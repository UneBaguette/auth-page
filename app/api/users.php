<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: X-Requested-With');
header("Content-Type: application/json");

include_once("../DB.php");

$db = new DB();

$api = $_SERVER['REQUEST_METHOD'];
$id = (int)($_GET['id'] ?? 0);

if ($api === 'GET'){
    if ($id !== 0){
        $datas = $db->fetch($id);
    } else {
        $datas = $db->fetch();
    }
    echo json_encode($datas);
}

if ($api == 'POST') {
    if (isset($_POST["mail"]) && isset($_POST["pass"]) && isset($_POST["passverif"])) {
        $email = $_POST["mail"];
        $pass = $_POST["pass"];
        $passverif = $_POST["passverif"];
        try {
            if ($pass === $passverif) {
                $hashpwd = password_hash($pass, PASSWORD_BCRYPT);
                if ($db->register($email, $hashpwd)){
                    echo $db->message('User added successfully!',false);
                } else {
                    echo $db->message('Failed to add an user!',true);
                }
            } else {
                echo $db->message('First password and second password are not the same!',true);
            }
        }
        catch (PDOException $e){
            echo json_encode($e->getMessage());
        }
    } else {
        echo $db->message('Missing input!',true);
    }
}

if ($api == 'DELETE') {
    if ($id != null) {
        if ($db->delete($id)) {
            echo $db->message('User deleted successfully!', false);
        } else {
            echo $db->message('Failed to delete the user!', true);
        }
    } else {
        echo $db->message('User was not found!', true);
    }
}