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
