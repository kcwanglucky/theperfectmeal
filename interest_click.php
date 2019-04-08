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

	$sql=$_SESSION['sql'];		//pass $res to here

	$res=mysql_query($sql);

	$login_name=$_SESSION['UL_username'];
	$login_password=$_SESSION['UL_password'];

	$k = 0;

	foreach($_POST['clicked'] as $i){
		if ($k = 0){
			mysql_query("UPDATE User_List SET `click_history` = '$i' WHERE `Username` = '$login_name'");
		}
		mysql_query("UPDATE User_List SET `click_history` = CONCAT(click_history, ' ', '$i') WHERE `Username` = '$login_name'");
	}

	print("<h2 align=\"center\">Thanks for your feedback</h2>");
    print("<h4 align=\"center\"><b> <a href=\"index.php\"> Back to main page! </a></b></h4>");
	//session_write_close();
	mysql_close($link);

?>