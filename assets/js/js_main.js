// console.log("Y vos que haces aquí?"); // Verificacion de urls en consola"


// -------------------------------Exportar Usuarios a Excel y PDF--------------------------------
function exportarxls() {

    var table = document.getElementById("data_table");
    var wb = XLSX.utils.table_to_book(table, { sheet: "Usuarios" });
    XLSX.writeFile(wb, "usuarios.xlsx");
}

function exportarPDF() {
    const { jsPDF } = window.jspdf;
    var doc = new jsPDF();

    // ------------------------ (logo de empresa)
    var img = document.getElementById("logo_empresa");
    if (img) {
        // x, y, width, height
        doc.addImage(img, 'jpeg', 90, 5, 30, 30); // centrado horizontal aproximado
    }

    // ------------------------Título
    doc.setFontSize(16);
    doc.text("Gestión de usuarios", 105, 38, { align: "center" });

    var table = document.getElementById("data_table");
    var rows = table.rows;
    let startX = 10;
    let startY = 40;
    // Solo las primeras 5 columnas (Ícono, Nombre, Email, Rol, Estado)
    let cellWidth = [8, 45, 40, 50, 50];
    let cellHeight = 10;
    let numCols = cellWidth.length; // Solo exporta  columnas necesarias

    // ------------------------Encabezados
    doc.setFontSize(12);
    let x = startX;
    for (let j = 0; j < numCols; j++) {
        doc.text(rows[0].cells[j].innerText, x + 2, startY + 7);
        doc.rect(x, startY, cellWidth[j], cellHeight);
        x += cellWidth[j];
    }

    // ----------------------Filas de datos
    for (let i = 1; i < rows.length; i++) {
        x = startX;
        for (let j = 0; j < numCols; j++) {
            doc.text(rows[i].cells[j].innerText, x + 2, startY + 7 + cellHeight * i);
            doc.rect(x, startY + cellHeight * i, cellWidth[j], cellHeight);
            x += cellWidth[j];
        }
    }

    doc.save('usuarios.pdf');
}

// -------------------------------Exportar Células a Excel y PDF--------------------------------
function exportarxls_ce() {
    var table = document.getElementById("data_table");
    var wb = XLSX.utils.table_to_book(table, { sheet: "Células" });
    XLSX.writeFile(wb, "celulas.xlsx");


}

function exportarPDF_ce() {
    const { jsPDF } = window.jspdf;
    var doc = new jsPDF('l', 'mm', 'a4'); // L= Horizontal

    // ------------------------ (logo de empresa)
    var img = document.getElementById("logo_empresa");
    if (img) {
        // x, y, width, height
        doc.addImage(img, 'jpeg', 135, 5, 30, 30); // centrado horizontal aproximado
    }
    // ------------------------ Título
    doc.setFontSize(16);
    doc.text("Gestión de células", 148, 38, { align: "center" });

    var table = document.getElementById("data_table");
    var rows = table.rows;
    let startX = 10;
    let startY = 41;
    let cellWidth = [10, 60, 45, 60, 25, 25, 47];
    let cellHeight = 10;
    let numCols = cellWidth.length;

    // Preparar encabezados (soporta multi-línea)
    doc.setFontSize(12);
    let headerSplits = [];
    let headerMaxLines = 1;
    for (let j = 0; j < numCols; j++) {
        let headerText = rows[0].cells[j].innerText.trim();
        let split = doc.splitTextToSize(headerText, cellWidth[j] - 4);
        headerSplits.push(split);
        if (split.length > headerMaxLines) headerMaxLines = split.length;
    }
    let headerHeight = cellHeight * headerMaxLines;

    // función para dibujar encabezados en una posición Y dada
    function drawHeaders(yPos) {
        let xh = startX;
        doc.setFontSize(12);
        for (let j = 0; j < numCols; j++) {
            doc.rect(xh, yPos, cellWidth[j], headerHeight);
            doc.text(headerSplits[j], xh + 2, yPos + 6);
            xh += cellWidth[j];
        }
    }

    // dibujar encabezados en la primera página
    drawHeaders(startY);

    // Filas de datos (ajuste de texto y altura dinámica) con salto de página
    let y = startY + headerHeight;
    let pageHeight = doc.internal.pageSize.getHeight();
    let bottomMargin = 12;

    for (let i = 1; i < rows.length; i++) {
        let x = startX;
        let maxLines = 1;
        let splitTexts = [];

        // Calcula el máximo de líneas para la fila
        for (let j = 0; j < numCols; j++) {
            let text = rows[i].cells[j].innerText;
            let splitText = doc.splitTextToSize(text, cellWidth[j] - 4);
            splitTexts.push(splitText);
            if (splitText.length > maxLines) maxLines = splitText.length;
        }
        let rowHeight = cellHeight * maxLines;

        // Si no cabe en la página, agregar nueva página y redibujar encabezados
        if (y + rowHeight > pageHeight - bottomMargin) {
            doc.addPage();
            // (opcional) si quieres volver a dibujar logo/título en páginas nuevas añádelo aquí
            drawHeaders(startY);
            y = startY + headerHeight;
            x = startX;
        }

        // Dibuja las celdas y el texto
        for (let j = 0; j < numCols; j++) {
            doc.rect(x, y, cellWidth[j], rowHeight);
            doc.text(splitTexts[j], x + 2, y + 6);
            x += cellWidth[j];
        }
        y += rowHeight;
    }

    doc.save('celulas.pdf');
}

