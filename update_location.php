<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/animate.min.css">
<link rel="stylesheet" href="css/font-awesome.min.css">
<link rel="stylesheet" href="css/nivo-lightbox.css">
<link rel="stylesheet" href="css/default.css">
<link rel="stylesheet" href="css/style.css" type="text/css">
<link href='https://fonts.googleapis.com/css?family=Roboto:400,500' rel='stylesheet' type='text/css'>

<?php
	
	$link = mysql_connect('webhost.engr.illinois.edu', 'theperfectmeal_cs411', 'cs411');
	if (!$link) {
		die('Could not connect: ' . mysql_error());
	}
	mysql_select_db('theperfectmeal_cs411');

	session_start();

	$login_name=$_SESSION['UL_username'];
	$login_password=$_SESSION['UL_password'];
	$login_location=$_POST["location"];

	$sql="UPDATE User_List SET `location_postal`= '$login_location' WHERE `Username` = '$login_name' AND `Password` = '$login_password'";

	$res=mysql_query($sql);
	$num_rows = mysql_num_rows($res);

	print("<div class=\"col-md-offset-2 col-md-8 col-sm-12 text-center\">");
	print("<h1 class=\"heading\"> Location Changed! </h1>");
	print("<hr>");
	print("<h1 class=\"heading\"><b> <a href=\"index.php\"> Back to main page! </a></b></h1>");
	print("</div>");

	session_write_close();
	mysql_close($link);

?>