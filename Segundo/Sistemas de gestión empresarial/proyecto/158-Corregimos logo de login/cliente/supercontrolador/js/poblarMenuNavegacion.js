function poblarMenuNavegacion(datos,tipoentidad){
	//console.log(datos)
            let menu = document.querySelector("nav #"+tipoentidad)             // Selecciono el menu donde voy a poner las entradas dinamicas
            datos.forEach(function(tabla){                          // Para cada una de las tablas que han venido de la base de datos
                let nombre_de_la_tabla = tabla['Tables_in_crimson'];    // Atrapo el nombre de la tabla que viene del fetch
                let elemento = document.createElement("li")         // Creo en memoria un nuevo elemento li
                let icono;
                switch(tipoentidad){
                	case "tabla":
                		icono = "<span class='boton botonblanco'><img src='img/iconotabla.svg'></span>";
                		break;
                	case "coleccion":
                		icono = "<span class='boton botonblanco'><img src='img/iconodocumento.svg'></span>";
                }
                elemento.innerHTML = icono+" "+nombre_de_la_tabla           // A ese elemento li le pongo como texto el nombre de la tabl
               elemento.setAttribute("destino",nombre_de_la_tabla)
                elemento.setAttribute("jvtooltip","Haz click para cargar la información de la tabla "+nombre_de_la_tabla)
                elemento.setAttribute("comentario",tabla['Comentario'])
                elemento.onclick = function(){                      // Cuando hago click en los elementos de la tabla
                    let texto = this.getAttribute("destino")                    // Atrapo el texto del elemento de navegacion
                    switch(tipoentidad){
				          	case "tabla":
				          		cargaDatosTabla(texto) 
				          		break;
				          	case "coleccion":
				          		cargaDatosColeccion(texto)
				          		console.log("ok coleccion")
				          }
                                             // Y lo paso como parametro a la llamada que carga los datos de la tabla
                    document.querySelector(".titulotabla h5").textContent = this.textContent
                    document.querySelector(".titulotabla p").textContent = this.getAttribute("comentario")
                    
                    // Primero voy a quitar todas las clases
                    let elementosmenu = document.querySelectorAll("nav ul li")
                    elementosmenu.forEach(function(elemento){           // PAra cada uno de los elementos del menu
                        elemento.classList.remove("menuseleccionado")
                    })
                    
                    this.classList.add("menuseleccionado")
                }
                menu.appendChild(elemento)                          // Lo añado al menú
                
            })
}
