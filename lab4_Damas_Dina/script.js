
const formulario     = document.getElementById("formEquipo");

const codigo         = document.getElementById("codigo");
const nombre         = document.getElementById("nombre");
const categoria      = document.getElementById("categoria");
const precio         = document.getElementById("precio");

const errorCodigo    = document.getElementById("errorCodigo");
const errorNombre    = document.getElementById("errorNombre");
const errorCategoria = document.getElementById("errorCategoria");
const errorPrecio    = document.getElementById("errorPrecio");

const tabla          = document.getElementById("tablaEquipos");
const contador       = document.getElementById("contador");
const limpiar        = document.getElementById("limpiarTabla");

let total = 0;


function limpiarErrores() {
    errorCodigo.textContent    = "";
    errorNombre.textContent    = "";
    errorCategoria.textContent = "";
    errorPrecio.textContent    = "";
}


formulario.addEventListener("submit", function (e) {
    e.preventDefault();
    limpiarErrores();

    let valido = true;

    
    const regexCodigo = /^E\d+$/;


    if (!regexCodigo.test(codigo.value.trim())) {
        errorCodigo.textContent = "El código debe empezar con 'E' seguido de números (Ej: E001).";
        valido = false;
    }

  if(nombre.value.trim().length<5){

        errorMarca.textContent="Ingrese mínimo 5 caracteres";
        valido=false;

    }

    if (categoria.value === "") {
        errorCategoria.textContent = " Debe seleccionar una categoría.";
        valido = false;
    }


    const precioNum = parseFloat(precio.value);
    if (precio.value === "" || isNaN(precioNum) || precioNum <= 0) {
        errorPrecio.textContent = "El precio debe ser un valor mayor que cero.";
        valido = false;
    }

    if (!valido) return;

    
    total++;

    const fila = document.createElement("tr");
    fila.innerHTML = `
        <td>${total}</td>
     <td>${codigo.value}</td>
        <td>${nombre.value}</td>
        <td>${categoria.value}</td>
        <td>${precio.value}</td>
    `;

    tabla.appendChild(fila);


    contador.textContent = total;
    formulario.reset();

});


limpiar.addEventListener("click", function () {
    if (confirm(" desea eliminar todos los equipos registrados?")) {
        tabla.innerHTML = "";
        total = 0;
        contador.textContent = 0;
    }
});
