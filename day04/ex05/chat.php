<?php

function displayMessage($message){
   echo "[" . date('H:i', $message['time'])
            . "] <b>" . $message['login'] . "</b>: "
            . $message['msg'] . "<br />";
}

function formatChatEntries($chat){
    foreach ($chat as $chat_message)
        displayMessage($chat_message);
}

function displayChat($path){
    $serialize_chat = file_get_contents($path);
    $chat = unserialize($serialize_chat);
    formatChatEntries($chat);
}

$path = '../private/chat';

if (file_exists($path))
    displayChat($path);