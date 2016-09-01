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
<h3><?php echo $fname;?>, join a discussion or start your own</h3>
<table width = "100%">
<tr>
<td width="60%">
<h4>Have a question? Ask your friends on the MeTube community...</h4>
<form  method="post" action=""  id="searchform"> 
	<table><tr><td>Title: </td><td><input  type="text" class="form-control" name="dis_name"></td></tr>
	<tr><td>Comment: </td><td><textarea rows="4" cols="50" name="comment"></textarea></td></tr>
	<tr><td></td><td><input  type="submit" class="btn btn-default" name="start" value="Start a Discussion"></td><tr>
	</table>
	
</form>

<?php

if(isset($_POST['start']))
{
	if($_POST['dis_name'] == "")
	{
		echo "Your discussion must have a title";
	}
	else
	{	
		$date= date('Y-m-d H:i:s');
		$title_id = $_POST['dis_name'].$date;
		$create_discussion = mysql_query("insert into discussion values('".$_SESSION['username']."', '".$_POST['dis_name']."', '".$_POST['comment']."', '".$_SESSION['username']."', '$date', '$title_id')");
	}
}

?>

<h4>Join a conversation. Search for interested topics..</h4>
<form  method="post" action=""  id="searchform">
	<table><tr><td>Topic Title (Keywords): </td><td><input  type="text" class="form-control" name="topic_name"></td></tr>
	<tr><td></td><td><input  type="submit" class="btn btn-default" name="search" value="Search related topics"></td><tr>
	</table>
</form>

<table width="80%" cellpadding="0" cellspacing="0">
<?php
if(isset($_POST['search']))
{
	echo "<h4>Related Topics..</h4>";
	$search_topic = mysql_query("SELECT * FROM discussion WHERE title LIKE '%".$_POST['topic_name']."%' or comment LIKE '%".$_POST['topic_name']."%'");
	while($topic_row = mysql_fetch_row($search_topic)) 
			{ 
				$owner = $topic_row[0];
				$title = $topic_row[1];
				$title_id = $topic_row[5];
?>
        	 <tr valign="top">			
			      <td>
					<a href="topic.php?id=<?php echo $title_id;?>" class="btn btn-info"><?php echo $title;?></a> 
                  </td>
				  <td>
				  <i>By...</i>
				  </td>
                  <td>
					<?php echo $owner; ?>
                  </td>
		</tr> 
	<?php
			}
		?>
<?php
}
?>

</table>

</td>

<td width="40%">
<h3 valign="top"><span class="label label-warning">Your Topics.. </span></h3>
<table width="100%">

<?php
$search_topic = mysql_query("SELECT * FROM discussion WHERE owner='".$_SESSION['username']."' group by title_id");
while($topic_row = mysql_fetch_row($search_topic)) 
{ 
	$owner = $topic_row[0];
	$title = $topic_row[1];
	$title_id = $topic_row[5];
?>
    <tr>			
	<td valign="top">
		<a href="topic.php?id=<?php echo $title_id;?>" class="btn btn-info"><?php echo $title;?></a> 
    </td>
	<td valign="top">
	<i>By..</i>
	</td>
    <td valign="top">
		<?php echo $owner; ?>
    </td>
	</tr>
<?php
}



?>

</table>
</td>
</tr>
</table>

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