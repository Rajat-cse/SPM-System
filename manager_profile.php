<?php   
    include 'dbh.inc.php';
    session_start();  
    if(!isset($_SESSION["sess_user"]))
    {  
        header("location:manager_login.php");  
    } 
	else if(!$con){
		echo "Connection cannot be established";
		echo "<script>setTimeout(\"location.href = 'employee_login.php';\",2500);</script>";
	}	
?>
<!DOCTYPE html>
<html>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<head>
	<link rel="stylesheet" type="text/css" href="style.css">
	<title>Manager profile</title>
</head>
<body>

	<div class="div0">
		<fieldset class="box0">
			<legend>Personal info</legend>
			<div>
				<?php 
				if($con){
		//mysqli_select_db($con,'profile') or die("cannnot connect to db");
		$flag=1;
		$user=$_SESSION['sess_user'];
		$sql=" SELECT * FROM profile.manager_profile WHERE username='$user' ";
		$result=mysqli_query($con,$sql);
		$resultcheck=mysqli_num_rows($result);
		if($resultcheck){
			if($rows=mysqli_fetch_assoc($result)){
				$image=$rows['image'];
				$phase=$rows['phase'];
				$mail=$rows['email'];
				echo '<img src="data:image/jpeg;base64,'.base64_encode( $image ).'"/>';
				
			}
			else echo "<a><img src=\"images/avatar.png\" width=\"100px\" height=\"100px\"></a>";
		}
				}
				?>
			</div>
			<div class="name">
				<h1>Hello, <?=$_SESSION['sess_user'];?></h1>
				<p>Company_name</p>
			</div>
			<div>
				<form action="manager_logout.php" method="POST">
					<button class="logout" name="logout" onclick="logout.php"type="submit" value="">Logout</button>
				</form>
			</div>
		</fieldset>
	</div>




	<div class="div1">
		<fieldset class="box1">
			<legend>Project info</legend>
			<div class="topnav">
				<a href="#home" class="active">Account</a>
				<div id="myLink0">
					<a href="account_update.php">Update</a>
				    <!--a href="#contact">Current</a>
				    <a href="#about">Forum</a-->
				</div>
				<a href="javascript:void(0);" class="icon" onclick="myFunction0()">
				</a>
			</div><br>
			<div class="topnav">
				<a href="#home" class="active">Project</a>
				<div id="myLink1">
					<a href="general_project.php">General</a>
				    <a href="current_project.php">Current</a>
				    <a href="finalchat/login.php">Forum</a>
				</div>
				<a href="javascript:void(0);" class="icon" onclick="myFunction1()">
				</a>
			</div><br>
			<div class="topnav">
				<a href="#home" class="active">Emp. Details</a>
				<div id="myLink2">
					<a href="manager_general.php">General</a>
				    <a href="employee_track.php">Track Progress</a>
				</div>
				<a href="javascript:void(1);" class="icon" onclick="myFunction2()">
				</a>
			</div>
		</fieldset>
		<fieldset class="request">
			<legend>Requests...</legend>
			
			<?php
				mysqli_select_db($con,'task') or die("Cannot select db");
				$user2=$_SESSION['sess_user'];
				$sql="SELECT * FROM request WHERE request LIKE '{$user2}%';";
				$result=mysqli_query($con,$sql);
				$resultcheck=mysqli_num_rows($result);
				if($resultcheck)
				{
					while($rows=mysqli_fetch_assoc($result))
					{	
						list($waste,$string) = explode(' ', $rows['request'], 2);
						echo $string;
						echo"<br>";
					}
				}
			?>

		</fieldset>
	</div>

	<div class="div2">
		<fieldset class="box2">
			<legend>Assign Task...</legend>
			<form action="assign_task.php" method="POST">
				<textarea name="task" rows=10 cols=97>Enter task here...</textarea>
				Assign Task ID<input type="number" name="taskid"></input>
				Input assign date:<input type="date" name="assigndate"></input><br><br>
				Input finish date:<input type="date" name="finishdate"></input><br><br>
				
				<br>
				
				<input type="radio" name="type" value="current" />Current</input>
				<input type="radio" name="type" value="upcoming" />Upcoming</input><br><br>
				<!--input type="submit" name="submit" value="Upload"-->
				Select Employee:<?php 
				include 'dbh.inc.php';

				//Adit note it from here some problem is inside the below lone.
				echo "<select name='employee_name'>";
				
				if($con)
				{
					$sql = "SELECT username FROM profile.emp_profile where phase = '$phase';";
					$result=mysqli_query($con,$sql);
					if($result)
					{
						while($row=mysqli_fetch_array($result))
						{
							echo "<option value='".$row['username']."'".">".$row['username']."</option>";
							echo"<br>";
						}
					}
				}
				else
				{
					echo "Unable to Connect ";
				}
				?>
				<br><input type="submit" name="submit"></input>
			</form>
		</fieldset>

		<fieldset class="box2">
			<legend>All Assigned Task...</legend>
			<?php 
				//here we go let's put the data if and only if available
				if($con){
					//mysqli_select_db($con,'task') or die('unable to select db');
					$sql="SELECT A.emp_name,A.task_id,A.assign_date,A.finishdate,B.current from task.assigned_task as A natural join task.all_task as B ORDER BY A.task_id;";
					$result=mysqli_query($con,$sql) or die('no data to show');
					echo"<table border='1'>
					<tr>
					<th>Task ID</th>
					<th>Task</th>
					<th>Assigned Date</th>
					<th>Finish Date</th>
					<th>Employee</th>
					</tr>";
					if($result!=False){
						while($rows=mysqli_fetch_array($result)){
							$taskid=$rows['task_id'];
							$ctask=$rows['current'];
							$employee=$row['emp_name'];
							$assigndate=$rows['assign_date'];
							$finishdate=$rows['finishdate'];
							if(!empty($ctask)){
							//echo $taskid."------".$ctask."---------".$assigndate."-----".$finishdate."-----".$employee."<br>";
								echo "<tr>";
								echo "<td>".$taskid."</td>";
								echo "<td>".$ctask."</td>";
								echo "<td>".$assigndate."</td>";
								echo "<td>".$finishdate."</td>";
								echo "<td>".$employee."</td>";
								echo "</tr>";

							}
						}
						
					}
					else{
						echo "No data to show";
					}
					
					//###############for upcoming task #############
					$sql="SELECT A.emp_name,A.task_id,A.assign_date,A.finishdate,B.upcoming from task.assigned_task as A natural join task.all_task as B ORDER BY A.task_id;";
					$result=mysqli_query($con,$sql) or die('no data to show');
					if($result!=False){
						while($rows=mysqli_fetch_array($result)){
							$taskid=$rows['task_id'];
							$utask=$rows['upcoming'];
							$employee=$row['emp_name'];
							$assigndate=$rows['assign_date'];
							$finishdate=$rows['finishdate'];
							if(!empty($utask)){
							//echo $taskid."------".$utask."---------".$assigndate."-----".$finishdate."-----".$employee."<br>";
							echo "<tr>";
							echo "<td>".$taskid."</td>";
							echo "<td>".$utask."</td>";
							echo "<td>".$assigndate."</td>";
							echo "<td>".$finishdate."</td>";
							echo "<td>".$employee."</td>";
							echo "</tr>";
							}
						}
						echo "</table>";
					}
					else{
						echo "No data to show";
					}
				}
				else{
					echo "cannot reach to database, contact your admin";
				}
				//mysqli_select_db($con,'profile') or die('Unable to display Data');
			?>
		</fieldset>
		<fieldset class="box2">
			<legend>Submission Report</legend>
				<form action="submission.php" method="POST" enctype="multipart/form-data">
					<p>Select Submission to View: <input type="file" name="viewfile"><br/></p>
					<input type="submit" name="sview" value="Show">
				</form>
				<br/>
				<form action="submission.php" method="POST" enctype="multipart/form-data">
					<p>Select File to Submit: <input type="file" name="submitfile"><br/></p>
					<input type="submit" name="ssub" value="Submit">
				</form>
		</fieldset>
	</div>

	<div class="div3">
		<fieldset class="box4">
			<legend>Requests...</legend>
			<form action="" method="POST">
				<textarea  rows=10 cols=35 name="notesubmit" >enter your request
				</textarea>
				<input  type="submit" name="subnote" value="Send">

				<?php
				if(!empty($_POST['subnote']))
				{
					$noti=$_POST['notesubmit'];
					$user1=$_SESSION['sess_user'];
					$req=$user1." ".$noti;
					mysqli_select_db($con,'task') or die("cannot connect to database");
					$sql="INSERT INTO request (request)values('$req');";
					$result=mysqli_query($con,$sql);
					if($result)
					{
						//header( "refresh:2;url=employee_profile.php?Success" );
						echo "<script>setTimeout(\"location.href='manager_profile.php'\",2000);</script>";
					}
					else
					{
						echo "Sending Failed!";
					}
				}
				?>
			</form>
		</fieldset>
		<form action="\webmail/index.php" method="POST">
			<button  class="sendemail" style="top:20px" name="email" type="" value="">Send Email</button>
		</form>
		<fieldset class="box4" style="top:40px">
			<legend>Latest Notifications...</legend>
			<?php
				if($con){
					//mysqli_select_db($con,'work') or die('connection lost to database');
					$sql="SELECT * FROM work.notification ;";
					$result=mysqli_query($con,$sql) or die('No new notifications');
					while($row=mysqli_fetch_array($result)){
						echo $row['notifications']."<br>";
					}
				}
				else{
					echo "No connection, Contact ADMIN";
				}
			?>
		</fieldset>
	</div>

</body>

<script>

function myFunction0() {
	var x = document.getElementById("myLink0");
  	if (x.style.display === "block") {
    	x.style.display = "none";
  	} else {
    	x.style.display = "block";
  	}
}
function myFunction1() {
	var x = document.getElementById("myLink1");
  	if (x.style.display === "block") {
    	x.style.display = "none";
  	} else {
    	x.style.display = "block";
  	}
}
function myFunction2() {
	var x = document.getElementById("myLink2");
  	if (x.style.display === "block") {
    	x.style.display = "none";
  	} else {
    	x.style.display = "block";
  	}
}
function myFunction3() {
	var x = document.getElementById("myLink3");
  	if (x.style.display === "block") {
    	x.style.display = "none";
  	} else {
    	x.style.display = "block";
  	}
}
</script>
</html>
