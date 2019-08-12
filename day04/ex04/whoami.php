<?php
session_start();

$error = "ERROR\n";
if (isset($_SESSION['logged_on_user']) AND !empty($_SESSION['logged_on_user']))
        echo $_SESSION['logged_on_user'];
echo $error;