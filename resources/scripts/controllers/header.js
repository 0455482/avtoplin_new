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

app.controller('headerCtrl', function ($scope, $rootScope, $location, $cookies, $route) {
    $scope.settingsActive = $cookies.get('settingsActive');
    if ($scope.settingsActive == "false")
        $scope.settingsActive = false;
    else
        $scope.settingsActive = true;

    $scope.dashboard = function() {
        $scope.settingsActive = false;
        $cookies.put('settingsActive', $scope.settingsActive);
    }

    $scope.settings = function() {
        $scope.settingsActive = !$scope.settingsActive;
        $cookies.put('settingsActive', $scope.settingsActive);
    }

    $scope.statistics = function() {
        $scope.settingsActive = false;
        $cookies.put('settingsActive', $scope.settingsActive);
    }

    $scope.usersActive = function() {
        $rootScope.settingsElement = 0;
        $rootScope.$broadcast("settingsElementChanged");
    }
    $scope.statusesActive = function() {
        $rootScope.settingsElement = 1;
        $rootScope.$broadcast("settingsElementChanged");
    }
    $scope.smsActive = function() {
        $rootScope.settingsElement = 2;
        $rootScope.$broadcast("settingsElementChanged");
    }
    $scope.offerActive = function() {
        $rootScope.settingsElement = 3;
        $rootScope.$broadcast("settingsElementChanged");
    }
});
