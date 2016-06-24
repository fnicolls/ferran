<!DOCTYPE html>
<html>
<head>
	<title>Create Your Profile</title>
</head>
<header>
	<div id="logo"></div>
	<nav>
		<ul>
			<li><a href="">Login</a></li>
			<li><a href="">Sign Up</a></li>
		</ul>
	</nav>	
</header>
<body>
<h1>Create Your Profile</h1>
	
	<div class="avatar">
		<!-- upload profile pic / avatar -->
	</div>
	

	<form>
		<label for="name">Your Name / Alias</label>
		<input type="text" name="name" id="name">

		<label for="bio">Bio / About You</label>
		<textarea name="bio" id="bio"></textarea>

		<label for="influ">Influences / Musical Taste</label>
		<textarea name="influ" id="influ"></textarea>		

		<label for="skills">Skills / Instruments</label>
		<input type="text" name="skill1" id="skills">
		<input type="text" name="skill2" id="skills">
		<input type="text" name="skill3" id="skills">
		<!-- allow user to add additional inputs if needed -->

		<label for="goal">What I'm Looking For</label>
		<textarea name="goal" id="goal"></textarea>

		<label for="bands">Current / Previous Bands</label>
		<textarea name="bands" id="bands"></textarea>

		<label for="upload">Upload Recordings or Videos</label>
		<!-- upload field -->

		<input type="submit" name="Save">

	</form>


</body>
</html>