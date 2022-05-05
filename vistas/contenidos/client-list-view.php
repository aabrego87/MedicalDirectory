<!-- Page header -->
<div class="full-box page-header">
    <h3 class="text-left">
        <i class="fas fa-clipboard-list fa-fw"></i> &nbsp; LISTA DE PACIENTES
    </h3>
    <p class="text-justify">
        Da un vistazo a tu lista de pacientes
    </p>
</div>

<div class="container-fluid">
    <ul class="full-box list-unstyled page-nav-tabs">
        <?php if($_SESSION['privilegio_mdirectory'] == 1 || $_SESSION['privilegio_mdirectory']==3){ ?>
        <li>
            <a href="<?php echo SERVERURL; ?>client-new/"><i class="fas fa-plus fa-fw"></i> &nbsp; AGREGAR PACIENTE</a>
        </li>
        <?php } ?>
        <li>
            <a class="active" href="<?php echo SERVERURL; ?>client-list/"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; PACIENTES</a>
        </li>
    </ul>	
</div>

<!-- Content here-->
<div class="container-fluid">
    <?php
        require_once "./controladores/clienteControlador.php";

        $ins_cliente = new clienteControlador();
        echo $ins_cliente->paginador_doctores_controlador($pagina[1], 5, $_SESSION['privilegio_mdirectory'], $_SESSION['id_mdirectory'], $pagina[0], '');
    ?>
</div>