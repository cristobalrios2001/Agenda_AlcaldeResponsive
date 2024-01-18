var id = sessionStorage.getItem('id_usuario');
var user = sessionStorage.getItem('usuario');
var crear = sessionStorage.getItem('crear');
var admin = sessionStorage.getItem('admin');


function node_env(name){
	switch (name) {
		case 'production':
//			var URL = "http://200.68.35.21:3000/";
			var URL = "http://agenda.laserena.cl:3000/";
			return URL;
	}
}
const DEV = node_env('production');
var horaJson = [{
		"hora": "07:30:00"
	},
	{
		"hora": "08:00:00"
	},
	{
		"hora": "08:30:00"
	},
	{
		"hora": "09:00:00"
	},
	{
		"hora": "09:30:00"
	},
	{
		"hora": "10:00:00"
	},
	{
		"hora": "10:30:00"
	},
	{
		"hora": "11:00:00"
	},
	{
		"hora": "11:30:00"
	},
	{
		"hora": "12:00:00"
	},
	{
		"hora": "12:30:00"
	},
	{
		"hora": "13:00:00"
	},
	{
		"hora": "13:30:00"
	},
	{
		"hora": "14:00:00"
	},
	{
		"hora": "14:30:00"
	},
	{
		"hora": "15:00:00"
	},
	{
		"hora": "15:30:00"
	},
	{
		"hora": "16:00:00"
	},
	{
		"hora": "16:30:00"
	},
	{
		"hora": "17:00:00"
	},
	{
		"hora": "17:30:00"
	},
	{
		"hora": "18:00:00"
	},
	{
		"hora": "18:30:00"
	},
	{
		"hora": "19:00:00"
	},
	{
		"hora": "19:30:00"
	},
	{
		"hora": "20:00:00"
	},
	{
		"hora": "20:30:00"
	},
	{
		"hora": "21:00:00"
	},
	{
		"hora": "21:30:00"
	},
	{
		"hora": "22:00:00"
	},
	{
		"hora": "22:30:00"
    },
    {
    	"hora": "23:00:00"
    }
];
var now = new Date();
var year = now.getFullYear();
var month = now.getMonth() + 1;
var day = now.getDate();
var dayWeek = now.getDay();
var dayWeekString;
switch (dayWeek) {
    case 0: dayWeekString='Domingo'; break;
    case 1: dayWeekString='Lunes';break;
    case 2: dayWeekString='Martes';break;
    case 3: dayWeekString='Miercoles';break;
    case 4: dayWeekString='Jueves';break;
    case 5: dayWeekString='Viernes';break;
    case 6: dayWeekString='Sabado';break;
}

var fechaactual = new Date();
var yearactual = fechaactual.getFullYear();
var monthactual = fechaactual.getMonth() + 1;
var dayactual = fechaactual.getDate();
function dateAsString(year, month, day, dayWeek) {
	d = (day < 10) ? '0' + day : day;
	m = month;
	m = (m < 10) ? '0' + m : m;
	return dayWeek+ ' ' + d + '-' + m + '-' + year;
}
function dateAsStringBD(year, month, day) {
	d = (day < 10) ? '0' + day : day;
	m = month;
	m = (m < 10) ? '0' + m : m;
	return year + '-' + m + '-' + d;
}


