<?php
include "mysqlClass.inc.php";


function user_exist_check ($username, $password, $fname, $lname, $email)
	{
	$query = "select * from login where username='$username'";
	$query_email = "select * from login where email = '$email'";
	$result = mysql_query( $query );
	$result_email = mysql_query($query_email);
	if (!$result)
	{
		die ("user_exist_check() failed. Could not query the database: <br />". mysql_error());
	}	
	else 
	{
		$row = mysql_fetch_assoc($result);
		$row_email = mysql_fetch_assoc($result_email);
		if($row == 0 & $row_email == 0)
		{
			$query = "insert into login values ('$username','$password','$fname', '$lname', '$email')";
			echo "insert query:" . $query;
			$insert = mysql_query( $query );
			if($insert)
				
				return 1;
			else
				die ("Could not insert into the database: <br />". mysql_error());		
		}
		else if ($row != 0)
		{
			return 2;
		}
		else if ($row_email != 0)
		{
			return 3;
		}
	}
}


function user_pass_check($username, $password)
{
	
	$query = "select * from login where username='$username'";
	//echo  $query;
	$result = mysql_query( $query );		
	if (!$result)
	{
	   die ("user_pass_check() failed. Could not query the database: <br />". mysql_error());
	}
	else{
		$row = mysql_fetch_row($result);
		if($row[0]=="")
			return 1; //no user name
		else if(strcmp($row[1],$password)) 
			return 2; //wrong password
		else
			return 0; //Checked.
			}	
}

function updateMediaTime($mediaid)
{
	$query = "	update  media set lastaccesstime=NOW()
   						WHERE '$mediaid' = mediaid
					";
					 // Run the query created above on the database through the connection
    $result = mysql_query( $query );
	if (!$result)
	{
	   die ("updateMediaTime() failed. Could not query the database: <br />". mysql_error());
	}
}


function upload_error($result)
{
	//view erorr description in http://us2.php.net/manual/en/features.file-upload.errors.php
	switch ($result){
	case 0:
		return 1;
	case 1:
		return "UPLOAD_ERR_INI_SIZE";
	case 2:
		return "UPLOAD_ERR_FORM_SIZE";
	case 3:
		return "UPLOAD_ERR_PARTIAL";
	case 4:
		return "UPLOAD_ERR_NO_FILE";
	case 5:
		return "File has already been uploaded";
	case 6:
		return  "Failed to move file from temporary directory";
	case 7:
		return  "Upload file failed";
	}
}

function update_username($newusername)
{	
	$user_exist_check = "select * from login where username='$newusername'";
	$username_result = mysql_query($user_exist_check);
	$username_result_row = mysql_fetch_row($username_result);
	$existusername = $username_result_row[0];
	if ($existusername==$newusername)
	{
		return 2;
	}
	else
	{	
		$current_username=$_SESSION['username'];
		$update_user = mysql_query("UPDATE login SET username='$newusername' WHERE username='$current_username'");
		$update_media = mysql_query("UPDATE media SET username='$newusername' WHERE username='$current_username'");
		$update_friends1 = mysql_query("UPDATE friends SET username='$newusername' WHERE username='$current_username'");
		$update_friends2 = mysql_query("UPDATE friends SET username='$newusername' WHERE friendname='$current_username'");
		$update_comments = mysql_query("UPDATE media_comments SET username='$newusername' WHERE username='$current_username'");
		$update_favorites = mysql_query("UPDATE media_favorites SET username='$newusername' WHERE username='$current_username'");
		if($update_user && $update_media)
		{		
			return 1;
		}
		else
		{
			die ("Could not insert into the database: <br />". mysql_error());
		}
	}	
}

function check_currpwd($password)
{
	$checkpwd = mysql_query("select * from login where username='".$_SESSION['username']."'");
	$row = mysql_fetch_row($checkpwd);
	if ($password == $row[1])
	{
		return 1;
	}
	else
	{
		return 2;
	}
}

function update_email($email)
{
	$checkemail = mysql_query("select email from login where email='$email'");
	$row_email = mysql_fetch_row($checkemail);
	if ($row_email == 0)
	{
		$update_email = mysql_query("update login set email = '$email' where username = '".$_SESSION['username']."'");
		return 1;
	}
	else
	{
		return 2;
	}
}

function update_name($fname, $lname)
{

	$update_name = mysql_query("update login set fname = '$fname', lname = '$lname' where username = '".$_SESSION['username']."'");
	return 1;
}

function check_newpwd($password1, $password2)
{
	$curr_pwd = mysql_query("select * from login where username='".$_SESSION['username']."'");
	$row = mysql_fetch_row($curr_pwd);
	if($password1 == $row[1])
	{
		return 3;	
	}
	else if($password1 != $row[1])
	{	
		if($password1 == $password2)
		{
		$update_pwd = mysql_query("update login set password='$password1' where username='".$_SESSION['username']."'");
		if($update_pwd)
			{
				return 1;
			}
		}
		else if($password1 != $password2)
		{
			return 2;
		}
	}
}

function media_upload_process($medianame, $visibility, $allow_comments, $allow_rating, $mdescription, $mtag, $category)
{
	$username=$_SESSION['username'];
	$medianame = $_POST['medianame'];
	$visibility = $_POST['visibility'];
	$mdescription = $_POST['mdescription'];
	$mtag = $_POST['mtag'];
	$allow_rating = $_POST['allow_rating'];
	$allow_comments = $_POST['allow_comments'];
	$category = $_POST['category'];
	
	//Create Directory if doesn't exist
	if(!file_exists('uploads/'))
	{
		mkdir('uploads/');
		chmod('uploads', 0755);
	}
	$dirfile = 'uploads/'.$username.'/';
	if(!file_exists($dirfile))
	mkdir($dirfile);
	chmod($dirfile, 0755);
	if($_FILES["file"]["error"] > 0 )
	{ 	
		$result=$_FILES["file"]["error"];
	} //error from 1-4
	else
	{
		$upfile = $dirfile.urlencode($_FILES["file"]["name"]);
	  
		if(file_exists($upfile))
		{
			$result="5"; //The file has been uploaded.
		}
		else
		{
			if(is_uploaded_file($_FILES["file"]["tmp_name"]))
			{
				if(!move_uploaded_file($_FILES["file"]["tmp_name"],$upfile))
				{
					$result="6"; //Failed to move file from temporary directory
				}
				else /*Successfully upload file*/
				{
					//insert into media table
					$date= date('Y-m-d H:i:s');
					$mid=$username.$date;
					$likes = "0";
					$dislikes = "0";
					$view_count = "0";
					$insert = "insert into media(filename, username, type, mediaid, path, uploaddate, medianame, visibility, allow_comments, allow_rating, view_count, likes, dislikes, description, tags, size, category)".
							  "values('". urlencode($_FILES["file"]["name"])."', '$username', '".$_FILES["file"]["type"]."', '$mid', '$upfile', '$date', '$medianame', '$visibility', '$allow_comments', '$allow_rating', '$view_count', '$likes', '$dislikes', '$mdescription', '$mtag' , '".$_FILES["file"]["size"]."', '$category')";
					$queryresult = mysql_query($insert)
						  or die("Insert into Media error in media_upload_process.php " .mysql_error());
					$result="0";
					chmod($upfile, 0644);
				}
			}
			else  
			{
				$result="7"; //upload file failed
			}
		}
	}
?>

<meta http-equiv="refresh" content="0;url=browse.php?result=<?php echo $result;?>">

<?php

}

	

function other()
{
	//You can write your own functions here.
}
	
?>