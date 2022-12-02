<?php
session_start();

$type = ($_SESSION['type'] ?? "");

if (!isset($_SESSION['auth']) && !isset($_SESSION['type'])){
    http_response_code(403);
    die("You don't have the right to view this page!");
}
if ($type === 'admin'){
    header("Location: admin");
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <?php $title = "Panneau utilisateur"; include('../base/head/head.php'); ?>
</head>
<body>
    <?php include("../base/body/header.php"); ?>
    <h1>
        SALUT TOI!
    </h1>
</body>
</html>