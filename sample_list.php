<?php

/*$books =  array(
                
    "phil" => array("my girl" => 2.5, "the god delusion" => 3.5,
                    "tweak" => 3, "the shack" => 4,
                    "the birds in my life" => 2.5,
                    "new moon" => 3.5),
    
    "sameer" => array("the last lecture" => 2.5, "the god delusion" => 3.5,
                      "the noble wilds" => 3, "the shack" => 3.5,
                      "the birds in my life" => 2.5, "new moon" => 1),
    
    "john" => array("a thousand splendid suns" => 5, "the secret" => 3.5,
                    "tweak" => 1),
    
    "peter" => array("chaos" => 5, "php in action" => 3.5),
    
    "jill" => array("the last lecture" => 1.5, "the secret" => 2.5,
                    "the noble wilds" => 4, "the host: a novel" => 3.5,
                    "the world without end" => 2.5, "new moon" => 3.5),
    
    "bruce" => array("the last lecture" => 3, "the hollow" => 1.5,
                     "the noble wilds" => 3, "the shack" => 3.5,
                     "the appeal" => 2, "new moon" => 3),
    
    "tom" => array("chaos" => 2.5)
    
    
);
*/

$link = mysql_connect('webhost.engr.illinois.edu', 'theperfectmeal_cs411', 'cs411');
if (!$link) {
    die('Could not connect: ' . mysql_error());
}
    
mysql_select_db('theperfectmeal_cs411');

$sql="SELECT `Username` FROM User_List ORDER BY `Username`";
$sql1="SELECT `location_postal`, `search_history`, `click_history`, `age`, `height`, `weight`, `race`, `wealth`, `gender` FROM User_List ORDER BY `Username`";
$res=mysql_query($sql);
$res1=mysql_query($sql1);
$userinfo = array();


while($row_username = mysql_fetch_assoc($res)){
    $row_userother = mysql_fetch_assoc($res1);
    $userinfo[$row_username['Username']] = $row_userother;
}

/*foreach($userinfo as $key=>$value)
    {
        print_r($key);
        print_r($value);
        print_r("\n");
    }
*/



//print_r($userinfo);
#print_r("<br>");
#print_r("<br>");
#print_r("<br>");
#print_r($books);

mysql_close($link);


?>