$(document).ready(function() {
    $('#viewCalendar').hide();
	$("#div-actividad").hide();
	if(user=='undefined' || user==null){
		 swal.fire({
			 title: 'Prohibido Acceso',
			 text: 'Tiene que Iniciar Sesion',
			 type: 'error',
			 timer: 1000,
			 showConfirmButton: false
		 });
		 setTimeout(function () {
			window.location.href = './login.php';
		 }, 1200);
	}
	document.getElementById("result").innerHTML = user;
	const arregloDate = dateAsString(year, month, day, dayWeekString);
	const fechaBD = dateAsStringBD(year, month, day);
	$("#date-popover-content").html(arregloDate);
    $("#date-fecha-content").html(arregloDate);
	$("#fecha_input").val(fechaBD);
	obtenerDatos(year, month, day);
	$("#my-calendar").zabuto_calendar({
			action: function () {
				return miFechaFuncion(this.id, true);
			},
			action_nav: function () {
				return miNavegadorFuncion(this.id);
			},
			year: year,
			month: month,
			show_previous: true,
			show_next: true,
			show_days: true,
			cell_border: true,
			today: true,
			nav_icon: true
	});

	$('#frmactividad').on("submit", function (e) {
		e.preventDefault();
		var fecha = $('#fecha_input').val();
		var hora_inicial = $('#slectHora').val();
		var descripcion = $('#txtareaActividad').val();
		var respuesta=descripcion.replace(/[.*+?^${}()|[\]\\\"/"]/g, '\\$&');

        var horaOriginal = hora_inicial.split(":");
        var h2 = horaOriginal[0];
        var m2 = horaOriginal[1];



        var hora_inicial_entero=h2+m2;


		if(descripcion =='' || descripcion==null){
			swal.fire({
				type: 'warning',
				title: 'Advertencia...',
				text: 'El campo actividad No puede estar Vacio!'//,
			});
		}else if(hora_inicial.trim() ==''){
				swal.fire({
					type: 'warning',
					title: 'Advertencia...',
					text: 'Se debe Seleccionar una Hora Inicial!' //,
				});
		}else{

                    var horaInicio = parseInt(hora_inicial_entero);
                    var minInicio = parseInt(m2);


                        horaStatic = horaInicio;
                        minutoStatic = minInicio;
                        if (horaInicio == horaStatic || minInicio == minInicio) {
                            h = (horaInicio < 1000) ? '0' + horaInicio : horaInicio;
                            m = (minInicio < 10) ? '0' + minInicio : minInicio;
                            horaInicio=horaInicio+100;
                            minInicio = 0;
                        }
                        if(minInicio==0){
                            h = (horaInicio < 1000) ? '0' + horaInicio : horaInicio;
                            minInicio = 30;
                        }

                $.ajax({
                    headers: {
                        'Access-Control-Allow-Origin': 'http://200.68.35.21:3000/',
                    },
                    type: 'POST',
                    url: DEV + 'nueva/actividad',
                    data: JSON.stringify({
                        "fecha": fecha,
                        "hora_inicial": hora_inicial,
                        "descripcion": respuesta,
                        "id_usuario": id
                    }),
                    contentType: "application/json",
                    success: function (data) {
                        var resultado = data;
                        switch (resultado.code) {
                            case 200:
                                swal({
                                    title: 'Evento Ingresada Exitosamente',
                                    text: resultado.success,
                                    type: 'success',
                                    timer: 1000,
                                    showConfirmButton: false
                                });
                                var fecha0=new Date(fecha);
                                var year0=String(fecha0.getFullYear());
                                var mes0=String(fecha0.getMonth()+1);
                                var dia0=String(fecha0.getDate()+1);
                                setTimeout(function() {
                                    $("#div-actividad").hide();
                                   		window.onload(obtenerDatos(year0, mes0, dia0));
                                    }, 1200);
                                break;
                            case 121:
                                swal({
                                    title: 'El evento, Ya tiene Ocupado esa Hora',
                                    text: resultado.failed,
                                    type: 'warning',
                                    timer: 1200
                                });
                                setTimeout(() => {
                                    $("#div-actividad").show();
                                    $("#txtareaActividad").focus();
                                }, 2800);
                                break;
                            case 400:
                                swal({
                                    title: 'No se pudo Ingresar el Evento',
                                    text: resultado.failed,
                                    type: 'warning',
                                    timer: 1000,
                                    showConfirmButton: false
                                });
                                setTimeout(function () {
                                    location.reload(window.location + 'administrador');
                                }, 1200);
                                break;
                            case 401:
                                swal({
                                    title: 'No se pudo Ingresar el Evento',
                                    text: resultado.failed,
                                    type: 'warning',
                                    timer: 1000,
                                    showConfirmButton: false
                                });
                                setTimeout(function () {
                                    location.reload(window.location + 'administrador');
                                }, 1200);
                                break;
                        }
                    },
                    error: function (data) {
                        swal({
                            title: 'Error Ingreso',
                            text: "El Evento no se ah Podido Registrar!",
                            type: 'warning',
                            timer: 1000,
                            showConfirmButton: false

                        });
                    }
                });

            }
        });
$('#addContent').click(function () {
	setTimeout(() => {
        $("#div-actividad").show();
        $('#slectHora').prop('disabled', false);
        $('#slectHora').val("0");
        $('#txtareaActividad').val("");
    }, 500);
    return false;
});

	$(document).on('click', '#warning', function (e) {
		swal({
			title: '¿Esta seguro de Cancelar?',
			text: "No podra revertir los cambios",
			type: 'error',
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Aceptar!'
		}).then((result) => {
			if (result.value) {
				swal({
					title: 'EDICIÓN CANCELADA',
					text: "La informacion a sido cancelada",
					type: 'warning',
					timer: 1000,
					showConfirmButton: false
                });
				setTimeout(function () {
					location.reload(window.location + 'administrador');
				}, 500);
			}
		});
	});
});
function message(tipo, title, html) {
        swal.fire({
            type: tipo,
            title: title,
            html: html,
            timer: 1400,
            showConfirmButton: false
        });

}
function miFechaFuncion(id, fromModal, bool) {
	$("#date-popover").hide();
	if (fromModal) {
		$("#" + id + "_modal").modal("hide");
	}
	var date = $("#" + id).data("date");
	var hasEvent = $("#" + id).data("hasEvent");
	if (hasEvent && !fromModal) {
		return false;
	}

    if (bool == true) {
    message('info', 'Nueva Actividad para', '<h1><strong>' + date + '</strong></h1>', true);
    }
    var fechacalculardia=new Date(date);
    var diaSitch=fechacalculardia.getDay();
    var diaSemana;
    switch (diaSitch) {
        case 0: diaSemana='Lunes'; break;
        case 1: diaSemana='Martes';break;
        case 2: diaSemana='Miercoles';break;
        case 3: diaSemana='Jueves';break;
        case 4: diaSemana='Viernes';break;
        case 5: diaSemana='Sabado';break;
        case 6: diaSemana='Domingo';break;
    }
	var fecha = date.split('-');
	$("#date-popover-content").html(diaSemana+' '+fecha[2] + '-' + fecha[1] + '-' + fecha[0]);
	$("#date-fecha-content").html(fecha[2] + '-' + fecha[1] + '-' + fecha[0]);
    $("#fecha_input").val(fecha[0] + '-' + fecha[1] + '-' + fecha[2]);

	obtenerDatos(fecha[0], fecha[1], fecha[2]);
	$("#date-popover").show();
	return true;
}

