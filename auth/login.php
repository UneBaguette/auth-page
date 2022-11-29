<?php

if (isset($_POST["mail"]) && isset($_POST["pass"])){
    $email = $_POST['mail'];
    $pass = $_POST['pass'];
    require ("../app/DB.php");
    try {
        $db = new DB("auth_site");
        if($db->login($email, $pass)){
            $sucess = true;
        } else {
            $error = true;
        };
    }
    catch (PDOException $e){
        echo $e->getMessage();
    }
}



if (isset($_COOKIE["auth"])){

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