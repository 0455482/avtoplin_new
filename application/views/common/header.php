<!DOCTYPE html>

<html ng-app="avtoplin_app">

<base href="/avtoplin_new/index.php/" />

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
	<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>resources/css/global.css">

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
	<link rel="stylesheet" href="../bower_components/angular-ui-select/dist/select.min.css">
	<link rel="stylesheet" href="../bower_components/select2/dist/css/select2.min.css">
	<link rel="stylesheet" href="../bower_components/selectize/dist/css/selectize.bootstrap3.css">
	<link rel="stylesheet" href="../bower_components/select2-bootstrap-css/select2-bootstrap.min.css">
	<link rel="stylesheet" href="../bower_components/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.css">
	<link rel="stylesheet" href="../bower_components/angular-chart.js/dist/angular-chart.css" />
</head>


<!-- start: SEARCH FORM -->
<div ng-class="{'app-mobile' : app.isMobile, 'app-navbar-fixed' : app.layout.isNavbarFixed, 'app-sidebar-fixed' : app.layout.isSidebarFixed, 'app-sidebar-closed':app.layout.isSidebarClosed, 'app-footer-fixed':app.layout.isFooterFixed}" ng-controller="headerCtrl">
	<div class="app-content ng-scope">
		<header class="navbar navbar-default navbar-static-top hidden-print ng-scope">
			<!-- start: TOP NAVBAR -->
			<!-- start: NAVBAR HEADER -->
			<div class="navbar-header">
				<a href="#" class="sidebar-mobile-toggler pull-left hidden-md hidden-lg" ng-click="toggle('sidebar')" class="btn btn-navbar sidebar-toggle"> <i class="ti-align-justify"></i> </a>
				<a class="navbar-brand" ui-sref="app.dashboard"> <div>{{app.name}}</div> </a>
				<a href="#" class="sidebar-toggler pull-right visible-md visible-lg" ng-click="app.layout.isSidebarClosed = !app.layout.isSidebarClosed"> <i class="ti-align-justify"></i> </a>
				<a class="pull-right menu-toggler visible-xs-block" id="menu-toggler" ng-click="navbarCollapsed = !navbarCollapsed"> <span class="sr-only">Toggle navigation</span> <i class="ti-view-grid"></i> </a>
			</div>
			<!-- end: NAVBAR HEADER -->
			<!-- start: NAVBAR COLLAPSE -->
			<div class="navbar-collapse collapse" uib-collapse="navbarCollapsed" ng-init="navbarCollapsed = true" off-click="navbarCollapsed = true" off-click-if='!navbarCollapsed' off-click-filter="#menu-toggler">
				<ul class="nav navbar-right" ct-fullheight="window" data-ct-fullheight-exclusion="header" data-ct-fullheight-if="isSmallDevice">
					<!-- start: MESSAGES DROPDOWN -->
					<!-- /// controller:  'InboxCtrl' -  localtion: assets/js/controllers/InboxCtrl.js /// -->

					<!-- end: MESSAGES DROPDOWN -->
					<!-- start: ACTIVITIES DROPDOWN -->
					<li class="dropdown" uib-dropdown on-toggle="toggled(open)">
						<a href class="dropdown-toggle" uib-dropdown-toggle> <i class="ti-check-box"></i> <span>ACTIVITIES</span> </a>
						<ul class="dropdown-menu dropdown-light dropdown-messages dropdown-large">
							<li>
								<span class="dropdown-header"> You have new notifications</span>
							</li>
							<li>
								<div class="drop-down-wrapper ps-container">
									<div class="list-group no-margin">
										<a class="media list-group-item" href=""> <img class="img-circle" alt="..." src="../STANDARD/assets/images/avatar-1.jpg"> <span class="media-body block no-margin"> Use awesome animate.css <small class="block text-grey">10 minutes ago</small> </span> </a>
										<a class="media list-group-item" href=""> <span class="media-body block no-margin"> 1.0 initial released <small class="block text-grey">1 hour ago</small> </span> </a>
									</div>
								</div>
							</li>
							<li class="view-all">
								<a href="#"> See All </a>
							</li>
						</ul>
					</li>
					<!-- end: ACTIVITIES DROPDOWN -->
					<!-- start: USER OPTIONS DROPDOWN -->
					<li class="dropdown current-user" uib-dropdown on-toggle="toggled(open)">
						<a href class="dropdown-toggle" uib-dropdown-toggle> <img src="../STANDARD/assets/images/avatar-1.jpg" alt="{{user.name}}"> <span class="username">{{user.name}} <i class="ti-angle-down"></i></i></span> </a>
						<ul class="dropdown-menu dropdown-dark">
							<li>
								<a ui-sref="app.pages.user"> My Profile </a>
							</li>
							<li>
								<a ui-sref="app.pages.calendar"> My Calendar </a>
							</li>
							<li>
								<a ui-sref="app.pages.messages"> My Messages (3) </a>
							</li>
							<li>
								<a ui-sref="login.lockscreen"> Lock Screen </a>
							</li>
							<li>
								<a ui-sref="login.signin"> Log Out </a>
							</li>
						</ul>
					</li>
					<!-- end: USER OPTIONS DROPDOWN -->
				</ul>
			</div>
		</header>
	</div>
	<div class="sidebar app-aside hidden-print ng-scope" id="sidebar" toggleable parent-active-class="app-slide-off">
		<div perfect-scrollbar wheel-propagation="false" suppress-scroll-x="true" class="sidebar-container ps-container ps-active-y">
			<nav>
				<div class="search-form">
					<a class="s-open" href="#">
						<i class="ti-search"></i>
					</a>
					<form class="navbar-form" role="search">
						<a class="s-remove" href="#" ng-toggle-class="search-open" target=".navbar-form">
							<i class="ti-close"></i>
						</a>
						<div class="form-group">
							<input type="text" class="form-control" placeholder="Search...">
							<button class="btn search-button" type="submit">
								<i class="ti-search"></i>
							</button>
						</div>
					</form>
				</div>
				<!-- end: SEARCH FORM -->
				<!-- start: MAIN NAVIGATION MENU -->
				<div class="navbar-title">
					<span>Main Navigation</span>
				</div>
				<ul class="main-navigation-menu">
					<li ui-sref-active="active">
						<a href="<?php echo base_url(); ?>index.php/dashboard" target="_self" ng-click="dashboard()">
							<div class="item-content">
								<div class="item-media">
									<i class="ti-home"></i>
								</div>
								<div class="item-inner">
									<span class="title"> Dashboard </span>
								</div>
							</div>
						</a>
					</li>
					<li ng-class="{'active open': settingsActive}">
						<a href="<?php echo base_url(); ?>index.php/settings" target="_self" ng-click="settings()">
							<div class="item-content">
								<div class="item-media">
									<i class="ti-settings"></i>
								</div>
								<div class="item-inner">
									<span class="title"> Nastavitve </span><i class="icon-arrow"></i>
								</div>
							</div>
						</a>
					<ul class="sub-menu">
						<li ui-sref-active="active">
							<a ng-click="usersActive()">
								<span class="title"> Uporabniki </span>
							</a>
						</li>
						<li ui-sref-active="active">
							<a ng-click="statusesActive()">
								<span class="title"> Statusi </span>
							</a>
						</li>
						<li ui-sref-active="active">
							<a ng-click="smsActive()">
								<span class="title"> SMS </span>
							</a>
						</li>
						<li ui-sref-active="active">
							<a ng-click="offerActive()">
								<span class="title"> Ponudba </span>
							</a>
						</li>
					</ul>
				</li>
					<li ui-sref-active="active">
						<a href="<?php echo base_url(); ?>index.php/statistics" target="_self" ng-click="statistics()">
							<div class="item-content">
								<div class="item-media">
									<i class="ti-bar-chart"></i>
								</div>
								<div class="item-inner">
									<span class="title"> Statistika </span>
								</div>
							</div>
						</a>
					</li>
				</ul>
			</nav>
		</div>
	</div>
