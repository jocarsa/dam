let textos = document.querySelectorAll("textarea")
console.log("tengo",textos.length,"textareas")
textos.forEach(function(textarea){
   let nuevocontenedor = document.createElement("div")
   nuevocontenedor.setAttribute("class","jvwysiwyg")
   textarea.replaceWith(nuevocontenedor)
   nuevocontenedor.appendChild(textarea)
   textarea.style.display = "none"

   let botonera = document.createElement("div")
   botonera.classList.add("botonera")
   nuevocontenedor.appendChild(botonera)

   let botonnegrita = document.createElement("button")
   botonnegrita.innerHTML = "<b>B</b>"
   botonnegrita.setAttribute("css", "font-weight");
   botonera.appendChild(botonnegrita)
   botonnegrita.onclick = function(){ reemplaza("font-weight", "bold") };

   let botonitalica = document.createElement("button")
   botonitalica.innerHTML = "<i>i</i>"
   botonitalica.setAttribute("css", "font-style");
   botonera.appendChild(botonitalica)
   botonitalica.onclick = function(){ reemplaza("font-style", "italic") };

   let botonsubrayado = document.createElement("button")
   botonsubrayado.innerHTML = "<u>u</u>"
   botonsubrayado.setAttribute("css", "text-decoration");
   botonera.appendChild(botonsubrayado)
   botonsubrayado.onclick = function(){ reemplaza("text-decoration", "underline") };

   let colorfrente = document.createElement("input")
   colorfrente.setAttribute("type","color")
   colorfrente.setAttribute("css","color")
   botonera.appendChild(colorfrente)
   colorfrente.oninput = function() { reemplaza("color", colorfrente.value); };

   let tamaniofuente = document.createElement("select")
   tamaniofuente.setAttribute("css","font-size")
   let tamanios = [10,12,14,16,18,20]
   tamanios.forEach(function(tamanio){
       let opcion = document.createElement("option")
       opcion.textContent = tamanio
       opcion.value = tamanio + "px"
       tamaniofuente.appendChild(opcion)
   })
   botonera.appendChild(tamaniofuente)
   tamaniofuente.onchange = function() { reemplaza("font-size", tamaniofuente.value); };

   let mieditor = document.createElement("div")
   mieditor.classList.add("editor")
   nuevocontenedor.appendChild(mieditor)
   mieditor.setAttribute("contenteditable","true")

   mieditor.onkeypress = function(){actualizaTextarea()}

   function actualizaTextarea(){
       let contenido = mieditor.innerHTML
       textarea.textContent = contenido
   }

   function reemplaza(cssProperty, value) {
       let selectedText = window.getSelection().toString();

       if (selectedText.length > 0) {
           let range = window.getSelection().getRangeAt(0);
           let styledElement = document.createElement("span");
           styledElement.style[cssProperty] = value;
           styledElement.textContent = selectedText;
           range.deleteContents();
           range.insertNode(styledElement);
       }

       actualizaTextarea();
   }
})
