// var app = angular.module('avtoplin_app',
// 	['ngRoute',
// 	'ngAnimate',
// 	'ui.bootstrap',
// 	'pickadate',
// 	'angular-growl',
// 	'colorpicker.module',
// 	'ngMaterial',
// 	'ngSanitize',
// 	'ui.select',
// 	'highcharts-ng'])
// 	.config(function($locationProvider, $mdDateLocaleProvider) {
//     	$locationProvider.html5Mode(true);
// 	})
//
// 	app.filter('num', function() {
// 		return function(input) {
// 			return parseInt(input, 10);
// 		};
// 	});
/**
* declare 'clip-two' module with dependencies
*/
'use strict';
var app = angular.module("avtoplin_app", [
	'ngAnimate',
	'ngCookies',
	'ngStorage',
	'ngSanitize',
	'ngTouch',
	'ui.router',
	'ui.bootstrap',
	'oc.lazyLoad',
	'cfp.loadingBar',
	'ncy-angular-breadcrumb',
	'duScroll',
	'pascalprecht.translate',
]).config(function($locationProvider) {
	$locationProvider.html5Mode(true);
});

app.run(['$rootScope', '$state', '$stateParams',
function ($rootScope, $state, $stateParams) {

	// Attach Fastclick for eliminating the 300ms delay between a physical tap and the firing of a click event on mobile browsers
	//FastClick.attach(document.body);

	// Set some reference to access them from any scope
	$rootScope.$state = $state;
	$rootScope.$stateParams = $stateParams;

	// GLOBAL APP SCOPE
	// set below basic information
	$rootScope.app = {
		name: 'avtoplin_app', // name of your project
		author: 'ClipTheme', // author's name or company name
		description: 'Angular Bootstrap Admin Template', // brief description
		version: '2.0', // current version
		year: ((new Date()).getFullYear()), // automatic current year (for copyright information)
		isMobile: (function () {// true if the browser is a mobile device
			var check = false;
			if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
				check = true;
			};
			return check;
		})(),
		layout: {
			isNavbarFixed: true, //true if you want to initialize the template with fixed header
			isSidebarFixed: true, // true if you want to initialize the template with fixed sidebar
			isSidebarClosed: false, // true if you want to initialize the template with closed sidebar
			isFooterFixed: false, // true if you want to initialize the template with fixed footer
			theme: 'theme-1', // indicate the theme chosen for your project
			logo: 'assets/images/logo.png', // relative path of the project logo
		}
	};
	$rootScope.user = {
		name: 'Petar',
		job: 'ng-Dev',
		picture: 'app/img/user/02.jpg'
	};
}]);


/**
 * Config constant
 */
