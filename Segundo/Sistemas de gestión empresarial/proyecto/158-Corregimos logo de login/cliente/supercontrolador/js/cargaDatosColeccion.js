function cargaDatosColeccion(coleccion) {
    console.log("Voy a cargar los datos de la colección");
    document.querySelector("table").innerHTML = ""; // Limpiar contenido previo

    fetch("../../servidor/?o=listadocumentos&coleccion=" + coleccion)
        .then(response => response.json()) // Convertir respuesta a JSON
        .then(datos => {
            console.log(datos);
            document.querySelector("table").style.display = "block";

            datos.forEach((dato) => {
                const articleHTML = renderJSONToHTML(dato);

                // Add a delete button to each article
                const articleElement = `
                    <article 
                        class="clickable-article" 
                        data-content='${JSON.stringify(dato)}'
                        style="border: 1px solid #ccc; margin: 10px; padding: 10px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); cursor: pointer;">
                        ${articleHTML}
                        <button 
                            class="delete-button" 
                            data-id="${dato._id['$oid'] || dato._id}" 
                            data-coleccion="${coleccion}"
                            style="background-color: red; color: white; border: none; padding: 5px 10px; margin-top: 10px; cursor: pointer;">
                            Eliminar
                        </button>
                    </article>
                `;
                document.querySelector("table").innerHTML += articleElement;
            });

            // Add click event listeners to articles
            document.querySelectorAll(".clickable-article").forEach(article => {
                article.addEventListener("click", function () {
                    const dataContent = JSON.parse(this.getAttribute("data-content"));
                    openModal(dataContent);
                });
            });

            // Add click event listeners to delete buttons
            document.querySelectorAll(".delete-button").forEach(button => {
                button.addEventListener("click", function (e) {
                    e.stopPropagation(); // Prevent triggering article click
                    const documentId = this.getAttribute("data-id");
                    const collectionName = this.getAttribute("data-coleccion");
                    eliminarDocumento(collectionName, documentId);
                });
            });
        });
}
// Function to render JSON to HTML (same as before)
function renderJSONToHTML(json) {
    if (typeof json !== "object" || json === null) {
        return `<span>${json}</span>`; // Simple values
    }

    if (Array.isArray(json)) {
        return `
            <ul style="list-style-type: square; margin-left: 20px;">
                ${json.map(item => `<li>${renderJSONToHTML(item)}</li>`).join("")}
            </ul>
        `;
    }

    return `
        <div style="margin-left: 10px;">
            ${Object.entries(json).map(([key, value]) => `
                <div style="margin-bottom: 8px;">
                    <strong style="color: #333;">${key}:</strong> ${renderJSONToHTML(value)}
                </div>
            `).join("")}
        </div>
    `;
}
// Function to send delete request
function eliminarDocumento(coleccion, id) {
    fetch(`../../servidor/?o=eliminadocumento&coleccion=${coleccion}&id=${id}`, {
        method: "DELETE",
    })
        .then(response => response.json())
        .then(data => {
            console.log("Resultado de eliminación:", data);
            if (data.deletedCount > 0) {
                alert("Documento eliminado correctamente.");
                cargaDatosColeccion(coleccion); // Reload data
            } else {
                alert("Error al eliminar el documento.");
            }
        })
        .catch(error => {
            console.error("Error:", error);
        });
}

