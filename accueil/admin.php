<?php 
session_start();
$type = ($_SESSION['type'] ?? "");

if(!isset($_SESSION['auth']) && !isset($_SESSION['type'])){ 
    http_response_code(403);
    die("You don't have the right to view this page!");
}
if ($type === 'user'){
    header("Location: user");
}

require ("../app/DB.php");
$db = new DB();

$users = $db->getRegisteredUsers();


?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <?php $title = "Panneau administrateur";include('../base/head/head.php'); ?>
</head>
<body>
    <?php include("../base/body/header.php"); ?>
    <h1>
        SALUT PATRON
    </h1>

    <table border="1">
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