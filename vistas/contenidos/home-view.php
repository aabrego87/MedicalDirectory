<?php
    require_once "./controladores/usuarioControlador.php";
    require_once "./controladores/doctorControlador.php";
    require_once "./controladores/clienteControlador.php";
    require_once "./controladores/servicioControlador.php";
    require_once "./controladores/reservacionControlador.php";

    $usuario = new usuarioControlador();
    $doctores = new doctorControlador();
    $clientes = new clienteControlador();
    $servicios = new servicioControlador();
    $reservaciones = new reservacionControlador();

    $total_usuarios = $usuario->datos_usuario_conrolador("Conteo", "");
    $total_doctores = $doctores->datos_doctor_controlador("Conteo", "");
    $total_clientes = $clientes->datos_cliente_controlador("Conteo", "");
    $total_servicios = $servicios->datos_servicio_controlador("Conteo", "");
    $total_reservaciones = $reservaciones->datos_reservaciones_controlador("Conteo", "");
?>
<!-- Page header -->
<div class="full-box page-header">
    <h3 class="text-left">
        <i class="fab fa-dashcube fa-fw"></i> &nbsp; DASHBOARD
    </h3>
    <p class="text-justify">
        Accede fácilmente a tus secciones más utiizadas
    </p>
</div>

<!-- Content -->

<div class="full-box tile-container">
    <?php if($_SESSION['privilegio_mdirectory'] == 1){ ?>
    <a href="<?php echo SERVERURL; ?>user-list/" class="tile">
        <div class="tile-tittle">Usuarios</div>
        <div class="tile-icon">
            <i class="fas fa-user fa-fw"></i>
            <p><?php echo $total_usuarios->rowCount(); ?> Registrados</p>
        </div>
    </a>
    <?php } ?>

    <?php if($_SESSION['privilegio_mdirectory'] == 1 || $_SESSION['privilegio_mdirectory'] == 2 || $_SESSION['privilegio_mdirectory'] == 3){ ?>
    
    
        <a href="<?php echo SERVERURL; ?>doctors-list/" class="tile">
            <div class="tile-tittle">Doctores</div>
            <div class="tile-icon">
                <i class="fas fa-clipboard-list fa-fw"></i>
                <p><?php echo $total_doctores->rowCount(); ?> Registrados</p>
            </div>
        </a>
    <?php } ?>

        <?php if($_SESSION['privilegio_mdirectory'] == 1 || $_SESSION['privilegio_mdirectory'] == 2 || $_SESSION['privilegio_mdirectory'] == 3 || $_SESSION['privilegio_mdirectory'] == 4){ ?>
        <a href="<?php echo SERVERURL; ?>client-list/" class="tile">
            <div class="tile-tittle">Pacientes</div>
            <div class="tile-icon">
                <i class="fa fa-users fa-fw"></i>
                <p><?php echo $total_clientes->rowCount(); ?> Registrados</p>
            </div>
        </a>
    <?php } ?>


    <a href="<?php echo SERVERURL; ?>service-list/" class="tile">
        <div class="tile-tittle">Servicios</div>
        <div class="tile-icon">
            <i class="fa fa-clipboard-list fa-fw"></i>
            <p><?php echo $total_servicios->rowCount(); ?> Registradas</p>
        </div>
    </a>
    
    <a href="<?php echo SERVERURL; ?>reservation-list/" class="tile">
        <div class="tile-tittle">Reservaciones</div>
        <div class="tile-icon">
            <i class="fas far fa-calendar-alt"></i>
            <p><?php echo $total_reservaciones->rowCount(); ?> Registrados</p>
        </div>
    </a>

    <a href="<?php echo SERVERURL; ?>company/" class="tile">
        <div class="tile-tittle">Compañía</div>
        <div class="tile-icon">
            <i class="fas fa-store fa-fw"></i>
            <p>200 Registrados</p>
        </div>
    </a>
</div>
