<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<title><?php echo COMPANY; ?></title>
	<?php include "./vistas/inc/Link.php"; ?>
</head>
<body>
	<?php
		$peticionAjax=false;

		require_once  "./controladores/vistasControlador.php";
		$IV = new vistasControlador();

		$vistas=$IV->obtener_vistas_controlador();

		if($vistas=="login" || $vistas=="404"){
			require_once "./vistas/contenidos/".$vistas."-view.php";

		}else if($vistas=="register-type"){
			require_once "./vistas/contenidos/".$vistas."-view.php";
		}else if($vistas=="register-doctor"){
			require_once "./vistas/contenidos/".$vistas."-view.php";
		}else if($vistas=="register-paciente"){
			require_once "./vistas/contenidos/".$vistas."-view.php";
		}else{
			session_start(['name' => 'MDIRECTORY']);

			$pagina = explode("/", $_GET['views']);

			require_once "./controladores/loginControlador.php";
			$lc = new loginControlador();

			if (!isset($_SESSION['token_mdirectory']) || !isset($_SESSION['usuario_mdirectory']) 
					|| !isset($_SESSION['privilegio_mdirectory']) || !isset($_SESSION['id_mdirectory'])) { //Evalua si estan seteadas las sesiones si no, evita el acceso
						echo $lc->forzar_cierre_sesion_controlador();
						exit();
			}
		?>
		<!-- Main container -->
		<main class="full-box main-container">
			<!-- Nav lateral -->
			<?php 
				include "./vistas/inc/NavLateral.php"; 
			?>
			<!-- Page content -->
			<section class="full-box page-content">
			<?php 
				include "./vistas/inc/NavBar.php"; 
				include $vistas;
			?>
			</section>
		</main>			
		<?php 
			include "./vistas/inc/LogOut.php";
		}
		include "./vistas/inc/Script.php"; 
		?>
</body>
</html>