function miNavegadorFuncion(id) {
	$("#date-popover").show();
	var nav = $("#" + id).data("navigation");
	var to = $("#" + id).data("to");
}

function eliminarActividad(id_agenda){
    swal({
        title: '¿Esta seguro de Eliminar esta Actividad?',
        text: "No podra revertir los cambios",
        type: 'error',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, Eliminar!'
    }).then((result) => {
        if (result.value) {
            $.ajax({
                headers: {
//                    'Access-Control-Allow-Origin': 'http://200.68.35.21:3000/',
                    'Access-Control-Allow-Origin': 'http://agenda.laserena.cl:3000/',
                    'Content-Type': 'application/json'
                },
                url: DEV + 'eliminar/actividad/' + id + '/' + id_agenda,
                method: 'GET',
                success: function (res) {
                    resultado=res;
                    switch (resultado.code) {
                        case 200:
                            swal({
                                title: resultado.success,
                                text: "Evento Guardado",
                                type: 'success',
                                timer: 1000,
                                showConfirmButton: false
                            });
                            setTimeout(function () {
                                location.reload(window.location + 'administrador');
                            }, 1200);
                        break;
                    }

                }
            });

            swal({
                title: 'ACTIVIDAD ELIMINADA',
                text: "La informacion a sido Eliminada",
                type: 'warning',
                timer: 1000,
                showConfirmButton: false
            });
            setTimeout(function () {
                location.reload(window.location + 'administrador');
            }, 1200);
        }
    });
}
function editarActividad(id_agenda) {
	$("#div-actividad").show();
	$("#txtareaActividad").focus();
	$.ajax({
		headers: {
//			'Access-Control-Allow-Origin': 'http://200.68.35.21:3000/',
			'Access-Control-Allow-Origin': 'http://agenda.laserena.cl:3000/',
			'Content-Type': 'application/json'
		},
		url: DEV+'actividad/'+ id + '/' + id_agenda,
		method: 'GET',
		success: function (res) {
			if(res.code==401){
				swal({
					title: 'Problemas Credenciales',
					text: resultado.failed,
					type: 'warning',
					timer: 1000,
					showConfirmButton: false
				});
			}else{
                var fecha = res[0].fecha;
                var nuevafecha=fecha.split("-");
                var yearfk=nuevafecha[0];
                var mesfk=nuevafecha[1];
                var diafk=nuevafecha[2];

                var hora_inicial = res[0].hora;
                var descripcion = res[0].descripcion;
                var descMinuscula = descripcion.toLowerCase();

                $("#div-actividad").html('<div class="titulo">ACTUALIZAR ACTIVIDAD </div><div class="col-md-6 mt"><label>Actividad</label><textarea id="txtareaActividad" name="txtareaActividad" class="form-control" rows="4" cols="50"></textarea></div><div class="col-md-6 mt"><label> Hora</label ><select class="form-control" id="slectHora" name="slectHora"> <option value="0"> Seleccione una hora </option><option value="07:30:00">07:30</option > <option value="08:00:00" > 08: 00 </option><option value="08:30:00">08:30</option > <option value="09:00:00"> 09: 00 </option><option value="09:30:00">9:30</option > <option value="10:00:00" > 10: 00 </option><option value="10:30:00">10:30</option > <option value="11:00:00" > 11: 00 </option><option value="11:30:00">11:30</option > <option value="12:00:00" > 12: 00 </option><option value="12:30:00">12:30</option > <option value="13:00:00" > 13: 00 </option><option value="13:30:00">13:30</option > <option value="14:00:00"> 14: 00 </option><option value="14:30:00">14:30</option > <option value="15:00:00" > 15: 00 </option><option value="15:30:00">15:30</option > <option value="16:00:00" > 16: 00 </option><option value="16:30:00">16:30</option > <option value="17:00:00" > 17: 00 </option><option value="17:30:00">17:30</option > <option value = "18:00:00" > 18: 00 </option><option value="18:30:00">18:30</option> <option value="19:00:00"> 19: 00 </option><option value="19:30:00">19:30</option > <option value="20:00:00" > 20: 00 < /option><option value="20:30:00">20:30</option > < option value = "21:00:00" > 21: 00 < /option><option value="21:30:00">21:30</option > <option value="22:00:00" > 22: 00 </option><option value="22:30:00">22:30</option> </select></div><div class="col-md-6 mt"><label></label><div class="row"><div class="col-md-6 col-xs-6"><button id="warning"  type="button" class="btn btn-danger btn-block">Cancelar</button></div><div class="col-md-6 col-xs-6"><button id="success" type="button" onclick="editarFormulario(' + id_agenda + ')" class="btn btn-success btn-block">Agregar</button></div> <div > <input type="hidden" id="fecha_input" name="fecha_input" value=""><input type="hidden" id="id_usuario" name="id_usuario" value="" ></div></div></div>');


				$('#txtareaActividad').val(unescape(descMinuscula));
                $('#slectHora').prop('disabled', true);
				$('#slectHora').val(hora_inicial);
				$('#id_usuario').val(id);
				$('#fecha_input').val(fecha);
				$('#idActividad').val(id_agenda);
				$('#success').text('Actualizar');
				$('#success').removeClass('btn-success');
                $('#success').addClass('btn-primary');
                var fechaForm = new Date(yearfk + "-" + mesfk + "-" + diafk);
                var hoy = new Date();
                var dia = hoy.getDate() - 1;
                hoy.setDate(dia);
                if (fechaForm < hoy) {
                    $('#success').attr("disabled", "disabled");
                    $('#success').attr("title", "No se puede Actualizar");
                } else if (fechaForm >= hoy ) {
                    $('#success').removeAttr("disabled");
                    $('#success').attr("title", "Actualizar Actividad");
                }

			}
		}
	});
}