app.constant('APP_MEDIAQUERY', {
    'desktopXL': 1200,
    'desktop': 992,
    'tablet': 768,
    'mobile': 480
});
app.constant('JS_REQUIRES', {
    //*** Scripts
    scripts: {
        //*** Javascript Plugins
        'modernizr': ['../bower_components/components-modernizr/modernizr.js'],
        'moment': ['../bower_components/moment/min/moment.min.js'],
        'spin': '../bower_components/spin.js/spin.js',

        //*** jQuery Plugins
        'perfect-scrollbar-plugin': ['../bower_components/perfect-scrollbar/js/min/perfect-scrollbar.jquery.min.js', '../bower_components/perfect-scrollbar/css/perfect-scrollbar.min.css'],
        'ladda': ['../bower_components/ladda/dist/ladda.min.js', '../bower_components/ladda/dist/ladda-themeless.min.css'],
        'sweet-alert': ['../bower_components/sweetalert/lib/sweet-alert.min.js', '../bower_components/sweetalert/lib/sweet-alert.css'],
        'chartjs': '../bower_components/chartjs/Chart.min.js',
        'jquery-sparkline': '../bower_components/jquery.sparkline.build/dist/jquery.sparkline.min.js',
        'ckeditor-plugin': '../bower_components/ckeditor/ckeditor.js',
        'jquery-nestable-plugin': ['../bower_components/jquery-nestable/jquery.nestable.js'],
        'touchspin-plugin': ['../bower_components/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.js', '../bower_components/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.css'],

        //*** Controllers
        'dashboardCtrl': 'assets/js/controllers/dashboardCtrl.js',
        'iconsCtrl': 'assets/js/controllers/iconsCtrl.js',
        'vAccordionCtrl': 'assets/js/controllers/vAccordionCtrl.js',
        'ckeditorCtrl': 'assets/js/controllers/ckeditorCtrl.js',
        'laddaCtrl': 'assets/js/controllers/laddaCtrl.js',
        'ngTableCtrl': 'assets/js/controllers/ngTableCtrl.js',
        'cropCtrl': 'assets/js/controllers/cropCtrl.js',
        'asideCtrl': 'assets/js/controllers/asideCtrl.js',
        'toasterCtrl': 'assets/js/controllers/toasterCtrl.js',
        'sweetAlertCtrl': 'assets/js/controllers/sweetAlertCtrl.js',
        'mapsCtrl': 'assets/js/controllers/mapsCtrl.js',
        'chartsCtrl': 'assets/js/controllers/chartsCtrl.js',
        'calendarCtrl': 'assets/js/controllers/calendarCtrl.js',
        'nestableCtrl': 'assets/js/controllers/nestableCtrl.js',
        'validationCtrl': ['assets/js/controllers/validationCtrl.js'],
        'userCtrl': ['assets/js/controllers/userCtrl.js'],
        'selectCtrl': 'assets/js/controllers/selectCtrl.js',
        'wizardCtrl': 'assets/js/controllers/wizardCtrl.js',
        'uploadCtrl': 'assets/js/controllers/uploadCtrl.js',
        'treeCtrl': 'assets/js/controllers/treeCtrl.js',
        'inboxCtrl': 'assets/js/controllers/inboxCtrl.js',
        'xeditableCtrl': 'assets/js/controllers/xeditableCtrl.js',
        'chatCtrl': 'assets/js/controllers/chatCtrl.js',
        'dynamicTableCtrl': 'assets/js/controllers/dynamicTableCtrl.js',
        'NotificationIconsCtrl': 'assets/js/controllers/notificationIconsCtrl.js',

        //*** Filters
        'htmlToPlaintext': 'assets/js/filters/htmlToPlaintext.js'
    },
    //*** angularJS Modules
    modules: [{
        name: 'angularMoment',
        files: ['../bower_components/angular-moment/angular-moment.min.js']
    }, {
        name: 'toaster',
        files: ['../bower_components/AngularJS-Toaster/toaster.js', '../bower_components/AngularJS-Toaster/toaster.css']
    }, {
        name: 'angularBootstrapNavTree',
        files: ['../bower_components/angular-bootstrap-nav-tree/dist/abn_tree_directive.js', '../bower_components/angular-bootstrap-nav-tree/dist/abn_tree.css']
    }, {
        name: 'angular-ladda',
        files: ['../bower_components/angular-ladda/dist/angular-ladda.min.js']
    }, {
        name: 'ngTable',
        files: ['../bower_components/ng-table/dist/ng-table.min.js', '../bower_components/ng-table/dist/ng-table.min.css']
    }, {
        name: 'ui.select',
        files: ['../bower_components/angular-ui-select/dist/select.min.js', '../bower_components/angular-ui-select/dist/select.min.css', '../bower_components/select2/dist/css/select2.min.css', '../bower_components/select2-bootstrap-css/select2-bootstrap.min.css', '../bower_components/selectize/dist/css/selectize.bootstrap3.css']
    }, {
        name: 'ui.mask',
        files: ['../bower_components/angular-ui-utils/mask.min.js']
    }, {
        name: 'ngImgCrop',
        files: ['../bower_components/ngImgCrop/compile/minified/ng-img-crop.js', '../bower_components/ngImgCrop/compile/minified/ng-img-crop.css']
    }, {
        name: 'angularFileUpload',
        files: ['../bower_components/angular-file-upload/angular-file-upload.min.js']
    }, {
        name: 'ngAside',
        files: ['../bower_components/angular-aside/dist/js/angular-aside.min.js', '../bower_components/angular-aside/dist/css/angular-aside.min.css']
    }, {
        name: 'truncate',
        files: ['../bower_components/angular-truncate/src/truncate.js']
    }, {
        name: 'oitozero.ngSweetAlert',
        files: ['../bower_components/angular-sweetalert-promised/SweetAlert.min.js']
    }, {
        name: 'monospaced.elastic',
        files: ['../bower_components/angular-elastic/elastic.js']
    }, {
        name: 'ngMap',
        files: ['../bower_components/ngmap/build/scripts/ng-map.min.js']
    }, {
        name: 'tc.chartjs',
        files: ['../bower_components/tc-angular-chartjs/dist/tc-angular-chartjs.min.js']
    }, {
        name: 'flow',
        files: ['../bower_components/ng-flow/dist/ng-flow-standalone.min.js']
    }, {
        name: 'uiSwitch',
        files: ['../bower_components/angular-ui-switch/angular-ui-switch.min.js', '../bower_components/angular-ui-switch/angular-ui-switch.min.css']
    }, {
        name: 'ckeditor',
        files: ['../bower_components/angular-ckeditor/angular-ckeditor.min.js']
    }, {
        name: 'mwl.calendar',
        files: ['../bower_components/angular-bootstrap-calendar/dist/js/angular-bootstrap-calendar-tpls.js', '../bower_components/angular-bootstrap-calendar/dist/css/angular-bootstrap-calendar.min.css', 'assets/js/config/config-calendar.js']
    }, {
        name: 'ng-nestable',
        files: ['../bower_components/ng-nestable/src/angular-nestable.js']
    }, {
        name: 'vAccordion',
        files: ['../bower_components/v-accordion/dist/v-accordion.min.js', '../bower_components/v-accordion/dist/v-accordion.min.css']
    }, {
        name: 'xeditable',
        files: ['../bower_components/angular-xeditable/dist/js/xeditable.min.js', '../bower_components/angular-xeditable/dist/css/xeditable.css', 'assets/js/config/config-xeditable.js']
    }, {
        name: 'checklist-model',
        files: ['../bower_components/checklist-model/checklist-model.js']
    }, {
        name: 'angular-notification-icons',
        files: ['../bower_components/angular-notification-icons/dist/angular-notification-icons.min.js', '../bower_components/angular-notification-icons/dist/angular-notification-icons.min.css']
    }]
});


