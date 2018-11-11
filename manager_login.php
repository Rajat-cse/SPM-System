<!--DOCTYPE html-->
<html>
<head>
    <title>login</title>
    <link rel="stylesheet" type="text/css" href="style1.css">   
</head>
    <body>
    <div class="login-box" style="height: 500px">
    <img src="images/avatar.png" class="avatar">
        <h1 style="text-align:center">Login Here</h1>
            <form action="" method="POST">
            <p>UserID</p>
            <input type="text" name="user" placeholder="Enter UserID">
            <p>Password</p>
            <input type="password" name="pass" placeholder="Enter Password">
            <p>Group</p>
            <input type="text" name="grp" placeholder="Enter Group">
            <input type="submit" name="submit" value="Login">
            <a href="forgot.php" style="color:white">Forget Password</a>
            </form>
            <?php  
		    if(isset($_POST["submit"]))
		    {    
		        if(!empty($_POST['user']) && !empty($_POST['pass'])) 
		        {  
		            $user=$_POST['user'];  
		            $pass=md5($_POST['pass']);  
		            $grp=strtoupper($_POST['grp']);
					$post="manager";
		            $con=mysqli_connect('localhost','root','rahul@321') or die(mysqli_error($con));  
		            mysqli_select_db($con,'user_registration') or die("cannot select DB");  
		          
		            $query=mysqli_query($con,"SELECT * FROM manager_login WHERE username='".$user."' AND password='".$pass."' AND phase='$grp'");  
		            $numrows=mysqli_num_rows($query);
		            if($numrows!=0)  
		            {  
		                while($row=mysqli_fetch_assoc($query))  
		                {  
		                    $dbusername=$row['username'];
		                    $dbpassword=$row['password'];
		                }  
		                if($user == $dbusername && $pass == $dbpassword)  
		                {
		                    session_start();  
		                    $_SESSION['sess_user']=$user;  
		                    $_SESSION['post']=$post;  
							mysqli_select_db($con,'profile') or die("cannot select DB");
							$sql="SELECT * FROM manager_profile WHERE username='$user';";
							
							$query=mysqli_query($con,$sql);
							$row=mysqli_fetch_assoc($query);
							$attdate=$row['date'];
							$count=$row['attendence'];
							$currdate=strtotime('today');
							$currdate=date("Y-m-d",$currdate);
							$salary=$row['salary']+5;
							$hour=$row['efforts']+1;
							if(strtotime($attdate) < strtotime($currdate))
							{
								//echo"rajat";
								$sql="UPDATE manager_profile SET attendence='$count'+1,date='$currdate', salary='$salary' ,efforts='$hour' WHERE username='$user';";
								$query=mysqli_query($con,$sql);
								if($query)
								{
									$message = "Your Attendence has been marked";
									echo "<script type='text/javascript'>alert('$message');</script>";
								}
							}
									echo"<script>setTimeout(\"location.href='manager_profile.php'\",0);</script> ";
							//header("Location: employee_profile.php");  						//Redirect browser
		                }  
		            } 
		            else 
		            {  
		                echo "Invalid username or password!";  
		            }  
		          
		        }
		        else 
		        {  
		            echo "All fields are required!";  
		        }  
		    }  
		    ?>
        </div>  
    </body>
</html>
