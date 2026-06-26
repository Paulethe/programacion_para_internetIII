<?php

require 'conexion.php';
$pdo = conectar();


$stmt = $pdo->query("
    SELECT r.*, c.nombre_categoria
    FROM repuestos r
    INNER JOIN categorias_repuesto c ON r.id_categoria = c.id
    WHERE r.estado_activo = 1
    ORDER BY r.id DESC
");
$repuestos = $stmt->fetchAll(PDO::FETCH_ASSOC);


$msg   = $_GET['msg']   ?? '';
$error = $_GET['error'] ?? '';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Taller - Repuestos</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="p-4">

<div class="container">
    <h2 class="mb-3"> Repuestos del Taller</h2>

   
    <?php if ($msg): ?>
        <div class="alert alert-success"><?= htmlspecialchars($msg) ?></div>
    <?php endif; ?>
    <?php if ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <a href="repuestos/crear.php" class="btn btn-primary mb-3"> Nuevo Repuesto</a>
    <a href="admin.php" class="btn btn-danger mb-3 ms-2"> Administrar (Hard Delete)</a>

    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>Código</th>
                <th>Nombre</th>
                <th>Categoría</th>
                <th>Stock</th>
                <th>Precio</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($repuestos as $r): ?>
               
                <tr class="<?= $r['stock'] < 5 ? 'table-warning' : '' ?>">
                    <td><?= htmlspecialchars($r['codigo_pieza']) ?></td>
                    <td><?= htmlspecialchars($r['nombre']) ?></td>
                    <td><?= htmlspecialchars($r['nombre_categoria']) ?></td>
                    <td>
                        <?= $r['stock'] ?>
                        <?php if ($r['stock'] < 5): ?>
                            <span class="badge bg-warning text-dark">⚠ Bajo</span>
                        <?php endif; ?>
                    </td>
                    <td>L. <?= number_format($r['precio'], 2) ?></td>
                    <td>
                        <a href="repuestos/editar.php?id=<?= $r['id'] ?>" class="btn btn-sm btn-warning">Editar</a>
                  
                        <a href="repuestos/soft_delete.php?id=<?= $r['id'] ?>"
                           class="btn btn-sm btn-secondary"
                           onclick="return confirm('¿Desactivar esta pieza por obsolescencia?')">
                           Inactivar
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if (empty($repuestos)): ?>
                <tr><td colspan="6" class="text-center">No hay repuestos registrados.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

</body>
</html>
