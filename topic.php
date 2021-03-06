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
<h3><span class="label label-info">Discussions</span><ul class="nav navbar-nav"> <li> <a href="discussion.php" class="btn btn-default" >Back</a></li></ul>
</h3>

<?php
if(isset($_GET['id'])) 
{
	$fetch_discussion = mysql_query("select * from discussion where title_id='".$_GET['id']."'");
	$discussion_row = mysql_fetch_row($fetch_discussion);
	$title = $discussion_row[1];
	$title_id = $discussion_row[5];
	$owner = $discussion_row[0];
	//Comments
?>
		<h4><?php echo $title; ?>&nbsp; started by <?php echo $owner; ?></h4>
		<form  method="post" action=""> 
		<table>
		<tr><td>Comment: </td><td><textarea rows="4" cols="50" name="comment"></textarea></td></tr>
		<tr><td></td><td><input  type="submit" class="btn btn-default" name="submit" value="Submit comment"></td><tr>
		</table>
		<br>
<?php

	if(isset($_POST['submit']))
	{
		if($_POST['comment'] == "")
		{
			echo "Enter your comment";
		}
		else
		{
			$date= date('Y-m-d H:i:s');
			$create_discussion = mysql_query("insert into discussion values('$owner', '$title', '".$_POST['comment']."', '".$_SESSION['username']."', '$date', '$title_id')");
		}
	}


	$fetch_comments = mysql_query("select * from discussion where title_id='".$_GET['id']."' order by comment_date desc");
	while($comments_row = mysql_fetch_row($fetch_comments))
	{
		$comment_by = $comments_row[3];
		$comment_made = $comments_row[2];
		$commented_on = $comments_row[4];
?>	
						
						<div class="alert alert-info">
		<p><b><?php echo $comment_by; ?></b>&nbsp;on&nbsp;<?php echo $commented_on; ?>&nbsp;commented:</p>
		<p><i><?php echo $comment_made; ?></i></p>
		</div>
		
<?php
	}

}

else
{
?>
	<meta http-equiv="refresh" content="0;url=discussion.php">
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