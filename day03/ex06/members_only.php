<?php

function surroundContent($content) {
    $opening_tags = "<html><body>";
    $closing_tags = "</body></html>\n";

    return $opening_tags . $content . $closing_tags;
}

function encodeImage(){
    $file_path = "../img/42.png";
    $MIME_type = mime_content_type($file_path);
    $file_content = file_get_contents($file_path);

    return "data:" . $MIME_type . ";base64," . base64_encode($file_content);
}

function generateContent(){
    $content = "\nBonjour Zaz<br />\n";
    $content .= "<img src='" . encodeImage() . "'>\n";

    return $content;
}

if (isset($_SERVER['PHP_AUTH_USER'])
            AND $_SERVER['PHP_AUTH_USER'] === 'zaz' AND $_SERVER['PHP_AUTH_PW'] === 'zaz') {
    $content = generateContent();
    $content = surroundContent($content);
    echo $content;
}
else {
    header('WWW-Authenticate: Basic realm="Tag img');
    header('HTTP/1.0 401 Unauthorized');
    $forbidden_area_message = "Cette zone est accessible uniquement aux membres du site";
    echo surroundContent($forbidden_area_message);
    exit;
}
