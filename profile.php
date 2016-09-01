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
					   if(isset($_GET['friendid']))
{
$fetch_user_data = mysql_query("select fname,lname from login where username='".$_SESSION['username']."'");
$user_data_row = mysql_fetch_row($fetch_user_data);
$fname = $user_data_row[0];
$lname = $user_data_row[1];
	$get_friend_name = mysql_query("select fname, lname from login where username = '".$_GET['friendid']."'");
	$name_row = mysql_fetch_row($get_friend_name);
	$friend_fname = $name_row[0];
	$friend_lname = $name_row[1];

?>
	
	<h4><?php echo $friend_fname; ?>&nbsp;<?php echo $friend_lname; ?>'s Channel<ul class="nav navbar-nav"> <li> <a href="browse_friends.php" class="btn btn-default" >Back </a></li></ul>
</h4>
<?php
	
	$checkblock = "SELECT * from contact where contactname='".$_GET['friendid']."' AND username = '".$_SESSION['username']."'";
	$checkblock2 = "SELECT * from contact where username='".$_GET['friendid']."' AND contactname = '".$_SESSION['username']."'";
	$runcheck2 = mysql_query($checkblock2);
	$runcheck = mysql_query($checkblock);
	$blocked2 = mysql_fetch_row($runcheck2);
	$blocked = mysql_fetch_row($runcheck);
	if($blocked[3] == "yes" )
{
	echo " you have blocked the user, you cant view anything";
	?>
	<form action="" method="post">
	<input type="submit" class="btn btn-default"  value = "UnBlock User" name = "unblock">
	
	<?php
	if(isset($_POST['unblock']))
	{
		$blockuser = "update contact set block = 'no' where contactname='".$_GET['friendid']."' AND username = '".$_SESSION['username']."' ";
		$blockquery = mysql_query($blockuser);
		?>
<meta http-equiv="refresh" content="0;url=profile.php?friendid=<?php echo $_GET['friendid'];?>"
<?php
	}
?>
	</form>
<?php
$showstatus = 0;
}
	else if($blocked2[3] == "yes" )
{
	echo " you have been blocked by the user, you cant view anything";
	echo " You cannot unblock" ;
?>
	<h3><ul class="nav navbar-nav"> <li> <a href="browse_friends.php" class="btn btn-default" >Go back </a></li></ul></h3>

<?php
	$showstatus = 0;
}

else if($blocked[3] == "no")
{	
	?>
	<form action="" method="post">
	<input type="submit" class="btn btn-default" value = "Block User" name = "block">


<?php

if(isset($_POST['block']))
	{
		$blockuser = "update contact set block = 'yes' where contactname='".$_GET['friendid']."' AND username = '".$_SESSION['username']."' ";
		$blockquery = mysql_query($blockuser);
		?>
<meta http-equiv="refresh" content="0;url=profile.php?friendid=<?php echo $_GET['friendid'];?>"
<?php
	}
?>
	</form>
<?php	

$search_friend="SELECT username FROM contact WHERE contactname='".$_GET['friendid']."' AND username = '".$_SESSION['username']."' AND friend = 'yes'" ;
$search_friend2="SELECT username from contact WHERE username='".$_GET['friendid']."' AND contactname = '".$_SESSION['username']."' AND friend = 'yes'" ;
$search_contact="SELECT username FROM contact WHERE contactname='".$_GET['friendid']."' AND username = '".$_SESSION['username']."' AND friend = 'no'"   ;
$search_contact2="SELECT username from contact WHERE username='".$_GET['friendid']."' AND contactname = '".$_SESSION['username']."' AND friend = 'no'" ;
$search_query=mysql_query($search_friend);
$search_query2=mysql_query($search_friend2);
$search_query3=mysql_query($search_contact);
$search_query4=mysql_query($search_contact2);

			 $result_row = mysql_fetch_row($search_query); //filename, username, type, mediaid, path
			 $result_row2 = mysql_fetch_row($search_query2);
			 $result_row3 = mysql_fetch_row($search_query3); //filename, username, type, mediaid, path
			 $result_row4 = mysql_fetch_row($search_query4);
				$friend = $result_row[0];
				$friend2 = $result_row2[0];
				$contact = $result_row3[0];
				$contact2 = $result_row4[0];
				if($friend == $_SESSION['username'])
				{ 
?>
				<p><b>Already a contact</b></p>
				<p><b>Already friend</b></p>
				<form action="profile.php?friendid=<?php echo $_GET['friendid'];?>" method="post">
				<input type="submit" class="btn btn-default" value="remove as contact" name="un_contact">
				<input type="submit" class="btn btn-default" value="remove as friend" name="un_friend">
							
<?php
if(isset($_POST['un_contact']))
	{
		echo "deleted contact" ;
		$delete_contact = "delete from contact where contactname='".$_GET['friendid']."' AND username = '".$_SESSION['username']."'" ;
		$run_deletecontact = mysql_query($delete_contact);
				?>
<meta http-equiv="refresh" content="0;url=profile.php?friendid=<?php echo $_GET['friendid'];?>"
<?php
		}
if(isset($_POST['un_friend']))
{
	echo "removed as friend";
	$delete_friend = "update contact set friend = 'no' where contactname='".$_GET['friendid']."' AND username = '".$_SESSION['username']."'" ;
	$run_friend = mysql_query($delete_friend);
				?>
				<meta http-equiv="refresh" content="0;url=profile.php?friendid=<?php echo $_GET['friendid'];?>"
<?php				
		}	
 ?> 
</form>
 <?php
				}
				else if($friend2 == $_GET['friendid'])
				{
?>              
				<p><b>Already a contact</b></p>
				<p><b>Already friend</b></p>
				<form action="profile.php?friendid=<?php echo $_GET['friendid'];?>" method="post">
				<input type="submit" class="btn btn-default" value="remove as contact" name="un_contact">
				<input type="submit" class="btn btn-default" value="remove as friend" name="un_friend">
							
<?php
if(isset($_POST['un_contact']))
	{
		echo "deleted contact" ;
		$delete_contact2 = "delete from contact where username='".$_GET['friendid']."' AND contactname = '".$_SESSION['username']."'" ;
		$run_deletecontact2 = mysql_query($delete_contact2);
				?>
<meta http-equiv="refresh" content="0;url=profile.php?friendid=<?php echo $_GET['friendid'];?>"
<?php
		}
if(isset($_POST['un_friend']))
{
	echo "removed as friend";
	$delete_friend2 = "update contact set friend = 'no' where username='".$_GET['friendid']."' AND contactname = '".$_SESSION['username']."'" ;
	$run_friend2 = mysql_query($delete_friend2);
				?>
				<meta http-equiv="refresh" content="0;url=profile.php?friendid=<?php echo $_GET['friendid'];?>"
<?php				
		}	
?> 
</form>
 <?php
				}	
				else if($contact == $_SESSION['username'])
				{
?>
				<p><b>Already a contact</b></p>
				<p><b>Wanna add as a friend?</b></p>
				<form action="profile.php?friendid=<?php echo $_GET['friendid'];?>" method="post">
				<input type="submit" class="btn btn-default" value="remove as contact" name="un_contact">
				<input type="submit" class="btn btn-default" value="add as friend" name="add_friend">
								
<?php
				if(isset($_POST['un_contact']))
	{
				echo "deleted contact" ;
				$delete_contact3 = "delete from contact where contactname='".$_GET['friendid']."' AND username = '".$_SESSION['username']."'" ;
				$run_deletecontact3 = mysql_query($delete_contact3);
				?>
<meta http-equiv="refresh" content="0;url=profile.php?friendid=<?php echo $_GET['friendid'];?>"
<?php
		}
						if(isset($_POST['add_friend']))
	{
				echo "Added as friend too" ;
				$add_friend3 = "update contact set friend = 'yes' where contactname='".$_GET['friendid']."' AND username = '".$_SESSION['username']."'" ;
				$run_addfriend3 = mysql_query($add_friend3);
				?>
<meta http-equiv="refresh" content="0;url=profile.php?friendid=<?php echo $_GET['friendid'];?>"
<?php
		}
		?> 
</form>
 <?php
				}	
				else if($contact2 ==  $_GET['friendid'])
				{
?>
				<p><b>Already a contact</b></p>
				<p><b>Wanna add as a friend?</b></p>
				<form action="profile.php?friendid=<?php echo $_GET['friendid'];?>" method="post">
				<input type="submit" class="btn btn-default" value="remove as contact" name="un_contact">
				<input type="submit" class="btn btn-default" value="add as friend" name="add_friend">
							
<?php
				if(isset($_POST['un_contact']))
	{
				echo "deleted contact" ;
				$delete_contact4 = "delete from contact where username='".$_GET['friendid']."' AND contactname = '".$_SESSION['username']."'" ;
				$run_deletecontact4 = mysql_query($delete_contact4);
				?>
<meta http-equiv="refresh" content="0;url=profile.php?friendid=<?php echo $_GET['friendid'];?>"
<?php
		}
			if(isset($_POST['add_friend']))
	{
				echo "deleted contact" ;
				$add_friend4 = "update contact set friend = 'yes' where username='".$_GET['friendid']."' AND contactname = '".$_SESSION['username']."'" ;
				$run_addfriend4 = mysql_query($add_friend4);
				?>
<meta http-equiv="refresh" content="0;url=profile.php?friendid=<?php echo $_GET['friendid'];?>"
<?php
		}
		?> 
</form>
 <?php
				}					
				else
				{
					
	?>
				<p>Not a friend and a contact </p>
				<form action="profile.php?friendid=<?php echo $_GET['friendid'];?>" method="post">
				<input type="submit" class="btn btn-default" value="Add as contact" name="add_contact">
				<input type="submit" class="btn btn-default" value="Add as Friend" name="add_friend">
				
<?php 
				if(isset($_POST['add_contact']))
	{
		echo "Added as contact" ;
		$insert_contact = "insert into contact values('".$_SESSION['username']."','".$_GET['friendid']."','no','no')";
		$run_insertcontact = mysql_query($insert_contact);
 
?>
 <meta http-equiv="refresh" content="0;url=profile.php?friendid=<?php echo $_GET['friendid'];?>"
<?php
		}
						if(isset($_POST['add_friend']))
	{
		echo "Added as friend" ;
		$insert_friend = "insert into contact values('".$_SESSION['username']."','".$_GET['friendid']."','yes','no')";
		$run_insertfriend = mysql_query($insert_friend);
 
?>
 <meta http-equiv="refresh" content="0;url=profile.php?friendid=<?php echo $_GET['friendid'];?>"
<?php
		}
				}
	
	$showstatus = 1;
}
else 
{
		?>
	</form>
	<p>Cannot block now</p>
<?php
$showstatus = 1;
if(isset($_POST['block']))
	{
		$blockuser = "update contact set block = 'yes' where contactname='".$_GET['friendid']."' AND username = '".$_SESSION['username']."' ";
		$blockquery = mysql_query($blockuser);
		?>
<meta http-equiv="refresh" content="0;url=profile.php?friendid=<?php echo $_GET['friendid'];?>"
<?php
	}

$search_friend="SELECT username FROM contact WHERE contactname='".$_GET['friendid']."' AND username = '".$_SESSION['username']."' AND friend = 'yes'" ;
$search_friend2="SELECT username from contact WHERE username='".$_GET['friendid']."' AND contactname = '".$_SESSION['username']."' AND friend = 'yes'" ;
$search_contact="SELECT username FROM contact WHERE contactname='".$_GET['friendid']."' AND username = '".$_SESSION['username']."' AND friend = 'no'"   ;
$search_contact2="SELECT username from contact WHERE username='".$_GET['friendid']."' AND contactname = '".$_SESSION['username']."' AND friend = 'no'" ;
$search_query=mysql_query($search_friend);
$search_query2=mysql_query($search_friend2);
$search_query3=mysql_query($search_contact);
$search_query4=mysql_query($search_contact2);

			 $result_row = mysql_fetch_row($search_query); //filename, username, type, mediaid, path
			 $result_row2 = mysql_fetch_row($search_query2);
			 $result_row3 = mysql_fetch_row($search_query3); //filename, username, type, mediaid, path
			 $result_row4 = mysql_fetch_row($search_query4);
				$friend = $result_row[0];
				$friend2 = $result_row2[0];
				$contact = $result_row3[0];
				$contact2 = $result_row4[0];
				if($friend == $_SESSION['username'])
				{ 
?>
				<p><b>Already a contact</b></p>
				<p><b>Already friend</b></p>
				<form action="profile.php?friendid=<?php echo $_GET['friendid'];?>" method="post">
				<input type="submit" class="btn btn-default" value="remove as contact" name="un_contact">
				<input type="submit" class="btn btn-default" value="remove as friend" name="un_friend">
				</form>				
<?php
if(isset($_POST['un_contact']))
	{
		echo "deleted contact" ;
		$delete_contact = "delete from contact where contactname='".$_GET['friendid']."' AND username = '".$_SESSION['username']."'" ;
		$run_deletecontact = mysql_query($delete_contact);
				?>
<meta http-equiv="refresh" content="0;url=profile.php?friendid=<?php echo $_GET['friendid'];?>"
<?php
		}
if(isset($_POST['un_friend']))
{
	echo "removed as friend";
	$delete_friend = "update contact set friend = 'no' where contactname='".$_GET['friendid']."' AND username = '".$_SESSION['username']."'" ;
	$run_friend = mysql_query($delete_friend);
				?>
				<meta http-equiv="refresh" content="0;url=profile.php?friendid=<?php echo $_GET['friendid'];?>"
<?php				
		}	

				}
				else if($friend2 == $_GET['friendid'])
				{
?>              
				<p><b>Already a contact</b></p>
				<p><b>Already friend</b></p>
				<form action="profile.php?friendid=<?php echo $_GET['friendid'];?>" method="post">
				<input type="submit" class="btn btn-default" value="remove as contact" name="un_contact">
				<input type="submit" class="btn btn-default" value="remove as friend" name="un_friend">
				</form>				
<?php
if(isset($_POST['un_contact']))
	{
		echo "deleted contact" ;
		$delete_contact2 = "delete from contact where username='".$_GET['friendid']."' AND contactname = '".$_SESSION['username']."'" ;
		$run_deletecontact2 = mysql_query($delete_contact2);
				?>
<meta http-equiv="refresh" content="0;url=profile.php?friendid=<?php echo $_GET['friendid'];?>"
<?php
		}
if(isset($_POST['un_friend']))
{
	echo "removed as friend";
	$delete_friend2 = "update contact set friend = 'no' where username='".$_GET['friendid']."' AND contactname = '".$_SESSION['username']."'" ;
	$run_friend2 = mysql_query($delete_friend2);
				?>
				<meta http-equiv="refresh" content="0;url=profile.php?friendid=<?php echo $_GET['friendid'];?>"
<?php				
		}	

				}	
				else if($contact == $_SESSION['username'])
				{
?>
				<p><b>Already a contact</b></p>
				<p><b>Wanna add as a friend?</b></p>
				<form action="profile.php?friendid=<?php echo $_GET['friendid'];?>" method="post">
				<input type="submit" class="btn btn-default" value="remove as contact" name="un_contact">
				<input type="submit" class="btn btn-default" value="add as friend" name="add_friend">
				</form>				
<?php
				if(isset($_POST['un_contact']))
	{
				echo "deleted contact" ;
				$delete_contact3 = "delete from contact where contactname='".$_GET['friendid']."' AND username = '".$_SESSION['username']."'" ;
				$run_deletecontact3 = mysql_query($delete_contact3);
				?>
<meta http-equiv="refresh" content="0;url=profile.php?friendid=<?php echo $_GET['friendid'];?>"
<?php
		}
						if(isset($_POST['add_friend']))
	{
				echo "Added as friend too" ;
				$add_friend3 = "update contact set friend = 'yes' where contactname='".$_GET['friendid']."' AND username = '".$_SESSION['username']."'" ;
				$run_addfriend3 = mysql_query($add_friend3);
				?>
<meta http-equiv="refresh" content="0;url=profile.php?friendid=<?php echo $_GET['friendid'];?>"
<?php
		}
				}	
				else if($contact2 ==  $_GET['friendid'])
				{
?>
				<p><b>Already a contact</b></p>
				<p><b>Wanna add as a friend?</b></p>
				<form action="profile.php?friendid=<?php echo $_GET['friendid'];?>" method="post">
				<input type="submit" class="btn btn-default" value="remove as contact" name="un_contact">
				<input type="submit" class="btn btn-default" value="add as friend" name="add_friend">
				</form>				
<?php
				if(isset($_POST['un_contact']))
	{
				echo "deleted contact" ;
				$delete_contact4 = "delete from contact where username='".$_GET['friendid']."' AND contactname = '".$_SESSION['username']."'" ;
				$run_deletecontact4 = mysql_query($delete_contact4);
				?>
<meta http-equiv="refresh" content="0;url=profile.php?friendid=<?php echo $_GET['friendid'];?>"
<?php
		}
			if(isset($_POST['add_friend']))
	{
				echo "deleted contact" ;
				$add_friend4 = "update contact set friend = 'yes' where username='".$_GET['friendid']."' AND contactname = '".$_SESSION['username']."'" ;
				$run_addfriend4 = mysql_query($add_friend4);
				?>
<meta http-equiv="refresh" content="0;url=profile.php?friendid=<?php echo $_GET['friendid'];?>"
<?php
		}
				}					
				else
				{
					
	?>
				<p>Not a friend and a contact </p>
				<form action="profile.php?friendid=<?php echo $_GET['friendid'];?>" method="post">
				<input type="submit" class="btn btn-default" value="Add as contact" name="add_contact">
				<input type="submit" class="btn btn-default" value="Add as Friend" name="add_friend">
				
<?php 
				if(isset($_POST['add_contact']))
					{
						echo "Added as contact" ;
						$insert_contact = "insert into contact values('".$_SESSION['username']."','".$_GET['friendid']."','no','no')";
						$run_insertcontact = mysql_query($insert_contact);
				 
?>
 <meta http-equiv="refresh" content="0;url=profile.php?friendid=<?php echo $_GET['friendid'];?>"
<?php
					}
				if(isset($_POST['add_friend']))
					{
						echo "Added as friend" ;
						$insert_friend = "insert into contact values('".$_SESSION['username']."','".$_GET['friendid']."','yes','no')";
						$run_insertfriend = mysql_query($insert_friend);
					 
?>
 <meta http-equiv="refresh" content="0;url=profile.php?friendid=<?php echo $_GET['friendid'];?>"
<?php
					}
		?> 
	</form>
 <?php
				}
}
}
if($showstatus == 1)
{
?>
<br>
<h4>Recently uploaded media...</h4>
<?php
	$curr_date= date('Y-m-d');
	$fetch_recent_video = mysql_query("select * from media where username='".$_GET['friendid']."' and visibility = 'y' ORDER by uploaddate DESC LIMIT 5");
?>
	<table width="100%" cellpadding="0" cellspacing="0">
	       <tr valign="top">			
<?php
	while($recent_video_row = mysql_fetch_row($fetch_recent_video))
	{
		$mediaid = $recent_video_row[3];
		$medianame= $recent_video_row[6];
		$filename = $recent_video_row[0];
		$filepath = $recent_video_row[4];
?>
		<td>
		<div class="media">
		<div class="media-left">
           <a href="media.php?id=<?php echo $mediaid;?>" target="_blank" class="thumbnail">
		   <img class="media-object" src="images/play.png" height="75px" width="75px"/> </a> <br>
		   <?php echo $medianame;?>
        <br>
           <a href="<?php echo $filepath;?>" target="_blank" class="btn btn-default" onclick="javascript:saveDownload(<?php echo $result_row[4];?>);">Download</a>
        </div>
		</div>
		</td>
		
<?php
	}
?>
</tr>
	</table>
	<a href="viewallmedia_profile.php?friendid=<?php echo $_GET['friendid']; ?>" class="btn btn-info"> View all Media in this Channel</a>
<br>
<h4> Playlists </h4>
<h4><span class="label label-default">Video Playlists</span></h4>
<?php

$search_video_playlist = mysql_query("select playlist_name from playlist where username='".$_GET['friendid']."' and type = 'video' group by playlist_name");
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
	<p><b><?php echo "The channel doesn't have any video playlists"; ?></b><p>

	<?php
}
?>

<h4><span class="label label-default">Audio Playlists</span></h4>
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
	<p><b><?php echo "The channel doesn't have any audio playlists"; ?></b><p>

	
	<?php
}
?>

<h4><span class="label label-default">Image Lists</span></h4>
<?php
$search_image_playlist = mysql_query("select playlist_name from playlist where username='".$_GET['friendid']."' and type = 'image' group by playlist_name");
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
	<p><b><?php echo "The channel doesn't have any image lists"; ?></b><p>

	
	<?php
}
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