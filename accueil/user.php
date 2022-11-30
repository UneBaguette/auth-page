<?php

if (isset($_COOKIE)) {
    print_r($_COOKIE);
    if (isset($_COOKIE['auth'])){
        print_r($_COOKIE['auth']);
    }
} else {
    echo "nothing";
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
                    <a href="index.php">Se déconnecter</a>
                </li>
            </ul>
        </nav>
    </header>
    <h1>
        SALUT TOI!
    </h1>
</body>
</html>