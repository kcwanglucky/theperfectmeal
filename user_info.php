<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/animate.min.css">
<link rel="stylesheet" href="css/font-awesome.min.css">
<link rel="stylesheet" href="css/nivo-lightbox.css">
<link rel="stylesheet" href="css/default.css">
<link rel="stylesheet" href="css/style.css" type="text/css">
<link href='https://fonts.googleapis.com/css?family=Roboto:400,500' rel='stylesheet' type='text/css'>


<?php
	session_start();
	$link = mysql_connect('webhost.engr.illinois.edu', 'theperfectmeal_cs411', 'cs411');
	if (!$link) {
		die('Could not connect: ' . mysql_error());
	}
	mysql_select_db('theperfectmeal_cs411');

	$user_name=$_SESSION['UL_username'];

	$user_password=$_SESSION['UL_password'];

	$user_age=$_POST["user_age"];

	$user_height=$_POST["user_height"];
	
	$user_weight=$_POST["user_weight"];

	$user_race=$_POST["user_race"];
	//print("<p> a</p>");
	$user_wealth=$_POST["user_wealth"];

	$user_gender=$_POST["user_gender"];

	mysql_query("UPDATE User_List SET `age` = '$user_age', `height` = '$user_height', `weight` = '$user_weight', `race` = '$user_race', `wealth` = '$user_wealth', `gender` = '$user_gender' WHERE `Username` = '$user_name' AND `Password` = '$user_password'");
	
	print("<h2 align=\"center\">Successfully update your information</h2>");
    print("<h4 align=\"center\"><b> <a href=\"index.php\"> Back to main page! </a></b></h4>");

    //session_write_close();
    mysql_close($link);

?>