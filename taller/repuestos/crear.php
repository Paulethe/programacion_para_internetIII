<?php

require '../conexion.php';
$pdo = conectar();


$categorias = $pdo->query("SELECT * FROM categorias_repuesto WHERE activo = 1")->fetchAll(PDO::FETCH_ASSOC);

$errores = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

   
    $codigo  = trim($_POST['codigo_pieza'] ?? '');
    $nombre  = trim($_POST['nombre'] ?? '');
    $id_cat  = $_POST['id_categoria'] ?? '';
    $stock   = $_POST['stock'] ?? '';
    $precio  = $_POST['precio'] ?? '';

    if ($codigo === '')          $errores[] = "El código de pieza es obligatorio.";
    if ($nombre === '')          $errores[] = "El nombre es obligatorio.";
    if (!is_numeric($id_cat))   $errores[] = "Selecciona una categoría válida.";
    if (!ctype_digit((string)$stock) || $stock < 0)
                                 $errores[] = "El stock debe ser un número entero positivo.";
    if (!is_numeric($precio) || $precio <= 0)
                                 $errores[] = "El precio debe ser un número mayor a 0.";


    if (empty($errores)) {
        try {
            $stmt = $pdo->prepare("
                INSERT INTO repuestos (codigo_pieza, nombre, id_categoria, stock, precio)
                VALUES (:codigo, :nombre, :id_cat, :stock, :precio)
            ");
            $stmt->execute([
                ':codigo'  => $codigo,
                ':nombre'  => $nombre,
                ':id_cat'  => (int)$id_cat,
                ':stock'   => (int)$stock,
                ':precio'  => (float)$precio,
            ]);
            header("Location: ../index.php?msg=Repuesto creado correctamente");
            exit;
        } catch (PDOException $e) {
            $errores[] = "Error al guardar: " . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nuevo Repuesto</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="p-4">
<div class="container" style="max-width:600px">
    <h2 class="mb-3"> Nuevo Repuesto</h2>

    
    <?php if (!empty($errores)): ?>
        <div class="alert alert-danger">
            <ul class="mb-0">
                <?php foreach ($errores as $e): ?>
                    <li><?= htmlspecialchars($e) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Código de Pieza</label>
            <input type="text" name="codigo_pieza" class="form-control"
                   value="<?= htmlspecialchars($_POST['codigo_pieza'] ?? '') ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Nombre</label>
            <input type="text" name="nombre" class="form-control"
                   value="<?= htmlspecialchars($_POST['nombre'] ?? '') ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Categoría</label>
            <!-- Select cargado dinámicamente desde la BD -->
            <select name="id_categoria" class="form-select">
                <option value="">-- Selecciona --</option>
                <?php foreach ($categorias as $cat): ?>
                    <option value="<?= $cat['id'] ?>"
                        <?= ($_POST['id_categoria'] ?? '') == $cat['id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($cat['nombre_categoria']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Stock</label>
            <input type="number" name="stock" class="form-control" min="0"
                   value="<?= htmlspecialchars($_POST['stock'] ?? '0') ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Precio (L.)</label>
            <input type="number" step="0.01" name="precio" class="form-control" min="0"
                   value="<?= htmlspecialchars($_POST['precio'] ?? '') ?>">
        </div>
        <button type="submit" class="btn btn-success">Guardar</button>
        <a href="../index.php" class="btn btn-secondary ms-2">Cancelar</a>
    </form>
</div>
</body>
</html>
