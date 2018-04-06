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

// s='';Array.from($0.getElementsByTagName('a')).forEach(function (u,i) { s += '"' + u + '" => "' + u.innerText + '",' + "\n"; })
$list = [
"https://www.alc.co.jp/jpn/article/faq/03/94.html" => "「どんな」「なんの」はどう違う？",
"https://www.alc.co.jp/jpn/article/faq/03/243.html" => "「説明したとおりに」と「説明したように」はどう違う？",
"https://www.alc.co.jp/jpn/article/faq/03/116.html" => "「かわいい」と「かわいらしい」はどう違う？",
"https://www.alc.co.jp/jpn/article/faq/03/242.html" => "「桜はきれいです」と「桜はきれいな花です」の場面はどう違う？",
"https://www.alc.co.jp/jpn/article/faq/03/73.html" => "「本当に」はナ形容詞？",
"https://www.alc.co.jp/jpn/article/faq/03/83.html" => "形容詞の「よい」と「いい」はどう違う？",
"https://www.alc.co.jp/jpn/article/faq/03/135.html" => "「同じ」はナ形容詞（形容動詞）？　連体詞？",
"https://www.alc.co.jp/jpn/article/faq/03/34.html" => "「雨がふりはじまる」ではなく「ふりはじめる」と言うのはなぜ？",
"https://www.alc.co.jp/jpn/article/faq/03/41.html" => "自動詞と他動詞は、どのように対応している？",
"https://www.alc.co.jp/jpn/article/faq/03/25.html" => "「家族と公園へ行く」と「家族で公園へ行く」。この二つの違いはなんですか。",
"https://www.alc.co.jp/jpn/article/faq/03/13.html" => "「木村さんに赤ちゃんが生まれた」と「木村さんの赤ちゃんが生まれた」は何が違いますか？",
"https://www.alc.co.jp/jpn/article/faq/03/136.html" => "「卒業してから10年が経つ」の「から」は何助詞？",
"https://www.alc.co.jp/jpn/article/faq/03/233.html" => "「電車が遅れたから遅刻したんです」がおかしいのはなぜ？",
"https://www.alc.co.jp/jpn/article/faq/03/76.html" => "「から」と「より」はどう違う？",
"https://www.alc.co.jp/jpn/article/faq/03/48.html" => "「○○円からお預かりいたします」という表現は正しい？",
"https://www.alc.co.jp/jpn/article/faq/03/244.html" => "「だれかいましたか」と「だれかがいましたか」の違いは？",
"https://www.alc.co.jp/jpn/article/faq/03/231.html" => "「水が飲みたい」と「水を飲みたい」はどう違う？",
"https://www.alc.co.jp/jpn/article/faq/03/232.html" => "「進歩が感じられる」と「進歩を感じられる」はどちらが正しい？",
"https://www.alc.co.jp/jpn/article/faq/03/236.html" => "「職が変わる」と「職を変わる」はどう違う？",
"https://www.alc.co.jp/jpn/article/faq/03/67.html" => "「～が～てある」と「～を～てある」はどう違う？",
"https://www.alc.co.jp/jpn/article/faq/03/19.html" => "「は」と「が」の使い分けを教えてください。",
"https://www.alc.co.jp/jpn/article/faq/03/114.html" => "「このお金はうちをたてるために使う」と「このお金はうちをたてるのに使う」はどう違う？",
"https://www.alc.co.jp/jpn/article/faq/03/143.html" => "「もし～だったら」「たとえ～でも」「いくら～でも」はどう違う？",
"https://www.alc.co.jp/jpn/article/faq/03/33.html" => "「だけ」と「しか」はどう違う?",
"https://www.alc.co.jp/jpn/article/faq/03/148.html" => "「（私が寝たあと）で」と「（寝たあと）に」の違いは？",
"https://www.alc.co.jp/jpn/article/faq/03/235.html" => "３つ以上の事柄を並べた場合、意味のまとまりをはっきりさせる方法は？",
"https://www.alc.co.jp/jpn/article/faq/03/234.html" => "「寒いと、窓を閉めてください」とは、なぜ言わない？",
"https://www.alc.co.jp/jpn/article/faq/03/237.html" => "「家族と会いました」と「家族に会いました」はどう違う？",
"https://www.alc.co.jp/jpn/article/faq/03/238.html" => "「もう、お風呂に入ろうっと」「お掃除しようっと」の「と」は何？",
"https://www.alc.co.jp/jpn/article/faq/03/85.html" => "「と」と「に」はどう違う？",
"https://www.alc.co.jp/jpn/article/faq/03/121.html" => "「お金があると旅行します」「お金があったら旅行します」「お金があれば旅行します」はどう違う？",
"https://www.alc.co.jp/jpn/article/faq/03/226.html" => "「どこか行きますか」と「どこかに行きますか」はどう違う？",
"https://www.alc.co.jp/jpn/article/faq/03/222.html" => "「アメリカに行きます」と「アメリカへ行きます」はどう違う？",
"https://www.alc.co.jp/jpn/article/faq/03/224.html" => "「山に登る」と「山を上る」はどう違う？",
"https://www.alc.co.jp/jpn/article/faq/03/225.html" => "「カラオケに行く」と「カラオケへ行く」はどう違う？",
"https://www.alc.co.jp/jpn/article/faq/03/91.html" => "「独りで」「二人で」「みんなで」は「で」なのに、なぜ「いっしょに」は「に」になる？",
"https://www.alc.co.jp/jpn/article/faq/03/89.html" => "「には」と「では」はどう違う？",
"https://www.alc.co.jp/jpn/article/faq/03/138.html" => "～に触りますの「に」は到達点の「に」？",
"https://www.alc.co.jp/jpn/article/faq/03/223.html" => "「５時に締め切ります」と「５時で締め切ります」はどう違う？",
"https://www.alc.co.jp/jpn/article/faq/03/227.html" => "「不思議の国のアリス」と「不思議な国のアリス」はどう違う？",
"https://www.alc.co.jp/jpn/article/faq/03/43.html" => "「（相手の名前）のばか！」と言うのに、なぜ「（相手の名前）はばか！」と言わない？",
"https://www.alc.co.jp/jpn/article/faq/03/228.html" => "「のみ」「だけ」「きり」はどう違う？",
"https://www.alc.co.jp/jpn/article/faq/03/230.html" => "「わたしのお金は盗まれた」という表現が不自然なのはなぜ？",
"https://www.alc.co.jp/jpn/article/faq/03/229.html" => "わからない言葉を聞くとき「『タイクツ』は何？」と聞けないのはなぜ？",
"https://www.alc.co.jp/jpn/article/faq/03/87.html" => "「～たまま」と「～っぱなし」はどう違う？",
"https://www.alc.co.jp/jpn/article/faq/03/221.html" => "「部屋を出る」と「部屋から出る」はどう違う？",
"https://www.alc.co.jp/jpn/article/faq/03/216.html" => "「手を触れないでください」は、本当は「絵を触れないでください」「手で触れないでください」では？",
"https://www.alc.co.jp/jpn/article/faq/03/217.html" => "「○○します」と「○○をします」。どんな単語は両方に使える？",
"https://www.alc.co.jp/jpn/article/faq/03/74.html" => "「笑わせられた」と「笑わされた」は どう違う？",
"https://www.alc.co.jp/jpn/article/faq/03/152.html" => "使役助動詞「（さ）せる」の使い方と意味は？",
"https://www.alc.co.jp/jpn/article/faq/03/218.html" => "「帰る」＋「そうだ」の否定形は「帰れそうもない」？「帰れなそうだ」？",
"https://www.alc.co.jp/jpn/article/faq/03/219.html" => "「暑かったり寒かったりです」と「暑かったり寒かったりします」はどう違う？",
"https://www.alc.co.jp/jpn/article/faq/03/99.html" => "「ないで」と「なくて」はどう違う？",
"https://www.alc.co.jp/jpn/article/faq/03/220.html" => "「行かない」の「ない」と「辛くない」の「ない」はどう違う？",
"https://www.alc.co.jp/jpn/article/faq/03/215.html" => "「～ます」と「～んです」はどう違う？",
"https://www.alc.co.jp/jpn/article/faq/03/153.html" => "「～ようだ」と「～そうだ」はどう違う？",
"https://www.alc.co.jp/jpn/article/faq/03/210.html" => "「らしい」と「ようだ」はどう違う？",
"https://www.alc.co.jp/jpn/article/faq/03/211.html" => "「さて」と「ところで」はどう違う？",
"https://www.alc.co.jp/jpn/article/faq/03/212.html" => "「そして」「それから」「それで」はどう違う？",
"https://www.alc.co.jp/jpn/article/faq/03/16.html" => "「お電話差し上げる」「お電話して差し上げる」の意味の違いはありますか。差し上げるという言い方が、やや優位な立場を意味しているように思えるのですが。",
"https://www.alc.co.jp/jpn/article/faq/03/26.html" => "「向かう」と「行く」の違いは？",
"https://www.alc.co.jp/jpn/article/faq/03/213.html" => "人間に対しても「お父さんがありますか」などと「ある」が使えるのはなぜ？",
"https://www.alc.co.jp/jpn/article/faq/03/214.html" => "「駅に行く」が言えるのに、「駅に歩く」と言えないのはなぜ？",
"https://www.alc.co.jp/jpn/article/faq/03/209.html" => "「帰る」と「戻る」はどう違う？",
"https://www.alc.co.jp/jpn/article/faq/03/203.html" => "「欠く」と「欠かす」はどう違う？",
"https://www.alc.co.jp/jpn/article/faq/03/55.html" => "「さける」と「よける」はどう違う？",
"https://www.alc.co.jp/jpn/article/faq/03/110.html" => "「目的に達する」と「目的を達する」はどう違う？",
"https://www.alc.co.jp/jpn/article/faq/03/82.html" => "「にぎる」と「つかむ」はどう違う？",
"https://www.alc.co.jp/jpn/article/faq/03/84.html" => "「開く」と「開ける」はどう違う？",
"https://www.alc.co.jp/jpn/article/faq/03/106.html" => "「含む」と「含める」はどう違う？",
"https://www.alc.co.jp/jpn/article/faq/03/18.html" => "「一日中テレビを見ていました」と「一日中テレビを見ました」の違いは？",
"https://www.alc.co.jp/jpn/article/faq/03/105.html" => "「見落とす」と「見逃す」はどう違う？",
"https://www.alc.co.jp/jpn/article/faq/03/204.html" => "ペットにえさなどを与える場合、「やる」と「あげる」のどちらが適切？",
"https://www.alc.co.jp/jpn/article/faq/03/205.html" => "「湯を沸かす」は「水を沸かす」では？",
"https://www.alc.co.jp/jpn/article/faq/03/38.html" => "「わかる」と「知る」はどう違う？",
"https://www.alc.co.jp/jpn/article/faq/03/62.html" => "「ために」と「ように」はどう違う？",
"https://www.alc.co.jp/jpn/article/faq/03/96.html" => "「～として」のいい導入は？",
"https://www.alc.co.jp/jpn/article/faq/03/206.html" => "「～に関して」と「～について」はどう違う？",
"https://www.alc.co.jp/jpn/article/faq/03/207.html" => "「～につれて」と「～にしたがって」はどう違う？",
"https://www.alc.co.jp/jpn/article/faq/03/109.html" => "「には」と「のは」はどう違う？",
"https://www.alc.co.jp/jpn/article/faq/03/137.html" => "「にしては」と「にしても」はどう違う？",
"https://www.alc.co.jp/jpn/article/faq/03/12.html" => "「間もなく」と「もうすぐ」はどう違うのですか？ 使用の制限などがあるのでしょうか？",
"https://www.alc.co.jp/jpn/article/faq/03/1.html" => "「いちおう」と「とりあえず」の違いは？",
"https://www.alc.co.jp/jpn/article/faq/03/51.html" => "　「あっさり」と「さっぱり」はどう違う？",
"https://www.alc.co.jp/jpn/article/faq/03/92.html" => "「いきなり」「急に」「突然」はどう違う？",
"https://www.alc.co.jp/jpn/article/faq/03/139.html" => "「一生懸命～する」と「頑張って～する」の違いは何？",
"https://www.alc.co.jp/jpn/article/faq/03/208.html" => "「しょっちゅう」「常に」「たびたび」「よく」はどう違う？",
"https://www.alc.co.jp/jpn/article/faq/03/202.html" => "「せっかく」と「わざわざ」はどう違う？",
"https://www.alc.co.jp/jpn/article/faq/03/196.html" => "「全然、大丈夫」は、正しい日本語？",
"https://www.alc.co.jp/jpn/article/faq/03/197.html" => "「だんだん」と｢少しずつ｣はどう違う？",
"https://www.alc.co.jp/jpn/article/faq/03/198.html" => "「ちょっとおかしい」の「ちょっと」って何？",
"https://www.alc.co.jp/jpn/article/faq/03/199.html" => "「どうやら～らしい」と「どうも～らしい」はどう違う？",
"https://www.alc.co.jp/jpn/article/faq/03/64.html" => "「なるべく」と「できるだけ」はどう違う？",
"https://www.alc.co.jp/jpn/article/faq/03/180.html" => "(1)「ひろびろ」のように濁る語と、(2)「ひらひら」のように濁らない語があるのはなぜ？",
"https://www.alc.co.jp/jpn/article/faq/03/200.html" => "「太郎は丸くゆっくりと円を描いた」と言えないのはなぜ？",
"https://www.alc.co.jp/jpn/article/faq/03/36.html" => "「わざわざお越しいただき～」のように「わざわざ」という言葉を目上に対して使うことは可能？",
"https://www.alc.co.jp/jpn/article/faq/03/54.html" => "「大勢」のように名詞なのに動詞を修飾できる語は？",
"https://www.alc.co.jp/jpn/article/faq/03/201.html" => "バスは無生物なのに、どうして「止まって『いる』」と言うの？",
"https://www.alc.co.jp/jpn/article/faq/03/195.html" => "「行く」と「行ってくる」はどう違う？",
"https://www.alc.co.jp/jpn/article/faq/03/9.html" => "「～ことが好きです」と「～のが好きです」は、同じ意味です、と生徒に説明してもいいですか？",
"https://www.alc.co.jp/jpn/article/faq/03/190.html" => "時間を表すとき「１時間」「30分間」と言うが、時間と分が合わさると「１時間30分」となるのはなぜ？",
"https://www.alc.co.jp/jpn/article/faq/03/77.html" => "「大切」と「大事」はどう違う？",
"https://www.alc.co.jp/jpn/article/faq/03/191.html" => "「～ところ」と「～ばかり」はどう違う？",
"https://www.alc.co.jp/jpn/article/faq/03/156.html" => "「大きな声」はナ形容詞？　「大きい声」とどう違う？",
"https://www.alc.co.jp/jpn/article/faq/03/97.html" => "日本語のリダンダント（今現在、旗がはためく、など）について教えてください。",
"https://www.alc.co.jp/jpn/article/faq/03/35.html" => "「お世話になります」と「お世話になっております」はどう違う？",
"https://www.alc.co.jp/jpn/article/faq/03/32.html" => "「毎日歯を磨きます」と「毎日歯を磨いています」はどう違う？",
"https://www.alc.co.jp/jpn/article/faq/03/58.html" => "「靴がほしいと言いました」と「靴がほしいと言っていました」はどう違う？",
"https://www.alc.co.jp/jpn/article/faq/03/66.html" => "「風邪引いたの？」と「風邪引いてるの？」はどう違う？",
"https://www.alc.co.jp/jpn/article/faq/03/131.html" => "「～ている」と「～てある」はどう違う？",
"https://www.alc.co.jp/jpn/article/faq/03/2.html" => "「動詞＋なくて」と「動詞＋ないで」の違いは？",
"https://www.alc.co.jp/jpn/article/faq/03/134.html" => "「呼ぶ」はなぜ「呼ぶだ」ではなく「呼んだ」と変化する？",
"https://www.alc.co.jp/jpn/article/faq/03/125.html" => "「くさい」「ぽい」「らしい」はどう違う？",
"https://www.alc.co.jp/jpn/article/faq/03/93.html" => "「シロに似た犬」と「シロに似ている犬」はどう違う？",
"https://www.alc.co.jp/jpn/article/faq/03/194.html" => "「～しようとした時」「～しようとすると」はどう違う？",
"https://www.alc.co.jp/jpn/article/faq/03/193.html" => "「～しないでください」は現在のことなのに、なぜ「わかりました」と答える？",
"https://www.alc.co.jp/jpn/article/faq/03/192.html" => "「頭が痛いとき薬を飲みました」と「頭が痛かったとき薬を飲みました」はどう違う？",
"https://www.alc.co.jp/jpn/article/faq/03/189.html" => "感謝するのは現在なので、「ありがとうございました」は「ありがとうございます」が正しいのでは？",
"https://www.alc.co.jp/jpn/article/faq/03/146.html" => "同じ過去のことを表すのに「～した」と「～している」の２通りあるのはなぜ？",
"https://www.alc.co.jp/jpn/article/faq/03/184.html" => "「ごめんなさい」「おやすみなさい」の「なさい」は命令形？",
"https://www.alc.co.jp/jpn/article/faq/03/113.html" => "なぜうそをついている人に「うそをつくな」ではなく「うそつけ」と言う？"
];
$n = 'bylist';
// 99bako == chu

