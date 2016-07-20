<?php 
session_start();
require('header.php');

if( is_logged_in() ){
	header('location:profile.php?user_id='.USER_ID);
}

 ?>
<div class="heroimg">
</div>
<main class="cf">
	<section id="mainhero">
		<h2>Find musicians in your area</h2>
		<h3>Start a band. Collaborate. Jam. Learn.</h3>
		<div class="users"><h4><span>737</span> Active Users</h4></div>
		<a href="#anchorpoint"><div class="button start">Get Started</div></a>
	</section>
	<section class="intro">
		<p id="anchorpoint">Playground is an interactive social network for musicians, helping them to find each other to start bands, collaborate on existing project, jam for fun, learn about music, or whatever else they may desire.</p>
		<h2>HOW IT WORKS</h2>		
	</section>
	<section class="about cf">
		<div class="compL"><img src="imgs/comp.jpg" alt="comp"></div>
		<div class="compR text">
			<h4><span>STEP 1:</span> CREATE YOUR PROFILE</h4>
			<p>List your instruments, skills, current or previous bands</p>
			<p>Upload your own recordings or videos to show off your skillset</p>
			<a href="profile.php"><div class="button">Sign Up Now</div></a>
		</div>
	</section>
	
	<section class="about mid cf">
		<div class="compR"><img src="imgs/comp.jpg" alt="comp"></div>
		<div class="compL text">
			<h4><span>STEP 2:</span> SEARCH FOR TALENT</h4>
			<p>Find musicians with similar music tastes or search by instrument and skill</p>
			<p>Send a message or invite people to join your group</p>
			<a href="#"><div class="button">Search Now</div></a>
		</div>
	</section>
	
	<section class="about cf">
		<div class="compL"><img src="imgs/comp.jpg" alt="comp"></div>
		<div class="compR text">
			<h4><span>STEP 3:</span> SEE OR PLAY A SHOW</h4>
			<p>Browse the calendar for shows featuring other Playground users in your area</p>
			<p>Add your own shows to the list</p>
			<a href="events.php"><div class="button">Browse Now</div></a>
		</div>
	</section>
</main>


<?php 
require('footer-home.php');

 ?>