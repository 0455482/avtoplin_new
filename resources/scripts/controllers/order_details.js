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

app.controller('orderDetailsCtrl', function ($scope, $filter, $rootScope, $http, $location, $mdDialog, $log, $route, GetDataService, updateURL, parseGetParams) {
    //init params
	var getParams = {};
    $scope.orderDetails = {};
    this.savedStateOrderDetails = {};
    $scope.oldOrderDetails = {};
    $scope.actives = [{id: 1, status: 'Active'}, {id: 0, status: 'Inactive'}];
    $scope.loading = false;
    $scope.isDisabled = true;

    /**
     * init data function
     * input parameter is order_id
     * returns orderDetails, fuels, statuses
     */
	$scope.initData = function() {
        $scope.loading = true;
        getParams = parseGetParams.parse();
        GetDataService.post('order_details/init', {
           order_id: getParams.order_id
        }).then(function(result) {
            $scope.names = result.data.statuses;
            $rootScope.names = result.data.statuses;
            $rootScope.orderDetails = result.data.order_details;
            $rootScope.orderDetails.date_created = $filter('date')(result.data.order_details.date_created, 'yyyy/mm/dd');
            (result.data.order_details.realization_date != null) ? $rootScope.orderDetails.realization_date = getDatefromString(result.data.order_details.realization_date) : null;
            (result.data.order_details.reservation_date != null) ? $rootScope.orderDetails.reservation_date = result.data.order_details.reservation_date : null;
            $scope.fuels = result.data.fuel;
            $rootScope.orderDetails.avtoplin = $scope.fuels[4].price;
            $scope.orderDetails = $rootScope.orderDetails;
            $scope.oldOrderDetails = result.data.old_order_details;
            if (Object.keys($scope.orderDetails.utm).length > 0) {
                $scope.showUTM = true;
            } else {
                $scope.showUTM = false;
            }
            $scope.loading = false;
        });

    }

    $scope.changeDate = function() {
        if($scope.orderDetails.reservation_date != null) {
            if($scope.isDisabled == true)
                $scope.orderDetails.reservation_date = $scope.orderDetails.reservation_date.format('isoDateTime');
            else {
                $scope.orderDetails.reservation_date = getDatefromString($scope.orderDetails.reservation_date);
            }
        }
    }

    /**
     * two functions for editing the info
     * we save the first state of input values
     * so if changes not saved, the order details are
     * without changes
     */
    this.urediInfo = function(order_details) {
        this.savedStateOrderDetails = angular.copy(order_details);
    }

    this.nazajInfo = function() {
        $scope.orderDetails = this.savedStateOrderDetails;
    }

    /**
     * watching the changes of fuel, LPG, average consumtion, and droved km per year
     * and calculate the savings per year you get by switching to LPG
     */
    $scope.$watch('[orderDetails.bencin, orderDetails.avtoplin, orderDetails.average_consumption, orderDetails.droved_km_year]', function(newValues) {
         $scope.orderDetails.bencin = parseFloat(newValues[0]);
         var bencin = parseFloat(newValues[0]);
         var avtoplin = parseFloat(newValues[1]);
         var povp_por = parseFloat(newValues[2]);
         var km_year = parseFloat(newValues[3]);
         var por_benc = 0;
         var por_ap = 0;

         if(bencin && avtoplin && povp_por && km_year) {
            por_benc = (km_year / 100) * povp_por * bencin;
            por_ap = (km_year / 100) * (povp_por * 0.1 + povp_por) * avtoplin;
         }
         $scope.orderDetails.prihranek = (por_benc - por_ap).toFixed(2);
    }, true);

    /**
     * opens old order modal
     * input parameter are pressed event, and the selected order
     * forwards the old_older to the oldOrderDetailsModalInstanceCtrl controller
     */
    $scope.openOldOrdersModal = function(ev, old_order) {
        $mdDialog.show({
            controller: 'oldOrderDetailsModalInstanceCtrl',
            templateUrl: 'oldOrderDetailsModal.html',
            parent: angular.element(document.body),
            targetEvent: ev,
            clickOutsideToClose: true,
            resolve: {
                old_order: function () {
                        return old_order;
                }
            }
        })
        .then(function(answer) {
        });
    }

    /**
     * opens date modal
     * input parameters are pressed event, and the order details
     * forwards the order details parameter so we can change the date
     */
    $scope.openDateModal = function(ev, orderDetails) {
         $mdDialog.show({
            controller: 'dateModalInstanceCtrl',
            templateUrl: 'dateModal.html',
            parent: angular.element(document.body),
            targetEvent: ev,
            clickOutsideToClose: true,
            resolve: {
                order: function () {
                        return orderDetails;
                }
            }
        })
        .then(function(answer) {

        });
    }

    /**
     * shows new offer modal
     * input parameter is the pressed event
     */
    $scope.showPonudbaModal = function(ev) {
         $mdDialog.show({
            controller: 'ponudbaModalInstanceCtrl',
            templateUrl: 'ponudbaModal.html',
            parent: angular.element(document.body),
            targetEvent: ev,
            clickOutsideToClose: true,

         })
        .then(function(answer) {

        });
    }

    /**
     * shows old offers modal
     * input parameters are the ID of the order, and the pressed event
     * makes call to api, and posts the order id
     * returns modal dialog with all the old offers for that order
     */
    $scope.oldOfferModal = function(id, ev) {
        $scope.loading = true;
        GetDataService.post('actions/getOrderOffers', {
           order_id: id
        }).then(function(result) {
            if(result.data) {
                $mdDialog.show({
                    controller: 'oldOfferModalInstanceCtrl',
                    templateUrl: 'oldOffersModal.html',
                    parent: angular.element(document.body),
                    targetEvent: ev,
                    clickOutsideToClose: true,
                    resolve: {
                        old_offers: function() {
                            return result.data;
                        }
                    }
                })
                .then(function(answer) {

                });
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

    $scope.openStatusModal = function(orderDetails, ev) {
        $scope.loading = true;
         GetDataService.post('Actions/getNextStatusesForStatus', {
            status_id: orderDetails.order_status_id
        }).then(function(result) {
            if(result.data) {
                $scope.loading = false;
                $mdDialog.show({
                controller: 'changeStatusModalInstanceCtrl',
                templateUrl: 'statusesModal.html',
                parent: angular.element(document.body),
                targetEvent: ev,
                clickOutsideToClose: true,
                resolve: {
                    next_statuses: function() {
                        return result.data;
                    },
                    orderDetails: function() {
                        return orderDetails;
                    }
                }
                })
                .then(function(answer) {
                    $scope.initData();
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

    $scope.showHistoryModal = function(order_id, ev) {
        $scope.loading = true;
         GetDataService.post('order_details/getOrderHistory', {
            order_id: order_id
        }).then(function(result) {
            if(result.data) {
                $scope.loading = false;
                $mdDialog.show({
                    controller: 'historyModalInstanceCtrl',
                    templateUrl: 'historyModal.html',
                    parent: angular.element(document.body),
                    targetEvent: ev,
                    clickOutsideToClose: true,
                    resolve: {
                        history: function() {
                            return result.data;
                            }
                    }
                })
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

    $scope.openInvoces = function(invoice, ev) {
        $scope.loading = true;
         GetDataService.post('Dashboard/getInvoiceDetails', {
            invoice_id: invoice
        }).then(function(result) {
            if(result.data) {
                $scope.loading = false;
                $mdDialog.show({
                    controller: 'invoicesModalInstanceCtrl',
                    templateUrl: 'invoicesModal.html',
                    targetEvent: ev,
                    clickOutsideToClose: true,
                    resolve: {
                        orders: function() {
                            return result.data.invoice_orders;
                        },
                        invoice_id: function() {
                            return invoice;
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

    /**
     * submits order details form
     * input parameter is order details data
     * makes call to api and posts order details data
     */
    $scope.submit_form = function(orderDetais) {

        var details = angular.copy(orderDetais);

        (details.reservation_date != null && details.time != null) ? details.reservation_date = details.reservation_date.format('isoDate') + ' ' + details.time.format('HH:MM') : details.reservation_date = null
        if(details.realization_date != null) {
             details.realization_date = details.realization_date.format('isoDate');
        } else {
             details.realization_date = null;
        }
        console.log(details.telephone.trim().toLowerCase().replace(/(?:(?:\+?1\s*(?:[.-]\s*)?)?(?:(\s*([2-9]1[02-9]|[2-9][02-8]1|[2-9][02-8][02-9]‌​)\s*)|([2-9]1[02-9]|[2-9][02-8]1|[2-9][02-8][02-9]))\s*(?:[.-]\s*)?)([2-9]1[02-9]‌​|[2-9][02-9]1|[2-9][02-9]{2})\s*(?:[.-]\s*)?([0-9]{4})/, ""));
        $scope.loading = true;
        GetDataService.post('order_details/editOrderDetails', {
           order_details: details
        }).then(function(result) {
            if(result.data == 1) {
                $rootScope.showAlert('orderSuccess');
                $scope.isDisabled = true;
                $scope.initData();
                $scope.loading = false;
            }
        });
    }

    $scope.showSendSMSModal = function(orderDetails) {
        $scope.loading = true;
        $mdDialog.show({
            controller: 'sendSMSModalInstanceCtrl',
            templateUrl: 'SendSMSModal.html',
            clickOutsideToClose: true,
            resolve: {
                orderDetails: function() {
                    return orderDetails;
                }
            }
        }).then(function() {
        });
        $scope.loading = false;
    }
});

function getDatefromString(string) {
    var arr = string.split('-');
    //console.log(new Date(arr[0] + ' ' + arr[1] + ' ' + arr[2]));
    return new Date(arr[0] + ' ' + arr[1] + ' ' + arr[2])
}

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

app.controller('historyModalInstanceCtrl', function ($scope, $mdDialog, history) {
    $scope.history = angular.copy(history);
    $scope.orderHistory = [];
    $scope.offerHistory = [];
    angular.forEach($scope.history, function(val, key) {
      if(val.type == "offer_sent") {
        $scope.offerHistory.push(val);
      } else {
        $scope.orderHistory.push(val);
      }
    })
    console.log($scope.offerHistory, $scope.orderHistory);
    $scope.cancel = function() {
        $mdDialog.cancel();
    };
});

app.controller('changeStatusModalInstanceCtrl', function ($scope, GetDataService, $rootScope, $route, $mdDialog, next_statuses, orderDetails) {
    $scope.next_statuses = angular.copy(next_statuses);
    var order = angular.copy(orderDetails);
    $scope.statusHeading = 'Spremeni status'

    $scope.backToStatuses = function() {
        $scope.statusHeading = "Spremeni status";
        $scope.collapsed = true;
    }

    $scope.changeStatus = function(status) {
        $scope.tmpStatus = status;
        $scope.statusHeading = status.name;
    }

    $scope.postStatus = function() {
        $scope.loading = true;
            GetDataService.post('Actions/changeOrdersStatus', {
                orders: order.id,
                status: $scope.tmpStatus.id
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

    //post reservation date, status: "Rezervirano", orders
    $scope.submitDateAndTime = function(date, time) {
        $scope.loading = true;
        GetDataService.post('Actions/changeOrdersStatus', {
            orders: order.id,
            status: 3,
            reservation_date: date.format('isoDate') + ' ' +time.format('HH:MM:00')
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

    $scope.finalDelete = function(checked) {
        $scope.loading = true;
            GetDataService.post('Actions/changeOrdersStatus', {
                orders: order.id,
                status: 8,
                deleted: checked ? 1 : 0
            }).then(function(result) {
                if (result.data) {
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

    $scope.archive = function(comment) {
        $scope.loading = true;
        GetDataService.post('Actions/changeOrdersStatus', {
            orders: order.id,
            status: 7,
            archive_comment: comment
        }).then(function(result) {
            if (result.data) {
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

    // post invoce number, status: "Racun", orders
    $scope.submitInvoice = function(invoice) {
        console.log(invoice);
        $scope.loading = true;
            GetDataService.post('Actions/changeOrdersStatus', {
                orders: order.id,
                status: 5,
                invoice_num: invoice.invoiceNum,
                date_export: invoice.date_export.format('isoDate'),//invoice.date_export,date.format('isoDate') + ' ' +time.format('HH:MM:00')
                date_done: invoice.date_done.format('isoDate'),//invoice.date_done,
                date_deadline: invoice.date_deadline.format('isoDate')//invoice.date_deadline
            }).then(function(result) {
                if (result.data) {
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

    $scope.hide = function() {
        $mdDialog.hide();
    };
    $scope.cancel = function() {
        $mdDialog.cancel();
    };
});

/**
 * controller for our old order modal
 * we use angular copy to copy the old order parameter to the
 * $scope so we can show the date in our modal
 */
app.controller('oldOrderDetailsModalInstanceCtrl', function ($scope, $mdDialog, old_order) {

    $scope.oldOrderDetails = angular.copy(old_order);
    $scope.hide = function() {
        $mdDialog.hide();
    };
    $scope.cancel = function() {
        $mdDialog.cancel();
    };
});

/**
 * controller for change date modal
 */
app.controller('dateModalInstanceCtrl', function ($scope, order, $mdDialog) {
    /**
     * function for seting the date
     */

    $scope.hide = function() {
        $mdDialog.hide();
    };
    $scope.cancel = function() {
        $mdDialog.cancel();
    };

});
/**
 * controller for new offer modal
 */
app.controller('ponudbaModalInstanceCtrl', function ($scope, $mdToast, $rootScope, $mdDialog, GetDataService) {
    $scope.show_actions = false;
    $scope.offer_id = {};
    /**
     * function that submits the made offer
     * input parameter is the made offer
     * makes call to api and posts made offer and the order id that is made for
     * returns the made offer id, so we are able to show pdf later in a new tab
     */
    $scope.submitOffer = function(offer) {
        $scope.loading = true;
        GetDataService.post('actions/createOrderOffer', {
        offer: offer,
        order_id: $rootScope.orderDetails.id
        }).then(function(result) {
          if(result.data || result.data != '-1') {
             $scope.offer_id = result.data;
             $scope.loading = false;
             $scope.show_actions = true;
             $rootScope.showAlert('offerSuccess');
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

    /**
     * function for sending offer as email to the customer
     * input parameter is offer id
     * sending the email after that is back end job
     */
    $scope.sendEmail = function(offer_id) {
        $scope.loading = true;
        GetDataService.post('actions/sendOfferEmail', {
            offer_id: offer_id,
        }).then(function(result) {
            if(result.data || result.data == -1) {
                $scope.loading = false;
                $mdDialog.hide();
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
    /**
     * hide/cancel the modal
     * common functions
     */
    $scope.hide = function() {
        $mdDialog.hide();
    };
    $scope.cancel = function() {
        $mdDialog.cancel();
    };

});
/**
 * controller for old offers modal
 */
app.controller('oldOfferModalInstanceCtrl', function ($scope, $rootScope, $mdToast, old_offers, $mdDialog, GetDataService) {
    $scope.oldOffers = angular.copy(old_offers);
    console.log($scope.oldOffers);
    /**
     * function for sending the offer as email to the customer
     * input parameter is the offer id
     */
    $scope.sendEmail = function(offer_id) {
        $scope.loading = true;
        GetDataService.post('actions/sendOfferEmail', {
            offer_id: offer_id,
        }).then(function(result) {
            if(result.data || result.data == -1) {
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
 * controller for sending SMS modal
 */
app.controller('sendSMSModalInstanceCtrl', function($scope, $rootScope, $mdDialog, GetDataService, orderDetails) {
    $scope.initData = function() {
        $scope.telephone = orderDetails.telephone;
        $scope.getTemplates();
    }

    $scope.getTemplates = function() {
        $scope.loading = true;
        GetDataService.get('Order_details/getActiveTemplates', {
        }).then(function(result) {
            if (result.data) {
                $scope.smsTemplates = result.data;
                $scope.selectedSMSTemplate = $scope.smsTemplates[0].id;
                $scope.changeTemplate();
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

    $scope.changeTemplate = function() {
        angular.forEach($scope.smsTemplates, function(template) {
            if (template.id == $scope.selectedSMSTemplate) {
                $scope.smsText = template.text;
            }
        });
    }

    $scope.sendSMS = function() {
        $scope.loading = true;
        GetDataService.post('Actions/sendSingleSms', {
            telephone: $scope.telephone,
            text: $scope.smsText,
            st_id: $scope.selectedSMSTemplate,
            o_id: orderDetails.id
        }).then(function(result) {
            if (result.data) {
                $scope.hide();
                $scope.loading = false;
                $rootScope.showAlert('sendSMSSuccess');
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
