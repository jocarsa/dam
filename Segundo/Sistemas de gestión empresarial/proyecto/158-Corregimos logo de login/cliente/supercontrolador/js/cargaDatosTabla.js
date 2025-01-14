/////////////////////////////////// CREO UNA FUNCIÓN PARA CARGAR DINÁMICAMENTE TABLAS /////////////////////////////////////////////

function cargaDatosTabla(tabla){
	
	/////////////////////////////////// VAMOS A VER SI TENEMOS APLICACIONES /////////////
	listaaplicaciones = []
	console.log("las aplicaciones son:",aplicaciones)
	try{
		aplicaciones.forEach(function(aplicacion){
			if(aplicacion.entidad == tabla){
				console.log("si que hay aplicaciones, y las aplicaciones son:",aplicacion.aplicaciones)
				listaaplicaciones = aplicacion.aplicaciones;
			}
		})
	}catch(Error){
		console.log("ha habido un error:",Error)
	}
	
	/////////////////////////////////// VAMOS A VER SI TENEMOS APLICACIONES /////////////

   let campoclave;                                                          // Creo  una variable que va a almacenar el nombre del campo que es clave primaria
   /////////////////////////////////// LISTADO DE COLUMNAS DE TABLA /////////////////////////////////////////////
    document.querySelector("table").style.display = "table"
    fetch("../../servidor/?o=columnastabla&tabla="+tabla)                 // LLamo a un microservicio que me da la lista de tablas y le paso la tabla como parametro
        .then(response => {
          return response.json();                                           // Quiero que el servidor me devuelva un json
        })
        .then(datos => {
            columnas_tabla = []                                             // Vacía las columnas anteriores para cargar solo las nuevas
            tipos_tabla = []																// Creo un array vacio para almacenar los tipos de dato de las colummnas de la tabla
            claves_tabla = []																// Creo un array vacio para almacenar el tipo de clave de cada columna de la tabla
            campos_busqueda = []															// Creo un array vacio para almacenar los input del buscador de la tabla
            let cabeceras_tabla = document.querySelector("table thead tr"); // Selecciono donde tengo que poner las cabeceras en la tabla
            cabeceras_tabla.innerHTML = ""                                  // Por si acaso hay columnas previamente cargadas, vacio la cabecera
            datos.forEach(function(dato){                                   // PAra cada uno de los datos
                let elemento = document.createElement("th")                 // Creo un elemento que es una cabecera de tabla
                columnas_tabla.push(dato['Field'])                          // Al listado de columnas le añades la columna actual
                 
                elemento.textContent = dato['Field']                        // Su texto es el nombre del campo de la base de datos
                campos_busqueda.push(document.createElement("input"))											// Creo un elemento de tipo input html
                campos_busqueda[campos_busqueda.length-1].setAttribute("placeholder",dato['Field'] )	// A cada uno de los campos del buscador les pongo un placeholder
                
                claves_tabla.push(dato['Key'])										// Al array de claves le añado el valor de la clave que viene de la base de datos
                
                campos_busqueda[campos_busqueda.length-1].setAttribute("type",convierteTipoDato(dato['Type']) )
                tipos_tabla.push(convierteTipoDato(dato['Type']))
                
                elemento.appendChild(campos_busqueda[campos_busqueda.length-1])											// En cada una de las cabeceras, pongo un campo input
                cabeceras_tabla.appendChild(elemento)                       // Añado ese elemento a las cabeceras de la tabla
                if(dato['Key'] == "PRI"){                                   // Si este campo es clave primaria
                    campoclave = dato['Field']                              // en ese caso, recordamos cual es el nombre del campo que hace de clave primaria
                }
            })
            
            ////// CARGO APLICACIONES SI ES QUE LAS HAY
            
            if(listaaplicaciones.length > 0){
            	let elemento = document.createElement("th")
            	elemento.textContent = "Apps"
            	cabeceras_tabla.appendChild(elemento)
            }
            
            ////// CARGO APLICACIONES SI ES QUE LAS HAY
            
            let elemento = document.createElement("th") 							// Creo una columna mas en la tabla
            elemento.innerHTML = "<span class='boton botonblanco'><img src='img/iconolupa.svg'></span>"												// En la ultima cabecera de columna pongo la lupa
            cabeceras_tabla.appendChild(elemento) 									// Lo añado a las cabeceras de la tabla
            elemento.onclick = function(){											// Cuando haga click en la lupa

            	mensaje = {}																// Creo un objeto vacio
            	campos_busqueda.forEach(function(campo){							// Para cada uno de los input de busqueda
            		let columna = campo.getAttribute("placeholder")				// Atrapo el nombre del campo
            		let valor = campo.value												// Atrapo el valor del campo
            		if(valor != ""){														// Si el campo no está vacio
            			mensaje[columna] = valor										// Le añado el dato al objeto
            		}
            	})
            	fetch("../../servidor/?o=buscarSimilar&tabla="+tabla, {		// Ahora realizo una peticion al servidor y le paso el objeto
                          method: 'POST', 
                          headers: {
                            'Content-Type': 'application/json', 
                          },
                          body: JSON.stringify(mensaje), 
                        })
					  .then(response => {
						 return response.json();                                                       // Quiero que el servidor me devuelva un json
					  })
					  .then(datos => {			  
					  		pueblaTabla(datos,campoclave,tabla,listaaplicaciones)									// Cuando el servidor me responde, pueblo la tabla con los datos que han venido
					  })
            }
            //console.log(columnas_tabla);
            
                /////////////////////////////////// LISTADO DE COLUMNAS DE TABLA /////////////////////////////////////////////
                let coleccioncampos = []                                                                // Creo una colección vacía de campos
                let contiene_modal = document.querySelector("#contienemodal")                           // Selecciono el contenedor del modal
                contiene_modal.innerHTML = "<h1>Formulario de inserción: "+tabla+"</h1>"                                                           // Si el modal contenía algo, lo vaćio
                let seccion = document.createElement("section")
                columnas_tabla.forEach(function(columna,index){                                               // PAra cada una de las columnas de la tabla
                    let contenedor = document.createElement("div")
                    let texto = document.createElement("p")
                    texto.textContent = "Inserta un nuevo elemento para: "+columna+""
                    contenedor.appendChild(texto)
                    if(claves_tabla[index] != "MUL"){
                    	if(tipos_tabla[index] == "textarea"){
                    		coleccioncampos.push(document.createElement("textarea"))
                    	}else{
                    	
		                 coleccioncampos.push(document.createElement("input"))
		                 }                               // Creo un campo input
		                 coleccioncampos[coleccioncampos.length-1].setAttribute("type",tipos_tabla[index]) 
		                                                          // Le pongo una leyenda al campo 
		                coleccioncampos[coleccioncampos.length-1].setAttribute("placeholder",columna)                                                  // Lo añado al modal
                    	contenedor.appendChild(coleccioncampos[coleccioncampos.length-1])                                                                            
                    
                    }else{
                    		let selectElement = document.createElement("select");
                    coleccioncampos.push(selectElement);

                    let defaultOption = document.createElement("option");
                    defaultOption.textContent = "Selecciona una opción:";
                    selectElement.appendChild(defaultOption);

                    fetchOptionsForSelect(selectElement, columna);
                    selectElement.setAttribute("placeholder", columna);
                    
                    contenedor.appendChild(selectElement);
                    selectjv(selectElement)
                    }  
                     
                    /*
                    try{
                    	
                    }catch(Error){
                    	console.log("no aplica")
                    }
                    */
                    seccion.appendChild(contenedor)                                                    // Lo añado al modal
                		
                	})
                contiene_modal.appendChild(seccion) 
                
                let boton_enviar = document.createElement("button")                                     // Por último creo un boton
                boton_enviar.textContent = "Enviar"                                                     // Le pongo texto al boton
                boton_enviar.onclick = function() {
						 console.log("Vamos a procesar el formulario");
						 console.log(coleccioncampos);
						 //let formData = new FormData();
							// LA NOVEDAD ESTRIBA EN QUE USAMOS JSON DIRECTO EN LUGAR DE FORMDATA
						 let jsonObject = {};
							coleccioncampos.forEach(function(campo) {
								 if (campo.getAttribute('placeholder') !== "Identificador") {
									  if (campo.getAttribute('type') === "file") {
											console.log("Archivos no soportados en esta versión.");
									  } else {
											jsonObject[campo.getAttribute('placeholder')] = campo.value;
									  }
								 }
							});

							console.log("Objeto JSON enviado:", jsonObject);

							fetch("../../servidor/?o=insertar&tabla=" + tabla, {
								 method: 'POST',
								 headers: {
									  'Content-Type': 'application/json',
								 },
								 body: JSON.stringify(jsonObject),
							})
								 .then(response => response.text())
								 .then(datos => {
									  console.log(datos);
									  document.querySelector("#modal").classList.remove("aparece");
									  document.querySelector("#modal").classList.add("desaparece");
									  setTimeout(() => {
											document.querySelector("#modal").style.display = "none";
									  }, 1000);
								 });
					};
                contienemodal.appendChild(boton_enviar)                                                 // Añado el boton al modal
                /////////////////////////////////// LISTADO DE COLUMNAS DE TABLA /////////////////////////////////////////////
            
            /////////////////////////////////// CONTENIDO DE LA TABLA /////////////////////////////////////////////
 
            fetch("../../servidor/?o=tabla&tabla="+tabla)                            // LLamo a un microservicio que me da la lista de tablas y le paso la tabla como parametro
                .then(response => {
                  return response.json();                                                   // Quiero que el servidor me devuelva un json
                })
                .then(datos => {
                    pueblaTabla(datos,campoclave,tabla,listaaplicaciones)
                })
           
            /////////////////////////////////// CONTENIDO DE LA TABLA /////////////////////////////////////////////
            
            
            /////////////////////////////////// CONTENIDO DE LA VENTANA MODAL /////////////////////////////////////////////
        })
    
 }
 
 /////////////////////////////////// CREO UNA FUNCIÓN PARA CARGAR DINÁMICAMENTE TABLAS /////////////////////////////////////////////
 
 
 
 function fetchOptionsForSelect(selectElement, column) {
    fetch("../../servidor/?o=tabla&tabla=" + column.split("_")[0])
        .then(response => response.json())
        .then(datos => {
            datos.forEach(function(dato) {
                let option = document.createElement("option");
                option.value = dato['Identificador'];
                option.textContent = Object.values(dato).join(' - ');
                selectElement.appendChild(option);
            });
        });
}
