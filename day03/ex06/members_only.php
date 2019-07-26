<?php
if (!isset($_SERVER['PHP_AUTH_USER'])) {
    header('WWW-Authenticate: Basic realm="Tag img');
    header('HTTP/1.0 401 Unauthorized');
    echo "Bouge de la batard\n";
}
else
{
    echo
}

?>
