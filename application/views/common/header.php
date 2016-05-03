<!DOCTYPE html>

<html ng-app="avtoplin_app">

	<base href="/avtoplin_new/index.php/" />

	<head>
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
		<link rel="stylesheet" href="assets/css/styles.css">
		<link rel="stylesheet" href="assets/css/plugins.css">
		<!-- Clip-Two Theme -->
		<link rel="stylesheet" data-ng-href="assets/css/themes/{{ app.layout.theme }}.css" />


		<!-- Global CSS -->
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
	</head>


	<!-- LOAD SCRIPTS -->
    <?php load_scripts($this->router->class, 'css'); ?>
	<?php load_scripts($this->router->class, 'service'); ?>
	<?php load_scripts($this->router->class, 'js');?>
    <script type="text/javascript">
        var loged_this_week = <?php echo $this->session->userdata["data"]["logged_this_week"]; ?>;
    </script>

	<body class="main">
        <header class="main_header">
            <div class="logo_image">
                <div class="left_logo">
                    <img src="/avtoplin_new/resources/images/g1_logo_beli.png"/>
                </div>
                <div class="center_logo_image">
                    <img src="/avtoplin_new/resources/images/admin_logo.png"/>
                    <label class="header_heading">Administracija G-1 D.O.O.</label>
                </div>
                <div class="right_side">
                    <div class="together">
                        <img src="/avtoplin_new/resources/images/kljucavnica_zaklenjena.png"/>
                        <label class="">Prijavljeni ste kot: <?php echo $this->session->userdata['data']['username'] ?></label>
                    </div>
                </div>
            </div>
            <!-- Main nav -->
            <nav ng-controller="navigationCtrl" ng-init="getCurTabSelected()" class="justify_flex">
                <!-- Main links -->
                <ul id="main_nav_links" class="main_links flex">
                    <li ng-class="{active: (tab_selected == 1) ? true : false}" ng-click="selectTab(1)">
                        <a href="<?php echo base_url(); ?>index.php/dashboard" target="_self">NAMIZJE</a>
                    </li>
                    <li ng-class="{active: (tab_selected == 2) ? true : false}" ng-click="selectTab(2)">
                        <a href="<?php echo base_url(); ?>index.php/settings" target="_self">NASTAVITVE</a>
                    </li>
                    <li ng-class="{active: (tab_selected == 3) ? true : false}" ng-click="selectTab(3)">
                        <a href="<?php echo base_url(); ?>index.php/statistics" target="_self">STATISTIKA</a>
                    </li>
                </ul>
                <!-- Logout -->
                <a href="<?php echo base_url(); ?>index.php/logout" target="_self">Odjava</a>
            </nav>
        </header>

        <script type="text/ng-template" id="loged_this_week.html">
            <md-dialog aria-label="Old order details" class="old_order_modal" ng-cloak>
                <md-toolbar style="background-color: rgb(255, 62, 12);">
                    <div class="md-toolbar-tools">
                    <h2>Opozorilo</h2>
                    <span flex></span>
                    <md-button class="md-icon-button" ng-click="cancel()">
                        <md-icon md-svg-src="/avtoplin/resources/images/ic_clear_white_24px.svg" aria-label="Close dialog"></md-icon>
                    </md-button>
                    </div>
                </md-toolbar>
                <md-dialog-content>
                    <div class="md-dialog-content">
                        <p><b> OPOZORILO: Pozor, prosim čimprej uskladite realizacije prejšnjega tedna! Hvala. </b></p>
                    </div>
                </md-dialog-content>
                <md-dialog-actions layout="row">
                    <md-button type="button" ng-click="cancel()" class="md-raised">V redu</md-button>
                </md-dialog-actions>
            </md-dialog>
        </script>


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
				    <script type="text/javascript" src="<?php echo base_url(); ?>resources/libs/js/date.format.js"></script>
					<script type="text/javascript" src="<?php echo base_url(); ?>resources/scripts/app.js"></script>
				    <script type="text/javascript" src="<?php echo base_url(); ?>resources/scripts/services/data.js"></script>
				    <script type="text/javascript" src="<?php echo base_url(); ?>resources/scripts/services/directive.js"></script>
				    <script type="text/javascript" src="<?php echo base_url(); ?>resources/scripts/controllers/header.js"></script>
