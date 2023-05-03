<?php
require 'conexion.php';

$message='';

if (!empty($_POST['user']) && !empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['confirm_password'])){

    // Verificar que las contraseñas coinciden
    if ($_POST['password'] === $_POST['confirm_password']) {

        // Verificar que el usuario y el correo electrónico no existan previamente
        $stmt = $conn->prepare("SELECT * FROM usuarios WHERE usuario=:user OR email=:email");
        $stmt->bindParam(':user', $_POST['user']);
        $stmt->bindParam(':email', $_POST['email']);
        $stmt->execute();

        if ($stmt->rowCount() == 0) {
            $sql = "INSERT INTO usuarios (usuario, email, password) VALUES (:user, :email, :password)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':user', $_POST['user']);
            $stmt->bindParam(':email', $_POST['email']);
            $password = hash('sha512',$_POST['password']); 
            $stmt->bindParam(':password', $password);

            if ($stmt->execute()){
                $message = 'Usuario creado exitosamente';
            } else {
                $message = 'Lo siento ha ocurrido un error creando su cuenta'; 
            }
        } else {
            $message = 'El usuario o el correo electrónico ya existen en la base de datos';
        }

    } else {
        $message = 'Las contraseñas no coinciden';
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Formulario de registro con Bootstrap</title>
  <!-- Agregamos los archivos CSS de Bootstrap -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <?php if(!empty($message)):?>
       <p><?= $message ?></p>
    <?php endif; ?>
  <div class="container mt-5">
    <div class="row">
      <div class="col-md-6 mx-auto">
        <div class="card">
          <div class="card-header">
            <h3 class="text-center">Formulario de registro</h3>
          </div>
          <div class="card-body">
            <form action="registro.php" method="POST">
              <div class="form-group">
                <label for="usuario">Usuario</label>
                <input type="text" name="user" id="nombre" class="form-control" placeholder="Ingresa tu nombre completo" required>
              </div>
              <div class="form-group">
                <label for="correo">Correo electrónico</label>
                <input type="email" name="email" id="correo" class="form-control" placeholder="Ingresa tu correo electrónico" required>
              </div>
              <div class="form-group">
                <label for="password">Contraseña</label>
                <input type="password" name="password" id="password" class="form-control" placeholder="Ingresa tu contraseña" required>
              </div>
              <div class="form-group">
                <label for="confirm_password">Confirmar contraseña</label>
                <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="Confirma tu contraseña" required>
              </div>
              <div class="form-group">
                <button type="submit" class="btn btn-primary btn-block">Registrarse</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Agregamos los archivos JS de Bootstrap -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.min.js"></script>
</body>
</html>