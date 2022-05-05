<script>
    let btn_salir = document.querySelector(".btn-exit-system")

    btn_salir.addEventListener('click', function(e){
        e.preventDefault();
        Swal.fire({
			title: '¿Desea salir del sistema?',
			text: "La sesión actual será cerrada",
			type: 'question',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Si, Salir',
			cancelButtonText: 'No, Cancelar'
		}).then((result) => {
			if (result.value) {
				
                let url = '<?php echo SERVERURL; ?>ajax/loginAjax.php';
                let token = '<?php echo $lc->encryption($_SESSION['token_mdirectory']); ?>';
                let usuario = '<?php echo $lc->encryption($_SESSION['usuario_mdirectory']); ?>';

                let datos = new FormData();
                datos.append("token", token);
                datos.append("usuario", usuario);

                fetch(url,{
                    method: 'POST',
                    body: datos
                })
                .then(respuesta => respuesta.json())
                .then(respuesta => {
                    return alertas_ajax(respuesta);
                });
			}
		});
    });
</script> 