app.config(['$stateProvider', '$urlRouterProvider', '$controllerProvider', '$compileProvider', '$filterProvider', '$provide', '$ocLazyLoadProvider', 'JS_REQUIRES',
function ($stateProvider, $urlRouterProvider, $controllerProvider, $compileProvider, $filterProvider, $provide, $ocLazyLoadProvider, jsRequires) {

	app.controller = $controllerProvider.register;
	app.directive = $compileProvider.directive;
	app.filter = $filterProvider.register;
	app.factory = $provide.factory;
	app.service = $provide.service;
	app.constant = $provide.constant;
	app.value = $provide.value;

	// LAZY MODULES

	$ocLazyLoadProvider.config({
		debug: false,
		events: true,
		modules: jsRequires.modules
	});

	// APPLICATION ROUTES
	// -----------------------------------
	// For any unmatched url, redirect to /app/dashboard
	$urlRouterProvider.otherwise("/app/dashboard");
	//
	// Set up the states
	$stateProvider.state('/', {
		url: "/",
		//templateUrl: "assets/views/app.html",
		resolve: loadSequence('modernizr', 'moment', 'angularMoment', 'uiSwitch', 'perfect-scrollbar-plugin', 'toaster', 'ngAside', 'vAccordion', 'sweet-alert', 'chartjs', 'tc.chartjs', 'oitozero.ngSweetAlert', 'chatCtrl', 'truncate', 'htmlToPlaintext', 'angular-notification-icons'),
		abstract: true
	}).state('dashboard', {
		url: "/dashboard",
		//templateUrl: "assets/views/dashboard.html",
		resolve: loadSequence('jquery-sparkline'),
		title: 'Dashboard',
		ncyBreadcrumb: {
			label: 'Dashboard'
		}
	});

	// Generates a resolve object previously configured in constant.JS_REQUIRES (config.constant.js)
	function loadSequence() {
		var _args = arguments;
		return {
			deps: ['$ocLazyLoad', '$q',
			function ($ocLL, $q) {
				var promise = $q.when(1);
				for (var i = 0, len = _args.length; i < len; i++) {
					promise = promiseThen(_args[i]);
				}
				return promise;

				function promiseThen(_arg) {
					if (typeof _arg == 'function')
					return promise.then(_arg);
					else
					return promise.then(function () {
						var nowLoad = requiredData(_arg);
						if (!nowLoad)
						return $.error('Route resolve: Bad resource name [' + _arg + ']');
						return $ocLL.load(nowLoad);
					});
				}

				function requiredData(name) {
					if (jsRequires.modules)
					for (var m in jsRequires.modules)
					if (jsRequires.modules[m].name && jsRequires.modules[m].name === name)
					return jsRequires.modules[m];
					return jsRequires.scripts && jsRequires.scripts[name];
				}
			}]
		};
	}
}]);
