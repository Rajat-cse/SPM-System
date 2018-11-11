<?php   
	include 'dbh.inc.php';
    session_start();  
    if(isset($_SESSION["sess_user"]))
    {   
        mysqli_select_db($con,'profile') or die("cannnot connect to db");  
    } 
	else{
		echo "Connection cannot be established";
		echo "<script>setTimeout(\"location.href = 'welcome.php';\",2500);</script>";
	}	
	?>


<!--DOCTYPE html-->
<html>

<head>
<title>account update</title>
</head>

<body>
<div>
<fieldset><legend>Account</legend>
<p>Hello, <?php 
		if($con){
		$user=$_SESSION['sess_user'];
		$sql=" SELECT * FROM emp_profile WHERE username='$user' ";
		$result=mysqli_query($con,$sql);
		$resultcheck=mysqli_num_rows($result);
		if($resultcheck){
			if($row=mysqli_fetch_assoc($result)){
				if($user!=$row['username'])$user=$row['username'];
			}
		}
		}
		echo $user;
		?>
</p>

<form method="POST">
change username : <input type="text" name="user" ></input><input type="submit" name="update_username"></input>
</form>
<form method="POST">
change password : <input type="password" name="pass" ></input>
confirm password : <input type="password" name="cpass" ></input>
<input type="submit" name="update_password"></input>
</form>
</fieldset>
</div>
</body>
</html>

<?php
$emp="employee";
$man="manager";
$head="head";
$superhead="superhead";
$admin="admin";
$username=$_SESSION['sess_user'];
if($_SESSION['post']===$emp){
	if($con)
    {
		if(isset($_POST['update_username'])){
				//echo "yes set";
		$user=$_POST['user'];
        mysqli_select_db($con,'user_registration') or die("cannnot connect to db");  
		$sql="SELECT username FROM emp_login WHERE emp_login.username='$user';";
		$result=mysqli_query($con,$sql);
		if(!$resultcheck=mysqli_num_rows($result)){
		$sql="UPDATE emp_login SET username='$user' where emp_login.username='$username';";
		if($result=mysqli_query($con,$sql)){
			mysqli_select_db($con,'profile') or die("cannnot connect to db");
			$sql="UPDATE emp_profile SET username='$user' where emp_profile.username='$username';";
			if($result=mysqli_query($con,$sql)){
			$_SESSION['sess_user']=$user;
			$username=$_SESSION['sess_user'];
			echo "Username updated successfully"."<br>";
			echo "<script>setTimeout(\"location.href='account_update.php';\",2500);</script>";
			}
		}
		
		
		}
		else{
			echo "Username already exist,Try another one";
		}
		}
		
		else if(isset($_POST['update_password'])){
		mysqli_select_db($con,'user_registration') or die("cannnot connect to db");
		$pass=md5($_POST['pass']);
		$pass1=md5($_POST['cpass']);
		if(strcasecmp($pass,$pass1)==0){
		$username=$_SESSION['sess_user'];  
		$sql="UPDATE emp_login SET password='$pass' where emp_login.username='$username';";
		if($result=mysqli_query($con,$sql)){
			echo "Password updated successfully"."<br>";
			echo "<script>setTimeout(\"location.href='account_update.php';\",2500);</script>";
		}
		else {
			echo "Unable to process your request at this moment";
			echo "<script>setTimeout(\"location.href='account_update.php';\",2500);</script>";
		}
		}else {echo "Please ensure both password and confirm password match";}
		}
	}	
	else{
		echo "Connection cannot be established";
		echo "<script>setTimeout(\"location.href = 'welcome.php';\",2500);</script>";
	}
}
//######################for manager#############################

