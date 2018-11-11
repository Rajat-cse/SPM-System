<?php
include 'dbh.inc.php';
session_start();
if(isset($_SESSION["sess_user"])){
	if($con){
		if(isset($_POST['submit'])){
			$flag=0;
			$flag1=0;
			$flag2=0;
			if(!empty($_POST['task']) && !empty($_POST['taskid'])){
				$task=$_POST['task'];
				$taskid=$_POST['taskid'];
			    $flag=1;
			}	
			else{
				$flag=0;
				echo "enter task first"."<br>";
				echo "<script>setTimeout(\"location.href = 'manager_profile.php';\",2500);</script>";
			}
			if(!empty($_POST['assigndate']) && !empty($_POST['finishdate'])){
				$assigndate=strtotime($_POST['assigndate']);
				$finishdate=strtotime($_POST['finishdate']);
				$flag1=1;
				if($finishdate<$assigndate){
						$flag1=0;
						echo "Please entervalid time period for finish time"."<br>";
						echo "<script>setTimeout(\"location.href = 'manager_profile.php';\",2500);</script>";
				}
				else{
					$flag1=1;
					$assigndate=date("Y-m-d",$assigndate);
					$finishdate=date("Y-m-d",$finishdate);
				}
			}
			else{
				$flag1=0;
				echo "enter valid date first"."<br>";
				echo "<script>setTimeout(\"location.href = 'manager_profile.php';\",2500);</script>";
			}
			
		   if(isset($_POST['type'])){
				$flag2=1;
				$type=$_POST['type'];
				$current="current";
				$upcoming="upcoming";
			}
		   else{
			   $flag2=0;
				echo "choose current or upcoming first"."<br>";
				echo "<script>setTimeout(\"location.href = 'manager_profile.php';\",2500);</script>";
		    }
		   $manager=$_SESSION['sess_user'];
		   $emp = $_POST['employee_name'];
		   if($flag===1 && $flag1===1 && $flag2===1){
			   if(strcasecmp($type,$current)==0){
			//mysqli_select_db($con,'task') or die("cannnot connect to db");
			$sql="INSERT INTO task.all_task (current,task_id) VALUES ('$task','$taskid');";
			if($result=mysqli_query($con,$sql)){
				//echo "hey current";
				echo "checking .....";
				$sql="INSERT INTO task.assigned_task (manager_name,emp_name,task_id,assign_date,finishdate) VALUES ('$manager','$emp','$taskid','$assigndate','$finishdate');";
				if($result=mysqli_query($con,$sql)){
					echo "please wait ....."."<br>";
					echo "Done, successfull";
					//mysqli_select_db($con,'profile') or die("cannnot connect to db");
					echo "<script>setTimeout(\"location.href = 'manager_profile.php';\",2500);</script>";
				}
				else{
				echo "Failed ,try again";
				//mysqli_select_db($con,'profile') or die("cannnot connect to db");
				echo "<script>setTimeout(\"location.href = 'manager_profile.php';\",2500);</script>";
			}
			}
			else{
				echo "task id already exist ";
			}
		}
		
		else if(strcasecmp($type,$upcoming)==0 && $flag===1 && $flag1===1 && $flag2===1){
			//mysqli_select_db($con,'task') or die("cannnot connect to db");
			$sql="INSERT INTO task.all_task (upcoming,task_id) VALUES ('$task','$taskid');";
			if($result=mysqli_query($con,$sql)){
				echo "checking .....";
				$sql="INSERT INTO task.assigned_task (manager_name,emp_name,task_id,assign_date,finishdate) VALUES ('$manager','$emp','$taskid','$assigndate','$finishdate');";
				if($result=mysqli_query($con,$sql)){
					echo "please wait ....."."<br>";
					echo "Done, successfull";
					//mysqli_select_db($con,'profile') or die("cannnot connect to db");
					echo "<script>setTimeout(\"location.href = 'manager_profile.php';\",2500);</script>";
				}
				else{
				echo "Failed ,try again";
				//mysqli_select_db($con,'profile') or die("cannnot connect to db");
				echo "<script>setTimeout(\"location.href = 'manager_profile.php';\",2500);</script>";
				//mysqli_select_db($con,'profile') or die("cannnot connect to db");
			}
			}
		}
			else{
				echo "task id already exist";
			}
		}
		
	  
	   else {
		   echo "Please select all attribute first";
		   echo "<script>setTimeout(\"location.href = 'manager_profile.php';\",2500);</script>";
	   }
	}
	else{
		echo "unable to submit";
	}
	}
	else{
		echo "Connection cannot be established";
		//echo "<script>setTimeout(\"location.href = 'manager_profile.php';\",2500);</script>";
	}
}

?>