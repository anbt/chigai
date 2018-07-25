<?php

require_once 'initsess.php';

$s = trim($_GET['s']);
$a = &$_SESSION['a'];
$ret = '';
$index = 0;

if (substr($s, 0, 1) == '/') { // folder display
	$s = substr($s, 1);
	foreach ($a as $fol => &$b) {
		if (strpos($fol, $s) !== false) {
			foreach ($b as $name) {
				$ret .= '<b>' . sprintf("%02d", ++$index) . '</b>. <a class="change-color" target="_blank" href="' . "chigai/$fol" . '">' . $fol. '</a>/<a class="change-color" target="_blank" href="' . "chigai/$fol/" . $name['enc'] . '">' . $name['ori'] . '</a><br>';
			}
		}
	}
}
else { // file search
	$s = strtolower($s);
	foreach ($a as $fol => &$b) {
		foreach ($b as $name) {
			if (strpos($name['low'], $s) !== false) {
				$ret .= '<b>' . sprintf("%02d", ++$index) . '</b>. <a class="change-color" target="_blank" href="' . "chigai/$fol" . '">' . $fol. '</a>/<a class="change-color" target="_blank" href="' . "chigai/$fol/" . $name['enc'] . '">' . $name['ori'] . '</a><br>';
			}
		}
	}
}

genOutput($ret);
