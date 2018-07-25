<?php

$textfile = 'dir.txt';

if (0 && @$_GET['b'] == 1) {
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
		$a[$fol][] = array(
			'ori' => trim($line[1]),
			'low' => strtolower(trim($line[1])),
			'enc' => encFilename(trim($line[1]))
		);
	}
	$_SESSION['a'] = $a;
}

if (!isset($_SESSION['a'])) {
	echo '<a href="?b=1">Build again</a><br>';
	exit('Can not store to session');
}

function jaSplit($s) {
	return preg_split('//u', $s, null, PREG_SPLIT_NO_EMPTY);
}
/*
to % format, %[a-f]* is kept, %[0-9]* is replaced by _
keep %20 (space)
keep alphabet char
how to do with one-byte ,()/&
99bako/工場（プラントとファクトリー／plant,factory）の違いと使い分け.html
chigai-allguide/「q&a」と「faq」の違い.html
*/
function encFilename($s) {
	$ext = '.' . pathinfo($s, PATHINFO_EXTENSION);
	$s = str_replace($ext, '', $s);
	$tmp = jaSplit($s);
	$s = '';
	foreach ($tmp as $v) {
		if (!preg_match('/[A-Za-z0-9]/', $v)) {
			if ($v == ' ')
				$v = '%20';
			else {
				$v = bin2hex($v);
				$v = chunk_split($v, 2, '%');
				$v = '%' . substr($v, 0, strlen($v) - 1);
				// $v = str_replace('%20', 'jch', $v);
				$v = preg_replace('/%[0-9]./', '_', $v);
				// $v = str_replace('jch', '%20', $v);
			}
		}
		$s .= $v;
	}
	return $s . $ext;
}
