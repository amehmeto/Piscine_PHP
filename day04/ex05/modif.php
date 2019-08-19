<?php

$login = $_POST['login'];
$old_password = $_POST['oldpw'];
$new_password = $_POST['newpw'];

function displayErrorAndExit(){
    $error = "ERROR\n";
    echo $error;
    exit;
}

function isAllFieldsSet($login, $old_password, $new_password){
    return (isset($login) AND isset($old_password) AND isset($new_password));

}
function isOneFieldEmpty($login, $old_password, $new_password){
    return (empty($login) OR empty($old_password) OR empty($new_password));
}

function getCredentialsList(){
    $path = "../private/passwd";
    $serialized_credentials_list = file_get_contents($path);
    $credentials_list = unserialize($serialized_credentials_list);
    return $credentials_list;
}

function getHashToCompare($credentials_list, $search_login){
    foreach ($credentials_list as $credentials)
        if ($credentials['login'] === $search_login)
            return $credentials['passwd'];
    return FALSE;
}

function isValidCredentials($login, $old_password){
    $credentials_list = getCredentialsList();
    $db_hash = getHashToCompare($credentials_list, $login);
    $old_password_hash = hash('whirlpool', $old_password);
    return ($old_password_hash === $db_hash);
}

function replacePassword($credentials, $new_password){
    $credentials['passwd'] = hash('whirlpool', $new_password);
    return $credentials;
}

function getListWithModifiedPassword($credentials_list, $wanted_login, $new_password){
    foreach ($credentials_list as $key => $credentials)
        if ($credentials['login'] === $wanted_login)
            $credentials_list[$key]['passwd'] = hash('whirlpool', $new_password);
    return $credentials_list;
}

function modify_password($login, $new_password){
    $path = "../private/passwd";
    $credentials_list = getCredentialsList();
    $credentials_list = getListWithModifiedPassword($credentials_list, $login, $new_password);
    $serialized_list = serialize($credentials_list);
    file_put_contents($path, $serialized_list);
    header('Location: ./index.html');
}


if (!isAllFieldsSet($login, $old_password, $new_password))
    displayErrorAndExit();
if (isOneFieldEmpty($login, $old_password, $new_password))
    displayErrorAndExit();
if (!isValidCredentials($login, $old_password))
    displayErrorAndExit();
else
    modify_password($login, $new_password);

