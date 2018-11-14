<?php 
	include'dbh.inc.php';
    session_start();  
    if(!isset($_SESSION["sess_user"]))
    {  
        header("location:admin_login.php");  
    } 
    else 
    {
	?>

	<!DOCTYPE html>
	<html>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<head>
		<link rel="stylesheet" type="text/css" href="style-1.css">
		<link rel="stylesheet" type="text/css" href="style-2.css">
		<title>Admin profile</title>
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
		$sql=" SELECT * FROM profile.admin_profile WHERE username='$user' ";
		$result=mysqli_query($con,$sql);
		$resultcheck=mysqli_num_rows($result);
		if($resultcheck){
			if($rows=mysqli_fetch_assoc($result)){
				$image=$rows['image'];
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
					<p>XYZ Co. Ltd.</p>
				</div>
				<div>
					<form action="admin_logout.php" method="POST">
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
					    <a href="current_project.php">Current</a>
					    <a href="finalchat/login.php">Forum</a>
					</div>
					<a href="javascript:void(0);" class="icon" onclick="myFunction0()">
					</a>
				</div><br>
				<div class="topnav">
					<a href="#home" class="active">Emp. Details</a>
					<div id="myLink2">
						<a href="admin_general.php">General</a>
					</div>
					<a href="javascript:void(0);" class="icon" onclick="myFunction2()">
					</a>
				</div>
			</fieldset>
		
		<fieldset class="request">
			<legend>Requests...</legend>
			<?php
				mysqli_select_db($con,'task') or die("Cannot select db");
				$sql="SELECT * FROM request ;";
				$result=mysqli_query($con,$sql);
				$resultcheck=mysqli_num_rows($result);
				if($resultcheck)
				{
					while($rows=mysqli_fetch_assoc($result))
					{
						echo $rows['req_id']." -- ";
						echo $rows['request'];
						echo"<br>";
					}
				}
			?>
			<div style="top:180px;left:-15px;position:relative">
				<form action="" method="POST">
			   		Delete Request By Number:<input type="number" name="nonod">
					   <input  type="submit" name="subnote" value="delete">
					
					<?php
						   
					   if(!empty($_POST['subnote']))
						{
							$noti=$_POST['nonod'];
								mysqli_select_db($con,'task') or die("cannot connect to database");
								$sql="DELETE  FROM request WHERE req_id='$noti';";
								$sql1="SELECT * FROM request WHERE req_id='$noti';";
								$result=mysqli_query($con,$sql1);
								if(mysqli_num_rows($result)==0){
									header( "refresh:1;url=admin_profile.php?No such Request" );
								}else{
									$result=mysqli_query($con,$sql);
									header( "refresh:1;url=admin_profile.php?Success" );
								}
								
							
							}
							
								
				?>
				   
				</form>
			</div>
			</fieldset>
		</div>
		
		

		<div class="div2">
			<fieldset class="box2">
				<legend>New Account</legend>
				<form  action="javascript:void(0);" method="POST">
					
					<button class="sendemail"  style="top:25px ;left:235px" onclick="myFunction1()">Add New Member</button>
				
				</form>

					<div id="myLink1" class="login-box">
			    	
				    	<img src="images/avatar.png" class="avatar">
				        <h1 style="text-align: center;">Register Here</h1>

			            <form action="logdb.inc.php" method="POST">

				            <p>Username</p>
				            <input type="text" name="user" placeholder="Enter Username">
				            
				            <p>Password</p>
				            <input type="password" name="pass" placeholder="Enter Password">

				            <p>Group</p>
							    <select name='grp'>
								<option value='Analysis' >Analysis</option>
								<option value='Design'>Design</option>
								<option value='Coding'>Coding</option>
								<option value='Testing'>Testing</option>
								<option value='Deployment'>Deployment</option>
								<option value='Maintenance'>Maintenance</option>
								</select>
								
							<p>Position</p>
				            <select name='position'>
								<option value='employee' >employee</option>
								<option value='head'>head</option>
								<option value='manager'>manager</option>
								</select>
								<p>Email</p>
				            <input type="text" name="email" placeholder="Enter Personal Email">
							
			            	<input type="submit" name="submit" value="Register">

		            	</form>
		        	</div>
			</fieldset>
		</div>


		<div class="div3">
			
			<fieldset class="box4">
				<legend>Latest Notifications...</legend>
				<?php
				    include 'dbh.inc.php';
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

			<form  action="\webmail/index.php" method="POST">
				<button  class="sendemail"  style="top:25px"name="email" type="" value="">Send Email</button>
			</form>
			
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
	<?php
	}
	?>
