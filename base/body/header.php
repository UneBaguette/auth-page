<?php
session_start();

include_once("../app/DB.php");

$db = new DB();

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
            <li>
                <?php 
                if ($db->isLoggedIn()){
                    echo "<a href='../auth/logout'>Se déconnecter</a>";
                } else
                    echo "<a href='/auth/login.php'>Se connecter</a>";
                
                ?>
            </li>
        </ul>
    </nav>
</header>