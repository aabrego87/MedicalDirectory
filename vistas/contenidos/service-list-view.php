<!-- Page header -->
<div class="full-box page-header">
    <h3 class="text-left">
        <i class="fas fa-clipboard-list fa-fw"></i> &nbsp; SERVICIOS
    </h3>
    <p class="text-justify">
        Consulta los servicios disponibles
    </p>
</div>

<?php 
    require_once "./modelos/especialidadModelo.php";

    $especialidades = especialidadModelo::obtener_especialidades_modelo();
?>

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
        <li>
            <form class="FormularioAjax" action="<?php echo SERVERURL; ?>ajax/buscadorAjax.php" method="POST">
            <input type="hidden" name="modulo" value="servicio">
            <select class="form-control" name="especialidad" id="inputSearch">
                <?php for($i = 0; $i < sizeof($especialidades); $i++){?>
                    <option value="<?php echo $especialidades[$i]['id_especialidad']; ?>"><?php echo $especialidades[$i]['especialidad']; ?></option>
                <?php } ?>
            </select>
        </li>
        <li>
            <button class="btn btn-raised">
                Buscar
            </button>
            </form>
        </li>
    </ul>	
</div>

<div class="container-fluid">
    <?php 
        require_once "./controladores/servicioControlador.php";

        $ins_servicio = new servicioControlador();
        echo $ins_servicio->paginador_servicios_controlador($pagina[1], 5, $_SESSION['privilegio_mdirectory'], $_SESSION['id_mdirectory'], $pagina[0], '');
    ?>
</div>