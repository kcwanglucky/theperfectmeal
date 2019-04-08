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

	$contact_name=$_POST["name"];
	
	$contact_email=$_POST["email"];

	$contact_message=$_POST["message"];
	//print("<p> a</p>");

	$sql="INSERT INTO Contact (name, email, message) VALUES ('$contact_name', '$contact_email', '$contact_message')";
	mysql_query($sql);
	print("<h2 align=\"center\">Thanks for your message!</h2>");
    print("<h4 align=\"center\"><b> <a href=\"index.php\"> Back to main page! </a></b></h4>");
    mysql_close($link);
	
?>