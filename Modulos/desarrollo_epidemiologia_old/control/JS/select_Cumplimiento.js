// FUNCIONES PARA CREAR EL SELECT DINAMICO EN CADA CASILLA DE LA COLUMNA 
function createSelect(rowIndex, cellIndex) {
    return `<select class="response" data-row-index="${rowIndex}" data-cell-index="${cellIndex}" style="width:97px;">
                <option value="" disabled selected hidden></option>
                <option value="si" style="font-weight: bold; color:green;">SI</option>
                <option value="no" style="font-weight: bold; color:red;">NO</option>
                <option value="NA">NO APLICA</option>
            </select>`;
}

// Inicializa las tablas
const tables = document.querySelectorAll('table');
tables.forEach(table => {
    const rows = table.querySelectorAll('tr');
    rows.forEach((row, rowIndex) => {
        if (rowIndex === rows.length - 1) return; // Ignora el último <tr>
        const cells = row.querySelectorAll('td');
        cells.forEach((cell, cellIndex) => {
            if (cellIndex === 0) return; // Ignora el primer <td>
            cell.innerHTML = createSelect(rowIndex, cellIndex);
        });
    });
});

// Para cambiar colores al seleccionar una opción
document.querySelectorAll('.response').forEach(select => {
    select.addEventListener('change', function(event) {
        const selectedOption = this.options[this.selectedIndex];
        if (selectedOption.value === "si") {
            this.style.color = "green";
            this.style.fontWeight = "bold";
            this.style.backgroundColor = "#DFF2BF"; 
        } else if (selectedOption.value === "no") {
            this.style.color = "red";
            this.style.fontWeight = "bold";
            this.style.backgroundColor = "#FFBABA"; 
        } else if (selectedOption.value === "NA") {
            this.style.color = "black";
            this.style.fontWeight = "bold"; 
            this.style.backgroundColor = "white";
        }

        // Obtener la celda y tabla para calcular el cumplimiento
        const td = event.target.closest('td');
        const colIndex = Array.from(td.parentNode.children).indexOf(td);
        const table = td.closest('table'); // Identifica la tabla actual

        calcularCumplimiento(colIndex, table);
    });
});

// FUNCION PARA EL LLENADO DEL CAMPO CUMPLIMIENTO
function calcularCumplimiento(colIndex, table) {
    const rows = table.querySelectorAll('tr');
    let allYes = true;
    let hasNo = false;
    let allNA=true;
    let allFilled = true; // Bandera para verificar si todos los selectores están llenos

    rows.forEach((row, rowIndex) => {
        if (rowIndex === rows.length - 1 || row.id === 'exclude-row') return; // Ignora la última fila

        const cells = row.querySelectorAll('td');
        if (cells.length > colIndex) {
            const cell = cells[colIndex];
            const selectInCell = cell.querySelector('select.response');

            if (selectInCell) {
                if (selectInCell.value === 'no') {
                    hasNo = true;
                    allNA = false;
                    allYes=false;

                } else if (selectInCell.value === 'si') {

                    allNA = false;

                } else if (selectInCell.value !== 'NA') {
                    allYes=false;
                }
                // Verifica si algún select está vacío
                if (!selectInCell.value) {
                    allFilled = false;
                }
            }
        }
    });

    // Si todos los selectores están llenos, habilitar el cumplimiento
    const complianceCell = rows[rows.length - 1].querySelectorAll('td')[colIndex];
    if (complianceCell && allFilled) {
        if (allNA){
            complianceCell.style.color = "black";
            complianceCell.textContent = 'NO APLICA';
            complianceCell.fontWeight = "bold";
        }
        else if (hasNo) {
            complianceCell.style.color = "red";
            complianceCell.textContent = 'NO';
            complianceCell.fontWeight = "bold";
        } else {
            complianceCell.style.color = "green";
            complianceCell.textContent = 'SI';
        }
    }
}
