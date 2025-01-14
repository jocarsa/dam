function convierteTipoDato(tipo){

	let tipodevuelto
	
    if(tipo.includes("varchar")){														// Si el tipo de dato incluye varchar																	// y le sumo el valor correspondiente al array
 		tipodevuelto = "text"
    }else if(tipo.includes("text")){														// Si el tipo de dato incluye int
    	tipodevuelto = "textarea"
    }else if(tipo.includes("int")){														// Si el tipo de dato incluye int
    	tipodevuelto = "number"
    }else if(tipo.includes("date")){														// Si el tipo de dato incluye fecha
    	tipodevuelto = "date"
    }else if(tipo.includes("decimal")){														// Si el tipo de dato incluye decimal
    	tipodevuelto = "number"
    }else if(tipo.includes("time")){														// Si el tipo de dato incluye decimal
    	tipodevuelto = "time"
    }else if(tipo.includes("blob")){														// Si el tipo de dato incluye blob
    	tipodevuelto = "file"
    }
                
                
	return tipodevuelto
	
}
