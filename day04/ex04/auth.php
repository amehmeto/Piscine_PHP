<?php

function getCredentialsList(){
    $path = "../private/passwd";
    $serialized_credentials_list = file_get_contents($path);
    $credentials_list = unserialize($serialized_credentials_list);
    return $credentials_list;
}

function checkCredentials($login, $password){
    $credentials_list = getCredentialsList();
    foreach ($credentials_list as $credentials)
        if ($credentials['login'] === $login)
            return TRUE;
    return FALSE;
}

function auth($login, $password){
    if ($login AND $password)
        return checkCredentials($login, $password);
    return FALSE;
}
