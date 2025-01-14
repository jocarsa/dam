class JVGrafica{
	constructor(datos,color,selector,titulo){
		this.datos = datos
		this.color = color
		this.selector = selector
		this.titulo = titulo
	}
	tarta() {
	 // Condiciones iniciales
	 let anchura = 512;                                      // Anchura del lienzo
	 let altura = 512;                                       // Altura del lienzo
	 let lienzo = document.createElement("canvas");         // Selecciono el lienzo
	 lienzo.width = anchura;                                 // Le pongo la anchura
	 lienzo.height = altura;                                // Le pongo la altura
	 //lienzo.style.border = "1px solid grey";                // Un poco de estilo
	 let contexto = lienzo.getContext("2d");                // creo un contexto en el que dibujar
	 let variacioncolor = 100;
	 let micolor = this.hexToRgb(this.color);
	 let alturaletra = 15;

	 document.querySelector(this.selector).appendChild(lienzo);

	 // Cálculo de totales y longitud
	 let total = 0;                                          // Arranco total a cero
	 this.datos.forEach(function(dato) {                     // Para cada un de los datos
		  total += dato.valor;                                // Actualizo el total
	 });

	 // Ahora si, dibujamos quesos
	 let anguloinicial = 0;                                  // Creo un angulo inicial que obviamente vale 0

	 this.datos.forEach(function(dato) {                     // Para cada uno de los quesos
		  let r = micolor[0] + Math.round((Math.random() - 0.5) * variacioncolor); // Creo un rojo aleatorio
		  let g = micolor[1] + Math.round((Math.random() - 0.5) * variacioncolor); // Creo un verde aleatorio
		  let b = micolor[2] + Math.round((Math.random() - 0.5) * variacioncolor); // Creo un azul aleatorio
		  let angulofinal = (dato.valor / total) * Math.PI * 2; // Calculo el porcentaje de angulo final
		  /////////////// QUESO
		  contexto.fillStyle = "rgb(" + r + "," + g + "," + b + ")"; // Pinto el queso
		  contexto.beginPath();                                     // Arranco el dibujo
		  contexto.moveTo(anchura / 2, altura / 2);                 // Muevo el cursor hasta el centro
		  contexto.arc(
			   anchura / 2,
			   altura / 2,
			   anchura / 2 - 50,
			   anguloinicial,
			   anguloinicial + angulofinal
		  );                                                        // Dibujo un circulo
		  contexto.lineTo(anchura / 2, altura / 2);                 // Vuelvo al centro
		  contexto.fill();                                          // Lo relleno de color
		  ///////////// TEXTO QUESO LEYENDA
		  let angulotexto = anguloinicial + angulofinal / 2;
		  contexto.textAlign = "center";
		  contexto.fillStyle = "white";
		  contexto.fillText(
			   dato.texto,
			   anchura / 2 + Math.cos(angulotexto) * (anchura / 2 - 50) / 2,
			   altura / 2 + Math.sin(angulotexto) * (anchura / 2 - 50) / 2 - alturaletra
		  );
		  ///////////// TEXTO QUESO TOTAL
		  angulotexto = anguloinicial + angulofinal / 2;
		  contexto.textAlign = "center";
		  contexto.fillStyle = "white";
		  contexto.fillText(
			   dato.valor,
			   anchura / 2 + Math.cos(angulotexto) * (anchura / 2 - 50) / 2,
			   altura / 2 + Math.sin(angulotexto) * (anchura / 2 - 50) / 2
		  );
		  ///////////// TEXTO QUESO PORCENTAJE
		  angulotexto = anguloinicial + angulofinal / 2;
		  contexto.textAlign = "center";
		  contexto.fillStyle = "white";
		  contexto.fillText(
			   (dato.valor / total).toFixed(2) + " %",
			   anchura / 2 + Math.cos(angulotexto) * (anchura / 2 - 50) / 2,
			   altura / 2 + Math.sin(angulotexto) * (anchura / 2 - 50) / 2 + alturaletra
		  );
		  anguloinicial += angulofinal;                      // Actualizo el cursor
	 });
}

anillo() {
	 // Condiciones iniciales
	 let anchura = 512;                                      // Anchura del lienzo
	 let altura = 512;                                       // Altura del lienzo
	 let lienzo = document.createElement("canvas");         // Selecciono el lienzo
	 lienzo.width = anchura;                                 // Le pongo la anchura
	 lienzo.height = altura;                                // Le pongo la altura
	 //lienzo.style.border = "1px solid grey";                // Un poco de estilo
	 let contexto = lienzo.getContext("2d");                // creo un contexto en el que dibujar
	 let variacioncolor = 100;
	 let micolor = this.hexToRgb(this.color);
	 let alturaletra = 20;
	 let misupercolor = this.color
	 let misupertitulo = this.titulo
	 contexto.font = "20px sans-serif"

	 document.querySelector(this.selector).appendChild(lienzo);

	 // Cálculo de totales y longitud
	 let total = 0;                                          // Arranco total a cero
	 this.datos.forEach(function(dato) {                     // Para cada un de los datos
		  total += dato.valor;                                // Actualizo el total
	 });
	
	 // Ahora si, dibujamos quesos
	 let anguloinicial = 0;                                  // Creo un angulo inicial que obviamente vale 0
		
	 this.datos.forEach(function(dato) {                     // Para cada uno de los quesos
		  let r = micolor[0] + Math.round((Math.random() - 0.5) * variacioncolor); // Creo un rojo aleatorio
		  let g = micolor[1] + Math.round((Math.random() - 0.5) * variacioncolor); // Creo un verde aleatorio
		  let b = micolor[2] + Math.round((Math.random() - 0.5) * variacioncolor); // Creo un azul aleatorio
		  let angulofinal = (dato.valor / total) * Math.PI * 2; // Calculo el porcentaje de angulo final
		  /////////////// QUESO
		  contexto.fillStyle = "rgb(" + r + "," + g + "," + b + ")"; // Pinto el queso
		  contexto.beginPath();                                     // Arranco el dibujo
		  contexto.moveTo(anchura / 2, altura / 2);                 // Muevo el cursor hasta el centro
		  contexto.arc(
			   anchura / 2,
			   altura / 2,
			   anchura / 2 - 50,
			   anguloinicial,
			   anguloinicial + angulofinal
		  );                                                        // Dibujo un circulo
		  contexto.lineTo(anchura / 2, altura / 2);                 // Vuelvo al centro
		  contexto.fill();                                          // Lo relleno de color
		  ///////////// TEXTO QUESO LEYENDA
		  let angulotexto = anguloinicial + angulofinal / 2;
		  contexto.textAlign = "center";
		  contexto.fillStyle = "white";
		  contexto.fillText(
			   dato.texto,
			   anchura / 2 + Math.cos(angulotexto) * (anchura / 2 +20) / 2,
			   altura / 2 + Math.sin(angulotexto) * (anchura / 2 +20) / 2 - alturaletra
		  );
		  ///////////// TEXTO QUESO TOTAL
		  angulotexto = anguloinicial + angulofinal / 2;
		  contexto.textAlign = "center";
		  contexto.fillStyle = "white";
		  contexto.fillText(
			   dato.valor,
			   anchura / 2 + Math.cos(angulotexto) * (anchura / 2 +20) / 2,
			   altura / 2 + Math.sin(angulotexto) * (anchura / 2 +20) / 2
		  );
		  ///////////// TEXTO QUESO PORCENTAJE
		  angulotexto = anguloinicial + angulofinal / 2;
		  contexto.textAlign = "center";
		  contexto.fillStyle = "white";
		  contexto.fillText(
			   (dato.valor / total).toFixed(2) + " %",
			   anchura / 2 + Math.cos(angulotexto) * (anchura / 2 +20) / 2,
			   altura / 2 + Math.sin(angulotexto) * (anchura / 2 +20) / 2 + alturaletra
		  );
		  ///////////// TEXTO TITULO
		  contexto.textAlign = "center";
		  contexto.fillStyle = misupercolor;
		  contexto.fillText(misupertitulo,anchura/2,alturaletra)
		  anguloinicial += angulofinal;                      // Actualizo el cursor
	 });
	 contexto.fillStyle = "white"
	 contexto.beginPath()
	 contexto.arc(anchura/2,altura/2,100,0,Math.PI*2)
	 contexto.fill()
}

// Método auxiliar corregido
hexToRgb(hex) {
	 // Elimina el '#' si está presente
	 hex = hex.replace(/^#/, '');

	 // Divide los valores hexadecimales
	 let bigint = parseInt(hex, 16);
	 let r = (bigint >> 16) & 255;
	 let g = (bigint >> 8) & 255;
	 let b = bigint & 255;

	 return [r, g, b];
}

}
