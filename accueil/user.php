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



//echo $_COOKIE['auth'] ?? "";

// if(!isset($_COOKIE['auth'])) { 
//     http_response_code(403);
//     die("You don't have the right to view this page !");
// }

// session_write_close();

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <?php $title = "Panneau utilisateur"; include('../base/head/head.php'); ?>
</head>
<body>
    <header>
        <nav>
            <ul>
                <li>
                    <a href="../auth/logout">Se déconnecter</a>
                </li>
            </ul>
        </nav>
    </header>
    <h1>
        SALUT TOI!
    </h1>
</body>
</html>