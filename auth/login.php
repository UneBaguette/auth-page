<?php
session_start();
$type = ($_SESSION['type'] ?? "");
if (isset($_SESSION['auth'])){
    if ($type === 'admin'){
        header("Location: ../accueil/admin");
    } elseif ($type === 'user') {
        header("Location: ../accueil/user");
    } else {
        header("Location: ../accueil");
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
    <form action="/app/auth/login" method="POST">
        <h1>Connection au site</h1>
        <?php
        echo $form->input("Email", "mail", "email");
        echo $form->input("Mot de passe", "pass", "password");
        ?>
        <button class="submit" type="submit">Se connecter</button>
    </form>
</body>
</html>