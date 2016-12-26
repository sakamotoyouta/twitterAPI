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
	$html .= '<div>';
	foreach($tweets['json']['statuses'] as $val){
		$interval_time = interval($val['created_at']);
		$li = '<div class="row">';
		$li .= '<a href="https://twitter.com/'.$val['user']['screen_name'] .'/status/'.$val['id'].'" target="_blank">';
		$li .= '<img class="col-md-1" src="'.$val['user']['profile_image_url'].'">';
		$li .= '</a>';
		$li .= '<div class="col-md-8"';
		$li .= '<p class="name">'.$val['user']['name'].'</p>';
		$li .= '<p class="text"><strong>'.htmlspecialchars($val['text']).'</strong></p>';
		$li .= '<p class="text-danger">'.$interval_time.'</p>';
		$li .= '</div>';
		$li .= '</div>';
		$html .= $li;
	}
	$html .= '</div>';
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
