<?php

function createPrivateDirectory(){
    $path = "../private";
    if (!file_exists($path) AND !mkdir($path, 0700))
        echo "Directory creation failed\n";
}

function prepareNewCredentials($credentials){
    unset($credentials['submit']);
    $credentials['passwd'] = hash('whirlpool', $credentials['passwd']);
    return $credentials;
}

function isLoginAlreadyUsed($searched_login, $credentials_list){
    foreach ($credentials_list as $credentials)
        if ($credentials['login'] === $searched_login)
            return TRUE;
    return FALSE;
}

function getUnserializedContent($path){
    $serialized_list = file_get_contents($path);
    return unserialize($serialized_list);
}

function addNewCredential($credentials_list, $credentials){
    $credentials_list[] = $credentials;
    $serialized_list = serialize($credentials_list);
    return $serialized_list;
}

function buildCredentialsList($credentials){
    $credentials = prepareNewCredentials($credentials);
    $path = "../private/passwd";
    $credentials_list = (!file_exists($path)) ? array() : getUnserializedContent($path);

    if (!isLoginAlreadyUsed($credentials['login'], $credentials_list))
        return addNewCredential($credentials_list, $credentials);
    return FALSE;
}

function writeNewCredentialsList($path, $credentials_list){
    file_put_contents($path, $credentials_list);
    echo "OK\n";
}

function storeCredentials($new_credentials){
    createPrivateDirectory();
    $credentials_list = buildCredentialsList($new_credentials);
    if ($credentials_list)
        writeNewCredentialsList("../private/passwd", $credentials_list);
    else
        echo "ERROR\n";
}

$error_message = "ERROR\n";

if (!isset($_POST['login']) OR !isset($_POST['passwd']))
    echo $error_message;
if ($_POST['login'] === '' OR $_POST['passwd'] === '')
    echo $error_message;
else
    storeCredentials($_POST);
