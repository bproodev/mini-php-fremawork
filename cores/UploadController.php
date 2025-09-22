<?php

namespace Core;

class UploadController {

    protected string $uploadDir = __DIR__. "/../public/uploads/";

    public function __construct(){
        if(!is_dir($this->uploadDir)){
            mkdir($this->uploadDir, 0777, true);
        }
    }

    public function upload(array $rules, string $inputName): ?string{
        $validator = new Validator($_FILES, $rules);
        if($validator->fails()){
            throw new \Exception(json_decode($validator->errors()));
        }

        $fileTmp = $_FILES[$inputName]['tmp_name'];
        $fileName = basename($_FILES[$inputName]["name"]);
        $ext      = pathinfo($fileName, PATHINFO_EXTENSION);
        $newName = uniqid("file_", true). ".".$ext;
        $destination = $this->uploadDir.$newName;

        if(move_uploaded_file($fileTmp, $destination)){
            return $newName;
        }
        return null;
    }

    public function uploadChunk(
        string $inputName,
        string $identifier,
        int $chunkIndex,
        int $totalChunks,
        string $originalName
    ): ?string {
        $tmpDir = $this->uploadDir."chunk/".$identifier."/";
        if(!is_dir($tmpDir)){
            mkdir($tmpDir, 0777, true);
        }

        $chunkFiles = $tmpDir.$chunkIndex;
        if(!move_uploaded_file($_FILES[$inputName]["tmp_name"], $chunkFiles)){
            error_log("Error uploading chunk $chunkIndex");
            return null;
        }
        
        // Default name if not provided
        if($this->allChunksUploaded($tmpDir, $totalChunks)){
            $originalFileName = $originalName;
            $fileName = basename($originalFileName); // Use the original file name here
            $ext = pathinfo($fileName, PATHINFO_EXTENSION);
            $fileName = uniqid("file_", true) . '.' . $ext; // Add the extension back to the unique ID
            $filePath = $this->uploadDir . $fileName; // Use the full file name now
            $out = fopen($filePath, 'wb');
            for($i=0; $i<$totalChunks; $i++){
                $in = fopen($tmpDir.$i, "rb");
                stream_copy_to_stream($in, $out);
                fclose($in);
            }
            fclose($out);

            array_map('unlink', glob($tmpDir."*"));
            rmdir($tmpDir);

            return $fileName;
        }
        return null;
    }

    private function allChunksUploaded(string $tmpDir, int $totalChunks): bool {
        for ($i = 0; $i < $totalChunks; $i++) {
            if (!file_exists($tmpDir.$i)) {
                return false; // un chunk manque → pas encore prêt
            }
        }
        return true; // tous les chunks sont là
    }

}