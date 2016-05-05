<!--VALIDATION URL FOR LOGIN-->
<script> var validation_url = "<?php echo json_encode($validation); ?>"; </script>

<!-- <div ng-controller="loginCtrl">
    <div class="login-box">
        <div class="top_header">
            <img src="/avtoplin/resources/images/admin_logo.png"/>
            <label class="header_heading">Administracija G-1 D.O.O.</label>
        </div>
        <div>
            <form name="loginForm" method="post" action="Login/login_user" class="form-horizontal" role="form">
                <h4 class="in_header">PRIJAVA</h4>
                <div class="form-group">
                    <div class="">
                        <input type="text" ng-class="{validation_error: fail}" class="form-control" placeholder="uporabniško ime" name="username" required focus/>
                    </div>
                </div>
                <div class="form-group">
                    <div class="">
                            <input type="password" ng-class="{validation_error: fail}" name="password" class="form-control" placeholder="geslo" required focus/>
                    </div>
                </div>
                <div class="form-group">
                    <button type="submit" class="width-35 btn btn-sm btn-primary" data-ng-disabled="loginForm.$invalid">
                        <i class="ace-icon fa fa-key"></i>
                        PRIJAVI SE
                    </button>
                </div>
            </form>
            <img style="margin-bottom: 20px;" src="/avtoplin/resources/images/g1_logo_barvni.png"/>
        </div>
    </div>
</div> -->

<!-- start: LOGIN -->
<div class="row">
	<div class="main-login col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 col-md-4 col-md-offset-4">
    <div class="top_header">
        <img src="/avtoplin/resources/images/admin_logo.png"/>
        <label class="header_heading">Administracija G-1 D.O.O.</label>
    </div>
		<!-- start: LOGIN BOX -->
		<div class="box-login">
			<form name="loginForm" method="post" action="Login/login_user" role="form" class="form-login">
				<fieldset>
					<legend>
						Sign in to your account
					</legend>
					<p>
						Please enter your name and password to log in.
					</p>
					<div class="form-group">
						<span class="input-icon">
							<input type="text" class="form-control" name="username" placeholder="Username">
							<i class="fa fa-user"></i> </span>
					</div>
					<div class="form-group form-actions">
						<span class="input-icon">
							<input type="password" class="form-control password" name="password" placeholder="Password">
							<i class="fa fa-lock"></i> </span>
					</div>
					<div class="form-actions">
						<button type="submit" class="btn btn-primary pull-right">
							Login <i class="fa fa-arrow-circle-right"></i>
						</button>
					</div>
					<div class="new-account">
						Don't have an account yet?
						<a ui-sref="login.registration">
							Create an account
						</a>
					</div>
				</fieldset>
			</form>
			<!-- start: COPYRIGHT -->
			<div class="copyright">
				{{app.year}} &copy; {{ app.name }} by {{ app.author }}.
			</div>
			<!-- end: COPYRIGHT -->
		</div>
		<!-- end: LOGIN BOX -->
	</div>
</div>
<!-- end: LOGIN -->