function editarFormulario(id_agenda){
	var fecha = $('#fecha_input').val();
	var hora_inicial = $('#slectHora').val();
	var descripcion = $('#txtareaActividad').val();
	var respuesta=descripcion.replace(/[.*+?^${}()|[\]\\\"/"]/g, '\\$&');
    var id_ag=id_agenda;


        var horaOriginal = hora_inicial.split(":");
        var h2 = horaOriginal[0];
        var m2 = horaOriginal[1];


        var horaInicio = parseInt(h2);
        var minInicio = parseInt(m2);

        tiempo = 0;

            horaStatic = horaInicio;
            minutoStatic = minInicio;
            if (horaInicio == horaStatic || minInicio == minInicio) {
                h = (horaInicio < 10) ? '0' + horaInicio : horaInicio;
                m = (minInicio < 10) ? '0' + minInicio : minInicio;
                horaInicio++;
                minInicio = 0;
                tiempo++;
            }
            h = (horaInicio < 10) ? '0' + horaInicio : horaInicio;
            minInicio = 30;
            tiempo++;
	$.ajax({
		headers: {
//			'Access-Control-Allow-Origin': 'http://200.68.35.21:3000/',
			'Access-Control-Allow-Origin': 'http://agenda.laserena.cl:3000/',
		},
		type: 'POST',
		url:DEV+'actualizar/actividad',
		data: JSON.stringify({
            "descripcion": respuesta,
			"id":id_ag,
			"id_usuario":id,
			"fecha": fecha
		}),
		contentType: "application/json",
		success: function (data) {
            var resultado = data;
            switch (resultado.code) {
                case 200:
                    swal({
                        title: 'Evento Actualizado Exitosamente',
                        text: "Evento Guardado",
                        type: 'success',
                        timer: 1000,
                        showConfirmButton: false
                    });
                    setTimeout(function () {
                        location.reload(window.location + 'administrador');
                    }, 1200);
                    break;
                case 400:
                    swal({
                        title: 'No se pudo Actualizar el Evento',
                        text: resultado.failed,
                        type: 'warning',
                        timer: 1000,
                        showConfirmButton: false
                    });
                    break;
                 case 401:
                        swal({
                    	    title: 'Problemas Credenciales',
                    	    text: resultado.failed,
                    	    type: 'success',
                    	    timer: 1000,
                    	    showConfirmButton: false
                    	});
                    break;
                default:
                    break;
            }
		},
		error: function (data) {
			swal({
				title: 'Error Ingreso',
				text: "El Evento no se ah Podido Actualizar!",
				type: 'warning',
				timer: 1000,
				showConfirmButton: false
			});
		}
	});
}
function limpiarForm(){
    $("#txtareaActividad").val("");
    $("#slectHora").val("");
    $("#testimado").val("");
}

