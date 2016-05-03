<!--VALIDATION URL FOR LOGIN-->
<script> var validation_url = "<?php echo json_encode($validation); ?>"; </script>

<div ng-controller="loginCtrl">
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
    </div><!-- /login-box -->
</div>