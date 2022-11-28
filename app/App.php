<?php

class App {

    public static function redirect($uri){
        header("Location: " . $uri);
        exit();
    }

}