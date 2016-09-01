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
    <div id="wrapper">
        <!-- Sidebar -->
        <div id="sidebar-wrapper">
            <ul class="sidebar-nav">
                <li class="sidebar-brand">
                    <img src="images/logo.png" />
                    
                </li>
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
?>
			<meta http-equiv="refresh" content="0;url=browse.php?q=<?php echo $_POST['searchtext']; ?>">
<?php
		}
	}
?> 
    <!-- /input-group -->
  </div>
				<ul class="nav navbar-nav" >
                    <li>
                        <a href="login.php">Logout</a>
                    </li>
                    <li>
                        <a href="media_upload.php">Upload</a>
                    </li>
                </ul>
            </div>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                       <?php 
$fetch_user_data = mysql_query("select fname,lname from login where username='".$_SESSION['username']."'");
$user_data_row = mysql_fetch_row($fetch_user_data);
$fname = $user_data_row[0];
$lname = $user_data_row[1];
?>
<h3><?php echo $fname;?>'s Playlists</h3>

<h3><span class="label label-default">Your Video Playlists</span></h3>
<?php

$search_video_playlist = mysql_query("select playlist_name from playlist where username='".$_SESSION['username']."' and type = 'video' group by playlist_name");
if(mysql_num_rows($search_video_playlist)>0)
{
?>
	
<?php

	while($playlist_row = mysql_fetch_row($search_video_playlist))
	{
?>	
		<p><b> Playlist name : <?php echo $playlist_row[0]; ?> </b></p>
<?php
 		$search_video_id_playlist = mysql_query("select mediaid from playlist where playlist_name = '$playlist_row[0]'");
?>
		<table>
		        	 <tr>			

<?php
		while($video_playlist_row = mysql_fetch_row($search_video_id_playlist))
		{
			$mediaid = $video_playlist_row[0];
			$fetch_media = mysql_query("select * from media where mediaid = '$mediaid'");
			$get_media_row = mysql_fetch_row($fetch_media);
			$medianame = $get_media_row[6];
			$filename = $get_media_row[0];
			$filepath = $get_media_row[4];
			$type = substr($get_media_row[2],0,5);
?>		
			      <td>
				  <div class="media">
		<div class="media-left">		
            	            <a href="media.php?id=<?php echo $mediaid;?>" target="_blank" class="thumbnail">
							 <img class="media-object" src="images/play.png" height="75" width="75"/>
							</a> <br>
							<b> <?php echo $medianame;?> </b>
                  <br>
						<b> Type : </b>	<?php echo $type;?>
				  <br>
            	            <a href="<?php echo $filepath;?>" class="btn btn-default" target="_blank" onclick="javascript:saveDownload(<?php echo $get_media_row[4];?>);">Download</a>
		</div>
		</div>                 
				 </td>

			
<?php
		}
?>
		</tr>
		</table>
<?php
	}
}
else
{
?>	<br>
	<p><b><?php echo "You do not have any video playlists"; ?></b><p>

	<?php
}
?>

<h3><span class="label label-default">Your Audio Playlists</span></h3>
<?php
$search_audio_playlist = mysql_query("select playlist_name from playlist where username='".$_SESSION['username']."' and type = 'audio' group by playlist_name");
if(mysql_num_rows($search_audio_playlist)>0)
{
?>
	
<?php
	while($playlist_row = mysql_fetch_row($search_audio_playlist))
	{
?>	
		<p><b>Playlist name :<?php echo $playlist_row[0]; ?> </b></p>
<?php
 		$search_audio_id_playlist = mysql_query("select mediaid from playlist where playlist_name = '$playlist_row[0]'");
?>
		<table width="100%" cellpadding="0" cellspacing="0">
		<tr>
<?php
		while($audio_playlist_row = mysql_fetch_row($search_audio_id_playlist))
		{
			$mediaid = $audio_playlist_row[0];
			$fetch_media = mysql_query("select * from media where mediaid = '$mediaid'");
			$get_media_row = mysql_fetch_row($fetch_media);
			$medianame = $get_media_row[6];
			$filename = $get_media_row[0];
			$filepath = $get_media_row[4];
			$type = substr($get_media_row[2],0,5);
?>		
        	 			
			      <td>
				  <div class="media">
		<div class="media-left">		
            	            <a href="media.php?id=<?php echo $mediaid;?>" target="_blank" class="thumbnail">
							<img class="media-object" src="images/play.png" height="75" width="75"/></a> <br>
                  <?php echo $medianame;?><br>
							<?php echo $type;?>
				  <br>
            	            <a href="<?php echo $filepath;?>" target="_blank" class = "btn btn-default" onclick="javascript:saveDownload(<?php echo $get_media_row[4];?>);">Download</a>
                  </div>
				  </div>
				  </td>

			
<?php
		}
?>
		</tr>
		</table>
<?php
	}
}
else
{
?>	<br>
	<p><b><?php echo "You do not have any Audio playlists"; ?></b><p>

	
	<?php
}
?>

<h3><span class="label label-default">Your Image Playlists</span></h3>
<?php
$search_image_playlist = mysql_query("select playlist_name from playlist where username='".$_SESSION['username']."' and type = 'image' group by playlist_name");
if(mysql_num_rows($search_image_playlist)>0)
{
?>

<?php
	while($playlist_row = mysql_fetch_row($search_image_playlist))
	{
?>	
		<p><b>Playlist name :<?php echo $playlist_row[0]; ?></b> </p>
<?php
 		$search_image_id_playlist = mysql_query("select mediaid from playlist where playlist_name = '$playlist_row[0]'");
?>
		<table width="100%" cellpadding="0" cellspacing="0">
		<tr>
<?php
		while($image_playlist_row = mysql_fetch_row($search_image_id_playlist))
		{
			$mediaid = $image_playlist_row[0];
			$fetch_media = mysql_query("select * from media where mediaid = '$mediaid'");
			$get_media_row = mysql_fetch_row($fetch_media);
			$medianame = $get_media_row[6];
			$filename = $get_media_row[0];
			$filepath = $get_media_row[4];
			$type = substr($get_media_row[2],0,5);
?>		
        				
			      <td>
				  <div class="media">
		<div class="media-left">		
            	            <a href="media.php?id=<?php echo $mediaid;?>" target="_blank" class="thumbnail">
							 <img class="media-object" src="images/play.png" height="75" width="75"/>
							</a> <br>
							<?php echo $medianame;?>
							<br>
							<b> Type : </b><?php echo $type;?> <br>

            	            <a href="<?php echo $filepath;?>" target="_blank" class="btn btn-default" onclick="javascript:saveDownload(<?php echo $get_media_row[4];?>);">Download</a>
                  </div>
				  </div>
				  </td>

			
<?php
		}
?>
</tr>
		</table>
<?php
	}
} 
else
{
?>	<br>
	<p><b><?php echo "You do not have any Image playlists"; ?></b><p>

	
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