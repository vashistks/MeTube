<?php
session_start();
include_once "function.php";

/******************************************************
*
* upload document from user
*
*******************************************************/

$username=$_SESSION['username'];
$medianame = $_POST['medianame'];
$visibility = $_POST['visibility'];
$allow_rating = $_POST['allow_rating'];
$allow_comments = $_POST['allow_comments'];


if (empty($_POST['medianame']))
{
	echo "Media name is mandatory";
}

else
{
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
					$view_count = "0";
					$likes = "0";
					$dislikes = "0";
					$insert = "insert into media values('".urlencode($_FILES["file"]["name"])."', '$username', '".$_FILES["file"]["type"]."', '$mid', '$upfile', '$date', '$medianame', '$visibility', '$allow_comments', '$allow_rating', '$view_count', '$likes', '$dislikes')";
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
}

	
	
	//You can process the error code of the $result here.
?>

<meta http-equiv="refresh" content="0;url=browse.php?result=<?php echo $result;?>">