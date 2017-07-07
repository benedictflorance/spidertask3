    <!DOCTYPE html>
	<html>
  	<head>
    <title>Dashboard - tripadvisor &copy</title>
    <link href="dashboard.css" rel="stylesheet" type="text/css">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
	<link href='https://fonts.googleapis.com/css?family=Pacifico' rel='stylesheet' type='text/css'></head>
<?php
   ini_set('display_errors', 1); 
   ini_set('log_errors',1); 
   error_reporting(E_ALL); 
   mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
   include("configure.php");
   session_start();
if(isset($_SESSION['username'])&&!empty($_SESSION['username']))
{
  echo "<script>
    var flag=0,marker;
      function initMap() {
  var map = new google.maps.Map(document.getElementById('map'), {
    zoom: 4,
     center: {lat: 22.91840532, lng: 78.39637065},
  });

  map.addListener('click', function(e) {
  	if(flag)
  	marker.setMap(null);
    placeMarkerAndPanTo(e.latLng, map);
  });
}

function placeMarkerAndPanTo(latLng, map) {
    marker = new google.maps.Marker({
    position: latLng,
    map: map
  });
  map.panTo(latLng);
  flag=1;
}

 function writeJournal(){
if(marker!=null)
window.location.href=\"journal.php?lat=\"+marker.position.lat()+\"&lng=\"+marker.position.lng();
else
document.getElementsByClassName('error')[0].textContent=\"Mark a location\";
 }
function viewJournal(){
if(marker!=null)
window.location.href=\"view.php?lat=\"+marker.position.lat()+\"&lng=\"+marker.position.lng();
else
document.getElementsByClassName('error')[0].textContent=\"Mark a location\";
 }
</script>
</head>
<body>
  <div id=\"outer\">
  <div id=\"middle\">
  <a href =\"logout.php\" id=\"button\" class=\"red left\">Logout</a><a href =\"list.php\" id=\"button\" class=\"red right\">Your Journals</a>
  <h1><span style=\"color:black\"</span>trip<span style=\"color:white\"</span>advisor &copy</h1>
  <h5>An online travel diary</h5>
  <h2> Welcome to the dashboard, {$_SESSION['name']}!</h2><span class=\"error\"></span>
    <div id=\"map\"></div>
   <h2>Mark the location on the map either to write or view journals!</h2><br>
   <div id=\"two\">
   <button id=\"button\" class=\"green\" onclick=\"writeJournal()\">Write Journal about this place</button>
   <button id=\"button\" class=\"green push\" onclick=\"viewJournal()\">View Journals around this place</button>
   </div>
  </div>
  </div>
    <script src=\"https://maps.googleapis.com/maps/api/js?key=AIzaSyAH278Zlix7114h7oxweZXTjVZyCQh01EM&callback=initMap\" async defer></script>
  </body>
</html>";
}
else
	echo "</head><body><h1>Access Denied</h2><br><a id=\"button\" class=\"green\" href=\"login.php\">Click here to log in</a></div></div></body></html>";
?>
