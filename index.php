<?php
session_start();
include('login.php');
if(isset($_SESSION['UL_username'])){
	
}

?>
<html>
	<head>
		<meta charset="utf-8">
		<title>The Perfect Meal</title>

		<meta http-equiv="X-UA-Compatible" content="IE=Edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="keywords" content="">
		<meta name="description" content="">

<!--

Template 2076 Zentro

http://www.tooplate.com/view/2076-zentro

-->
		<link rel="stylesheet" href="css/bootstrap.min.css">
		<link rel="stylesheet" href="css/animate.min.css">
		<link rel="stylesheet" href="css/font-awesome.min.css">
		<link rel="stylesheet" href="css/nivo-lightbox.css">
		<link rel="stylesheet" href="css/default.css">

		<link rel="stylesheet" href="css/style.css" type="text/css">
		<link href='https://fonts.googleapis.com/css?family=Roboto:400,500' rel='stylesheet' type='text/css'>

	</head>

	<body>
		<!-- preloader section 
		<section class="preloader">
		<div class="sk-spinner sk-spinner-pulse"></div>
		</section>
		

		<!-- navigation section -->
		<section class="navbar navbar-default navbar-fixed-top" role="navigation">
			<div class="container">
				<div class="navbar-header">
					<button class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
						<span class="icon icon-bar"></span>
						<span class="icon icon-bar"></span>
						<span class="icon icon-bar"></span>
					</button>
					<a href="#" class="navbar-brand">The Perfect Meal</a> 
				</div>
				<div class="collapse navbar-collapse">
					<ul class="nav navbar-nav navbar-right">
						<?php if(isset($_SESSION['UL_username'])){

							print("<li><a href=\"login.php\">Hi ");
							echo $_SESSION['UL_username'];
							print("</a></li>");
						}
						?>	
						<li><a href="#home" class="smoothScroll">Home</a></li>
						<li><a href="#search" class="smoothScroll">Restaurant</a></li>
						<li><a href="#search" class="smoothScroll">Recipe</a></li>
						
						<?php if(isset($_SESSION['UL_username'])){
							print("<li><a href=\"logout.php\">Log Out</a></li>");
						}
						else{
							print("<li><a href=\"#login\" class=\"smoothScroll\">Log In</a></li>");
							print("<li><a href=\"#signup\" class=\"smoothScroll\">Sign Up</a></li>");
						}
						?>

						<li><a href="#contact" class="smoothScroll">Contact Us</a></li>
					</ul>
				</div>
			</div>
		</section>

		<!-- home section -->
		<section id="home" class="parallax-section">
			<div class="container">
				<div class="row">
					<div class="col-md-12 col-sm-12">
						<h1>Wanna have a perfect meal?</h1>
						<h2>Get tasty dishes based on your preference!</h2>
						<a href="#search" class="smoothScroll btn btn-default">Start Here</a>
					</div>
				</div>
			</div>		
		</section>


		<section id="search" class="parallax-section">
			<div class="container">
				<div class="row">
					<div class="col-md-offset-2 col-md-8 col-sm-12 text-center">
						<h1 class="heading">Begin your customized search</h1>
						<hr>
					</div>	
					<br/>
					<br/>
					<br/>
					<br/>
					<div class="col-md-12 col-sm-12" style="padding-left: 80px; padding-right: 80px;">	
						<h3>Please select an option from the list below</h3>
						
						<?php
						if(isset($_SESSION['UL_username'])){
							print("<form action=\"adv_search.php\" method=\"post\" target=\"_blank\">");	
							print("<p align= \"left\">");
							print("<input name=\"search_type\" type=\"radio\" value=\"Restaurant\" checked />Restaurant<br/>");
							print("<input name=\"search_type\" type=\"radio\" value=\"Recipe\" />Recipe<br/>");
							print("<input name=\"search_type\" type=\"radio\" value=\"Both\" />Both<br/>");
							print("Input the dish type/ingredients you want to enjoy: <input name=\"search_param\" type=\"text\" /><br/>");
							print("<input name=\"Search\" type=\"submit\" value=\"Search\" /><br/>");
							print("<input name=\"Search\" type=\"submit\" value=\"Search Popular\" /><br/>");
							print("</p></form>");
						}
						else{
							print("<form action=\"search_resrec.php\" method=\"post\" target=\"_blank\">");	
							print("<p align= \"left\">");
							print("<input name=\"search_type\" type=\"radio\" value=\"Restaurant\" checked />Restaurant<br/>");
							print("<input name=\"search_type\" type=\"radio\" value=\"Recipe\" />Recipe<br/>");
							print("<input name=\"search_type\" type=\"radio\" value=\"Both\" />Both<br/>");
							print("Input the dish type/ingredients you want to enjoy: <input name=\"search_param\" type=\"text\" /><br/>");
							print("<input name=\"Search\" type=\"submit\" value=\"Search\" /><br/>");
							print("<input name=\"Search\" type=\"submit\" value=\"Search Popular\" /><br/>");
							print("</p></form>");
						}

						?>

					</div>
				</div>
			</div>
		</section>	
		
		<?php

		if(isset($_SESSION['UL_username'])){
			goto here;
		}

		?>

		<section id="login" class="parallax-section">
			<div class="container">
				<div class="row">
					<div class="col-md-offset-2 col-md-8 col-sm-12 text-center">
						<h1 class="heading">Log In</h1>
						<hr>
					</div>
					<br/>
					<br/>	
					<br/>
					<br/>
					<div class="col-md-12 col-sm-12" style="padding-left: 80px; padding-right: 80px;">		
						<h3>Log In</h3>
						<form action="login.php" method="post" target="_blank">
							<p align= "left">
							Username:&nbsp <input name="username" type="text" /><br/>
							Password:&nbsp <input name="password" type="password" /><br/>
							<input name="submit" type="submit" value="Log in" class="btn-submit">
							</p>
						</form>
					</div>	
				</div>
			</div>
		</section>

		<section id="signup" class="parallax-section">
			<div class="container">
				<div class="row">
					<div class="col-md-offset-2 col-md-8 col-sm-12 text-center">
						<h1 class="heading">Create an account</h1>
						<hr>
					</div>
					<br/>
					<br/>
					<br/>
					<br/>	
					<div class="col-md-12 col-sm-12" style="padding-left: 80px; padding-right: 80px;">		
						<h3>Sign Up</h3>
						<form action="signup.php" method="post" target="_blank">
							<p align= "left">
							Requested Username: <input name="username" type="text" /><br/>							
							Requested Password: <input name="password" type="password" /><br/>
							Registered Email: <input name="email" type="text" /><br/>
							Location(postal): <input name="location" type="text" /><br/>
							<input type="submit" value="Sign Up" class="btn-submit">
							</p>
						</form>
					</div>	
				</div>
			</div>
		</section>

		<?php

		here:

		?>
		<section id="contact" class="parallax-section">
			<div class="container">
				<div class="row">
					<div class="col-md-offset-2 col-md-8 col-sm-12 text-center">
						<h1 class="heading">Contact Us</h1>
						<hr>
					</div>
					<div class="col-md-offset-1 col-md-10 col-sm-12 wow fadeIn" data-wow-delay="0.9s">
						<form action="contact.php" method="post">
							<div class="col-md-6 col-sm-6">
								<input name="name" type="text" class="form-control" id="name" placeholder="Name">
						    </div>
							<div class="col-md-6 col-sm-6">
								<input name="email" type="email" class="form-control" id="email" placeholder="Email">
						    </div>
							<div class="col-md-12 col-sm-12">
								<textarea name="message" rows="8" class="form-control" id="message" placeholder="Message"></textarea>
							</div>
							<div class="col-md-offset-3 col-md-6 col-sm-offset-3 col-sm-6">
								<input name="submit" type="submit" class="form-control" id="submit" value="Submit">
							</div>
						</form>
					</div>
				</div>
			</div>
		</section>

	<?php
		//exit();
		//session_write_close();

	?>
	
	<!-- JAVASCRIPT JS FILES -->	
	<script src="js/jquery.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/jquery.parallax.js"></script>
	<script src="js/smoothscroll.js"></script>
	<script src="js/nivo-lightbox.min.js"></script>
	<script src="js/wow.min.js"></script>
	<script src="js/custom.js"></script>
	</body>
</html>