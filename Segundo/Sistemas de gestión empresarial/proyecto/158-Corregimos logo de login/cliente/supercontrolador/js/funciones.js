function renderTable(assocArray) {
         let table = `<table class='jvtabla'>`;
         table += `<thead><tr><th>Key</th><th>Value</th></tr></thead>`;
         table += `<tbody>`;

         for (const key in assocArray) {
             table += `<tr><td>${key}</td><td>${assocArray[key]}</td></tr>`;
         }

         table += `</tbody></table>`;
         return table;
     }
