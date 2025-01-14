
	let tamanio = 1;
	let cantidadcontraste = 1
	let contenedor = document.createElement("div")
	contenedor.classList.add("jvampliador")
	let invertido = false;
	
	////////////////// AUMENTAR /////////////////
	
	let aumentar = document.createElement("button")
	aumentar.textContent = "+"
	 aumentar.setAttribute("aria-label","Ampliar")
	 aumentar.setAttribute("title","Ampliar el tamaño de la letra")
	
	contenedor.appendChild(aumentar)
	aumentar.onclick = function(){
		tamanio *= 1.1;
		document.querySelector("body").style.fontSize = tamanio+"em"
	}
	
	////////////////// CONTRASTE /////////////////
	
	let contraste = document.createElement("button")
	contraste.textContent = "C"
	contraste.setAttribute("aria-label","Contraste")
	
	contenedor.appendChild(contraste)
	contraste.onclick = function(){
		cantidadcontraste = 30;
		document.querySelector("body").style.filter = "contrast("+cantidadcontraste+")"
	}
	
	////////////////// INVERTIR /////////////////
	
	let invertir = document.createElement("button")
	invertir.textContent = "I"
	invertir.setAttribute("aria-label","Invertir")
	
	contenedor.appendChild(invertir)
	invertir.onclick = function(){
		if(invertido == false){
			document.querySelector("body").style.filter = "invert(1) hue-rotate(180deg)"
			invertido = true
		}else{
			document.querySelector("body").style.filter = "invert(0) hue-rotate(0deg)"
			invertido = false
		}
	}
	
	////////////////// FUENTE /////////////////
	
	let fuentes = ['Sans-serif','serif','personalizada','monospace']
	let contador = 0
	
	let fuente = document.createElement("button")
	fuente.textContent = "F"
	fuente.setAttribute("aria-label","Cambiar la fuente")
	
	contenedor.appendChild(fuente)
	fuente.onclick = function(){
		console.log("ok pulsado")
		document.querySelector("body").style.fontFamily = fuentes[contador]
		contador++;
		if(contador == 4){contador = 0;}
	}
	
	////////////////// DISMINUIR /////////////////
	
	let disminuir = document.createElement("button")
	disminuir.textContent = "-"
	disminuir.setAttribute("aria-label","Disminuir el tamaño de la fuente")
	contenedor.appendChild(disminuir)
	
	disminuir.onclick = function(){
		tamanio *= 0.9;
		document.querySelector("body").style.fontSize = tamanio+"em"
	}
	
	document.querySelector("body").appendChild(contenedor)

