<?php include("includes/header.php") ?>
<?php include("includes/nav.php") ?>

<div class="jumbotron text-center " style="width: 500px; margin-left: auto; margin-right: auto;">
    <p id="name" style="font-size: 50px;"></p>

    <hr class="my-4">
    <p>If you are interested in an internship, click the below button</p>

    <input type="button" tabindex="4"
           class=" btn btn-primary "
           value="Find more" onclick="toForm()">
</div>
<script>
debugger;
    $.ajax({
        type: "GET",
        dataType: "json",
        url: "load_db.php?op=getSession",
        success: function (data) {
            debugger;
            if (data.status == 'OK' && data.userId !== null) {
                window.location = "activate.php";

            } else if (data.status == 'OK' && data.userId == null) {
                $('#name').fadeIn().append('<p class="display-8"; style="font-size: 65px;">Welcome</p>' + data.name + ',' );


                $('#user-name').html('Hello ' + data.name);
                $('.nav-link').removeClass('hide');
            }

            else if (data.status =='NO'){
                $(location).attr("href", "login.php");
            }

            if (data.status == 'err') {
                alert("error!!");
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

