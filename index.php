<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>Search And Replace Serialized String</title>
<style type="text/css">
html{height:100%;overflow-y:scroll;width:100%}body{height:100%;margin:0;overflow:visible;padding:0;vertical-align:top;width:100%}h1,h2,h3,h4,h5,h6{font-size:100%;font-weight:normal;margin:0}p{margin:0}a img,img{border:0;vertical-align:middle}strong{font-style:normal;font-weight:bold}small{font-size:100%}ol,ul{list-style-type:none}dd,dl,dt,li,ol,ul{margin:0;padding:0}hr{background-color:#CCCCCC;border:0;color:#CCCCCC;height:1px;margin:0;padding:0}table{border-collapse:collapse;border-spacing:0;font-size:100%}th{font-style:normal;font-weight:normal;margin:0;padding:0;text-align:left}td{margin:0;padding:0}blockquote,div,span{margin:0;padding:0}pre{font-family:monospace;line-height:1.0;margin:0;padding:0}button{background:0;border:0;cursor:pointer;padding:0;vertical-align:middle}button,fieldset,form,input,label,legend,select,textarea{font-family:inherit;font-size:100%;font-style:inherit;font-weight:inherit;margin:0;padding:0;vertical-align:middle}label{cursor:pointer}textarea{resize:vertical}* html textarea{margin-top:-2px}*:first-child+html textarea{margin-top:-2px}abbr,acronym{border:0}address,caption,cite,code,dfn,em,var{font-style:normal;font-weight:normal}caption{text-align:left}code,kbd,pre,samp,tt{font-family:monospace;line-height:1.0}*+html code,*+html kbd,*+html pre,*+html samp,*+html tt{font-size:108%}q:after,q:before{content:''}article,aside,audio,canvas,details,figcaption,figure,footer,header,hgroup,mark,menu,nav,section,summary,time,video{background:transparent;border:0;font-size:100%;margin:0;outline:0;padding:0;vertical-align:baseline}article,aside,details,figcaption,figure,footer,header,hgroup,menu,nav,section{display:block}

html {
	font-size: 62.5%;
	-webkit-text-size-adjust: 100%;
	-ms-text-size-adjust:     100%;
}

body {
	color: #000000;
	font-family: -apple-system, "游ゴシック", "Yu Gothic", "游ゴシック体", YuGothic, "メイリオ", Meiryo, "ヒラギノ角ゴ ProN W3", "Hiragino Kaku Gothic ProN", "ヒラギノ角ゴ Pro W3", "Hiragino Kaku Gothic Pro", sans-serif;
	line-height: 1.5;
}
body * {
	box-sizing: border-box;
}

.command {
	background: #2E3D58;
	display: -webkit-flex;
	display: flex;
	font-size: 1.2rem;
	left: 0;
	padding: 10px;
	position: fixed;
	top: 0;
	width: 100%;
}
.command--item {
	margin-right: 10px;
	position: relative;
}
.command--item:last-child {
	margin-right: 0;
}
.command--item__sql {
	background: #FFFFFF;
	cursor: pointer;
}
	.command--item__sql::before,
	.command--item__sql::after {
		content: "";
		display: table;
	}
	.command--item__sql::after {
		clear: both;
	}
	.command--item__sql {
		zoom: 1;
	}
.command--item--btn-file {
	float: left;
}
input[type="file"] {
	display: none;
}
.command--item--btn-file {
	background: #00809B;
	border: none;
	color: #FFFFFF;
	display: inline-block;
	height: 30px;
	line-height: 30px;
	padding: 0 20px;
}
.command--item--file-name {
	float: left;
	position: relative;
}
.command--item--file-name span {
	display: block;
	height: 30px;
	line-height: 30px;
	overflow: hidden;
	padding: 0 10px;
	text-overflow: ellipsis;
	white-space: nowrap;
	width: 150px;
}
.command--item__arrow {
	color: #E3E6EE;
	font-size: 20px;
	height: 30px;
	line-height: 30px;
	vertical-align: top;
}
.command--item input[type="text"] {
	background: #FFFFFF;
	border: none;
	height: 30px;
	line-height: 30px;
	padding: 0 10px;
	width: 250px;
}
.command--error {
	background: #ED2C7D;
	color: #FFFFFF;
	left: 0;
	margin-top: 4px;
	padding: 5px 10px;
	position: absolute;
	top: 100%;
}
.command--error::before {
	border-left: 4px solid transparent;
	border-right: 4px solid transparent;
	border-bottom: 8px solid #ED2C7D;
	top: -8px;
	content: '';
	left: 20px;
	margin-left: -6px;
	position: absolute;
}
.command--item--btn-submit {
	background: #AC0B0F;
	border: none;
	color: #FFFFFF;
	display: inline-block;
	height: 30px;
	line-height: 30px;
	padding: 0 20px;
}
.log {
	font-size: 1.2rem;
	padding: 50px 0 0;
}
.log--hd {
	background: #F5F5F5;
	font-size: 1.4rem;
	font-weight: bold;
	padding: 10px 20px;
}
.log--all-count {
	border-bottom: 1px solid #F5F5F5;
	padding: 5px 20px 5px 30px;
}
.log--serial-count {
	border-bottom: 1px solid #F5F5F5;
	padding: 5px 20px 5px 40px;
}
.log--items li {
	background: #F5F5F5;
	padding: 2px 20px 2px 50px;
}
.log--items li:nth-child(2n) {
	background: #FFFFFF;
}
.log--items li span {
	background: #FFF59F;
	display: inline-block;
	position: relative;
}
.loading {
	background: url(loading.svg) 50% 50% no-repeat;
	display: none;
	height: 100%;
	left: 0;
	position: fixed;
	top: 0;
	width: 100%;
}
</style>
</head>

<body>
<div class="command">
	<div class="command--item command--item__sql"><button class="command--item--btn-file">SQLファイルを選択</button><div class="command--item--file-name"><span></span></div></div>
	<div class="command--item command--item__search_word"><input type="text" name="search_word" value="<?php if ( !empty ( $search_word ) ) echo $search_word; ?>" placeholder="検索" /></div>
	<div class="command--item command--item__arrow">→</div>
	<div class="command--item command--item__replace_word"><input type="text" name="replace_word" value="<?php if ( !empty ( $replace_word ) ) echo $replace_word; ?>" placeholder="置換" /></div>
	<div class="command--item"><button class="command--item--btn-submit">一括置換</button></div>
</div>
<input type="file" name="sql" />
<div class="log"></div>
<div class="loading"></div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script type="text/javascript">
var download = function(fd) {
	$.ajax({
		url : 'download.php',
		type: 'POST',
		dataType: 'json',
		data : fd,
		async: true,
		processData : false,
		contentType : false
	}).done(function(result){
		if (result.sql) {
			var mimeType = 'application/x-sql';
			var name = 'sql.sql';
			var blob = new Blob([result.sql], {type:mimeType});
			var a = document.createElement('a');
			a.download = name;
			a.target = '_blank';
			// for IE
			if (window.navigator.msSaveBlob) {
				window.navigator.msSaveBlob(blob, name)
			}
			// for Firefox
			else if (window.URL && window.URL.createObjectURL) {
				a.href = window.URL.createObjectURL(blob);
				document.body.appendChild(a);
				a.click();
				document.body.removeChild(a);
			}
			// for Chrome
			else if (window.webkitURL && window.webkitURL.createObject) {
				a.href = window.webkitURL.createObjectURL(blob);
				a.click();
			}
			// for Safari
			else {
				window.open('data:' + mimeType + ';base64,' + window.Base64.encode(result), '_blank');
			}
		}
		if (result.log) {
			$('.log').html('<div class="log--hd">実行結果</div><div class="log--items">' + result.log + '</div>');
		}
		$('.loading').fadeOut();
	}).fail(function() {
	});
};

$('.command--item__sql').on('click', function() {
	$('input[name="sql"]').click();
});

$('input[name="sql"]').change(function() {
	$('.command--item--file-name > span').html($(this).prop('files')[0]['name'])
});

$('.command--item--btn-submit').on('click', function() {
	var sql = $('input[name="sql"]').val();
	var search_word = $('input[name="search_word"]').val();
	var replace_word = $('input[name="replace_word"]').val();
	var fd = new FormData();
	
	if (!sql)
		$('.command--item--file-name').append('<div class="command--error">選択してください</div>');
	else
		$('.command--item--file-name .command--error').remove();
	
	if (!search_word)
		$('.command--item__search_word').append('<div class="command--error">入力してください</div>');
	else
		$('.command--item__search_word .command--error').remove();
	
	if (!replace_word)
		$('.command--item__replace_word').append('<div class="command--error">入力してください</div>');
	else
		$('.command--item__replace_word .command--error').remove();
	
	if (sql !== '' && search_word !== '' && replace_word !== '') {
		fd.append('sql', $('input[name="sql"]').prop('files')[0]);
		fd.append('search_word', search_word);
		fd.append('replace_word', replace_word);
		$('.loading').show();
		download(fd);
	}
});
</script>
</body>
</html>
