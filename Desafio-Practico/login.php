<?php 

require 'conexion.php';

$message = "";

if (!empty($_POST['email']) && (!empty($_POST['password']))) {
    $records = $conn->prepare('SELECT IdUsuario, Usuario, email, password FROM usuarios WHERE email=:email');
    $records->bindParam(':email', $_POST['email']);
    $records->execute();
    $results = $records->fetch(PDO::FETCH_ASSOC);

    if (is_array($results) && count($results) > 0 && hash('sha512', $_POST['password']) == $results['password']) {
      session_start();
      $_SESSION['IdUsuario'] = $results['IdUsuario']; 
      echo "<p>Iniciado sesión correctamente ". $_SESSION['IdUsuario']. "</p> " ;
    } else {
      $message = "Datos incorrectos";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Formulario de inicio de sesión</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
  <style>
    body {
      background-color: #f8f9fa;
    }
    .form-signin {
      width: 100%;
      max-width: 400px;
      padding: 15px;
      margin: auto;
    }
    .form-signin .form-control {
      position: relative;
      box-sizing: border-box;
      height: auto;
      padding: 10px;
      font-size: 16px;
    }
    .form-signin input[type="email"] {
      margin-bottom: -1px;
      border-bottom-right-radius: 0;
      border-bottom-left-radius: 0;
    }
    .form-signin input[type="password"] {
      margin-bottom: 10px;
      border-top-left-radius: 0;
      border-top-right-radius: 0;
    }
    .form-signin h3 {
      margin-bottom: 15px;
      text-align: center;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="row">
      <div class="col-md-6 offset-md-3 mt-5">
        <form method="POST" action="" class="form-signin">
          <h3>Iniciar sesión</h3>
          <?php if (!empty($message)): ?>
            <div class="alert alert-danger"><?= $message ?></div>
          <?php endif; ?>
          <div class="form-group">
            <label for="email">Correo electrónico</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Ingresa tu correo electrónico" required>
          </div>
          <div class="form-group">
            <label for="password">Contraseña</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Ingresa tu contraseña" required>
          </div>
          <button type="submit" class="btn btn-lg btn-primary btn-block">Iniciar sesión</button>
        </form>
      </div>
    </div>
  </div>
</body>
</html>
