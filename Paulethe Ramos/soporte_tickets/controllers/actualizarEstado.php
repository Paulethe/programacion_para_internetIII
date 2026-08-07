<?php
require_once "../includes/session.php";
require_once "../config/db.php";

if ($_SESSION["rol"] != "tecnico") {
    header("Location: listarTickets.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $estado = $_POST["estado"];

    $stmt = $conn->prepare("UPDATE tickets SET estado = ? WHERE id = ?");
    $stmt->bind_param("si", $estado, $id);
    $stmt->execute();
}

header("Location: listarTickets.php");
exit();
?>