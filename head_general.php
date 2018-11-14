<!DOCTYPE html>
<?php
include 'dbh.inc.php';
$flag=0;
session_start();
if(!isset($_SESSION["sess_user"]))
    {  
		echo "connection fail";
        header("location:head_profile.php");  
    }
else{
 if($con){
		mysqli_select_db($con,'profile') or die("cannnot connect to db");
		$flag=1;
		$user=$_SESSION['sess_user'];
		$sql=" SELECT * FROM head_profile WHERE username='$user' ";
		$result=mysqli_query($con,$sql);
		$resultcheck=mysqli_num_rows($result);
		if($resultcheck){
			if($row=mysqli_fetch_assoc($result)){
				$name=$row['name'];
				$dob=$row['dob'];
				$mobile = $row['mobile'];
				$email = $row['email'];
				$permadd = $row['permadd'];
				$tempadd = $row['tempadd'];
				$group = $row['phase'];
				$image=$row['image'];
			}
		}
	}
	else{
		$flag=0;
		echo "Connection cannot be established";
		echo "<script>setTimeout(\"location.href = 'employee_general.php';\",2500);</script>";
	}	
?>

<html>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<head>
	<link rel="stylesheet" type="text/css" href="style-3.css">
	<title>Account</title>
	<link>
</head>
<body >


	<div class="div0">
		<fieldset class="box0">
			<legend>Personal info</legend>
			<div>
				<?php if($flag==1)echo '<img src="data:image/jpeg;base64,'.base64_encode( $image ).'"/>';?>
			</div>
			<div class="name">
				<h1>Hello, <?php echo $_SESSION['sess_user']; ?></h1>
				<p>Company_name</p>
			</div>
			<div>
			<form action="head_logout.php" method="">
				<button class="logout" name="email" value="logout">Logout</button>
			</form>
			<form action="head_profile.php" method="">
				<button style="top:-5px;left:950px"class="logout" value="logout">Back</button>
			</form>
			</div>
		</fieldset>
	</div>




	<div class="div1">
		<fieldset class="box1">
			<legend>Update Information</legend>
			<form action="general.inc.php" method="POST">
				
				<label>Name</label>
				<input class="box" type="text" name="name" placeholder="Enter New Name">
				<input type="submit" name="submit1" value="update"><br><br>


				<label>DOB</label>
				<input class="box" type="date" name="dob" placeholder="Enter New DOB">
				<input type="submit" name="submit2" value="update"><br><br>

				
				<label>E-mail</label>
				<input class="box" type="text" name="email" placeholder="Enter New E-mail">
				<input type="submit" name="submit3" value="update"><br><br>

			</form>
		</fieldset>
	</div>
	
	
	<div class="div3">
		<fieldset class="box4">
			<legend>Update Information</legend>
			<form action="general.inc.php" method="POST" enctype="multipart/form-data">
				<label>Profile Picture<label><br>
				<input type="file" name="image" placeholder="Upload Your Picture Here">
				<br><input type="submit" name="special" value="update"><br><br>

				<label>Temp. Address</label>
				<input class="textbox" type="text" name="tempadd" placeholder="Enter New Temp. Address">
				<br><input type="submit" name="submit4" value="update"><br><br>

				<label>Perm. Address</label>
				<input class="textbox" type="text" name="permadd" placeholder="Enter New Perm. Address">
				<br><input type="submit" name="submit5" value="update"><br><br>

				<label>Mobile No.</label>
				<input class="textbox" type="text" name="mobile" placeholder="Enter New Mobile No.">
				<br><input type="submit" name="submit6" value="update"><br><br>

			</form>
		</fieldset>
	</div>



	<div class="div2">
		<fieldset class="box7">
			<legend>Account Details</legend>
			<p>Name : <?php if($flag==1){echo $name;};?></p>
			<p>DOB  :<?php if($flag==1)echo $dob;?></p>
			<p>Contact Number : <?php if($flag==1)echo $mobile;?></p>
			<p>E-mail : <?php if($flag==1)echo $email;?></p>
			<p>Permanent Address :<?php if($flag==1)echo $permadd;?></p>
		</fieldset>
	</div>


</body>
</html>

<?php
}
?>