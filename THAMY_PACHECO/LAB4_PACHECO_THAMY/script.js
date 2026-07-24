const formulario = document.getElementById("formEquipo");

const codigo = document.getElementById("CODIGO");
const nombre = document.getElementById("NOMBRE");
const categoria = document.getElementById("CATEGORIA");
const precio = document.getElementById("PRECIO");

const errorcodigo = document.getElementById("errorCODIGO");
const errornombre = document.getElementById("errorNOMBRE");
const errorcategoria = document.getElementById("errorCATEGORIA");
const errorprecio = document.getElementById("errorPRECIO");

const tabla = document.getElementById("tablaEquipos");
const contador = document.getElementById("CONTADOR");
const limpiar = document.getElementById("limpiarTABLA");

let total = 0;

function LimpiarErrores(){
    errorcodigo.textContent="";
    errornombre.textContent="";
    errorcategoria.textContent="";
    errorprecio.textContent="";
}

formulario.addEventListener("submit",function(e){
    e.preventDefault();

    LimpiarErrores();
    let valido = true;
    let regex = /^E\d+$/;

    if(!regex.test(codigo.value.trim())){
        errorcodigo.textContent="DEBE DE INICIAR CON LA LETRA E SEGUIDA DE NÚMEROS.";
        valido=false;
    }

    if(nombre.value.trim().length<5){
        errornombre.textContent="INGRESE UN NOMBRE";
        valido=false;
    }

    if(categoria.value===""){
        errorcategoria.textContent="SELECCIONES UNA CATEGORÍA.";
        valido=false;
    }

    if(precio.value==="" || Number(precio.value)<=0){
        errorprecio.textContent="EL PRECIO DEBE SER MAYOR QUE CERO.";
        valido=false;
    }

    if(!valido){
        return;
    }

    const fila=document.createElement("tr");
    fila.innerHTML=`<td>${codigo.value}</td> <td>${nombre.value}</td>
    <td>${categoria.value}</td> <td>L. ${parseFloat(precio.value).toFixed(2)}</td>`;

    tabla.appendChild(fila);
    total++;
    contador.textContent=total;
    formulario.reset();

});

limpiar.addEventListener("click",function(){

    if(confirm("¿DESEA ELIMINAR TODOS LOS REGISTROS?")){
        tabla.innerHTML="";
        total=0;
        contador.textContent=0;
    }
});