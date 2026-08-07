const formTicket = document.getElementById("formTicket");

if (formTicket) {
    formTicket.addEventListener("submit", function (e) {
        const titulo = document.getElementById("titulo").value.trim();
        const descripcion = document.getElementById("descripcion").value.trim();
        const departamento = document.getElementById("departamento").value.trim();

        if (titulo === "" || descripcion === "" || departamento === "") {
            e.preventDefault();
            alert("Por favor completa todos los campos obligatorios.");
        }
    });
}