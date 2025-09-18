<?php

if(!function_exists('view')){
    function view(string $view, array $data=[]): void{
        extract($data);

        $path = __DIR__. "/../app/Views/".str_replace(".", "/", $view).".php";

        if(file_exists($path)){
            require $path;
        }else{
            throw new Exception("La vue [$view] est introuvable");
        }
    }
}