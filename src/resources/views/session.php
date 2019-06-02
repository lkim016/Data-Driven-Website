<?php
session_start();

$username = "";
$email = "";
$errors = array();
$_SESSION['success'] = "";

$db = mysqli_connect('localhost', 'root', 'Sprite1234!', 'cis197');

?>