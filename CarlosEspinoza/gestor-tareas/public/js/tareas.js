var app = angular.module('appTareas', []);

app.controller('TareasController', function($scope, $http) {
    function cargarTareas() {
        $http.get('/api/tareas').then(function(res) {
            $scope.tareas = res.data;
        });
    }

    $scope.agregarTarea = function() {
        if (!$scope.nuevaTarea) return;
        $scope.agregando = true;
        $http.post('/api/tareas', { titulo: $scope.nuevaTarea }).then(function() {
            $scope.nuevaTarea = '';
            cargarTareas();
        }).finally(function() {
            $scope.agregando = false;
        });
    };

    $scope.borrarTarea = function(id) {
        $http.delete('/api/tareas/' + id).then(function() {
            cargarTareas();
        });
    };

    cargarTareas();
});
