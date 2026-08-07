<div class="menu">
    <span>Bienvenido, <?php echo $_SESSION["nombre"]; ?> (<?php echo $_SESSION["rol"]; ?>)</span>

    <?php if ($_SESSION["rol"] == "usuario") { ?>
        <a href="registrarTicket.php">Nuevo Ticket</a>
    <?php } ?>

    <a href="listarTickets.php">Ver Tickets</a>
    <a href="logout.php">Cerrar sesión</a>
</div>