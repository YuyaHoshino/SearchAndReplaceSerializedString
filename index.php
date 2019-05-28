<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>SQLのシリアライズされた文字列の一括置換プログラム</title>
<style type="text/css">
.log {
	font-size: 12px;
	line-height: 1.5;
}
</style>
</head>

<body>
<input type="file" name="sql" />
<input type="text" name="search_word" value="<?php if ( !empty ( $search_word ) ) echo $search_word; ?>" placeholder="検索" />
<input type="text" name="replace_word" value="<?php if ( !empty ( $replace_word ) ) echo $replace_word; ?>" placeholder="置換" />
<button>送信</button>
<div class="log"></div>
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
			$('.log').html('<p><strong>実行結果：</strong></p><p>' + result.log + '</p>');
		}
	}).fail(function() {
	});
};

$('button').on('click', function() {
	var sql = $('input[name="sql"]').val();
	var search_word = $('input[name="search_word"]').val();
	var replace_word = $('input[name="replace_word"]').val();
	var fd = new FormData();
	
	if (sql !== '' && search_word !== '' && replace_word !== '') {
		fd.append('sql', $('input[name="sql"]').prop('files')[0]);
		fd.append('search_word', search_word);
		fd.append('replace_word', replace_word);
		download(fd);
	}
});
</script>
</body>
</html>