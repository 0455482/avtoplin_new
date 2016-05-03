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
					<a href class="dropdown-toggle" uib-dropdown-toggle> <i class="ti-check-box"></i> <span translate="topbar.activities.MAIN">ACTIVITIES</span> </a>
					<ul class="dropdown-menu dropdown-light dropdown-messages dropdown-large">
						<li>
							<span class="dropdown-header" translate="topbar.activities.HEADER"> You have new notifications</span>
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
							<a href="#" translate="topbar.activities.SEEALL"> See All </a>
						</li>
					</ul>
				</li>
				<!-- end: ACTIVITIES DROPDOWN -->
				<!-- start: LANGUAGE SWITCHER -->
				<li class="dropdown" uib-dropdown on-toggle="toggled(open)">
					<a href class="dropdown-toggle" uib-dropdown-toggle> <i class="ti-world"></i> {{language.selected}} </a>
					<ul role="menu" class="dropdown-menu dropdown-light fadeInUpShort">
						<li ng-repeat="(localeId, langName) in language.available">
							<a ng-click="language.set(localeId, $event)" href="#" class="menu-toggler"> {{langName}} </a>
						</li>
					</ul>
				</li>
				<!-- start: LANGUAGE SWITCHER -->
				<!-- start: USER OPTIONS DROPDOWN -->
				<li class="dropdown current-user" uib-dropdown on-toggle="toggled(open)">
					<a href class="dropdown-toggle" uib-dropdown-toggle> <img src="../STANDARD/assets/images/avatar-1.jpg" alt="{{user.name}}"> <span class="username">{{user.name}} <i class="ti-angle-down"></i></i></span> </a>
					<ul class="dropdown-menu dropdown-dark">
						<li>
							<a ui-sref="app.pages.user" translate="topbar.user.PROFILE"> My Profile </a>
						</li>
						<li>
							<a ui-sref="app.pages.calendar" translate="topbar.user.CALENDAR"> My Calendar </a>
						</li>
						<li>
							<a ui-sref="app.pages.messages" translate="topbar.user.MESSAGES"> My Messages (3) </a>
						</li>
						<li>
							<a ui-sref="login.lockscreen" translate="topbar.user.LOCKSCREEN"> Lock Screen </a>
						</li>
						<li>
							<a ui-sref="login.signin" translate="topbar.user.LOGOUT"> Log Out </a>
						</li>
					</ul>
				</li>
				<!-- end: USER OPTIONS DROPDOWN -->
			</ul>
			<!-- start: MENU TOGGLER FOR MOBILE DEVICES -->
			<div class="close-handle visible-xs-block menu-toggler" ng-click="navbarCollapsed = true">
				<div class="arrow-left"></div>
				<div class="arrow-right"></div>
			</div>
			<!-- end: MENU TOGGLER FOR MOBILE DEVICES -->
		</div>
		<a class="sidebar-mobile-toggler dropdown-off-sidebar hidden-md hidden-lg" ng-click="toggle('off-sidebar')"> &nbsp; </a>
		<a class="dropdown-off-sidebar hidden-sm hidden-xs" ng-click="toggle('off-sidebar')"> &nbsp; </a>
		<!-- end: NAVBAR COLLAPSE -->
		<!-- start: TOP NAVBAR -->

	</header>

	<div class="sidebar app-aside hidden-print ng-scope" id="sidebar" toggleable parent-active-class="app-slide-off">
		<div perfect-scrollbar wheel-propagation="false" suppress-scroll-x="true" class="sidebar-container ps-container ps-active-y">
			<!-- start: SEARCH FORM -->
			<nav>
				<div ng-class="{'app-mobile' : app.isMobile, 'app-navbar-fixed' : app.layout.isNavbarFixed, 'app-sidebar-fixed' : app.layout.isSidebarFixed, 'app-sidebar-closed':app.layout.isSidebarClosed, 'app-footer-fixed':app.layout.isFooterFixed}">
					<div class="search-form">
						<a class="s-open" href="#">
							<i class="ti-search"></i>
						</a>
						<form class="navbar-form" role="search">
							<a class="s-remove" href="#" ng-toggle-class="search-open" target=".navbar-form">
								<i class="ti-close"></i>
							</a>
							<div class="form-group">
								<input type="text" class="form-control" placeholder="{{ 'sidebar.search.PLACEHOLDER' | translate }}">
								<button class="btn search-button" type="submit">
									<i class="ti-search"></i>
								</button>
							</div>
						</form>
					</div>
					<!-- end: SEARCH FORM -->
					<!-- start: MAIN NAVIGATION MENU -->
					<div class="navbar-title">
						<span translate="sidebar.heading.NAVIGATION">Main Navigation</span>
					</div>
					<ul class="main-navigation-menu">
						<li ui-sref-active="active">
							<a ui-sref="app.dashboard">
								<div class="item-content">
									<div class="item-media">
										<i class="ti-home"></i>
									</div>
									<div class="item-inner">
										<span class="title" translate="sidebar.nav.dashboard.MAIN"> Dashboard </span>
									</div>
								</div>
							</a>
						</li>
						<li ng-class="{'active open':$state.includes('app.ui')}">
							<a href="javascript:void(0)">
								<div class="item-content">
									<div class="item-media">
										<i class="ti-settings"></i>
									</div>
									<div class="item-inner">
										<span class="title" translate="sidebar.nav.element.MAIN"> UI Elements </span><i class="icon-arrow"></i>
									</div>
								</div>
							</a>
							<ul class="sub-menu">
								<li ui-sref-active="active">
									<a ui-sref="app.ui.elements">
										<span class="title" translate="sidebar.nav.element.ELEMENTS"> Elements </span>
									</a>
								</li>
								<li ui-sref-active="active">
									<a ui-sref="app.ui.buttons">
										<span class="title" translate="sidebar.nav.element.BUTTONS"> Buttons </span>
									</a>
								</li>
								<li ui-sref-active="active">
									<a ui-sref="app.ui.links">
										<span class="title" translate="sidebar.nav.element.LINKS"> Links </span>
									</a>
								</li>
								<li ui-sref-active="active">
									<a ui-sref="app.ui.icons">
										<span class="title" translate="sidebar.nav.element.FONTAWESOME"> Font Awesome Icons </span>
									</a>
								</li>
								<li ui-sref-active="active">
									<a ui-sref="app.ui.lineicons">
										<span class="title" translate="sidebar.nav.element.LINEARICONS"> Linear Icons </span>
									</a>
								</li>
								<li ui-sref-active="active">
									<a ui-sref="app.ui.modals">
										<span class="title" translate="sidebar.nav.element.MODALS"> Modals </span>
									</a>
								</li>
								<li ui-sref-active="active">
									<a ui-sref="app.ui.toggle">
										<span class="title" translate="sidebar.nav.element.TOGGLE"> Toggle </span>
									</a>
								</li>
								<li ui-sref-active="active">
									<a ui-sref="app.ui.tabs_accordions">
										<span class="title" translate="sidebar.nav.element.TABS"> Tabs &amp; Accordions </span>
									</a>
								</li>
								<li ui-sref-active="active">
									<a ui-sref="app.ui.panels">
										<span class="title" translate="sidebar.nav.element.PANELS"> Panels </span>
									</a>
								</li>
								<li ui-sref-active="active">
									<a ui-sref="app.ui.notifications">
										<span class="title" translate="sidebar.nav.element.NOTIFICATIONS"> Notifications </span>
									</a>
								</li>
								<li ui-sref-active="active">
									<a ui-sref="app.ui.treeview">
										<span class="title" translate="sidebar.nav.element.TREEVIEW"> Treeview </span>
									</a>
								</li>
								<li ui-sref-active="active">
									<a ui-sref="app.ui.media">
										<span class="title" translate="sidebar.nav.element.MEDIA"> Media Object </span>
									</a>
								</li>
								<li ui-sref-active="active">
									<a ui-sref="app.ui.nestable">
										<span class="title" translate="sidebar.nav.element.NESTABLE"> Nestable List </span>
									</a>
								</li>
								<li ui-sref-active="active">
									<a ui-sref="app.ui.typography">
										<span class="title" translate="sidebar.nav.element.TYPOGRAPHY"> Typography </span>
									</a>
								</li>
							</ul>
						</li>
						<li ng-class="{'active open':$state.includes('app.table')}">
							<a href="javascript:void(0)">
								<div class="item-content">
									<div class="item-media">
										<i class="ti-layout-grid2"></i>
									</div>
									<div class="item-inner">
										<span class="title" translate="sidebar.nav.tables.MAIN"> Tables </span><i class="icon-arrow"></i>
									</div>
								</div>
							</a>
							<ul class="sub-menu">
								<li ui-sref-active="active">
									<a ui-sref="app.table.basic">
										<span class="title" translate="sidebar.nav.tables.BASIC">Basic Tables</span>
									</a>
								</li>
								<li ui-sref-active="active">
									<a ui-sref="app.table.responsive">
										<span class="title" translate="sidebar.nav.tables.RESPONSIVE">Responsive Tables</span>
									</a>
								</li>
								<li ui-sref-active="active">
									<a ui-sref="app.table.dynamic">
										<span class="title" translate="sidebar.nav.tables.DYNAMIC">Dynamic Tables</span>
									</a>
								</li>
								<li ui-sref-active="active">
									<a ui-sref="app.table.data">
										<span class="title" translate="sidebar.nav.tables.DATA">Advanced Data Tables</span>
									</a>
								</li>
							</ul>
						</li>
						<li ng-class="{'active open':$state.includes('app.form')}">
							<a href="javascript:void(0)">
								<div class="item-content">
									<div class="item-media">
										<i class="ti-pencil-alt"></i>
									</div>
									<div class="item-inner">
										<span class="title" translate="sidebar.nav.forms.MAIN"> Forms </span><i class="icon-arrow"></i>
									</div>
								</div>
							</a>
							<ul class="sub-menu">
								<li ui-sref-active="active">
									<a ui-sref="app.form.elements">
										<span class="title" translate="sidebar.nav.forms.ELEMENTS">Form Elements</span>
									</a>
								</li>
								<li ui-sref-active="active">
									<a ui-sref="app.form.xeditable">
										<span class="title" translate="sidebar.nav.forms.XEDITABLE">Form Elements</span>
									</a>
								</li>
								<li ui-sref-active="active">
									<a ui-sref="app.form.texteditor">
										<span class="title" translate="sidebar.nav.forms.TEXTEDITOR">Text Editor</span>
									</a>
								</li>
								<li ui-sref-active="active">
									<a ui-sref="app.form.wizard">
										<span class="title" translate="sidebar.nav.forms.WIZARD">Form Wizard</span>
									</a>
								</li>
								<li ui-sref-active="active">
									<a ui-sref="app.form.validation">
										<span class="title" translate="sidebar.nav.forms.VALIDATION">Form Validation</span>
									</a>
								</li>
								<li ui-sref-active="active">
									<a ui-sref="app.form.cropping">
										<span class="title" translate="sidebar.nav.forms.CROPPING">Image Cropping</span>
									</a>
								</li>
								<li ui-sref-active="active">
									<a ui-sref="app.form.upload">
										<span class="title" translate="sidebar.nav.forms.UPLOAD">Multiple File Upload</span>
									</a>
								</li>
							</ul>
						</li>
						<li ng-class="{'active open':$state.includes('login')}">
							<a href="javascript:void(0)">
								<div class="item-content">
									<div class="item-media">
										<i class="ti-user"></i>
									</div>
									<div class="item-inner">
										<span class="title" translate="sidebar.nav.login.MAIN"> Login </span><i class="icon-arrow"></i>
									</div>
								</div>
							</a>
							<ul class="sub-menu">
								<li ui-sref-active="active">
									<a ui-sref="login.signin">
										<span class="title" translate="sidebar.nav.login.LOGIN"> Login Form </span>
									</a>
								</li>
								<li ui-sref-active="active">
									<a ui-sref="login.registration">
										<span class="title" translate="sidebar.nav.login.REGISTRATION"> Registration Form </span>
									</a>
								</li>
								<li ui-sref-active="active">
									<a ui-sref="login.forgot" translate="sidebar.nav.login.FORGOT">
										<span class="title"> Forgot Password Form </span>
									</a>
								</li>
								<li ui-sref-active="active">
									<a ui-sref="login.lockscreen" translate="sidebar.nav.login.LOCKSCREEN">
										<span class="title">Lock Screen</span>
									</a>
								</li>
							</ul>
						</li>
						<li ng-class="{'active open':$state.includes('app.pages')}">
							<a href="javascript:void(0)">
								<div class="item-content">
									<div class="item-media">
										<i class="ti-layers-alt"></i>
									</div>
									<div class="item-inner">
										<span class="title" translate="sidebar.nav.pages.MAIN"> Pages </span><i class="icon-arrow"></i>
									</div>
								</div>
							</a>
							<ul class="sub-menu">
								<li ui-sref-active="active">
									<a ui-sref="app.pages.user">
										<span class="title" translate="sidebar.nav.pages.USERPROFILE">User Profile</span>
									</a>
								</li>
								<li ui-sref-active="active">
									<a ui-sref="app.pages.invoice">
										<span class="title" translate="sidebar.nav.pages.INVOICE">Invoice</span>
									</a>
								</li>
								<li ui-sref-active="active">
									<a ui-sref="app.pages.timeline">
										<span class="title" translate="sidebar.nav.pages.TIMELINE">Timeline</span>
									</a>
								</li>
								<li ui-sref-active="active">
									<a ui-sref="app.pages.calendar">
										<span class="title" translate="sidebar.nav.pages.CALENDAR">Calendar</span>
									</a>
								</li>
								<li ui-sref-active="active">
									<a ui-sref="app.pages.messages">
										<span class="title" translate="sidebar.nav.pages.MESSAGES">Messages</span>
									</a>
								</li>
								<li ui-sref-active="active">
									<a ui-sref="app.pages.blank">
										<span class="title" translate="sidebar.nav.pages.BLANKPAGE">Blank Page</span>
									</a>
								</li>
							</ul>
						</li>
						<li ng-class="{'active open':$state.includes('app.utilities')}">
							<a href="javascript:void(0)">
								<div class="item-content">
									<div class="item-media">
										<i class="ti-package"></i>
									</div>
									<div class="item-inner">
										<span class="title" translate="sidebar.nav.utilities.MAIN"> Utilities </span><i class="icon-arrow"></i>
									</div>
								</div>
							</a>
							<ul class="sub-menu">
								<li ui-sref-active="active">
									<a ui-sref="app.utilities.search">
										<span class="title" translate="sidebar.nav.utilities.SEARCHRESULT">Search Results</span>
									</a>
								</li>
								<li ui-sref-active="active">
									<a ui-sref="error.404">
										<span class="title" translate="sidebar.nav.utilities.ERROR404">Error 404</span>
									</a>
								</li>
								<li ui-sref-active="active">
									<a ui-sref="error.500">
										<span class="title" translate="sidebar.nav.utilities.ERROR500">Error 500</span>
									</a>
								</li>
								<li ui-sref-active="active">
									<a ui-sref="app.utilities.pricing">
										<span class="title" translate="sidebar.nav.utilities.PRICING">Pricing Table</span>
									</a>
								</li>
							</ul>
						</li>
						<li>
							<a href="javascript:void(0)">
								<div class="item-content">
									<div class="item-media">
										<i class="ti-folder"></i>
									</div>
									<div class="item-inner">
										<span class="title" translate="sidebar.nav.3level.MAIN"> 3 Level Menu </span><i class="icon-arrow"></i>
									</div>
								</div>
							</a>
							<ul class="sub-menu">
								<li>
									<a href="javascript:;">
										<span translate="sidebar.nav.3level.Item1.MAIN">Item 1</span> <i class="icon-arrow"></i>
									</a>
									<ul class="sub-menu">
										<li>
											<a href="#" translate="sidebar.nav.3level.Item1.LINK1">
												Sample Link 1
											</a>
										</li>
										<li>
											<a href="#" translate="sidebar.nav.3level.Item1.LINK2">
												Sample Link 2
											</a>
										</li>
										<li>
											<a href="#" translate="sidebar.nav.3level.Item1.LINK3">
												Sample Link 3
											</a>
										</li>
									</ul>
								</li>
								<li>
									<a href="javascript:;">
										<span translate="sidebar.nav.3level.Item2.MAIN">Item 2</span> <i class="icon-arrow"></i>
									</a>
									<ul class="sub-menu">
										<li>
											<a href="#" translate="sidebar.nav.3level.Item2.LINK1">
												Sample Link 1
											</a>
										</li>
										<li>
											<a href="#" translate="sidebar.nav.3level.Item2.LINK1">
												Sample Link 2
											</a>
										</li>
										<li>
											<a href="#" translate="sidebar.nav.3level.Item2.LINK1">
												Sample Link 3
											</a>
										</li>
									</ul>
								</li>
								<li>
									<a href="javascript:;">
										<span translate="sidebar.nav.3level.Item3.MAIN">Item 3</span> <i class="icon-arrow"></i>
									</a>
									<ul class="sub-menu">
										<li>
											<a href="#" translate="sidebar.nav.3level.Item3.LINK1">
												Sample Link 1
											</a>
										</li>
										<li>
											<a href="#" translate="sidebar.nav.3level.Item3.LINK1">
												Sample Link 2
											</a>
										</li>
										<li>
											<a href="#" translate="sidebar.nav.3level.Item3.LINK1">
												Sample Link 3
											</a>
										</li>
									</ul>
								</li>
							</ul>
						</li>
						<li>
							<a href="javascript:void(0)">
								<div class="item-content">
									<div class="item-media">
										<i class="ti-menu-alt"></i>
									</div>
									<div class="item-inner">
										<span class="title" translate="sidebar.nav.4level.MAIN"> 4 Level Menu </span><i class="icon-arrow"></i>
									</div>
								</div>
							</a>
							<ul class="sub-menu">
								<li>
									<a href="javascript:;">
										<span translate="sidebar.nav.4level.Item1.MAIN">Item 1</span> <i class="icon-arrow"></i>
									</a>
									<ul class="sub-menu">
										<li>
											<a href="javascript:;">
												<span translate="sidebar.nav.4level.Item1.link1.MAIN">Sample Link 1</span> <i class="icon-arrow"></i>
											</a>
											<ul class="sub-menu">
												<li>
													<a href="#" translate="sidebar.nav.4level.Item1.link1.LINK1">
														Sample Link 1
													</a>
												</li>
												<li>
													<a href="#" translate="sidebar.nav.4level.Item1.link1.LINK2">
														Sample Link 2
													</a>
												</li>
												<li>
													<a href="#" translate="sidebar.nav.4level.Item1.link1.LINK3">
														Sample Link 3
													</a>
												</li>
											</ul>
										</li>
										<li>
											<a href="javascript:;">
												<span translate="sidebar.nav.4level.Item1.link2.MAIN">Sample Link 2</span> <i class="icon-arrow"></i>
											</a>
											<ul class="sub-menu">
												<li>
													<a href="#" translate="sidebar.nav.4level.Item1.link2.LINK1">
														Sample Link 1
													</a>
												</li>
												<li>
													<a href="#" translate="sidebar.nav.4level.Item1.link2.LINK2">
														Sample Link 2
													</a>
												</li>
												<li>
													<a href="#" translate="sidebar.nav.4level.Item1.link2.LINK3">
														Sample Link 3
													</a>
												</li>
											</ul>
										</li>
										<li>
											<a href="javascript:;">
												<span translate="sidebar.nav.4level.Item1.link3.MAIN">Sample Link 3</span> <i class="icon-arrow"></i>
											</a>
											<ul class="sub-menu">
												<li>
													<a href="#" translate="sidebar.nav.4level.Item1.link3.LINK1">
														Sample Link 1
													</a>
												</li>
												<li>
													<a href="#" translate="sidebar.nav.4level.Item1.link3.LINK2">
														Sample Link 2
													</a>
												</li>
												<li>
													<a href="#" translate="sidebar.nav.4level.Item1.link3.LINK3">
														Sample Link 3
													</a>
												</li>
											</ul>
										</li>
									</ul>
								</li>
								<li>
									<a href="javascript:;">
										<span translate="sidebar.nav.4level.Item2.MAIN">Item 2</span> <i class="icon-arrow"></i>
									</a>
									<ul class="sub-menu">
										<li>
											<a href="javascript:;">
												<span translate="sidebar.nav.4level.Item2.link1.MAIN">Sample Link 1</span> <i class="icon-arrow"></i>
											</a>
											<ul class="sub-menu">
												<li>
													<a href="#" translate="sidebar.nav.4level.Item2.link1.LINK1">
														Sample Link 1
													</a>
												</li>
												<li>
													<a href="#" translate="sidebar.nav.4level.Item2.link1.LINK2">
														Sample Link 2
													</a>
												</li>
												<li>
													<a href="#" translate="sidebar.nav.4level.Item2.link1.LINK3">
														Sample Link 3
													</a>
												</li>
											</ul>
										</li>
										<li>
											<a href="javascript:;">
												<span translate="sidebar.nav.4level.Item2.link2.MAIN">Sample Link 2</span> <i class="icon-arrow"></i>
											</a>
											<ul class="sub-menu">
												<li>
													<a href="#" translate="sidebar.nav.4level.Item2.link2.LINK1">
														Sample Link 1
													</a>
												</li>
												<li>
													<a href="#" translate="sidebar.nav.4level.Item2.link2.LINK2">
														Sample Link 2
													</a>
												</li>
												<li>
													<a href="#" translate="sidebar.nav.4level.Item2.link2.LINK3">
														Sample Link 3
													</a>
												</li>
											</ul>
										</li>
										<li>
											<a href="javascript:;">
												<span translate="sidebar.nav.4level.Item2.link3.MAIN">Sample Link 3</span> <i class="icon-arrow"></i>
											</a>
											<ul class="sub-menu">
												<li>
													<a href="#" translate="sidebar.nav.4level.Item2.link3.LINK1">
														Sample Link 1
													</a>
												</li>
												<li>
													<a href="#" translate="sidebar.nav.4level.Item2.link3.LINK2">
														Sample Link 2
													</a>
												</li>
												<li>
													<a href="#" translate="sidebar.nav.4level.Item2.link3.LINK3">
														Sample Link 3
													</a>
												</li>
											</ul>
										</li>
									</ul>
								</li>
								<li>
									<a href="javascript:;">
										<span translate="sidebar.nav.4level.Item3.MAIN">Item 3</span> <i class="icon-arrow"></i>
									</a>
									<ul class="sub-menu">
										<li>
											<a href="javascript:;">
												<span translate="sidebar.nav.4level.Item3.link1.MAIN">Sample Link 1</span> <i class="icon-arrow"></i>
											</a>
											<ul class="sub-menu">
												<li>
													<a href="#" translate="sidebar.nav.4level.Item3.link1.LINK1">
														Sample Link 1
													</a>
												</li>
												<li>
													<a href="#" translate="sidebar.nav.4level.Item3.link1.LINK2">
														Sample Link 2
													</a>
												</li>
												<li>
													<a href="#" translate="sidebar.nav.4level.Item3.link1.LINK3">
														Sample Link 3
													</a>
												</li>
											</ul>
										</li>
										<li>
											<a href="javascript:;">
												<span translate="sidebar.nav.4level.Item3.link2.MAIN">Sample Link 2</span> <i class="icon-arrow"></i>
											</a>
											<ul class="sub-menu">
												<li>
													<a href="#" translate="sidebar.nav.4level.Item3.link2.LINK1">
														Sample Link 1
													</a>
												</li>
												<li>
													<a href="#" translate="sidebar.nav.4level.Item3.link2.LINK2">
														Sample Link 2
													</a>
												</li>
												<li>
													<a href="#" translate="sidebar.nav.4level.Item3.link2.LINK3">
														Sample Link 3
													</a>
												</li>
											</ul>
										</li>
										<li>
											<a href="javascript:;">
												<span translate="sidebar.nav.4level.Item3.link3.MAIN">Sample Link 3</span> <i class="icon-arrow"></i>
											</a>
											<ul class="sub-menu">
												<li>
													<a href="#" translate="sidebar.nav.4level.Item3.link3.LINK1">
														Sample Link 1
													</a>
												</li>
												<li>
													<a href="#" translate="sidebar.nav.4level.Item3.link3.LINK2">
														Sample Link 2
													</a>
												</li>
												<li>
													<a href="#" translate="sidebar.nav.4level.Item3.link3.LINK3">
														Sample Link 3
													</a>
												</li>
											</ul>
										</li>
									</ul>
								</li>
							</ul>
						</li>
						<li ui-sref-active="active">
							<a ui-sref="app.maps">
								<div class="item-content">
									<div class="item-media">
										<i class="ti-location-pin"></i>
									</div>
									<div class="item-inner">
										<span class="title" translate="sidebar.nav.maps.MAIN"> Maps </span>
									</div>
								</div>
							</a>
						</li>
						<li ui-sref-active="active">
							<a ui-sref="app.charts">
								<div class="item-content">
									<div class="item-media">
										<i class="ti-pie-chart"></i>
									</div>
									<div class="item-inner">
										<span class="title" translate="sidebar.nav.charts.MAIN"> Charts </span>
									</div>
								</div>
							</a>
						</li>
					</ul>
					<!-- end: MAIN NAVIGATION MENU -->
					<!-- start: CORE FEATURES -->
					<div class="navbar-title">
						<span translate="sidebar.heading.FEATURES">Core Features</span>
					</div>
					<ul class="folders">
						<li>
							<a ui-sref="app.pages.calendar">
								<div class="item-content">
									<div class="item-media">
										<span class="fa-stack"> <i class="fa fa-square fa-stack-2x"></i> <i class="fa fa-terminal fa-stack-1x fa-inverse"></i> </span>
									</div>
									<div class="item-inner">
										<span class="title" translate="sidebar.nav.pages.CALENDAR"> Calendar </span>
									</div>
								</div>
							</a>
						</li>
						<li>
							<a ui-sref="app.pages.messages">
								<div class="item-content">
									<div class="item-media">
										<span class="fa-stack"> <i class="fa fa-square fa-stack-2x"></i> <i class="fa fa-folder-open-o fa-stack-1x fa-inverse"></i> </span>
									</div>
									<div class="item-inner">
										<span class="title" translate="sidebar.nav.pages.MESSAGES"> Messages </span>
									</div>
								</div>
							</a>
						</li>
					</ul>
					<!-- end: CORE FEATURES -->
					<!-- start: DOCUMENTATION BUTTON -->
					<div class="wrapper">
						<a ui-sref="app.documentation" class="button-o">
							<i class="ti-help"></i>
							<span translate="sidebar.heading.DOCUMENTATION">Documentation</span>
						</a>
					</div>
				</div>
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

		<?php load_scripts($this->router->class, 'service'); ?>
		<?php load_scripts($this->router->class, 'js');?>
