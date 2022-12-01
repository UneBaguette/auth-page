<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: X-Requested-With');
header("Content-Type: application/json");

$root = dirname(dirname(dirname(__FILE__)));

include_once($root . "/app/DB.php");

$db = new DB();

$api = $_SERVER['REQUEST_METHOD'];

if ($api === 'GET'){
    $datas = $db->fetch();
    echo json_encode($datas);
}