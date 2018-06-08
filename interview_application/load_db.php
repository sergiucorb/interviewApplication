<?php
error_reporting(E_ALL);

require_once('php/config.php');
session_start();

$hostname = host;
$username = name;
$password = password;
$namedb = namedb;


try {
    $dbh = new PDO("mysql:host=$hostname;dbname=" . namedb, $username, $password);
    $dbh->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo(array($e => "Eroare conectare la baza de date:"));
    exit;
}

$json = file_get_contents('php://input');
$obj = json_decode($json);

//DELETE FORM
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_POST['op'] == 'deleteForm') {
        if (!isset($_POST['id'])) {
            echo json_encode(array('status' => 'err'));
            exit;
        } else {
            $id = $_POST['id'];
            $sql = "DELETE FROM form_table WHERE id = :id";
            $stmt = $dbh->prepare($sql);
            $params = array(
                ":id" => $id,
            );
            $stmt->execute($params);
            echo json_encode(array('status' => 'ok'));
            exit;
        }
    }
};
//USER REGISTER
if ($_GET['op'] == 'addUser') {
    try {

        $sql = "INSERT INTO `users_table`(`first_name`,`last_name`,`username`,`email`,`password`, `created_date`)
                          VALUES (:first_name,:last_name,:username, :email, :password, SYSDATE())";
        $stmt = $dbh->prepare($sql);
        //$stmt->setFetchMode(PDO::FETCH_ASSOC);
        $params = array(
            ":first_name" => $_GET['first_name'],
            ":last_name" => $_GET['last_name'],
            ":username" => $_GET['username'],
            ":email" => $_GET['mail'],
            ":password" => $_GET['pass']
        );
        $stmt->execute($params);

        echo json_encode(array('status' => 'ok'));

    } catch (PDOException $e) {

        echo json_encode(array('status' => 'err', 'err' => $e));

        exit;
    }
}

// ADD FORM OR EDIT FORM
if ($_GET['op'] == 'form') {

    if (isset($_GET['post_id'])) {


        $sql = "UPDATE form_table SET 
                title = :title, 
                description =:description, 
                uploaded_file =:uploaded_file, 
                gender =:gender 
                WHERE id =:id";
        $stmt = $dbh->prepare($sql);
        $params = array(
            ":title" => $_GET['title'],
            ":description" => $_GET['description'],
            ":uploaded_file" => $_GET['upload'],
            ":gender" => $_GET['gender'],
            ":id" => $_GET['post_id']
        );

        $stmt->execute($params);
//
        echo json_encode(array('status' => 'ok'));

        //        echo json_encode(array('status' => 'err'));

        exit;
    } else {
        try {
            $sql = "INSERT INTO `form_table`(`user_id`,`title`,`description`,`uploaded_file`,`gender`,`created_date`)
                          VALUES(:user_id,:title, :description, :upload_file, :gender, SYSDATE())";
            $stmt = $dbh->prepare($sql);
            //$stmt->setFetchMode(PDO::FETCH_ASSOC);
            $params = array(
                ":title" => $_GET['title'],
                ":user_id" => $_SESSION['id'],
                ":description" => $_GET['description'],
                ":upload_file" => $_GET['upload'],
                ":gender" => $_GET['gender'],

            );

            $stmt->execute($params);

            echo json_encode(array('status' => 'ok'));

        } catch (PDOException $e) {

            echo json_encode(array('status' => 'err'));

            exit;
        }
    }
}
//EMAIL EXIST?
if ($_GET['op'] == 'email_exist') {

    $sql = "SELECT email FROM users_table WHERE email = :mail ";
    $sth = $dbh->prepare($sql);
    $params = array(':mail' => $_GET['mail']);
    $sth->setFetchMode();
    $sth->execute($params);
    $id = $sth->fetch();
    $_SESSION['idUser'] = $id[0];

    if ($id[0] == null) {
        echo json_encode(array("status" => "ok"));
    } else {
        echo json_encode(array('status' => 'exist'));
    }
}



//USERNAME EXIST?
if ($_GET['op'] == 'username_exist') {

    $sql = "SELECT username FROM users_table WHERE username = :username ";
    $sth = $dbh->prepare($sql);
    $params = array(':username' => $_GET['username']);
    $sth->setFetchMode();
    $sth->execute($params);
    $idUsername = $sth->fetch();
    $_SESSION['idUsername'] = $idUsername[0];

    if ($idUsername[0] == null) {

        echo json_encode(array("status" => "ok"));
    } else {
        echo json_encode(array('status' => 'exist'));
    }
}
//GET ID FROM form_table
if ($_GET['op'] == 'get_post') {
    if (!isset($_GET['post_id'])) {
        echo json_encode(array('status' => 'err'));
        exit;
    } else {
        $sql = "SELECT id, title, description , gender, created_date FROM form_table where id =:id";
        $id = $_GET['post_id'];
        $sth = $dbh->prepare($sql);
        $params = array(':id' => $id);
        $sth->setFetchMode();
        $sth->execute($params);
        $data = $sth->fetch();
        echo json_encode($data);

        exit;
    }


}
//USER LOGIN
if ($_GET['op'] == 'userLogin') {

    $sql = "SELECT users_table.id, users_table.username, form_table.user_id
          FROM users_table LEFT JOIN form_table ON users_table.id = form_table.user_id 
          WHERE email =:email AND password =:password";

    try {
        $sth = $dbh->prepare($sql);
        $params = array(':email' => $_GET['mail'],
            ':password' => $_GET['pass']);
        $sth->setFetchMode();
        $sth->execute($params);
        $id = $sth->fetch();
        $_SESSION['idUser'] = $id;
//        print_r($id);

        if ($id == null) {
            echo json_encode(array('status' => 'incorrect'));
            $_SESSION['session'] = null;

        } else {
            echo json_encode(array('status' => 'ok'));
            $param1 = $id[0];
            $param2 = $id[1];
            $param3 = $id[2];


            $_SESSION['id'] = $param1;
            $_SESSION['nameUser'] = $param2;
            $_SESSION['user_id'] = $param3;
            $_SESSION['session'] = 'ok';
        }

    } catch (PDOException $e) {
        echo json_encode(array('status' => 'err', 'err' => $e));
        exit;
    }

}


// GET FORM WITH user_id
if ($_GET['op'] == 'getForm') {

    try {
        $sql = "SELECT id, title, description , gender, created_date FROM form_table where user_id =:user_id";
        $sth = $dbh->prepare($sql);
        $sth->setFetchMode();
        $id = isset($_SESSION['id']) ? $_SESSION['id'] : null;
        if (!$id) {
            echo json_encode(array('status' => 'err'));
        }
        $sth->execute(array(':user_id' => $id));
        $yellow = $sth->fetchAll();
        echo json_encode($yellow, true);


    } catch (PDOException $e) {

        echo json_encode(array('status' => 'err', 'err' => $e));

        exit;
    }
}
//GET SESSION..VALUES FROM DB
if ($_GET['op'] == 'getSession') {
    if ($_SESSION['id'] != null) {
        $par = 'OK';
        echo json_encode(array('id' => $_SESSION['id'], 'name' => $_SESSION['nameUser'], 'userId' => $_SESSION['user_id'], "status" => $par));
    } else {
         $par = 'NO';
         echo json_encode(array("status"=>$par));
    }

}

//DISCONNECT
if ($_GET['op'] == 'disconnect') {
    if (false) {
        echo "xxx";
    } else {
        $_SESSION['id'] = null;
        $_SESSION['nameUser'] = null;

        echo json_encode(array("status" => 'OK'));
    }

}

