<?php
require_once 'get_twitter.php';

//tweetの取得
$hashtag = 'javascript';//#要らない
$count = '10';
$tw_api = new Conect_twapi($hashtag,$count);
$tweets = $tw_api->get_tweet();

// JSONをオブジェクトに変換
$obj = json_decode( $tweets['json'],true ) ;

// エラー判定
$error = array();
if( !$tweets['json'] || !$obj ){
	$error[] = "データを取得することができませんでした…。設定を見直して下さい。";
}
if(empty($obj['statuses'])){
	$error[] = '"'.$hashtag.'"ではツイートが見つかりませんでした。';
}

$now = new DateTime();
function interval($src) {
	global $now;
	$timestamp = strtotime($src);
	$created_time = date('Y-m-d H:i:s',$timestamp);
	$created_time = new DateTime($created_time);
	$interval = $created_time->diff($now);
	if($interval->i <= 0){
		return "たった今";
	}elseif($interval->h <= 0){
		return $interval->i."分前";
	}elseif($interval->d <= 0){
		return $interval->h."時間前";
	}elseif ($interval->m <= 0) {
		return $interval->d."日前";
	}
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>ハッシュタグでツイートを取得</title>
<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1" />
<style media="screen">
	li{
		margin-bottom: 30px;
	}
	p{
		margin-bottom: 5px;
		margin-top: 0px;
	}
	p.time{
		color: #f00;
		font-weight: bold;
	}
</style>
</head>
<body>
<h1>好きなハッシュタグでツイートを検索・取得して、テキストを表示します。</h1>
<?php
	if(count($error) > 0):
		echo "<h2>エラー内容</h2>";
		foreach ($error as $val){
			echo "<p>".$val."</p>";
		}
	else: ?>
	<ol>
<?php
	foreach($obj['statuses'] as $val){
		$interval_time = interval($val['created_at']);
		$li = '<li>';
		$li .= '<p><img src="'.$val['user']['profile_image_url'].'"></p>';
		$li .= '<p> name: '.$val['user']['name'].'</p>';
		$li .= '<p>text: '.htmlspecialchars($val['text']).'</p>';
		$li .= '<p class="time">'.$interval_time.'</p>';
		$li .= '</li>';
		echo $li;
	}
?>
	</ol>
<?php endif;?>

</body>
</html>