// -------------------------------Exportar Ministerios a Excel y PDF--------------------------------
function exportarxls_mi() {
    var table = document.getElementById("data_table");
    var wb = XLSX.utils.table_to_book(table, { sheet: "Ministerios" });
    XLSX.writeFile(wb, "ministerios.xlsx");
}

function exportarPDF_mi() {
    const { jsPDF } = window.jspdf;
    var doc = new jsPDF('p', 'mm', 'a4'); // P = vertical (portrait)

    // ------------------------ (logo de empresa)
    var img = document.getElementById("logo_empresa");
    if (img) {
        doc.addImage(img, 'jpeg', 90, 5, 30, 30);
    }

    // ------------------------ Título
    doc.setFontSize(16);
    doc.text("Gestión de ministerios", 105, 38, { align: "center" });

    var table = document.getElementById("data_table");
    var rows = table.rows;

    // Dimensiones base
    let startY = 45; // espacio por logo/título
    let cellWidth = [10, 75, 85];
    let cellHeight = 10;
    let numCols = cellWidth.length;
    let tableWidth = cellWidth.reduce((a, b) => a + b, 0);

    // Centrar horizontalmente
    let pageWidth = doc.internal.pageSize.getWidth();
    let startX = (pageWidth - tableWidth) / 2;

    // Preparar encabezados (soporta multi línea)
    doc.setFontSize(12);
    let headerSplits = [];
    let headerMaxLines = 1;
    for (let j = 0; j < numCols; j++) {
        let headerText = rows[0].cells[j].innerText.trim();
        let split = doc.splitTextToSize(headerText, cellWidth[j] - 4);
        headerSplits.push(split);
        if (split.length > headerMaxLines) headerMaxLines = split.length;
    }
    let headerHeight = cellHeight * headerMaxLines;

    // Función para dibujar encabezados en una posición Y dada
    function drawHeaders(yPos) {
        let xh = startX;
        doc.setFontSize(12);
        for (let j = 0; j < numCols; j++) {
            doc.rect(xh, yPos, cellWidth[j], headerHeight);
            doc.text(headerSplits[j], xh + 2, yPos + 6);
            xh += cellWidth[j];
        }
    }

    // dibujar encabezados en la primera página
    drawHeaders(startY);

    // Filas
    let y = startY + headerHeight;
    for (let i = 1; i < rows.length; i++) {
        let x = startX;
        let maxLines = 1;
        let splitTexts = [];

        // calcular líneas por celda
        for (let j = 0; j < numCols; j++) {
            let text = rows[i].cells[j].innerText.trim();
            let splitText = doc.splitTextToSize(text, cellWidth[j] - 4);
            splitTexts.push(splitText);
            if (splitText.length > maxLines) maxLines = splitText.length;
        }

        let rowHeight = cellHeight * maxLines;

        // comprobar salto de página
        let pageHeight = doc.internal.pageSize.getHeight();
        let bottomMargin = 20;
        if (y + rowHeight > pageHeight - bottomMargin) {
            doc.addPage();
            // volver a dibujar encabezados en la nueva página
            drawHeaders(startY);
            y = startY + headerHeight;
            x = startX;
        }

        // dibujar celdas y texto
        for (let j = 0; j < numCols; j++) {
            doc.rect(x, y, cellWidth[j], rowHeight);
            doc.text(splitTexts[j], x + 2, y + 6);
            x += cellWidth[j];
        }

        y += rowHeight;
    }

    // ------------------------ Guardar Miembros Excel-----------------------------------------------------
    doc.save('ministerios.pdf');
}

