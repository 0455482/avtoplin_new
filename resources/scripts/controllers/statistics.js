// app.run(function($rootScope, notification) {
//     $rootScope.show = false;
//
//     $rootScope.closeAlert = function() {
//         $rootScope.show = false;
//     }
//
//     $rootScope.showAlert = function(id) {
//         $rootScope.show = true;
//         $rootScope.alert = notification.get(id);
//     }
// })

app.controller('statisticsCtrl', function ($scope, GetDataService, updateURL, parseGetParams, $rootScope) {
    // init params
//     $scope.tabs = [
//         { title: 'Statistika naročil', id: 0, post: 'getAllOrders'},
//         { title: 'Profit', id: 1, post: 'calculateYearProfit'},
//         { title: 'Statistika rezerviranih', id: 2, post: 'getReservedOrders'},
//         { title: 'Statistika realiziranih', id: 3, post: 'getRealizedOrders'},
//         { title: 'Uspešnost', id: 4, post: 'getConversion'},
//         { title: 'UTM Statistika', id: 5, post: 'getUTMStatistika'}
//     ];
//     $scope.selectedTab = "0";
//
    GetDataService.get('Statistics/init').then(function(result) {
        $scope.user_type = result.data.user_type;
        $scope.loading = false;
    });
//
//
//     $scope.dateOptions = [
//         { title: 'From-To', id: 0},
//         { title: 'Year', id: 1}
//     ];
//     $scope.selectedDateOption = "0";
//     $scope.dateYearOptions = [];
//     $scope.utmOptions = [
//         { title: 'Source', id: 0},
//         { title: 'Medium', id: 1},
//         { title: 'Content', id: 2},
//         { title: 'Term', id: 3},
//         { title: 'Placement', id: 4},
//         { title: 'Campaign', id: 5}
//     ];
//     $scope.selectedUTMOption = "0";
//     $scope.chartConfig = {
//         options: {
//             chart: {
//                 type: 'column'
//             }
//         },
//         series: [{
//             data: []
//         }],
//         title: {
//             text: 'Statistika paketov'
//         },
//         xAxis: {
//             categories: []
//         },
//         yAxis: {
//             title: {
//                 text: ''
//             }
//         },
//         loading: false
//     };
//     var getParams = {};
//
//     /**
//      * init data function
//      * input parameter
//      * returns dates, date year options and chart data
//      */
//     $scope.initData = function() {
//         $scope.dateTo = new Date();
//         $scope.dateFrom = new Date($scope.dateTo.getFullYear(), $scope.dateTo.getMonth() - 1, $scope.dateTo.getDate());
//         var tmpDate = new Date(2014, 1, 1, 0, 0, 0, 0);
//         var now = new Date();
//         var i = 0;
//         while (tmpDate.getTime() < now.getTime()) {
//             var yearOption = {
//                 date: angular.copy(tmpDate),
//                 id: i,
//                 formatedDate: tmpDate.getFullYear()
//             }
//             i++;
//             $scope.dateYearOptions.push(yearOption);
//             tmpDate.setFullYear(tmpDate.getFullYear() + 1);
//         }
//         $scope.selectedDateYear = i - 1;
//         $scope.dateDay = new Date();
//         $scope.disableDateOption = false;
//         getParams = parseGetParams.parse();
//         getParams.tab ? getParams.tab : getParams.tab = $scope.selectedTab;
//         $scope.selectedTab = getParams.tab;
//         $scope.switchTab($scope.selectedTab);
//
//
//     }
//
//     //function for updating options
//     //and chart when some option is changed
//     $scope.update = function() {
//         $scope.switchTab($scope.selectedTab);
//     }
//
//     //function for setting dates
//     //depending on the selected date option
//     function setPostDates() {
//         if ($scope.selectedDateOption=="0") {
//             $scope.date_from = $scope.dateFrom;
//             $scope.date_to = $scope.dateTo;
//         }
//         else if ($scope.selectedDateOption=="1") {
//             $scope.date_year = new Date($scope.dateYearOptions[$scope.selectedDateYear].date.getFullYear(), 0, 1);
//         }
//     }
//
//     //switch tabs for different chart statistics
//     //@@input parameter is tab id
//     //in order to stay on the same tab on refresh this method
//     //modifies the url, and adds the tab id
//     //makes call to api and returns the selected tab data
//     $scope.switchTab = function(tabId) {
//         $scope.selectedTab = tabId;
//         setPostDates();
//         if ($scope.tabs[tabId].title == 'UTM Statistika') {
//             $scope.showUTM = true;
//             $scope.disableDateOption = false;
//         }
//         else if ($scope.tabs[tabId].title == 'Profit') {
//             $scope.showUTM = false;
//             $scope.disableDateOption = true;
//             $scope.selectedDateOption = "1";
//             $scope.date_year = new Date($scope.dateYearOptions[$scope.selectedDateYear].date.getFullYear(), 0, 1);
//         }
//         else {
//             $scope.showUTM = false;
//             $scope.disableDateOption = false;
//         }
//         $scope.getStatistika();
//         getParams.tab = tabId;
//         updateURL.update(getParams, '/statistics');
//     }
//
//     //function for getting statistics data
//     //depending on the selected tab
//     $scope.getStatistika = function() {
//         $scope.loading = true;
//         var data = {
//             flag: $scope.selectedDateOption
//         };
//         if ($scope.selectedDateOption=="0") {
//             data.date_from = $scope.date_from.format('isoDate');
//             data.date_to = $scope.date_to.format('isoDate');
//         } else {
//             data.date_year = $scope.date_year.format('yyyy');
//         }
//
//         if ($scope.tabs[$scope.selectedTab].title == 'UTM Statistika') {
//             data.utm = $scope.utmOptions[$scope.selectedUTMOption].title.toLowerCase();
//         }
//
//         GetDataService.post('Statistics/' + $scope.tabs[$scope.selectedTab].post, data)
//         .then(function(result) {
//             if (result.data) {
//                 $scope.chartConfig.series = result.data.count;
//                 $scope.chartConfig.xAxis.categories = result.data.date;
//                 $scope.chartConfig.title.text = $scope.tabs[$scope.selectedTab].title;
//                 $scope.loading = false;
//             } else {
//                 $scope.loading = false;
//                 $rootScope.showAlert('badRequest');
//             }
//         }, function errorCallback(response) {
//             if(response.status != 200) {
//                 $scope.loading = false;
//                 $rootScope.showAlert('badRequest');
//             }
//         });
//     }
//
//     //function that shows modal
//     //for adding expenses
//     $scope.showAddExpensesModal = function() {
//         $scope.loading = true;
//         $mdDialog.show({
//             controller: 'addExpensesModalInstanceCtrl',
//             templateUrl: 'AddExpensesModal.html',
//             clickOutsideToClose: true,
//             resolve: {
//             }
//         }).then(function() {
//         });
//         $scope.loading = false;
//     }
// });
//
// /**
//  * Controller for add expenses modal
//  */
// app.controller('addExpensesModalInstanceCtrl', function($scope, $mdDialog, GetDataService, $rootScope) {
//     //init params
//     $scope.format = 'MM/yyyy';
//     $scope.opened = false;
//     $scope.dateOptions = {
//         minMode: 'month'
//     };
//     $scope.expenses = 0.00;
//     $scope.id = -1;
//
//     /**
//      * init data function
//      * input parameter
//      * returns date now and expenses for that date
//      */
//     $scope.initData = function() {
//         $scope.date = new Date();
//         $scope.getExpenses();
//     }
//
//
//     // function that gets expenses
//     // for chosen month
//     $scope.getExpenses = function() {
//         $scope.loading = true;
//         GetDataService.post('Statistics/getExpensesForDate', {
//             date: $scope.date.format('yyyy-mm')
//         }).then(function(result) {
//             if (result.data) {
//                 $scope.id = result.data.id;
//                 if (result.data.expenses) {
//                     $scope.expenses = result.data.expenses;
//                 } else {
//                     $scope.expenses = 0;
//                 }
//                 $scope.loading = false;
//             } else {
//                 $scope.loading = false;
//                 $rootScope.showAlert('badRequest');
//             }
//         }, function errorCallback(response) {
//             if(response.status != 200) {
//                 $scope.loading = false;
//                 $rootScope.showAlert('badRequest');
//             }
//         });
//     }
//
//     $scope.hide = function() {
//         $mdDialog.hide();
//     };
//     $scope.cancel = function() {
//         $mdDialog.cancel();
//     };
//     $scope.open = function() {
//         $scope.opened = true;
//     };
//
//     // function that adds expenses for chosen month
//     // if expenses exist sends id else sends id = -1s
//     $scope.addExpenses = function(date, expenses) {
//         $scope.loading = true;
//         GetDataService.post('Statistics/addMonthlyExpenses', {
//             date: date.format('yyyy-mm'),
//             expenses: expenses,
//             id: $scope.id
//         }).then(function(result) {
//             if (result.data) {
//                 $scope.hide();
//                 $scope.loading = false;
//                 $rootScope.showAlert('expensesAddSuccess');
//             } else {
//                 $scope.loading = false;
//                 $rootScope.showAlert('badRequest');
//             }
//         }, function errorCallback(response) {
//             if(response.status != 200) {
//                 $scope.loading = false;
//                 $rootScope.showAlert('badRequest');
//             }
//         });
//     }
});
