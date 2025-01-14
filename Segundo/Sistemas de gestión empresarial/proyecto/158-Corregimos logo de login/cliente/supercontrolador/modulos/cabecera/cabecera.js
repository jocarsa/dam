/*
	En este archivo encontramos las siguientes funciones:
	1.-Función de imprimir
	2.-Mostrar el panel de lógica de negocio
	3.-Mostrar la ayuda
	4.-Recargar la web al pulsar en el título
*/

function imprimir(){
	/////IMPRIMIR ///////
	
	document.querySelector("#imprimir").onclick = function(){
		window.print()
	}
}

function muestraBI(){
	//// BUSINESS ANALYTICS ////
	
	document.querySelector("#businessanalytics").onclick = function(){
		console.log("Has hecho click")
		document.querySelector("section").innerHTML = ""
		let marco = document.createElement("iframe")
		marco.setAttribute("src","../bi/")
		document.querySelector("section").appendChild(marco)
	}
}
function ayuda(){
	/// AYUDA ////////
	
	document.querySelector("#ayuda").onclick = function(){
		console.log("vamos a la ayuda")
		let marco = document.createElement("iframe")
		marco.setAttribute("src","ayuda/")
		document.querySelector("main").appendChild(marco)
	}
}
function recargarEnTitulo(){
	/// RECARGAR PAGINA
	document.querySelector("h1").onclick = function(){
		window.location = window.location
	}
}