if ($n == 'chu') {
	for ($p = 22; $p > 0; --$p) {
		// $u = "https://chu-channel.com/category/knowledge/meaning" . ($p > 1 ? "/page/$p" : "");
		$u = "https://99bako.com/category/chigai" . ($p > 1 ? "/page/$p" : "");

		$c = curl_init($u);
		curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($c, CURLOPT_BINARYTRANSFER, true);
		curl_setopt($c, CURLOPT_HEADER, false);
		curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);
		$s = curl_exec($c);
		curl_close($c);

		$doc = new DOMDocument();
		@$doc->loadHTML($s);
		$path = new DOMXPath($doc);

		$a = getElementsByClassName($path, 'top-post-list')->item(0);
		$a = $a->getElementsByTagName('article');
		for ($i = $a->length - 1; $i > -1; --$i) {
			$l = $a->item($i)->childNodes->item(0);
			$c = curl_init($l->getAttribute('href'));
			curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($c, CURLOPT_BINARYTRANSFER, true);
			curl_setopt($c, CURLOPT_HEADER, false);
			curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);
			$s = curl_exec($c);
			curl_close($c);
			$title = cleanTitle($l->getAttribute('title'));
			file_put_contents("wfio://test/$title.html", $s);
		}
		
		echo "Done page $p<br>";
	}
}
else if ($n == 'shittoku') {
	for ($p = 1; $p > 0; --$p) {
		$u = "http://知っ得袋.biz/category/言葉の違い" . ($p > 1 ? "/page/$p" : "");

		$c = curl_init($u);
		curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($c, CURLOPT_BINARYTRANSFER, true);
		curl_setopt($c, CURLOPT_HEADER, false);
		curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);
		$s = curl_exec($c);
		curl_close($c);

		$doc = new DOMDocument();
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
	for ($p = 15; $p > 0; --$p) {
		$u = "https://chigai-allguide.com/category/言葉/類語・表現・意味/" . ($p > 1 ? "page/$p/" : "");

		$c = curl_init($u);
		curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($c, CURLOPT_BINARYTRANSFER, true);
		curl_setopt($c, CURLOPT_HEADER, false);
		curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);
		$s = curl_exec($c);
		curl_close($c);

		$doc = new DOMDocument();
		@$doc->loadHTML($s);
		
		$a = $doc->getElementById('post_list');
		$a = $a->getElementsByTagName('li');
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
else if ($n == 'chigai') {
	$u = "http://www.chigai.org/%E3%81%93%E3%81%A8%E3%81%B0%E3%81%AE%E4%B8%AD%E3%81%AE%E9%81%95%E3%81%84/";

	$c = curl_init($u);
	curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($c, CURLOPT_BINARYTRANSFER, true);
	curl_setopt($c, CURLOPT_HEADER, false);
	curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);
	$s = curl_exec($c);
	curl_close($c);

	$doc = new DOMDocument();
	@$doc->loadHTML($s);
	$path = new DOMXPath($doc);
	
	$a = getElementsById($path, 'lcp_instance_0')->item(1);
	$a = $a->getElementsByTagName('li');
	for ($i = $a->length - 1; $i > -1; --$i) {
		$l = $a->item($i)->getElementsByTagName('a')->item(0);
		$c = curl_init($l->getAttribute('href'));
		curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($c, CURLOPT_BINARYTRANSFER, true);
		curl_setopt($c, CURLOPT_HEADER, false);
		curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);
		$s = curl_exec($c);
		curl_close($c);
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

		$c = curl_init($u);
		curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($c, CURLOPT_BINARYTRANSFER, true);
		curl_setopt($c, CURLOPT_HEADER, false);
		curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);
		$s = curl_exec($c);
		curl_close($c);

		$doc = new DOMDocument();
		@$doc->loadHTML($s);
		$path = new DOMXPath($doc);
		
		$a = getElementsByClassName($path, 'ichiran1')->item(0)->childNodes->item(1);
		$a = $a->getElementsByTagName('li');
		for ($i = $a->length - 1; $i > -1; --$i) {
			$l = $a->item($i)->getElementsByTagName('a')->item(0);
			$c = curl_init($myu . $l->getAttribute('href'));
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
else if ($n == 'bylist') {
	foreach ($list as $url => $title) {
		$c = curl_init($url);
		curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($c, CURLOPT_BINARYTRANSFER, true);
		curl_setopt($c, CURLOPT_HEADER, false);
		curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);
		$s = curl_exec($c);
		curl_close($c);
		$title = cleanTitle($title);
		file_put_contents("wfio://test/$title.html", $s);
	}
	
	echo "Done<br>";
}
else if ($n == 'chigai-master') {
	for ($p = 15; $p > 0; --$p) {
		// $u = "http://chigai-master.com/archives/category/言葉・表現" . ($p > 1 ? "/page/$p" : "");
		$u = "http://imijiten.com/category/kanjiimi/" . ($p > 1 ? "page/$p/" : "");

		$c = curl_init($u);
		curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($c, CURLOPT_BINARYTRANSFER, true);
		curl_setopt($c, CURLOPT_HEADER, false);
		curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);
		$s = curl_exec($c);
		curl_close($c);
		
		$doc = new DOMDocument();
		@$doc->loadHTML('<?xml encoding="utf-8"?>' . $s);
		$path = new DOMXPath($doc);
		
		$a = getElementsByClassName($path, 'article-header');
		for ($i = $a->length - 1; $i > -1; --$i) {
			$l = $a->item($i)->getElementsByTagName('a')->item(0);
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
else if ($n == 'chigaiha') {
	for ($p = 3; $p > 0; --$p) {
		$u = "http://xn--n8j9do164a.net/archives/category/word" . ($p > 1 ? "/page/$p" : "");

		$c = curl_init($u);
		curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($c, CURLOPT_BINARYTRANSFER, true);
		curl_setopt($c, CURLOPT_HEADER, false);
		curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);
		$s = curl_exec($c);
		curl_close($c);
		
		$doc = new DOMDocument();
		@$doc->loadHTML($s);
		$path = new DOMXPath($doc);
		
		$a = getElementsByClassName($path, 'post-title');
		$a1 = getElementsByClassName($path, 'post-cat');
		for ($i = $a->length - 1; $i > -1; --$i) {
			if ($a1->item($i)->childNodes->item(0)->nodeValue != '言葉の違い') continue;
			$l = $a->item($i)->childNodes->item(0);
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

