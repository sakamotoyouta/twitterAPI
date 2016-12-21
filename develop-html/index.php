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
<script
  src="https://code.jquery.com/jquery-3.1.1.min.js"
  integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
  crossorigin="anonymous"></script>
<script>
	$(function(){
		$('input[type="submit"]').click(function(){
			var search_word = $('input[name="search_word"]').val();
			$.ajax({
				url: 'get_twitter.php',
				type: 'POST',
				data: {word:search_word}
			}).done(function(data){
				$('.tweets').html(data);
			}).fail(function(){
				console.log('error');
			});
			return false;
		});
	});
</script>
</head>
<body>
<h1>好きなハッシュタグでツイートを検索・取得して、テキストを表示します。</h1>
<form action="#" method="post">
	<input type="text" name="search_word" placeholder="検索したい言葉を入れてね" value="">
	<input type="submit" name="検索">
</form>
<div class="tweets">

</div>
</body>
</html>
