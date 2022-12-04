<?php
if (session_id() == '' || !isset($_SESSION) || session_status() === PHP_SESSION_NONE){
    session_start();
}

$root = dirname(dirname(__DIR__));

require_once($root . "/app/DB.php");

$db = new DB();

$db->onExpired();

?>
<header>
    <nav>
        <ul>
            <li>
                <?php

                if (!str_contains($_SERVER['PHP_SELF'], "accueil/index")){
                    echo "<a href='../../accueil'>Accueil</a>";
                }
                
                ?>
            </li>
            <?php 
            if ($db->isLoggedIn()){
                if ($_SESSION['type'] === 'admin'){
                    if (!str_contains($_SERVER['PHP_SELF'], "accueil/admin")){
                        echo "<li>
                            <a href='/accueil/admin'>Page d'administration</a>
                        </li>";
                    }
                    if (!str_contains($_SERVER['PHP_SELF'], "accueil/user")){
                        echo "<li>
                                <a href='/accueil/user'>Page d'utilisateur</a>
                            </li>";
                    }
                    echo "
                        <li class='disconnect'>
                            <a href='/auth/logout'>Se déconnecter</a>
                        </li>";

                } elseif ($_SESSION['type'] === 'user'){
                    if (!str_contains($_SERVER['PHP_SELF'], "accueil/user")){
                        echo "<li>
                                <a href='/accueil/user'>Page d'utilisateur</a>
                            </li>";
                    }
                    echo "
                        <li class='disconnect'>
                            <a href='/auth/logout'>Se déconnecter</a>
                        </li>";
                } else {
                    echo "<li class='disconnect'>
                            <a href='/auth/logout'>Se déconnecter</a>
                        </li>";
                }
            } else
                echo "<li><a href='/auth/login.php'>Se connecter</a></li>";
            
            ?>
        </ul>
    </nav>
</header>