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

    <title>Upload Media</title>

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
<h3><?php echo $fname;?>, upload your media onto MeTube here...</h3>

<form method="post" action="media_upload.php" enctype="multipart/form-data" >
 
  <table style="border-collapse:separate; border-spacing:0 5px;"><tr>
  <td>
  <input type="hidden" name="MAX_FILE_SIZE" value="20971520" /></td><td></td></tr>
  <tr>
  <td>
   Add a Media: </td><td><label style="color:#663399"><em> (Each file limit 20M)</em></label></td></tr>
	<tr>
	<td>
	<input class="btn btn-primary" name="file" type="file" size="20" /></td><td></td></tr>
	<tr>
	<td>
	Media Name:</td><td><input class="form-control" name="medianame" type="text" maxlength="50"></td></tr>
	<tr>
	<tr>
	<td>
	Category:</td><td><input class="form-control" name="category" type="text" maxlength="50" placeholder="General, Entertainment, Sports or Science" ></td></tr>
	<tr>
	<td>
	Description:</td><td><textarea class="form-control" name="mdescription" row="4" cols="50" placeholder="Add a short description for your media. Description should not exceed 200 characters." ></textarea></td></tr>
	<tr>
	<td>
	Tag:</td><td><textarea class="form-control" name="mtag" row="4" cols="50" placeholder="Tag your media under specific keywords. Separate each tag with a space and total number of characters should not exceed 50."></textarea></td></tr>
	<tr>
	<td>Do you want this media to be visible in public search results? </td> <td><input type="radio" name="visibility" value="y"<?php echo ($visibility != "n") ? 'checked="checked"' : ''; ?>>Yes
<input type="radio" name="visibility" value="n" <?php echo ($visibility == "n") ? 'checked="checked"' : ''; ?>>No</td></tr>
<tr>
<td>
Do you want other users to comment under this media? </td> <td><input type="radio" name="allow_comments" value="y" <?php echo ($allow_comments != "n") ? 'checked="checked"' : ''; ?>>Yes
<input type="radio" name="allow_comments" value="n" <?php echo ($allow_comments == "n") ? 'checked="checked"' : ''; ?>>No</td></tr>
<tr>
<td>
Do you want other users to rate this media? </td> <td><input type="radio" name="allow_rating" value="y" <?php echo ($allow_rating != "n") ? 'checked="checked"' : ''; ?>>Yes
<input type="radio" name="allow_rating" value="n" <?php echo ($allow_rating == "n") ? 'checked="checked"' : ''; ?>>No</td></tr>
<tr>
<td></td>
     	
<td>	<input value="Upload" class="btn btn-primary" name="submit" type="submit" /></td></tr>
</table>
	


<?php

if(isset($_POST['submit'])) 
{
	if (empty($_POST['medianame']))
	{
		echo "Media name is mandatory";
	}
	else if(empty($_POST['mdescription']))
	{
		echo "Media description is mandatory";
	}
	else if(empty($_POST['category']))
	{
		echo "category is mandatory";
	}
	else if(empty($_POST['mtag']))
	{
		echo "Media tag is mandatory";
	}
	else
	{
		$check_upload = media_upload_process($_POST['medianame'], $_POST['visibility'], $_POST['allow_comments'], $_POST['allow_rating'], $_POST['mdescription'], $_POST['mtag'], $_POST['category']);
	}


 }

?>
                
 </form>

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