<?php

require_once 'initsess.php';

$t = 'Header set Cache-Control "max-age=' . CACHE_TIME . ', public"';
$t .= "\n" . 'Header set Pragma "public"';
file_put_contents('.htaccess', $t);

require_once 'buildsess.php';

?>
<html><head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<style>
.loader {
	top: 0;
	right: 20%;
	position: fixed;
	zoom: 10;
	z-index: 9999;
}
#wrap {
	font-size: 25px;
	line-height: 2;
	font-weight: 600;
}
.change-color {
	color: #504d86;
}
</style>
</head><body>
<img src='ajax-loader.gif' alt='Loading...' id='loading' class='loader' style="display: none">
<input style="font-size: 40px; line-height: 40px;" id="searchinput" size="15" tabindex="-1" value="水準"></input> <?php echo buildSessAgain(); ?>
<hr>
<div id="wrap"></div>
</body>
<script>
const LIMIT = '<?php echo LIMIT; ?>';

String.prototype.cutByLimit = function(limit) {
	return this.substring(this.indexOf(LIMIT) + LIMIT.length, this.lastIndexOf(LIMIT));
}
function cleanAjaxRet(r) {
	if (r.indexOf(LIMIT) >= 0)
		return r.cutByLimit(LIMIT);
	return r;
}

function gId(str) {
	return document.getElementById(str) ? document.getElementById(str) : alert('Where is id = ' + str);
}
var ajaxFail = 0;
function doAjax(data, noreset) {
	if (!noreset)
		ajaxFail = 0;
	loading.style.display = '';
	
	var xhr = new XMLHttpRequest();
	xhr.open(data.post ? 'POST' : 'GET', data.url);
	if (data.post)
		xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	xhr.onload = function() {
		loading.style.display = 'none';
		if (xhr.status === 200) {
			ajaxFail = 0;
			var ret = xhr.responseText;
			ret = cleanAjaxRet(ret);
			if (data.want == 'json')
				ret = JSON.parse(ret);
			data.todo(ret);
		}
		else {
			if (data.onfail)
				data.onfail();
			alert('Request failed.  Returned status of ' + xhr.status);
		}
	}
	
	xhr.timeout = data.timeout ? xhr.timeout : 30000;
	xhr.ontimeout = function(e) {
		ajaxFail++;
		if (ajaxFail < 10) {
			doAjax(data, true);
			return;
		}
		loading.style.display = 'none';
	}

	if (data.post)
		xhr.send(encodeURI(data.postdata));
	else
		xhr.send();
}

var loading = gId('loading');
var searchinput = gId('searchinput');
var wrap = gId('wrap');
function cleanDoc() {
	wrap.nextElementSibling.remove();
}
if (window.location.href.indexOf('chigai.freevar.com') > -1)
	cleanDoc();

searchinput.addEventListener("keydown", function(e) {
	if (e.keyCode == 13) {
		doSearch();
		e.preventDefault();
	}
	else if (e.keyCode == 191) {
		searchinput.focus();
		searchinput.select();
		e.preventDefault();
	}
	e.stopPropagation();
});
function doSearch() {
	var data = {};
	data.url = 'search.php?s=' + searchinput.value;
	data.todo = function(ret) {
		wrap.innerHTML = ret;
	}
	doAjax(data);
}
searchinput.focus();
searchinput.select();
document.addEventListener('keydown', function(e) {
	if (e.keyCode == 191) {
		searchinput.focus();
		searchinput.select();
		e.preventDefault();
	}
});
</script>
</html>