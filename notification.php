<?php
	include 'dbh.inc.php';
	session_start();
	if($con){
		//########first for notify
		if(!empty($_POST['sub1'])){
			if(!empty($_POST['nono']) && !empty($_POST['notification'])){
				$nid=$_POST['nono'];
				$ns=$_POST['notification'];
				$date=strtotime('today');
				$date=date("Y-m-d",$date);
				mysqli_select_db($con,'work') or die('cannot connect to database');
				$sql="SELECT n_id FROM notification WHERE notification.n_id='$nid';";
				$result=mysqli_query($con,$sql);
				$resultcheck=mysqli_num_rows($result);
				if($resultcheck===0){
					$sql="SELECT notifications FROM notification WHERE notification.notifications='$ns';";
					$result=mysqli_query($con,$sql);
					$resultcheck=mysqli_num_rows($result);
					if($resultcheck===0){
						$sql="INSERT INTO notification values ('$ns','$nid','$date');";
						if($result=mysqli_query($con,$sql)){
							echo "Success, Check in notification bar, Taking you back..............";
							echo "<script>setTimeout(\"location.href='head_profile.php';\",2500);</script>";
						}
						else{
							echo "Query failed ,Please try again, With proper data input";
							echo "<script>setTimeout(\"location.href='head_profile.php';\",2500);</script>";	
						}
					}
					else{
						echo "This notification or it's number already exist";
						echo "<script>setTimeout(\"location.href='head_profile.php';\",2500);</script>";	
					}
				}
				else{
					echo "Please input differnet notifications id, Data already exist";
					echo "<script>setTimeout(\"location.href='head_profile.php';\",2500);</script>";	
				}
			}
			else{
				echo "Mention notification number and notification as well, Both fields are required";
				echo "<script>setTimeout(\"location.href='head_profile.php';\",2500);</script>";	
			}
		}
		
		//################# for sub2 ###############
		if(!empty($_POST['sub2'])){
			$nsid=$_POST['nonod'];
			mysqli_select_db($con,'work') or die('cannot connect to database');
			$sql="DELETE FROM notification WHERE notification.n_id = '$nsid';";
			$result=mysqli_query($con,$sql) or die('Sorry no such notification');
			if($result){
				echo "Notification successfully deleted, Taking you back to main page........";
				echo "<script>setTimeout(\"location.href='head_profile.php';\",2500);</script>";	
			}
			else{
				echo "Fail to delete notification, No such notification exist, Try again......";
				echo "<script>setTimeout(\"location.href='head_profile.php';\",2500);</script>";	
			}
		}
	}
	else{
		echo "Unable to connect at this moment,Taking you back to main page";
		echo "<script>setTimeout(\"Location.href='head_profile.php'\",2500);</script>";	
	}
?>