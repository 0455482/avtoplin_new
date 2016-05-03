var app = angular.module('avtoplin_app', 
	['ngRoute', 
	'ngAnimate', 
	'ui.bootstrap', 
	'pickadate', 
	'angular-growl', 
	'colorpicker.module',
	'ngMaterial',
	'ngSanitize',
	'ui.select',
	'highcharts-ng'])
	.config(function($locationProvider, $mdDateLocaleProvider) {
    	$locationProvider.html5Mode(true);
	})
	
	app.filter('num', function() {
		return function(input) {
			return parseInt(input, 10);
		};
	});