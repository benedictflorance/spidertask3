<?php
	include("configure.php");
	 ini_set('display_errors', 1); 
   ini_set('log_errors',1); 
   error_reporting(E_ALL); 
   mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
	$location = $_REQUEST["location"];
	$username = $_REQUEST["user"];
	$date = $_REQUEST["date"];
	$query=$conn->prepare("UPDATE journals SET vote=vote+1 WHERE title=? AND username=? AND date=?");
	$query->bind_param("sss",$location,$username,$date);
	$query->execute();
	$query1="SELECT vote from journals WHERE title='".$location."' AND username='".$username."' AND date='".$date."'";
	$qresult1=mysqli_query($conn,$query1);
	$row=$qresult1->fetch_assoc();
	echo $row['vote'];
?>
