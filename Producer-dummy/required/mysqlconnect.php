<?php

$host="localhost";

$user="root";

$pw="";

$db="ty"; 

$port = "3306";

//  $host="runmawi.c6g3cx2hhgii.ap-south-1.rds.amazonaws.com"; //mysql.hostinger.in

//  $user="admin"; //u711448037_classroom

//  $pw="runmawi132"; //Classroom123

//  $db="runmawi"; //u711448037_classroom



//  $host="dbaas-db-9323382-do-user-12652600-0.b.db.ondigitalocean.com"; //mysql.hostinger.in

//  $user="doadmin"; //u711448037_classroom

//  $pw="AVNS_CAcNfGmYDxTKILSGgji"; //Classroom123

//  $db="defaultdb"; //u711448037_classroom

//  $port = "25060";



// $host="db-mysql-blr1-08036-do-user-12652600-0.b.db.ondigitalocean.com"; //mysql.hostinger.in

//  $user="doadmin"; //u711448037_classroom

//  $pw="AVNS_q_3ioHIFtjfGei4L6Iq"; //Classroom123

//  $db="defaultdb"; //u711448037_classroom

//  $port = "25060";



$con=mysqli_connect($host,$user,$pw,$db,$port);



if (!$con) {

	echo "<head><meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">";

	echo "</head><body>";

	echo "<div style='position:fixed; top:32%; right:0px; left:0px'>";

	echo "<center>";

	echo "<br><br><img src=\"assets/images/icons/error.png\" width=80px><br><br>";

	echo "Database server is currently down. Please try after some time.";

	echo "</center>";

	echo "</div>";

	echo "</body></html>";

	die();

}

mysqli_query($con, "SET time_zone = '+05:30'");

date_default_timezone_set("Asia/Calcutta");

?>

