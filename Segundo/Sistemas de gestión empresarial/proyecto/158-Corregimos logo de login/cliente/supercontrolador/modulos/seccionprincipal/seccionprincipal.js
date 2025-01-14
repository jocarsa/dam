function cargaGraficas(){
	console.log("Vamos a por las gráficas")
	fetch("../../servidor/?o=estadisticastablas")
    	.then(function(result){
    		return result.json()
    	})
    	.then(function(datos){
    	console.log("el servidor dice ok")
    		let nuevografico = new JVGrafica(datos,"#dc143c","table tbody","Resgistros en cada tabla");
			nuevografico.anillo()
    	})
}

function cargoAplicaciones(){
	////////////////////////////////// CARGO LAS APLICACIONES /////////////////////////////////////////////
    
    fetch("apps/apps.json")
    .then(function(response){
    	return response.json()
    })
    .then(function(datos){
    	console.log(datos)
    	aplicaciones = datos
    })
}
