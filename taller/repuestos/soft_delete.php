<?php
require '../conexion.php';
$pdo = conectar();

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) {
    header("Location: ../index.php?error=ID inválido");
    exit;
}

try {
    $stmt = $pdo->prepare("UPDATE repuestos SET estado_activo = 0 WHERE id = :id");
    $stmt->execute([':id' => $id]);
    header("Location: ../index.php?msg=Pieza desactivada por obsolescencia");
} catch (PDOException $e) {
    header("Location: ../index.php?error=" . urlencode($e->getMessage()));
}
exit;
