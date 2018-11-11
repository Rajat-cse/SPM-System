<?php   
	include 'dbh.inc.php';
    session_start();
	$user=$_SESSION['sess_user'];
    if(!isset($_SESSION["sess_user"]))
    {  
        header("location:employee_login.php");  
    } 
	else if($con){
		//mysqli_select_db($con,'profile') or die("cannnot connect to db");
		$flag=1;
		$user=$_SESSION['sess_user'];
		$sql=" SELECT * FROM profile.emp_profile WHERE username='$user' ";
		$result=mysqli_query($con,$sql);
		$resultcheck=mysqli_num_rows($result);
		if($resultcheck){
			if($row=mysqli_fetch_assoc($result)){
				$image=$row['image'];
				$mail=$row['email'];
			}
		}
	}
	else if(!$con){
		$flag=0;
		echo "Connection cannot be established";
		echo "<script>setTimeout(\"location.href = 'employee_login.php';\",2500);</script>";
	}	
?>
	<?php
	if($con){
		//mysqli_select_db($con,'task');
		$sql1="SELECT * FROM task.all_task AS a, task.assigned_task AS b WHERE a.task_id = b.task_id AND b.emp_name ='$user';";
		$result1=mysqli_query($con,$sql1);
		//$numrows=mysqli_num_rows($result1);
		if($result1!=False){
			$flag1=1;
		}
		else{
			$flag1=0;
		}
	}else{
		echo "Unable to reach db";
	}
	
	?>
	
