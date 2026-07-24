<!DOCTYPE html>
<html ng-app="appTareas">
<head>
    <meta charset="UTF-8">
    <title>Mis Tareas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.8.2/angular.min.js"></script>
</head>
<body ng-controller="TareasController" class="bg-light">

<div class="container py-5">
    <div class="card shadow" style="max-width: 500px; margin: auto;">
        <div class="card-body">
            <h1 class="card-title text-center mb-4">Lista de Tareas</h1>

            <div class="input-group mb-3">
                <input type="text" class="form-control" ng-model="nuevaTarea" placeholder="Escribe una tarea...">
                <button class="btn btn-success" ng-click="agregarTarea()" ng-disabled="agregando">Agregar</button>
            </div>

            <p ng-if="tareas.length == 0" class="text-muted text-center">No hay tareas pendientes.</p>

            <ul class="list-group">
                <li class="list-group-item d-flex justify-content-between align-items-center" ng-repeat="t in tareas">
                    @{{ t.titulo }}
                    <button class="btn btn-danger btn-sm" ng-click="borrarTarea(t.id)">X</button>
                </li>
            </ul>
        </div>
    </div>
</div>

<script src="/js/tareas.js"></script>

</body>
</html>
