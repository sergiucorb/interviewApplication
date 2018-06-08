<?php include("includes/header.php") ?>
<?php include("includes/nav.php") ?>


<div class="container">
    <div class="panel-body">
        <div class="row">
            <div class="col-lg-9 col-lg-offset-1">
                <div class="alert alert-success text-center " role="alert">
                    <h4 class="alert-heading" style="font-size: 30px"><b>Well done!</b></h4>
                    <p> Thank you for applying. Your data is verified at this time and we will contact you as soon as
                        you fit our requirements .</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-9 col-md-offset-1">
                <table class="table">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Gender</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody id="append-rows">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script src="functions.js"></script>
<script>
    function deleteRow(ev) {
        var id = $(ev.target).data('id'),
            $tr = $(ev.target).parent().parent();

        $.post({
            dataType: 'json',
            url: 'load_db.php',
            data: {
                op: "deleteForm",
                id: id
            },
            success: function () {
                $tr.remove();
            }
        })
    }

    function updateRow(ev) {
        var id = $(ev.target).data('id');
        window.location.href = "form.php?update_id=" + id
    }

    $(document).ready(function () {
        $.ajax({
            method: "GET",
            dataType: "json",
            url: "load_db.php?op=getForm",
            success: function (obj) {
                for (var i = 0; i < obj.length; i++) {
                    var data = obj[i],
                        id = "<tr><th>" + data.id + "</th>",
                        title = "<td>" + data.title + "</td>",
                        description = "<td>" + data.description + "</td>",
                        gender = "<td>" + data.gender + "</td>",
                        createdAt = "<td>" + data.created_date + "</td>",
                        action = "<td><button style='margin-right: 10px' class='btn btn-danger' data-id='" + data.id + "'>Delete</button>" +
                            "<button class='btn btn-primary' data-id='" + data.id + "'>Update</button> " +
                            "</td></tr>";
                    $("#append-rows").append(id + title + description + gender + createdAt + action);
                }
                $(".btn-danger").click(deleteRow);
                $(".btn-primary").click(updateRow);
            },
            error: function (data) {
                console.log(data);
            }
        });
    })
</script>
<script>
    //DELETE FORM
    $.ajax({
        method: "POST",
        dataType: "json",
        url: "load_db.php?op=deleteForm",
        success: function (obj) {
            for (var i = 0; i < obj.length; i++) {
                var data = obj[i],
                    id = "<tr><th>" + data.id + "</th>",
                    title = "<td>" + data.title + "</td>",
                    description = "<td>" + data.description + "</td>",
                    genre = "<td>" + data.genre + "</td>",
                    createdAt = "<td>" + data.created_date + "</td>",
                    action = "<td><button class='btn btn-danger' data-id='" + data.id + "'>Delete</button></td></tr>";
                $("#append-rows").append(id + title + description + genre + createdAt + action);
            }
        },
        error: function (data) {
            console.log(data);
        }
    });
</script>
<?php include("includes/footer.php") ?>
