app.controller('navigationCtrl', function ($scope, parseGetPage, $rootScope, $location, $http) { 

    $scope.getCurTabSelected = function() {
         $scope.tab_selected = parseGetPage.parse();
    }
    if(loged_this_week == 0) {
        $mdDialog.show({
            controller: 'logedModalInstanceCtrl',
            templateUrl: 'loged_this_week.html',
            clickOutsideToClose: true
        });
    }
});

app.controller('logedModalInstanceCtrl', function ($scope, $mdDialog) {
    $scope.cancel = function() {
        $mdDialog.cancel();
    };
});
