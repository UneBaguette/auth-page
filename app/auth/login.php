<?php
if (isset($_POST['mail']) && isset($_POST['pass'])) {
    $mail = $_POST['mail'];
    $pass = $_POST['pass'];
    require ("../DB.php");
    require("../App.php");
    try {
        session_start();
        $db = new DB();
        if ($db->login($mail, $pass)){
            $type = $db->getTypeOfUser($mail, $pass);
            $s_name = session_name();
            $id = uniqid();
            setcookie($s_name, '', time() + $lifetime);
            $_SESSION['type'] = $type;
            $_SESSION['auth'] = $id;
            $_SESSION['created'] = time();
            if ($type === 'admin'){
                App::redirect("/accueil/admin");
            } elseif ($type === 'user'){
                App::redirect("/accueil/user");
            } else {
                App::redirect("/accueil");
            }
            # exit on success
            exit();
        } else {
            die("Couldn't connect!");
        };
    }
    catch (PDOException $e){
        echo $e->getMessage();
    }
} 

header("Location: ../../accueil");
exit("Missing inputs");