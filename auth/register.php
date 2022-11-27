<?php if (!isset($_COOKIE['auth'])) {http_response_code(403); die("You should not have access to this page!");} include ("../app/Form.php"); $form = new Form(); ?>
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
        
        ?>
        <button type="submit">S'inscrire</button>
    </form>
</body>
</html>