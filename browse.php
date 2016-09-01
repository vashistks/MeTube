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
                    <a href="updateprofile.php">My Profile</a>
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
		
        <div class="col-lg-6">
    
     <form  method="post" action=""  id="searchform"> 
	     	
		<div class="input-group">	
	      <input  type="text" class="form-control" name="search" placeholder="Search for videos, images, audio and much more...">
		
	      <span class="input-group-btn">  <input  class="btn btn-default" type="submit" name="submit" value="search"> </span>
		 </div>
		 <br>
		 <table><tr>
		 <td style="padding-right: 10px;">
		<h4><span class="label label-default"> Media Type </span></h4>
		 <select class="form-control" name="mtype">
			<option value="">All</option>
			<option value="video">Videos</option>
			<option value="image">Images</option>
			<option value="audio">Audio</option>
		</select> 
		</td>
		<td style="padding-right: 10px;">
		<h4><span class="label label-default"> Upload Date </span></h4>
		<select class="form-control" name="udate">
			<option value="">All</option>
			<option value="<?php echo date('Y-m-d'); ?>">Today</option>
			<option value="<?php echo date('Y-m-d', strtotime('-7 days')); ?>">This Week</option>
			<option value="<?php echo date('Y-m-d', strtotime('-30 days')); ?>">This Month</option>
		</select>
		</td>
		<td style="padding-right: 10px;">
		<h4><span class="label label-default"> Media Size </span></h4>
		<select class="form-control" name="size">
			<option value="">All</option>
			<option value="1">Less 500KB</option>
			<option value="2">500 KB to 5MB</option>
			<option value="3">More than 5MB</option>
		</select>
		</td>
		</tr>
		</table>
</form>
<?php

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
            
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <?php 
$fetch_user_data = mysql_query("select fname,lname from login where username='".$_SESSION['username']."'");
$user_data_row = mysql_fetch_row($fetch_user_data);
$fname = $user_data_row[0];
$lname = $user_data_row[1];
?>
						<h3><b>Welcome, <?php echo $fname;?>&nbsp<?php echo $lname; ?>! </b>  </h3>
                        
<div id='upload_result'>
<?php 
	if(isset($_REQUEST['result']) && $_REQUEST['result']!=0)
	{		
		echo upload_error($_REQUEST['result']);
	}
?>
</div>
<?php

	$query = "SELECT * from media"; 
	$result = mysql_query( $query );
	if (!$result){
	   die ("Could not query the media table in the database: <br />". mysql_error());
	}

$curr_date = date('Y-m-d');
?>
<h4>Trending Tags</h4>
<?php
	
$get_tags = mysql_query("select word, COUNT(word) as word_count from word_cloud group by word order by word_count desc limit 10");
?>
<table width="90%">
<tr>
<td>
<form method="post" action="">
<?php
$i="1";
while($get_tags_row = mysql_fetch_row($get_tags))
{
?>
	<input type="submit" class="btn btn-primary" name = "<?php echo $i; ?>" value="<?php echo $get_tags_row[0]; ?>">
<?php
	$a[$i] = "$get_tags_row[0]";
	$i = $i + 1;
?>
	&nbsp;
<?php
}
?>
</form>
</td>
</tr>
</table>

