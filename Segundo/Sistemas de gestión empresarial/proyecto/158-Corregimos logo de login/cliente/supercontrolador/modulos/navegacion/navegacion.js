function listadoTablas(aplicacion){
	/////////////////////////////////// LISTADO DE TABLAS /////////////////////////////////////////////
    
    fetch("../../servidor/?o=listatablasaplicacion&aplicacion="+aplicacion)                        // LLamo a un microservicio que me da la lista de tablas
        .then(response => {
          return response.json();                                   // Quiero que el servidor me devuelva un json
        })
        .then(datos => {
        //console.log(datos)
        		poblarMenuNavegacion(datos,"tabla");
        })
    
    /////////////////////////////////// LISTADO DE TABLAS /////////////////////////////////////////////
}

function listadoDocumentos(){
	/////////////////////////////////// LISTADO DE COLECCIONES DE MONGO /////////////////////////////////////////////
    
    fetch("../../servidor/?o=listacolecciones")                        // LLamo a un microservicio que me da la lista de tablas
        .then(response => {
          return response.json();                                   // Quiero que el servidor me devuelva un json
        })
        .then(datos => {
        console.log("Vamos con las colecciones")
        console.log(datos)
        		poblarMenuNavegacion(datos,"coleccion");
        })
    
    /////////////////////////////////// LISTADO DE COLECCIONES DE MONGO /////////////////////////////////////////////
}
