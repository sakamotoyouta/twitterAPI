<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>好きな言葉でツイートを取得</title>
<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1" />
<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/style.css">
<script
  src="https://code.jquery.com/jquery-3.1.1.min.js"
  integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
  crossorigin="anonymous"></script>
  <script src="js/bootstrap.min.js"></script>
 <script src="js/script.js"></script>
</head>
<body>
<div class="container">
	<div class="page-header">
		<h1>好きなワードでツイートを検索・取得して、<br>テキストを表示します。</h1>
	</div>
	<form action="#" method="post" class="form-inline text-center">
		<div class="form-group">
			<label for="word">検索したい言葉</label>
			<input type="text" name="search_word" placeholder="検索したい言葉" value="" id="word" class="form-control">
		</div>
		<input type="submit" name="検索" class="btn btn-primary">
	</form>

	<div class="tweets">

	</div>
</div>
</body>
</html>
