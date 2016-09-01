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
                    <a href="login.php">Logout</a>
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
<h3><?php echo $fname;?>, you can search new people and add them as a contact/friend</h3>
<table width="100%">
<tr width="60%"><td >
<table width="100%">
<tr>
<td width="60%">
<h3>Find people below ...</h3>
<div class="col-lg-6">
<form  method="post" action=""  id="searchform"> 
	<div class="input-group">
	      <input  type="text" name="search_friends" class="form-control"> 
	  <span class="input-group-btn"><input  type="submit" class="btn btn-default" name="search" value="search"></span>
</div>
		  
</div>
<br>
</td>

</tr>
<tr width="60%"> <td>
<?php
if(isset($_POST['search']))
{
echo "<h4>Search Results</h4>";
$search_sql="SELECT username FROM login WHERE (fname LIKE '%".$_POST['search_friends']."%' or lname LIKE '%".$_POST['search_friends']."%') and (username <> '".$_SESSION['username']."') group by username";
$search_query=mysql_query($search_sql);
?>
<table width="50%" cellpadding="0" cellspacing="0">
<?php
while ($result_row = mysql_fetch_row($search_query)) 
			{ 	
		$friendid = $result_row[0];
		$checkstatus_block1 = mysql_query("SELECT * from contact WHERE username = '".$_SESSION['username']."' and contactname ='$friendid' AND block = 'yes' ");
		$checkstatus_block2 = mysql_query("SELECT * from contact WHERE username = '$friendid' and contactname ='".$_SESSION['username']."' AND block = 'yes' ");
		
		if(mysql_num_rows($checkstatus_block1) == "0" && mysql_num_rows($checkstatus_block2) == "0")
				{
				$get_friend_name = mysql_query("select fname, lname from login where username='$friendid'");
				$friend_name_row = mysql_fetch_row($get_friend_name);
				
		?>
		
        	 <tr valign="top">			
			      <td style="padding-bottom: 5px;">
					<?php echo $friend_name_row[0]; ?>
					<?php echo $friend_name_row[1]; ?>
                  </td> 
                  <td style="padding-bottom: 5px;">
            	    <a href="profile.php?friendid=<?php echo $friendid; ?>" class="btn btn-info">View Profile</a>
                  </td>
				<td>
						
				</td>
			</tr>
		
	<?php
			}
			}
?>
</table>
<?php
}
?>
</td>

</tr>
</form>
</table>
</td>
<td valign="top" width="40%">
<?php
$get_friend_list = mysql_query("select contactname from contact where username='".$_SESSION['username']."' AND friend = 'yes'");
?>
<h4><span class="label label-default">My friends</span></h4>
<table >
<?php
while($friend_list_row = mysql_fetch_row($get_friend_list))
{
?>
	<tr>
	<td style = "padding-right: 5px; padding-bottom: 5px">
<?php
	$get_friend_name = mysql_query("select fname,lname from login where username='$friend_list_row[0]'");
	$friend_name_row = mysql_fetch_row($get_friend_name);
	echo $friend_name_row[0];
?>
	&nbsp;
<?php
	echo $friend_name_row[1];
?>
	</td>
	<td style = "padding-right: 5px; padding-bottom: 5px">
		<a href="profile.php?friendid=<?php echo $friend_list_row[0]; ?>" class="btn btn-info">View Profile</a>
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