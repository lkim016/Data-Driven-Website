<?php
session_start();

// variable declarations
$username = ""; # need to put login information here
$email = "";
$errors = array();
$_SESSION['success'] = "";

// connect to the database
// $db = mysqli_connect('localhost', 'debian-sys-maint', '2gQXjTEAtEtWu64F', 'cis197');
$db = mysqli_connect('localhost', 'root', 'Sprite1234!', 'cis197');

// REGISTER USER
if (isset($_POST['reg_user'])) {
    //receive all input values form the form
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
    $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);

    // form validation: ensure that the form is correctly filled
    // by adding (array)push() corresponding error unto $errors array
    if (empty($username)) { array_push($errors, "Username is required"); }
    if (empty($email)) { array_push($errors, "Email is required"); }
    if (empty($password_1)) { array_push($errors, "Password is required"); }
    if ($password_1 != $password_2) {
        array_push($errors, "The two passwords do not match");
    }

    // first check the database to make sure
    // a user does not already exist with the same username and/or email
    $user_check_query = "select * from users where username='$username' or email='$email' limit 1";
    $result = mysqli_query($db, $user_check_query);
    $user = mysqli_fetch_assoc($result);

    if ($user) { // if user exists
        if ($user['username'] === $username) {
            array_push($errors, "Username already exists");
        }

        if ($user['email'] === $email) {
            array_push($errors, "Email already exists");
        }
    }

    // Finally, register user if there are no errors in the form
    if (count($errors) == 0) {
        $passwd = md5($password_1);   //encrypt the password before saving in the database

        $query = "insert into users (username, email, passwd) values ('$username', '$email', '$passwd')";
        mysqli_query($db, $query);
        $_SESSION['username'] = $username;
        $_SESSION['success'] = "You are not logged in";
        header('location: index.php');
    }

    // LOGIN USER
    if (isset($_POST['login_user'])) {
        $username = mysqli_real_escape_string($db, $_POST['username']);
        $passd = mysqli_real_escape_string($db, $_POST['password']);

        if (empty($username)) {
            array_push($errors, "Username is required");
        }
        if (empty($password)) {
            array_push($errors, "Password is required");
        }
    }

    if (count($errors) == 0) {
        $password = md5($password);
        $query = "select * from users where username='$username' AND password='$password'";
        $results = mysqli_query($db, $query);
        if (mysqli_num_rows($results) == 1) {
            $_SESSION['username'] = $username;
            $_SESSION['success'] = "You are now logged in";
            header('location: index.php');
        }
        else {
            array_push($errors, "Wrong username/password combination");
        }
    }
}


?>