<?php

function createPrivateDirectory(){
    $path = "../private";

    if (!file_exists($path))
        if (!mkdir($path, 0700))
            echo "Directory creation failed\n";
}

function prepareNewCredentials($credentials){
    unset($credentials['submit']);
    $credentials['passwd'] = hash('whirlpool', $credentials['passwd']);
    $credentials_list = array($credentials);
    return $credentials_list;
}

function buildCredentialsList($credentials){
    $credentials_list = prepareNewCredentials($credentials);
    $serialized_list = serialize($credentials_list);
    return $serialized_list;
}
function storeCredentials($new_credentials){
    createPrivateDirectory();
    $credentials_list = buildCredentialsList($new_credentials);
    file_put_contents("../private/passwd", $credentials_list, FILE_APPEND);
    echo "OK\n";
}

$error_message = "ERROR\n";

if (!isset($_POST['login']) OR !isset($_POST['passwd']))
    echo $error_message;
if ($_POST['login'] === '' OR $_POST['passwd'] === '')
    echo $error_message;
else
    storeCredentials($_POST);
