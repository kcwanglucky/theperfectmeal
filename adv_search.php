<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/animate.min.css">
<link rel="stylesheet" href="css/font-awesome.min.css">
<link rel="stylesheet" href="css/nivo-lightbox.css">
<link rel="stylesheet" href="css/default.css">
<link rel="stylesheet" href="css/style.css" type="text/css">
<link href='https://fonts.googleapis.com/css?family=Roboto:400,500' rel='stylesheet' type='text/css'>

<?php
	session_start();

	$searchCriterion=$_POST["search_param"];
	$searchType=$_POST["search_type"];


	$login_name=$_SESSION['UL_username'];
	$login_password=$_SESSION['UL_password'];
	$login_location=$_POST["location"];

//new addition

	require_once("recommend.php");
	require_once("sample_list.php");
	
	$link = mysql_connect('webhost.engr.illinois.edu', 'theperfectmeal_cs411', 'cs411');
	if (!$link) {
		die('Could not connect: ' . mysql_error());
	}
	mysql_select_db('theperfectmeal_cs411');


	$re = new Recommend();

	//echo $login_name;

	$sim_user = $re->getRecommendations($userinfo, $login_name);
	//$sim_user = $re->getRecommendations($userinfo, "Angel");
	//$sim_user1 = $re->getRecommendations($userinfo, "stupid");

	//print_r($sim_user1);

	$sim_userlist = array();

	foreach ($sim_user as $key=>$value){
		$sim_userlist[] = $key;
	}

	//print_r($sim_userlist);
//new addition ends

//new addition
	$sql_postal="SELECT `location_postal` FROM User_List WHERE `Username` = '$login_name' AND `Password` = '$login_password'";
	$res_postal=mysql_query($sql_postal);
	$data_postal=mysql_fetch_assoc($res_postal);

	$postal_str=$data_postal[location_postal];
	$data_postal_str = str_split($postal_str);
	
	$postalFirst3digit = "";			//store the first three digit of postal code
	$counter = 0;

	foreach ($data_postal_str as $datadigit){
		if($counter < 3){
			$postalFirst3digit .= $datadigit; 
		}
		$counter = $counter + 1;
	}

//new addition ends


	if ($searchType == "Restaurant")
	{
		/*$sql1="SELECT * FROM Restaurant WHERE `res_category` LIKE '%$searchCriterion%' AND `address` LIKE '%' || (SELECT location_postal FROM User_List WHERE `Username` = '$login_name') || '%'";
		*/

//new addition		
		$sql_rest_recom = array();
		foreach(range(0, 5) as $j){
			$top_similar = $sim_userlist[$j];
			$sql_rest_recom[$j]="SELECT * FROM Restaurant, User_List WHERE `click_history` LIKE CONCAT('%', `res_name`, '%') AND `Username` = '$top_similar' AND `res_address` LIKE CONCAT('%', $postalFirst3digit, '__' ) ";
			/*$sql_rest_recom[$j]="SELECT * FROM Restaurant WHERE `res_category` LIKE '%$searchCriterion%' AND `res_name` LIKE (SELECT CONCAT('%', click_history, '%') FROM User_List WHERE `Username` = '$top_similar' )  AND `res_address` LIKE (SELECT CONCAT('%', location_postal, '%') FROM User_List WHERE `Username` = '$login_name')";
			*/
		}
		
		$res_rest_recom = array();
		$num_rows_rest_recom = 0;

		foreach(range(0, 5) as $k){
			$res_rest_recom[$k]=mysql_query($sql_rest_recom[$k]);
			//echo mysql_num_rows($res_rest_recom[$k]);
			//echo "    ";
			//print_r($res_rest_recom[$k]);
			$num_rows_rest_recom = $num_rows_rest_recom + mysql_num_rows($res_rest_recom[$k]);
		}
		

/*		$res_rest1=mysql_query($sql_rest_recom[0]);
		$res_rest2=mysql_query($sql_rest_recom[1]);
		$res_rest3=mysql_query($sql_rest_recom[2]);
		$res_rest4=mysql_query($sql_rest_recom[3]);
		print_r($res_rest4);

		$num_rows_rest_recom = mysql_num_rows($res_rest1) + mysql_num_rows($res_rest2) + mysql_num_rows($res_rest3) + mysql_num_rows($res_rest4);
*/

//new addition end		

		$sql1="SELECT * FROM Restaurant WHERE `res_category` LIKE '%$searchCriterion%' AND `res_address` LIKE CONCAT('%', $postalFirst3digit, '__' ) ORDER BY `res_rating` DESC";
		

		$res=mysql_query($sql1);

		$num_rows = mysql_num_rows($res);
		//echo $num_rows;
	}

	else if ($searchType == "Recipe")
	{
		
//new addition
			$user_information = array();
			$sql_user="SELECT * FROM User_List WHERE `Username` = '$login_name' AND `Password` = '$login_password' ";

			$res_user=mysql_query($sql_user);

			while($row_user = mysql_fetch_assoc($res_user)){
			    $user_information[] = $row_user;
			}
//new addition end

		$sql2="SELECT * FROM `Recipe` WHERE `ingredient` LIKE '%$searchCriterion%' OR `name` LIKE '%$searchCriterion%' ORDER BY 'review_count' DESC";
		$res=mysql_query($sql2);
		$num_rows = mysql_num_rows($res);
	}

	else
	{
		$sql1="SELECT * FROM Restaurant WHERE `res_category` LIKE '%$searchCriterion%' AND `res_address` LIKE CONCAT('%', $postalFirst3digit, '__' )  ORDER BY `res_rating` DESC";
		$sql2="SELECT * FROM `Recipe` WHERE `ingredient` LIKE '%$searchCriterion%' OR `name` LIKE '%$searchCriterion%' ORDER BY 'review_count' DESC";
		$res1=mysql_query($sql1);
		$res2=mysql_query($sql2);
		$num_rows = mysql_num_rows($res1) + mysql_num_rows($res2);
	}

