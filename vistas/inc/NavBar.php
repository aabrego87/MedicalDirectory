<nav class="full-box navbar-info">
	<a href="#" class="float-left show-nav-lateral">
		<i class="fas fa-exchange-alt"></i>
	</a>
	<a href="<?php //Comprobando tipo de usuario para editar perfil propio
		if($_SESSION['privilegio_mdirectory'] == 1 || $_SESSION['privilegio_mdirectory'] == 2 || $_SESSION['privilegio_mdirectory'] == 3){
			$seccion = 'user-update/'; 
		}else if($_SESSION['privilegio_mdirectory'] == 4){
			$seccion = 'doctors-update/';
		}else if($_SESSION['privilegio_mdirectory'] == 5){
			$seccion = 'client-update/';
		}
		
		echo SERVERURL . $seccion .$lc->encryption($_SESSION['id_mdirectory']).'/';

		?>">
		<i class="fas fa-user-cog"></i>
	</a>
	<a href="#" class="btn-exit-system">
		<i class="fas fa-power-off"></i>
	</a>
</nav>