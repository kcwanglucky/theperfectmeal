<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="keywords" content="">
<meta name="description" content="">
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


	$searchCriterion=$_POST["search_param"];
	$searchType=$_POST["search_type"];
	$searchlevel=$_POST["Search"];

	if($searchlevel == "Search"){
		if ($searchType == "Restaurant")
		{
			$sql1="SELECT * FROM `Restaurant` WHERE `res_category` LIKE '%$searchCriterion%' OR `res_menu` LIKE '%$searchCriterion%' ORDER BY `res_rating` DESC, `res_reviewcount` DESC";
			$res=mysql_query($sql1);
			$num_rows = mysql_num_rows($res);
		}

		else if ($searchType == "Recipe")
		{
			$sql2="SELECT * FROM `Recipe` WHERE `ingredient` LIKE '%$searchCriterion%' OR `name` LIKE '%$searchCriterion%' ORDER BY 'review_count' DESC, 'rating' DESC, 'made_count' DESC";
			$res=mysql_query($sql2);
			$num_rows = mysql_num_rows($res);
		}

		else
		{
			$sql1="SELECT * FROM `Restaurant` WHERE `res_category` LIKE '%$searchCriterion%' OR `res_menu` LIKE '%$searchCriterion%' ORDER BY `res_rating` DESC, `res_reviewcount` DESC";
			$sql2="SELECT * FROM `Recipe` WHERE `ingredient` LIKE '%$searchCriterion%' OR `name` LIKE '%$searchCriterion%' ORDER BY 'review_count' DESC, 'rating' DESC, 'made_count' DESC";
			$res1=mysql_query($sql1);
			$res2=mysql_query($sql2);
			$num_rows = mysql_num_rows($res1) + mysql_num_rows($res2);
		}

	}
	else{
		if ($searchType == "Restaurant")
		{
			$sql1="SELECT * FROM `Restaurant` WHERE  `review` > (SELECT AVG(review) FROM Restaurant WHERE `res_category` LIKE '%$searchCriterion%') AND `res_category` LIKE '%$searchCriterion%'ORDER BY `res_rating` DESC, `res_reviewcount` DESC";
			$res=mysql_query($sql1);
			$num_rows = mysql_num_rows($res);
		}

		else if ($searchType == "Recipe")
		{
			$sql2="SELECT * FROM `Recipe` WHERE `ingredient` LIKE '%$searchCriterion%' AND `name` LIKE '%$searchCriterion%' ORDER BY 'review_count' DESC, 'rating' DESC, 'made_count' DESC";
			$res=mysql_query($sql2);
			$num_rows = mysql_num_rows($res);
		}

		else
		{
			$sql1="SELECT * FROM `Restaurant` WHERE  `review` > (SELECT AVG(review) FROM Restaurant WHERE `res_category` LIKE '%$searchCriterion%') AND `res_category` LIKE '%$searchCriterion%'ORDER BY `res_rating` DESC, `res_reviewcount` DESC ";
			$sql2="SELECT * FROM `Recipe` WHERE `ingredient` LIKE '%$searchCriterion%' AND `name` LIKE '%$searchCriterion%' ORDER BY `review_count` DESC, `rating` DESC, `made_count` DESC ";
			$res1=mysql_query($sql1);
			$res2=mysql_query($sql2);
			$num_rows = mysql_num_rows($res1) + mysql_num_rows($res2);
		}
	}

	print("<section id=\"gallery\" class=\"parallax-section\">");
	print("<div class=\"container\">");
	print("<div class=\"row\">");
	print("<div class=\"col-md-offset-2 col-md-8 col-sm-12 text-center\" style=\"width: 1180px; margin-left: 0px; padding-left: 0px; padding-right: 0px; \">");
	print("<h1 class=\"heading\">Here are your best options!</h1>");
	print("<hr>
		");
	
		
	print("<td>&nbsp;<a href=\"index.php\">Home</a> &nbsp;
	     </td><br> ");
	
	if ($num_rows>0)
	{
		print("<p>There are " . $num_rows . " result(s) available</p>");
		$i = 1;
		$j = 1;
				
		if($searchType == "Restaurant"){
			$res=mysql_query($sql1);
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

				print("<br><br>");
				print("</div>");
				$i = $i + 1;
			}
		}
		else if($searchType == "Recipe"){
			$res=mysql_query($sql2);
			while($data=mysql_fetch_assoc($res)){
				print("<div class=\"col-md-4 col-sm-4 wow fadeInUp\" data-wow-delay=\"0.3s\">");
				print("<a href=$data[website] data-lightbox-gallery=\"zenda-gallery\"><img src=\"images/gallery-img1.jpg\" alt=\"gallery img\" ></a>");
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
		}
		else{
			$res1=mysql_query($sql1);
			$res2=mysql_query($sql2);
					
			print("<h1 class=\"heading\"><b> Search Result for Restaurants: </b></h1>");
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
				$a = str_replace(" "," / ",$result);
				$website = 'http://'.$data[res_website];

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

				print("<br><br>");
				print("</div>");
				$i = $i + 1;
			}
			print("<br><br>");
			print("<div class=\"col-md-4 col-sm-4 wow fadeInUp\" data-wow-delay=\"0.3s\" style=\"height: 507px\">");
			print("</div>");
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
				$j = $j + 1;
			}
		}
		if ($num_rows % 3 == 1){
			print("<div class=\"col-md-4 col-sm-4 wow fadeInUp\" data-wow-delay=\"0.3s\">");
			print("</div>");
			print("<div class=\"col-md-4 col-sm-4 wow fadeInUp\" data-wow-delay=\"0.3s\">");
			print("</div>");
		}
		if ($num_rows % 3 == 2){
			print("<div class=\"col-md-4 col-sm-4 wow fadeInUp\" data-wow-delay=\"0.3s\">");
			print("</div>");
		}
	}
	else
	{
		print("There is no restaurant/recipe found with your current search criterion: \"$searchCriterion\" <br> Please recheck your searching criteria! <br\> <br> Thanks! <br/>");
		print("<td>&nbsp;<a href=\"index.html\">Home</a> &nbsp;
 			</td><br> ");
	}
			
			print("</td>
		</tr>
		
	</table> ");
	//session_write_close();		
	mysql_close($link);



?>