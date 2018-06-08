<?php include("includes/header.php") ?>
<?php include("includes/nav.php") ?>


    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-login">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-12">
                            <a href="login.php" class="active" id="login-form-link">Login</a>
                        </div>

                    </div>
                    <hr>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <form id="login-form" method="post" role="form" style="display: block;">
                                <div class="form-group">
                                    <input type="text" name="email" id="email-login" tabindex="1" class="form-control"
                                           placeholder="Email" required>
                                </div>
                                <div class="form-group">
                                    <input type="password" name="password" id="login-password" tabindex="2"
                                           class="form-control" placeholder="Password" required>
                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-6 col-sm-offset-3">
                                            <input type="button" tabindex="4"
                                                   class="form-control btn btn-login" value="Log In"
                                                   onclick="userLogin()" on>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-6 col-sm-offset-3">
                                            <p class="text-center">Don't have an account yet?</p>
                                            <input type="button" tabindex="4"
                                                   class="form-control btn btn-success"
                                                   value="Go to register" onclick="getRegister()">
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
    <script>

        $.ajax({
            type: "GET",
            dataType: "json",
            url: "load_db.php?op=getSession",
            success: function (data) {

                if (data.status == 'OK') {
                    $(location).attr("href", "index.php");
                }
                if (data.status == 'NO') {
                    alert("YOU ARE NOT LOGGED IN");
                }
            },
            error: function (e) {
                if (e.status == 'err') {
                    alert(e);
                }
            }
        });
    </script>
    <script src="functions.js"></script>
<?php include("includes/footer.php") ?>