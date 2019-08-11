<?php

function getCredentialsList(){
    $path = "../private/passwd";
    $serialized_credentials_list = file_get_contents($path);
    $credentials_list = unserialize($serialized_credentials_list);
    return $credentials_list;
}

function isPasswordValid($credentials, $password){
    $hashed_password = hash('whirlpool', $password);
    return ($credentials['passwd'] === $hashed_password);
}

function isLoginValid($credentials_list, $login, $password){
    foreach ($credentials_list as $key => $credentials)
        if ($credentials['login'] === $login)
            return isPasswordValid($credentials_list[$key], $password);
    return FALSE;
}

function checkCredentials($login, $password){
    $credentials_list = getCredentialsList();
    return (isLoginValid($credentials_list, $login, $password));
}

function auth($login, $password){
    if ($login AND $password)
        return checkCredentials($login, $password);
    return FALSE;
}
