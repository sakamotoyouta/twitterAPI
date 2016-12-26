(function($){
	$(function(){
		//ajaxでtweetを取得
		$('input[type="submit"]').click(function(){
			var search_word = $('input[name="search_word"]').val();
			$.ajax({
				url: '/develop-html/get_twitter.php',
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
})(jQuery);
