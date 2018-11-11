<?php
  include 'dbh.inc.php';
  session_start();  
    if(!isset($_SESSION["sess_user"]))
    {  
        header("location:admin_login.php");  
    } 
    else 
    {
		//echo "Please make appropriate changes";
	}
	?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="style-4.css">
<title>assign project</title>
</head>

<body>
	<p><b>Please Make Appropriate Changes</b></p>
<div class="div2" style="position:relative;top:100px">
	<fieldset class="box6">
		<legend>New Project Details</legend>
			<form method="POST">
				Project_Name		:<input class="textbox" style="min-width:400px" type="text" name="prjname"></input><br/><br/><br/>
				Initial_Date        :<input class="textbox" style="min-width:400px" type="date" name="init"></input><br/><br/><br/>
				Final_Date  		:<input class="textbox" style="min-width:400px" type="date" name="inid"></input><br/><br/><br/>
				Budget      		:<input class="textbox" style="min-width:400px" type="number" name="budget"></input><br/><br/><br/>
				Efforts_No.of_People     :<input class="textbox" style="min-width:400px" type="number" name="efforts"></input><br/><br/><br/>
				<input class="choosefile" type="submit" name="submit1"></input>
			</form>
	</fieldset>

	<fieldset class="box6">
		<legend>Allocate Phase</legend>
			<form method="POST">
				Phase_Name  		:
									<select name='phase' class="textbox">
									<option value='Analysis' >Analysis</option>
									<option value='Design'>Design</option>
									<option value='Coding'>Coding</option>
									<option value='Testing'>Testing</option>
									<option value='Deployment'>Deployment</option>
									<option value='Maintenance'>Maintenance</option>
									</select>
									<br/><br/><br/>
				Head_Name   		:<?php 
									include 'dbh.inc.php';
									echo "<select name='head'>";
									if($con){
										$sql = "SELECT username FROM user_registration.head_login;";
										$result=mysqli_query($con,$sql);
										if($result){
											while($row=mysqli_fetch_array($result)){
												echo "<option value='".$row['username']."'".">".$row['username']."</option>";
											}
											echo "</select>";
									}
									}
									else{
										echo "Unable to Connect ";
									}
								
									?> 
									<br/><br/><br/>
				Project_Name		:
									<?php 
									include 'dbh.inc.php';
									echo "<select name='project'>";
									if($con){
										$sql = "SELECT prj_name FROM work.project;";
										$result=mysqli_query($con,$sql);
										if($result){
											while($row=mysqli_fetch_array($result)){
												echo "<option value='".$row['prj_name']."'".">".$row['prj_name']."</option>";
											}
									}
									}
									else{
										echo "Unable to Connect ";
									}
								
									?> 
									<br/><br/>
				<input class="choosefile" type="submit" name="submit2">
			</form>
	</fieldset>


	<fieldset class="box6">
		<legend>All Project Details</legend>
		<!--fetch data and show here-->
			<?php
				if($con)
				{
					mysqli_select_db($con,'work') or die('cannot reach to database');
					$sql="SELECT prj_name,init,inid,budget,efforts FROM project;";
					$result=mysqli_query($con,$sql) or die('No data to preview');

					while($rows=mysqli_fetch_assoc($result))
					{
						echo $rows['prj_name']." ".$rows['init']." ".$rows['inid']." ".$rows['budget']." ".$rows['efforts']."<br>";
					}
					
				}
				else
				{
					echo "Cannot connect at this time";
				}
			?>
	</fieldset>

	<fieldset class="box2">
		<legend>All Phase Details</legend>
		<!--fetch data and show here-->
			<?php
				if($con)
				{
					mysqli_select_db($con,'work') or die('cannot reach to database');
					$sql="SELECT * FROM phase;";
					$result=mysqli_query($con,$sql) or die('No data to preview');
					while($rows=mysqli_fetch_assoc($result)){
						echo $rows['prj_name']." ".$rows['ph_name']." ".$rows['head']."<br>";
					}
					
				}
				else
				{
					echo "Cannot connect at this time";
				}
			?>
	</fieldset>
</div>
</body>
</html>

<?php
	if($con){
		mysqli_select_db($con,'work') or die('unable to connect to database');
		if(isset($_POST['submit1'])){
				if(!empty($_POST['prjname']) && !empty($_POST['init']) && !empty($_POST['inid']) && !empty($_POST['budget']) && !empty($_POST['efforts'])){
					$prjname=$_POST['prjname'];
					$init=$_POST['init'];
					$inid=$_POST['inid'];
					$budget=$_POST['budget'];
					$efforts=$_POST['efforts'];
					$sql="INSERT INTO project (prj_name,init,inid,budget,efforts)VALUES ('$prjname','$init','$inid','$budget','$efforts') ;";
					$result=mysqli_query($con,$sql) or die('Project already exist ,cannot process data at this time');
					if($result){
						header("Location: assign_project.php?registration=SUCCESS");
					}
				}
				else{
					echo "All fields are required !";
					echo "<script>setTimeout(\"Location.href='assign_project.php'\",2500)</script> ";
				}
		}
		
		//############## for submit2 ###################
		if(isset($_POST['submit2'])){
			if(!empty($_POST['phase']) && !empty($_POST['head']) && !empty($_POST['project'])){
				$ph_name=strtoupper($_POST['phase']);
				$head=$_POST['head'];
				$proj=$_POST['project'];
				$q1="SELECT * FROM user_registration.head_login WHERE username='$head';";
				$result=mysqli_query($con,$q1) or die ('No Head exist');
				if($row=mysqli_fetch_assoc($result)){
					$check1=$row['username'];
					$check2=$row['phase'];
					if(strcasecmp($ph_name,$check2)==0){
						$sql= "INSERT INTO phase VALUES ('$ph_name','$head','$proj') ;";
						$result=mysqli_query($con,$sql) or die ('Phase already exist');
						if($result){
							header("Location: assign_project.php?SUCCESS");
						}
					}
					else{
						header("Location: assign_project.php?try_correct_phase_of_head");
					}
				}
				
			}
			else{
				header("Location: assign_project.php?Please Enter Proper data");
				}
		}
		
	}
	else{
		echo "unable to connect to database, Please proceed at later time"; 
	}
?>