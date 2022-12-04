<?php
session_start();

$type = ($_SESSION['type'] ?? "");

if (!isset($_SESSION['auth']) && !isset($_SESSION['type'])){
    http_response_code(403);
    die("You don't have the right to view this page!");
} elseif (isset($_SESSION['auth']) && isset($_SESSION['type'])){
    if ($_SESSION['type'] !== 'user') {
        if ($_SESSION['type'] !== 'admin') {
            http_response_code(403);
            die("You don't have the right to view this page!");
        }
    }
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <?php $base = "../../base/"; $title = "Panneau utilisateur"; include($base . 'head/head.php'); ?>
</head>
<body>
    <?php include($base . "body/header.php"); ?>
    <h1>
        SALUT TOI!
    </h1>
    <div class="video-container">
        <img src="https://i.giphy.com/media/xTiIzJSKB4l7xTouE8/giphy.webp">
    </div>
</body>
</html>