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
	<input type="text" class="form-control" placeholder="Search for..." name="searchtext"> 
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
<h3><?php echo $fname;?>, you can browse by category here </h3>

 <form  method="post" action="" id="searchform"> 
<div class="input-group">	
	      <input  type="text" class="form-control" name="search" placeholder="Search for videos, images, audio and much more...">
		
	      <span class="input-group-btn">  <input  class="btn btn-default" type="submit" name="searchcat" value="search"> </span>
		 </div>
		 <h4><span class="label label-default"> Media Category </span></h4>
		 <select class="form-control" name="cattype">
			<option value="general">General</option>
			<option value="entertainment">Entertainment</option>
			<option value="sports">Sports</option>
			<option value="sciecne">Science</option>
		</select> 
</div>
<?php
if(isset($_POST['searchcat']))
{
	echo "<h4>Search Results</h4>";
	$cattype = $_POST['cattype'];
	
		$search_sql1="SELECT * FROM media WHERE medianame LIKE '%".$_POST['search']."%' AND (category = '$cattype' AND visibility = 'y') order by view_count desc  ";
		$search_query1=mysql_query($search_sql1);

	?>
	<table width="50%" cellpadding="0" cellspacing="0">
	 <tr valign="top">	
<?php	
	while ($result_row1 = mysql_fetch_row($search_query1)) //filename, username, type, mediaid, path
	{ 
				$mediaid = $result_row1[3];
				$type = $result_row1[2];
				$medianame= $result_row1[6];
				$filename = $result_row1[0];
				$filepath = $result_row1[4];
		?>
        	 		
			      <td>
            	          <div class="media">
		<div class="media-left">
           <a href="media.php?id=<?php echo $mediaid;?>" target="_blank" class="thumbnail">
		    <img class="media-object" src="images/play.png" />
		  </a>    
		  <?php echo $medianame;?><br>
		   <?php echo $type; ?>
		  <br>
           <a href="<?php echo $filepath;?>" class="btn btn-default" target="_blank" onclick="javascript:saveDownload(<?php echo $result_row[4];?>);">Download</a>
		   </div>
		   </div>
                        </td>
			
<?php
	}
?>
</tr>
	</table>
	</form>
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

</body>

</html>