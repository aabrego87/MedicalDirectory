<?php  
    if ($_SESSION['privilegio_mdirectory']!=1 && $_SESSION['privilegio_mdirectory']!=2 && $_SESSION['privilegio_mdirectory']!=3 && $_SESSION['privilegio_mdirectory']!=4) {
        echo $lc->forzar_cierre_sesion_controlador();
        exit();
    }
?>
<!-- Page header -->
<div class="full-box page-header">
    <h3 class="text-left">
        <i class="fas fa-clipboard-list fa-fw"></i> &nbsp; LISTA DE DOCTORES
    </h3>
    <p class="text-justify">
        Consulta la información del doctor deseado
    </p>
</div>

<div class="container-fluid">
    <ul class="full-box list-unstyled page-nav-tabs">
        <?php if($_SESSION['privilegio_mdirectory'] ==1){ ?>
        <li>
            <a href="<?php echo SERVERURL; ?>doctors-new/"><i class="fas fa-plus fa-fw"></i> &nbsp; NUEVO DOCTOR</a>
        </li>
        <?php } ?>
        <li>
            <a class="active" href="<?php echo SERVERURL; ?>doctors-list/"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; DOCTORES</a>
        </li>
    </ul>	
</div>

<div class="container-fluid">
    <?php
        require_once "./controladores/doctorControlador.php";

        $ins_doctor = new doctorControlador();
        echo $ins_doctor->paginador_doctores_controlador($pagina[1], 5, $_SESSION['privilegio_mdirectory'], $_SESSION['id_mdirectory'], $pagina[0], "");
    ?>
</div>