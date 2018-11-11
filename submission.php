<?php
				include 'dbh.inc.php';
				session_start();
				$user=$_SESSION['sess_user'];
				$post=$_SESSION['post'];
				$emp="employee";
				$man="manager";
				$head="head";
				$super="superhead";
				//submission code starts here
				if($con && strcasecmp($post,$emp)==0)
				{
					 if(!empty($_POST['taskfile'])){
						 //@@@@@@@@@@@@@@@@@@@@@@@@@@@@ ---------------------- @@@@@@@@@@@@@@@ file in localhost
							define ('MAX_FILE_SIZE', 1000000);
							$permitted = array('image/gif', 'image/jpeg', 'image/png', 'image/pjpeg', 'text/plain', 'application/pdf'); 
							$error = true;
							$filetype = "";

							foreach( $permitted as $key => $value )
							{
								if( $_FILES['file']['type'] == $value ) 
									{   
										
										$error = false; 
										$filetype = explode("/",$_FILES['file']['type']); 
										$filetype = $filetype[0]; 
									}
							}

							if  ($_FILES['file']['size'] > 0 && $_FILES['file']['size'] <= MAX_FILE_SIZE) 
							{
								if( $error == false )
									{
										move_uploaded_file($_FILES["file"]["tmp_name"], "manager/" . $_FILES["file"]["name"]);
										//#################### here remaining data to feed to database ################ 
												//mysqli_select_db($con,'task') or die('Unable to display Data');
												$task1=$_POST['task_id'];
												//echo $task1;
												$sql="SELECT * FROM task.assigned_task WHERE emp_name = '$user' AND task_id = '$task1';";
												
												$result=mysqli_query($con,$sql);
												if($result!=False){
													
													$row=mysqli_fetch_array($result);
													$emp_id=$row['emp_name'];
													$man=$row['manager_name'];
													$tas=$row['task_id'];
													$status=strtoupper("yes");
													$sql1="INSERT INTO task.report (emp_id,man_id,task_id,status)values('$emp_id','$man','$tas','$status');";
													//echo "Rahul";
													if($result1=mysqli_query($con,$sql1)){
														//echo "Rahul123";
														echo "Success"."<br>";
														echo "Success"."<br>";
													}
												}
										if( $filetype == "image" )
											{
												echo '<img src="manager/'.$_FILES["file"]["name"].'">';
												echo "<script>setTimeout(\"location.href='employee_profile.php'\",2500);</script>";
											}
										elseif($filetype == "text") 
											{
												echo nl2br( file_get_contents("manager/".$_FILES["file"]["name"]) );
												echo "<script>setTimeout(\"location.href='employee_profile.php'\",2500);</script>";
											}
										else{
											
											$myname=$_FILES["file"]["name"];
											$path="manager/".$myname;
											header("Content-type: application/pdf");
											header("Content-Disposition: inline; filename='$myname'");
											@readfile($path);
											echo "<script>setTimeout(\"location.href='employee_profile.php'\",2500);</script>";
										}	
										

									}
								else
									{
										echo "Not permitted filetype.";
									}
							}
							else{
								echo "Please select the file first";
								echo "<script>setTimeout(\"location.href='employee_profile.php'\",2500);</script>";
							}
						
						 
						 
					
					 }
				else{
								echo "Unautorized access";
								echo "<script>setTimeout(\"location.href='welcome.php'\",2500);</script>";
							}
				}
				//for manager @@@@@@@@@@@@@@@@@@@@@@@@@@ ########################
				else if($con && strcasecmp($post,$man)==0){
					
					if(!empty($_POST['sview'])){
						 //@@@@@@@@@@@@@@@@@@@@@@@@@@@@ ---------------------- @@@@@@@@@@@@@@@ file in localhost
							define ('MAX_FILE_SIZE', 1000000);
							$permitted = array('image/gif', 'image/jpeg', 'image/png', 'image/pjpeg', 'text/plain', 'application/pdf'); 
							$error = true;
							$filetype = "";
							foreach( $permitted as $key => $value )
							{   
							    //echo "test";
								if( $_FILES['viewfile']['type'] == $value ) 
									{   
										
										$error = false; 
										$filetype = explode("/",$_FILES['viewfile']['type']); 
										$filetype = $filetype[0]; 
									}
							}

							if  ($_FILES['viewfile']['size'] > 0 && $_FILES['viewfile']['size'] <= MAX_FILE_SIZE) 
							{
								if( $error == false )
									{
										//move_uploaded_file($_FILES["viewfile"]["tmp_name"], "manager/" . $_FILES["viewfile"]["name"]);
										if( $filetype == "image" )
											{
												echo '<img src="manager/'.$_FILES["viewfile"]["name"].'">';
												//echo "<script>setTimeout(\"location.href='manager_profile.php'\",2500);</script>";
											}
										elseif($filetype == "text") 
											{
												echo nl2br( file_get_contents("manager/".$_FILES["viewfile"]["name"]) );
												//echo "<script>setTimeout(\"location.href='manager_profile.php'\",2500);</script>";
											}
										else{
											
											$myname=$_FILES["viewfile"]["name"];
											$path="manager/".$myname;
											header("Content-type: application/pdf");
											header("Content-Disposition: inline; filename='$myname'");
											@readfile($path);
											//echo "<script>setTimeout(\"location.href='manager_profile.php'\",2500);</script>";
										}	
										

									}
								else
									{
										echo "Not permitted filetype.";
									}
							}
							else{
								echo "Please select the file first";
								echo "<script>setTimeout(\"location.href='manager_profile.php'\",2500);</script>";
							}
					
					
					}
					else if(!empty($_POST['ssub'])){
						
						 //@@@@@@@@@@@@@@@@@@@@@@@@@@@@ ---------------------- @@@@@@@@@@@@@@@ file in localhost
							define ('MAX_FILE_SIZE', 1000000);
							$permitted = array('image/gif', 'image/jpeg', 'image/png', 'image/pjpeg', 'text/plain', 'application/pdf'); 
							$error = true;
							$filetype = "";
							foreach( $permitted as $key => $value )
							{   
							    //echo "test";
								if( $_FILES['submitfile']['type'] == $value ) 
									{   
										
										$error = false; 
										$filetype = explode("/",$_FILES['submitfile']['type']); 
										$filetype = $filetype[0]; 
									}
							}

							if  ($_FILES['submitfile']['size'] > 0 && $_FILES['submitfile']['size'] <= MAX_FILE_SIZE) 
							{
								if( $error == false )
									{
										move_uploaded_file($_FILES["submitfile"]["tmp_name"], "head/" . $_FILES["submitfile"]["name"]);
										if( $filetype == "image" )
											{
												echo '<img src="head/'.$_FILES["submitfile"]["name"].'">';
												echo "<script>setTimeout(\"location.href='manager_profile.php'\",2500);</script>";
											}
										elseif($filetype == "text") 
											{
												echo nl2br( file_get_contents("head/".$_FILES["submitfile"]["name"]) );
												echo "<script>setTimeout(\"location.href='manager_profile.php'\",2500);</script>";
											}
										else{
											echo "<script>setTimeout(\"location.href='manager_profile.php'\",2500);</script>";
											$myname=$_FILES["submitfile"]["name"];
											$path="head/".$myname;
											header("Content-type: application/pdf");
											header("Content-Disposition: inline; filename='$myname'");
											@readfile($path);
											
										}	
										

									}
								else
									{
										echo "Not permitted filetype.";
									}
							}
							else{
								echo "Please select the file first";
								echo "<script>setTimeout(\"location.href='manager_profile.php'\",2500);</script>";
							}
					
					
					}
				}
				
				//for head ###################@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
				
				else if($con && strcasecmp($post,$head)==0){
					
					if(!empty($_POST['sview'])){
						 //@@@@@@@@@@@@@@@@@@@@@@@@@@@@ ---------------------- @@@@@@@@@@@@@@@ file in localhost
							define ('MAX_FILE_SIZE', 1000000);
							$permitted = array('image/gif', 'image/jpeg', 'image/png', 'image/pjpeg', 'text/plain', 'application/pdf'); 
							$error = true;
							$filetype = "";
							foreach( $permitted as $key => $value )
							{   
							    //echo "test";
								if( $_FILES['viewfile']['type'] == $value ) 
									{   
										
										$error = false; 
										$filetype = explode("/",$_FILES['viewfile']['type']); 
										$filetype = $filetype[0]; 
									}
							}

							if  ($_FILES['viewfile']['size'] > 0 && $_FILES['viewfile']['size'] <= MAX_FILE_SIZE) 
							{
								if( $error == false )
									{
										//move_uploaded_file($_FILES["viewfile"]["tmp_name"], "head/" . $_FILES["viewfile"]["name"]);
										if( $filetype == "image" )
											{
												echo '<img src="head/'.$_FILES["viewfile"]["name"].'">';
												//echo "<script>setTimeout(\"location.href='manager_profile.php'\",2500);</script>";
											}
										elseif($filetype == "text") 
											{
												echo nl2br( file_get_contents("head/".$_FILES["viewfile"]["name"]) );
												//echo "<script>setTimeout(\"location.href='head_profile.php'\",2500);</script>";
											}
										else{
											
											$myname=$_FILES["viewfile"]["name"];
											$path="head/".$myname;
											header("Content-type: application/pdf");
											header("Content-Disposition: inline; filename='$myname'");
											@readfile($path);
											//echo "<script>setTimeout(\"location.href='head_profile.php'\",2500);</script>";
										}	
										

									}
								else
									{
										echo "Not permitted filetype.";
									}
							}
							else{
								echo "Please select the file first";
								echo "<script>setTimeout(\"location.href='head_profile.php'\",2500);</script>";
							}
					
					
					}
					else if(!empty($_POST['ssub'])){
						
						 //@@@@@@@@@@@@@@@@@@@@@@@@@@@@ ---------------------- @@@@@@@@@@@@@@@ file in localhost
							define ('MAX_FILE_SIZE', 1000000);
							$permitted = array('image/gif', 'image/jpeg', 'image/png', 'image/pjpeg', 'text/plain', 'application/pdf'); 
							$error = true;
							$filetype = "";
							foreach( $permitted as $key => $value )
							{   
							    //echo "test";
								if( $_FILES['submitfile']['type'] == $value ) 
									{   
										
										$error = false; 
										$filetype = explode("/",$_FILES['submitfile']['type']); 
										$filetype = $filetype[0]; 
									}
							}

							if  ($_FILES['submitfile']['size'] > 0 && $_FILES['submitfile']['size'] <= MAX_FILE_SIZE) 
							{
								if( $error == false )
									{
										move_uploaded_file($_FILES["submitfile"]["tmp_name"], "superhead/" . $_FILES["submitfile"]["name"]);
										$project=$_POST['project'];
										$sql1="SELECT * FROM work.graph WHERE prj_name='$project';";
										$result1=mysqli_query($con,$sql1);
										if($result1!=False){
											if($row=mysqli_fetch_array($result1)){
												$a=$row['analysis']+1;
												$d=$row['design']+1;
												$c=$row['coding']+1;
												$t=$row['testing']+1;
												$p=$row['deployment']+1;
												$m=$row['maintenance']+1;
												$phase=$_SESSION['grp'];
												$phase=strtolower($phase);
												
												switch($phase){
													case "analysis" :$sql1="UPDATE work.graph SET analysis='$a' WHERE prj_name='$project';";
																	 $result1=mysqli_query($con,$sql1);
																	 if($result1!=False){
																		echo "Done";
																		break;
																	 }
																	 else{
																		 die('Cannot done at this time').mysqli_error();
																		 break;
																	 }
																	
													case "design" :$sql1="UPDATE work.graph SET design='$d' WHERE prj_name='$project';";
																	 $result1=mysqli_query($con,$sql1);
																	 if($result1!=False){
																		echo "Done";
																		break;
																	 }
																	 else{
																		 die('Cannot done at this time').mysqli_error();
																		 break;
																	 }
																	 
													case "coding" :$sql1="UPDATE work.graph SET coding='$c' WHERE prj_name='$project';";
																	 $result1=mysqli_query($con,$sql1);
																	 //echo $project."  --- ".$c;
																	 if($result1){
																		echo "Done";
																		break;
																	 }
																	 else{
																		 die('Cannot done at this time').mysqli_error();
																		 break;
																	 }		
													case "testing" :$sql1="UPDATE work.graph SET testing='$t' WHERE prj_name='$project';";
																	 $result1=mysqli_query($con,$sql1);
																	 if($result1!=False){
																		echo "Done";
																		break;
																	 }
																	 else{
																		 die('Cannot done at this time').mysqli_error();
																		 break;
																	 }
													case "deployment" :$sql1="UPDATE work.graph SET deployement='$p' WHERE prj_name='$project';";
																	   $result1=mysqli_query($con,$sql1);
																	   if($result1!=False){
																		 echo "Done";
																		 break;
																	    }
																		else{
																		  die('Cannot done at this time').mysqli_error();
																		  break;
																		}
													case "maintenace" :$sql1="UPDATE work.graph SET maintenance='$m' WHERE prj_name='$project';";
																	 $result1=mysqli_query($con,$sql1);
																	 if($result1!=False){
																		echo "Done";
																		break;
																	 }
																	 else{
																		 die('Cannot done at this time').mysqli_error();
																		 break;
																	 }
												}
												
											}
										}
										if( $filetype == "image" )
											{
												echo '<img src="head/'.$_FILES["submitfile"]["name"].'">';
												echo "<script>setTimeout(\"location.href='head_profile.php'\",2500);</script>";
											}
										elseif($filetype == "text") 
											{
												echo nl2br( file_get_contents("superhead/".$_FILES["submitfile"]["name"]) );
												echo "<script>setTimeout(\"location.href='head_profile.php'\",2500);</script>";
											}
										else{
											echo "<script>setTimeout(\"location.href='head_profile.php'\",2500);</script>";
											$myname=$_FILES["submitfile"]["name"];
											$path="superhead/".$myname;
											header("Content-type: application/pdf");
											header("Content-Disposition: inline; filename='$myname'");
											@readfile($path);
											
										}	
										

									}
								else
									{
										echo "Not permitted filetype.";
									}
							}
							else{
								echo "Please select the file first";
								echo "<script>setTimeout(\"location.href='head_profile.php'\",2500);</script>";
							}
					
					
					}
				}
				//for superhead ######################here @@@@@@@@@@@@@@@@@@@@@@@@@@@@--------------------------
				
				else if($con && strcasecmp($post,$super)==0){
					
					if(!empty($_POST['sview'])){
						 //@@@@@@@@@@@@@@@@@@@@@@@@@@@@ ---------------------- @@@@@@@@@@@@@@@ file in localhost
							define ('MAX_FILE_SIZE', 1000000);
							$permitted = array('image/gif', 'image/jpeg', 'image/png', 'image/pjpeg', 'text/plain', 'application/pdf'); 
							$error = true;
							$filetype = "";
							foreach( $permitted as $key => $value )
							{   
							    //echo "test";
								if( $_FILES['viewfile']['type'] == $value ) 
									{   
										
										$error = false; 
										$filetype = explode("/",$_FILES['viewfile']['type']); 
										$filetype = $filetype[0]; 
									}
							}

							if  ($_FILES['viewfile']['size'] > 0 && $_FILES['viewfile']['size'] <= MAX_FILE_SIZE) 
							{
								if( $error == false )
									{
										//move_uploaded_file($_FILES["viewfile"]["tmp_name"], "superhead/" . $_FILES["viewfile"]["name"]);
										if( $filetype == "image" )
											{
												echo '<img src="superhead/'.$_FILES["viewfile"]["name"].'">';
												//echo "<script>setTimeout(\"location.href='superhead_profile.php'\",2500);</script>";
											}
										elseif($filetype == "text") 
											{
												echo nl2br( file_get_contents("superhead/".$_FILES["viewfile"]["name"]) );
												//echo "<script>setTimeout(\"location.href='superhead_profile.php'\",2500);</script>";
											}
										else{
											
											$myname=$_FILES["viewfile"]["name"];
											$path="superhead/".$myname;
											header("Content-type: application/pdf");
											header("Content-Disposition: inline; filename='$myname'");
											@readfile($path);
											//echo "<script>setTimeout(\"location.href='superhead_profile.php'\",2500);</script>";
										}	
										

									}
								else
									{
										echo "Not permitted filetype.";
									}
							}
							else{
								echo "Please select the file first";
								echo "<script>setTimeout(\"location.href='superhead_profile.php'\",2500);</script>";
							}
					
					
					}
				}
				
				
				else{
								echo "Unable to connect to db ,Please contact admin";
								//echo "<script>setTimeout(\"location.href='welcome_profile.php'\",2500);</script>";
							}
				?>