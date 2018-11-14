<?php
	include 'dbh.inc.php';
	session_start();
	if($con){
		$employee="employee";
		$manager="manager";
		$head="head";
		$superhead="superhead";
		$user=$_SESSION['sess_user'];
	}
	else{
		echo "No Connection";
	}
?>
<?php
 $post=$_SESSION['post'];
 $super="superhead";
 if(strcasecmp($post,$super)==0){
	 ?>
<!DOCTYPE html>

<html>
<link href="project.css" rel="stylesheet" type="text/css">
<head>
<title>General project detail</title>
</head>

<body>
<form action="superhead_profile.php" method="">
		<button style="top:-5px;left:1050px"class="logout" value="logout">Back</button>
</form>
<div>
<form action="" method="POST" enctype="multipart/form-data">
<p id="id1">Select Project  Name:</p><?php 
					echo "<select name='project'>";
					include 'dbh.inc.php';
					if($con){
						mysqli_select_db($con,'work') or die('Unable to display Data');
						$sql="SELECT * FROM project;";
						$result=mysqli_query($con,$sql);
						if($result){
							while($row=mysqli_fetch_array($result)){
								echo "<option class=\"blinking\" value='".$row['prj_name']."'".">".$row['prj_name']."</option>";
								echo $row['prj_name'];
							}
							echo "</select>";
					}
					}
					else{
						echo "Unable to Connect ";
					}
					?>
<br/>
<!--span class="blinking">Am I blinking?</span-->
<br/>					
<input type="file" name="file" placeholder="Place your file">
<br/>
<input type="submit" name="submit" value="Upload">
</form>
</div>



<!--div>
<p>Serial No.</p>
</div>

<div>
<p>Project</p>
</div>

<div>
<p>Phase</p>
</div>

<div>
<p>Head</p>
</div>

<div>
<p>Manager</p>
</div>

<div>
<p>Employee</p>
</div>

<div>
<p>Budget</p>
</div>

<div>
<p>Initial Time</p>
</div>

<div>
<p>Finish Time</p>
</div>

<div>
<p>No. of Days</p>
</div-->

</body>
</html>
 <?php
 }
 //finish if condition for superhead 
 //now checking if there is any submission
if($con){
	if(isset($_POST['submit']) && count($_FILES)>0){
				mysqli_select_db($con,'work') or die ('Database out of reach');
				
				$project=$_POST['project'];
				if(!empty($_FILES['file']['tmp_name'])&& file_exists($_FILES['file']['tmp_name'])){
					$file= addslashes(file_get_contents($_FILES['file']['tmp_name']));
				    $sql="UPDATE project SET prj_file='{$file}' where prj_name='$project'; ";
					
					if(mysqli_query($con,$sql)){
						echo "Project Details updated successfully";
						echo "<script>setTimeout(\"location.href = 'general_project.php';\",2500);</script>";
					}
				}
				else{
						echo "Error in updating file";
						}
		
	
}
}
else{
	echo "Unable to upload at this time";
	echo "<script>setTimeout(\"location.href = 'current_project.php';\",2500);</script>";
}
 ?>

<?php
	//Displaying details for everyone
	include 'dbh.inc.php';
  
    if(!isset($_SESSION["sess_user"]))
    {  
        header("location:superhead_profile.php");  
    } 
    else 
    {
		if($con){
		mysqli_select_db($con,'work') or die("cannnot connect to db");
		$flag=1;
		$user=$_SESSION['sess_user'];
		$sql=" SELECT * FROM project;";
		$result=mysqli_query($con,$sql);
		$resultcheck=mysqli_num_rows($result);
		if($resultcheck){
			while($row=mysqli_fetch_array($result)){
				$file1=$row['prj_file'];
				echo '<link rel="stylesheet" type="text/css" href="project.css"></head>';
				echo"<br/>"."<br/>"."<br/>"."<br/>";
				echo"Project Name --";
				echo "<p class=\"blinking\">".$row['prj_name']."</p>";
				//echo"<br/>";
				echo "Total Budget Allocated--";
				echo "<p class=\"blinking\">".$row['budget']."</p>";
				echo"<br/>";
				echo "Total People Working on this Project --";
				echo "<p class=\"blinking\">".$row['efforts']."<br/>";
				echo"<br/>";
				echo '<img src="data:image/jpeg;base64,'.base64_encode( $file1 ).'"/>';
				echo"<br/>"."<br/>"."<br/>"."<br/>";
			}
		}
	}
	else{
		$flag=0;
		echo "Connection cannot be established";
		echo "<script>setTimeout(\"location.href = 'employee_login.php';\",2500);</script>";
	}
	}
				
				
	?>


