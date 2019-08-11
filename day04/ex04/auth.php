<?php

function getCredentialsList(){
    $path = "../private/passwd";
    $serialized_credentials_list = file_get_contents($path);
    $credentials_list = unserialize($serialized_credentials_list);
    return $credentials_list;
}

function isLoginValid($credentials_list, $login){
    foreach ($credentials_list as $credentials)
        if ($credentials['login'] === $login)
            return TRUE;
    return FALSE;
}

function checkCredentials($login, $password){
    $credentials_list = getCredentialsList();
    return isLoginValid($credentials_list, $login);
}

function auth($login, $password){
    if ($login AND $password)
        return checkCredentials($login, $password);
    return FALSE;
}
