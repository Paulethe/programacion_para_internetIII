<?php
require_once "../includes/session.php";
require_once "../config/db.php";

if ($_SESSION["rol"] != "usuario") {
    header("Location: listarTickets.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = $_POST["titulo"];
    $descripcion = $_POST["descripcion"];
    $departamento = $_POST["departamento"];
    $prioridad = $_POST["prioridad"];
    $id_usuario = $_SESSION["id"];

    $stmt = $conn->prepare("INSERT INTO tickets (id_usuario, titulo, descripcion, departamento, prioridad) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("issss", $id_usuario, $titulo, $descripcion, $departamento, $prioridad);
    $stmt->execute();

    header("Location: listarTickets.php");
    exit();
}
?>
<?php include "../includes/header.php"; ?>

<?php include "../includes/navbar.php"; ?>

<div class="contenedor-form">
    <h2>Registrar nuevo ticket</h2>

    <form id="formTicket" method="POST" action="registrarTicket.php">
        <label>Título:</label>
        <input type="text" name="titulo" id="titulo">

        <label>Descripción:</label>
        <textarea name="descripcion" id="descripcion"></textarea>

        <label>Departamento:</label>
        <input type="text" name="departamento" id="departamento">

        <label>Prioridad:</label>
        <select name="prioridad" id="prioridad">
            <option value="Baja">Baja</option>
            <option value="Media">Media</option>
            <option value="Alta">Alta</option>
        </select>

        <button type="submit">Guardar Ticket</button>
    </form>
</div>

<script src="../assets/js/validaciones.js"></script>

<?php include "../includes/footer.php"; ?> 