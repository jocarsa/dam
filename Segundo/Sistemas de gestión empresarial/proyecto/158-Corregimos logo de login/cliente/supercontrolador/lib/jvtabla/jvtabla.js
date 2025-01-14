function initializeTableSorting(table) {
    let contenido = []; // Superarray vacio
    let indices = []; // Lista de indices
    let cabeceras = table.querySelectorAll("thead tr th"); // Cargo las cabeceras
    
    cabeceras.forEach(function (cabecera, colIndex) {
        indices.push(cabecera.textContent.trim()); // Añade cabeceras a los indices
        cabecera.onclick = function () { // Evento click para ordenar
            console.log("Vamos a ordenar según la columna: " + cabecera.textContent);
            table.querySelector("tbody").innerHTML = ""; // Vacia el cuerpo
            contenido.sort(function (a, b) { // Ordena el array
                let valA = a[indices[colIndex]].toLowerCase();
                let valB = b[indices[colIndex]].toLowerCase();
                if (!isNaN(valA) && !isNaN(valB)) {
                    valA = parseFloat(valA);
                    valB = parseFloat(valB);
                }
                return valA > valB ? 1 : valA < valB ? -1 : 0;
            });
            poblarTabla();
        };
    });

    // Ahora vamos con los datos
    let registros = table.querySelectorAll("tbody tr");
    registros.forEach(function (registro) {
        let linea = {}; // Objeto vacio por fila
        let celdas = registro.querySelectorAll("td");
        celdas.forEach(function (celda, index) {
            linea[indices[index]] = celda.textContent.trim();
        });
        contenido.push(linea); // Añade la fila al superarray
    });

    console.log(contenido);
    poblarTabla();

    function poblarTabla() {
        table.querySelector("thead tr").innerHTML = ""; // Limpia cabeceras
        let cabezal1 = document.createElement("th");
        cabezal1.textContent = "N°";
        table.querySelector("thead tr").appendChild(cabezal1);

        indices.forEach(function (campo, colIndex) {
            let cabezal = document.createElement("th");
            cabezal.textContent = campo;
            table.querySelector("thead tr").appendChild(cabezal);

            cabezal.onclick = function () { // Evento click para reordenar
                console.log("Vamos a ordenar según la columna: " + cabezal.textContent);
                table.querySelector("tbody").innerHTML = ""; // Vacia el cuerpo
                contenido.sort(function (a, b) {
                    let valA = a[indices[colIndex]].toLowerCase();
                    let valB = b[indices[colIndex]].toLowerCase();
                    if (!isNaN(valA) && !isNaN(valB)) {
                        valA = parseFloat(valA);
                        valB = parseFloat(valB);
                    }
                    return valA > valB ? 1 : valA < valB ? -1 : 0;
                });
                poblarTabla();
            };
        });

        table.querySelector("tbody").innerHTML = ""; // Limpia el cuerpo
        let contador = 1;
        contenido.forEach(function (linea) {
            let fila = document.createElement("tr");
            let celda1 = document.createElement("td");
            celda1.textContent = contador;
            fila.appendChild(celda1);
            contador++;

            indices.forEach(function (campo) {
                let celda = document.createElement("td");
                celda.textContent = linea[campo];
                fila.appendChild(celda);
            });
            table.querySelector("tbody").appendChild(fila);
        });
    }
}

// Inicializa las tablas actuales
document.querySelectorAll(".jvtabla").forEach(initializeTableSorting);

// Observa nuevos elementos en el DOM
const observer = new MutationObserver(function (mutations) {
    mutations.forEach(function (mutation) {
        mutation.addedNodes.forEach(function (node) {
            if (node.nodeType === 1 && node.classList.contains("jvtabla")) {
                initializeTableSorting(node);
            }
        });
    });
});

observer.observe(document.body, {
    childList: true,
    subtree: true,
});

