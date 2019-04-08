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

	$signup_name=$_POST["username"];

	$signup_password=$_POST["password"];
	
	$signup_email=$_POST["email"];

	$signup_location=$_POST["location"];
	//print("<p> a</p>");

	$sql="SELECT * FROM `User_List` WHERE `Username` = '$signup_name'";
	$res=mysql_query($sql);
	$num_rows = mysql_num_rows($res);
	//print("<p> a</p>");

	if (!filter_var($signup_email, FILTER_VALIDATE_EMAIL)){//Validate email address
        print("<h2 align=\"center\">Invalid email address. Please type a valid email!</h2>");
        print("<h4 align=\"center\"><b> <a href=\"index.php\"> Sign Up Again Here! </a></b></h4>");
    }

    else if ($num_rows > 0){
    	print("<h2 align=\"center\">User Already Exists!</h2>");
    	print("<h4 align=\"center\"><b> <a href=\"index.php\"> Please use another username! </a></b></h4>");
    }

    else{
    	
    	
		$_SESSION['UL_username'] = $signup_name;
		$_SESSION['UL_password'] = $signup_password;


    	mysql_query("INSERT INTO User_List (Username, Password, Email, location_postal) VALUES ('$signup_name', '$signup_password', '$signup_email', '$signup_location')");
    	print("<h2 align=\"center\">User Created!</h2>");

    	print("<div class=\"col-md-12 col-sm-12\" style=\"padding-left: 80px; padding-right: 80px;\">");
		print("<form action=\"user_info.php\" method=\"post\" target=\"_blank\">");
			
		print("<h3>Please enter the following information(Optional):</h3>");
		
		print("<p align= \"left\">");
		print("Gender: <select name=\"user_gender\"> <br/>");
		print("<option value=\"1\" selected>--Please select--<br/>");
		print("<option value=\"2\">Male");
		print("<option value=\"3\">Female");
		print("</select>");
		print(" ");
		print("</p>");

		print("<p align= \"left\">");
		print("Age: <select name=\"user_age\"> <br/>");
		print("<option value=\"1\" selected>--Please select--<br/>");
		print("<option value=\"2\">11-20");
		print("<option value=\"3\">21-30");
		print("<option value=\"4\">31-40");
		print("<option value=\"5\">41-50");
		print("<option value=\"6\">51-60");
		print("<option value=\"7\">61-70");
		print("<option value=\"8\">Below 10");
		print("</select>");
		print(" ");
		print("</p>");

		print("<p align= \"left\">");
		print("Height(cm): <select name=\"user_height\"> <br/>");
		print("<option value=\"1\" selected>--Please select--<br/>");
		print("<option value=\"2\">141-150");
		print("<option value=\"3\">151-160");
		print("<option value=\"4\">161-170");
		print("<option value=\"5\">171-180");
		print("<option value=\"6\">181-190");
		print("<option value=\"7\">190 up");
		print("</select>");
		print(" ");
		print("</p>");

		print("<p align= \"left\">");
		print("Weight(kg): <select name=\"user_weight\"> <br/>");
		print("<option value=\"1\" selected>--Please select--<br/>");
		print("<option value=\"2\">31-40");
		print("<option value=\"3\">41-50");
		print("<option value=\"4\">51-60");
		print("<option value=\"5\">61-70");
		print("<option value=\"6\">71-80");
		print("<option value=\"7\">81-90");
		print("<option value=\"8\">90 up");
		print("</select>");
		print(" ");
		print("</p>");

		print("<p align= \"left\">");
		print("Race: <select name=\"user_race\"> <br/>");
		print("<option value=\"1\" selected>--Please select--<br/>");
		print("<option value=\"2\">Chinese");
		print("<option value=\"4\">White");
		print("<option value=\"5\">Italian");
		print("<option value=\"6\">French");
		print("<option value=\"7\">German");
		print("<option value=\"8\">Black");
		print("<option value=\"10\">Hispanic");
		print("<option value=\"12\">Japanese");
		print("<option value=\"13\">Korean");
		print("<option value=\"17\">Indian");
		print("<option value=\"16\">Middle East");
		print("</select>");
		print(" ");
		print("</p>");

		print("<p align= \"left\">");
		print("Monthly Income(USD): <select name=\"user_wealth\"> <br/>");
		print("<option value=\"1\" selected>--Please select--<br/>");
		print("<option value=\"7\">Below 1000");
		print("<option value=\"2\">1000-1500");
		print("<option value=\"3\">1500-2500");
		print("<option value=\"4\">2500-3500");
		print("<option value=\"5\">3500-4500");
		print("<option value=\"6\">4500-5500");
		print("<option value=\"7\">5500 up");
		print("</select>");
		print(" ");
		print("</p>");		


		print("<input name=\"submit\" type=\"submit\" value=\"Submit\" /><br/>");

		print("</form>");
		print("</div>");

    	print("<h4 align=\"center\"><b> <a href=\"index.php\"> Back to main page! </a></b></h4>");

    }
    
    //print("<p> a</p>");
    //session_write_close();
    mysql_close($link);
    exit();
?>