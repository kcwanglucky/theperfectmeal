<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/animate.min.css">
<link rel="stylesheet" href="css/font-awesome.min.css">
<link rel="stylesheet" href="css/nivo-lightbox.css">
<link rel="stylesheet" href="css/default.css">
<link rel="stylesheet" href="css/style.css" type="text/css">
<link href='https://fonts.googleapis.com/css?family=Roboto:400,500' rel='stylesheet' type='text/css'>
<?php

	if(session_status()!=PHP_SESSION_ACTIVE){
		session_start();
	} 

	if(isset($_POST["submit"])){
		if(empty($_POST["username"]) || empty($_POST["password"])){
			print("<h2 align=\"center\"><b> Invalid Username or Password</b></h2>");
			print("<h4 align=\"center\"><b> <a href=\"index.php\"> Please try again </a></b></h4>");
		}
		else{
			$link = mysql_connect('webhost.engr.illinois.edu', 'theperfectmeal_cs411', 'cs411');
			if (!$link) {
				die('Could not connect: ' . mysql_error());
			}
			mysql_select_db('theperfectmeal_cs411');

			


			$login_name=$_POST["username"];
			$login_password=$_POST["password"];



			$sql="SELECT * FROM `User_List` WHERE `Username` = '$login_name' AND `Password` = '$login_password'";

			$res=mysql_query($sql);
			$num_rows = mysql_num_rows($res);
			//$data=mysql_fetch_assoc($res);

			if ($num_rows == 0){
				print("<h2 align=\"center\"><b> Sorry. You have not signed up yet!</b></h2>");
				print("<h4 align=\"center\"><b> <a href=\"index.php\"> Sign Up Here! </a></b></h4>");
			}
			else{
				$_SESSION['UL_username'] = $login_name;
				$_SESSION['UL_password'] = $login_password;

				print("<div class=\"col-md-offset-2 col-md-8 col-sm-12 text-center\" style=\"border-right-width: 200px; margin-right: 190px;\" >");
				print("<h2><b> Hi $login_name! Welcome Back </b></h2>");
				print("<hr>");
				print("</div>");


				print("<div class=\"col-md-12 col-sm-12\" style=\"padding-left: 80px; padding-right: 80px;\">");
				print("<form action=\"adv_search.php\" method=\"post\" target=\"_blank\">");
					
				print("<h3>Get your customized recommendation!</h3>");
				print("<p align= \"left\">");
				print("<input name=\"search_type\" type=\"radio\" value=\"Restaurant\" checked />Restaurant<br/>");
				print("<input name=\"search_type\" type=\"radio\" value=\"Recipe\" />Recipe<br/>");
				print("<input name=\"search_type\" type=\"radio\" value=\"Both\" />Both<br/>");
				print("Input the dish type/ingredients you want to enjoy: <input name=\"search_param\" type=\"text\" /><br/>");
				print("<input name=\"Search\" type=\"submit\" value=\"Search\" /><br/>");
				print("</p>");
				print("</form>");
				print("</div>");

				print("<div class=\"col-md-12 col-sm-12\" style=\"padding-left: 80px; padding-right: 80px;\">");
				print("<h3> Change your location </h3>");
				print("<form action=\"update_location.php\" method=\"post\" target=\"_blank\">");
				print("Location(postal): <input name=\"location\" type=\"text\" />");
				print("<br>");
				print("<input type=\"submit\" value=\"Submit\" style=\"text-align: left\" class=\"btn-submit\">");
				print("</form>");
				print("</div>");

				print("<div class=\"col-md-12 col-sm-12\" style=\"padding-left: 80px; padding-right: 80px;\">");
				print("<form action=\"withdrawal.php\" method=\"post\" target=\"_blank\">");
				print("<h3>Withdraw the Account: </h3>");
				print("<input type=\"submit\" value=\"Submit\" style=\"text-align: left\" class=\"btn-submit\">");
				print("</form>");
				print("</div>");



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
				print("</div>");
				//header("index.php");

			}
			mysql_close($link);
		}
		exit;
	}

	/*if(isset($_SESSION['UL_username']) ) {
		print("<div class=\"col-md-offset-2 col-md-8 col-sm-12 text-center\" style=\"border-right-width: 200px; margin-right: 190px;\" >");
		print("<h2><b> Hello "); 
		echo $_SESSION['UL_username'];
		print("!</b></h2>");
		print("<hr>");
		print("</div>");


		print("<div class=\"col-md-12 col-sm-12\" style=\"padding-left: 80px; padding-right: 80px;\">");
		print("<form action=\"adv_search.php\" method=\"post\" target=\"_blank\">");
			
		print("<h3>Please select an option from the list below</h3>");
		print("<p align= \"left\">");
		print("<input name=\"search_type\" type=\"radio\" value=\"Restaurant\" checked />Restaurant<br/>");
		print("<input name=\"search_type\" type=\"radio\" value=\"Recipe\" />Recipe<br/>");
		print("<input name=\"search_type\" type=\"radio\" value=\"Both\" />Both<br/>");
		print("Input the dish type/ingredients you want to enjoy: <input name=\"search_param\" type=\"text\" /><br/>");
		print("<input name=\"Search\" type=\"submit\" value=\"Search\" /><br/>");
		print("</p>");
		print("</form>");
		print("</div>");

		print("<div class=\"col-md-12 col-sm-12\" style=\"padding-left: 80px; padding-right: 80px;\">");
		print("<h3> Change your location </h3>");
		print("<form action=\"update_location.php\" method=\"post\" target=\"_blank\">");
		print("Location(postal): <input name=\"location\" type=\"text\" />");
		print("<br>");
		print("<input type=\"submit\" value=\"Submit\" style=\"text-align: left\" class=\"btn-submit\">");
		print("</form>");
		print("</div>");

		print("<div class=\"col-md-12 col-sm-12\" style=\"padding-left: 80px; padding-right: 80px;\">");
		print("<form action=\"withdrawal.php\" method=\"post\" target=\"_blank\">");
		print("<h3>Withdraw the Account: </h3>");
		print("<input type=\"submit\" value=\"Submit\" style=\"text-align: left\" class=\"btn-submit\">");
		print("</form>");
		print("<h4 align=\"center\"><b> <a href=\"index.php\"> Back to main page! </a></b></h4>");
		print("</div>");
		header("index.php");
	}
	*/

	
?>