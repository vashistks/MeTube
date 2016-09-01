<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
	session_start();
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

include_once "function.php";

if(isset($_SESSION['username']))
{	
	session_unset();
}

if(isset($_POST['submit'])) {
		if($_POST['username'] == "" || $_POST['password'] == "") {
			$login_error = "One or more fields are missing.";
		}
		else {
			$check = user_pass_check($_POST['username'],$_POST['password']); // Call functions from function.php
			if($check == 1) {
				$login_error = "User ".$_POST['username']." not found.";
			}
			elseif($check==2) {
				$login_error = "Incorrect password.";
			}
			else if($check==0){
				$_SESSION['username']=$_POST['username']; //Set the $_SESSION['username']
				header('Location: browse.php');
			}		
		}
}


 
?>
	<form method="post" action="<?php echo "login.php"; ?>">

	<table style="margin: auto; text-align: center;" width="25%">
		<tr>
			<td>Username &nbsp;<input class="form-control"  type="text" name="username"><br /></td>
		</tr>
		<tr>
			<td>Password &nbsp <input class="form-control"  type="password" name="password"><br /></td>
		</tr>
		<tr>
        
			<td><input class="btn btn-default" name="reset" type="reset" value="Reset"> &nbsp;<input class="btn btn-primary" name="submit" type="submit" value="Login"><br /></td>
		</tr>
		
		<tr><td><a class="btn btn-default" href="index.php">Back to home</a></td>
		</tr>
	</table>
	
	</form>
<br>


<?php
  if(isset($login_error))
   {  echo "<div id='passwd_result'>".$login_error."</div>";}
?>
</body>
</html>