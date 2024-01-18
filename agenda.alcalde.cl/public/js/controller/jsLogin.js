$(".alert").hide();
eventListeners();
//const URL = "http://172.16.1.224:3000/";
//      const URL = "http://200.68.35.21:3000/";   
const URL = "http://agenda.laserena.cl:3000/";
//const URL = "http://192.168.0.24:3000/";

function eventListeners() {
	document.querySelector('#form-login').addEventListener('submit', validarLogin);
}
function validarLogin(e) {
	e.preventDefault();
	var usuario = document.querySelector('#txtUsuario').value;
	var clave = document.querySelector('#txtClave').value;
	if (usuario === '' || clave === '') {
		swal({
			title: 'Alerta de Notificación',
			text: "Debe llenar ambos campos",
			type: 'warning',
			timer: 1800,

		});
	} else {
		var xhr = new XMLHttpRequest();
		xhr.open('POST', URL + 'auth/login', true);
		xhr.setRequestHeader('X_Requested_With', 'XMLHttpRequest');
		xhr.setRequestHeader('Access-Control-Allow-Headers','*');
		xhr.setRequestHeader('Access-Control-Allow-Origin', '*');
		xhr.setRequestHeader('Content-type', 'application/json; charset=UTF-8');
		xhr.onreadystatechange = function () {
			if (xhr.readyState == 4 && xhr.status === 200) {
				var respuesta = xhr.responseText;
				var json = JSON.parse(respuesta); 
				if (json.code == 200) { 
						if (typeof (Storage) !== "undefined") {
							sessionStorage.setItem('usuario', json.user);
							sessionStorage.setItem('id_usuario', json.id_user);
							for (const key in json.permisos) {
								if(key=="crear"){
									if (json.permisos.hasOwnProperty(key)) {
										const crear = json.permisos[key];
										sessionStorage.setItem('crear', crear);
									}
								}else if(key=="administrar"){
									if (json.permisos.hasOwnProperty(key)) {
										const admin = json.permisos[key];
										sessionStorage.setItem('admin', admin);

									}
								}
							}
						} else {
							document.getElementById("result").innerHTML = "Lo siento, El Navegador no Acepta Storage de Session...";
						}
						swal({
							position:'top-right',
							title: json.success,
							html: "<h6>Bienvenido</h6> <b>" + json.user+'</b>',
							type: 'success',
							timer: 1000,
							showConfirmButton: false

						});
						setTimeout(function () {
							window.location.href = 'administrador';
						}, 1800);
				} else {
					swal({
						title: 'Login Incorrecto',
						text: "Usuario o Clave Incorrecto, Comunicarse con Mesa de Ayuda",
						type: 'warning',
						timer: 1800,
						showConfirmButton: false
					});
					$(".alert").show();
				 }
			}
		};
		xhr.send(JSON.stringify({"usuario":usuario, "clave":clave}));
	}
}





