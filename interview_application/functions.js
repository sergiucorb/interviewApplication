function getParameterByName(name, url) {
    if (!url) url = window.location.href;
    name = name.replace(/[\[\]]/g, "\\$&");
    var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, " "));
}

$(document).ready(function () {
    var postId = getParameterByName('update_id');
    if (postId) {
        $.ajax({
            method: 'get',
            url: 'load_db.php?post_id=' + postId + '&op=get_post',
            contentType: 'json',
            success: function (data) {
                data = JSON.parse(data);
                $("#title-h").html("Edit post with id: " + postId);
                $("#register-form").append("<input hidden id='post-id' value='" + postId + "'>");
                $("#title").val(data.title);
                $("#gender").val(data.gender);
                $("#upload_file").val(Math.random().toString(36).replace(/[^a-z]+/g, ''));
                $("#created_form_date").val(new Date().toISOString().slice(0, 10));
                $("#description").val(data.description);
            }
        });
    }
});

//EMAIL VALIDATION
function validateEmail(valid_mail) {
    var re = /\S+@\S+\.\S+/;
    return re.test(valid_mail);
}

//REGISTER A USER
function addUser() {
    debugger;
    var min = 3,
        max = 20;
    var errors = [];
    var
        first_name = $('#first-name').val(),
        last_name = $('#last-name').val(),
        username = $('#username').val(),
        email = $('#email').val(),
        password = $('#password').val(),
        confirm_password = $('#confirm-password').val();


    if (first_name.length < min) {
        errors.push('First name cannot be less than 3  characters');
    }

    if (last_name.length < min) {
        errors.push('Last name cannot be less than 3  characters');
    }

    if (username.length < min) {
        errors.push('Username cannot be less than 3  characters');
    }

    if (email.length < min) {
        errors.push('Email cannot be less than 3 characters');
    }
    if (password == '') {
        errors.push('Password filed cannot be empty.')
    }
    if (password != confirm_password) {
        errors.push('Passwords do not match.')
    }
    if (!validateEmail(email)) {
        errors.push("Invalid email");
    }
    if (errors.length > 0) {
        alert(errors); // modify into a div
    }
    // //send new user to db
    else {
        $.ajax({
            type: "GET",
            dataType: "json",
            url: "load_db.php?op=addUser&first_name=" + first_name + "&last_name=" + last_name + "&username=" + username + "&mail=" + email + "&pass=" + password,

            success: function (data) {
                if (data.status == 'ok') {
                    $(location).attr("href", "login.php");
                }
                if (data.status == 'err') {

                    $('#register-form').fadeIn().append(
                        '<h3 style="text-align:center ">You have a problem</h3><br>');
                }
            },
            error: function (e) {
                alert(e.message);
            }
        });


    }

}

//EMAIL EXIST?
function testEmail() {
    var email = $('#email').val();
    $.ajax({
        type: "GET",
        dataType: "json",
        url: "load_db.php?op=email_exist&mail=" + email,
        success: function (data) {

            if (data.status == 'exist') {

                $('#register-form').fadeIn().append(
                    '<h3 style="text-align:center ">This email already exists!</h3><br>');
                $("#email").val('');

            }
        },
        error: function (e) {
            console.log(e.message);
        }
    });

}


//USERNAME EXIST?
function testUsername() {
    var username = $('#username').val();
    $.ajax({
        type: "GET",
        dataType: "json",
        url: "load_db.php?op=username_exist&username=" + username,
        success: function (data) {

            if (data.status == 'exist') {

                $('#register-form').fadeIn().append(
                    '<h3 style="text-align:center ">This username already exist!</h3><br>');
                $("#username").val('');
            }
        },
        error: function (e) {
            console.log(e.message);
        }
    });
}


//LOGIN
function userLogin() {
    var email_login = $('#email-login').val(),
        login_password = $('#login-password').val();
    $.ajax({
        type: "GET",
        dataType: "json",
        url: "load_db.php?op=userLogin&mail=" + email_login + "&pass=" + login_password,
        success: function (data) {
            if (data.status == 'ok') {
                $(location).attr("href", "index.php");
            }


            if (data.status == 'incorrect') {
                $('#login-form').fadeIn().append(
                    '<h3 style="text-align:center ">Email or password incorrect</h3><br>');
            }
        },
        error: function (e) {
            if (e.status == 'err') {
                alert(e);
            }
        }
    });
}

//DISCONNECT
function disconnect() {
    $.ajax({
        type: "GET",
        dataType: "json",
        url: "load_db.php?op=disconnect",
        success: function (data) {

            if (data.status == 'OK') {

                // alert("Deconectarea a fost realizata cu succes!");
                $(location).attr("href", "login.php");

            }
        },
        error: function (e) {
            console.log(e.message);
        }
    });

}

function toForm() {
    if (true) {
        $(location).attr("href", "form.php");
    }
}

//ADD FORM!!
function addForm() {
    var errors = [];
    var
        title = $('#title').val(),
        description = $('#description').val(),
        upload_file = $('#upload_file').val(),
        gender = $('#gender').val(),
        postId = $("#post-id"),
        url = "load_db.php?op=form&title=" + title + "&description=" + description + "&upload=" + upload_file + "&gender=" + gender;

    if (postId.length === 1) {
        url = url + "&post_id=" + postId.val();
    }

    if (title.length == '') {
        errors.push('Title field cannot be empty. Please add a title');
    }
    if (description.length == '') {
        errors.push('Description field cannot be empty. Please add a description.');
    }

    if (errors.length > 0) {
        alert(errors);
    }
    // //send new user to db
    else {
        $.ajax({
            type: "GET",
            dataType: "json",
            url: url,
            success: function (data) {
                if (data.status == 'ok') {
                    // alert("WELL DONE!");
                    $(location).attr("href", "activate.php");
                }

                if (data.status == 'err') {


                    alert("wrong input")

                }
            },
            error: function (e) {
                console.log(e.message);
            }
        });


    }

}

function getRegister() {
    if (true) {
        $(location).attr("href", "register.php");
    }
}

function getLogin() {
    if (true) {
        $(location).attr("href", "login.php");
    }
}


