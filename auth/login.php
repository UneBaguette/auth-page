<?php


if (isset($_POST["mail"]) && isset($_POST["pass"])){
    $email = $_POST['mail'];
    $pass = $_POST['pass'];
    require ("../app/DB.php");
    try {
        // 30 Days epxires
        //$timeout = 86400 * 30;
        // 20 seconds expires
        $timeout = 120;
        $db = new DB("auth_site");
        if($db->login($email, $pass)){
            ini_set("session.gc_maxlifetime", $timeout);
            ini_set("session.cookie_lifetime", $timeout);
            session_start();
            $s_name = session_name('auth');
            if (isset($_COOKIE['auth'])){
                setcookie($s_name, $_COOKIE[$s_name], time() + $timeout, "/");
            };
            $sucess = true;
        } else {
            $error = true;
        };
    }
    catch (PDOException $e){
        echo $e->getMessage();
    }
}

require("../app/Form.php"); 

$form = new Form(); 


?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <?php $title = "Connection"; include('../base/head/head-form.php'); ?>
</head>
<body>
    <form action="" method="POST">
        <h1>Connection au site</h1>
        <?php
        echo $form->input("Email", "mail", "email");
        echo $form->input("Mot de passe", "pass", "password")
        ;?>
        <button class="submit" type="submit">Se connecter</button>
        <?php if (!empty($sucess)) echo "<p class='sucess'><span>Succès</span></p>";?>
        <?php if (!empty($error)) echo "<p class='error'><span>Mauvais identifiant !</span></p>";?>
    </form>
</body>
</html>