<?php
//test
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
"http://www.st38.net/sukkiri-chigai/z0502.html" => "抵抗力と免疫力の違い",
"http://www.st38.net/sukkiri-chigai/z0503.html" => "的屋と屋台の違い",
"http://www.st38.net/sukkiri-chigai/z0504.html" => "デジャブと予知夢の違い",
"http://www.st38.net/sukkiri-chigai/z0505.html" => "手帳とメモ帳の違い",
"http://www.st38.net/sukkiri-chigai/z0506.html" => "デモとパレードの違い",
"http://www.st38.net/sukkiri-chigai/z0507.html" => "転向と転身の違い",
"http://www.st38.net/sukkiri-chigai/z0508.html" => "天井裏と屋根裏の違い",
"http://www.st38.net/sukkiri-chigai/z0509.html" => "伝説と民話の違い",
"http://www.st38.net/sukkiri-chigai/z0510.html" => "テンポと拍子の違い",
"http://www.st38.net/sukkiri-chigai/z0511.html" => "土一揆と百姓一揆の違い",
"http://www.st38.net/sukkiri-chigai/z0512.html" => "トイレットペーパーのシングルとダブルの違い",
"http://www.st38.net/sukkiri-chigai/z0513.html" => "盗塁とヒットエンドランの違い",
"http://www.st38.net/sukkiri-chigai/z0514.html" => "道路と道の違い",
"http://www.st38.net/sukkiri-chigai/z0515.html" => "特色と特徴の違い",
"http://www.st38.net/sukkiri-chigai/z0516.html" => "研ぐと磨くの違い",
"http://www.st38.net/sukkiri-chigai/z0517.html" => "特記事項と備考の違い",
"http://www.st38.net/sukkiri-chigai/z0518.html" => "トピックスとヘッドラインの違い",
"http://www.st38.net/sukkiri-chigai/z0519.html" => "トランペットとホルンの違い",
"http://www.st38.net/sukkiri-chigai/z0520.html" => "鶏むね肉と鳥もも肉の違い",
"http://www.st38.net/sukkiri-chigai/z0521.html" => "トンカツとメンチカツの違い",
"http://www.st38.net/sukkiri-chigai/z0522.html" => "鈍感と敏感の違い",
"http://www.st38.net/sukkiri-chigai/z0523.html" => "なぞかけとなぞなぞの違い",
"http://www.st38.net/sukkiri-chigai/z0524.html" => "何かしらと何らかの違い",
"http://www.st38.net/sukkiri-chigai/z0525.html" => "南極と北極の違い",
"http://www.st38.net/sukkiri-chigai/z0526.html" => "苦手と下手の違い",
"http://www.st38.net/sukkiri-chigai/z0527.html" => "ニタニタとニヤニヤの違い",
"http://www.st38.net/sukkiri-chigai/z0528.html" => "日没と日暮れの違い",
"http://www.st38.net/sukkiri-chigai/z0529.html" => "乳液と保湿液の違い",
"http://www.st38.net/sukkiri-chigai/z0530.html" => "任務と役割の違い",
"http://www.st38.net/sukkiri-chigai/z0531.html" => "ネットカフェと漫画喫茶の違い",
"http://www.st38.net/sukkiri-chigai/z0532.html" => "納会と忘年会の違い",
"http://www.st38.net/sukkiri-chigai/z0533.html" => "ノウハウとハウツーの違い",
"http://www.st38.net/sukkiri-chigai/z0534.html" => "野原と原っぱの違い",
"http://www.st38.net/sukkiri-chigai/z0535.html" => "のりとボンドの違い",
"http://www.st38.net/sukkiri-chigai/z0536.html" => "パートタイムとフルタイムの違い",
"http://www.st38.net/sukkiri-chigai/z0537.html" => "廃棄と滅却の違い",
"http://www.st38.net/sukkiri-chigai/z0538.html" => "ハイヒールとピンヒールの違い",
"http://www.st38.net/sukkiri-chigai/z0539.html" => "ハガキとポストカードの違い",
"http://www.st38.net/sukkiri-chigai/z0540.html" => "計ると量るの違い",
"http://www.st38.net/sukkiri-chigai/z0541.html" => "バカンスと旅行の違い",
"http://www.st38.net/sukkiri-chigai/z0542.html" => "バグと不具合の違い",
"http://www.st38.net/sukkiri-chigai/z0543.html" => "ハグと抱擁の違い",
"http://www.st38.net/sukkiri-chigai/z0544.html" => "バスタオルとフェイスタオルの違い",
"http://www.st38.net/sukkiri-chigai/z0545.html" => "バターと発酵バターの違い",
"http://www.st38.net/sukkiri-chigai/z0546.html" => "バックパックとリュックサックの違い",
"http://www.st38.net/sukkiri-chigai/z0547.html" => "バトルとファイトの違い",
"http://www.st38.net/sukkiri-chigai/z0548.html" => "針金とワイヤーの違い",
"http://www.st38.net/sukkiri-chigai/z0549.html" => "磐石と盤石の違い",
"http://www.st38.net/sukkiri-chigai/z0550.html" => "反すると反対するの違い",
"http://www.st38.net/sukkiri-chigai/z0551.html" => "ハンドメイドとホームメイドの違い",
"http://www.st38.net/sukkiri-chigai/z0552.html" => "秘境と辺境の違い",
"http://www.st38.net/sukkiri-chigai/z0553.html" => "久しぶりと久々の違い",
"http://www.st38.net/sukkiri-chigai/z0554.html" => "ビデオとムービーの違い",
"http://www.st38.net/sukkiri-chigai/z0555.html" => "一重と二重の違い",
"http://www.st38.net/sukkiri-chigai/z0556.html" => "ひねるとよじるの違い",
"http://www.st38.net/sukkiri-chigai/z0557.html" => "ヒレ肉とフィレ肉の違い",
"http://www.st38.net/sukkiri-chigai/z0558.html" => "不可能と無理の違い",
"http://www.st38.net/sukkiri-chigai/z0559.html" => "フットとレッグの違い",
"http://www.st38.net/sukkiri-chigai/z0560.html" => "プライドとメンツの違い",
"http://www.st38.net/sukkiri-chigai/z0561.html" => "振袖と浴衣の違い",
"http://www.st38.net/sukkiri-chigai/z0562.html" => "プロレスとボクシングの違い",
"http://www.st38.net/sukkiri-chigai/z0563.html" => "並行と並列の違い",
"http://www.st38.net/sukkiri-chigai/z0564.html" => "ペーストとマッシュの違い",
"http://www.st38.net/sukkiri-chigai/z0565.html" => "変貌と変容の違い",
"http://www.st38.net/sukkiri-chigai/z0566.html" => "方向と向きの違い",
"http://www.st38.net/sukkiri-chigai/z0567.html" => "ほかほかとぽかぽかの違い",
"http://www.st38.net/sukkiri-chigai/z0568.html" => "保護者会とPTAの違い",
"http://www.st38.net/sukkiri-chigai/z0569.html" => "補充と補足の違い",
"http://www.st38.net/sukkiri-chigai/z0570.html" => "マウンテンバイクとロードバイクの違い",
"http://www.st38.net/sukkiri-chigai/z0571.html" => "負けず嫌いとプライドが高いの違い",
"http://www.st38.net/sukkiri-chigai/z0572.html" => "真夏日と猛暑の違い",
"http://www.st38.net/sukkiri-chigai/z0573.html" => "真似と模倣の違い",
"http://www.st38.net/sukkiri-chigai/z0574.html" => "マンゴスチンとライチの違い",
"http://www.st38.net/sukkiri-chigai/z0575.html" => "ミニバンとワンボックスカーの違い",
"http://www.st38.net/sukkiri-chigai/z0576.html" => "無限大と無量大数の違い",
"http://www.st38.net/sukkiri-chigai/z0577.html" => "無線lanと有線lanの違い",
"http://www.st38.net/sukkiri-chigai/z0578.html" => "無線マイクと有線マイクの違い",
"http://www.st38.net/sukkiri-chigai/z0579.html" => "無茶と無理の違い",
"http://www.st38.net/sukkiri-chigai/z0580.html" => "メッセージとメールの違い",
"http://www.st38.net/sukkiri-chigai/z0581.html" => "黙認と容認の違い",
"http://www.st38.net/sukkiri-chigai/z0582.html" => "モスクと礼拝所の違い",
"http://www.st38.net/sukkiri-chigai/z0583.html" => "モラハラとDVの違い",
"http://www.st38.net/sukkiri-chigai/z0584.html" => "役員と労働者の違い",
"http://www.st38.net/sukkiri-chigai/z0585.html" => "やりがいとやる気の違い",
"http://www.st38.net/sukkiri-chigai/z0586.html" => "融資と融通の違い",
"http://www.st38.net/sukkiri-chigai/z0587.html" => "湯通しと湯引きの違い",
"http://www.st38.net/sukkiri-chigai/z0588.html" => "夜明けと夜更けの違い",
"http://www.st38.net/sukkiri-chigai/z0589.html" => "溶剤と溶媒の違い",
"http://www.st38.net/sukkiri-chigai/z0590.html" => "蘇ると甦るの違い",
"http://www.st38.net/sukkiri-chigai/z0591.html" => "ラザニアとリゾットの違い",
"http://www.st38.net/sukkiri-chigai/z0592.html" => "利己的と利他的の違い",
"http://www.st38.net/sukkiri-chigai/z0593.html" => "利子と利回りの違い",
"http://www.st38.net/sukkiri-chigai/z0594.html" => "漁港と港の違い",
"http://www.st38.net/sukkiri-chigai/z0595.html" => "レントゲンとCTの違い",
"http://www.st38.net/sukkiri-chigai/z0596.html" => "ローストターキーとローストチキンの違い",
"http://www.st38.net/sukkiri-chigai/z0597.html" => "ロックとR&Bの違い",
"http://www.st38.net/sukkiri-chigai/z0598.html" => "涌くと湧くの違い",
"http://www.st38.net/sukkiri-chigai/z0599.html" => "～つつと～ながらの違い",
"http://www.st38.net/sukkiri-chigai/z0600.html" => "～としてはと～にしてはの違い",
"http://www.st38.net/sukkiri-chigai/z0601.html" => "～につれてと～に伴っての違い",
"http://www.st38.net/sukkiri-chigai/z0602.html" => "ICとLSIの違い"
];
$n = 'bylist';
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
		file_put_contents("wfio://test/501-600/$title.html", $s);
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
	$url = "http://www.st38.net/naruhodo-nattoku-chigai";
	$cols = ['a', 'ka', 'sa', 'ta', 'na', 'ha', 'ma', 'ya', 'ra'];
	$url = "http://www.st38.net/sukkiri-chigai";
	$cols = ['501-600'];
	foreach ($cols as $col) {
		$s = docurl("$url/aa-$col.html");
		@$doc->loadHTML($s);
		$path = new DOMXPath($doc);
		
		$con = getElementsByClassName($path, 'contents2');
		mkdir("test/$col");
		for ($i = 0; $i < 2; ++$i) {
			$a = $con->item($i)->getElementsByTagName('a');
			for ($j = 0; $j < $a->length; ++$j) {
				$title = cleanTitle($a->item($j)->nodeValue);
				$s = docurl("$url/" . $a->item($j)->getAttribute('href'));
				file_put_contents("wfio://test/$col/$title.html", $s);
			}
		}
		echo "Done column $col<br>";
	}
}
