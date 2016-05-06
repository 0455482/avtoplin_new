app.factory("GetDataService", ['$http',
	function ($http) {
        $http.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded';
        $http.defaults.transformRequest = function(data) {
            return data != undefined ? $.param(data) : null;
        }
        var obj = {};
        obj.get = function (q) {
            return $http.get(q).then(function (results) {
                return results;
            });
        };
        obj.post = function (q, object) {
            return $http.post(q, object).then(function (results) {
                return results;
            });
        };
        obj.put = function (q, object) {
            return $http.put(q, object).then(function (results) {
                return results;
            });
        };
        obj.delete = function (q) {
            return $http.delete(q).then(function (results) {
                return results;
            });
        };
        return obj;
    }]);


app.factory("getIndexForStatus",
    function() {
        var obj = {};
        obj.getIndex = function(status) {

        }
        return obj;
    });

 app.factory("converDate",
    function() {
        var obj = {};
        obj.convert = function(date) {
            var arr_string = date.split('-');


        }
        return obj;
    });

app.factory("updateURL", ['$location',
	function ($location) {
        var obj = {};
        obj.update = function(data, url) {
            for (var i in data) {
                $location.path(url).search(i, data[i]);
            };
        }
        return obj;
    }]);

app.factory("parseGetParams", ['$location',
	function ($location) {
        var obj1 = {};
        obj1.parse = function() {
            var a = /\+/g;
            var r = /([^&=]+)=?([^&]*)/g;
            var d = function(s) {
                return decodeURIComponent(s.replace(a, ''));
            };

            var q = $location.url().split('?')[1];
            var obj = {};
            if(q) {
                while (e = r.exec(q)) {
                    obj[d(e[1])] = d(e[2]);
                }
            }

            return obj;
        }
        return obj1;
    }])

app.factory("parseGetPage", ['$location',
	function ($location) {
        var obj1 = {};
        obj1.parse = function() {
            var q = $location.path().split('/')[1];
            var obj = 0;
            switch(q) {
                case 'dashboard':
                    obj = 1;
                    break;
                case 'settings':
                    obj = 2;
                    break;
                case 'statistics':
                    obj = 3;
                    break;
            }
             return obj;
        }
        return obj1;
    }])

app.factory("getIndexForStatus",
    function() {
        var obj = {};
        obj.getIndex = function(status) {
            var index = 0;
            switch (status) {
                case 'Neobdelano':
                    index = 1;
                    break;
                case 'Klicano':
                    index = 2;
                    break;
                case 'Rezervirano':
                    index = 3;
                    break;
                case 'Realizirano':
                    index = 4;
                    break;
                case 'Račun':
                    index = 5;
                    break;
                case 'Plačano':
                    index = 6;
                    break;
                case 'Arhiv':
                    index = 7;
                    break;
                case 'Izbrisano':
                    index = 8;
                    break;
                default:
                    index = 9;
            }
            return index;
        }
        return obj;
    });

	  app.filter('range', function(){
	    return function(n) {
	      var res = [];
	      for (var i = 0; i < n; i++) {
	        res.push(i);
	      }
	      return res;
	    };
	  });

    app.factory("notification", [
    function() {
        var alerts = [
            { id: 'badRequest', msg: 'Napaka, prosimo poskusite kasneje.', type: 'danger' },
            { id: 'wrongParameters', msg: 'Napačni parametri, prosimo poskusite spet.', type: 'danger' },
            { id: 'statusSuccess', msg: 'Uspešno ste spremenili status.', type: 'success' },
            { id: 'userEditSuccess', msg: 'Uspešno ste posodobili uporadabnika.', type: 'success' },
            { id: 'userCreateSuccess', msg: 'Uspešno ste dodali uporadabnika.', type: 'success' },
            { id: 'colorChangeSuccess', msg: 'Uspešno ste spremenili barvo.', type: 'success' },
            { id: 'smsEditSuccess', msg: 'Uspešno ste posodobili SMS.', type: 'success' },
            { id: 'smsCreateSuccess', msg: 'Uspešno ste dodali SMS.', type: 'success' },
            { id: 'offerSuccess', msg: 'Uspešno ste shranili ponudbo.', type: 'success' },
            { id: 'expensesAddSuccess', msg: 'Uspešno ste dodali mesečne stroške.', type: 'success' },
            { id: 'badUserPass', msg: 'Napačno uporabniško ime ali geslo, poskusite še enkrat', type: 'danger' },
            { id: 'success_mail', msg: 'Uspešno ste poslali mail', type: 'success' },
            { id: 'exportSuccess', msg: 'Uspešno ste izvozili narocila', type: 'success' },
            { id: 'sendSMSSuccess', msg: 'Uspešno ste poslali SMS.', type: 'success' },
            { id: 'orderSuccess', msg: 'Uspešno ste posodobili naročilo.', type: 'success' }
        ];
        var obj = {};
        obj.get = function(id) {
            var alert = {};
            angular.forEach(alerts, function(element, index) {
                if (element.id == id) {
                    alert = element;
                }
            });
            return alert;
        }
        return obj;
    }]);
