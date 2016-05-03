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

app.controller('settingsCtrl', function ($scope, $mdMedia, $mdDialog, $log, updateURL, parseGetParams, GetDataService, $rootScope) { 
        //initialization defaults
        $scope.users = {};
        $scope.statuses = {};
        $scope.sms = {};
        $scope.loading = false;
        $scope.selectedIndex = 0;
        var getParams = {};
        $scope.tabs = [
            { title: 'Uporabniki', count: 0},
            { title: 'Statusi', count: 1},
            { title: 'SMS', count: 2},
            { title: 'Ponudba', count: 3}
        ];
        $scope.tab_val = 'Statusi';                            
        //init settings data
        //makes call to api for init data 
        //return all users data
        $scope.initData = function() {
                $scope.loading = true;
                getParams = parseGetParams.parse();
                if(!getParams.filter) {
                        GetDataService.get('Settings/init').then(function(result) {
                                $scope.users     = result.data.users;
                                $scope.user_type = result.data.user_type; 
                                $scope.loading = false;
                        });
                } else {
                        $scope.switchTab(getParams.filter);
                        $scope.selectedIndex = getIndexForStatus(getParams.filter);
                }
        }
        
        //switch tabs on settings
        //@@input parameter is tab value == status
        //in order to stay on the same tab on refresh this method 
        //modifies the url, and adds the tab status
        //makes call to api and returns the selected tab data
        $scope.switchTab = function(tab_val) {
                switch(tab_val) {
                        case 'SMS': 
                        $scope.loading = true;
                        GetDataService.get('Settings/getAllSmsTemplates').then(function(result) {
                                if(result.data) {
                                        $scope.sms = result.data;
                                        getParams.filter = tab_val;
                                        updateURL.update(getParams, '/settings');
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
                        case 'Uporabniki': 
                        $scope.loading = true;
                        GetDataService.get('Settings/getAllUsers').then(function(result) {
                                if(result.data) {
                                        $scope.users = result.data;
                                        getParams.filter = tab_val;
                                        updateURL.update(getParams, '/settings');
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
                        case 'Statusi':
                        $scope.loading = true;
                        GetDataService.get('Settings/getAllStatuses').then(function(result) {
                                if(result.data) {
                                        $scope.statuses = result.data;
                                        getParams.filter = tab_val;
                                        updateURL.update(getParams, '/settings');
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
                        case 'Ponudba': 
                        $scope.loading = true;
                        GetDataService.get('Settings/getOfferParameters').then(function(result) {
                                if(result.data) {
                                        $scope.engines = result.data.engines;
                                        $scope.discounts = result.data.discounts;
                                        $scope.installments = result.data.installments;
                                        getParams.filter = tab_val;
                                        updateURL.update(getParams, '/settings');
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
        
        $scope.showAdvanced = function(val) {
                $scope.loading = true;
                GetDataService.post('Settings/getUserDetails', {
                        user_id: val.user_id
                }).then(function(result) {
                        $mdDialog.show({
                                controller: 'editUserInstanceCtrl',
                                templateUrl: 'editUserModal.html',
                                parent: angular.element(document.body),
                                clickOutsideToClose: true,
                                resolve: {
                                        user: function () {
                                                return result.data;
                                        }
                                }
                        })
                        .then(function(answer) {
                                $scope.initData();
                        });
                        $scope.loading = false;
                });
        };
        
        $scope.showCreateModal= function() {
                $mdDialog.show({
                        controller: 'createUserModalInstanceCtrl',
                        templateUrl: 'createUserModal.html',
                        parent: angular.element(document.body),
                        clickOutsideToClose: true
                })
                .then(function() {
                        $scope.initData();
                });
        };
        
        $scope.showColorsModal = function(status) {
                $mdDialog.show({
                        controller: 'colorsModalInstanceCtrl',
                        templateUrl: 'colorModalContent.html',
                        parent: angular.element(document.body),
                        clickOutsideToClose: true,
                        resolve: {
                                status: function() {
                                        return status;
                                }
                        }
                })
                .then(function() {
                        $scope.switchTab('Statuse');
                });
        }
        
        $scope.showEditSMSModal = function(sms_id) {
                $scope.loading = true;
                GetDataService.post('Settings/getSmsTemplateDetails', {
                        id: sms_id
                }).then(function(result) {
                        $mdDialog.show({
                                controller: 'editSMSModalInstanceCtrl',
                                templateUrl: 'SMSModalContent.html',
                                parent: angular.element(document.body),
                                clickOutsideToClose: true,
                                resolve: {
                                        sms: function() {
                                                return result.data;
                                        }
                                }
                        })
                        .then(function() {
                                $scope.switchTab('SMS');
                        });
                        $scope.loading = false;
                });
        }
        
        $scope.showCreateSMSModal = function() {
                $mdDialog.show({
                        controller: 'createSMSModalInstanceCtrl',
                        templateUrl: 'SMSModalContent.html',
                        parent: angular.element(document.body),
                        clickOutsideToClose: true
                })
                .then(function() {
                        $scope.switchTab('SMS');
                });
        }

        // function for showing SMS history modal
        $scope.showSMSHistoryModal = function() {
            $mdDialog.show({
                    controller: 'showSMSHistoryModalInstanceCtrl',
                    templateUrl: 'showSMSHistoryModalContent.html',
                    parent: angular.element(document.body),
                    clickOutsideToClose: true
            })
            .then(function() {
                    $scope.switchTab('SMS');
            });
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
        
        // function with input param status
        // returns index number
        function getIndexForStatus(status) {
            var index = 0;
            switch (status) {
                case 'Uporabniki':
                    index = 0;
                    break;
                case 'Statuse':
                    index = 1;
                    break;
                case 'SMS':
                    index = 2;
                    break;
                case 'Ponudba':
                    index = 3;
                    break;
            }
            return index;
        }
});

app.controller('editUserInstanceCtrl', function ($scope, $mdDialog, user, GetDataService, $rootScope) {
    $scope.types = ['admin', 'regular'];
    $scope.active = [{status: 'Active', id: 1}, {status: 'Inactive', id: 0}];   
    $scope.user = angular.copy(user);
    
    $scope.updateUser = function(edit_user) {
        $scope.loading = true;
        GetDataService.post('Settings/editUser', {
                user: edit_user
        }).then(function(result) {
                $mdDialog.hide();
                $scope.loading = false;
                $rootScope.showAlert('userEditSuccess');
        });
    }
    $scope.hide = function() {
        $mdDialog.hide();
    };
    $scope.cancel = function() {
        $mdDialog.cancel();
    };
});

app.controller('createUserModalInstanceCtrl', function ($scope, $mdDialog, GetDataService, $rootScope) {
    $scope.types = ['admin', 'regular'];
    $scope.active = [{status: 'Active', id: 1}, {status: 'Inactive', id: 0}];
    $scope.newUser = {};
    
    $scope.createUser = function(new_user) {
        $scope.loading = true;
        GetDataService.post('Settings/createUser', {
                user: new_user
        }).then(function(result) {
                $mdDialog.hide();
                $scope.loading = false;
                $rootScope.showAlert('userCreateSuccess');
        });
    }
    
    $scope.hide = function() {
        $mdDialog.hide();
    };
    $scope.cancel = function() {
        $mdDialog.cancel();
    };
});

app.controller('colorsModalInstanceCtrl', function ($scope, status, $mdDialog, GetDataService, $rootScope) {
    $scope.color = angular.copy(status.color);
    $scope.changeColor = function(color) {
            $scope.loading = true;
            GetDataService.post('Settings/setStatusColor', {
                id: status.id,
                color: $scope.color
            }).then(function(result) {
                $mdDialog.hide();
                $scope.loading = false;
                $rootScope.showAlert('colorChangeSuccess');
            });
    }
    $scope.hide = function() {
        $mdDialog.hide();
    };
    $scope.cancel = function() {
        $mdDialog.cancel();
    };
});

app.controller('editSMSModalInstanceCtrl', function ($scope, sms, $mdDialog, GetDataService, $rootScope) {
    $scope.naslov = 'Uredi SMS';
    $scope.types = [{status: 'Active', id: 1}, {status: 'Inactive', id: 0}];
    $scope.sms = angular.copy(sms);
    $scope.edit_createSMS = function(sms) {
            $scope.loading = true;
            GetDataService.post('Settings/editSmsTemplate', {
                sms: sms,
            }).then(function(result) {
                if(result.data) {
                        $mdDialog.hide();
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
    }
    $scope.hide = function() {
        $mdDialog.hide();
    };
    $scope.cancel = function() {
        $mdDialog.cancel();
    };
});

app.controller('createSMSModalInstanceCtrl', function ($scope, $mdDialog, GetDataService, $rootScope) {
    $scope.naslov = 'Ustvari SMS';
    $scope.types = [{status: 'Active', id: 1}, {status: 'Inactive', id: 0}];
    $scope.edit_createSMS = function(sms) {
            $scope.loading = true;
            GetDataService.post('Settings/createSmsTemplate', {
                sms: sms,
            }).then(function(result) {
                if(result.data) {
                        $mdDialog.hide();
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
    }
    $scope.hide = function() {
        $mdDialog.hide();
    };
    $scope.cancel = function() {
        $mdDialog.cancel();
    };
});

/**
 * Controller for showing SMS history
 */
app.controller('showSMSHistoryModalInstanceCtrl', function ($scope, $mdDialog, GetDataService, $rootScope) {
    //init show sms history modal data
    //return sms history
    $scope.initData = function() {
        $scope.getSMSs();
    }

    //function for getting sms history
    $scope.getSMSs = function() {
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
    }

    $scope.hide = function() {
        $mdDialog.hide();
    };
    $scope.cancel = function() {
        $mdDialog.cancel();
    };
});