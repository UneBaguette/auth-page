<?php 
session_start();

$type = ($_SESSION['type'] ?? "");

if (isset($_SESSION['auth']) && isset($_SESSION['type'])){
    if ($_SESSION['type'] !== 'admin') {
        http_response_code(403);
        die("You don't have the right to view this page!");
    }
} else {
    http_response_code(403);
    die("You don't have the right to view this page!");
}

require ("../../app/DB.php");
$db = new DB();

$users = $db->getRegisteredUsers();

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <?php $base = "../../base/"; $title = "Panneau administrateur";include($base . 'head/head.php'); ?>
</head>
<body>
    <?php include($base . "body/header.php"); ?>
    <h1>
        SALUT PATRON
    </h1>

    <table class="admin-table" border="1">
        <thead>
            <tr><th>Id</th><th>Email</th><th>Type</th><th>Modifier</th><th>Supprimer</th></tr>
        </thead>
        <tbody>
            <?php foreach($users as $v): ?>
                <tr>
                    <?php echo "<td>" . $v["id"] . "</td><td>" . $v["email"] . "</td><td>" . $v["type"] . "</td><td class='table-modify'>🖋️</td>";
                    
                    if ($v['type'] === 'admin') {
                        echo "<td style='text-align: center;' >ADMIN</td>";
                    } else {
                        echo "<td class='table-delete' data-id='" . $v["id"] . "'>🗑️</td>";
                    }; 
                    
                    ?>
                </tr>

            <?php endforeach; ?>
        </tbody>
    </table>
    <script>
            const trashs = document.querySelectorAll('.table-delete');

            trashs.forEach((trash, i) => {
                trash.addEventListener('dblclick', () => {
                    deleteById(trash.getAttribute("data-id"));
                })
            })

            async function deleteById(id){
                const res = await fetch("/app/api/users?id=" + id, {
                    method: 'DELETE'
                }).catch((e) => {
                    console.error(e);
                });

                const datas = await res.json();

                return datas['success'] = true ? deleteRow(id) : false;
            }

            function deleteRow(id){
                trashs.forEach((trash) => {
                    const parentElement = trash.parentNode;
                    if (trash.getAttribute('data-id') === id){
                        parentElement.remove();
                    }
                })
            }




    </script>

    
</body>
</html>