<?php
// /viewforum.php?id=XXX to /forum/XXX
$uri = $_SERVER['REQUEST_URI'];
preg_match('/viewforum\.php\?id=(\d+)/', $uri, $matches);
header("Location: http://" . $_SERVER['HTTP_HOST'] . "/forum/" . $matches[1]);
die();

