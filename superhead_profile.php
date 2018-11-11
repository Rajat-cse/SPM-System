<?php
include 'dbh.inc.php';
session_start();
if(isset($_SESSION['sess_user'])){
	$user=$_SESSION['sess_user'];

	mysqli_select_db($con,'profile') or die("cannot connect database !");
	$sql="SELECT * FROM superhead_profile WHERE username='$user';";
	$result=mysqli_query($con,$sql);
	$resultcheck=mysqli_num_rows($result);
	if($resultcheck)
	{
		while($rows=mysqli_fetch_assoc($result))
		{
			$mail=$rows['email'];
		}
	}
	else
	{
		echo"Query Failed!";
	}
}
else{
	echo "Unauthorized access";
	echo "<script>setTimeout(\"location.href='superhead_login.php';\",2500);<script>";
}
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="style-5.css"/>
	<title>superhead_profile</title>
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
		$sql=" SELECT * FROM profile.superhead_profile WHERE username='$user' ";
		$result=mysqli_query($con,$sql);
		$resultcheck=mysqli_num_rows($result);
		if($resultcheck){
			if($rows=mysqli_fetch_assoc($result)){
				$image=$rows['image'];
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
				<form action="superhead_logout.php" method="POST">
					<button class="logout" name="logout" onclick="logout.php"type="submit" value="">Logout</button>
				</form>
			</div>
	</div>

	<div class="div1">
		<fieldset class="box1">
			<legend>Information</legend>
			<div class="topnav">
					<a href="#Account" class="active">Account</a>
					<div id="myLink0">
						<a href="account_update.php">Update</a>
					</div>
					<a href="javascript:void(0);" class="icon" onclick="myFunction0()">
					</a>
				</div><br>
				<div class="topnav">
					<a href="#Project" class="active">Project</a>
					<div id="myLink1">
						<a href="assign_project.php">Assign Project</a>
						<a href="general_project.php">General Project</a>
						<a href="current_project.php">Current Project</a>
						<a href="finalchat/login.php">Forum</a>					
					</div>
					<a href="javascript:void(0);" class="icon" onclick="myFunction1()">
					</a>
				</div><br>
				<div class="topnav">
					<a href="#Employee" class="active">Employee</a>
					<div id="myLink2">
						<a href="superhead_general.php">General</a>
						<a href="employee_track.php">Track Progress</a>
					</div>
					<a href="javascript:void(0);" class="icon" onclick="myFunction2()">
					</a>
				</div><br>
		</fieldset>
		<fieldset class="request">
			<legend>Requests...</legend>
			
			<!--	SHOWING REQUEST	CONCEPT	-->
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
			<legend>
				Access Submissions
			</legend>
			<form action="submission.php" method="POST" enctype="multipart/form-data">
							<p>Select Submission to View: <input type="file" name="viewfile"><br/></p>
							<input type="submit" name="sview" value="Show">
					</form>
		</fieldset>
		<fieldset class="box2">
			<legend>Progress Report</legend>
			<form action="" method="POST">
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
	
					<br><input type="submit" name="submit"></input>
					
		</form>

		<!--	MAKING GRAPH CONCEPT	-->
		<?php
			if(!empty($_POST['submit']))
			{
				$project=$_POST['project'];
				echo $project;
				$sql2="SELECT * FROM work.graph WHERE prj_name = '$project';";
				$result=mysqli_query($con,$sql2);
				if($result!=False){
					if($row=mysqli_fetch_assoc($result)){
						$a=$row['analysis'];
						$d=$row['design'];
						$c=$row['coding'];
						$t=$row['testing'];
						$p=$row['deployment'];
						$m=$row['maintenance'];
		}
		
	}
				echo '<div id="chartContainer" style="height: 370px; width: 100%;"></div>
								<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>';
			}
		?>
		
	</fieldset>
</div>
	<div class="div3">
		
		<fieldset class="box4">
			<legend>
				Enter Requests...
			</legend>
				<form action="" method="POST">
					
					<textarea rows=10 cols=35 name="notesubmit" >enter your request
					</textarea>
					<input style="left:0px"type="submit" name="subnote" value="Send">

					<!--	ENTER REQUEST CONCEPT	-->
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
							echo "<script>setTimeout(\"location.href='superhead_profile.php'\",2000);</script>";
						}
						else
						{
							echo "Sending Failed!";
						}
					}
					?>
				</form>
		</fieldset>

		<form action="\webmail">
		<button class="sendemail">Email</button>
		</form>
		
		<fieldset class="box4" style="top:40px">
			<legend>Latest Notifications</legend>
			<?php
					if($con){
						mysqli_select_db($con,'work') or die('connection lost to database');
						$sql="SELECT * FROM notification ;";
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

<script>

window.onload = function () {

var chart = new CanvasJS.Chart("chartContainer", {
	animationEnabled: true,
	theme: "light2", // "light1", "light2", "dark1", "dark2"
	title:{
		text: "Overall Progress"
	},
	axisY: {
		title: "Days"
	},
	data: [{        
		type: "column",  
		showInLegend: true, 
		legendMarkerColor: "grey",
		legendText: "Days = #No. of days taken",
		dataPoints: [      
			{ y: <?php echo $a;?> , label: "Analysis" },
			{ y: <?php echo $d;?>,  label: "Design" },
			{ y: <?php echo $c;?>,  label: "Coding" },
			{ y: <?php echo $t;?>,  label: "Testing" },
			{ y: <?php echo $p;?>,  label: "Deployment" },
			{ y: <?php echo $m;?>, label: "Maintenance" },
		]
	}]
});
chart.render();

}
</script>

</html>