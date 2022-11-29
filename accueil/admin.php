<?php 



if(!isset($_COOKIE['auth'])){ 
    http_response_code(403); 
    die("You don't have the right to view this page !");
}

require ("../app/DB.php");
$db = new DB("auth_site");

$users = $db->getRegisteredUsers();


?>
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

    <table>
        <thead>
            <tr><th>Email</th><th>Type</th></tr>
        </thead>
        <tbody>
            <?php foreach($users as $v): ?>
                <tr>
                    <?php echo "<td>". $v["email"] ."</td><td>". $v["type"] ."</td>" ?>
                </tr>

            <?php endforeach; ?>
        </tbody>
    </table>

    
</body>
</html>