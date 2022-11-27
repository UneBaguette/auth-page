<?php

if (isset($_COOKIE['auth'])){
    header("Location: user.php");
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <?php $title = "Site Principale";include('../base/head/head.php'); ?>
</head>
<body>
    <header>
        <nav>
            <ul>
                <li>
                    <a href="/auth/login.php">Se connecter</a>
                </li>
                <!-- No peasant allowed -->
                <!-- <li>
                    <a href="/auth/register.php">S'inscrire</a>
                </li> -->
            </ul>
        </nav>
    </header>
    <h1>
        Bienvenue paysan.
    </h1>
    <div class="video-container">
        <video autoplay width="500" loop >
            <source src="https://thumbs.gfycat.com/CalmEnlightenedAuklet-mobile.mp4" type="video/mp4"/>
        </video>
    </div>
</body>
</html>