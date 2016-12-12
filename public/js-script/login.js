$(document).ready(function() {
	
	$("#ingresar").click(function(){

		if($("#email").val() == "" || $("#pass").val() == ""){
			alert("Ambos campos son requeridos");
		}else{
			var email = $("#email").val();
			var pass  = $("#pass").val();

			var data = {
						email:email,
						password:pass
			}

			$.ajax({
				url: BASEURL + '/loginUser',
				type: 'POST',
				dataType: 'json',
				data: data,
			})
			.done(function(result) {
				
				if(result.id){
					alert("Bienvenido");
					window.location.href = BASEURL+"/home";
				}	
				else{
					alert("Datos incorrectos");
					$("#email").val("");
					$("#pass").val("");
					$("#email").focus();
				}		
				
			});
			
		}
		

		
	});

});