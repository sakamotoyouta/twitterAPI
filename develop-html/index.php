<?php
require_once 'get_twitter.php';

//tweetの取得
$hashtag = 'hoge';//#要らない
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
?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>ハッシュタグでツイートを取得</title>
<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1" />
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
			echo '<li>'.htmlspecialchars($val['text']).'</li>';
		}
?>
	</ol>
<?php endif;?>

</body>
</html>
