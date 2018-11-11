<?php
	include 'dbh.inc.php';
	session_start();
	if(!isset($_SESSION['sess_user'])){
		header("Location: welcome.php");
	}
	else if($con){
		$user=$_SESSION['sess_user'];
		if(!empty($_SESSION['grp']))
		$grp=$_SESSION['grp'];
		$post=$_SESSION['post'];
		$emp="employee";
		$man="manager";
		$head="head";
		$admin="admin";
		$superhead="superhead";
		mysqli_select_db($con,'profile') or die("cannot select database");
		if(strcasecmp($post,$emp)==0){
			echo "hello employee"."<br>";
		if(isset($_POST['submit1'])||isset($_POST['submit2'])||isset($_POST['submit3'])){
				$name=$_POST['name'];
				$dob=strtotime($_POST['dob']);
				$date = date("Y-m-d",$dob);
				$dob=$date;
				$email=$_POST['email'];
				if(isset($_POST['submit1'])){
					
					if(!empty($_POST['name'])){
						$sql="UPDATE emp_profile SET name='$name' where username='$user'; ";
						if(mysqli_query($con,$sql)){
							echo "Name has been updated successfully";
							echo "<script>setTimeout(\"location.href = 'employee_general.php';\",2500);</script>";
						}
						else{
							die("Error in updating name").mysqli_error();
						}
					}
				}
			    else if(isset($_POST['submit2'])){
					if(!empty($_POST['dob'])){
						$sql="UPDATE emp_profile SET dob='$dob' where username='$user'; ";
						if(mysqli_query($con,$sql )){
							echo "DOB has been updated successfully";
							echo "<script>setTimeout(\"location.href = 'employee_general.php';\",2500);</script>";
						}
						else{
							die("Error in updating dob").mysqli_error();
						}
					}
				}
				else if(isset($_POST['submit3'])){
					if(!empty($_POST['email'])){
						$sql="UPDATE emp_profile SET email='$email' where username='$user'; ";
						if(mysqli_query($con,$sql)){
							echo "E-mail has been updated successfully";
							echo "<script>setTimeout(\"location.href = 'employee_general.php';\",2500);</script>";
						}
						else{
							die("Error in updating name").mysqli_error();
						}
					}
				}
		}
		else if(isset($_POST['submit4'])||isset($_POST['submit5'])||isset($_POST['submit6'])||isset($_POST['special'])){
			$tempadd=$_POST['tempadd'];
			$permadd=$_POST['permadd'];
			$mobile=$_POST['mobile'];
			if(isset($_POST['submit4'])){
				if(!empty($_POST['tempadd'])){
					$sql="UPDATE emp_profile SET tempadd='$tempadd' where username='$user'; ";
					if(mysqli_query($con,$sql)){
						echo "Temporary address has been updated successfully";
						echo "<script>setTimeout(\"location.href = 'employee_general.php';\",2500);</script>";
					}
					else{
							die("Error in updating name").mysqli_error();
						}
				}
			}
			else if(isset($_POST['submit5'])){
				if(!empty($_POST['permadd'])){
					$sql="UPDATE emp_profile SET permadd='$permadd' where username='$user'; ";
					if(mysqli_query($con,$sql)){
						echo "Permanent address has been updated successfully";
						echo "<script>setTimeout(\"location.href = 'employee_general.php';\",2500);</script>";
					}
					else{
							die("Error in updating name").mysqli_error();
						}
				}
			}
			else if(isset($_POST['submit6'])){
				if(!empty($_POST['mobile'])){
					$sql="UPDATE emp_profile SET mobile='$mobile' where username='$user'; ";
					if(mysqli_query($con,$sql)){
						echo "Mobile number has been updated successfully";
						echo "<script>setTimeout(\"location.href = 'employee_general.php';\",2500);</script>";
					}
					else{
							die("Error in updating name").mysqli_error();
						}
				}
			}
			else if(isset($_POST['special']) && count($_FILES)>0){
				if(!empty($_FILES['image']['tmp_name'])&& file_exists($_FILES['image']['tmp_name'])){
					$image= addslashes(file_get_contents($_FILES['image']['tmp_name']));
				$sql="UPDATE emp_profile SET image='{$image}' where username='$user'; ";
					
					if(mysqli_query($con,$sql)){
						echo "profile pic has been updated successfully";
						echo "<script>setTimeout(\"location.href = 'employee_general.php';\",2500);</script>";
					}
				}
				else{
							die("Error in updating file").mysqli_error();
						}
			}
		}
		
		

	}
	if(strcasecmp($post,$man)==0){
		echo "hello manager"."<br>";
		if(isset($_POST['submit1'])||isset($_POST['submit2'])||isset($_POST['submit3'])){
				$name=$_POST['name'];
				$dob=strtotime($_POST['dob']);
				$date = date("Y-m-d",$dob);
				$dob=$date;
				$email=$_POST['email'];
				
				if(isset($_POST['submit1'])){
					
					if(!empty($_POST['name'])){
						$sql="UPDATE manager_profile SET name='$name' where username='$user'; ";
						if(mysqli_query($con,$sql)){
							echo "Name has been updated successfully";
							echo "<script>setTimeout(\"location.href = 'manager_general.php';\",2500);</script>";
						}
						else{
							die("Error in updating name").mysqli_error();
						}
					}
				}
			    else if(isset($_POST['submit2'])){
					if(!empty($_POST['dob'])){
						$sql="UPDATE manager_profile SET dob='$dob' where username='$user'; ";
						if(mysqli_query($con,$sql )){
							echo "DOB has been updated successfully";
							echo "<script>setTimeout(\"location.href = 'manager_general.php';\",2500);</script>";
						}
						else{
							die("Error in updating dob").mysqli_error();
						}
					}
				}
				else if(isset($_POST['submit3'])){
					if(!empty($_POST['email'])){
						$sql="UPDATE manager_profile SET email='$email' where username='$user'; ";
						if(mysqli_query($con,$sql)){
							echo "E-mail has been updated successfully";
							echo "<script>setTimeout(\"location.href = 'manager_general.php';\",2500);</script>";
						}
						else{
							die("Error in updating name").mysqli_error();
						}
					}
				}
		}
		else if(isset($_POST['submit4'])||isset($_POST['submit5'])||isset($_POST['submit6'])||isset($_POST['special'])){
			$tempadd=$_POST['tempadd'];
			$permadd=$_POST['permadd'];
			$mobile=$_POST['mobile'];
			if(isset($_POST['submit4'])){
				if(!empty($_POST['tempadd'])){
					$sql="UPDATE manager_profile SET tempadd='$tempadd' where username='$user'; ";
					if(mysqli_query($con,$sql)){
						echo "Temporary address has been updated successfully";
						echo "<script>setTimeout(\"location.href = 'manager_general.php';\",2500);</script>";
					}
					else{
							die("Error in updating name").mysqli_error();
						}
				}
			}
			else if(isset($_POST['submit5'])){
				if(!empty($_POST['permadd'])){
					$sql="UPDATE manager_profile SET permadd='$permadd' where username='$user'; ";
					if(mysqli_query($con,$sql)){
						echo "Permanent address has been updated successfully";
						echo "<script>setTimeout(\"location.href = 'manager_general.php';\",2500);</script>";
					}
					else{
							die("Error in updating name").mysqli_error();
						}
				}
			}
			else if(isset($_POST['submit6'])){
				if(!empty($_POST['mobile'])){
					$sql="UPDATE manager_profile SET mobile='$mobile' where username='$user'; ";
					if(mysqli_query($con,$sql)){
						echo "Mobile number has been updated successfully";
						echo "<script>setTimeout(\"location.href = 'manager_general.php';\",2500);</script>";
					}
					else{
							die("Error in updating name").mysqli_error();
						}
				}
			}
			else if(isset($_POST['special']) && count($_FILES)>0){
				if(!empty($_FILES['image']['tmp_name'])&& file_exists($_FILES['image']['tmp_name'])){
					$image= addslashes(file_get_contents($_FILES['image']['tmp_name']));
				$sql="UPDATE manager_profile SET image='{$image}' where username='$user'; ";
					
					if(mysqli_query($con,$sql)){
						echo "profile pic has been updated successfully";
						echo "<script>setTimeout(\"location.href = 'manager_general.php';\",2500);</script>";
					}
				}
				else{
							die("Error in updating file").mysqli_error();
						}
			}
		}
		
		

	}
	
	if(strcasecmp($post,$head)==0){
		echo "hello head"."<br>";
		if(isset($_POST['submit1'])||isset($_POST['submit2'])||isset($_POST['submit3'])){
				$name=$_POST['name'];
				$dob=strtotime($_POST['dob']);
				$date = date("Y-m-d",$dob);
				$dob=$date;
				$email=$_POST['email'];
				if(isset($_POST['submit1'])){
					
					if(!empty($_POST['name'])){
						$sql="UPDATE head_profile SET name='$name' where username='$user'; ";
						if(mysqli_query($con,$sql)){
							echo "Name has been updated successfully";
							echo "<script>setTimeout(\"location.href = 'head_general.php';\",2500);</script>";
						}
						else{
							die("Error in updating name").mysqli_error();
						}
					}
				}
			    else if(isset($_POST['submit2'])){
					if(!empty($_POST['dob'])){
						$sql="UPDATE head_profile SET dob='$dob' where username='$user'; ";
						if(mysqli_query($con,$sql )){
							echo "DOB has been updated successfully";
							echo "<script>setTimeout(\"location.href = 'head_general.php';\",2500);</script>";
						}
						else{
							die("Error in updating dob").mysqli_error();
						}
					}
				}
				else if(isset($_POST['submit3'])){
					if(!empty($_POST['email'])){
						$sql="UPDATE head_profile SET email='$email' where username='$user'; ";
						if(mysqli_query($con,$sql)){
							echo "E-mail has been updated successfully";
							echo "<script>setTimeout(\"location.href = 'head_general.php';\",2500);</script>";
						}
						else{
							die("Error in updating name").mysqli_error();
						}
					}
				}
		}
		else if(isset($_POST['submit4'])||isset($_POST['submit5'])||isset($_POST['submit6'])||isset($_POST['special'])){
			$tempadd=$_POST['tempadd'];
			$permadd=$_POST['permadd'];
			$mobile=$_POST['mobile'];
			if(isset($_POST['submit4'])){
				if(!empty($_POST['tempadd'])){
					$sql="UPDATE head_profile SET tempadd='$tempadd' where username='$user'; ";
					if(mysqli_query($con,$sql)){
						echo "Temporary address has been updated successfully";
						echo "<script>setTimeout(\"location.href = 'head_general.php';\",2500);</script>";
					}
					else{
							die("Error in updating name").mysqli_error();
						}
				}
			}
			else if(isset($_POST['submit5'])){
				if(!empty($_POST['permadd'])){
					$sql="UPDATE head_profile SET permadd='$permadd' where username='$user'; ";
					if(mysqli_query($con,$sql)){
						echo "Permanent address has been updated successfully";
						echo "<script>setTimeout(\"location.href = 'head_general.php';\",2500);</script>";
					}
					else{
							die("Error in updating name").mysqli_error();
						}
				}
			}
			else if(isset($_POST['submit6'])){
				if(!empty($_POST['mobile'])){
					$sql="UPDATE head_profile SET mobile='$mobile' where username='$user'; ";
					if(mysqli_query($con,$sql)){
						echo "Mobile number has been updated successfully";
						echo "<script>setTimeout(\"location.href = 'head_general.php';\",2500);</script>";
					}
					else{
							die("Error in updating name").mysqli_error();
						}
				}
			}
			else if(isset($_POST['special']) && count($_FILES)>0){
				if(!empty($_FILES['image']['tmp_name'])&& file_exists($_FILES['image']['tmp_name'])){
					$image= addslashes(file_get_contents($_FILES['image']['tmp_name']));
				$sql="UPDATE head_profile SET image='{$image}' where username='$user'; ";
					
					if(mysqli_query($con,$sql)){
						echo "profile pic has been updated successfully";
						echo "<script>setTimeout(\"location.href = 'head_general.php';\",2500);</script>";
					}
				}
				else{
							die("Error in updating file").mysqli_error();
						}
			}
		}
		
		

	}
	
	//############################# finally for superhead ##########################
	if(strcasecmp($post,$superhead)==0){
			echo "hello SuperHead"."<br>";
		if(isset($_POST['submit1'])||isset($_POST['submit2'])||isset($_POST['submit3'])){
				$name=$_POST['name'];
				$dob=strtotime($_POST['dob']);
				$date = date("Y-m-d",$dob);
				$dob=$date;
				$email=$_POST['email'];
				if(isset($_POST['submit1'])){
					
					if(!empty($_POST['name'])){
						$sql="UPDATE superhead_profile SET name='$name' where username='$user'; ";
						if(mysqli_query($con,$sql)){
							echo "Name has been updated successfully";
							echo "<script>setTimeout(\"location.href = 'superhead_general.php';\",2500);</script>";
						}
						else{
							die("Error in updating name").mysqli_error();
						}
					}
				}
			    else if(isset($_POST['submit2'])){
					if(!empty($_POST['dob'])){
						$sql="UPDATE superhead_profile SET dob='$dob' where username='$user'; ";
						if(mysqli_query($con,$sql )){
							echo "DOB has been updated successfully";
							echo "<script>setTimeout(\"location.href = 'superhead_general.php';\",2500);</script>";
						}
						else{
							die("Error in updating dob").mysqli_error();
						}
					}
				}
				else if(isset($_POST['submit3'])){
					if(!empty($_POST['email'])){
						$sql="UPDATE superhead_profile SET email='$email' where username='$user'; ";
						if(mysqli_query($con,$sql)){
							echo "E-mail has been updated successfully";
							echo "<script>setTimeout(\"location.href = 'superhead_general.php';\",2500);</script>";
						}
						else{
							die("Error in updating name").mysqli_error();
						}
					}
				}
		}
		else if(isset($_POST['submit4'])||isset($_POST['submit5'])||isset($_POST['submit6'])||isset($_POST['special'])){
			$tempadd=$_POST['tempadd'];
			$permadd=$_POST['permadd'];
			$mobile=$_POST['mobile'];
			if(isset($_POST['submit4'])){
				if(!empty($_POST['tempadd'])){
					$sql="UPDATE superhead_profile SET tempadd='$tempadd' where username='$user'; ";
					if(mysqli_query($con,$sql)){
						echo "Temporary address has been updated successfully";
						echo "<script>setTimeout(\"location.href = 'superhead_general.php';\",2500);</script>";
					}
					else{
							die("Error in updating name").mysqli_error();
						}
				}
			}
			else if(isset($_POST['submit5'])){
				if(!empty($_POST['permadd'])){
					$sql="UPDATE superhead_profile SET permadd='$permadd' where username='$user'; ";
					if(mysqli_query($con,$sql)){
						echo "Permanent address has been updated successfully";
						echo "<script>setTimeout(\"location.href = 'superhead_general.php';\",2500);</script>";
					}
					else{
							die("Error in updating name").mysqli_error();
						}
				}
			}
			else if(isset($_POST['submit6'])){
				if(!empty($_POST['mobile'])){
					$sql="UPDATE emp_profile SET mobile='$mobile' where username='$user'; ";
					if(mysqli_query($con,$sql)){
						echo "Mobile number has been updated successfully";
						echo "<script>setTimeout(\"location.href = 'superhead_general.php';\",2500);</script>";
					}
					else{
							die("Error in updating name").mysqli_error();
						}
				}
			}
			else if(isset($_POST['special']) && count($_FILES)>0){
				if(!empty($_FILES['image']['tmp_name'])&& file_exists($_FILES['image']['tmp_name'])){
					$image= addslashes(file_get_contents($_FILES['image']['tmp_name']));
				$sql="UPDATE superhead_profile SET image='{$image}' where username='$user'; ";
					
					if(mysqli_query($con,$sql)){
						echo "profile pic has been updated successfully";
						echo "<script>setTimeout(\"location.href = 'superhead_general.php';\",2500);</script>";
					}
				}
				else{
							die("Error in updating file").mysqli_error();
						}
			}
		}
		
		

	}
	//############################# for admin #############################
	if(strcasecmp($post,$admin)==0){
			echo "Hello ADMIN"."<br>";
		if(isset($_POST['submit1'])||isset($_POST['submit2'])||isset($_POST['submit3'])){
				$name=$_POST['name'];
				$dob=strtotime($_POST['dob']);
				$date = date("Y-m-d",$dob);
				$dob=$date;
				$email=$_POST['email'];
				if(isset($_POST['submit1'])){
					
					if(!empty($_POST['name'])){
						$sql="UPDATE admin_profile SET name='$name' where username='$user'; ";
						if(mysqli_query($con,$sql)){
							echo "Name has been updated successfully";
							echo "<script>setTimeout(\"location.href = 'admin_general.php';\",2500);</script>";
						}
						else{
							die("Error in updating name").mysqli_error();
						}
					}
				}
			    else if(isset($_POST['submit2'])){
					if(!empty($_POST['dob'])){
						$sql="UPDATE admin_profile SET dob='$dob' where username='$user'; ";
						if(mysqli_query($con,$sql )){
							echo "DOB has been updated successfully";
							echo "<script>setTimeout(\"location.href = 'admin_general.php';\",2500);</script>";
						}
						else{
							die("Error in updating dob").mysqli_error();
						}
					}
				}
				else if(isset($_POST['submit3'])){
					if(!empty($_POST['email'])){
						$sql="UPDATE admin_profile SET email='$email' where username='$user'; ";
						if(mysqli_query($con,$sql)){
							echo "E-mail has been updated successfully";
							echo "<script>setTimeout(\"location.href = 'admin_general.php';\",2500);</script>";
						}
						else{
							die("Error in updating name").mysqli_error();
						}
					}
				}
		}
		else if(isset($_POST['submit4'])||isset($_POST['submit5'])||isset($_POST['submit6'])||isset($_POST['special'])){
			$tempadd=$_POST['tempadd'];
			$permadd=$_POST['permadd'];
			$mobile=$_POST['mobile'];
			if(isset($_POST['submit4'])){
				if(!empty($_POST['tempadd'])){
					$sql="UPDATE admin_profile SET tempadd='$tempadd' where username='$user'; ";
					if(mysqli_query($con,$sql)){
						echo "Temporary address has been updated successfully";
						echo "<script>setTimeout(\"location.href = 'admin_general.php';\",2500);</script>";
					}
					else{
							die("Error in updating name").mysqli_error();
						}
				}
			}
			else if(isset($_POST['submit5'])){
				if(!empty($_POST['permadd'])){
					$sql="UPDATE admin_profile SET permadd='$permadd' where username='$user'; ";
					if(mysqli_query($con,$sql)){
						echo "Permanent address has been updated successfully";
						echo "<script>setTimeout(\"location.href = 'admin_general.php';\",2500);</script>";
					}
					else{
							die("Error in updating name").mysqli_error();
						}
				}
			}
			else if(isset($_POST['submit6'])){
				if(!empty($_POST['mobile'])){
					$sql="UPDATE emp_profile SET mobile='$mobile' where username='$user'; ";
					if(mysqli_query($con,$sql)){
						echo "Mobile number has been updated successfully";
						echo "<script>setTimeout(\"location.href = 'admin_general.php';\",2500);</script>";
					}
					else{
							die("Error in updating name").mysqli_error();
						}
				}
			}
			else if(isset($_POST['special']) && count($_FILES)>0){
				if(!empty($_FILES['image']['tmp_name'])&& file_exists($_FILES['image']['tmp_name'])){
					$image= addslashes(file_get_contents($_FILES['image']['tmp_name']));
				$sql="UPDATE admin_profile SET image='{$image}' where username='$user'; ";
					
					if(mysqli_query($con,$sql)){
						echo "profile pic has been updated successfully";
						echo "<script>setTimeout(\"location.href = 'admin_general.php';\",2500);</script>";
					}
				}
				else{
							echo "Error in updating file,too large file ";
							echo "<script>setTimeout(\"location.href = 'admin_general.php';\",2500);</script>";
						}
			}
		}
		
		

	}
	
	}
	
	else{
		echo "Connection cannot be established";
		echo "<script>setTimeout(\"location.href = 'welcome.php';\",2500);</script>";
	}
?>