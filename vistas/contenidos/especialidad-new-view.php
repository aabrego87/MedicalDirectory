<!-- Page header -->
<div class="full-box page-header">
    <h3 class="text-left">
        <i class="fas fa-plus fa-fw"></i> &nbsp; AGREGAR ESPECIALIDAD
    </h3>
    <p class="text-justify">
        Agregue el nombre de la especialidad deseada
    </p>
</div>

<div class="container-fluid">
    <ul class="full-box list-unstyled page-nav-tabs">
        <li>
            <a class="active" href="<?php echo SERVERURL; ?>especialidad-new/"><i class="fas fa-plus fa-fw"></i> &nbsp; AGREGAR ESPECIALIDAD</a>
        </li>
        <li>
            <a href="<?php echo SERVERURL; ?>especialidad-list/"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; ESPECIALIDADES</a>
        </li>
    </ul>
</div>

<!--CONTENT-->
<div class="container-fluid">
    <form class="form-neon FormularioAjax" action="<?php echo SERVERURL; ?>ajax/especialidadAjax.php" method="POST" data-form="save" autocomplete="off">
        <fieldset>
            <legend><i class="fa fa-star"></i> &nbsp; Información de la Especialidad</legend>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label for="especialidad_nombre" class="bmd-label-floating">Nombre de la Especialidad</label>
                            <input type="text" pattern="[a-zA-záéíóúÁÉÍÓÚñÑ0-9 ]{1,140}" class="form-control" name="especialidad_nombre_reg" id="especialidad_nombre" maxlength="140">
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
