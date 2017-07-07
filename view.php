<!DOCTYPE html>
	<html>
  	<head>
    <title>View Journals - tripadvisor &copy</title>
    <link href="dashboard.css" rel="stylesheet" type="text/css">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
	<link href='https://fonts.googleapis.com/css?family=Pacifico' rel='stylesheet' type='text/css'>
  <link href="https://fonts.googleapis.com/css?family=Satisfy" rel="stylesheet">
</head>
<?php
   ini_set('display_errors', 1); 
   ini_set('log_errors',1); 
   error_reporting(E_ALL); 
   mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
   include("configure.php");
   session_start();
   $flag=0;
   if(isset($_GET['lat'])&&isset($_GET['lng']))
   {
    $lat=$_GET['lat'];
    $lng=$_GET['lng'];
    $flag=1;
   }

if(isset($_SESSION['username'])&&!empty($_SESSION['username'])&&$flag)
{
  echo "<a href =\"logout.php\" id=\"button\" class=\"red left\">Logout</a><a href =\"dashboard.php\" id=\"button\" class=\"red right\">Dashboard</a>
  <h1><span style=\"color:black\"</span>trip<span style=\"color:white\"</span>advisor &copy</h1>
  <h5>An online travel diary</h5>
  <h1 class=\"space\">Journals In and Around</h1>";
  $latlow=$lat-1.5;
  $lathigh=$lat+1.5;
  $lnglow=$lng-1.5;
  $lnghigh=$lng+1.5;
  $query=$conn->prepare("SELECT * FROM journals WHERE (lat BETWEEN ? AND ?) AND (lng BETWEEN ? AND ?)");
  $query->bind_param("dddd",$latlow,$lathigh,$lnglow,$lnghigh);
  $query->execute();
  $result=$query->get_result();
  if(mysqli_num_rows($result)>0){
  while($rows=mysqli_fetch_array($result))
  {
  if($rows['public']=="yes")
  {echo "<div class=\"box\"><h2>{$rows['title']}<h2><h5>By {$rows['username']}</h5>";
  if(isset($rows['image'])&&!empty($rows['image']))
  {
  $location="uploads\\".$rows['image'];
  echo "<img src=\"{$location}\" />";
  }
  echo "<br><span style=\"font-weight:bold\">{$rows['date']}</span> : {$rows['content']}</div>";}
  }}
  else
    echo "<br><h2>Alas, No journals near this location.<br> Go to Dashboard to add one!</h2>";
}
else
  echo "</head><body><h1>Access Denied</h2><br><a id=\"button\" class=\"green\" href=\"login.php\">Click here to log in</a></div></div></body></html>";
?>