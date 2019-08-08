<?php

$error_message = "ERROR\n";

function storeCredentials($credentials){

    if (!file_exists("../private"))
        if (!mkdir("../private", 0700))
            echo "Directory creation failed\n";
    unset($credentials['submit']);
    $credentials_list = array($credentials);
    $serialized_list = serialize($credentials_list);
    file_put_contents("../private/passwd", $serialized_list, FILE_APPEND);
    echo "OK\n";
}

if (!isset($_POST['login']) OR !isset($_POST['passwd']))
    echo $error_message;
if ($_POST['login'] === '' OR $_POST['passwd'] === '')
    echo $error_message;
else
    storeCredentials($_POST);
