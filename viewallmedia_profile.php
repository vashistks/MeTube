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
if(isset($_GET['friendid']))
{
?>
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
$fetch_user_data = mysql_query("select fname,lname from login where username='".$_GET['friendid']."'");
$user_data_row = mysql_fetch_row($fetch_user_data);
$fname = $user_data_row[0];
$lname = $user_data_row[1];
?>
<h3><b>Showing All media uploaded by <?php echo $fname;?>&nbsp;<?php echo $lname;?></b>
<ul class="nav navbar-nav"> <li> <a href="profile.php?friendid=<?php echo $_GET['friendid']; ?>" class="btn btn-default" >Back</a></li></ul>
</h3>
<?php
	$fetch_all_media = mysql_query("select * from media where username='".$_GET['friendid']."' and visibility = 'y'");
	if(mysql_num_rows($fetch_all_media) > "0")
	{
?>

	<table>
		<tr>
		<th style="padding: 10px;">Media Link</th>
		<th style="padding: 10px;">Media Name</th>
		<th style="padding: 10px;">Media Type</th>
		<th style="padding: 10px;">Download link</th>
		</tr>
		
	       			
<?php
while($recent_video_row = mysql_fetch_row($fetch_all_media))
{
	
		
		$mediaid = $recent_video_row[3];
		$medianame= $recent_video_row[6];
		$filename = $recent_video_row[0];
		$filepath = $recent_video_row[4];
		$type = substr($recent_video_row[2],0,5);
?>
<tr valign="middle">
		<td style="padding: 10px;">
		<div class="media">
		<div class="media-left">
           <a href="media.php?id=<?php echo $mediaid;?>" target="_blank" class="thumbnail">
		   <img class="media-object" src="images/play.png" height="75px" width="75px"/> </a> </td>
		   <td style="padding: 10px;"> <?php echo $medianame;?> </td>
        
		<td style="padding: 10px;"><?php echo $type; ?> </td> <td>
           <a href="<?php echo $filepath;?>" target="_blank" class="btn btn-default" onclick="javascript:saveDownload(<?php echo $result_row[4];?>);">Download</a>
        </td>
		</div>
		</div>
</tr>
<?php
	
}
?>
</table>
	
<?php

}
else
{
?>
	<h4>This channel doesn't have any media yet. Visit us later.</h4>
<?php
}

?>


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
<?php
}
?>

</body>

</html>