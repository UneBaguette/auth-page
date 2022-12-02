<?php
session_start();

if (isset($_POST['mail']) && isset($_POST['pass'])) {
    $mail = $_POST['mail'];
    $pass = $_POST['pass'];
    require ("../DB.php");
    try {
        $db = new DB();
        if ($db->login($mail, $pass)){
            $lifetime = 20;
            ini_set("session.gc_maxlifetime", $lifetime);
            ini_set("session.cookie_lifetime", $lifetime);
            $type = $db->getTypeOfUser($mail, $pass);
            $s_name = session_name();
            $id = uniqid();
            setcookie($s_name, '', time() + $lifetime);
            $_SESSION['type'] = $type;
            $_SESSION['auth'] = $id;
            if ($type === 'admin'){
                header("Location: ../../accueil/admin.php");
                exit;
            } elseif ($type === 'user'){
                header("Location: ../../accueil/user.php");
                exit;
            } else {
                header("Location: ../../accueil");
                exit;
            }
        } else {
            header("Location: ../../accueil");
            exit("Couldn't connect!");
        };
    }
    catch (PDOException $e){
        echo $e->getMessage();
    }
} 

header("Location: ../../accueil");
exit("Missing inputs");