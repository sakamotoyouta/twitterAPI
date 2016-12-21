<?php
require_once 'class/conect-twitter.php';

$html = '';
if(isset($_POST["word"])){
	$word = $_POST["word"];
}else{
	echo "検索ワードを入力してね";
	return;
}
//tweetの取得
$count = '10';
$tw_api = new Conect_twapi($word,$count);
$tweets = $tw_api->get_tweet();

// エラー判定
$error = array();
if( !$tweets['json'] ){
	$error[] = "データを取得することができませんでした…。設定を見直して下さい。";
}
if(empty($tweets['json']['statuses'])){
	$error[] = '"'.$word.'"ではツイートが見つかりませんでした。';
}


if(count($error) > 0){
	$html .= "<h2>エラー内容</h2>";
	foreach ($error as $val){
		$html .= "<p>".$val."</p>";
	}
}else{
	$html .= '<ol>';
	foreach($tweets['json']['statuses'] as $val){
		$interval_time = interval($val['created_at']);
		$li = '<li>';
		$li .= '<p><img src="'.$val['user']['profile_image_url'].'"></p>';
		$li .= '<p> name: '.$val['user']['name'].'</p>';
		$li .= '<p>text: '.htmlspecialchars($val['text']).'</p>';
		$li .= '<p class="time">'.$interval_time.'</p>';
		$li .= '</li>';
		$html .= $li;
	}
	$html .= '<ol>';
}

echo $html;

//時間設定
function interval($src) {
	$now = new DateTime();
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
