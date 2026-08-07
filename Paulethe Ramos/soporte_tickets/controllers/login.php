<?php
session_start();
require_once "../config/db.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows == 1) {
        $usuario = $resultado->fetch_assoc();

        if (password_verify($password, $usuario["password"])) {
            $_SESSION["id"] = $usuario["id"];
            $_SESSION["nombre"] = $usuario["nombre"];
            $_SESSION["rol"] = $usuario["rol"];
            header("Location: listarTickets.php");
            exit();
        } else {
            $error = "Contraseña incorrecta";
        }
    } else {
        $error = "El usuario no existe";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar sesión</title>
    <link rel="stylesheet" href="../assets/css/estilos.css">
</head>
<body>
    <div class="contenedor-login">
        <h2>Sistema de Soporte Técnico</h2>

        <?php if ($error != "") { ?>
            <p class="mensaje-error"><?php echo $error; ?></p>
        <?php } ?>

       <form method="POST" action="login.php">
            <label>Correo:</label>
            <input type="email" name="email" required>

            <label>Contraseña:</label>
            <input type="password" name="password" required>

            <button type="submit">Ingresar</button>
        </form>

        <div class="DatosPrueba">
            <h3>Usuarios de prueba</h3>
            <p><strong>Usuario:</strong> juan@correo.com / 123456</p>
            <p><strong>Técnico:</strong> carlos@correo.com / 123456</p>
        </div>
    </div>
</body>
</html>