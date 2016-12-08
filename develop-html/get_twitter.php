<?php
/**************************************************

	ベアラートークンを用いてtweetの取得

**************************************************/
class Conect_twapi{
	public $bearer_token = '';
	public $request_url = 'https://api.twitter.com/1.1/search/tweets.json' ;
	public $params = array();

	function __construct($hashtag,$count){
		// リクエスト用パラメータ
		$this->params['q']='#'.$hashtag;
		$this->params['count']=$count;
		$this->params['lang']='ja';
		// パラメータがある場合
		if( $this->params ){
			$this->request_url .= '?' . http_build_query( $this->params ) ;
		}
	}

	public function get_tweet(){
		// リクエスト用のコンテキスト
		$context = array(
			'http' => array(
				'method' => 'GET' , // リクエストメソッド
				'header' => array(			  // ヘッダー
					'Authorization: Bearer ' . $this->bearer_token ,
				) ,
			) ,
		);
		// cURLを使ってリクエスト
		$curl = curl_init() ;
		curl_setopt( $curl , CURLOPT_URL , $this->request_url ) ;
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
		$response = array("json"=>$json,"header"=>$header);
		return $response;
	}
}
