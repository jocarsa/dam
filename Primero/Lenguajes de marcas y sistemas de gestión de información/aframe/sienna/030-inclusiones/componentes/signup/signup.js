document.querySelector("#crearusuario").onclick = function(){
	const url = 'back/siennaback.php?router=signup'; // Replace with your target URL
			const datos = {
				 usuario: document.querySelector("#nuevousuario").value,
				 contrasena: document.querySelector("#nuevacontrasena").value
			};

			fetch(url, {
				 method: 'POST', 
				 headers: {
					  'Content-Type': 'application/json' 
				 },
				 body: JSON.stringify(datos) 
			})
			.then(function(response){
				return response.json()
			})
			.then(function(datos){
				console.log(datos)
				if(datos.respuesta == "ok"){
					window.location = window.location;
				}
			})
}	
