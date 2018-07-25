<?php

require_once 'func.php';

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
