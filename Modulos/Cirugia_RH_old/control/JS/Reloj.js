function setFechaActual() {
    const fechaInput = document.getElementById('Fecha');
    
    if (fechaInput) {
        const today = new Date();
        const year = today.getFullYear();
        const month = String(today.getMonth() + 1).padStart(2, '0'); // Mes comienza en 0, se le suma 1
        const day = String(today.getDate()).padStart(2, '0');
        
        const fechaActual = `${year}-${month}-${day}`; // Formato yyyy-mm-dd
        fechaInput.value = fechaActual;
    } else {
        console.error('El input con id "Fecha" no existe.');
    }
}

// Llamar al método para que se ejecute cuando se cargue la página
window.onload = setFechaActual;
