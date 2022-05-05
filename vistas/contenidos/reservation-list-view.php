<!-- Page header -->
<div class="full-box page-header">
    <h3 class="text-left">
        <i class="fas fa-clipboard-list fa-fw"></i> &nbsp; RESERVACIONES
    </h3>
    <p class="text-justify">
        Consulta las reservaciones que hay pendientes
    </p>
</div>

<div class="container-fluid">
    <ul class="full-box list-unstyled page-nav-tabs">
        <li>
            <a href="<?php echo SERVERURL; ?>service-list/"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; SERVICIOS</a>
        </li>
        <li>
            <a class="active" href="<?php echo SERVERURL; ?>reservation-list/"><i class="far fa-calendar-alt"></i> &nbsp; RESERVACIONES</a>
        </li>
    </ul>
</div>

    <div class="container-fluid">
        <?php
            require_once "./controladores/reservacionControlador.php";

            $ins_reservacion = new reservacionControlador();
            echo $ins_reservacion->paginador_reservaciones_controlador($pagina[1], 5, $_SESSION['privilegio_mdirectory'], $_SESSION['id_mdirectory'], $pagina[0], '');
        ?>
    </div>
