/*
	Escuchador del boton de guardar.
	Realiza una petición asincrónica al servidor enviándole los datos del terreno y el usuario
*/
document.querySelector("#guardar").onclick = function(){
			console.log("vamos a guardar")
			const url = 'back/siennaback.php'; // Replace with your target URL
			const datos = {
				 usuario: localStorage.getItem("siennausuario"),
				 terreno: memoria
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
				 return response.text(); // Parse JSON response if needed
			})
			.then(responseData => {
				 console.log('Response:', responseData);
			})
			.catch(error => {
				 console.error('Error:', error);
			});
		}
