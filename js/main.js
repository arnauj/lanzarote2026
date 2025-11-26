
function showLoading() {
    loading.style.display = 'block';
}
// Función para ocultar la imagen de carga
function hideLoading() {
    loading.style.display = 'none';
}

function fetchJSON(url,modo="") {
    showLoading(); // Mostrar loading


    let ventanaModalLabel     = document.getElementById('ventanaModalLabel');
    let contenidoVentanaModal = document.getElementById('contenidoVentanaModal');
    let formData = '';

    if (modo == 'formulario')
    {
        let formulario = document.getElementById("formGeneral");
        formData = new FormData(formulario);
    }


    fetch(url,{
        method: 'POST'
       ,body: formData
    }).then(response => {
        if (!response.ok) {
            throw new Error(`Error HTTP: ${response.status}`);
        }
        return response.json(); // Convertir respuesta a JSON
    })
    .then(data => {

        ventanaModalLabel.innerHTML = data.titulo;
        contenidoVentanaModal.innerHTML = data.contenido;
    })
    .catch(error => {
        ventanaModalLabel.innerHTML = 'Error insesperado';
        contenidoVentanaModal.innerHTML = `<p style="color: red;">Error:
        ${error.message}</p>`;
    })
    .finally(() => {
        hideLoading(); // Ocultar loading
    });
}