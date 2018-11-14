<?php
	include 'dbh.inc.php';
	session_start();
	if($con){
		$employee="employee";
		$manager="manager";
		$head="head";
		$superhead="superhead";
		$user=$_SESSION['sess_user'];
		$post=$_SESSION['post'];
	}
	else{
		echo "No Connection";
	}
?>

<?php
if(strcasecmp($post,$head)==0){?>
<!DOCTYPE html>

<html>
<link rel="stylesheet" type="text/css" href="project.css" >
<head>
<title>Current project detail</title>
</head>

<body>
<div>
<form action="" method="POST" enctype="multipart/form-data">
<p id="id1">Select Project  Name:</p>
				<?php 
					echo "<select name='project'>";
					include 'dbh.inc.php';
					if($con){
						mysqli_select_db($con,'work') or die('Unable to display Data');
						$sql="SELECT * FROM project_dir;";
						$result=mysqli_query($con,$sql);
						if($result){
							while($row=mysqli_fetch_array($result)){
								echo "<option class=\"blinking\" value='".$row['prj_name']."'".">".$row['prj_name']."</option>";
								//echo $row['prj_name'];
							}
							echo "</select>";
					}
					}
					else{
						echo "Unable to Connect ";
					}
					?>
<br/>
<br/>
<br/>
<br/>
<p id="id1">Phase Name:</p>
	<select name='phase'>
		<option value="r&d">R&D</option>
								<option value='Analysis' >Analysis</option>
								<option value='Design'>Design</option>
								<option value='Coding'>Coding</option>
								<option value='Testing'>Testing</option>
								<option value='Deployment'>Deployment</option>
								<option value='Maintenance'>Maintenance</option>
								
	</select>					
<br/>
<br/>
<br/>
<br/>
<br/>					
<input type="file" name="file" placeholder="Place your file">
<input type="submit" name="submit" value="Upload">
</form>
</div>
</div>
</body>
</html>

<?php
}
if($con){
	if(isset($_POST['submit']) && count($_FILES)>0){
				mysqli_select_db($con,'work') or die ('Database out of reach');
				
				$project=$_POST['project'];
				$phase=strtoupper($_POST['phase']);
				
				if(!empty($_FILES['file']['tmp_name'])&& file_exists($_FILES['file']['tmp_name'])){
					//echo $phase."---".$project;
					$file= addslashes(file_get_contents($_FILES['file']['tmp_name']));
				    $sql="UPDATE project_dir SET cprj_file='{$file}' where prj_name='$project' AND ph_name='$phase'; ";
					
					if(mysqli_query($con,$sql)){
						
						echo " Current Project Details updated successfully";
						echo "<script>setTimeout(\"location.href = 'current_project.php';\",2500);</script>";
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
		
		$sql=" SELECT * FROM project_dir;";
		$result=mysqli_query($con,$sql);
		$resultcheck=mysqli_num_rows($result);
		if($resultcheck){
			while($row=mysqli_fetch_array($result)){
				$file1=$row['cprj_file'];
				//echo '<link rel="stylesheet" type="text/css" href="project.css"></head>';
				echo"<br/>"."<br/>"."<br/>"."<br/>";
				echo "Project Name --";
				echo "<p class=\"blinking\">".$row['prj_name']."</p>";
				//echo"<br/>";
				echo "Phase--> "."<class=\"blinking\">".$row['ph_name']." <--Budget Allocated for this phase-- <p class=\"blinking\">".$row['budget']."</p>";
				//echo"<br/>";
				echo "Total Number of Working days for this Phase --";
				echo "<p class=\"blinking\">".$row['days']."</p>";
				echo"<br/>";
				echo '<img src="data:image/jpeg;base64,'.base64_encode( $file1 ).'"/>';
				echo"<br/>"."<br/>"."<br/>"."<br/>";
			}
		}
	}
	else{
		echo "Connection cannot be established";
		echo "<script>setTimeout(\"location.href = 'employee_login.php';\",2500);</script>";
	}
	}
				
				
	?>


