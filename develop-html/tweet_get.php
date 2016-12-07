<?php
/**************************************************

	GETメソッドのリクエスト [ベアラートークン]

	* URLとオプションを変えて色々と試してみて下さい

**************************************************/

	// 設定
	$bearer_token = '' ;	// ベアラートークン
	$request_url = 'https://api.twitter.com/1.1/search/tweets.json' ;		// エンドポイント

	// パラメータ
	$params = array(
		'q' => 'hoge' ,
		'count' => 10 ,
	) ;

	// パラメータがある場合
	if( $params )
	{
		$request_url .= '?' . http_build_query( $params ) ;
	}

	// リクエスト用のコンテキスト
	$context = array(
		'http' => array(
			'method' => 'GET' , // リクエストメソッド
			'header' => array(			  // ヘッダー
				'Authorization: Bearer ' . $bearer_token ,
			) ,
		) ,
	) ;

	// cURLを使ってリクエスト
	$curl = curl_init() ;
	curl_setopt( $curl , CURLOPT_URL , $request_url ) ;
	curl_setopt( $curl , CURLOPT_HEADER, 1 ) ;
	curl_setopt( $curl , CURLOPT_CUSTOMREQUEST , $context['http']['method'] ) ;			// メソッド
	curl_setopt( $curl , CURLOPT_SSL_VERIFYPEER , false ) ;								// 証明書の検証を行わない
	curl_setopt( $curl , CURLOPT_RETURNTRANSFER , true ) ;								// curl_execの結果を文字列で返す
	curl_setopt( $curl , CURLOPT_HTTPHEADER , $context['http']['header'] ) ;			// ヘッダー
	curl_setopt( $curl , CURLOPT_TIMEOUT , 5 ) ;										// タイムアウトの秒数
	$res1 = curl_exec( $curl ) ;
	$res2 = curl_getinfo( $curl ) ;
	curl_close( $curl ) ;

	// 取得したデータ
	$json = substr( $res1, $res2['header_size'] ) ;				// 取得したデータ(JSONなど)
	$header = substr( $res1, 0, $res2['header_size'] ) ;		// レスポンスヘッダー (検証に利用したい場合にどうぞ)

	// [cURL]ではなく、[file_get_contents()]を使うには下記の通りです…
	// $json = @file_get_contents( $request_url , false , stream_context_create( $context ) ) ;

	// JSONをオブジェクトに変換
	$obj = json_decode( $json,true ) ;

	// HTML用
	$html = '' ;

	// エラー判定
	if( !$json || !$obj )
	{
		$html .= '<h2>エラー内容</h2>' ;
		$html .= '<p>データを取得することができませんでした…。設定を見直して下さい。</p>' ;
	}

	// 検証用にレスポンスヘッダーを出力 [本番環境では不要]
	$html .= '<h2>取得したデータ</h2>' ;
	$html .= '<p>下記のデータを取得できました。</p>' ;
	$html .= 	'<h3>ボディ(JSON)</h3>' ;
	$html .= 	'<p><textarea rows="8">' . $json . '</textarea></p>' ;
	$html .= 	'<h3>レスポンスヘッダー</h3>' ;
	$html .= 	'<p><textarea rows="8">' . $header . '</textarea></p>' ;

	// for($i =0; $i<count($obj['statuses']);$i++){
	// 	$html .= '<p>'.$obj['statuses'][$i]['text'].'</p>';
	// }
	foreach($obj['statuses'] as $val){
		$html .= '<p>'.htmlspecialchars($val['text']).'</p>';
	}

?>

<?php
	// ブラウザに[$html]を出力 (HTMLのヘッダーとフッターを付けましょう)
	echo $html ;
?>
