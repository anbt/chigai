<?php

require_once 'initsess.php';

$n = trim($_GET['n']);
if (!isset($_SESSION[$n])) {
	echo '<h1>Not found!</h1>';
}
else {
	echo '<h1><pre>';
	print_r($_SESSION[$n]);
	echo '</pre></h1>';
}