if($_SESSION['post']===$man){
	if($con)
    {
		if(isset($_POST['update_username'])){
				//echo "yes set";
		$user=$_POST['user'];
        mysqli_select_db($con,'user_registration') or die("cannnot connect to db");  
		$sql="SELECT username FROM manager_login WHERE manager_login.username='$user';";
		$result=mysqli_query($con,$sql);
		if(!$resultcheck=mysqli_num_rows($result)){
		$sql="UPDATE manager_login SET username='$user' where manager_login.username='$username';";
		if($result=mysqli_query($con,$sql)){
			mysqli_select_db($con,'profile') or die("cannnot connect to db");
			$sql="UPDATE manager_profile SET username='$user' where manager_profile.username='$username';";
			if($result=mysqli_query($con,$sql)){
			$_SESSION['sess_user']=$user;
			$username=$_SESSION['sess_user'];
			echo "Username updated successfully"."<br>";
			echo "<script>setTimeout(\"location.href='account_update.php';\",2500);</script>";
			}
		}
		
		
		}
		else{
			echo "Username already exist,Try another one";
		}
		}
		
		else if(isset($_POST['update_password'])){
		mysqli_select_db($con,'user_registration') or die("cannnot connect to db");
		$pass=md5($_POST['pass']);
		$pass1=md5($_POST['cpass']);
		if(strcasecmp($pass,$pass1)==0){
		$username=$_SESSION['sess_user'];  
		$sql="UPDATE manager_login SET password='$pass' where manager_login.username='$username';";
		if($result=mysqli_query($con,$sql)){
			echo "Password updated successfully"."<br>";
			echo "<script>setTimeout(\"location.href='account_update.php';\",2500);</script>";
		}
		else {
			echo "Unable to process your request at this moment";
			echo "<script>setTimeout(\"location.href='account_update.php';\",2500);</script>";
		}
    }else {echo "Please ensure both password and confirm password match";}
		}
	}	
	else{
		echo "Connection cannot be established";
		echo "<script>setTimeout(\"location.href = 'welcome.php';\",2500);</script>";
	}
}

//###############################for head #################################


if($_SESSION['post']===$head){
	if($con)
    {
		if(isset($_POST['update_username'])){
				//echo "yes set";
		$user=$_POST['user'];
        mysqli_select_db($con,'user_registration') or die("cannnot connect to db");  
		$sql="SELECT username FROM head_login WHERE head_login.username='$user';";
		$result=mysqli_query($con,$sql);
		if(!$resultcheck=mysqli_num_rows($result)){
		$sql="UPDATE head_login SET username='$user' where head_login.username='$username';";
		if($result=mysqli_query($con,$sql)){
			mysqli_select_db($con,'profile') or die("cannnot connect to db");
			$sql="UPDATE head_profile SET username='$user' where head_profile.username='$username';";
			if($result=mysqli_query($con,$sql)){
			$_SESSION['sess_user']=$user;
			$username=$_SESSION['sess_user'];
			echo "Username updated successfully"."<br>";
			echo "<script>setTimeout(\"location.href='account_update.php';\",2500);</script>";
			}
		}
		
		
		}
		else{
			echo "Username already exist,Try another one";
		}
		}
		
		else if(isset($_POST['update_password'])){
		mysqli_select_db($con,'user_registration') or die("cannnot connect to db");
		$pass=md5($_POST['pass']);
		$pass1=md5($_POST['cpass']);
		if(strcasecmp($pass,$pass1)==0){
		$username=$_SESSION['sess_user'];  
		$sql="UPDATE head_login SET password='$pass' where head_login.username='$username';";
		if($result=mysqli_query($con,$sql)){
			echo "Password updated successfully"."<br>";
			echo "<script>setTimeout(\"location.href='account_update.php';\",2500);</script>";
		}
		else {
			echo "Unable to process your request at this moment";
			echo "<script>setTimeout(\"location.href='account_update.php';\",2500);</script>";
		}
    }else {echo "Please ensure both password and confirm password match";}
		}
	}	
	else{
		echo "Connection cannot be established";
		echo "<script>setTimeout(\"location.href = 'welcome.php';\",2500);</script>";
	}
}