// -------------------------------Guardar Miembros PDF--------------------------------
// Exportar Miembros a Excel y PDF
function exportarxls_mie() {
    var table = document.getElementById("data_table");
    var wb = XLSX.utils.table_to_book(table, { sheet: "Miembros" });
    XLSX.writeFile(wb, "miembros.xlsx");
}

    function exportarPDF_mie() {
    const { jsPDF } = window.jspdf;
    var doc = new jsPDF('l', 'mm', 'legal'); // L= Horizontal   

    // ------------------------ (logo de empresa)
    var img = document.getElementById("logo_empresa");
    if (img) {
        // x, y, width, height
        doc.addImage(img, 'jpeg', 164, 5, 30, 30); // centrado horizontal aproximado
    }

    // ------------------------Título
    doc.setFontSize(16);
    doc.text("Gestión de miembros", 180, 38, { align: "center" });// centrado en horizontal

    var table = document.getElementById("data_table");
    var rows = table.rows;
    let startX = 10;
    let startY = 41;
    let cellWidth = [10, 75, 30, 25, 15, 30, 30, 30, 30, 55];
    let cellHeight = 10;
    let numCols = cellWidth.length;

    // ------------------------Preparar encabezados y calcular altura necesaria
    doc.setFontSize(12);
    let headerSplits = [];
    let headerMaxLines = 1;
    for (let j = 0; j < numCols; j++) {
        let headerText = rows[0].cells[j].innerText.trim();
        // dividir el texto del encabezado al ancho de la celda (restar padding)
        let split = doc.splitTextToSize(headerText, cellWidth[j] - 4);
        headerSplits.push(split);
        if (split.length > headerMaxLines) headerMaxLines = split.length;
    }
    let headerHeight = cellHeight * headerMaxLines;

    // ------------------------Dibujar encabezados (multi-línea)
    let x = startX;
    for (let j = 0; j < numCols; j++) {
        doc.rect(x, startY, cellWidth[j], headerHeight);
        // doc.text acepta array y los imprime en líneas consecutivas
        doc.text(headerSplits[j], x + 2, startY + 6); // 6 mm aprox como primer baseline
        x += cellWidth[j];
    }

    // ----------------------Filas de datos (con ajuste de texto)
    let y = startY + headerHeight;
    for (let i = 1; i < rows.length; i++) {
        x = startX;
        let maxLines = 1;
        let splitTexts = [];

        // Calcular número máximo de líneas por fila
        for (let j = 0; j < numCols; j++) {
            let text = rows[i].cells[j].innerText.trim();
            let splitText = doc.splitTextToSize(text, cellWidth[j] - 4);
            splitTexts.push(splitText);
            if (splitText.length > maxLines) maxLines = splitText.length;
        }

        let rowHeight = cellHeight * maxLines;

        // Si se sale de la página, agregar nueva página y repetir encabezados
        let pageHeight = doc.internal.pageSize.getHeight();
        if (y + rowHeight > pageHeight - 20) { // margen inferior
            doc.addPage();
            // repetir encabezados en nueva página
            y = 20; // nuevo startY en la página
            x = startX;
            // asegurar tamaño de fuente para encabezados en la nueva página
            doc.setFontSize(12);
            for (let j = 0; j < numCols; j++) {
                doc.rect(x, y, cellWidth[j], headerHeight);
                doc.text(headerSplits[j], x + 2, y + 6);
                x += cellWidth[j];
            }
            y += headerHeight;
            // IMPORTANT: volver a posicionar X al inicio de la tabla antes de dibujar la fila
            x = startX;
        }

        // Dibujar celdas y texto
        for (let j = 0; j < numCols; j++) {
            doc.rect(x, y, cellWidth[j], rowHeight);
            doc.text(splitTexts[j], x + 2, y + 6);
            x += cellWidth[j];
        }

        y += rowHeight;
    }

    doc.save('miembros.pdf');
}