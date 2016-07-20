<footer class="cf">
	<div class="flinks">
		<a href="#">ABOUT US</a> | 
		<a href="#">TERMS OF SERVICE</a> | 
		<a href="#">RSS</a>
	</div>
</footer>

</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>
<script>
	$(window).scroll(function() {
	if ($(this).scrollTop() > 670){  
	    $('header').addClass("sticky");
	    $('#logo').addClass("logostick");
	  }
	  else{
	    $('header').removeClass("sticky");
	    $('#logo').removeClass("logostick");
	  }
	});


	$(".start").click(function() {
    $('html, body').animate({
        scrollTop: $("#anchorpoint").offset().top - 100
    }, 1500);
});
</script>
</html>