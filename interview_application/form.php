<?php include("includes/header.php") ?>
<?php include("includes/nav.php") ?>

    <div class="row">
        <div class="col-lg-6 col-md-offset-3">
            <div class="panel panel-heading">
                <div class="row">
                    <div class="col-xs-12 text-center">
                        <h2 class="active" id="register">Interview Application</h2>
                    </div>
                </div>

            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-12">
                        <form id="register-form" method="post" role="form">
                            <div class="form-group">
                                <h4 id="title-h" class="active">Please complete all required fields</h4>
                            </div>
                            <hr>
                            <div class="form-group">
                                <input type="text" name="title" id="title" tabindex="1" class="form-control"
                                       placeholder="Title" value="" required>
                            </div>
                            <div class="form-group">
                                <input type="text" name="description" id="description" tabindex="1"
                                       class="form-control" placeholder="Description" value="" required>
                            </div>
                            <div class="form-group">
                                <input type="" name="upload_file" id="upload_file" tabindex="2"
                                       class="form-control" placeholder="Upload a document" required>
                            </div>
                            <div class="form-group">
                                <select id="gender" class="form-control">
                                    <option value="" selected disabled hidden>Choose a gender</option>

                                    <option value="1">Male</option>
                                    <option value="0">Female</option>
                                </select>
                            </div>


                            <div class="row">
                                <div class="col-sm-6 col-sm-offset-3">
                                    <div class="row">
                                        <input type="button" tabindex="4" class="form-control btn btn-success"
                                               value="APPLY" onclick="addForm()">

                                    </div>
                                </div>

                            </div>

                    </div>

                    </form>
                </div>
            </div>
        </div>


        <script src="functions.js"></script>

<?php include("includes/footer.php") ?>