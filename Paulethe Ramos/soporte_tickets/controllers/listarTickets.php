<?php
require_once "../includes/session.php";
require_once "../config/db.php";

$rol = $_SESSION["rol"];

if ($rol == "usuario") {
    $id_usuario = $_SESSION["id"];
    $stmt = $conn->prepare("SELECT * FROM tickets WHERE id_usuario = ? ORDER BY fecha_creacion DESC");
    $stmt->bind_param("i", $id_usuario);
    $stmt->execute();
    $resultado = $stmt->get_result();
} else {
    $sql = "SELECT tickets.*, usuarios.nombre AS nombre_usuario 
            FROM tickets 
            INNER JOIN usuarios ON tickets.id_usuario = usuarios.id 
            ORDER BY fecha_creacion DESC";
    $resultado = $conn->query($sql);
}
?>
<?php include "../includes/header.php"; ?>

<?php include "../includes/navbar.php"; ?>

<div class="contenedor-tabla">
    <h2>Listado de Tickets</h2>

    <table>
        <tr>
            <?php if ($rol == "tecnico") { ?>
                <th>Usuario</th>
            <?php } ?>
            <th>Título</th>
            <th>Departamento</th>
            <th>Prioridad</th>
            <th>Estado</th>
            <th>Fecha</th>
            <?php if ($rol == "tecnico") { ?>
                <th>Acción</th>
            <?php } ?>
        </tr>

        <?php while ($ticket = $resultado->fetch_assoc()) { ?>
            <tr class="prioridad-<?php echo strtolower($ticket['prioridad']); ?>">
                <?php if ($rol == "tecnico") { ?>
                    <td><?php echo $ticket["nombre_usuario"]; ?></td>
                <?php } ?>
                <td><?php echo $ticket["titulo"]; ?></td>
                <td><?php echo $ticket["departamento"]; ?></td>
                <td><?php echo $ticket["prioridad"]; ?></td>
                <td>
                    <span class="badge badge-<?php echo strtolower(str_replace(" ", "-", $ticket['estado'])); ?>">
                        <?php echo $ticket["estado"]; ?>
                    </span>
                </td>
                <td><?php echo $ticket["fecha_creacion"]; ?></td>

                <?php if ($rol == "tecnico") { ?>
                    <td>
                        <form method="POST" action="actualizarEstado.php">
                            <input type="hidden" name="id" value="<?php echo $ticket['id']; ?>">
                            <select name="estado">
                                <option value="Pendiente" <?php if($ticket['estado']=='Pendiente') echo 'selected'; ?>>Pendiente</option>
                                <option value="En Proceso" <?php if($ticket['estado']=='En Proceso') echo 'selected'; ?>>En Proceso</option>
                                <option value="Resuelto" <?php if($ticket['estado']=='Resuelto') echo 'selected'; ?>>Resuelto</option>
                            </select>
                            <button type="submit">Cambiar</button>
                        </form>
                    </td>
                <?php } ?>
            </tr>
        <?php } ?>
    </table>
</div>

<?php include "../includes/footer.php"; ?>