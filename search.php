<?php

require_once 'initsess.php';

$s = strtolower(trim($_GET['s']));
$a = &$_SESSION['a'];
$ret = '';
$index = 0;
foreach ($a as $fol => &$b) {
	foreach ($b as $name) {
		if (strpos($name['ori'], $s) !== false) {
			$ret .= '<b>' . sprintf("%02d", ++$index) . '</b>. <a class="change-color" target="_blank" href="' . "chigai/$fol" . '">' . $fol. '</a>/<a class="change-color" target="_blank" href="' . "chigai/$fol/" . $name['enc'] . '">' . $name['ori'] . '</a><br>';
		}
	}
}
genOutput($ret);
