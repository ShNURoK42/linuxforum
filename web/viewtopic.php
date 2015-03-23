<?php
// /viewtopic.php?id=XXX or /viewtopic.php?pid=XXX to /topic/XXX
$uri = $_SERVER['REQUEST_URI'];
header('HTTP/1.1 301 Moved Permanently');
if(strpos($uri, 'pid')) {
    preg_match('/viewtopic\.php\?pid=(\d+)/', $uri, $matches);
    header("Location: http://" . $_SERVER['HTTP_HOST'] . "/post/" . $matches[1]);
} else {
    preg_match('/viewtopic\.php\?id=(\d+)/', $uri, $matches);
    header("Location: http://" . $_SERVER['HTTP_HOST'] . "/topic/" . $matches[1]);
}
die();

