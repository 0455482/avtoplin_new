app.run(function($rootScope, notification) {
    $rootScope.show = false;

    $rootScope.closeAlert = function() {
        $rootScope.show = false;
    }

    $rootScope.showAlert = function(id) {
        $rootScope.show = true;
        $rootScope.alert = notification.get(id);
    }
})

app.controller('statisticsCtrl', function ($scope, GetDataService, updateURL, parseGetParams, $rootScope, $uibModal) {

    $scope.options = {
        // Sets the chart to be responsive
        responsive: true,
        //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
        scaleBeginAtZero: true,
        //Boolean - Whether grid lines are shown across the chart
        scaleShowGridLines: true,
        //String - Colour of the grid lines
        scaleGridLineColor: "rgba(0,0,0,.05)",
        //Number - Width of the grid lines
        scaleGridLineWidth: 1,
        //Boolean - If there is a stroke on each bar
        barShowStroke: true,
        //Number - Pixel width of the bar stroke
        barStrokeWidth: 2,
        //Number - Spacing between each of the X value sets
        barValueSpacing: 5,
        //Number - Spacing between data sets within X values
        barDatasetSpacing: 1,
        //String - A legend template
        legendTemplate: '<ul style="display: inline-flex;" class="tc-chart-js-legend"><% for (var i=0; i<datasets.length; i++){%><li><span style="background-color:<%=datasets[i].fillColor%>"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>'
    };

    var self = this;
    self.open1 = function() {
        self.opened1 = !self.opened1;
    };

    self.open2 = function() {
        self.opened2 = !self.opened2;
    };

    $scope.format = 'dd/MM/yyyy';
    $scope.selectedDateOption = 0;
    $scope.utmOptions = [
        { title: 'Source', id: 0},
        { title: 'Medium', id: 1},
        { title: 'Content', id: 2},
        { title: 'Term', id: 3},
        { title: 'Placement', id: 4},
        { title: 'Campaign', id: 5}
    ];
    $scope.selectedUTMOption = "0";
    $scope.tabs = [
        { title: 'Statistika naročil', id: 0, post: 'getAllOrders'},
        { title: 'Profit', id: 1, post: 'calculateYearProfit'},
        { title: 'Statistika rezerviranih', id: 2, post: 'getReservedOrders'},
        { title: 'Statistika realiziranih', id: 3, post: 'getRealizedOrders'},
        { title: 'Uspešnost', id: 4, post: 'getConversion'},
        { title: 'UTM Statistika', id: 5, post: 'getUTMStatistika'}
    ];

    $scope.initData = function() {
        self.dateTo = new Date();
        self.dateFrom = new Date(self.dateTo.getFullYear(), self.dateTo.getMonth() - 1, self.dateTo.getDate());
        var tmpDate = new Date(2014, 1, 1, 0, 0, 0, 0);
        var now = new Date();
        var i = 0;
        $scope.dateYearOptions = [];
        while (tmpDate.getTime() < now.getTime()) {
            var yearOption = {
                date: angular.copy(tmpDate),
                id: i,
                formatedDate: tmpDate.getFullYear()
            }
            i++;
            $scope.dateYearOptions.push(yearOption);
            tmpDate.setFullYear(tmpDate.getFullYear() + 1);
        }
        self.selectedDateYear = i - 1;
        $scope.getStatistika();
    }

    $scope.pop = function(){
          $rootScope.showAlert('badRequest');
       };

    function setPostDates() {
        if ($scope.selectedDateOption == "0") {
            $scope.date_from = self.dateFrom;
            $scope.date_to = self.dateTo;
        }
        else if ($scope.selectedDateOption == "1")
        $scope.date_year = new Date($scope.dateYearOptions[self.selectedDateYear].date.getFullYear(), 0, 1);
    }

    $scope.getStatistika = function() {
        $scope.loading = true;
        setPostDates();
        var data = {
            flag: $scope.selectedDateOption
        };
        if ($scope.selectedDateOption == "0") {
            data.date_from = $scope.date_from.format('isoDate');
            data.date_to = $scope.date_to.format('isoDate');
        } else {
            data.date_year = $scope.date_year.format('yyyy');
        }
        data.utm = $scope.utmOptions[$scope.selectedUTMOption].title.toLowerCase();

        $scope.statistics = [];
        angular.forEach($scope.tabs, function(value, key) {
            if (value.title == "Profit" && data.flag == 0) {
                GetDataService.post('Statistics/' + value.post, {
                    flag: 1,
                    date_year: new Date($scope.dateYearOptions[self.selectedDateYear].date.getFullYear(), 0, 1).format('yyyy')
                })
                .then(function(result) {
                    if (result.data) {
                        $scope.statistics[key] = {};
                        $scope.statistics[key].labels = result.data.date;
                        $scope.statistics[key].series = [];
                        $scope.statistics[key].data = [];
                        angular.forEach(result.data.count, function(value2, key2) {
                            $scope.statistics[key].series.push(value2.name);
                            $scope.statistics[key].data.push(value2.data);
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
            } else {
                GetDataService.post('Statistics/' + value.post, data)
                .then(function(result) {
                    if (result.data) {
                        $scope.statistics[key] = {};
                        $scope.statistics[key].labels = result.data.date;
                        $scope.statistics[key].series = [];
                        $scope.statistics[key].data = [];
                        angular.forEach(result.data.count, function(value2, key2) {
                            $scope.statistics[key].series.push(value2.name);
                            $scope.statistics[key].data.push(value2.data);
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
        })
    }

    $scope.showAddExpensesModal = function() {
        var modalInstance = $uibModal.open({
            controller: 'addExpensesModalInstanceCtrl',
            templateUrl: 'AddExpensesModal.html',
        });
        modalInstance.result.then(function (id) {
        }, function () {
        });
    };
});


/**
 * Controller for add expenses modal
 */
app.controller('addExpensesModalInstanceCtrl', function($scope, $uibModalInstance, GetDataService, $rootScope) {
    //init params
    $scope.format = 'MM/yyyy';
    $scope.opened = false;
    $scope.dateOptions = {
       datepickerMode:"'month'",
       minMode:"'month'",
       minDate:"minDate",
       showWeeks:"false",
    };

    $scope.expenses = 0.00;
    $scope.id = -1;
    $scope.date = new Date();

    /**
     * init data function
     * input parameter
     * returns date now and expenses for that date
     */
    $scope.initData = function() {
        $scope.date = new Date();
        $scope.getExpenses();
    }

    // function that gets expenses
    // for chosen month
    $scope.getExpenses = function() {
        $scope.loading = true;
        GetDataService.post('Statistics/getExpensesForDate', {
            date: $scope.date.format('yyyy-mm')
        }).then(function(result) {
            if (result.data) {
                $scope.id = result.data.id;
                if (result.data.expenses) {
                    $scope.expenses = result.data.expenses;
                } else {
                    $scope.expenses = 0;
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

    $scope.cancel = function () {
        $uibModalInstance.dismiss('cancel');
    };

    $scope.open = function() {
        $scope.opened = !$scope.opened;
    };

    $scope.ok = function () {
        $scope.loading = true;
        GetDataService.post('Statistics/addMonthlyExpenses', {
            date: $scope.date.format('yyyy-mm'),
            expenses: $scope.expenses,
            id: $scope.id
        }).then(function(result) {
            if (result.data) {
                $uibModalInstance.close(1);
                $scope.loading = false;
                $rootScope.showAlert('expensesAddSuccess');
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
});
