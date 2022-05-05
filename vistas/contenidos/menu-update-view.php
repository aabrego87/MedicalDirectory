<?php
    require_once "./modelos/menusModelo.php";

    $menus_padres = menusModelo::obtener_padres_modelo();
?>
<!-- Page header -->
<div class="full-box page-header">
    <h3 class="text-left">
        <i class="fas fa-sync-alt fa-fw"></i> &nbsp; ACTUALIZAR MENÚ
    </h3>
    <p class="text-justify">
        Modifique aquí la información del Menú
    </p>
</div>

<div class="container-fluid">
    <ul class="full-box list-unstyled page-nav-tabs">
        <?php if($_SESSION['privilegio_mdirectory'] == 1 || $_SESSION['privilegio_mdirectory'] == 3 || $_SESSION['privilegio_mdirectory'] == 4){ ?>
        <li>
            <a href="<?php echo SERVERURL; ?>menu-new/"><i class="fas fa-plus fa-fw"></i> &nbsp; AGREGAR MENÚ</a>
        </li>
        <?php } ?>
        <li>
            <a href="<?php echo SERVERURL; ?>menu-list/"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; MENÚS</a>
        </li>
    </ul>	
</div>

<?php //Obteniendo datos del Doctor
    require_once "./controladores/menuControlador.php";

    $ins_menu = new menuControlador();
    $datos_menu = $ins_menu->datos_menu_controlador("Unico", $pagina[1]);

    if($datos_menu->rowCount() == 1){
        $campo = $datos_menu->fetch();
?>

<!-- Content here-->
<div class="container-fluid">
    <form class="form-neon FormularioAjax" action="<?php echo SERVERURL; ?>ajax/menuAjax.php" method="POST" data-form="update" autocomplete="off">
        <input type="hidden" name="menu_id_up" value="<?php echo $pagina[1]; ?>">
        <fieldset>
            <legend><i class="fas fa-user"></i> &nbsp; Información básica</legend>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label for="menu_nombre" class="bmd-label-floating">Nombre del Menú</label>
                            <input type="text" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ\-., ]{1,40}" class="form-control" name="menu_nombre_up" id="menu_nombre" value="<?php echo $campo['nom_menu'] ?>" maxlength="40" required>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label for="menu_icono" class="bmd-label-floating">ícono del Menú</label>
                            <input type="text" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ\-., ]{1,40}" class="form-control" name="menu_icono_up" id="menu_icono" value="<?php echo $campo['icon_menu'] ?>" maxlength="20">
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label for="menu_ruta" class="bmd-label-floating">Ruta del Menú</label>
                            <input type="text" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,#\- / ]{1,150}" class="form-control" name="menu_ruta_up" id="menu_ruta" value="<?php echo $campo['ruta_menu'] ?>" maxlength="150" required>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="menu_activo" class="bmd-label-floating">Activo</label>
                            <input class="form-control" type="radio" name="menu_activo_up" id="menu_activo" value="1" <?php if($campo['activo'] == 1){ echo 'checked';} ?>>
                            <label for="menu_activo" class="bmd-label-floating">Inactivo</label>
                            <input class="form-control" type="radio" name="menu_activo_up" id="menu_activo" value="0" <?php if($campo['activo'] == 0){ echo 'checked';} ?>>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="menu_padre" class="bmd-label-floating">Menú Padre</label>
                            <select class="form-control" name="menu_padre_up" id="menu_padre">
                                <option value="0">Sin menú padre</option>
                                <?php for($i = 0; $i < sizeof($menus_padres); $i++){ ?>
                                    <option value="<?php echo $menus_padres[$i]['id_menu']; ?>" <?php if($campo['id_padre'] == $menus_padres[$i]['id_menu']){ echo 'selected';} ?>><?php echo $menus_padres[$i]['nom_menu']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
        <p class="text-center" style="margin-top: 40px;">
            <button type="submit" class="btn btn-raised btn-success btn-sm"><i class="fas fa-sync-alt"></i> &nbsp; ACTUALIZAR</button>
        </p>
    </form>

<?php }else{ ?><!--Alerta si no se encuentra el ID-->
    <div class="alert alert-danger text-center" role="alert">
        <p><i class="fas fa-exclamation-triangle fa-5x"></i></p>
        <h4 class="alert-heading">¡Algo no va bien!</h4>
        <p class="mb-0">Lo sentimos, no podemos mostrar la información solicitada debido a un problema.</p>
    </div>
<?php } ?>

</div>	