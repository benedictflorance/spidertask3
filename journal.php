<!DOCTYPE html>
	<html>
  	<head>
    <title>Review - tripadvisor &copy</title>
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
   $flag=0;
   if(isset($_GET['lat'])&&isset($_GET['lng']))
   {
    $lat=$_GET['lat'];
    $lng=$_GET['lng'];
    $flag=1;
   }
$fileErr=$titleErr=$contentErr=$submitErr=$dateErr='';
if(isset($_SESSION['username'])&&!empty($_SESSION['username'])&&$flag)
{
if(isset($_POST['submit']))
{ $name='';
  $errors=0;
  $title=$_POST['title'];
  $date=trim(mysqli_real_escape_string($conn,$_POST['date']));
  $content=$_POST['content'];
  $username=$_SESSION['username'];
  $privacy=$_POST['privacy'];
  $name=$_FILES['image']['name'];  
  $temp_name=$_FILES['image']['tmp_name'];
  $sql1 =$conn->prepare("SELECT date FROM journals WHERE lat=? AND lng=? AND username=?");
  $sql1->bind_param("dds",$lat,$lng,$username);
  $sql1->execute();
  $result1=$sql1->get_result();
  $row1=mysqli_fetch_array($result1);
  if((mysqli_num_rows($result1)==1)&&($row1['date']==$date)) 
  {$contentErr="You've already reviewed the location on the mentioned date";
    $errors++;}

  $query =$conn->prepare("SELECT date FROM journals WHERE title=? AND username=?");
  $query->bind_param("ss",$title,$username);
  $query->execute();
  $output=$query->get_result();
  $rows=mysqli_fetch_array($output);
  if((mysqli_num_rows($output)==1)&&($rows['date']==$date)) 
  {$contentErr="You've already reviewed the location on the mentioned date";
    $errors++;}
  if(empty($title))
  {$titleErr="Title Cannot be Empty";
  $errors++;}
  if(empty($content))
  {$contentErr="Content Cannot be Empty";
  $errors++;}
  if (!preg_match("/^\d{1,2}\/\d{1,2}\/\d{4}$/",$date)) 
{
  $dateErr="Invalid Date Format";
  $errors++;
}
  else{
    $datearr= explode('/', $date);
if (!checkdate($datearr[1], $datearr[0], $datearr[2])) {
  $dateErr="Invalid Date";
  $errors++;
}
  }
  if(empty($date))
  {$dateErr="Date Cannot be Empty";
  $errors++;}
$newname='';
$filename=uniqid();
if(isset($name)&&!empty($name))
    { $upload=1;
      $info = pathinfo($_FILES['image']['name']);
      $imageFileType = $info['extension'];
      $newname = $filename.".".$imageFileType; 
      $target = 'uploads/'.$newname;
       if ($_FILES["image"]["size"] > 2000000) {
        $fileErr="Sorry, your file is too large.";
        $errors++;
        $upload=0;
      }
     $check = getimagesize($temp_name);
      if(!$check) 
      {
        $fileErr="Invalid Image Format";
        $errors++;
        $upload=0;
      }
      if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
      && $imageFileType != "gif" ) {
        $fileErr="Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $errors++;
        $upload=0;}
        if($upload&& !$errors)
        {if (move_uploaded_file($_FILES["image"]["tmp_name"], $target)) {
    } else {
        $fileErr="Upload failed";
        $errors++;
    }}

    }
  if(!$errors)
  {
  $vote=0;
  $sql =$conn->prepare("INSERT INTO journals(title,content,lat,lng,image,vote,date,username,public) VALUES(?,?,?,?,?,?,?,?,?)");
  $sql->bind_param("ssddsisss",$title,$content,$lat,$lng,$newname,$vote,$date,$username,$privacy);
  $result=$sql->execute();
  $submitErr="Journal Succesfully entered. You'll be redirected to dashboard shortly.";
  header("refresh:2;url=dashboard.php");
}
}
 echo  "<a href =\"logout.php\" id=\"button\" class=\"red left\">Logout</a><a href =\"dashboard.php\" id=\"button\" class=\"red right\">Change Location</a>
  <h1><span style=\"color:black\"</span>trip<span style=\"color:white\"</span>advisor &copy</h1>
  <h5>An online travel diary</h5>
  <h2>Share your travel joruney!</h2>
  <span class=\"success\">";echo $submitErr;echo "</span><br>
  <form action=\"";echo htmlentities($_SERVER["PHP_SELF"])."?lat=".$lat."&lng=".$lng;echo "\" method=\"post\" enctype=\"multipart/form-data\">
    <span style=\"color:red\">All * fields are mandatory</span><br>
    <textarea spellcheck=\"false\" onkeyup=\"this.style.height='24px'; this.style.height = this.scrollHeight + 12 + 'px';\" name=\"content\"></textarea><br><span class=\"error\">";echo $contentErr;echo"</span><br>
    <label> Location:<span style=\"color:red\">*</span><input type = \"text\" name = \"title\"/></label><br><span class=\"error\">";echo $titleErr;echo"</span><br>
    <label> Date of Entry(dd/mm/yyyy):<span style=\"color:red\">*</span><input type = \"text\" name = \"date\"/></label><br><span class=\"error\">";echo $dateErr;echo"</span><br>
    <label> Upload Image?  <input type = \"file\" name = \"image\"/></label><br><span class=\"error\">";echo $fileErr;echo"</span><br>
    Privacy:<span style=\"color:red\">*</span>
    <label><input type=\"radio\" name=\"privacy\" value=\"yes\" checked>Public</label>
    <label><input type=\"radio\" name=\"privacy\" value=\"no\">Private</label><br>
    <input id=\"button\"class=\"red\" type =\"submit\" class=\"red\" name=\"submit\" value = \"Review\"/><br>
    </form></div></div>
    </body>";
}
else
  echo "</head><body><h1>Access Denied</h2><br><a id=\"button\" class=\"green\" href=\"login.php\">Click here to log in</a></div></div></body></html>";
?>