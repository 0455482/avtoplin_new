app.controller('loginCtrl', function ($scope, $rootScope, $routeParams, $location, $http) { 
    $scope.fail = false;
    if(validation_url == 0) {
        $scope.fail = true;
        $rootScope.showAlert('badUserPass', 'top');
    }
});