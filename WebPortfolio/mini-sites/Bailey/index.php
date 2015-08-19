<?php include "nav1.php" ?>
<?php
$main = "home.php";
$site_error = "error.php";
//$id = $HTTP_GET_VARS['mbc'];
$id = $_GET['mbc'];
if(isset($id))
{
	$secondID = $id;
	$id = $id.".php";
	if(file_exists($id))
	{
		include $id;
		$id = $secondID;
	}
	else
	{
		include $site_error;
	}
}
else
{
	include $main;
}
?>
<?php include "nav2.php" ?>