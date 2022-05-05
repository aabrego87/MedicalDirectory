<?php
    require_once "./controladores/doctorControlador.php";

    $ins_doctor = new doctorControlador();
    $datos_doctor = $ins_doctor->datos_doctor_controlador("Unico", $pagina[1]);
    
    if($datos_doctor->rowCount() == 1){
        $campo = $datos_doctor->fetch();
    }
?>
<!-- Page header -->
<div class="full-box page-header">
    <h3 class="text-center">
        <i class="fas fa-clipboard-list fa-fw"></i> &nbsp; DOCTOR <?php echo $campo['nombre_doctor'] . ' ' . $campo['apellido_p_doctor'] . ' ' . $campo['apellido_m_doctor']; ?>
    </h3>
    <center>
        <img src="<?php echo SERVERURL . 'vistas/assets/doctores/' . $campo['imagen'];?>" width="20%" alt="">
    </center>
    <p class="text-center">
        <?php echo $campo['descripcion']; ?>
    </p>
</div>

<div class="container-fluid">
    <ul class="full-box list-unstyled page-nav-tabs">
        <li>
            <a href="<?php echo SERVERURL; ?>home/"><i class="fas fa-home fa-fw"></i> &nbsp; INICIO</a>
        </li>
        <li>
            <a class="" href="<?php echo SERVERURL . 'service-doctor-list/' . $lc->encryption($campo['id_doctor']); ?>"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; SERVICIOS DEL DOCTOR</a>
        </li>
    </ul>	
</div>

<div class="container-fluid">
    <div class="form-neon">
        <fieldset>
            <legend><i class="fa fa-user"></i> &nbsp; Datos del Doctor</legend>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="">Teléfono:</label>
                            <h6><?php echo $campo['telefono']; ?></h6>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="">Email:</label>
                            <h6><?php echo $campo['email']; ?></h6>
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
        <fieldset>
            <legend><i class="fa fa-building"></i> &nbsp; Información del Consultorio</legend>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="">Nombre del Consultorio:</label>
                            <h6><?php echo $campo['nombre_negocio']; ?></h6>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="">Dirección del Consultorio:</label>
                            <h6><?php echo $campo['direccion_consultorio']; ?></h6>
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
    </div>
    <br/><br/>
</div>