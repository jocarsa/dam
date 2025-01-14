window.onload = function(){
	

    let usuario = localStorage.getItem("crimson_usuario")
    if(usuario == undefined){
    	window.location = "../"
    }
    let token =  localStorage.getItem("crimson_token")
    if(token == undefined){
    	window.location = "../"
    }
    
    fetch("../../servidor/?o=compruebatoken&token="+token) 
    .then(response => {
          return response.json();                       // Quiero que el servidor me devuelva un json
        })
        .then(data => {
        	console.log(data)
        	if(data.resultado == "ok"){
        		
        	}else{
        		window.location = "../"
        	}
        })
    
    fetch("../../servidor/?o=listadoaplicacionesusuario&usuario="+usuario)         // LLamo a un microservicio que me da la lista de aplicaciones
        .then(response => {
          return response.json();                       // Quiero que el servidor me devuelva un json
        })
        .then(data => {
            const plantilla = document.getElementById('plantilla_aplicacion');              // Cargo el template HTML como una plantilla en memoria (como un class)
            console.log(data)                                                               // Vomito el json en pantalla
            data.forEach(function(elemento) {                                               // Para cada uno de los elementos que vienen en el json de la base de datos
                console.log(elemento);                                                      // Pongo el elemento en pantalla simplemente para comprobar que funciona
                const instancia = plantilla.content.cloneNode(true);                        // Creo  una nueva instancia de la clase (como un instance)
                const nombre = instancia.querySelector('p');                                // Dentro de la plantilla selecciono a uno de los elementos
                nombre.innerHTML = elemento.nombre;                                         // Y le pongo el contenido que saco del json
                let icono = instancia.querySelector(".icono")
                icono.textContent = elemento.nombre[0]
                document.querySelector('main').appendChild(instancia);                      // Por ultimo realmente pongo la instancia en el arbol html
            });
            
            let aplicaciones = document.querySelectorAll(".aplicacion")                     // Selecciono todas las aplicaciones y las pongo en un array
            aplicaciones.forEach(function(aplicacion){                                      // Para cada una de las aplicaciones
                aplicacion.onclick = function(){                                            // Cuando haga click en esa aplicacion
                    localStorage.setItem('crimson_aplicacion', this.querySelector("p").textContent);
                    window.location = "../supercontrolador/"
                }
            })
        })
     document.querySelector("#cerrarsesion").onclick = function(){
     	localStorage.removeItem("crimson_usuario")
     		localStorage.removeItem("crimson_token")
     		window.location = "../"
     }
}