//################ for superhead finally #################
if($_SESSION['post']===$superhead){
	if($con)
    {
		if(isset($_POST['update_username'])){
				//echo "yes set";
		$user=$_POST['user'];
        mysqli_select_db($con,'user_registration') or die("cannnot connect to db");  
		$sql="SELECT username FROM superhead_login WHERE superhead_login.username='$user';";
		$result=mysqli_query($con,$sql);
		if(!$resultcheck=mysqli_num_rows($result)){
		$sql="UPDATE superhead_login SET username='$user' where superhead_login.username='$username';";
		if($result=mysqli_query($con,$sql)){
			mysqli_select_db($con,'profile') or die("cannnot connect to db");
			$sql="UPDATE superhead_profile SET username='$user' where superhead_profile.username='$username';";
			if($result=mysqli_query($con,$sql)){
			$_SESSION['sess_user']=$user;
			$username=$_SESSION['sess_user'];
			echo "Username updated successfully"."<br>";
			echo "<script>setTimeout(\"location.href='account_update.php';\",2500);</script>";
			}
		}
		
		
		}
		else{
			echo "Username already exist,Try another one";
		}
		}
		
		else if(isset($_POST['update_password'])){
		mysqli_select_db($con,'user_registration') or die("cannnot connect to db");
		$pass=md5($_POST['pass']);
		$pass1=md5($_POST['cpass']);
		if(strcasecmp($pass,$pass1)==0){
		$username=$_SESSION['sess_user'];  
		$sql="UPDATE superhead_login SET password='$pass' where superhead_login.username='$username';";
		if($result=mysqli_query($con,$sql)){
			echo "Password updated successfully"."<br>";
			echo "<script>setTimeout(\"location.href='account_update.php';\",2500);</script>";
		}
		else {
			echo "Unable to process your request at this moment";
			echo "<script>setTimeout(\"location.href='account_update.php';\",2500);</script>";
		}
    }else {echo "Please ensure both password and confirm password match";}
		}
	}	
	else{
		echo "Connection cannot be established";
		echo "<script>setTimeout(\"location.href = 'welcome.php';\",2500);</script>";
	}
}

//############### for admin also #@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@

if($_SESSION['post']===$admin){
	if($con)
    {
		if(isset($_POST['update_username'])){
				//echo "yes set";
		$user=$_POST['user'];
        mysqli_select_db($con,'user_registration') or die("cannnot connect to db");  
		$sql="SELECT username FROM admin_login WHERE admin_login.username='$user';";
		$result=mysqli_query($con,$sql);
		if(!$resultcheck=mysqli_num_rows($result)){
		$sql="UPDATE admin_login SET username='$user' where admin_login.username='$username';";
		if($result=mysqli_query($con,$sql)){
			mysqli_select_db($con,'profile') or die("cannnot connect to db");
			$sql="UPDATE admin_profile SET username='$user' where admin_profile.username='$username';";
			if($result=mysqli_query($con,$sql)){
			$_SESSION['sess_user']=$user;
			$username=$_SESSION['sess_user'];
			echo "Username updated successfully"."<br>";
			echo "<script>setTimeout(\"location.href='account_update.php';\",2500);</script>";
			}
		}
		
		
		}
		else{
			echo "Username already exist,Try another one";
		}
		}
		
		else if(isset($_POST['update_password'])){
		mysqli_select_db($con,'user_registration') or die("cannnot connect to db");
		$pass=md5($_POST['pass']);
		$pass1=md5($_POST['cpass']);
		if(strcasecmp($pass,$pass1)==0){
		$username=$_SESSION['sess_user'];  
		$sql="UPDATE admin_login SET password='$pass' where admin_login.username='$username';";
		if($result=mysqli_query($con,$sql)){
			echo "Password updated successfully"."<br>";
			echo "<script>setTimeout(\"location.href='account_update.php';\",2500);</script>";
		}
		else {
			echo "Unable to process your request at this moment";
			echo "<script>setTimeout(\"location.href='account_update.php';\",2500);</script>";
		}
    }else {echo "Please ensure both password and confirm password match";}
		}
	}	
	else{
		echo "Connection cannot be established";
		echo "<script>setTimeout(\"location.href = 'welcome.php';\",2500);</script>";
	}
}

?>