<?php
	$action = $_GET["action"];
	if ($action == "set")
		setcookie($_GET["name"], $_GET["value"], (time() + 3600 * 24));
	else if ($action == "get")
		echo $_COOKIE[$_GET["name"]]."\n";
	else if ($action == "del")
		setcookie($_GET["name"]);
?>
