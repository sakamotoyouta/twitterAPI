<?php
/**************************************************

	ベアラートークンを用いてtweetの取得

**************************************************/
class Conect_twapi{
	public $bearer_token = '';
	public $request_url = 'https://api.twitter.com/1.1/search/tweets.json' ;
	public $params = array();
	public $context = [];
	public $search_word = '';
	public $count = 0;

	function __construct($word,$count){
		//リクエスト用のコンテキストの設定
		$this->context = array(
			'http' => array(
				'method' => 'GET' , // リクエストメソッド
				'header' => array(			  // ヘッダー
					'Authorization: Bearer ' . $this->bearer_token ,
				) ,
			) ,
		);
		$this->search_word = $word;
		$this->count = $count;
	}

	public function get_tweet(){
		// リクエスト用パラメータ
		$this->params['q']=$this->search_word;
		$this->params['count']=$this->count;
		$this->params['lang']='ja';
		$this->params['locale']='ja';
		$this->params['result_type']='recent';
		// パラメータがある場合
		if( $this->params ){
			$this->request_url .= '?' . http_build_query( $this->params ) ;
		}
		// cURLを使ってリクエスト
		$curl = curl_init() ;
		curl_setopt( $curl , CURLOPT_URL , $this->request_url ) ;
		curl_setopt( $curl , CURLOPT_HEADER, 1 ) ;
		curl_setopt( $curl , CURLOPT_CUSTOMREQUEST , $this->context['http']['method'] ) ;			// メソッド
		curl_setopt( $curl , CURLOPT_SSL_VERIFYPEER , false ) ;								// 証明書の検証を行わない
		curl_setopt( $curl , CURLOPT_RETURNTRANSFER , true ) ;								// curl_execの結果を文字列で返す
		curl_setopt( $curl , CURLOPT_HTTPHEADER , $this->context['http']['header'] ) ;			// ヘッダー
		curl_setopt( $curl , CURLOPT_TIMEOUT , 5 ) ;										// タイムアウトの秒数
		$res1 = curl_exec( $curl ) ;
		$res2 = curl_getinfo( $curl ) ;
		curl_close( $curl ) ;
		// 取得したデータ
		$json = json_decode(substr($res1, $res2['header_size']),true);				// 取得したデータ(JSONなど)
		$header = substr( $res1, 0, $res2['header_size'] ) ;		// レスポンスヘッダー (検証に利用したい場合にどうぞ)
		$response = array("json"=>$json,"header"=>$header);
		return $response;
	}
}
