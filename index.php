<?php
session_start();
$pathinfo = isset($_SERVER['PATH_INFO'])
    ? $_SERVER['PATH_INFO']
    : $_SERVER['REDIRECT_URL'];

$params = preg_split('|/|', $pathinfo, -1, PREG_SPLIT_NO_EMPTY);

if (strlen($params[0]) == 0) {
	$params[0] = 'opinion';
}

require_once('controllers/'.$params[0].'.php');
?>
