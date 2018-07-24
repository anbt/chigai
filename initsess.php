<?php

function bt() { echo '<pre>'; debug_print_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS); echo '</pre>'; }
function d($s = null) { echo '<pre>'; echo htmlentities(var_dump($s)); echo '</pre>'; }
function de($s = null) { $s === null && bt(); d($s); exit; }

mb_internal_encoding("UTF-8");
const LIMIT = '142857';
function genOutput($s) {
	echo LIMIT . $s . LIMIT;
}

const CACHE_TIME = 31104000;
function echoHeader() {
	// header('Access-Control-Allow-Origin: *');
	header('Content-Type: text/html; charset=utf-8');
	header('Cache-Control: max-age=' . CACHE_TIME . ', public');
	header("Pragma: public");
}
echoHeader();

// http://php.net/manual/en/function.session-cache-limiter.php
if (!session_start(
	[
		'cache_limiter' => 'public',
		'cache_expire' => CACHE_TIME / 60
	]
)) {
	echo 'Can not start session!';
	exit();
}
