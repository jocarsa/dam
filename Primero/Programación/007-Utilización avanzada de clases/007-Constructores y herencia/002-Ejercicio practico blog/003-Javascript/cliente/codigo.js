window.onload = function(){
	console.log("Javascript funciona")
	fetch("../servidor/damearticulos.php")
	.then(function(response){
		return response.json()
	})
	.then(function(datos){
		console.log(datos)
	})
}
