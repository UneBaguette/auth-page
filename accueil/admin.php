<?php if(!isset($_COOKIE['auth'])){ http_response_code(403); die("You don't have the right to view this page !");}  ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <?php $title = "Panneau administrateur";include('../base/head/head.php'); ?>
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
        SALUT PATRON
    </h1>

    
</body>
</html>