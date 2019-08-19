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

function displayChatIframe(){
    echo "<iframe name='chat' src='chat.php' width='100%' height='550px'></iframe>\n";
    echo "<iframe style='background-color: #ff5050' name='speak.php' src='speak.php' width='100%' height='50px'></iframe>\n";
};

$failure = "ERROR\n";

if (auth($login, $password)){
    $_SESSION['logged_on_user'] = $login;
    displayChatIframe();
}
else
    echo $failure;