<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
	session_start();
	include_once "function.php";
	if(!isset($_POST['search']))
{
header("Location: https://http://people.cs.clemson.edu/~bgovind/index.php");
}

?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>MeTube - Videos, Images & much more..</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="css/default.css" />
<script type="text/javascript" src="js/jquery-latest.pack.js"></script>
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
<div>
<img src="metube.png" height="110" width="250" /> 
</div>
<h4>Search Results</h4>
<form  method="post" action="index.php"  id="searchform"> 
	      <input  type="text" name="search"> 
	      <input  type="submit" name="submit" value="search"></form>
<table width="50%" cellpadding="0" cellspacing="0">
		<?php
$search_sql="SELECT * FROM media WHERE filename LIKE '%".$_POST['search']."%'";
$search_query=mysql_query($search_sql);
			while ($result_row = mysql_fetch_row($search_query)) 
//filename, username, type, mediaid, path
			{ 
				$mediaid = $result_row[3];
				$filename = $result_row[0];
				$filepath = $result_row[4];
		?>
        	 <tr valign="top">			
			      <td>
            	            <a href="media.php?id=<?php echo $mediaid;?>" target="_blank"><?php echo $filename;?></a> 
                        </td>
                        <td>
            	            <a href="<?php echo $filepath;?>" target="_blank" onclick="javascript:saveDownload(<?php echo $result_row[4];?>);">Download</a>
                        </td>
		</tr>
	<?php
			}
		?>

        	</table>
<?php
			}
		?>

</body>
</html>