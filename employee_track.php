<!DOCTYPE html>
<?php
	session_start();
	include'dbh.inc.php';
	$user=$_SESSION['sess_user'];
	$post=$_SESSION['post'];
	$emp="employee";
	$man="manager";
	$head="head";
	$super="superhead";
	//echo $post.$user;
	if($con)
	{
		//##### employee
		if(strcasecmp($post,$emp)==0){
		mysqli_select_db($con,'profile') or die ("cannot select database");
		$sql="SELECT * FROM emp_profile WHERE username='$user';";
		$query=mysqli_query($con,$sql);
		$row=mysqli_fetch_assoc($query);
		if($query)
		{
			$sal=$row['salary'];
			$eff=$row['efforts'];
			$att=$row['attendence'];
		}
		else
		{
			echo"Query Failed!";
		}
		}
		//####### fro manager
		if(strcasecmp($post,$man)==0){
		mysqli_select_db($con,'profile') or die ("cannot select database");
		$sql="SELECT * FROM manager_profile WHERE username='$user';";
		$query=mysqli_query($con,$sql);
		$row=mysqli_fetch_assoc($query);
		if($query)
		{
			$sal=$row['salary'];
			$eff=$row['efforts'];
			$att=$row['attendence'];
		}
		else
		{
			echo"Query Failed!";
		}
		}
		//###### for head
		else if(strcasecmp($post,$head)==0){
		mysqli_select_db($con,'profile') or die ("cannot select database");
		$sql="SELECT * FROM head_profile WHERE username='$user';";
		$query=mysqli_query($con,$sql);
		$row=mysqli_fetch_assoc($query);
		if($query)
		{
			$sal=$row['salary'];
			$eff=$row['efforts'];
			$att=$row['attendence'];
		}
		else
		{
			echo"Query Failed!";
		}
		}
		//########## for superhead
		else if(strcasecmp($post,$super)==0){
			//echo "super";
		mysqli_select_db($con,'profile') or die ("cannot select database");
		$sql="SELECT * FROM superhead_profile WHERE username='$user';";
		$query=mysqli_query($con,$sql);
		$row=mysqli_fetch_assoc($query);
		if($query)
		{   
	        
			$sal=$row['salary'];
			$eff=$row['efforts'];
			$att=$row['attendence'];
		}
		else
		{
			echo"Query Failed!";
		}
		}
	}
	else
	{
		echo"Unable to reach database";
	}
?>

<html>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<head>
	<link rel="stylesheet" type="text/css" href="style.css">
	<title>track progress</title>
	<link>
</head>
<body>


	<div class="div0">
		<fieldset class="box0">
			<legend>Personal info</legend>
			<div>
				<img src="images/avatar.png">
			</div>
			<div class="name">
				<h1>Hello, <?php echo $user ?></h1>
				<p>Company_name</p>
			</div>
			<div>
				<form action="employee_logout.php" method="POST">
					<button class="logout" name="logout" onclick="logout.php"type="submit" value="">Logout</button>
				</form>
			</div>
		</fieldset>
	</div>

	<div class="div1" style="width:1200px">
		<fieldset class="box1" style="min-width:1240px;min-height:320px">
			<legend>Your Progress...</legend>
			<div id="chartContainer" style="height: 300px; width: 100%;"></div>
			<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
		</fieldset>
	</div>

</body>
<script>
	var num1=<?php echo $eff ?>;
	var num2=<?php echo $sal ?>;
	var num3=<?php echo $att ?>;

	window.onload = function () {
		
	var chart = new CanvasJS.Chart("chartContainer", {
		animationEnabled: true,
		
		title:{
			text:"Proect Progress"
		},
		axisX:{
			interval: 1
		},
		axisY2:{
			interlacedColor: "rgba(1,77,101,.2)",
			gridColor: "rgba(1,77,101,.1)",
			title: ""
		},
		data: [{
			type: "bar",
			name: "companies",
			axisYType: "secondary",
			color: "#014D65",
			dataPoints: [
				{ y: num1, label: "Efforts (in Hours)" },
				{ y: num2, label: "Salary (in Lacs)" },
				{ y: num3, label: "Attendence (in Days)" },
			]
		}]
	});
	chart.render();
	}
	
</script>

</html>