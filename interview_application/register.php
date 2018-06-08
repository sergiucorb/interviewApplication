<?php include("includes/header.php") ?>
<?php include("includes/nav.php") ?>

    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-login">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-12">
                            <a href="register.php" class="active" id="">Register</a>
                        </div>
                    </div>
                    <hr>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <form id="register-form" method="post" role="form">
                                <div class="form-group">
                                    <input type="text" name="first_name" id="first-name" tabindex="1"
                                           class="form-control"
                                           placeholder="First name" value="" required>
                                </div>
                                <div class="form-group">
                                    <input type="text" name="last_name" id="last-name" tabindex="1" class="form-control"
                                           placeholder="Last name" value="" required>
                                </div>
                                <div class="form-group">
                                    <input type="text" name="username" id="username" tabindex="1" class="form-control"
                                           placeholder="Username" value="" onchange="testUsername()" required>
                                </div>

                                <div class="form-group">
                                    <input type="email" name="email" id="email" tabindex="1"
                                           class="form-control" placeholder="Email Address" value=""
                                           onchange="testEmail()" required>
                                </div>
                                <div class="form-group">
                                    <input type="password" name="password" id="password" tabindex="2"
                                           class="form-control" placeholder="Password" required>
                                </div>
                                <div class="form-group">
                                    <input type="password" name="confirm-password" id="confirm-password" tabindex="2"
                                           class="form-control" placeholder="Confirm password" required>
                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-6 col-sm-offset-3">
                                            <input type="button" tabindex="4"
                                                   class="form-control btn btn-register"
                                                   value="Register Now" on onclick="addUser()">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-6 col-sm-offset-3">
                                            <p class="text-center"> Already have an account?</p>
                                            <input type="button" tabindex="4"
                                                   class="form-control btn btn-info"
                                                   value="Login" onclick="getLogin()">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="functions.js">
    </script>
<?php include("includes/footer.php") ?>