<!DOCTYPE html>
<html>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<head>
	<link rel="stylesheet" type="text/css" href="emp_css.css">
	<title>Employee profile</title>
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
		$sql=" SELECT * FROM profile.emp_profile WHERE username='$user';";
		$result=mysqli_query($con,$sql);
		$resultcheck=mysqli_num_rows($result);
		if($resultcheck){
			if($row=mysqli_fetch_assoc($result)){
				$image=$row['image'];
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
				<form action="employee_logout.php" method="POST">
					<button class="logout" name="logout" onclick="logout.php"type="submit" value="">Logout</button>
				</form>
			</div>
		</fieldset>
	</div>

	<div class="div1">
		<fieldset class="box1">
			<legend>General Info</legend>
			<div class="topnav">
				<a class="active">Account</a>
				<div id="myLink0">
					<a href="account_update.php">Update</a>
				    <!--a href="#contact">Current</a>
				    <a href="#about">Forum</a-->
				</div>
				<a href="javascript:void(0);" class="icon" onclick="myFunction0()">
				</a>
			</div><br>
			<div class="topnav">
				<a class="active">Project</a>
				<div id="myLink1">
					<a href="general_project.php">General</a>
				    <a href="current_project.php">Current</a>
				    <a href="finalchat/login.php">Forum</a>
				</div>
				<a href="javascript:void(0);" class="icon" onclick="myFunction1()">
				</a>
			</div><br>
			<div class="topnav">
				<a class="active">Emp. Details</a>
				<div id="myLink2">
					<a href="employee_general.php">General</a>
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
			<fieldset class="box2" style="min-height:150px">
				<legend>Today's Task</legend>
				<?php
					if($flag1!=0)
					{
						//mysqli_select_db($con,'task') or die('cannot select db');
						$sql1="SELECT * FROM task.all_task AS a, task.assigned_task AS b WHERE a.task_id = b.task_id AND b.emp_name ='$user' ORDER BY a.task_id;";
						$result1=mysqli_query($con,$sql1);
						echo"<table border='1'>
						<tr>
						<th>Finish</th>
						<th>Current</th>
						</tr>";
						while($row1=mysqli_fetch_array($result1))
						{
							//echo "rahul";
							$man=$row1['manager_name'];
							$emp=$row1['emp_name'];
							$assign=$row1['assign_date'];
							$finish=$row1['finishdate'];
							$tid=$row1['task_id'];
							$current=$row1['current'];
							$todays_date=strtotime('today');
							$date1 = strtotime($row1['finishdate']);
							if($todays_date < $date1)
							{	//echo "rahul";
								if(!empty($row1['current'])){
								//echo $finish."-----".$row1['current']."<br>";
								echo "<tr>";
								echo "<td>".$finish."</td>";
								echo "<td>".$row1['current']."</td>";
								echo "</tr>";
								}
							}
							else{
								if(!empty($current)){
									//move this task to pending task
									$q1="DELETE FROM task.assigned_task WHERE task_id='$tid';";
									if($res=mysqli_query($con,$q1)!=False){
									
										$q1="DELETE FROM task.all_task WHERE task_id='$tid';";
										if($res=mysqli_query($con,$q1)!=False){
											$q2="INSERT INTO task.all_task (task_id,pending) values('$tid','$current');";
											if($res2=mysqli_query($con,$q2)!=False){
												$q2="INSERT INTO task.assigned_task (manager_name,emp_name,assign_date,finishdate,task_id) values('$man','$emp','$assign','$finish','$tid');";
												if($res2=mysqli_query($con,$q2)!=False){
													//done
													//echo "No task for Today";
												}
											}
											else{
												echo "Some error has occured !, Cannot show the data";
											}
										}
									}
								}
							}							
						}
						echo "</table>";
					}
				?>
			</fieldset>
			<fieldset class="box2"style="min-height:150px">
				<legend>Pending Task</legend>
							<?php
					if($flag1!=0)
					{
						//mysqli_select_db($con,'task') or die('cannot select db');
						$sql3="SELECT * FROM task.all_task AS a, task.assigned_task AS b WHERE a.task_id = b.task_id AND b.emp_name ='$user' ORDER BY a.task_id;";
						$result3=mysqli_query($con,$sql3);
						echo"<table border='1'>
						<tr>
						<th>Finish Date</th>
						<th>Pending</th>
						</tr>";	
						while($row3=mysqli_fetch_array($result3))
						{
								if(!empty($row3['pending'])){
								//echo $row3['finishdate']."-----".$row3['pending']."<br>";
								echo "<tr>";
								echo "<td>".$row3['finishdate']."</td>";
								echo "<td>".$row3['pending']."</td>";
								echo "</tr>";

								}						
						}
						echo "</table>";
					}
				?>
				
			</fieldset>
			<fieldset class="box2" style="min-height:150px">
				<legend>Upcoming Task</legend>
				<?php
					if($flag1!=0)
					{
						$sql1="SELECT * FROM task.all_task AS a, task.assigned_task AS b WHERE a.task_id = b.task_id AND b.emp_name ='$user'ORDER BY a.task_id;";
						$resultcheck=mysqli_query($con,$sql1);
						echo"<table border='1'>
						<tr>
						<th>Assign Date</th>
						<th>Upcoming</th>
						</tr>";
						while($row1=mysqli_fetch_array($resultcheck))
						{
							$man=$row1['manager_name'];
							$emp=$row1['emp_name'];
							$assign=$row1['assign_date'];
							$finish=$row1['finishdate'];
							$tid=$row1['task_id'];
							$upcoming=$row1['upcoming'];
							$todays_date=strtotime('today');
							$date1=$row1['assign_date'];
							$date1 = strtotime($date1);
							//echo $date1."----------".$todays_date;
							if($todays_date < $date1)
							{   
								if(!empty($row1['upcoming'])){
								//	echo $assign."-----".$row1['upcoming']."<br>";
								echo "<tr>";
								echo "<td>".$assign."</td>";
								echo "<td>".$row1['upcoming']."</td>";
								echo "</tr>";
								}
							}
							else{
								if(!empty($upcoming)){
									//move this task to current task
									$q1="DELETE FROM task.assigned_task WHERE task_id='$tid';";
									if($res=mysqli_query($con,$q1)!=False){
										$q1="DELETE FROM task.all_task WHERE task_id='$tid';";
										if($res=mysqli_query($con,$q1)!=False){
											$q2="INSERT INTO task.all_task (task_id,current) values('$tid','$upcoming');";
											if($res2=mysqli_query($con,$q2)!=False){
												$q2="INSERT INTO task.assigned_task (manager_name,emp_name,assign_date,finishdate,task_id) values('$man','$emp','$assign','$finish','$tid');";
												if($res2=mysqli_query($con,$q2)!=False){
													//done
												}
											}
											else{
												echo "Some error has occured !, Cannot show the data";
											}
										}
									}
								}	
							}
						}
						echo"</table>";
					}
					//mysqli_select_db($con,'profile') or die('cannot select db');
				?>
			</fieldset>
			<fieldset class="box2" style="min-height:80px">
				<legend>Submission</legend>
				<br>
				<form action="submission.php" method="POST" enctype="multipart/form-data">
						Select Task ID:<?php 
						include 'dbh.inc.php';
						echo "<select name='task_id'>";
						if($con){
							
							//mysqli_select_db($con,'task') or die('Unable to display Data');
							
							$sql = "SELECT task_id FROM task.assigned_task where emp_name = '$user';";
							$result=mysqli_query($con,$sql);
							if($result){
								while($row=mysqli_fetch_array($result)){
									echo "<option value='".$row['task_id']."'".">".$row['task_id']."</option>";
								}
								echo "</select>";
						}
						}
						else{
							echo "Unable to Connect ";
						}
						?>

					<input  type="file" name="file">

					<input class="upload" name="taskfile" type="submit" value="upload">
				</form>
		</fieldset>
	</div>

	<div class="div3">
		<fieldset class="box4">
			<legend>Ask Questions...</legend>
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
						echo "<script>setTimeout(\"location.href='employee_profile.php'\",2000);</script>";
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
