<!DOCTYPE html>

<html ng-app="avtoplin_app">

	<base href="/avtoplin_new/index.php/" />


	<!--SCRIPTS-->
	<script type="text/javascript" src="<?php echo base_url(); ?>resources/libs/js/jquery.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>resources/libs/js/jquery-ui.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>resources/libs/js/angular.min.js"></script>
	<script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.2.18/angular-sanitize.js"></script>
	<script src="<?php echo base_url(); ?>bower_components/angular-cookies/angular-cookies.min.js"></script>
	<script src="<?php echo base_url(); ?>bower_components/ngstorage/ngStorage.min.js"></script>
	<script src="<?php echo base_url(); ?>bower_components/angular-touch/angular-touch.min.js"></script>
	<script src="<?php echo base_url(); ?>bower_components/angular-ui-router/release/angular-ui-router.min.js"></script>
	<script src="<?php echo base_url(); ?>bower_components/oclazyload/dist/ocLazyLoad.min.js"></script>
	<script src="<?php echo base_url(); ?>bower_components/angular-loading-bar/build/loading-bar.min.js"></script>
	<script src="<?php echo base_url(); ?>bower_components/angular-breadcrumb/dist/angular-breadcrumb.min.js"></script>
	<script src="<?php echo base_url(); ?>bower_components/angular-scroll/angular-scroll.min.js"></script>
	<script src="<?php echo base_url(); ?>bower_components/angular-translate/angular-translate.min.js"></script>
	<script src="<?php echo base_url(); ?>bower_components/angular-translate-loader-url/angular-translate-loader-url.min.js"></script>
	<script src="<?php echo base_url(); ?>bower_components/angular-translate-loader-static-files/angular-translate-loader-static-files.min.js"></script>
	<script src="<?php echo base_url(); ?>bower_components/angular-translate-storage-local/angular-translate-storage-local.min.js"></script>
	<script src="<?php echo base_url(); ?>bower_components/angular-translate-storage-cookie/angular-translate-storage-cookie.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>resources/libs/js/angular-route.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>resources/libs/js/angular-material.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>resources/libs/js/angular-animate.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>resources/libs/js/angular-aria.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>resources/libs/js/ui-bootstrap-tpls-1.1.2.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>resources/libs/js/angular-growl.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>resources/libs/js/ng-pickadate.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>resources/libs/js/picker.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>resources/libs/js/picker.date.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>resources/libs/js/picker.time.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>resources/libs/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>resources/libs/js/bootstrap-colorpicker-module.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>resources/libs/js/select.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>resources/libs/js/highcharts.src.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>resources/libs/js/highcharts-ng.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>resources/libs/js/date.format.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>resources/scripts/app.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>resources/scripts/services/data.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>resources/scripts/services/directive.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>resources/scripts/controllers/header.js"></script>

	<!-- Global CSS -->
	<head>
		<!-- Global CSS -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<meta name="description" content="{{app.description}}">
		<meta name="keywords" content="app, responsive, angular, bootstrap, dashboard, admin">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
		<meta name="HandheldFriendly" content="true" />
		<meta name="apple-touch-fullscreen" content="yes" />
		<title data-ng-bind="pageTitle()">Clip-Two - Angular Bootstrap Admin Template</title>
		<!-- Google fonts -->
		<link href="http://fonts.googleapis.com/css?family=Lato:300,400,400italic,600,700|Raleway:300,400,500,600,700|Crete+Round:400italic" rel="stylesheet" type="text/css" />
		<!-- Bootstrap -->
		<link rel="stylesheet" href="../bower_components/bootstrap/dist/css/bootstrap.min.css">
		<!-- Font Awesome -->
		<link rel="stylesheet" href="../bower_components/font-awesome/css/font-awesome.min.css">
		<!-- Themify Icons -->
		<link rel="stylesheet" href="../bower_components/themify-icons/themify-icons.css">
		<!-- Loading Bar -->
		<link rel="stylesheet" href="../bower_components/angular-loading-bar/build/loading-bar.min.css">
		<!-- Animate Css -->
		<link rel="stylesheet" href="../bower_components/animate.css/animate.min.css">
		<!-- Clip-Two CSS -->
		<link rel="stylesheet" href="../STANDARD/assets/css/styles.css">
		<link rel="stylesheet" href="../STANDARD/assets/css/plugins.css">
		<!-- Clip-Two Theme -->
		<link rel="stylesheet" href="../STANDARD/assets/css/themes/theme-1.css" />

		<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>resources/libs/css/classic.css">
		<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>resources/libs/css/classic.date.css">
		<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>resources/libs/css/classic.time.css">
		<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>resources/libs/css/toaster.css">
		<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>resources/libs/css/angular-growl.min.css">
		<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>resources/libs/css/colopicker.css">
		<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>resources/libs/css/select.css">
		<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>resources/libs/css/select2.css">
		<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>resources/libs/css/selectize.default.css">
		<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>resources/libs/css/ng-animation.css">
	</head>

	<!-- LOAD SCRIPTS -->
    <?php load_scripts($this->router->class, 'css'); ?>
	<?php load_scripts($this->router->class, 'service'); ?>
	<?php load_scripts($this->router->class, 'js'); ?>

	<body class="main">