<!-- end: DOCUMENTATION BUTTON -->


<!-- LOAD SCRIPTS -->
<?php load_scripts($this->router->class, 'css'); ?>
<script type="text/javascript">
var loged_this_week = <?php echo $this->session->userdata["data"]["logged_this_week"]; ?>;
</script>

<body>
	<!--SCRIPTS-->
	<script type="text/javascript" src="<?php echo base_url(); ?>resources/libs/js/jquery.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>resources/libs/js/jquery-ui.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>resources/libs/js/angular.min.js"></script>
	<script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.2.18/angular-sanitize.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>resources/libs/js/angular-route.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>resources/libs/js/angular-material.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>resources/libs/js/angular-animate.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>resources/libs/js/angular-aria.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>resources/libs/js/angular-growl.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>resources/libs/js/ng-pickadate.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>resources/libs/js/picker.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>resources/libs/js/picker.date.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>resources/libs/js/picker.time.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>resources/libs/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>resources/libs/js/bootstrap-colorpicker-module.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>resources/libs/js/select.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>resources/libs/js/date.format.js"></script>
	<script src="<?php echo base_url(); ?>bower_components/angular-bootstrap/ui-bootstrap-tpls.min.js"></script>
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
	<script src="<?php echo base_url(); ?>bower_components/angular-ui-select/dist/select.min.js"></script>
	<script src="<?php echo base_url(); ?>bower_components//angular-ui-utils/mask.min.js"></script>
	<script src="<?php echo base_url(); ?>bower_components/angular-elastic/elastic.js"></script>
	<script src="<?php echo base_url(); ?>bower_components/perfect-scrollbar/js/min/perfect-scrollbar.min.js"></script>
	<script src="<?php echo base_url(); ?>bower_components/perfect-scrollbar/js/min/perfect-scrollbar.jquery.min.js"></script>
	<script src="<?php echo base_url(); ?>bower_components/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.js"></script>
  	<script src="<?php echo base_url(); ?>bower_components/Chart.js/Chart.min.js"></script>
	<!-- <script src="<?php echo base_url(); ?>bower_components/chartjs/Chart.min.js"></script> -->
  	<script src="<?php echo base_url(); ?>bower_components/angular-chart.js/dist/angular-chart.min.js"></script>
	<script src="<?php echo base_url(); ?>bower_components/tc-angular-chartjs/dist/tc-angular-chartjs.min.js"></script>
	<script src="<?php echo base_url(); ?>bower_components/angular-translate-loader-static-files/angular-translate-loader-static-files.min.js"></script>
	<script src="<?php echo base_url(); ?>bower_components/angular-translate-storage-local/angular-translate-storage-local.min.js"></script>
	<script src="<?php echo base_url(); ?>bower_components/angular-translate-storage-cookie/angular-translate-storage-cookie.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>resources/scripts/app.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>resources/scripts/services/data.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>resources/scripts/services/directive.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>resources/scripts/services/select.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>resources/scripts/services/char-limit.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>resources/scripts/services/chat.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>resources/scripts/services/compare-to.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>resources/scripts/services/dismiss.js"></script>
	<!-- <script type="text/javascript" src="<?php echo base_url(); ?>resources/scripts/services/empty-links.js"></script> -->
	<script type="text/javascript" src="<?php echo base_url(); ?>resources/scripts/services/file-upload.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>resources/scripts/services/full-height.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>resources/scripts/services/messages.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>resources/scripts/services/off-click.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>resources/scripts/services/panel-tools.js"></script>
	<!-- <script type="text/javascript" src="<?php echo base_url(); ?>resources/scripts/services/perfect-scrollbar.js"></script> -->
	<!-- <script type="text/javascript" src="<?php echo base_url(); ?>resources/scripts/services/sidebars.js"></script> -->
	<script type="text/javascript" src="<?php echo base_url(); ?>resources/scripts/services/sparkline.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>resources/scripts/services/toggle.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>resources/scripts/services/touchspin.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>resources/scripts/controllers/header.js"></script>


	<?php load_scripts($this->router->class, 'service'); ?>
	<?php load_scripts($this->router->class, 'js');?>
