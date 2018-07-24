<?php

$textfile = 'dir.txt';

if (@$_GET['b'] == 1) {
	// put folders to txt
	$a = array_diff(scandir('chigai'), ['..', '.']);
	$s = '';
	foreach ($a as &$fol) {
		$b = array_diff(scandir("chigai/$fol"), ['..', '.']);
		foreach ($b as &$file) {
			$s .= "$fol\t$file\n";
		}
	}
	file_put_contents($textfile, $s);
	header("Location: index.php");
	echo '<a href="index.php">Start</a>';
	exit();
}

if (file_exists($textfile) && !isset($_SESSION['a'])) {
	// put to session
	$s = file_get_contents($textfile);
	$s = explode("\n", $s);
	$a = [];
	foreach ($s as &$line) {
		$line = explode("\t", $line);
		if (!@$line[1])
			continue;
		$fol = trim($line[0]);
		if (!isset($a[$fol]))
			$a[$fol] = [];
		$a[$fol][] = trim($line[1]);
	}
	$_SESSION['a'] = $a;
}

if (!isset($_SESSION['a'])) {
	echo '<a href="?b=1">Build again</a><br>';
	exit('Can not store to session');
}
