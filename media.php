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

    <title>MeTube</title>

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

                      
<?php 
if(isset($_GET['id']))
{
?>
    <div id="wrapper">
        <!-- Sidebar -->
        <div id="sidebar-wrapper">
            <ul class="sidebar-nav">
                <li class="sidebar-brand">
                    <img src="images/logo.png" />
                    
                </li>
<?php			if(isset($_SESSION['username']))
				{
?>
                <li>
                    <a href="browse.php">Home</a>
                </li>
				<li>
                    <a href="category.php">Category search</a>
                </li>
                <li>
                    <a href="updateprofile.php" class="active">My Profile</a>
                </li>
                <li>
                    <a href="browse_friends.php">People</a>
                </li>
                <li>
                    <a href="message.php">Messages</a>
                </li>
                <li>
                    <a href="discussion.php">Discussion</a>
                </li>
                <li>
                    <a href="playlist.php">My Playlists</a>
                </li>
                <li>
                    <a href="channel.php">My Channels</a>
                </li>
				<li>
                    <a href="favourites.php">Favourites</a>
                </li>
<li>
                    <a href="login.php">logout</a>
                </li>
<?php			}
				else
				{
?>				<li>
                    <a href="index.php">Home</a>
                </li>
<li>
                    <a href="login.php">Sign In</a>
                </li>
<li>
                    <a href="register.php">Sign Up</a>
                </li>
<?php		
				}
?>
            </ul>
        </div>
        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <div id="page-content-wrapper">
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1" >
        <div class="col-lg-6">
    
     <form  method="post" action=""  id="searchform">
	<div class="input-group">	 	 
	<input type="text" class="form-control" placeholder="Search for videos, images, audio and much more..." name="searchtext"> 
             <span class="input-group-btn"> <input class="btn btn-default" type="submit" name="search_media" value="search"> </span>		
		</div>
	 </form>
	 
	 
<?php
	if(isset($_POST['search_media']))
	{
		if($_POST['searchtext'] != "")
		{
			if(isset($_SESSION['username']))
			{
?>
			<meta http-equiv="refresh" content="0;url=browse.php?q=<?php echo $_POST['searchtext']; ?>">
<?php
			}
			else
			{
?>
			<meta http-equiv="refresh" content="0;url=index.php?q=<?php echo $_POST['searchtext']; ?>">
<?php
			}
		}
	}
?>	  
    <!-- /input-group -->
  </div>
<?php		if(isset($_SESSION['username']))
			{
?>
				<ul class="nav navbar-nav" >
                    <li>
                        <a href="login.php">Logout</a>
                    </li>
                    <li>
                        <a href="media_upload.php">Upload</a>
                    </li>
                </ul>
<?php		}
			else
			{
?>				<ul class="nav navbar-nav" >
                    <li>
                        <a href="login.php">Sign In</a>
                    </li>
                    <li>
                        <a href="register.php">Sign Up</a>
                    </li>
                </ul>
<?php		}
?>
            </div>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
<table width="80%">
	<tr>
	<td>
<?php
	$query = "SELECT * FROM media WHERE mediaid='".$_GET['id']."'";
	$result = mysql_query( $query );
	$result_row = mysql_fetch_row($result);
	
	//updateMediaTime($_GET['id']);
	
	$filename=$result_row[0];   ////0, 4, 2
	$filepath=$result_row[4];
	$uploaded_by_id = $result_row[1];
	$type=substr($result_row[2],0,5);
	$views = $result_row[10];
	$likes = $result_row[11];
	$dislikes = $result_row[12];
	$allow_rating = $result_row[9];
	$description = $result_row[13];
	$rating = $result_row[16];
	$rated_by = $result_row[17];
	
	$get_uploader_name = mysql_query("select fname,lname from login where username = '$uploaded_by_id'");
	$uploader_name_row = mysql_fetch_row($get_uploader_name);
	$uploader_fname = $uploader_name_row[0];
	$uploader_lname = $uploader_name_row[1];
	
	
	//Media Type
	if($type ==  "image") //view image
	{
		?>
		<p>Viewing Image:&nbsp; <b><?php echo $result_row[6];?></b>&nbsp;<i>uploaded by</i>&nbsp;<b><?php echo $uploader_fname; ?>&nbsp;<?php echo $uploader_lname; ?></b></p>
		<p><?php echo $result_row[10];?>&nbsp;Views</p>
		<img src="<?php echo $filepath;  ?>" width="720" height="406"></img>
<?php
	}
	else //view video
	{	
?>
		
		<p>Viewing Video:&nbsp;<b><?php echo $result_row[6];?></b>&nbsp;<i>uploaded by</i>&nbsp;<b><?php echo $uploader_fname; ?>&nbsp;<?php echo $uploader_lname; ?></b></p>
		<p><?php echo $result_row[10];?>&nbsp;Views</p>
		
		
		<video width="720" height="406" controls autoplay>
		<source src="<?php echo $filepath;  ?>">
		</video>
		
		          
<?php
	}
	
?>	
	<table>
	<tr>
	<td style="padding-right: 10px;">
<?php
	//Favorites
	if(isset($_SESSION['username']))
	{
		$check_fav = mysql_query("select * from media_favorites where mediaid='".$_GET['id']."' and username='".$_SESSION['username']."'");
		

		if(mysql_num_rows($check_fav) == 0)
		{
?>
			<form action="" method="post">
				<br>
				<input name="addtofav" type="submit" class="btn btn-primary" value="Add to Favorites">
			</form>
<?php
			if(isset($_POST['addtofav']))
			{
				$add_fav = mysql_query("insert into media_favorites values('".$_SESSION['username']."','".$_GET['id']."','$type')");
?>
			<meta http-equiv="refresh" content="0;url=media.php?id=<?php echo $_GET['id'];?>">
<?php
			}
				
		}
		else
		{
?>
			<form action="" method="post">
				<br>
				<input name="removefav" type="submit" class="btn btn-primary" value="Remove from Favorites">
			</form>
<?php
			if(isset($_POST['removefav']))
			{
				$remove_fav = mysql_query("delete from media_favorites where username='".$_SESSION['username']."' and mediaid = '".$_GET['id']."'");
?>
			<meta http-equiv="refresh" content="0;url=media.php?id=<?php echo $_GET['id'];?>">
<?php
			}
		}
		
	}

?>
	</td>
	<td style="padding-right: 10px;">
<?php
	if(isset($_SESSION['username']))
	{
		$check_subscription = mysql_query("select * from channel_subscription where username='".$_SESSION['username']."' and channel_name = '$uploaded_by_id'");
		if(mysql_num_rows($check_subscription) == 0)
		{
?>
			<form action="" method="post">
				<br>
				<input name="subscribe" class="btn btn-primary" type="submit" value="Subscribe">
			</form>
<?php
			if(isset($_POST['subscribe']))
			{
				$subs = mysql_query("insert into channel_subscription values('".$_SESSION['username']."','$uploaded_by_id')");
?>
				<meta http-equiv="refresh" content="0;url=media.php?id=<?php echo $_GET['id'];?>">
<?php
			}
				
		}
		
		else
		{
?>
			<form action="" method="post">
				<br>
				<input name="unsubscribe" type="submit" class="btn btn-primary" value="Unsubscribe">
			</form>
<?php
			if(isset($_POST['unsubscribe']))
			{
				$unsubs = mysql_query("delete from channel_subscription where username='".$_SESSION['username']."' and channel_name = '$uploaded_by_id'");
?>
			<meta http-equiv="refresh" content="0;url=media.php?id=<?php echo $_GET['id'];?>">
<?php
			}
		}

		
	}
	else
	{
?>
		<p><b>Login to subscribe to this channel</b></p>
<?php
	}
?>
	</td>
	</tr>
	</table>
	<br>
	<p style="background-color:lightgrey; border-radius: 5px; padding: 5px;"><b>Description</b><br><?php echo $result_row[13]; ?><p>
<?php
	//Rating
?>	<div style="background-color:lightgrey; border-radius: 7px; padding: 5px;">
<?php
	if($allow_rating == "y" && $rated_by == "0")
	{
?>
		<p><b>Viewer Rating:</b>&nbsp;<?php echo $result_row[16]; ?>/5</p>
<?php
	}
	else if ($allow_rating == "y" && $rated_by != "0")
	{
		$rating_avg = $rating/$rated_by;
?>
		<p><b>Viewer Rating</b>&nbsp;<?php echo round($rating_avg, 1); ?>/5</p>
<?php
	}
	?>  <?php
	if(isset($_SESSION['username']) && $allow_rating == "y")
	{
?>
		<form action = "" method="post">
		<table>
		<tr>
		<td style="padding-right: 10px;">
		<b>Rate this media</b>
		</td>
		<td style="padding-right: 10px;">
		<select class="form-control" name="new_rating">
			<option value="0">0</option>
			<option value="1">1</option>
			<option value="2">2</option>
			<option value="3">3</option>
			<option value="4">4</option>`	
			<option value="5">5</option>
		</select>
		</td>
		<td style="padding-right: 10px;"><input name="rate" type="submit" class="btn btn-primary" value="Submit Rating"></td>
		</tr>
		</table>
<?php
		if(isset($_POST['rate']))
		{

				$rating_new = $rating + $_POST['new_rating'];
				$rated_by = $rated_by + 1;
				$update_rating = mysql_query("update media set rating = '$rating_new' where mediaid='".$_GET['id']."'");
				$update_rated_by = mysql_query("update media set rated_by = '$rated_by' where mediaid='".$_GET['id']."'");
?>
				<meta http-equiv="refresh" content="0;url=media.php?id=<?php echo $_GET['id'];?>">
<?php
				
		}
		
	}
	else if(isset($_SESSION['username']) && $allow_rating != "y")
	{
?>
		<p><b>The uploader has disabled ratings for this media</b></p>
<?php

	}
	else if($allow_rating == "y")
	{
?>
	<p><b>Login to rate this media.</b></p>
<?php	
	}
?>
	</div>

	<br>
	<div style="background-color:lightgrey; border-radius: 5px; padding: 5px;">
<?php
	//Playlist
	if(isset($_SESSION['username']))
	{
?>		
		<form action="" method="post">
		<p><b>New Playlist Name</b></p>	 	 
		<table><tr><td style="padding-right: 10px;"><input type="text" class="form-control" name="newplaylist"></td><td style="padding-right: 10px;">
		<input name="createplaylist" type="submit" class="btn btn-primary" value="Create New Playlist and Add Media"> </td></tr></table>
		
		</form>
<?php
		if(isset($_POST['createplaylist']))
		{
			$check_playlist_name_user = mysql_query("select * from playlist where username='".$_SESSION['username']."' and playlist_name='".$_POST['newplaylist']."' and type='$type'");
			if(mysql_num_rows($check_playlist_name_user) == 0)
			{			
						$insert_media_newplaylist = mysql_query("insert into playlist values('".$_SESSION['username']."', '".$_GET['id']."', '".$_POST['newplaylist']."', '$result_row[6]', '$type')");
?>
						<meta http-equiv="refresh" content="0;url=media.php?id=<?php echo $_GET['id'];?>">
<?php
			}
			else
			{
				echo "A playlist of this name already exists. Please enter a differnt name";
			}
		}
		$get_playlist = mysql_query("select playlist_name from playlist where username='".$_SESSION['username']."' and type='$type' group by playlist_name");
		if(mysql_num_rows($get_playlist) > 0)
		{
?>		
			<form method="post" action="">
			<p><b>Add to Existing Playlist</b></p>
			<table><tr><td style="padding-right: 10px;">
			<select class="form-control" name="playlist">
<?php
			while($get_playlist_new_row = mysql_fetch_row($get_playlist))
			{
?>
				<option value="<?php echo $get_playlist_new_row[0]; ?>"><?php echo $get_playlist_new_row[0]; ?></option>
<?php				
			}
?>
			</select><td style="padding-right: 10px;">
			<td><input type="submit" name="insertintoplaylist" class="btn btn-primary" value="Add to Existing Playlist"></td>
			</tr>
			</table>
			</form>
<?php			
			if(isset($_POST['insertintoplaylist']))
			{	
				$name = $_POST['playlist'];
				$check_media_in_selected_playlist = mysql_query("select * from playlist where username = '".$_SESSION['username']."' and mediaid='".$_GET['id']."' and playlist_name = '$name' and type='$type'");
				if(mysql_num_rows($check_media_in_selected_playlist) != 0)
				{
					echo "This media already exists in the playlist you have selected. Please select a different playlist or create a new one.";
				}
				else
				{
					$insert_media_playlist = mysql_query("insert into playlist values('".$_SESSION['username']."', '".$_GET['id']."', '$name', '$result_row[6]', '$type')");
?>
					<meta http-equiv="refresh" content="0;url=media.php?id=<?php echo $_GET['id'];?>">
<?php
				}
			}
		}
					
	}	
	else
	{
?>
		<p><b>Login to add this media to your playlist</b></p>
<?php	
	}
?>
	</div>
	<br>
	<div style="background-color:#F8F8FF; border-radius: 5px; padding: 5px;">
<?php	
	//Comments
	$allow_comment_status = $result_row[8];
	if(isset($_SESSION['username']) && $allow_comment_status=="y")
	{
?>
		<form action="" method="post">
		<br>
		<b>Comment</b><br><textarea class="form-control" rows="4" cols="50" name="newcomment" placeholder="Post your thoughts on this media..."></textarea>
		<input name="addcomment" type="submit" class="btn btn-primary" value="Add Comment">
		</form>
		<p><b>Previous Comments</b></p>
<?php
	
		if(isset($_POST['addcomment']))
		{
		$date= date('Y-m-d H:i:s');
		$insertcomment = "insert into media_comments(mediaid, username, comment, comment_date)".
					"values('".$_GET['id']."','".$_SESSION['username']."','".$_POST['newcomment']."','$date')";
		$insertcomment_query = mysql_query($insertcomment);
		}
			

	}	
	else if(isset($_SESSION['username']) && $allow_comment_status=="n")
	{	
?>		
		<p><b>Comments have been disabled for this media</b></p>
<?php
		
	}
	else if(!isset($_SESSION['username']) && $allow_comment_status=="y")
	{	
?>		
		<p><b>Login to post a comment. If you dont have an account please register</b></p>
		<p><b>Previous Comments:</b></p>
<?php
		
	}
	else if(!isset($_SESSION['username']) && $allow_comment_status=="n")
	{	
?>		
		<p><b>Comments have been disabled for this media</b></p>
<?php
		
	}


	$views=$views+1;
	$update_view_count = mysql_query("UPDATE media SET view_count='$views' WHERE mediaid='".$_GET['id']."'");
?>

<?php



$fetch_comments = mysql_query("select * from media_comments where mediaid='".$_GET['id']."' order by comment_date desc");
while($comments_row = mysql_fetch_row($fetch_comments))
	{
		$comment_by = $comments_row[1];
		$get_comment_by_name = mysql_query("select fname, lname from login where username = '$comment_by'");
		$get_comment_by_name_row = mysql_fetch_row($get_comment_by_name);
		$comment_by_fname = $get_comment_by_name_row[0];
		$comment_by_lname = $get_comment_by_name_row[1];
		$comment_made = $comments_row[2];
		$commented_on = $comments_row[3];
	?>	
		<p><b><?php echo $comment_by_fname; ?>&nbsp;<?php echo $comment_by_lname; ?></b>&nbsp;on&nbsp;<?php echo $commented_on; ?>&nbsp;commented:</p>
		<p><i><?php echo $comment_made; ?></i></p>
		
<?php
	}
?>

</div>

	

</td>
<td valign="top" style="padding-right: 10px; padding-left: 10px">
<h4>Recommended Media</h4>
<?php

//Recommendations
$curr_media = str_word_count($result_row[6], 1);

$get_suggestions = mysql_query("select mediaid, medianame, view_count from media where (medianame like '%$curr_media[0]%' or medianame like '%$curr_media[1]%' or username = '$uploaded_by_id' or tags like '$result_row[14]') and (visibility = 'y' and type like '%$type%' and mediaid <> '".$_GET['id']."') group by mediaid order by view_count desc limit 6");
while ($get_suggestion_row = mysql_fetch_row($get_suggestions))
{
?>	<table>
	<tr>
	<td>
	<a href="media.php?id=<?php echo $get_suggestion_row[0];?>" class="thumbnail"><img class="media-object" src="images/play.png" /></a> 
	</td>
	</tr>
	<tr>
	<td>
	<?php echo $get_suggestion_row[1]; ?>
	</td>
	</tr>
	<tr>
	<td>
	<i>Views &nbsp;<?php echo $get_suggestion_row[2]; ?></i>
	</td>
	</tr>
	</table>
<?php
}

?>
</td>
</tr>
</table>
<?php
}

else
{
?>
	<meta http-equiv="refresh" content="0;url=browse.php">
<?php
}
?>


<br><br>

                    </div>
                        <a href="#menu-toggle" class="btn btn-default" id="menu-toggle" >Toggle Menu</a>

                </div>
            </div>
        </div>
        <!-- /#page-content-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Menu Toggle Script -->
    <script>
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
    </script>

</body>

</html>