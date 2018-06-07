<?php

ini_set('max_execution_time', 3600);
header('Content-Type: text/html; charset=UTF-8');
function getElementsByClassName($path, $class) {
	return $path->query("//*[contains(concat(' ', normalize-space(@class), ' '), '$class')]");
}
function getElementsById($path, $id) {
	return $path->query("//*[contains(concat(' ', normalize-space(@id), ' '), '$id')]");
}
function cleanTitle($title) {
	$title = trim($title);
	$title = str_replace('/', ' ', $title);
	$title = str_replace('\\', ' ', $title);
	$title = str_replace('*', ' ', $title);
	$title = str_replace('"', ' ', $title);
	$title = str_replace('<', ' ', $title);
	$title = str_replace('>', ' ', $title);
	$title = str_replace('|', ' ', $title);
	$title = str_replace('?', ' ', $title);
	$title = str_replace(':', ' ', $title);
	$title = str_replace('  ', ' ', $title);
	return $title;
}
$c = curl_init();
curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
curl_setopt($c, CURLOPT_BINARYTRANSFER, true);
curl_setopt($c, CURLOPT_HEADER, false);
curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);
$doc = new DOMDocument();
function docurl($u) {
	global $c;
	curl_setopt($c, CURLOPT_URL, $u);
	return curl_exec($c);
}

// s='';Array.from($0.getElementsByTagName('a')).forEach(function (u,i) { s += '"' + u + '" => "' + u.innerText + '",' + "\n"; })
$list = [

];
$n = 'chigaiha';
// 99bako == chu

