<?php
session_start();
$type = ($_SESSION['type'] ?? "");
if ($type === 'admin'){
    header("Location: ../accueil/admin");
} elseif ($type === 'user') {
    header("Location: ../accueil/user");
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
        <?php if (!empty($sucess)) echo "<p class='sucess'><span>Succès</span></p>";?>
        <?php if (!empty($error)) echo "<p class='error'><span>Mauvais identifiant !</span></p>";?>
    </form>
    <script>

        const form = document.querySelector('form');

        form.addEventListener("submit", (e) => {

        });

    </script>
</body>
</html>