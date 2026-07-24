var app = angular.module("app", []);

app.controller("TareaController", function ($scope, $http) {
    $scope.tareas = [];

    // cargar la lista de tareas
    $scope.cargar = function () {
        $http.get("http://127.0.0.1:8000/api/tareas")
            .then(function (response) {
                $scope.tareas = response.data; 
            })
            .catch(function (error) {
                console.error("Error al cargar las tareas:", error);
            });
    };

    // guardar una nueva tarea
    $scope.guardar = function () {
        console.log("Enviando tarea: ", $scope.titulo);

        $http.post("http://127.0.0.1:8000/api/tareas", {
            titulo: $scope.titulo
        })
        .then(function (response) {
            alert("Datos guardados: " + JSON.stringify(response.data));
            $scope.titulo = "";
            $scope.cargar();
        })
        .catch(function (error) {
            alert("Hubo un error al conectar con Laravel Código: " + error.status);
            console.error("Detalle del error:", error);
        });
    };

    // eliminar una tarea
    $scope.eliminar = function (id) {
        if (confirm("¿Estás seguro de que deseas eliminar esta tarea?")) {
            $http.delete("http://127.0.0.1:8000/api/tareas/" + id)
            .then(function (response) {
                alert(response.data.mensaje || "Tarea eliminada con éxito");
                $scope.cargar();
            })
            .catch(function (error) {
                alert("No se pudo eliminar la tarea. Código: " + error.status);
                console.error("Detalle del error al eliminar:", error);
            });
        }
    };

    
    $scope.cargar(); 
});
