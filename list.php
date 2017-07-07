<!DOCTYPE html>
	<html>
  	<head>
    <title>Your Journals - tripadvisor &copy</title>
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

if(isset($_SESSION['username'])&&!empty($_SESSION['username']))
{
  $username=$_SESSION['username'];
  echo "<a href =\"logout.php\" id=\"button\" class=\"red left\">Logout</a><a href =\"dashboard.php\" id=\"button\" class=\"red right\">Dashboard</a>
  <h1><span style=\"color:black\"</span>trip<span style=\"color:white\"</span>advisor &copy</h1>
  <h5>An online travel diary</h5>
  <h1 class=\"space\">Your Journals</h1>";
  $query=$conn->prepare("SELECT * FROM journals WHERE username= ?");
  $query->bind_param("s",$username);
  $query->execute();
  $result=$query->get_result();
  if(mysqli_num_rows($result)>0){
  while($rows=mysqli_fetch_array($result))
  {
  echo "<div class=\"box\"><h2>{$rows['title']}</h2>";
  if(isset($rows['image'])&&!empty($rows['image']))
  {
  $location="uploads\\".$rows['image'];
  echo "<img src=\"{$location}\" />";
  }
  echo "<p><span style=\"font-weight:bold\">{$rows['date']}</span> : {$rows['content']}</div>";}
  }
  else
    echo "<br><h2>Hmm, you haven't added any journals.<br> Go to Dashboard to add one!</h2>";
}
else
  echo "</head><body><h1>Access Denied</h2><br><a id=\"button\" class=\"green\" href=\"login.php\">Click here to log in</a></div></div></body></html>";
?>