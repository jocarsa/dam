
document.querySelector("#iniciarsesion").onclick = function(){
	const url = 'back/siennaback.php?router=login'; // Replace with your target URL
			const datos = {
				 usuario: document.querySelector("#usuario").value,
				 contrasena: document.querySelector("#contrasena").value
			};

			fetch(url, {
				 method: 'POST', // Use POST, PUT, DELETE, etc. as needed
				 headers: {
					  'Content-Type': 'application/json' // Set the content type to JSON
				 },
				 body: JSON.stringify(datos) // Convert the JavaScript object to a JSON string
			})
			.then(response => {
				 if (!response.ok) {
					  throw new Error(`HTTP error! Status: ${response.status}`);
				 }
				 return response.json(); // Parse JSON response if needed
			})
			.then(responseData => {
				 console.log('Response:', responseData);
				 if(responseData.resultado == "ok"){
				 	document.querySelector("#login").style.display = "none";
					localStorage.setItem("siennausuario",document.querySelector("#usuario").value)
					
					// Cargo terreno si existe
					fetch("back/siennaback.php?router=cargaterreno&usuario="+document.querySelector("#usuario").value)
					.then(function(response){
						return response.json()
					})
					.then(function(datos){
						console.log(datos)
						memoria = datos
					})
					
				 }else{
				 	window.location = window.location;
				 }
			})
			.catch(error => {
				 console.error('Error:', error);
			});
	
}

