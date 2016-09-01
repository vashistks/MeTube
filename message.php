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
                    <a href="channels.php">My Channels</a>
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
<h3><?php echo $fname;?>, you can view your messages and chats here</h3>
<form action="message.php" method="post">
<table width="40%">
<tr>
<div class="btn-group btn-group-justified" role="group" >
<td>
<a href="compose.php" class="btn btn-default">Compose </a></td>
<td><input type="submit" name="inbox" value = "Inbox" class="btn btn-default"></td>
<td><input type="submit" name="unread" value = "Unread" class="btn btn-default"></td>
</div>
</tr>
</table>
<br>

<?php
if(isset($_POST['inbox']))
	{
			$chats = "select * from message where receiver = '".$_SESSION['username']."' GROUP by sender ORDER by date desc" ;
			$fetchchats = mysql_query($chats);
		//	$chats2 = "select DISTINCT sender from message where receiver = '".$_SESSION['username']."' ORDER by date " ;
		//	$fetchchats2 = mysql_query($chats2);
	if(mysql_num_rows($fetchchats)>0)
		{
while($getdetails= mysql_fetch_row($fetchchats))		
		{		
		$getchat = $getdetails[0];
			$getfrom = $getdetails[1];
			$getto = $getdetails[2];		
			$getdate = $getdetails[3];
			$getstatus = $getdetails[4];
		
		?>	
		
		<div class="alert alert-info">
		<p><b> Messages from <?php echo  $getfrom ?> : </b> <a href="chat.php?id=<?php echo $getfrom?>" class="btn btn-default"> <b> View Chat</b> </a> <br>	
		<b><?php echo $getfrom; ?></b>&nbsp;last messaged on:&nbsp;<?php echo $getdate; ?>&nbsp; 
		<br><i><?php echo $getchat; ?></i></p> 
		</div>
		
<?php			
		}
	}
	}
	
else if(isset($_POST['unread']))
	{
			$chats = "select * from message where receiver = '".$_SESSION['username']."' AND view_status='unread' GROUP by sender ORDER by date desc" ;
			$fetchchats = mysql_query($chats);
		//	$chats2 = "select DISTINCT sender from message where receiver = '".$_SESSION['username']."' ORDER by date " ;
		//	$fetchchats2 = mysql_query($chats2);
	if(mysql_num_rows($fetchchats)>0)
		{
while($getdetails= mysql_fetch_row($fetchchats))		
		{		
		$getchat = $getdetails[0];
			$getfrom = $getdetails[1];
			$getto = $getdetails[2];		
			$getdate = $getdetails[3];
			$getstatus = $getdetails[4];
		
		?>	
		
		<div class="alert alert-info">
		<p><b> Messages from <?php echo  $getfrom ?> : </b> <a href="chat.php?id=<?php echo $getfrom?>" class="btn btn-default"> <b> View Chat</b> </a> <br>	
		<b><?php echo $getfrom; ?></b>&nbsp;last messaged on:&nbsp;<?php echo $getdate; ?>&nbsp; 
		<br><i><?php echo $getchat; ?></i></p> 
		</div>
		
<?php			
		}
	}
	}
		
	else
	{
		echo "Click above menu to navigate";
	}

?>
	</form>
<br><br>
                    </div>
					
                        <a href="#menu-toggle" class="btn btn-default" id="menu-toggle">Toggle Menu</a>

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