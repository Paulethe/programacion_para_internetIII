<!DOCTYPE html>
<html lang="es" ng-app="todoApp" class="notranslate" translate="no">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Tareas</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.8.2/angular.min.js"></script>
</head>
<body ng-controller="todoController" class="bg-light d-flex align-items-center justify-content-center" style="min-height: 100vh; margin: 0;">

    <div class="container" style="max-width: 550px;">
        <div class="card shadow-sm border-0 rounded-4 p-4">
            
            <h1 class="text-center fw-bold text-dark mb-4">Tareas Pendientes</h1>
            
            <div class="input-group mb-4 shadow-sm rounded">
                <input type="text" class="form-control border-secondary-subtle p-2" 
                       placeholder="Escribe una tarea..." 
                       ng-model="nuevaTarea.titulo">
                <button class="btn px-4 notranslate fw-bold" type="button" ng-click="agregarTarea()">
                    Agregar
                </button>
            </div>

          <div class="card shadow-sm rounded-4 p-4" style="border: 1px solid lightgray; max-width: 550px; background-color: white;">
                <ul class="list-group list-group-flush rounded-3 border">
                    <li class="list-group-item d-flex justify-content-between align-items-center p-3" ng-repeat="tarea in tareas">
                        <span class="text-dark fs-5">@{{ tarea.titulo }}</span>
                      
                    </li>
                    
                    <li class="list-group-item text-center text-muted py-4 fs-6" ng-if="tareas.length === 0">
                        No hay tareas pendientes.
                    </li>
                </ul>
            </div>

        </div>
    </div>

    <script>
        var app = angular.module('todoApp', []);

        app.controller('todoController', function($scope, $http) {
            $scope.tareas = [];
            $scope.nuevaTarea = { titulo: '' };

            var tokenElement = document.querySelector('meta[name="csrf-token"]');
            if (tokenElement) {
                $http.defaults.headers.common['X-CSRF-TOKEN'] = tokenElement.getAttribute('content');
            }

            $scope.obtenerTareas = function() {
                $http.get('/api/tareas')
                    .then(function(response) {
                        $scope.tareas = response.data;
                    }, function(error) {
                        console.error('Error al obtener tareas:', error);
                    });
            };

            $scope.agregarTarea = function() {
                if (!$scope.nuevaTarea.titulo || $scope.nuevaTarea.titulo.trim() === '') {
                    alert('¡Por favor escribe una tarea válida!');
                    return;
                }

                var datosEnvio = { titulo: $scope.nuevaTarea.titulo };

                $http.post('/api/tareas', datosEnvio)
                    .then(function(response) {
                        if (response.data && response.data.tarea) {
                            $scope.tareas.push(response.data.tarea);
                        } else {
                            $scope.obtenerTareas(); 
                        }
                        $scope.nuevaTarea.titulo = ''; 
                    }, function(error) {
                        console.error('Error al guardar la tarea:', error);
                        alert('Error al conectar con el servidor.');
                    });
            };

            $scope.obtenerTareas();
        });
    </script>

</body>
</html>