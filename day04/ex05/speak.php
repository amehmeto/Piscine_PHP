<?php

session_start();

function generateSpeakForm(){
    $form = "<form method='post' action='speak.php'>
                <input style='width: 80%' name='msg' type='text'>
                <input type='submit' name='submit' value='OK'>
            </form>\n";
    return $form;
}

function generateNewChatEntry(){
    $login = $_SESSION['logged_on_user'];
    $message = $_POST['msg'];
    $time = time();
    $new_chat = array('login' => $login, 'time' => $time, 'msg' => $message);
    return $new_chat;
}

function getPrivateChat($path){
    $serialized_full_chat = file_get_contents($path);
    $full_chat = unserialize($serialized_full_chat);
    return $full_chat;
}

function populateChatDB(){
    $path = '../private/chat';
    if (file_exists($path))
        $full_chat = getPrivateChat($path);
    $new_chat_entry = generateNewChatEntry();
    $full_chat[] = $new_chat_entry;
    $full_chat = serialize($full_chat);
    file_put_contents($path, $full_chat);
}

function speak(){
    if ($_POST['submit'] === 'OK')
        populateChatDB();
    echo generateSpeakForm();
}

if ($_SESSION['logged_on_user'] )
    speak();
else
    echo "ERROR\n";
