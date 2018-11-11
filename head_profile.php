3<?php   
    include 'dbh.inc.php';
    session_start();  
    if(!isset($_SESSION["sess_user"]))
    {  
        header("location:head_login.php");  
    } 
    else 
    {
		if($con){
		mysqli_select_db($con,'profile') or die("cannnot connect to db");
		$flag=1;
		$user=$_SESSION['sess_user'];
		$sql=" SELECT * FROM head_profile WHERE username='$user' ";
		$result=mysqli_query($con,$sql);
		$resultcheck=mysqli_num_rows($result);
		if($resultcheck){
			if($row=mysqli_fetch_assoc($result)){
				$image=$row['image'];
				$mail=$row['email'];
			}
		}
	}
	else{
		$flag=0;
		echo "Connection cannot be established";
		echo "<script>setTimeout(\"location.href = 'employee_login.php';\",2500);</script>";
	}
	?>
<!DOCTYPE html>
<html>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<head>
	<link rel="stylesheet" type="text/css" href="style.css">
	<title>Head profile</title>
</head>
<body >

	<div class="div0">
		<fieldset class="box0">
			<legend>Personal info</legend>
			<div>
				<?php 
				if($flag==1)
				{echo '<img src="data:image/jpeg;base64,'.base64_encode( $image ).'"/>';} 
				else echo '<img src="images/avatar.png">';
				?>
			</div>
			<div class="name">
				<h1>Hello,  <?=$_SESSION['sess_user'];?></h1>
				<p>Company_name</p>
			</div>
			<div>
				<form action="head_logout.php" method="POST">
					<button class="logout" name="logout" type="submit" value="">Logout</button>
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
					<a href="head_general.php">General</a>
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
		<fieldset class="request">
			<legend>Submissions</legend>
			<form action="submission.php" method="POST" enctype="multipart/form-data">
					<p>Select Submission to View: <input type="file" name="viewfile"></p>
					<input type="submit" name="sview" value="Show">
			</form>
			<form action="submission.php" method="POST" enctype="multipart/form-data">
				<p>Select File to Submit: <input type="file" name="submitfile"></p>
				Select Project:<?php 
				include 'dbh.inc.php';
				echo "<select name='project'>";
				if($con){
					//mysqli_select_db($con,'profile') or die('Unable to display Data');
					/*$sql="SELECT emp_profile.username FROM emp_profile, manager_profile where emp_profile.phase = manager_profile.phase and  manager_profile.username = '$user';";
					*/
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
				<input type="submit" name="ssub" value="Submit">
			</form>
		</fieldset>
	</div>




	<div class="div2">
			<fieldset class="box2">
				<legend>Change Notifications</legend>
				<form action="notification.php" method="POST">
				<textarea rows=10 cols=99 name="notification">
			   </textarea><br><br>
			   Give Notification Number:<input type="number" name="nono">
			   <input type="submit" name="sub1" value="notify">
			   </form>
			   <form action="notification.php" method="POST">
			   Delete Notification By Number:<input type="number" name="nonod">
			   <input type="submit" name="sub2" value="delete">
			   </form>
			</fieldset>
			<fieldset class="box2">
				<legend>Phase Details</legend>
				<!--Let's fetch all detials regarding phase-->
				<?php
					if($con){
						mysqli_select_db($con,'work') or die('Database is not accessible');
						$sql="SELECT * FROM phase;";
						$result=mysqli_query($con,$sql) or die('No data to show');
						echo"<table border='1'>
						<tr>
						<th>Project Name</th>
						<th>Phase Name</th>
						<th>Head Name</th>
						</tr>";
						if($result!=False){
							while($row=mysqli_fetch_array($result)){
								$projname=$row['prj_name'];
								$phase=$row['ph_name'];
								$headname=$row['head'];
								//echo $projname." "."------------"." ".$phase." "."-----------"." ".$headname."<br>";
								echo "<tr>";
								echo "<td>".$projname."</td>";
								echo "<td>".$phase."</td>";
								echo "<td>".$headname."</td>";
								echo "</tr>";
							}
							echo "</table>";
						}
					}
					else{
						echo "Server is out of reach";
					}
				?>
			</fieldset>
			<fieldset class="box2">
				<legend>Team Members Details</legend>
				<!--Show the details of the complete phase of only phase in which head is working-->
				<?php
					if($con){
						mysqli_select_db($con,'user_registration') or die('Database is not accessible');
						$user2=$_SESSION['sess_user'];
						$sql="SELECT a.username as head, b.username as manager, c.username as emp FROM head_login as a,manager_login as b,emp_login as c WHERE a.phase=b.phase AND a.phase=c.phase AND a.username='$user2';";
						$result=mysqli_query($con,$sql) or die('No data to show');
						echo"<table border='1'>
						<tr>
						<th>Head</th>
						<th>Manager</th>
						<th>Employee</th>
						</tr>";
						if($result!=False){
							while($row=mysqli_fetch_array($result)){
								$head=$row['head'];
								$manager=$row['manager'];
								$emp=$row['emp'];
								//echo $head." -- ".$manager." -- ".$emp."<br>";
								echo "<tr>";
									echo "<td>".$head."</td>";
									echo "<td>".$manager."</td>";
									echo "<td>".$emp."</td>";
									echo "</tr>";
							}
							echo "</table>";
						}
					}
					else{
						echo "Unable to connect at this moment";
					}
				?>
			</fieldset>
	</div>




	<div class="div3">
		<fieldset class="box4" style="top:0px">
			<legend>Requests...</legend>
			<form action="" method="POST">
				<textarea  rows=10 cols=35 name="notesubmit" >enter your request
				</textarea>
				<input type="submit" name="subnote" value="Send">
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
						echo "<script>setTimeout(\"location.href='head_profile.php'\",2000);</script>";
					}
					else
					{
						echo "Sending Failed!";
					}
				}
				?>
			</form>
		</fieldset>

		<form  action="\webmail/index.php" method="POST">
			<button  style="top:20px" class="sendemail" name="email" type="" value="">Send Email</button>
		</form>

		<fieldset class="box4" style="top:40px">
			<legend>Latest Notifications...</legend>
			<!--Fetch all notifications by all head-->
			<?php
				if($con){
					mysqli_select_db($con,'work') or die('connection lost to database');
					$sql="SELECT * FROM notification ;";
					$result=mysqli_query($con,$sql) or die('No new notifications');
					while($row=mysqli_fetch_array($result)){
						echo $row['n_id']."--".$row['notifications']." -- "."[".$row['n_date']."]"."<br>";
					}
				}
				else{
					echo "No connection, Contact ADMIN";
				}
			?>
		</fieldset>
	</div>

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
</body>
</html>
<?php
	}
	?>