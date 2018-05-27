
addToHomescreen();

jQuery(document).ready(function($){
	$('.start-form').click(function() {
		event.preventDefault();
		$link = $(this).attr('link') + '.php';
		console.log($link);
		window.location = $link;
	})	
});