<?php
if(isset($_POST['1']))
{
?> 		<h4>Media found under the tag "<?php echo $a[1]; ?>"</h4>
<?php

		$update_word_cloud = mysql_query("insert into word_cloud values('$a[1]')");
		$search_with_tag = mysql_query("select * from media where medianame LIKE '%$a[1]%' or description LIKE '%$a[1]%' or tags like '$a[1]' order by uploaddate desc");
?>		
		<table width="100%" cellpadding="0" cellspacing="0">
		 <tr valign="top">	
<?php	
	while ($result_row = mysql_fetch_row($search_with_tag)) //filename, username, type, mediaid, path
	{ 
				$mediaid = $result_row[3];
				$type = $result_row[2];
				$medianame= $result_row[6];
				$filename = $result_row[0];
				$filepath = $result_row[4];
		$visibility = $result_row[7];
				$uploaded_by = $result_row[1];
		if($visibility == "n" && $uploaded_by == $_SESSION['username'])
		{
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
		else if($visibility == "y")
		{
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
	}
?>
</tr>
	</table>
<?php
}
else if(isset($_POST['2']))
{
?> 		<h4>Media found under the tag "<?php echo $a[2]; ?>"</h4>
<?php
		$update_word_cloud = mysql_query("insert into word_cloud values('$a[2]')");
		$search_with_tag = mysql_query("select * from media where medianame LIKE '%$a[2]%' or description LIKE '%$a[2]%' or tags like '%$a[2]%' order by uploaddate desc");
?>		
		<table width="100%" cellpadding="0" cellspacing="0">
		 <tr valign="top">	
<?php	
	while ($result_row = mysql_fetch_row($search_with_tag)) //filename, username, type, mediaid, path
	{ 
				$mediaid = $result_row[3];
				$type = $result_row[2];
				$medianame= $result_row[6];
				$filename = $result_row[0];
				$filepath = $result_row[4];
				$visibility = $result_row[7];
				$uploaded_by = $result_row[1];
		if($visibility == "n" && $uploaded_by == $_SESSION['username'])
		{
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
		else if($visibility == "y")
		{
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
			
	}
?>
</tr>
	</table>
<?php
}
else if(isset($_POST['3']))
{
?> 		<h4>Media found under the tag "<?php echo $a[3]; ?>"</h4>
<?php
		$update_word_cloud = mysql_query("insert into word_cloud values('$a[3]')");
		$search_with_tag = mysql_query("select * from media where medianame LIKE '%$a[3]%' or description LIKE '%$a[3]%' or tags like '%$a[3]%' order by uploaddate desc");
?>		
		<table width="100%" cellpadding="0" cellspacing="0">
		 <tr valign="top">	
<?php	
	while ($result_row = mysql_fetch_row($search_with_tag)) //filename, username, type, mediaid, path
	{ 
				$mediaid = $result_row[3];
				$type = $result_row[2];
				$medianame= $result_row[6];
				$filename = $result_row[0];
				$filepath = $result_row[4];
				$visibility = $result_row[7];
				$uploaded_by = $result_row[1];
		if($visibility == "n" && $uploaded_by == $_SESSION['username'])
		{
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
		else if($visibility == "y")
		{
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
	}
?>
</tr>
	</table>
<?php
}
else if(isset($_POST['4']))
{
?> 		<h4>Media found under the tag "<?php echo $a[4]; ?>"</h4>
<?php
		$update_word_cloud = mysql_query("insert into word_cloud values('$a[4]')");
		$search_with_tag = mysql_query("select * from media where medianame LIKE '%$a[4]%' or description LIKE '%$a[4]%' or tags like '%$a[4]%' order by uploaddate desc");
?>		
		<table width="50%" cellpadding="0" cellspacing="0">
		 <tr valign="top">	
<?php	
	while ($result_row = mysql_fetch_row($search_with_tag)) //filename, username, type, mediaid, path
	{ 
				$mediaid = $result_row[3];
				$type = $result_row[2];
				$medianame= $result_row[6];
				$filename = $result_row[0];
				$filepath = $result_row[4];
				$visibility = $result_row[7];
				$uploaded_by = $result_row[1];
		if($visibility == "n" && $uploaded_by == $_SESSION['username'])
		{
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
		else if($visibility == "y")
		{
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
	}
?>
</tr>
	</table>
<?php
}
else if(isset($_POST['5']))
{
?> 		<h4>Media found under the tag "<?php echo $a[5]; ?>"</h4>
<?php
		$update_word_cloud = mysql_query("insert into word_cloud values('$a[5]')");
		$search_with_tag = mysql_query("select * from media where medianame LIKE '%$a[5]%' or description LIKE '%$a[5]%' or tags like '%$a[5]%' order by uploaddate desc");
?>		
		<table width="100%" cellpadding="0" cellspacing="0">
		 <tr valign="top">	
<?php	
	while ($result_row = mysql_fetch_row($search_with_tag)) //filename, username, type, mediaid, path
	{ 
				$mediaid = $result_row[3];
				$type = $result_row[2];
				$medianame= $result_row[6];
				$filename = $result_row[0];
				$filepath = $result_row[4];
				$visibility = $result_row[7];
				$uploaded_by = $result_row[1];
		if($visibility == "n" && $uploaded_by == $_SESSION['username'])
		{
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
		else if($visibility == "y")
		{
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
	}
?>
</tr>
	</table>
<?php
}
else if(isset($_POST['6']))
{
?> 		<h4>Media found under the tag "<?php echo $a[6]; ?>"</h4>
<?php
		$update_word_cloud = mysql_query("insert into word_cloud values('$a[6]')");
		$search_with_tag = mysql_query("select * from media where medianame LIKE '%$a[6]%' or description LIKE '%$a[6]%' or tags like '%$a[6]%' order by uploaddate desc");
?>		
		<table width="100%" cellpadding="0" cellspacing="0">
		 <tr valign="top">	
<?php	
	while ($result_row = mysql_fetch_row($search_with_tag)) //filename, username, type, mediaid, path
	{ 
				$mediaid = $result_row[3];
				$type = $result_row[2];
				$medianame= $result_row[6];
				$filename = $result_row[0];
				$filepath = $result_row[4];
				$visibility = $result_row[7];
				$uploaded_by = $result_row[1];
		if($visibility = "n" && $uploaded_by == $_SESSION['username'])
		{
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
		else if($visibility == "y")
		{
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
	}
?>
</tr>
	</table>
<?php
}
else if(isset($_POST['7']))
{
?> 		<h4>Media found under the tag "<?php echo $a[7]; ?>"</h4>
<?php
		$update_word_cloud = mysql_query("insert into word_cloud values('$a[7]')");
		$search_with_tag = mysql_query("select * from media where medianame LIKE '%$a[7]%' or description LIKE '%$a[7]%' or tags like '%$a[7]%' order by uploaddate desc");
?>		
		<table width="100%" cellpadding="0" cellspacing="0">
		 <tr valign="top">	
<?php	
	while ($result_row = mysql_fetch_row($search_with_tag)) //filename, username, type, mediaid, path
	{ 
				$mediaid = $result_row[3];
				$type = $result_row[2];
				$medianame= $result_row[6];
				$filename = $result_row[0];
				$filepath = $result_row[4];
				$visibility = $result_row[7];
				$uploaded_by = $result_row[1];
		if($visibility == "n" && $uploaded_by == $_SESSION['username'])
		{
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
		else if($visibility == "y")
		{
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
	}
?>
</tr>
	</table>
<?php
}
else if(isset($_POST['8']))
{
?> 		<h4>Media found under the tag "<?php echo $a[8]; ?>"</h4>
<?php
		$update_word_cloud = mysql_query("insert into word_cloud values('$a[8]')");
		$search_with_tag = mysql_query("select * from media where medianame LIKE '%$a[8]%' or description LIKE '%$a[8]%' or tags like '%$a[8]%' order by uploaddate desc");
?>		
		<table width="100%" cellpadding="0" cellspacing="0">
		 <tr valign="top">	
<?php	
	while ($result_row = mysql_fetch_row($search_with_tag)) //filename, username, type, mediaid, path
	{ 
				$mediaid = $result_row[3];
				$type = $result_row[2];
				$medianame= $result_row[6];
				$filename = $result_row[0];
				$filepath = $result_row[4];
				$visibility = $result_row[7];
				$uploaded_by = $result_row[1];
		if($visibility == "n" && $uploaded_by == $_SESSION['username'])
		{
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
		else if($visibility == "y")
		{
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
	}
?>
</tr>
	</table>
<?php
}
else if(isset($_POST['9']))
{
?> 		<h4>Media found under the tag "<?php echo $a[9]; ?>"</h4>
<?php
		$update_word_cloud = mysql_query("insert into word_cloud values('$a[9]')");
		$search_with_tag = mysql_query("select * from media where medianame LIKE '%$a[9]%' or description LIKE '%$a[9]%' or tags like '%$a[9]%' order by uploaddate desc");
?>		
		<table width="100%" cellpadding="0" cellspacing="0">
		 <tr valign="top">	
<?php		
		while ($result_row = mysql_fetch_row($search_with_tag)) //filename, username, type, mediaid, path
	{ 
				$mediaid = $result_row[3];
				$type = $result_row[2];
				$medianame= $result_row[6];
				$filename = $result_row[0];
				$filepath = $result_row[4];
				$visibility = $result_row[7];
				$uploaded_by = $result_row[1];
		if($visibility == "n" && $uploaded_by == $_SESSION['username'])
		{
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
		else if($visibility == "y")
		{
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
	}
?>
</tr>
	</table>
<?php
}
else if(isset($_POST['10']))
{
?> 		<h4>Media found under the tag "<?php echo $a[10]; ?>"</h4>
<?php
		$update_word_cloud = mysql_query("insert into word_cloud values('$a[10]')");
		$search_with_tag = mysql_query("select * from media where medianame LIKE '%$a[9]%' or description LIKE '%$a[10]%' or tags like '%$a[10]%' order by uploaddate desc");
?>		
		<table width="100%" cellpadding="0" cellspacing="0">
		 <tr valign="top">	
<?php	
	while ($result_row = mysql_fetch_row($search_with_tag)) //filename, username, type, mediaid, path
	{ 
				$mediaid = $result_row[3];
				$type = $result_row[2];
				$medianame= $result_row[6];
				$filename = $result_row[0];
				$filepath = $result_row[4];
				$visibility = $result_row[7];
				$uploaded_by = $result_row[1];
		if($visibility == "n" && $uploaded_by == $_SESSION['username'])
		{
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
		else if($visibility == "y")
		{
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
		
	}
?>
</tr>
	</table>
<?php
}

else if(isset($_POST['search']))
{
	if($_POST['search'] <> "")
	{
	$update_word_cloud = mysql_query("insert into word_cloud values('".$_POST['search']."')");
	}
	echo "<h4>Search Results</h4>";
	
	
	$mtype = $_POST['mtype'];
	
	if($_POST['mtype'] == "" && $_POST['udate'] == "" && $_POST['size']=="")
	{
		$search_sql="SELECT * FROM media WHERE (medianame LIKE '%".$_POST['search']."%' or description LIKE '%".$_POST['search']."%' or tags like '%".$_POST['search']."%') group by mediaid order by view_count desc";
		$search_query=mysql_query($search_sql);
	}
	else if ($_POST['mtype'] != "" && $_POST['udate'] == "" && $_POST['size']=="")
	{
		$search_sql="SELECT * FROM media WHERE ((medianame LIKE '%".$_POST['search']."%' or description LIKE '%".$_POST['search']."%' or tags like '%".$_POST['search']."%') and (type like '%$mtype%')) group by mediaid order by view_count desc";
		$search_query=mysql_query($search_sql);
	}
	else if ($_POST['udate'] != "" && $_POST['size'] == "")
	{
		$search_sql="SELECT * FROM media WHERE ((medianame LIKE '%".$_POST['search']."%' or description LIKE '%".$_POST['search']."%' or tags like '%".$_POST['search']."%') and (type like '%$mtype%' and uploaddate <= '$curr_date' and uploaddate >= '".$_POST['udate']."')) group by mediaid order by view_count desc";
		$search_query=mysql_query($search_sql);
	}
	else if ($_POST['udate'] != "" && $_POST['size'] == "1")
	{
		$search_sql="SELECT * FROM media WHERE ((medianame LIKE '%".$_POST['search']."%' or description LIKE '%".$_POST['search']."%' or tags like '%".$_POST['search']."%') and (type like '%$mtype%' and uploaddate <= '$curr_date' and uploaddate >= '".$_POST['udate']."' and size <= '500000')) group by mediaid order by view_count desc";
		$search_query=mysql_query($search_sql);
	}
	else if ($_POST['udate'] != "" && $_POST['size'] == "2")
	{
		$search_sql="SELECT * FROM media WHERE ((medianame LIKE '%".$_POST['search']."%' or description LIKE '%".$_POST['search']."%' or tags like '%".$_POST['search']."%') and (type like '%$mtype%' and uploaddate <= '$curr_date' and uploaddate >= '".$_POST['udate']."' and size >= '500000' and size <= '5242880')) group by mediaid order by view_count desc";
		$search_query=mysql_query($search_sql);
	}
	else if ($_POST['udate'] != "" && $_POST['size'] == "3")
	{
		$search_sql="SELECT * FROM media WHERE ((medianame LIKE '%".$_POST['search']."%' or description LIKE '%".$_POST['search']."%' or tags like '%".$_POST['search']."%') and (type like '%$mtype%' and uploaddate <= '$curr_date' and uploaddate >= '".$_POST['udate']."' and size > '5242880')) group by mediaid order by view_count desc";
		$search_query=mysql_query($search_sql);
	}
	else if ($_POST['udate'] == "" && $_POST['size'] == "1")
	{
		$search_sql="SELECT * FROM media WHERE ((medianame LIKE '%".$_POST['search']."%' or description LIKE '%".$_POST['search']."%' or tags like '%".$_POST['search']."%') and (type like '%$mtype%' and size < '500000')) group by mediaid order by view_count desc";
		$search_query=mysql_query($search_sql);
	}
	else if ($_POST['udate'] == "" && $_POST['size'] == "2")
	{
		$search_sql="SELECT * FROM media WHERE ((medianame LIKE '%".$_POST['search']."%' or description LIKE '%".$_POST['search']."%' or tags like '%".$_POST['search']."%') and (type like '%$mtype%' and size >= '500000' and size <= '5242880')) group by mediaid order by view_count desc";
		$search_query=mysql_query($search_sql);
	}
	else if ($_POST['udate'] == "" && $_POST['size'] == "3")
	{
		$search_sql="SELECT * FROM media WHERE ((medianame LIKE '%".$_POST['search']."%' or description LIKE '%".$_POST['search']."%' or tags like '%".$_POST['search']."%') and (type like '%$mtype%' and size > '5242880')) group by mediaid order by view_count desc";
		$search_query=mysql_query($search_sql);
	}
	
	
	
?>
	<table width="50%" cellpadding="0" cellspacing="0">
	 <tr valign="top">	
<?php	
	while ($result_row = mysql_fetch_row($search_query)) //filename, username, type, mediaid, path
	{ 
				$mediaid = $result_row[3];
				$type = $result_row[2];
				$medianame= $result_row[6];
				$filename = $result_row[0];
				$filepath = $result_row[4];
				$visibility = $result_row[7];
				$uploaded_by = $result_row[1];
		
		 if($visibility == "y")
		{
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
		else if($visibility = "n")
		{
		if($uploaded_by == $_SESSION['username'])
		{
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
		}
			
	}
?>
</tr>
	</table>
<?php
}

else if(isset($_GET['q']))
{
	if($_GET['q'] <> "")
	{
	$update_word_cloud = mysql_query("insert into word_cloud values('".$_GET['q']."')");
	}
	echo "<h4>Search Results</h4>";

	$search_sql="SELECT * FROM media WHERE (medianame LIKE '%".$_GET['q']."%' or description LIKE '%".$_GET['q']."%' or tags like '%".$_GET['q']."%') group by mediaid order by view_count desc";
	$search_query=mysql_query($search_sql);
		
?>
	<table width="50%" cellpadding="0" cellspacing="0">
	 <tr valign="top">	
<?php	
	while ($result_row = mysql_fetch_row($search_query)) //filename, username, type, mediaid, path
	{ 
				$mediaid = $result_row[3];
				$type = $result_row[2];
				$medianame= $result_row[6];
				$filename = $result_row[0];
				$filepath = $result_row[4];
				$visibility = $result_row[7];
				$uploaded_by = $result_row[1];
				
		if($visibility == "y")
		{
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
	
		else if($visibility == "n" && $uploaded_by == $_SESSION['username'])
		{
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
	}
?>
</tr>
	</table>
<?php
}

else
{
?>
	<h4> Recently Uploaded Media</h4>
<?php
	$curr_date= date('Y-m-d');
	$fetch_recent_video = mysql_query("select * from media where visibility = 'y' ORDER by uploaddate desc LIMIT 5");
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
		$type = $recent_video_row[2];
?>      <td>
		<div class="media">
		<div class="media-left">		
		   <a href="media.php?id=<?php echo $mediaid;?>" target="_blank" class="thumbnail">
		   		    <img class="media-object" src="images/play.png" />
		   </a>
		   <?php echo $medianame;?><br>
		   <?php echo $type; ?>
		           
        <br>
           <a href="<?php echo $filepath;?>" class="btn btn-default" target="_blank" align="center" onclick="javascript:saveDownload(<?php echo $result_row[4];?>);">Download</a>
        
		</div>
		</div>
		</td>
<?php
	}
?></tr>
	</table>
	<h4>Most Viewed Media</h4>
<?php
	$fetch_most_video = mysql_query("select * from media where visibility = 'y' order by view_count desc limit 5");
?>
	<table width="100%" cellpadding="0" cellspacing="0">
	       <tr valign="top">			

<?php
	while($most_video_row = mysql_fetch_row($fetch_most_video))
	{
		$mediaid = $most_video_row[3];
		$medianame= $most_video_row[6];
		$filename = $most_video_row[0];
		$filepath = $most_video_row[4];
		$type = $most_video_row[2];

?>
		<td>
			<div class="media">
		<div class="media-left">
           <a href="media.php?id=<?php echo $mediaid;?>" target="_blank" class="thumbnail">
		    <img class="media-object" src="images/play.png" />
		  </a>    
		  <?php echo $medianame; ?><br>
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
<?php
}

?>


<br>
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