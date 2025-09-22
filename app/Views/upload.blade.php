@extends("layouts.app")

@section("title", "Upload des fichiers")

@section("content")
    <h1>Upload Profile Picture</h1>
    @if (!empty($errors))
        <ul style="color:red;">
            @foreach ($errors as $fieldErrors)
                @foreach ($fieldErrors as $error)
                    <li>{{ $error }}</li> <br>
                @endforeach
            @endforeach
        </ul>
    @endif
    @if($fileName)
        <p>Fichier telecharge avec succes!</p>
        <img src="{{ BASE_PATH . '/uploads/' . $fileName }}" alt="Profile Picture" width="150">
    @else
        <form method="POST" id="uploadForm" enctype="multipart/form-data">
            <label for="fileInput">Choisissez un fichier</label>
            <input type="file" name="avatar" id="fileInput" required>
            <br>
            <progress id="progressBar" value="0" max="100"></progress>
            <p id="status"></p>
            <br>
            <button type="submit">Upload</button>
        </form>
    @endif
@endsection

@section("scripts")
    <script src="{{ asset('assets/js/upload.js')}}"></script>
@endsection