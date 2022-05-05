<!-- Page header -->
<?php
    require_once "./modelos/menusModelo.php";

    $menus_padres = menusModelo::obtener_padres_modelo();

?>
<div class="full-box page-header">
    <h3 class="text-left">
        <i class="fas fa-plus fa-fw"></i> &nbsp; AGREGAR MENÚ
    </h3>
    <p class="text-justify">
        Agrega un nuevo menú para mostrar en la barra lateral
    </p>
</div>

<div class="container-fluid">
    <ul class="full-box list-unstyled page-nav-tabs">
        <li>
            <a class="active" href="<?php echo SERVERURL; ?>menu-new/"><i class="fas fa-plus fa-fw"></i> &nbsp; AGREGAR MENÚ</a>
        </li>
        <li>
            <a href="<?php echo SERVERURL; ?>menu-list/"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; MENÚS</a>
        </li>
    </ul>	
</div>

<!-- Content here-->
<div class="container-fluid">
    <form class="form-neon FormularioAjax" action="<?php echo SERVERURL; ?>ajax/menuAjax.php" method="POST" data-form="save" autocomplete="off" enctype="multipart/form-data">
        <fieldset>
            <legend><i class="fas fa-user"></i> &nbsp; Información básica</legend>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label for="menu_nombre" class="bmd-label-floating">Nombre del Menú</label>
                            <input type="text" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ\-., ]{1,40}" class="form-control" name="menu_nombre_reg" id="menu_nombre" maxlength="40" required>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label for="menu_icono" class="bmd-label-floating">ícono del Menú</label>
                            <input type="text" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ\-., ]{1,40}" class="form-control" name="menu_icono_reg" id="menu_icono" maxlength="20">
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label for="menu_ruta" class="bmd-label-floating">Ruta del Menú</label>
                            <input type="text" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,#\- / ]{1,150}" class="form-control" name="menu_ruta_reg" id="menu_ruta" maxlength="150" required>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="menu_activo" class="bmd-label-floating">Activo</label>
                            <input class="form-control" type="radio" name="menu_activo_reg" id="menu_activo" value="1">
                            <label for="menu_activo" class="bmd-label-floating">Inactivo</label>
                            <input class="form-control" type="radio" name="menu_activo_reg" id="menu_activo" value="0">
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="menu_padre" class="bmd-label-floating">Menú Padre</label>
                            <select class="form-control" name="menu_padre_reg" id="menu_padre">
                                <option value="0">Sin menú padre</option>
                                <?php for($i = 0; $i < sizeof($menus_padres); $i++){ ?>
                                    <option value="<?php echo $menus_padres[$i]['id_menu']; ?>"><?php echo $menus_padres[$i]['nom_menu']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
        <br><br><br>
        <p class="text-center" style="margin-top: 40px;">
            <button type="reset" class="btn btn-raised btn-secondary btn-sm"><i class="fas fa-paint-roller"></i> &nbsp; LIMPIAR</button>
            &nbsp; &nbsp;
            <button type="submit" class="btn btn-raised btn-info btn-sm"><i class="far fa-save"></i> &nbsp; GUARDAR</button>
        </p>
    </form>
</div>	