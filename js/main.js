
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



function fetchHTML(url,id,modo="") {
    showLoading(); // Mostrar loading


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
        return response.text(); // Convertir respuesta a TEXT
    })
    .then(data => {
        id.innerHTML = data;
    })
    .catch(error => {
        id.innerHTML = `<p style="color: red;">Error insesperado<br />Error:
        ${error.message}</p>`;
    })
    .finally(() => {
        hideLoading(); // Ocultar loading
    });
}


document.querySelector("#idcalendario_curso").addEventListener("change", (evento) => {

    fetchHTML('/calendario/'+ evento.target.value, document.getElementById('place_calendario'));






});