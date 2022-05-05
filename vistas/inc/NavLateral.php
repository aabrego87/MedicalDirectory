<?php 
	require_once "./modelos/menusModelo.php";

	$menus = menusModelo::obtener_menus_modelo($_SESSION['privilegio_mdirectory']); //MENUS
	$submenus1 = menusModelo::obtener_submenus1_modelo($_SESSION['privilegio_mdirectory']); //SUBMENUS CONFIGURACION
	$submenus2 = menusModelo::obtener_submenus2_modelo($_SESSION['privilegio_mdirectory']); //SUBMENUS OPERACION
	$submenus3 = menusModelo::obtener_submenus3_modelo($_SESSION['privilegio_mdirectory']); //SUBMENUS REPORTES

?>
<section class="full-box nav-lateral">
	<div class="full-box nav-lateral-bg show-nav-lateral"></div>
	<div class="full-box nav-lateral-content">
		<figure class="full-box nav-lateral-avatar">
			<i class="far fa-times-circle show-nav-lateral"></i>
			<img src="<?php if($_SESSION['privilegio_mdirectory'] == 1 || $_SESSION['privilegio_mdirectory'] == 2 || $_SESSION['privilegio_mdirectory'] == 3){
				echo SERVERURL . 'vistas/assets/avatar/' . $_SESSION['imagen_mdirectory'];
			}else if($_SESSION['privilegio_mdirectory'] == 4){
				echo SERVERURL . 'vistas/assets/doctores/' . $_SESSION['imagen_mdirectory'];
			}else if($_SESSION['privilegio_mdirectory'] == 5){
				echo SERVERURL . 'vistas/assets/clientes/' . $_SESSION['imagen_mdirectory'];
			} ?>" class="img-fluid" alt="Avatar">
			<figcaption class="roboto-medium text-center">
				<!--Andrés Abrego <br><small class="roboto-condensed-light">Web Developer</small>-->
				<?php if($_SESSION['privilegio_mdirectory'] == 1 || $_SESSION['privilegio_mdirectory'] == 2 || $_SESSION['privilegio_mdirectory'] == 3){
						$usuario = 'Usuario:';
					}else if($_SESSION['privilegio_mdirectory'] == 4){
						$usuario = 'Doctor:';
					}else if($_SESSION['privilegio_mdirectory'] == 5){
						$usuario = 'Cliente:';
					}
					echo $usuario . ' ' . $_SESSION['nombre_mdirectory'] . " " . $_SESSION['apellido_p_mdirectory'] . " " . $_SESSION['apellido_m_mdirectory']; ?> <br><small class="roboto-condensed-light"><?php echo $_SESSION['usuario_mdirectory']; ?></small>
			</figcaption>
		</figure>
		<div class="full-box nav-lateral-bar"></div>
		<nav class="full-box nav-lateral-menu">
			<ul>
				<!-- MENU DASHBOARD -->
				<li>
					<a href="<?php echo SERVERURL . $menus[0][3]; ?>"><i class="<?php echo $menus[0][2]?>"></i> &nbsp; <?php echo $menus[0][1]; ?></a>
				</li>

				<!-- MENU CONFIGURACION -->
				<li>
					<a href="<?php echo SERVERURL . $menus[1][3]; ?>" class="nav-btn-submenu"><i class="<?php echo $menus[1][2]; ?>"></i> &nbsp; <?php echo $menus[1][1]; ?> <i class="fas fa-chevron-down"></i></a>
					<!-- SUBMENUS CONFIGURACION -->
					<ul>
						<?php for($i = 0; $i < sizeof($submenus1); $i++){?>
							<li>
								<a href="<?php echo SERVERURL . $submenus1[$i][3]; ?>"><i class="<?php echo $submenus1[$i][2]?>"></i> &nbsp; <?php echo $submenus1[$i][1]; ?></a>
							</li>	
						<?php } ?>
					</ul>
				</li>

				<!-- MENU CATEGORIAS -->
				<li>
					<a href="<?php echo SERVERURL . $menus[2][3]; ?>" class="nav-btn-submenu"><i class="<?php echo $menus[2][2]; ?>"></i> &nbsp; <?php echo $menus[2][1]; ?> <i class="fas fa-chevron-down"></i></a>
					<!-- SUBMENUS PASARELAS -->
					<ul>
						<?php for($i = 0; $i < sizeof($submenus2); $i++){?>
							<li>
								<a href="<?php echo SERVERURL . $submenus2[$i][3]; ?>"><i class="<?php echo $submenus2[$i][2]; ?>"></i> &nbsp; <?php echo $submenus2[$i][1]; ?></a>
							</li>
						<?php } ?>
					</ul>
				</li>

				<!--MENU EMPRESA-->
				<li>
					<a href="<?php echo SERVERURL. $menus[3]['ruta_menu']; ?>"><i class="<?php echo $menus[3]['icon_menu']; ?>"></i> &nbsp; <?php echo $menus[3]['nom_menu']; ?></a>
				</li>
			</ul>
		</nav>
	</div>
</section>