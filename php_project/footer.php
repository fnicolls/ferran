<footer class="cf">
	<div class="flinks">
		<a href="about.php">ABOUT US</a> | 
		<a href="tos.php">TERMS OF SERVICE</a> | 
		<a href="rss.php">RSS</a>
	</div>
</footer>

</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>
<script>
	$(window).scroll(function() {
		if ($(this).scrollTop() > 120){  
		    $('header').addClass("sticky");
		    $('#logo').addClass("logostick");
		}else{
		    $('header').removeClass("sticky");
		    $('#logo').removeClass("logostick");
		}
		if($(this).scrollTop() > 160){
			$('#main-nav').addClass("stickynav");
		}else{
			 $('#main-nav').removeClass("stickynav");
		}
	});




	$(".start").click(function() {
	    $('html, body').animate({scrollTop: $("#anchorpoint").offset().top - 100}, 1500);
	});

</script>
</html>