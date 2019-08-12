<?php

include 'auth.php';
session_start();

$_SESSION['logged_on_user'] = '';
$login = NULL;
$password = NULL;

if (isset($_GET['login']) AND isset($_GET['passwd'])){
    $login = $_GET['login'];
    $password = $_GET['passwd'];
}

$success = "OK\n";
$failure = "ERROR\n";

if (auth($login, $password)){
    $_SESSION['logged_on_user'] = $login;
    echo $success;
}
else
    echo $failure;