function logout() {
    sessionStorage.clear();
    swal({
        title: 'Saliendo del Sistema',
        text: "Hasta Luego!!",
        type: 'warning',
        timer: 2800,
        showConfirmButton: false
    });
    setTimeout(function () {
        window.location.href = 'login.php';
    }, 1000);
}
function obtenerDatos(year, month, day) {
	$.ajax({
		headers: {
//			'Access-Control-Allow-Origin': 'http://200.68.35.21:3000/',
			'Access-Control-Allow-Origin': 'http://agenda.laserena.cl:3000/',
			'Content-Type': 'application/json'
		},
		url: DEV + 'actividad/'+id+'/' + year + '/' + month + '/' + day,
		method: 'GET',
		success: function (res) {

            var template = '<table width="100%" bordercolor="white" border="4" style="border-color:#fff; text-align: center; margin-top:5px;"><thead><tr><td width="8%" align="center" valign="middle" bgcolor="green" scope="col" style="color:white" class="titulo-tabla-print titulo-tabla ">Hora</td><td width="72%" align="center" valign="middle" bgcolor="#333333" scope="col" style="color:white" class="titulo-tabla-print titulo-tabla titulo-actividad-tabla">Actividad</td><td class="no-print titulo-tabla" width="14%" align="center" valign="middle" id="accion_row" bgcolor="#333333" scope="col" style="color:white">Acción</tdh></tr></thead><tbody>';
            var hora_inicial;
            var horaBase;
            var id_agenda;
            for (let i = 0; i < horaJson.length; i++) {
                var contadorHora = horaJson[i].hora;
                var recorridoVector = contadorHora.split(":");
                var horaVector = recorridoVector[0];
                var minutoVector = recorridoVector[1];
                var horaVectorTotal = horaVector + minutoVector;
                var horatotalinicialBD;
                var contador=1;
                for (var index = 0; index < res.length; index++) {
                    var descripcion = res[index].descripcion;
                    var descMinuscula = descripcion.toUpperCase();

                    hora_inicial = res[index].hora;
                    id_agenda = res[index].id_agenda;

                    var horaOriginal = hora_inicial.split(":");
                    var h2 = horaOriginal[0];
                    var m2 = horaOriginal[1];

                    horatotalinicialBD = h2 + m2;

                    if (parseInt(horaVectorTotal) == parseInt(horatotalinicialBD)) {
                    	horaBase = horaVectorTotal;
                        minBase = parseInt(horatotalinicialBD.slice(2, 4));

                        var back = ["#66ff99", "#f3becc", "#99ddff", "#ffcc99", "#cccccc"];
                            h = horaBase;
                            m = (minBase < 10) ? '0' + minBase : minBase;

                        if (horatotalinicialBD != null || horatotalinicialBD == 'undefined') {

                            template += '<tr class="label-default">';
                                 if(parseInt(horatotalinicialBD)==parseInt(horaBase)){
                                    totalHoraInicial = h2 + m2;
                                    horaInicio = horaBase;
                                    minInicio = minBase;
                                    switch(contador){
                                        case 1:
                                                if(contador<=1){
                                                    template += '<tr class="label-default"><td class="label-default-td" ><strong>' + Math.floor(parseInt(h) / 100) + ":" + m + '</strong></td>';//<td class="label-default-td"><strong>' + totalHoraFinal.slice(0, 2) + ":" + totalHoraFinal.slice(2, 4) + '</strong></td>
                                                }
                                                if(contador<=1){
                                                    template += '<td style="background-color:' + back[1] + ';padding:12px;" class="actividadletra">'+descMinuscula+'</td><td class="no-print bg-info accion_row" style="border-bottom:1px solid #fff !important;border-top:1px solid #fff !important;"><button type="button" name="id_agenda(' + id_agenda + ')"  onclick="editarActividad(' + id_agenda + ')" class="btn btn-xs btn-primary mbottom"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span > </button><button type="button" id="btn_eliminar(' + id_agenda + ')" name="btn_agenda(' + id_agenda + ')" onclick="eliminarActividad(' + id_agenda + ')" class="btn btn-xs btn-danger mbottom btndelete"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span > </button></td ></ tr>';
                                                    contador ++;
                                                }
                                            break;
                                        case 2:
                                                if(contador>2){
                                                    template += '<tr class="label-default" ><td class="label-default-td" rowspan="'+contador+'" ><strong>' + Math.floor(parseInt(h) / 100) + ":" + m + '</strong></td>';//<td class="label-default-td"><strong>' + totalHoraFinal.slice(0, 2) + ":" + totalHoraFinal.slice(2, 4) + '</strong></td>style="border:0!important;"border-top: 2px solid black!important;border-bottom: 2px solid black!important;
                                                }
                                                if(contador>1){
                                                    template += '<td style="border-top:0px!important;"></td><td style="background-color:' + back[1] + '!important;padding:12px;" class="actividadletra">'+descMinuscula+'</td><td class="no-print bg-info accion_row" style="border-bottom:2px solid '+back[4]+'!important;border-top:2px solid '+back[4]+'!important;"><button type="button" name="id_agenda(' + id_agenda + ')"  onclick="editarActividad(' + id_agenda + ')" class="btn btn-xs btn-primary mbottom"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span > </button><button type="button" id="btn_eliminar(' + id_agenda + ')" name="btn_agenda(' + id_agenda + ')" onclick="eliminarActividad(' + id_agenda + ')" class="btn btn-xs btn-danger mbottom btndelete"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span > </button></td ></ tr>';
                                                    contador++;
                                                }
                                            break;
                                        case 3:
                                                if(contador>3){
                                                    template += '<tr class="label-default"><td class="label-default-td" rowspan="'+contador+'" style="border:0!important;"><strong>' + Math.floor(parseInt(h) / 100) + ":" + m + '</strong></td>';//<td class="label-default-td"><strong>' + totalHoraFinal.slice(0, 2) + ":" + totalHoraFinal.slice(2, 4) + '</strong></td>border-top: 2px solid black!important;border-bottom: 2px solid black!important;
                                                }
                                                if(contador>2){
                                                    template += '<td style="border-top:0px!important;"></td><td style="background-color:' + back[1] + '!important;padding:12px;border-bottom: 1px solid black!important;" class="actividadletra">'+descMinuscula+'</td><td class="no-print bg-info accion_row" style="border-bottom:2px solid '+back[4]+'!important;border-top:2px solid '+back[4]+'!important;"><button type="button" name="id_agenda(' + id_agenda + ')"  onclick="editarActividad(' + id_agenda + ')" class="btn btn-xs btn-primary mbottom"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span > </button><button type="button" id="btn_eliminar(' + id_agenda + ')" name="btn_agenda(' + id_agenda + ')" onclick="eliminarActividad(' + id_agenda + ')" class="btn btn-xs btn-danger mbottom btndelete"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span > </button></td ></ tr>';
                                                    contador++;
                                                }
                                            break;
                                        case 4:
                                            if(contador>4){
                                                template += '<tr class="label-default" ><td class="label-default-td"  rowspan="'+contador+'" style="border:0!important;"><strong>' + Math.floor(parseInt(h) / 100) + ":" + m + '</strong></td>';//<td class="label-default-td"><strong>' + totalHoraFinal.slice(0, 2) + ":" + totalHoraFinal.slice(2, 4) + '</strong></td>border-top: 2px solid black!important;
                                            }
                                            if(contador>3){
                                                template += '<td style="border-top:0px!important;"></td><td style="background-color:' + back[1] + ';padding:12px;border-bottom: 1px solid black!important;" class="actividadletra">'+descMinuscula+'</td><td class="no-print bg-info accion_row" style="border-bottom:2px solid '+back[4]+'!important;border-top:1px solid '+back[4]+'!important;"><button type="button" name="id_agenda(' + id_agenda + ')"  onclick="editarActividad(' + id_agenda + ')" class="btn btn-xs btn-primary mbottom"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span > </button><button type="button" id="btn_eliminar(' + id_agenda + ')" name="btn_agenda(' + id_agenda + ')" onclick="eliminarActividad(' + id_agenda + ')" class="btn btn-xs btn-danger mbottom btndelete"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span > </button></td ></ tr>';
                                                contador++;
                                            }
                                        break;
                                        case 5:
                                            if(contador>5){
                                                template += '<tr class="label-default" ><td class="label-default-td"  rowspan="'+contador+'" style="border:0!important;"><strong>' + Math.floor(parseInt(h) / 100) + ":" + m + '</strong></td>';//<td class="label-default-td"><strong>' + totalHoraFinal.slice(0, 2) + ":" + totalHoraFinal.slice(2, 4) + '</strong></td>border-top: 2px solid black!important;
                                            }
                                            if(contador>4){
                                                template += '<td style="border-top:0px!important;"></td><td style="background-color:' + back[1] + ';padding:12px;border-bottom: 1px solid black!important;" class="actividadletra">'+descMinuscula+'</td><td class="no-print bg-info accion_row" style="border-bottom:2px solid '+back[4]+'!important;border-top:1px solid '+back[4]+'!important;"><button type="button" name="id_agenda(' + id_agenda + ')"  onclick="editarActividad(' + id_agenda + ')" class="btn btn-xs btn-primary mbottom"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span > </button><button type="button" id="btn_eliminar(' + id_agenda + ')" name="btn_agenda(' + id_agenda + ')" onclick="eliminarActividad(' + id_agenda + ')" class="btn btn-xs btn-danger mbottom btndelete"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span > </button></td ></ tr>';
                                                contador++;
                                            }
                                        break;
                                        case 6:
                                            if(contador>6){
                                                template += '<tr class="label-default" ><td class="label-default-td"  rowspan="'+contador+'" style="border:0!important;"><strong>' + Math.floor(parseInt(h) / 100) + ":" + m + '</strong></td>';//<td class="label-default-td"><strong>' + totalHoraFinal.slice(0, 2) + ":" + totalHoraFinal.slice(2, 4) + '</strong></td>border-top: 2px solid black!important;
                                            }
                                            if(contador>5){
                                                template += '<td style="border-top:0px!important;"></td><td style="background-color:' + back[1] + ';padding:12px;border-bottom: 1px solid black!important;" class="actividadletra">'+descMinuscula+'</td><td class="no-print bg-info accion_row" style="border-bottom:2px solid '+back[4]+'!important;border-top:1px solid '+back[4]+'!important;"><button type="button" name="id_agenda(' + id_agenda + ')"  onclick="editarActividad(' + id_agenda + ')" class="btn btn-xs btn-primary mbottom"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span > </button><button type="button" id="btn_eliminar(' + id_agenda + ')" name="btn_agenda(' + id_agenda + ')" onclick="eliminarActividad(' + id_agenda + ')" class="btn btn-xs btn-danger mbottom btndelete"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span > </button></td ></ tr>';
                                                contador++;
                                            }
                                        break;
                                        case 7:
                                            if(contador>7){
                                                template += '<tr class="label-default" ><td class="label-default-td"  rowspan="'+contador+'" style="border:0!important;"><strong>' + Math.floor(parseInt(h) / 100) + ":" + m + '</strong></td>';//<td class="label-default-td"><strong>' + totalHoraFinal.slice(0, 2) + ":" + totalHoraFinal.slice(2, 4) + '</strong></td>border-top: 2px solid black!important;
                                            }
                                            if(contador>6){
                                                template += '<td style="border-top:0px!important;"></td><td style="background-color:' + back[1] + ';padding:12px;border-bottom: 1px solid black!important;" class="actividadletra">'+descMinuscula+'</td><td class="no-print bg-info accion_row" style="border-bottom:2px solid '+back[4]+'!important;border-top:1px solid '+back[4]+'!important;"><button type="button" name="id_agenda(' + id_agenda + ')"  onclick="editarActividad(' + id_agenda + ')" class="btn btn-xs btn-primary mbottom"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span > </button><button type="button" id="btn_eliminar(' + id_agenda + ')" name="btn_agenda(' + id_agenda + ')" onclick="eliminarActividad(' + id_agenda + ')" class="btn btn-xs btn-danger mbottom btndelete"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span > </button></td ></ tr>';
                                                contador--;
                                            }
                                        break;
                                    }
                                template +='</tr>';
                              }
                            }
                        }
                    }
                var backg = ["#969aa3", "#969aa3", "purple"];
                Base = (horaBase == undefined) ? horaBase = 630 : horaBase;
                var min = (parseInt(horaVectorTotal.slice(2, 4)) < 10) ? '0' + parseInt(horaVectorTotal.slice(2, 4)) : parseInt(horaVectorTotal.slice(2, 4));
                if (parseInt(horaVectorTotal) != parseInt(Base) && contadorHora<='23:00:00') {
                    if ((Math.floor(parseInt(horaVectorTotal) / 100) + ":" + min) != "23:00") {
                        template += ' <tr ><td class="label-default-td" style="color:white"><strong>' + Math.floor(parseInt(horaVectorTotal) / 100) + ":" + min + '</strong></td><td></td><td class="no-print"></td></tr>';
                    }
                    if ((Math.floor(parseInt(horaVectorTotal) / 100) + ":" + min)=="23:00"){
                        template += ' <tr ><td class="label-default" ><strong>' + Math.floor(parseInt(horaVectorTotal) / 100) + ":" + min + '</strong></td><td style="background-color:' + backg[0] + ';padding:10px;font-size:13px;">CIERRE JORNADA</td><td class="no-print accion_row" style="background-color:' + backg[0] + ';"></td></tr>';
                    }
                }
            }
            template += '</tbody></table>';
            $("#calendario_agenda").html(template);

            var fechaForm=new Date(year+"-"+month+"-"+day);
            var hoy=new Date();
            var dia = hoy.getDate() - 1;
            hoy.setDate(dia);

            hoy.setHours(0, 0, 0, 0);
            fechaForm.setHours(0, 0, 0, 0);

            if (fechaForm == hoy || fechaForm >= hoy) {
                $('#addContent').removeAttr("disabled");
                $('#addContent').attr("title", "Nueva Actividad");
                $('.btndelete').removeAttr("disabled");
                $('.btndelete').attr("title", "Se puede Eliminar");


            } else if (fechaForm < hoy) {
                $('#addContent').attr("disabled", "disabled");
                $('#addContent').attr("title", "No se puede Ingresar");
                $('.btndelete').attr("disabled", "disabled");
                $('.btndelete').attr("title", "No se puede Eliminar");

            }

            if (crear == 1 && admin == 1) {
				$('.mbottom').show();
                $('#addContent').show();
                $('#accion_row').show();
                $('.accion_row').show();
			} else if (crear == 0 && admin == 0) {
				$('#addContent').hide();
                $('.mbottom').hide();
                $('#accion_row').hide();
                $('.accion_row').hide();
                $('.accion_row').width("0%");
                $('.titulo-actividad-tabla').width("96%");
			}
		}
	});
}
