<!-- Page header -->
<div class="full-box page-header">
    <h3 class="text-left">
        <i class="fas fa-clipboard-list fa-fw"></i> &nbsp; SERVICIOS
    </h3>
    <p class="text-justify">
        Consulta los servicios disponibles
    </p>
</div>

<div class="container-fluid">
    <ul class="full-box list-unstyled page-nav-tabs">
        <?php if($_SESSION['privilegio_mdirectory'] == 1 || $_SESSION['privilegio_mdirectory'] == 3 || $_SESSION['privilegio_mdirectory'] == 4){ ?>
        <li>
            <a href="<?php echo SERVERURL; ?>service-new/"><i class="fas fa-plus fa-fw"></i> &nbsp; AGREGAR SERVICIO</a>
        </li>
        <?php } ?>
        <li>
            <a class="active" href="<?php echo SERVERURL; ?>service-list/"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; SERVICIOS</a>
        </li>
    </ul>	
</div>

<div class="container-fluid">
    <?php 
        require_once "./controladores/servicioControlador.php";

        $ins_servicio = new servicioControlador();
        echo $ins_servicio->paginador_servicios_controlador($pagina[1], 5, $_SESSION['privilegio_mdirectory'], $pagina[1], $pagina[0], '');
    ?>
</div>