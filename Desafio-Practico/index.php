<?php

session_start();
require('conexion.php');
if(isset($_SESSION['IdUsuario'])){
    $records= $conn->prepare('SELECT IdUsuario, usuario, correo, contrasena FROM usuarios IdUsuarios =:Id');
    $records->bindParam(';Id', $_SESSION['IdUsuarios']);
    $records->execute();
    $results= $records->fetch(PDO::FETCH_ASSOC);
    $user= null;
    if (count($results) > 0 ){
        $user = $results;
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php if(!empty($user)): ?>
        <br>welcome. <?= $user['email'] ?>
        <?php endif ?>
</body>
</html>