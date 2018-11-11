<!--DOCTYPE html-->
<html>
<head>
    <title>login</title>
    <link rel="stylesheet" type="text/css" href="style1.css">   
</head>
    <body>
    <div class="login-box" style="height: 500px">
    <img src="images/avatar.png" class="avatar">
        <h1>Enter your details</h1>
            <form action="phpmailer/email.php" method="POST">
            <p>UserID</p>
            <input type="text" name="user" placeholder="Enter UserID">
            <p>Personal email</p>
            <input type="text" name="mail" placeholder="Enter Email">
			   <p>Position</p>
            <input type="text" name="post" placeholder="Enter Position">
            <input type="submit" name="submit" value="Login">
            <a href="welcome.php">GO Back</a> 
            </form>  
        </div>  
    </body>
</html>