//if user enter new search criteria, update to search_history attribute
	$sql3="SELECT * FROM User_List WHERE `search_history` LIKE '%$searchCriterion%' AND `Username` = '$login_name'";
	$res3=mysql_query($sql3);
	$num_rows3 = mysql_num_rows($res3);

	if($num_rows3 == 0){
		mysql_query("UPDATE User_List SET `search_history` = CONCAT(search_history, ' ', '$searchCriterion') WHERE `Username` = '$login_name' AND `Password` = '$login_password' ");
	}
	
	print("<section id=\"gallery\" class=\"parallax-section\">");
	print("<div class=\"container\">");
	print("<div class=\"row\">");
	print("<div class=\"col-md-offset-2 col-md-8 col-sm-12 text-center\" style=\"width: 1180px; margin-left: 0px; padding-left: 0px; padding-right: 0px; \">");

	
//new addition
	
	if( $num_rows_rest_recom > 0){
		print("<h1 class=\"heading\" style=\"margin-top: 50px;\">What other similar users like</h1>");
		print("<hr>");
		print("<td>&nbsp;<a href=\"index.php\">Home</a> &nbsp;
		     </td><br> ");

		print("<p>There are " . $num_rows_rest_recom . " result(s) available</p>");
		$i = 1;
		foreach(range(0, 5) as $x){
			while($data=mysql_fetch_assoc($res_rest_recom[$x])){		
				$category = $data[res_category];
				$result = "";							//separate the food categories
				$chars = str_split($category);

				foreach($chars as $char)
				{
					if($char < 'a' && strlen($result)!=0 && strcmp($char, '&') != 0 && strcmp($char, '(') != 0 && strcmp($char, ')') != 0 && strcmp($char, '-') != 0){
						$result .=' ';
						$result .=$char;
					}
					elseif (strcmp($char, '&') == 0 || strcmp($char, '(') == 0 || strcmp($char, ')') == 0) {
						continue;
					}
					else{
						
						$result .=$char;
					}
				}
				$a = str_replace(" "," / ",$result);

				$website = 'http://'.$data[res_website];
				$name=$data[res_name];
				
//new addition 
				$sql_coupon="SELECT DISTINCT * FROM Restaurant INNER JOIN Coupon ON Restaurant.res_name = Coupon.name AND `res_name` ='$data[res_name]';";
				$res_coupon=mysql_query($sql_coupon);
				$num_coupon=mysql_num_rows($res_coupon);
//new addition ends

				print("<div class=\"col-md-4 col-sm-4 wow fadeInUp\" data-wow-delay=\"0.3s\">");
				print("<a href=\"images/gallery-img1.jpg\" data-lightbox-gallery=\"zenda-gallery\"><img src=$data[res_photo] alt=\"gallery img\" style=\"height: 245px;\" ></a>");
				print("<div><h3 style=\" margin-bottom: 0px; margin-top: 10px;\"> $i: <a href=$website>{$data[res_name]}</a></h3><span>{$a}</span></div>");
				print("<b><u>Yelp Page:</u></b> <a href=$data[res_yelp_page]> Click Here </a><br/>");
				print("<b><u>Food Type:</u></b> {$result}<br/>");
				print("<b><u>Phone:</u></b> {$data[res_phonenumber]}<br/>");
				print("<b><u>Address:</u></b> {$data[res_address]}<br/>");
				print("<b><u>Review Count on Yelp:</u></b> {$data[res_reviewcount]}<br/>");
				print("<b><u>Accept credit card?:</u></b> {$data[res_credit]}<br/>");
//new addition
				if($num_coupon > 0){
					$data_coupon=mysql_fetch_assoc($res_coupon);
					print("<b><u>Coupon Available:</u></b> <a href=$data_coupon[groupon_page]> Click Here </a><br/>");
				}
//new addition end	
				print("<br><br>");
				print("</div>");
				$i = $i + 1;
			}
		}
	}
	if ($num_rows_rest_recom % 3 == 1){
		print("<div class=\"col-md-4 col-sm-4 wow fadeInUp\" data-wow-delay=\"0.3s\">");
		print("</div>");
		print("<div class=\"col-md-4 col-sm-4 wow fadeInUp\" data-wow-delay=\"0.3s\">");
		print("</div>");
	}
	if ($num_rows_rest_recom % 3 == 2){
		print("<div class=\"col-md-4 col-sm-4 wow fadeInUp\" data-wow-delay=\"0.3s\">");
		print("</div>");
	}
	print("</div>");
	

//new addition end	

	print("<div class=\"col-md-offset-2 col-md-8 col-sm-12 text-center\" style=\"width: 1180px; margin-left: 0px; padding-left: 0px; padding-right: 0px; \">");
	print("<h1 class=\"heading\" style=\"margin-top: 50px;\">Here are your best options!</h1>");
	print("<hr>");
	print("<td>&nbsp;<a href=\"index.php\">Home</a> &nbsp;
		     </td><br> ");
	
	if ($num_rows>0)
	{
		
		print("<p>There are " . $num_rows . " result(s) available</p>");
		$i = 1;
		$j = 1;
		
		if($searchType == "Restaurant"){
			$res=mysql_query($sql1);

			$_SESSION['sql'] = $sql1;
			//echo $_SESSION['sql'];
			
			print("<form action=\"interest_click.php\" method=\"post\" target=\"_blank\">");
			
			while($data=mysql_fetch_assoc($res))
			{		
				$category = $data[res_category];
				$result = "";							//separate the food categories
				$chars = str_split($category);

				foreach($chars as $char)
				{
					if($char < 'a' && strlen($result)!=0 && strcmp($char, '&') != 0 && strcmp($char, '(') != 0 && strcmp($char, ')') != 0 && strcmp($char, '-') != 0){
						$result .=' ';
						$result .=$char;
					}
					elseif (strcmp($char, '&') == 0 || strcmp($char, '(') == 0 || strcmp($char, ')') == 0) {
						continue;
					}
					else{
						
						$result .=$char;
					}
				}
				$a = str_replace(" "," / ",$result);

				$website = 'http://'.$data[res_website];
				$name=$data[res_name];
				
//new addition 
				$sql_coupon="SELECT DISTINCT * FROM Restaurant INNER JOIN Coupon ON Restaurant.res_name = Coupon.name AND `res_name` ='$data[res_name]';";
				$res_coupon=mysql_query($sql_coupon);
				$num_coupon=mysql_num_rows($res_coupon);
//new addition ends

				print("<div class=\"col-md-4 col-sm-4 wow fadeInUp\" data-wow-delay=\"0.3s\">");
				print("<a href=$website data-lightbox-gallery=\"zenda-gallery\"><img src=$data[res_photo] alt=\"gallery img\" style=\"height: 245px;\"></a>");
				print("<div><h3 style=\" margin-bottom: 0px; margin-top: 10px;\"> $i: <a href=$website>{$data[res_name]}</a></h3><span>{$a}</span></div>");
				print("<b><u>Yelp Page:</u></b> <a href=$data[res_yelp_page]> Click Here </a><br/>");
				print("<b><u>Food Type:</u></b> {$result}<br/>");
				print("<b><u>Phone:</u></b> {$data[res_phonenumber]}<br/>");
				print("<b><u>Address:</u></b> {$data[res_address]}<br/>");
				print("<b><u>Review Count on Yelp:</u></b> {$data[res_reviewcount]}<br/>");
				print("<b><u>Rating on Yelp:</u></b> {$data[res_rating]}<br/>");
				print("<b><u>Accept credit card?:</u></b> {$data[res_credit]}<br/>");
//new addition
				if($num_coupon > 0){
					$data_coupon=mysql_fetch_assoc($res_coupon);
					print("<b><u>Coupon Available:</u></b> <a href=$data_coupon[groupon_page]> Click Here </a><br/>");
				}
//new addition end				
				print("<b><u>Interest?</u></b>  <input type=\"checkbox\" value=\"{$data[res_name]}\" name=\"clicked[]\" /> ");
				

				print("<br><br>");
				print("</div>");
				$i = $i + 1;
					
			}

			print("</div>");
			
			print("</section>");
			
			print("<div class=\"col-md-offset-2 col-md-8 col-sm-12 text-center\" style=\"width: 1180px; margin-left: 0px; padding-left: 137px; padding-right: 0px; \">");
			print("<input name=\"submit\" type=\"submit\" value=\"Submit\" style=\"border-left-width: 2px; margin-left: 550px; margin-right: 550px; \" /><br/>");
			print("</form>");
			print("</div>");

			
		}
		else if($searchType == "Recipe"){
			

			$res=mysql_query($sql2);
			while($data=mysql_fetch_assoc($res)){
				print("<div class=\"col-md-4 col-sm-4 wow fadeInUp\" data-wow-delay=\"0.3s\">");
				print("<a href=$data[website] data-lightbox-gallery=\"zenda-gallery\"><img src=\"images/gallery-img1.jpg\" alt=\"gallery img\"></a>");
				

				print("<div><h3 style=\"margin-top: 10px;\"> $j: <a href=$data[website]>{$data[name]} </a></h3></div>");
				print("<b><u>Website:</u></b> <a href=$data[website]> Click Here</a><br/>");


				print("<b><u>Number of review:</u></b> {$data[review_count]}<br/>");
				print("<b><u>Number of made:</u></b> {$data[made_count]}<br/>");
				print("<b><u>Time(min):</u></b> {$data[time]}<br/>");
				print("<b><u>Calorie(cals):</u></b> {$data[calorie]}<br/>");
				print("<br><br>");
				print("</div>");
				$j = $j + 1;
			}
			print("</div>");
			
			print("</section>");
		}
		else{
			$res1=mysql_query($sql1);
			$res2=mysql_query($sql2);

			print("<h1 class=\"heading\"><b> Search Result for Restaurants: </b></h1>");

			$_SESSION['sql'] = $sql1;
			//echo $_SESSION['sql'];
			
			print("<form action=\"interest_click.php\" method=\"post\" target=\"_blank\">");
			$k = 1;
			$l = 1;

			while($data=mysql_fetch_assoc($res1))
			{		
				$category = $data[res_category];
				$result = "";							//separate the food categories
				$chars = str_split($category);

				foreach($chars as $char)
				{
					if($char < 'a' && strlen($result)!=0 && strcmp($char, '&') != 0 && strcmp($char, '(') != 0 && strcmp($char, ')') != 0 && strcmp($char, '-') != 0){
						$result .=' ';
						$result .=$char;
					}
					elseif (strcmp($char, '&') == 0 || strcmp($char, '(') == 0 || strcmp($char, ')') == 0) {
						continue;
					}
					else{
						
						$result .=$char;
					}
				}
				//print("<h1>{$result}</h1>");
				$a = str_replace(" "," / ",$result);

				
				$website = 'http://'.$data[res_website];
				$name=$data[res_name];

//new addition 
				$sql_coupon="SELECT DISTINCT * FROM Restaurant INNER JOIN Coupon ON Restaurant.res_name = Coupon.name AND `res_name` ='$data[res_name]';";
				$res_coupon=mysql_query($sql_coupon);
				$num_coupon=mysql_num_rows($res_coupon);
//new addition ends

				print("<div class=\"col-md-4 col-sm-4 wow fadeInUp\" data-wow-delay=\"0.3s\">");
				print("<a href=$website data-lightbox-gallery=\"zenda-gallery\"><img src=$data[res_photo] alt=\"gallery img\" style=\"height: 245px;\"></a>");
				print("<div><h3 style=\" margin-bottom: 0px; margin-top: 10px;\"> $k: <a href=$website>{$data[res_name]}</a></h3><span>{$a}</span></div>");
				print("<b><u>Yelp Page:</u></b> <a href=$data[res_yelp_page]> Click Here </a><br/>");
				print("<b><u>Food Type:</u></b> {$result}<br/>");
				print("<b><u>Phone:</u></b> {$data[res_phonenumber]}<br/>");
				print("<b><u>Address:</u></b> {$data[res_address]}<br/>");
				print("<b><u>Review Count on Yelp:</u></b> {$data[res_reviewcount]}<br/>");
				print("<b><u>Rating on Yelp:</u></b> {$data[res_rating]}<br/>");
				print("<b><u>Accept credit card?:</u></b> {$data[res_credit]}<br/>");
				
//new addition
				if($num_coupon > 0){
					$data_coupon=mysql_fetch_assoc($res_coupon);
					print("<b><u>Coupon Available:</u></b> <a href=$data_coupon[groupon_page]> Click Here </a><br/>");
				}
//new addition end
				print("<b><u>Interest?</u></b>  <input type=\"checkbox\" value=\"{$data[res_name]}\" name=\"clicked[]\" /> ");
				

				print("<br><br>");
				print("</div>");
				$k = $k + 1;
			}

			print("<br><br>");

			print("<h1 class=\"heading\"><b> Search Result for Recipes: </b></h1>");
			while($data=mysql_fetch_assoc($res2)){
				print("<div class=\"col-md-4 col-sm-4 wow fadeInUp\" data-wow-delay=\"0.3s\">");
				print("<a href=$data[website] data-lightbox-gallery=\"zenda-gallery\"><img src=\"images/gallery-img1.jpg\" alt=\"gallery img\"></a>");
				print("<div><h3 style=\"margin-top: 10px;\"> $j: <a href=$data[website]>{$data[name]} </a></h3></div>");
				print("<b><u>Website:</u></b> <a href=$data[website]> Click Here</a><br/>");
				print("<b><u>Number of review:</u></b> {$data[review_count]}<br/>");
				print("<b><u>Number of made:</u></b> {$data[made_count]}<br/>");
				print("<b><u>Time(min):</u></b> {$data[time]}<br/>");
				print("<b><u>Calorie(cals):</u></b> {$data[calorie]}<br/>");
				print("<br><br>");
				print("</div>");
				$l = $l + 1;
			}
			print("</div>");
			print("</section>");

			print("<div class=\"col-md-offset-2 col-md-8 col-sm-12 text-center\" style=\"width: 1180px; margin-left: 0px; padding-left: 137px; padding-right: 0px; \">");
			print("<input name=\"submit\" type=\"submit\" value=\"Submit\" style=\"border-left-width: 2px; margin-left: 550px; margin-right: 550px; \" /><br/>");
			print("</form>");
			print("</div>");
		}
		
		print("<div class=\"col-md-offset-2 col-md-8 col-sm-12 text-center\" style=\"width: 1180px; margin-left: 0px; padding-left: 265px; padding-right: 0px; padding-bottom: 100px; \">");
		print("<td>&nbsp;<a href=\"index.php\">Home</a> &nbsp;
		     </td><br> ");
		print("</div>");
	}	



	else
	{
		print("There is no restaurant/recipe found with your current search criterion: \"$searchCriterion\" <br> Please recheck your searching criteria! <br\> <br> Thanks! <br/>");
		print("<td>&nbsp;<a href=\"index.php\">Home</a> &nbsp;
 			</td><br> ");
	}
			
			print("</td>
		</tr>
		
	</table> ");




	//require_once("recommend_test.php");
	




	//session_write_close();
	mysql_close($link);



?>