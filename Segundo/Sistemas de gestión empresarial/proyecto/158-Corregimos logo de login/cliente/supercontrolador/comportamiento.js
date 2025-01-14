var columnas_tabla = []                                             // Creo una variable global para almacenar las columnas
var aplicaciones;


window.onload = function(){
	 let aplicacion = localStorage.getItem("crimson_aplicacion")
    
    listadoTablas(aplicacion);
    listadoDocumentos();

    cargaGraficas();		
    modal()
    //abrirEmail()
    
    cargoAplicaciones()
	 imprimir();
	
	 muestraBI()
	
	 ayuda()
	 recargarEnTitulo()
}


 
 
 
 
