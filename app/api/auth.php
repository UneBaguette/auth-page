<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Headers: *');
header("Content-Type: application/json;");

# test

include_once("../DB.php");

$db = new DB();

$api = $_SERVER['REQUEST_METHOD'];
$id = (int)($_GET['id'] ?? 0);


if ($api == "GET"){
    if (isset($_GET['mail']) && isset($_GET['pass'])){

    } else {
        echo $db->message("Missing get parameter", true);
    }
    echo $db->message("Error", true);
}

if ($api == "POST"){
    echo $db->message("Error", true);
}