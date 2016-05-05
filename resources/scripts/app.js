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
	'ngRoute',
	'ngAnimate',
	'ngCookies',
	'ngStorage',
	'ngSanitize',
	'ngTouch',
	'ui.router',
	'ui.bootstrap',
	'oc.lazyLoad',
	'cfp.loadingBar',
	'colorpicker.module',
	'ncy-angular-breadcrumb',
	'duScroll',
	'pascalprecht.translate',
	'chart.js'
]).config(function($locationProvider) {
	$locationProvider.html5Mode(true);
});

app.constant('APP_MEDIAQUERY', {
    'desktopXL': 1200,
    'desktop': 992,
    'tablet': 768,
    'mobile': 480
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
