<?php

require 'conexion.php';
$pdo = conectar();

$msg   = $_GET['msg']   ?? '';
$error = $_GET['error'] ?? '';


if (isset($_GET['hard_delete'])) {
    $id = filter_input(INPUT_GET, 'hard_delete', FILTER_VALIDATE_INT);

    if ($id) {
        try {
            
            $check = $pdo->prepare("SELECT stock FROM repuestos WHERE id = :id");
            $check->execute([':id' => $id]);
            $rep = $check->fetch(PDO::FETCH_ASSOC);

            if ($rep && $rep['stock'] == 0) {
                $stmt = $pdo->prepare("DELETE FROM repuestos WHERE id = :id");
                $stmt->execute([':id' => $id]);
                header("Location: admin.php?msg=Repuesto eliminado definitivamente");
            } else {
                header("Location: admin.php?error=Solo se puede eliminar si el stock es 0");
            }
        } catch (PDOException $e) {
            header("Location: admin.php?error=" . urlencode($e->getMessage()));
        }
        exit;
    }
}


$stmt = $pdo->query("
    SELECT r.*, c.nombre_categoria
    FROM repuestos r
    INNER JOIN categorias_repuesto c ON r.id_categoria = c.id
    ORDER BY r.estado_activo DESC, r.id DESC
");
$repuestos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Admin - Hard Delete</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="p-4">
<div class="container">
    <h2 class="mb-3 text-danger">Panel Administrativo — Todos los Repuestos</h2>
    <p class="text-muted">Aquí aparecen activos e inactivos.</p>

    <?php if ($msg): ?>
        <div class="alert alert-success"><?= htmlspecialchars($msg) ?></div>
    <?php endif; ?>
    <?php if ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <a href="index.php" class="btn btn-secondary mb-3">← Volver</a>

    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Código</th>
                <th>Nombre</th>
                <th>Categoría</th>
                <th>Stock</th>
                <th>Estado</th>
                <th>Eliminar</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($repuestos as $r): ?>
                <tr class="<?= $r['stock'] < 5 ? 'table-warning' : '' ?> <?= !$r['estado_activo'] ? 'table-secondary' : '' ?>">
                    <td><?= $r['id'] ?></td>
                    <td><?= htmlspecialchars($r['codigo_pieza']) ?></td>
                    <td><?= htmlspecialchars($r['nombre']) ?></td>
                    <td><?= htmlspecialchars($r['nombre_categoria']) ?></td>
                    <td><?= $r['stock'] ?></td>
                    <td>
                        <?php if ($r['estado_activo']): ?>
                            <span class="badge bg-success">Activo</span>
                        <?php else: ?>
                            <span class="badge bg-secondary">Inactivo</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if ($r['stock'] == 0): ?>
                          
                            <a href="admin.php?hard_delete=<?= $r['id'] ?>"
                               class="btn btn-sm btn-danger"
                               onclick="return confirm('Esta acción no se puede deshacer. ¿Continuar?')">
                               Eliminar
                            </a>
                        <?php else: ?>
                            <span class="text-muted small">Stock > 0, no eliminable</span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>
