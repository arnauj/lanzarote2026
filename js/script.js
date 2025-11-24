
const loading = document.getElementById('loading');
const result = document.getElementById('result');
// Función para mostrar la imagen de carga
function showLoading() {
    loading.style.display = 'block';
}
// Función para ocultar la imagen de carga
function hideLoading() {
    loading.style.display = 'none';
}

function fetchJSON() {
    showLoading(); // Mostrar loading
    fetch('server-json.php').then(response => {
        if (!response.ok) {
            throw new Error(`Error HTTP: ${response.status}`);
        }
        return response.json(); // Convertir respuesta a JSON
    })
    .then(data => {
        result.innerHTML = `
            <p>Mensaje: ${data.mensaje}</p>
            <p>Fecha: ${data.fecha}</p>
        `;
    })
    .catch(error => {
        result.innerHTML = `<p style="color: red;">Error:
        ${error.message}</p>`;
    })
    .finally(() => {
        hideLoading(); // Ocultar loading
    });
}


function fetchText() {
    showLoading(); // Mostrar loading

fetch('/mi-endpoint');

    fetch('server-text.php', {
        method: 'POST',
        body: formData // El objeto FormData contiene los datos del
    }).then(response => {
        if (!response.ok) {
            throw new Error(`Error HTTP: ${response.status}`);
        }
        return response.text(); // Convertir respuesta a texto
    })
    .then(data => {
        result.innerHTML = `<p>${data}</p>`;
    })
    .catch(error => {
        result.innerHTML = `<p style="color: red;">Error:
        ${error.message}</p>`;
    })
    .finally(() => {
        hideLoading(); // Ocultar loading
    });
}