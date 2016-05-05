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

app.controller('dashboardCtrl', function ($scope, $http, $location, $uibModal, $log, GetDataService, updateURL, parseGetParams, getIndexForStatus, $rootScope) {
    //defaults on init
    $scope.tab = 'Neobdelano';
    $scope.statuses = '';
    $scope.thumbnails = '';
    $scope.colorRows = {};
    $scope.curDateOd = {};
    $scope.curDateDo = {};
    $scope.quick_text = '';
    $scope.loading = false;
    $scope.pagination = {};
    $scope.tab_status_id = 1;
    $scope.pagination.start_item = 1;
    $scope.pagination.numPerPage = 20;
    var getParams = {};
    $scope.selectedOrdersCount = 0;
    $scope.selectedOrders = {};

    //var ctrl = this;
    //$scope.redirectToStatus = null;

    //init dashboard data
    //makes call to api for init data
    //return page data
    $scope.initData = function() {
            GetDataService.get('Dashboard/init').then(function(result) {
            $scope.statuses = result.data.statuses;
            console.log($scope.statuses);
            ($scope.tab_status_id > 8) ? $scope.color = '#0466A7' : $scope.color = $scope.statuses[$scope.tab_status_id - 1].color;
            $rootScope.statuses = result.data.statuses;
            $scope.thumbnails = result.data.box_stats;
        }, function errorCallback(response) {
            if(	response.status != 200) {
                $scope.loading = false;
                $rootScope.showAlert('badRequest');
            }
        });
        getParams = parseGetParams.parse();
        getParams.filter ? getParams.filter : getParams.filter = $scope.tab;
        $scope.tab = getParams.filter;
        $scope.tab_status_id = getIndexForStatus.getIndex(getParams.filter);
        $scope.dt = getParams.dateFrom ? new Date(getParams.dateFrom * 1) : '';
        $scope.dm = getParams.dateTo ? new Date(getParams.dateTo * 1) : '';
        $scope.quick_text = getParams.quick_text;
        if (getParams.filter == 'Vse') {
             $scope.search = true;
             $scope.color = "#0466A7";
        } else {
            $scope.search = false;
        }
        countFilteredOrders();
        getFilteredOrders();
    }

    //seting the input date to the selected date
    $scope.$watch('dt', function(newValue) {
     $scope.curDateOd.date = newValue;
     $scope.curDateOd.timestamp = new Date($scope.curDateOd.date).getTime();
 }, true);
    //seting the input date to the selected date
    $scope.$watch('dm', function(newValue) {
     $scope.curDateDo.date = newValue;
     $scope.curDateDo.timestamp = new Date($scope.curDateDo.date).getTime();
 }, true);
    //selecting a order in the main table
    $scope.$watch('rows', function(rows){
        var counter = 0;
        var orders = [];
        angular.forEach(rows, function(row){
            if (row.selected) {
                counter++;
                orders.push(row.id);
            }
        })
        $scope.selectedOrdersCount = counter;
        $scope.selectedOrders = angular.copy(orders);
    }, true);

    //switch tabs on dashboard
    //@@input parameter is tab value == status
    //in order to stay on the same tab on refresh this method
    //modifies the url, and adds the tab status
    //makes call to api and returns the selected tab data
    $scope.switchTab = function(tab_val) {
        $scope.loading = true;
        $scope.tab = tab_val;
        $scope.checkedAll = false;
        $scope.pagination.start_item = 1;
        $scope.pagination.numPerPage = 20;
        getParams.filter = tab_val;
        $scope.tab_status_id = getIndexForStatus.getIndex(getParams.filter);
        ($scope.tab_status_id <= 8) ? $scope.color = $scope.statuses[$scope.tab_status_id - 1].color : $scope.color = '#0466A7';
        updateURL.update(getParams, '/dashboard');
        countFilteredOrders();
        getFilteredOrders();
    }

    //function for showing date picker from
    //and setting todays date if the scope is clear
    $scope.showOd = function() {
        if(!$scope.curDateOd.date) {
            $scope.curDateOd.date = new Date();
            $scope.curDateOd.timestamp = new Date().getTime();
        }
        if($scope.curDateDo.date && $scope.curDateOd.date) {
            getParams.dateFrom = $scope.curDateOd.timestamp;
            getParams.dateTo = $scope.curDateDo.timestamp;
            updateURL.update(getParams, '/dashboard');
            countFilteredOrders();
            getFilteredOrders();
        }
    }
    //function for showing date picker to
    //and setting todays date if the scope is clear
    $scope.showDo = function() {
        if(!$scope.curDateDo.date) {
            $scope.curDateDo.date = new Date();
            $scope.curDateDo.timestamp = new Date().getTime();
        }
        if($scope.curDateDo.date && $scope.curDateOd.date) {
            getParams.dateFrom = $scope.curDateOd.timestamp;
            getParams.dateTo = $scope.curDateDo.timestamp;
            updateURL.update(getParams, '/dashboard');
            countFilteredOrders();
            getFilteredOrders();
        }
    }

    //search function makes call to api with search text and all initializing parameters
    //we get data for this parameters
    $scope.setSearch = function(text) {
        getParams.quick_text = text;
        updateURL.update(getParams, '/dashboard');
        $scope.switchTab('Vse');
        $scope.search = true;
        $scope.color = "#0466A7";
        countFilteredOrders();
        getFilteredOrders();
    }

    //function for next page pagination... first we check if the number of data
    //is biger than our max data number per page, than if the number of all data
    //is greater we incremet our variable, and the start item variable
    //than we make call to api with all our initializing variables and the from variable
    //than we get data for that page
    $scope.pagination.nextPage = function() {
        if($scope.pagination.all_data > $scope.pagination.numPerPage) {
            $scope.loading = true;
            if($scope.pagination.all_data > ($scope.pagination.numPerPage + 20)) {
                $scope.pagination.start_item += 20;
                $scope.pagination.numPerPage += 20;
            } else {
                var diference = $scope.pagination.all_data - $scope.pagination.numPerPage;
                $scope.pagination.start_item += 20;
                $scope.pagination.numPerPage += diference;
            }
            GetDataService.post('Dashboard/getFilteredOrders', {
                date_from: (getParams.dateFrom) ? new Date(getParams.dateFrom * 1).format('isoDate') : null,
                date_to:  (getParams.dateTo) ? new Date(getParams.dateTo * 1).format('isoDate') : null,
                quick_text: $scope.quick_text,
                from: $scope.pagination.start_item - 1,
                status: $scope.tab_status_id
            }).then(function(result) {
                if(result.data == '-1') {
                    $scope.loading = false;
                    $rootScope.showAlert('badRequest');
                } else {
                    $scope.rows = result.data;
                    $scope.loading = false;
                }
            }, function errorCallback(response) {
                if(response.status != 200) {
                    $scope.loading = false;
                    $rootScope.showAlert('badRequest');
                }
            });
        }
    }
    $scope.pagination.prevPage = function() {
        if($scope.pagination.all_data >= $scope.pagination.numPerPage && $scope.pagination.start_item > 1) {
            $scope.loading = true;
            if($scope.pagination.start_item < $scope.pagination.numPerPage) {
                $scope.pagination.numPerPage = ($scope.pagination.start_item - 1);
                $scope.pagination.start_item -= 20;
            }
            GetDataService.post('Dashboard/getFilteredOrders', {
                date_from: (getParams.dateFrom) ? new Date(getParams.dateFrom * 1).format('isoDate') : null,
                date_to: (getParams.dateTo) ? new Date(getParams.dateTo * 1).format('isoDate') : null,
                quick_text: $scope.quick_text,
                from: $scope.pagination.start_item - 1,
                status: $scope.tab_status_id
            }).then(function(result) {
                if(result.data == '-1') {
                    $scope.loading = false;
                    $rootScope.showAlert('badRequest');
                } else {
                    $scope.rows = result.data;
                    $scope.loading = false;
                }
            }, function errorCallback(response) {
                if(response.status != 200) {
                    $rootScope.showAlert('badRequest');
                }
            });
        }
    }

    $scope.pagination.lastPage = function() {
        if($scope.pagination.all_data > $scope.pagination.numPerPage) {
            if($scope.pagination.all_data % 20 === 0) {
                $scope.pagination.numPerPage = $scope.pagination.all_data;
                $scope.pagination.start_item = $scope.pagination.all_data - 19;
            } else {
                $scope.pagination.numPerPage = $scope.pagination.all_data;
                $scope.pagination.start_item = $scope.pagination.all_data - ($scope.pagination.all_data % 20) + 1;
            }
            $scope.loading = true;
            GetDataService.post('Dashboard/getFilteredOrders', {
                date_from: (getParams.dateFrom) ? new Date(getParams.dateFrom * 1).format('isoDate') : null,
                date_to: (getParams.dateTo) ? new Date(getParams.dateTo * 1).format('isoDate') : null,
                quick_text: $scope.quick_text,
                from: $scope.pagination.start_item - 1,
                status: $scope.tab_status_id
            }).then(function(result) {
                if(result.data == '-1') {
                    $scope.loading = false;
                    $rootScope.showAlert('badRequest');
                } else {
                    $scope.rows = result.data;
                    $scope.loading = false;
                }
            }, function errorCallback(response) {
                if(response.status != 200) {
                    $rootScope.showAlert('badRequest');
                }
            });
        }
    }

    $scope.pagination.firstPage = function() {
        if($scope.pagination.start_item > 20) {
            $scope.pagination.start_item = 1;
            $scope.pagination.numPerPage = 21;

            $scope.loading = true;
            GetDataService.post('Dashboard/getFilteredOrders', {
                date_from: (getParams.dateFrom) ? new Date(getParams.dateFrom * 1).format('isoDate') : null,
                date_to: (getParams.dateTo) ? new Date(getParams.dateTo * 1).format('isoDate') : null,
                quick_text: $scope.quick_text,
                from: $scope.pagination.start_item - 1,
                status: $scope.tab_status_id
            }).then(function(result) {
                if(result.data == '-1') {
                    $scope.loading = false;
                    $rootScope.showAlert('badRequest');
                } else {
                    $scope.rows = result.data;
                    $scope.loading = false;
                }
            }, function errorCallback(response) {
                if(response.status != 200) {
                    $rootScope.showAlert('badRequest');
                }
            });
        }
    }

    //function that makes call to api,
    //post date_from, date_to, quick_text and status
    //gets table data count for the above parameters
    function countFilteredOrders() {
        $scope.loading = true;
        if(getParams.filter != 'Račun' && getParams.filter != 'Plačano') {
            GetDataService.post('Dashboard/countFilteredOrders', {
                date_from: (getParams.dateFrom) ? new Date(getParams.dateFrom * 1).format('isoDate') : null,
                date_to: (getParams.dateTo) ? new Date(getParams.dateTo * 1).format('isoDate') : null,
                quick_text: getParams.quick_text,
                status: $scope.tab_status_id
            }).then(function(result) {
                if(result.data) {
                    $scope.pagination.all_data = result.data;
                    if($scope.pagination.all_data <= 20) {
                        $scope.pagination.numPerPage = result.data;
                    }
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
        } else {
            GetDataService.post('Dashboard/countFilteredInvoices', {
                date_from: (getParams.dateFrom) ? new Date(getParams.dateFrom * 1).format('isoDate') : null,
                date_to: (getParams.dateTo) ? new Date(getParams.dateTo * 1).format('isoDate') : null,
                paid: (getParams.filter == 'Račun') ? 0 : 1
            }).then(function(result) {
                if(result.data) {
                    $scope.pagination.all_data = result.data;
                    if($scope.pagination.all_data <= 20) {
                        $scope.pagination.numPerPage = result.data;
                    }
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
        }
    }

    //function that makes call to api,
    //post date_from, date_to, quick_text and status
    //gets table data for the above parameters
    function getFilteredOrders() {
        $scope.loading = true;
        if(getParams.filter != 'Račun' && getParams.filter != 'Plačano') {
            GetDataService.post('Dashboard/getFilteredOrders', {
                date_from: (getParams.dateFrom) ? new Date(getParams.dateFrom * 1).format('isoDate') : null,
                date_to: (getParams.dateTo) ? new Date(getParams.dateTo * 1).format('isoDate') : null,
                quick_text: getParams.quick_text,
                from: $scope.pagination.start_item - 1,
                status: $scope.tab_status_id
            }).then(function(result) {
                if(result.data) {
                    $scope.rows = result.data;
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
        } else {
            GetDataService.post('Dashboard/getFilteredInvoices', {
                date_from: (getParams.dateFrom) ? new Date(getParams.dateFrom * 1).format('isoDate') : null,
                date_to: (getParams.dateTo) ? new Date(getParams.dateTo * 1).format('isoDate') : null,
                from: $scope.pagination.start_item - 1,
                paid: (getParams.filter == 'Račun') ? 0 : 1
            }).then(function(result) {
                if(result.data) {
                    $scope.rows = result.data;
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
        }
    }

    //displays selected orders modal
    $scope.showSelectedOrdersModal = function(orders) {
        $scope.loading = true;
         GetDataService.post('Actions/getNextStatusesForStatus', {
            status_id: $scope.tab_status_id
        }).then(function(result) {
            $mdDialog.show({
                controller: 'selectedOrdersModalInstanceCtrl',
                templateUrl: 'SelectedOrdersModal.html',
                clickOutsideToClose: true,
                resolve: {
                    orders: function() {
                        return orders;
                    },
                    tab_status: function() {
                        return $scope.tab_status_id;
                    },
                    next_statuses: function() {
                        return result.data;
                    }
                }
            }).then(function() {
                $scope.switchTab($scope.tab);
            });
            $scope.loading = false;
        });
    }

    // checkes all checkboxes
    $scope.checkAll = function() {
        angular.forEach($scope.rows, function(row){
            row.selected = $scope.checkedAll;
        })
    }

    // opens invoice modal
    // on pregled if status == 5
    $scope.openInvoicesModal = function(invoice_id) {
        $scope.loading = true;
         GetDataService.post('Dashboard/getInvoiceDetails', {
            invoice_id: invoice_id
        }).then(function(result) {
            if(result.data) {
                $scope.loading = false;
                $mdDialog.show({
                    controller: 'invoicesModalInstanceCtrl',
                    templateUrl: 'invoicesModal.html',
                    clickOutsideToClose: true,
                    resolve: {
                        orders: function() {
                            return result.data.invoice_orders;
                        },
                        invoice_id: function() {
                            return invoice_id;
                        }
                    }
                });
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

    $scope.clickNoty = function(redirect) {
        $scope.switchTab(redirect.name);
    }

});



/**
 * Controller for invoices orders modal
 */
app.controller('invoicesModalInstanceCtrl', function($scope, orders, invoice_id, $mdDialog, GetDataService, $rootScope) {
    //init params
    $scope.orders = angular.copy(orders);
    $scope.invoice_id = angular.copy(invoice_id);

    // function for changes status of invoice
    $scope.payCheck = function() {
        $scope.loading = true;
        GetDataService.post('Actions/changeInvoicesStatus', {
            invoices: invoice_id,
            status: 6
        }).then(function(result) {
            if(result.data) {
                $mdDialog.hide();
                $scope.loading = false;
                $rootScope.showAlert('statusSuccess');
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

    $scope.sendInvoiceEmail = function(inv_id) {
        $scope.loading = true;
         GetDataService.post('actions/sendInvoiceEmail', {
            inv_id: inv_id
        }).then(function(result) {
            console.log(result);
            if(result.data) {
                $scope.loading = false;
                $rootScope.showAlert('success_mail');
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
 * Controller for selected orders modal
 */
app.controller('selectedOrdersModalInstanceCtrl', function($scope, orders, tab_status, $mdDialog, next_statuses, $rootScope, GetDataService) {
    // init params
    $scope.orders = angular.copy(orders);
    $scope.statuses = angular.copy($rootScope.statuses);
    $scope.next_statuses = angular.copy(next_statuses);
    $scope.status_id = angular.copy(tab_status);
    $scope.showModal = false;
    $scope.statusHeading = "Spremeni status";
    $scope.tmpStatus = {};
    $scope.collapsed = true;
    $scope.open = false;

    $scope.hide = function() {
        $mdDialog.hide();
    };
    $scope.cancel = function() {
        $mdDialog.cancel();
    };

    // function for returning to
    // option for changing status
    $scope.backToStatuses = function() {
        $scope.statusHeading = "Spremeni status";
        $scope.collapsed = true;
    }

    // fuction for displaying
    // the status selected
    $scope.changeStatus = function(status) {
        $scope.tmpStatus = status;
        $scope.statusHeading = status.name;
    }

    //post status, orders
    $scope.postStatus = function() {
        $scope.loading = true;
        if($scope.status_id != 5) {
            GetDataService.post('Actions/changeOrdersStatus', {
                orders: $scope.orders,
                status: $scope.tmpStatus.id
            }).then(function(result) {
                if(result.data) {
                    $mdDialog.hide();
                    $scope.loading = false;
                    $scope.$parent.redirectToStatus = $scope.tmpStatus;
                    $rootScope.showAlert('statusSuccess');
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
        } else {
            $scope.loading = true;
            GetDataService.post('Actions/changeInvoicesStatus', {
                invoices: $scope.orders,
                status: 6
            }).then(function(result) {
                if(result.data) {
                    $mdDialog.hide();
                    $scope.$parent.redirectToStatus = $scope.tmpStatus;
                    $scope.loading = false;
                    $rootScope.showAlert('statusSuccess');
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
    }

    $scope.izvoziPodatke = function () {
        // $scope.loading = true;
        // GetDataService.post('Actions/exportOrders', {
        //     orders: $scope.orders
        // }).then(function (result) {
        //   console.log(result);
        //     if (result.data) {
        //         $mdDialog.hide();
        //         $scope.loading = false;
        //         $rootScope.showAlert('exportSuccess');
        //     }
        // });
    }

    //post reservation date, status: "Rezervirano", orders
    $scope.submitDateAndTime = function(date, time) {
        $scope.loading = true;
        GetDataService.post('Actions/changeOrdersStatus', {
            orders: $scope.orders,
            status: 3,
            reservation_date: date.format('isoDate') + ' ' +time.format('HH:MM:00')
        }).then(function(result) {
            if(result.data) {
                $scope.loading = false;
                $mdDialog.hide();
                $scope.$parent.redirectToStatus = $scope.tmpStatus;
                $rootScope.showAlert('statusSuccess');
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

    // post invoce number, exporting date, deadline date, done date, status: "Racun", orders
    $scope.submitInvoice = function(invoice) {
        $scope.loading = true;
            GetDataService.post('Actions/changeOrdersStatus', {
                orders: $scope.orders,
                status: 5,
                invoice_num: invoice.invoiceNum,
                date_export: invoice.date_export.format('isoDate'),//invoice.date_export,date.format('isoDate') + ' ' +time.format('HH:MM:00')
                date_done: invoice.date_done.format('isoDate'),//invoice.date_done,
                date_deadline: invoice.date_deadline.format('isoDate')//invoice.date_deadline
            }).then(function(result) {
                if (result.data) {
                    $mdDialog.hide();
                    $scope.$parent.redirectToStatus = $scope.tmpStatus;
                    $scope.loading = false;
                    $rootScope.showAlert('statusSuccess');
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

    // post orders, status: "Zbirsano"
    // and bool if it is final delete
    $scope.finalDelete = function(checked) {
        $scope.loading = true;
            GetDataService.post('Actions/changeOrdersStatus', {
                orders: $scope.orders,
                status: 8,
                deleted: checked ? 1 : 0
            }).then(function(result) {
                if (result.data) {
                    $mdDialog.hide();
                    $scope.$parent.redirectToStatus = $scope.tmpStatus;
                    $scope.loading = false;
                    $rootScope.showAlert('statusSuccess');
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

    // post orders, status: "Arhiv"
    // and archive comment
    $scope.archive = function(comment) {
        $scope.loading = true;
        GetDataService.post('Actions/changeOrdersStatus', {
            orders: $scope.orders,
            status: 7,
            archive_comment: comment
        }).then(function(result) {
            if (result.data) {
                $mdDialog.hide();
                $scope.$parent.redirectToStatus = $scope.tmpStatus;
                $scope.loading = false;
                $rootScope.showAlert('statusSuccess');
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
});
