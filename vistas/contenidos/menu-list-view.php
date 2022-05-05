<!-- Page header -->
<div class="full-box page-header">
    <h3 class="text-left">
        <i class="fas fa-clipboard-list fa-fw"></i> &nbsp; LISTA DE MENUS
    </h3>
    <p class="text-justify">
        Consulta la información de los menus que están disonibles en el sistema
    </p>
</div>

<div class="container-fluid">
    <ul class="full-box list-unstyled page-nav-tabs">
        <li>
            <a href="<?php echo SERVERURL; ?>menu-new/"><i class="fas fa-plus fa-fw"></i> &nbsp; AGREGAR MENÚ</a>
        </li>
        <li>
            <a class="active" href="<?php echo SERVERURL; ?>menu-list/"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; MENÚS</a>
        </li>
    </ul>
</div>

<div class="container-fluid">
    <?php 
        require_once "./controladores/menuControlador.php";

        $ins_menu = new menuControlador();
        echo $ins_menu->paginador_menus_controlador($pagina[1], 5, $_SESSION['privilegio_mdirectory'], $_SESSION['id_mdirectory'], $pagina[0], "");
    ?>
</div>