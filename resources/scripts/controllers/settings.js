app.run(function($rootScope, notification) {
    $rootScope.statuses = '';
    $rootScope.show = false;

    $rootScope.closeAlert = function() {
        $rootScope.show = false;
    }

    $rootScope.showAlert = function(id) {
        $rootScope.show = true;
        $rootScope.alert = notification.get(id);
    }
})

app.controller('settingsCtrl', function ($scope, $log, updateURL, parseGetParams, GetDataService, $rootScope, $uibModal) {
    //initialization defaults
    var getParams = {};

    $scope.initData = function() {
        $scope.loading = true;
        getParams = parseGetParams.parse();
        if(!getParams.element) {
            GetDataService.get('Settings/init').then(function(result) {
                $scope.users     = result.data.users;
                if (result.data.user_type == "admin")
                    $scope.user_type = true;
                else
                    $scope.user_type = false;
                $scope.selectedIndex = 0;
                $scope.loading = false;
            });
        } else {
            $scope.selectedIndex = parseInt(getParams.element);
            $scope.switchTab($scope.selectedIndex);
        }

        $scope.$on("settingsElementChanged", function () {
            $scope.selectedIndex = $rootScope.settingsElement;
            getParams.element = $scope.selectedIndex;
            updateURL.update(getParams, '/settings');
            $scope.switchTab($scope.selectedIndex);
        });
    }

    //@@input parameter is tab value == status
    //in order to stay on the same tab on refresh this method
    //modifies the url, and adds the tab status
    //makes call to api and returns the selected tab data
    $scope.switchTab = function(elementId) {
        switch(elementId) {
            case 0:
                $scope.loading = true;
                GetDataService.get('Settings/getAllUsers').then(function(result) {
                    if(result.data) {
                        $scope.users = result.data;
                        $scope.loading = false;
                    } else {
                        $scope.loading = false;
                        $rootScope.showAlert('badRequest');
                    }
                }, function errorCallback(response) {
                    if(response.status != 200) {
                        $scope.loading = false;
                        $rootScope.showAlert('badRequest');
                    }
                });
                $scope.loading = true;
                GetDataService.get('Settings/init').then(function(result) {
                    if (result.data.user_type == "admin")
                        $scope.user_type = true;
                    else
                        $scope.user_type = false;
                    $scope.loading = false;
                });
                break;
            case 1:
                $scope.loading = true;
                GetDataService.get('Settings/getAllStatuses').then(function(result) {
                    if(result.data) {
                        $scope.statuses = result.data;
                        $scope.loading = false;
                    } else {
                        $scope.loading = false;
                        $rootScope.showAlert('badRequest');
                    }
                }, function errorCallback(response) {
                    if(response.status != 200) {
                        $scope.loading = false;
                        $rootScope.showAlert('badRequest');
                    }
                });
                break;
            case 2:
                $scope.loading = true;
                GetDataService.get('Settings/getAllSmsTemplates').then(function(result) {
                    if(result.data) {
                        $scope.sms = result.data;
                        $scope.loading = false;
                    } else {
                        $scope.loading = false;
                        $rootScope.showAlert('badRequest');
                    }
                }, function errorCallback(response) {
                    if(response.status != 200) {
                        $scope.loading = false;
                        $rootScope.showAlert('badRequest');
                    }
                });
                $scope.loading = true;
                GetDataService.post('Settings/getSmsHistory', {
                }).then(function(result) {
                    if (result.data) {
                        $scope.loading = false;
                        $scope.smss = result.data;
                    } else {
                        $scope.loading = false;
                        toast.show('badRequest', 'top');
                    }
                }, function errorCallback(response) {
                    if(response.status != 200) {
                        $scope.loading = false;
                        toast.show('badRequest', 'top');
                    }
                });
                break;
            case 3:
                $scope.loading = true;
                GetDataService.get('Settings/getOfferParameters').then(function(result) {
                    if(result.data) {
                        $scope.engines = result.data.engines;
                        $scope.discounts = result.data.discounts;
                        $scope.installments = result.data.installments;
                        $scope.loading = false;
                    } else {
                        $scope.loading = false;
                        $rootScope.showAlert('badRequest');
                    }
                }, function errorCallback(response) {
                    if(response.status != 200) {
                        $scope.loading = false;
                        $rootScope.showAlert('badRequest');
                    }
                });
                break;
        }
    }

    $scope.saveEngine = function(engine, dis, install) {
        $scope.loading = true;
        GetDataService.post('Settings/changeOfferParameters', {
            engine: angular.copy(engine),
            discounts: angular.copy(dis),
            installments: angular.copy(install)
        }).then(function(result) {
            $scope.loading = false;
            $rootScope.showAlert('offerSuccess');
        });
    }

    $scope.showAdvanced = function(val) {
        $scope.loading = true;
        GetDataService.post('Settings/getUserDetails', {
            user_id: val.user_id
        }).then(function(result) {
            var modalInstance = $uibModal.open({
                controller: 'editUserInstanceCtrl',
                templateUrl: 'createUserModal.html',
                resolve: {
                    user: function () {
                        return result.data;
                    }
                }
            });
            modalInstance.result.then(function (id) {
                $scope.initData();
            }, function () {
            });
            $scope.loading = false;
        });

    };

    $scope.showCreateModal = function() {
        var modalInstance = $uibModal.open({
            controller: 'createUserModalInstanceCtrl',
            templateUrl: 'createUserModal.html',
        });
        modalInstance.result.then(function (id) {
            $scope.initData();
        }, function () {
        });
    };


    $scope.showCreateSMSModal = function() {
        var modalInstance = $uibModal.open({
            templateUrl: 'SMSModalContent.html',
            controller: 'createSMSModalInstanceCtrl'
        });
        modalInstance.result.then(function (id) {
            $scope.switchTab(2);
        }, function () {
        });
    }

    $scope.showEditSMSModal = function(sms_id) {
        $scope.loading = true;
        GetDataService.post('Settings/getSmsTemplateDetails', {
            id: sms_id
        }).then(function(result) {
            var modalInstance = $uibModal.open({
                controller: 'editSMSModalInstanceCtrl',
                templateUrl: 'SMSModalContent.html',
                resolve: {
                    sms: function() {
                        return result.data;
                    }
                }
            });
            modalInstance.result.then(function (id) {
                $scope.switchTab(2);
            }, function () {
            });
            $scope.loading = false;
        });
    }

    $scope.showColorsModal = function(status) {
        var modalInstance = $uibModal.open({
            controller: 'colorsModalInstanceCtrl',
            templateUrl: 'colorModalContent.html',
            resolve: {
                status: function() {
                    return status;
                }
            }
        });
        modalInstance.result.then(function (id) {
            $scope.switchTab(1);
        }, function () {
        });
    }
});

