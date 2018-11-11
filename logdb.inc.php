<?php
include 'dbh.inc.php';  
  if($con){
	mysqli_select_db($con,'user_registration') or die("cannot select db");  
	$group=strtoupper($_POST['grp']);
	$post=$_POST['position'];
	$user=$_POST['user'];
	$pass=md5($_POST['pass']);
	$email=$_POST['email'];
	$emp='employee';
	$man='manager';
	$head='head';
	$super='superhead';
	echo $post.$group;
	$flag=0;
    if(strcasecmp($post,$emp)==0){	
		$sqltest="SELECT username FROM emp_login where emp_login.username='$user';";
		$sql="INSERT INTO emp_login (phase,username,password,personal_email) values ('$group','$user','$pass','$email');";
		$flag=1;
	}
	else if(strcasecmp($post,$man)==0){
		$sqltest="SELECT username FROM manager_login where manager_login.username='$user';";
		$sql="INSERT INTO manager_login (phase,username,password,personal_email) values ('$group','$user','$pass','$email');";
		$flag=1;
	}
	else if(strcasecmp($post,$head)==0){
		$sqltest="SELECT username FROM head_login where head_login.username='$user';";
		$sql="INSERT INTO head_login (phase,username,password,personal_email) values ('$group','$user','$pass','$email');";
		$flag=1;
	}
	else{
		echo "Enter correct post"."<br>"."Taking you back to profile page";
        echo "<script>setTimeout(\"location.href = 'admin_profile.php';\",2500);</script>";
	}
	if($flag==1){
		
	$result=mysqli_query($con,$sqltest);
	$resultcheck=mysqli_num_rows($result);
	if($resultcheck!=0){
		echo "username already exist"."<br>"."Taking you back to profile page";
        echo "<script>setTimeout(\"location.href = 'admin_profile.php';\",2500);</script>";		
	}
	
	else{
		if(isset($_POST['submit'])){
			if(mysqli_query($con,$sql)){
				header("Location: admin_profile.php?registration=SUCCESS");
		}
		else{
			   header("Location: admin_profile.php?registration=TRYAGAIN");
		}
	}
   }
  }
  }  
  else{
		echo "unable to connect to db"."<br>"."Taking you back to profile page";
		echo "<script>setTimeout(\"location.href = 'admin_profile.php';\",2500);</script>";
		die(mysqli_error($con));
	}