<!DOCTYPE html>

<html ng-app="avtoplin_app">
	
	<base href="/avtoplin/index.php/" />
	
	
	<!--SCRIPTS-->
	<script type="text/javascript" src="<?php echo base_url(); ?>resources/libs/js/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>resources/libs/js/jquery-ui.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>resources/libs/js/angular.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.2.18/angular-sanitize.js"></script>
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
	<script type="text/javascript" src="<?php echo base_url(); ?>resources/scripts/app.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>resources/scripts/services/data.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>resources/scripts/services/directive.js"></script>
   
	<!-- Global CSS -->
	<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>resources/libs/css/bootstrap.min.css">
    <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>resources/libs/css/bootstrap.css">
    <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>resources/libs/css/classic.css">
	<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>resources/libs/css/classic.date.css">
    <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>resources/libs/css/classic.time.css">
	<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>resources/libs/css/toaster.css">
	<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>resources/libs/css/angular-growl.min.css">
	<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>resources/libs/css/angular-material.min.css">
    <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>resources/libs/css/colopicker.css">
    <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>resources/libs/css/select.css">
    <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>resources/libs/css/select2.css">
    <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>resources/libs/css/selectize.default.css">
    <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>resources/libs/css/ng-animation.css">
    <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>resources/css/global.css">
    
	<!-- LOAD SCRIPTS -->
    <?php load_scripts($this->router->class, 'css'); ?>
	<?php load_scripts($this->router->class, 'service'); ?>
	<?php load_scripts($this->router->class, 'js'); ?>
	
	<body class="main">