<!-- Page header -->
<div class="full-box page-header">
    <h3 class="text-left">
        <i class="fas fa-clipboard-list fa-fw"></i> &nbsp; LISTA DE ESPECIALIDADES
    </h3>
    <p class="text-justify">
        Consulta las especialidades disponibles para cada doctor
    </p>
</div>

<div class="container-fluid">
    <ul class="full-box list-unstyled page-nav-tabs">
        <li>
            <a href="<?php echo SERVERURL; ?>especialidad-new/"><i class="fas fa-plus fa-fw"></i> &nbsp; AGREGAR ESPECIALIDAD</a>
        </li>
        <li>
            <a class="active" href="<?php echo SERVERURL; ?>especialidad-list/"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; ESPECIALIDADES</a>
        </li>
    </ul>	
</div>

<div class="container-fluid">
    <?php 
        require_once "./controladores/especialidadControlador.php";

        $ins_especialidades = new especialidadControlador();
        echo $ins_especialidades->paginador_especialidad_controlador($pagina[1], 5, $_SESSION['privilegio_mdirectory'], $_SESSION['id_mdirectory'], $pagina[0], "");
    ?>
</div>