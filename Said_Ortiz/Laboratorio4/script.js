    const formulario = document.getElementById("formEquipo");

    const codigo = document.getElementById("codigo");
    const nombre = document.getElementById("nombre");
    const categoria = document.getElementById("categoria");
    const precio = document.getElementById("precio");

    const errorCodigo = document.getElementById("errorCodigo");
    const errorNombre = document.getElementById("errorNombre");
    const errorCategoria = document.getElementById("errorCategoria");
    const errorPrecio = document.getElementById("errorPrecio");
    
    const tabla = document.getElementById("tablaEquipos");
    const contador = document.getElementById("contador");
    const limpiar = document.getElementById("limpiarTabla");


    let totalEquipos = 0;

    function limpiarErrores(){
        errorCodigo.textContent="";
        errorNombre.textContent="";
        errorCategoria.textContent="";
        errorPrecio.textContent="";
    }

    formulario.addEventListener("submit",function(e){
        
        e.preventDefault();

        limpiarErrores();

        let valido=true;

        let regex=/^E\d+$/;

        if(!regex.test(codigo.value.trim())){

            errorCodigo.textContent="Formato valido: E001";
            valido=false;
        }

        if(nombre.value.trim().length<5){
            errorNombre.textContent="Ingrese minimo 5 caracteres";
            valido=false;
        }

        if(categoria.value===""){
            errorCategoria.textContent="Seleccione una Categoria";
            valido=false;
        }

        if(precio.value==="" || Number(precio.value)<=0){
            errorPrecio.textContent="El precio debe ser mayor que cero";
            valido=false;
        }

        if(!valido){
            return;
        }

        const fila=document.createElement("tr");

        fila.innerHTML=`
            <td>${codigo.value}</td>
            <td>${nombre.value}</td>
            <td>${categoria.value}</td>
            <td>L. ${Number(precio.value).toFixed(2)}</td>
        `;
        
        tabla.appendChild(fila);

        totalEquipos++;

        contador.textContent=totalEquipos;

        formulario.reset();
    });

    limpiar.addEventListener("click", function(){
        if(confirm("¿Desea eliminar todos los registros?")){
            tabla.innerHTML="";

            totalEquipos=0;

            contador.textContent=0;
        }
    });
