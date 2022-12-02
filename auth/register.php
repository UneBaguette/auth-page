<?php
session_start();
$type = ($_SESSION['type'] ?? "");

if (!isset($_SESSION['auth']) && !isset($_SESSION['type'])){
    http_response_code(403);
    die("You don't have the right to view this page!");
}
if ($type !== 'admin'){
    http_response_code(403);
    die("You don't have the right to view this page!");
}

require ("../app/Form.php"); 
$form = new Form();

if (isset($_POST["mail"]) && isset($_POST["pass"]) && isset($_POST["passverif"])){
    $email = $_POST["mail"];
    $pass = $_POST["pass"];
    $passverif = $_POST["passverif"];
    require ("../app/DB.php");
    try {
        if ($pass === $passverif) {
            $db = new DB("auth_site");
            $hashpwd = password_hash($pass, PASSWORD_BCRYPT);
            if ($db->register($email, $hashpwd)){
                $sucess = true;
            } else {
                $error = true;
            }
        } else {
            $error = true;
        }
    }
    catch (PDOException $e){
        echo $e->getMessage();
    }
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <?php $title = "Inscription"; include('../base/head/head-form.php'); ?>
</head>
<body>
    <form action="" method="POST">
        <h1>Inscription au site</h1>
        <?php
        
        echo $form->input("Email", "mail", "email");
        echo $form->input("Mot de passe", "pass", "password");
        echo $form->input("Confirmation du mot de passe", "passverif", "password");
        
        ?>
        <button type="submit">S'inscrire</button>
        <?php

        if (!empty($sucess)) echo "<p class='sucess'><span>Succès</span></p>";
        if (!empty($error)) echo "<p class='error'><span>Mauvais identifiant !</span></p>";

        ?>
    </form>
</body>
</html>