app.controller('editUserInstanceCtrl', function ($scope, $uibModalInstance, user, GetDataService, $rootScope) {
    $scope.title = "Uredi uporabnik";
    $scope.user = angular.copy(user);

    $scope.ok = function () {
        $scope.loading = true;
        GetDataService.post('Settings/editUser', {
            user: $scope.user
        }).then(function(result) {
            $uibModalInstance.close(1);
            $scope.loading = false;
            $rootScope.showAlert('userEditSuccess');
        });
    };

    $scope.cancel = function () {
        $uibModalInstance.dismiss('cancel');
    };
});

app.controller('createUserModalInstanceCtrl', function ($scope, $uibModalInstance, GetDataService, $rootScope) {
    $scope.title = "Dodaj uporabnik";
    $scope.user = {};

    $scope.ok = function () {
        $scope.loading = true;
        GetDataService.post('Settings/createUser', {
            user: $scope.user
        }).then(function(result) {
            $uibModalInstance.close(1);
            $scope.loading = false;
            $rootScope.showAlert('userCreateSuccess');
        });
    };

    $scope.cancel = function () {
        $uibModalInstance.dismiss('cancel');
    };
});

app.controller('editSMSModalInstanceCtrl', function ($scope, sms, $uibModalInstance, GetDataService, $rootScope) {
    $scope.title = "Uredi SMS";
    $scope.sms = angular.copy(sms);
    $scope.sms.active = parseInt($scope.sms.active);

    $scope.ok = function () {
        $scope.loading = true;
        GetDataService.post('Settings/editSmsTemplate', {
            sms: $scope.sms,
        }).then(function(result) {
            if(result.data) {
                $uibModalInstance.close(1);
                $scope.loading = false;
                $rootScope.showAlert('smsEditSuccess');
            } else {
                $scope.loading = false;
                $rootScope.showAlert('badRequest');
            }
        }, function errorCallback(response) {
            if(response.status != 200) {
                $scope.loading = false;
                $rootScope.showAlert('badRequest');
            }
        });
    };

    $scope.cancel = function () {
        $uibModalInstance.dismiss('cancel');
    };
});

app.controller('colorsModalInstanceCtrl', function ($scope, status, $uibModalInstance, GetDataService, $rootScope) {
    $scope.color = angular.copy(status.color);

    $scope.ok = function () {
        $scope.loading = true;
        GetDataService.post('Settings/setStatusColor', {
            id: status.id,
            color: $scope.color
        }).then(function(result) {
            $uibModalInstance.close(1);
            $scope.loading = false;
            $rootScope.showAlert('colorChangeSuccess');
        });
    };

    $scope.cancel = function () {
        $uibModalInstance.dismiss('cancel');
    };
});

app.controller('createSMSModalInstanceCtrl', function ($scope, GetDataService, $rootScope, $uibModalInstance) {
    $scope.sms = {};
    $scope.title = "Ustvari SMS";

    $scope.ok = function () {
        $scope.loading = true;
        GetDataService.post('Settings/createSmsTemplate', {
            sms: $scope.sms,
        }).then(function(result) {
            if(result.data) {
                $uibModalInstance.close(1);
                $scope.loading = false;
                $rootScope.showAlert('smsCreateSuccess');
            } else {
                $scope.loading = false;
                $rootScope.showAlert('badRequest');
            }
        }, function errorCallback(response) {
            if(response.status != 200) {
                $scope.loading = false;
                $rootScope.showAlert('badRequest');
            }
        });
    };

    $scope.cancel = function () {
        $uibModalInstance.dismiss('cancel');
    };
});
