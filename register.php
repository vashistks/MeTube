<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php

	include_once "function.php";
?>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>MeTube Sign In</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/simple-sidebar.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
<script type="text/javascript">
function saveDownload(id)
{
	$.post("media_download_process.php",
	{
       id: id,
	},
	function(message) 
    { }
 	);
} 
</script>
</head>
<body>
<div>
<p style="text-align: center;"><img src="metube.png" height="110" width="250"/> </p>
</div>
<?php
session_start();

include_once "function.php";

if(isset($_POST['submit'])) 
{
	if ($_POST['username'] == "")
	{
		echo "Username is a mandatory field";
	}
	else if($_POST['fname'] == "")
	{
		echo "First Name is a mandatory field";
	}
	else if($_POST['lname'] == "")
	{
		echo "Last Name is a mandatory field";
	}
	else if($_POST['email'] == "")
	{
		echo "Email ID is a mandatory field";
	}
	else if( $_POST['passowrd1'] != $_POST['passowrd2']) 
	{
		echo "Passwords don't match. Try again?";
	}
	else 
	{
		$check = user_exist_check($_POST['username'], $_POST['passowrd1'], $_POST['fname'], $_POST['lname'], $_POST['email']);	
		if($check == 1)
		{
			//echo "Register success";
			$_SESSION['username']=$_POST['username'];
			header('Location: browse.php');
		}
		else if($check == 2)
		{
			$register_error = "Username already exists. Please user a different username.";
		}
		else if($check == 3)
		{
			$register_error = "Email already exists. Please user a different email ID.";
		}
	}
}

?>
<form action="register.php" method="post">
	<table style="margin: auto; text-align: center;" width="35%">
	<tr><td>Username:</td> <td><input class="form-control" type="text" name="username"></td></tr>
	<tr><td>First Name: </td><td><input class="form-control" type="text" name="fname"></td></tr>
	<tr><td>Last Name: </td><td><input class="form-control" type="text" name="lname"></td></tr>
	<tr><td>Email: </td><td><input class="form-control" type="email" name="email"></td></tr>
	<tr><td>Create Password: </td><td><input class="form-control" type="password" name="passowrd1"></td></tr>
	<tr><td>Repeat password: </td><td><input class="form-control" type="password" name="passowrd2"></td></tr>
	<tr><td><a href="login.php">Login</a></td><td><input name="submit" class="btn btn-primary" type="submit" value="Submit"></td></tr>
	</table>
</form>

<?php
  if(isset($register_error))
   {  echo "<div id='passwd_result'> register_error:".$register_error."</div>";}
?>

</body>
</html>