if ($n == 'chu') {
	for ($p = 3; $p > 0; --$p) {
		// $u = "https://chu-channel.com/category/knowledge/meaning" . ($p > 1 ? "/page/$p" : "");
		$u = "https://99bako.com/category/chigai" . ($p > 1 ? "/page/$p" : "");

		$s = docurl($u);
		@$doc->loadHTML($s);
		$path = new DOMXPath($doc);

		$a = getElementsByClassName($path, 'top-post-list')->item(0);
		$a = $a->getElementsByTagName('article');
		for ($i = $a->length - 1; $i > -1; --$i) {
			$l = $a->item($i)->childNodes->item(0);
			$s = docurl($l->getAttribute('href'));
			$title = cleanTitle($l->getAttribute('title'));
			file_put_contents("wfio://test/$title.html", $s);
		}
		
		echo "Done page $p<br>";
	}
}
else if ($n == 'shittoku') {
	for ($p = 1; $p > 0; --$p) {
		$u = "http://知っ得袋.biz/category/言葉の違い" . ($p > 1 ? "/page/$p" : "");
		
		$s = docurl($u);
		@$doc->loadHTML($s);
		
		$a = $doc->getElementById('topnews');
		$a = $a->getElementsByTagName('dl');
		for ($i = $a->length - 1; $i > -1; --$i) {
			$l = $a->item($i)->getElementsByTagName('a')->item(1);
			$c = curl_init($l->getAttribute('href'));
			curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($c, CURLOPT_BINARYTRANSFER, true);
			curl_setopt($c, CURLOPT_HEADER, false);
			curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);
			$s = curl_exec($c);
			curl_close($c);
			$title = cleanTitle($l->nodeValue);
			file_put_contents("wfio://test/$title.html", $s);
		}
		
		echo "Done page $p<br>";
	}
}
else if ($n == 'allguide') {
	for ($p = 3; $p > 0; --$p) {
		// $u = "https://chigai-allguide.com/category/言葉/類語・表現・意味/" . ($p > 1 ? "page/$p/" : "");
		$u = "https://chigai-allguide.com/category/言葉/漢字・読み/" . ($p > 1 ? "page/$p/" : "");

		$s = docurl($u);
		@$doc->loadHTML($s);
		
		$a = $doc->getElementById('post_list');
		$a = $a->getElementsByTagName('li');
		for ($i = $a->length - 1; $i > -1; --$i) {
			$l = $a->item($i)->getElementsByTagName('a')->item(1);
			$s = docurl($l->getAttribute('href'));
			$title = cleanTitle($l->nodeValue);
			file_put_contents("wfio://test/$title.html", $s);
		}
		
		echo "Done page $p<br>";
	}
}
else if ($n == 'chigai') {
	$u = "http://www.chigai.org/%E3%81%93%E3%81%A8%E3%81%B0%E3%81%AE%E4%B8%AD%E3%81%AE%E9%81%95%E3%81%84/";

	$s = docurl($u);
	@$doc->loadHTML($s);
	$path = new DOMXPath($doc);
	
	$a = getElementsById($path, 'lcp_instance_0')->item(1);
	$a = $a->getElementsByTagName('li');
	for ($i = $a->length - 1; $i > -1; --$i) {
		$l = $a->item($i)->getElementsByTagName('a')->item(0);
		$s = docurl($l->getAttribute('href'));
		$doc2 = new DOMDocument();
		@$doc2->loadHTML($s);
		$path = new DOMXPath($doc2);
		
		$b = getElementsById($path, 'lcp_instance_0')->item(0);
		$b = $b->getElementsByTagName('li');
		for ($j = $b->length - 1; $j > -1; --$j) {
			$l2 = $b->item($j)->getElementsByTagName('a')->item(0);
			$l2->setAttribute('href', $l2->getAttribute('title') . '.html');
		}
		$s = $doc2->saveHTML();
		$title = cleanTitle($l->nodeValue);
		file_put_contents("wfio://test/$title.html", $s);
	}
	
	echo "Done<br>";
}
else if ($n == '11p') {
	for ($p = 11; $p > 0; --$p) {
		// $myu = 'http://www.st38.net/chigaino-zatugaku/';
		// $myu = 'http://lance2.net/chigai-3/';
		$myu = 'http://tetteikaisetu-chigai.lance5.net/';
		$u = $myu . "aa-$p.html";

		$s = docurl($u);
		@$doc->loadHTML($s);
		$path = new DOMXPath($doc);
		
		$a = getElementsByClassName($path, 'ichiran1')->item(0)->childNodes->item(1);
		$a = $a->getElementsByTagName('li');
		for ($i = $a->length - 1; $i > -1; --$i) {
			$l = $a->item($i)->getElementsByTagName('a')->item(0);
			$s = docurl($myu . $l->getAttribute('href'));
			$title = cleanTitle($l->nodeValue);
			file_put_contents("wfio://test/$title.html", $s);
		}
		
		echo "Done page $p<br>";
	}
}
else if ($n == 'bylist') {
	foreach ($list as $u => $title) {
		$s = docurl($u);
		$title = cleanTitle($title);
		file_put_contents("wfio://test/$title.html", $s);
	}
	
	echo "Done<br>";
}
else if ($n == 'chigai-master') {
	for ($p = 15; $p > 0; --$p) {
		// $u = "http://chigai-master.com/archives/category/言葉・表現" . ($p > 1 ? "/page/$p" : "");
		$u = "http://imijiten.com/category/kanjiimi/" . ($p > 1 ? "page/$p/" : "");

		$s = docurl($u);
		@$doc->loadHTML('<?xml encoding="utf-8"?>' . $s);
		$path = new DOMXPath($doc);
		
		$a = getElementsByClassName($path, 'article-header');
		for ($i = $a->length - 1; $i > -1; --$i) {
			$l = $a->item($i)->getElementsByTagName('a')->item(0);
			$s = docurl($l->getAttribute('href'));
			$title = cleanTitle($l->nodeValue);
			file_put_contents("wfio://test/$title.html", $s);
		}
		
		echo "Done page $p<br>";
	}
}
else if ($n == 'chigaiha') {
	for ($p = 1; $p > 0; --$p) {
		$u = "https://xn--n8j9do164a.net/archives/category/word" . ($p > 1 ? "/page/$p" : "");
		
		$s = docurl($u);
		@$doc->loadHTML($s);
		$path = new DOMXPath($doc);
		
		$a = getElementsByClassName($path, 'post-title');
		$a1 = getElementsByClassName($path, 'post-cat');
		for ($i = $a->length - 1; $i > -1; --$i) {
			if ($a1->item($i)->childNodes->item(0)->nodeValue != '言葉の違い') continue;
			$l = $a->item($i)->childNodes->item(0);
			$s = docurl($l->getAttribute('href'));
			$title = cleanTitle($l->nodeValue);
			file_put_contents("wfio://test/$title.html", $s);
		}
		
		echo "Done page $p<br>";
	}
}
else if ($n == 'st38naruhodo') {
	$cols = ['a', 'ka', 'sa', 'ta', 'na', 'ha', 'ma', 'ya', 'ra'];
	foreach ($cols as $col) {
		$s = docurl("http://www.st38.net/naruhodo-nattoku-chigai/aa-$col.html");
		@$doc->loadHTML($s);
		$path = new DOMXPath($doc);
		
		$con = getElementsByClassName($path, 'contents2');
		for ($i = 0; $i < 2; ++$i) {
			$a = $con->item($i)->getElementsByTagName('a');
			for ($j = 0; $j < $a->length; ++$j) {
				$title = cleanTitle($a->item($j)->nodeValue);
				$s = docurl('http://www.st38.net/naruhodo-nattoku-chigai/' . $a->item($j)->getAttribute('href'));
				file_put_contents("wfio://test/$col/$title.html", $s);
			}
		}
		echo "Done column $col<br>";
	}
}
