function validaEmail(email) {
  var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  return regex.test(email);
}


function ultimoUsuario(){
	$.ajax({
		url: BASEURL + '/lastUser',
		type: 'GET',
		dataType: 'json',
	})
	.done(function(resultUser) {
		$("#username").html(resultUser.name);
		$("#usermail").html(resultUser.email);
	});
}

$(document).ready(function() {
	ultimoUsuario();
	$("#registrar").click(function(){
		if($("#name").val() == "" || $("#email").val() == "" ||$("#pass").val() == "" || $("#pass2").val() == ""){
			alert("Todos los campos son requeridos");
		}else if(!validaEmail($("#email").val())){
			alert("Ingresa un email valido");
		}else if($("#pass").val().length < 6){
			alert("La contraseña debe ser mayor a 6 caracteres");
			$("#pass").val("");
			$("#pass2").val("");
			$("#pass").focus();
		}else if($("#pass").val() != $("#pass2").val()){
			alert("Las contraseñas deben coincidir");
			$("#pass").val("");
			$("#pass2").val("");
			$("#pass").focus();	
		}else{
			var name = $("#name").val();
			var email = $("#email").val();
			var pass  = $("#pass").val();

			var data = {
						name:name,
						email:email,
						password:pass
			}

			$.ajax({
				url: BASEURL + '/newUser',
				type: 'POST',
				dataType: 'json',
				data: data,
			})
			.done(function(result) {
				if(result.success){
					alert("Usuario agregado correctamente");
					$("#name").val("");
					$("#email").val("");
					$("#pass").val("");
					$("#pass2").val("");

					ultimoUsuario();
					
				}else{
					alert("Usuario ya existente");
				}
			});
				
		}
	});

});	