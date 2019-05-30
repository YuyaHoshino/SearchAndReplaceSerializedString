<?php
$sql = !empty ( $_FILES['sql']['tmp_name'] ) ? file_get_contents ( $_FILES['sql']['tmp_name'] ) : '';
$search_word = filter_input ( INPUT_POST, 'search_word', FILTER_SANITIZE_FULL_SPECIAL_CHARS );
$replace_word = filter_input ( INPUT_POST, 'replace_word', FILTER_SANITIZE_FULL_SPECIAL_CHARS );
$count = 0;
$log = '';
$sql_new = '';

if ( $sql && $search_word && $replace_word ) {
	$sql_new = $sql;
	
	// とりあえず全部置換
	$sql_new = str_replace ( $search_word, $replace_word, $sql_new );
	
	// 置換数
	$log .= '<div class="log--all-count"><strong>置換総数：</strong>' . number_format ( substr_count ( $sql, $search_word ) ) . '</div>';
	$log .= '<div class="log--serial-count"><strong>シリアライズ：</strong>';
	
	// 文字列の長さを比較
	//$add_length = strlen ( $replace_word ) - strlen ( $search_word );
	
	// シリアライズされた文字列を検索
	if ( preg_match_all ( '@s:([0-9]+):@', $sql, $count_arr ) ) {
		// カウント数だけ先に取得しておく
		$count_arr = $count_arr[1];
		
		// 「s:数字:」で区切って配列にする
		$serialize_val_arr = preg_split ( '@s:[0-9]+:@', $sql_new );
		array_shift ( $serialize_val_arr );
		
		$i = 0;
		$_log = '';
		foreach ( $serialize_val_arr as $row ) {
			if ( preg_match ( '@^((\\\)?")(.+?)((\\\)?";)@', $row, $result1 ) ) {
				// シリアライズ文字列の値部分を抽出
				$quotation1 = $result1[1];
				$serialize_val = $result1[3];
				$quotation2 = $result1[4];
				
				// 文字列を検索
				if ( preg_match_all ( '@' . $replace_word . '@', $serialize_val, $result2 ) ) {
					// もとの文字数
					$len_org = (int) $count_arr[$i];
					
					// 増加後の文字数
					$len_new = strlen ( $serialize_val );
					
					// 検索
					$serialize_org =  's:' . $len_org . ':' . $quotation1 . $serialize_val . $quotation2;
					
					// 置換
					$serialize_replace =  's:' . $len_new . ':' . $quotation1 . $serialize_val . $quotation2;
					
					// 置き換える
					$sql_new =  str_replace ( $serialize_org, $serialize_replace, $sql_new );
					
					// ログ
					$count++;
					$_log .= '<li><strong>#' . $count . "</strong> " . str_replace ( $replace_word, '<span>' . $replace_word . '</span>', $serialize_replace ) . '</li>';
				}
			}
			$i++;
		}
		$log .= number_format ( $count ) . '</div><ul class="log--items">' . $_log . '</ul>';
	}
}

$json = json_encode ( array ( 'sql' => $sql_new, 'log' => $log ) );
header ( 'Content-Type: application/json; charset=utf-8' );
echo $json;
exit;
