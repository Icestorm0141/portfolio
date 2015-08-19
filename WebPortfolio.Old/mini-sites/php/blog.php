<?php
session_name('ajs2189');
session_start();
//echo phpinfo();
//include "tools.php";


include "blogLibrary.php";
$v_users = mySQLDoQuery("select * from users");
$v_blog = mySQLDoQuery("select * from blog order by entryID desc");
$v_comments = mySQLDoQuery("select * from comments order by commentID desc");

$admin=blogAdmin($_REQUEST['s_UserName'],$v_users);
$view = $_REQUEST['view'];
$subView = $_REQUEST['subView'];
$user =$_REQUEST['s_UserName'];
//$v_subView = mySQLDoQuery("select * from $subView");


if($view == "logout")
{
	logout("index.php");
}

function updateSQL($action,$table) {
	$results = "false";
	//echo $query;
	if(writeSQL(triviaUpdate($action,$table)) == "true")
	{
		$results = "true";
	}
	return $results;
}

$header .= <<<EOT
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Project 3 - User Preferences & Blog Administration Panel</title>
<link rel="stylesheet" type="text/css" href="admin.css" />
</head>

<body>
<div id="container" style ="border:2px solid #996600; background:#eee0af;">
<img src="images/blogBanner.png" id="Blog Banner" alt="" /><br />
<div id="adminNav">
EOT;
$header .="|  <a href=\"blog.php\">Panel Home</a>  |  <a href=\"index.php\">Project 3 Home</a>  |  ";
if($admin == "true")
{
$header.=<<<BLOG
	<a href="blog.php?view=create">Create a Blog Entry</a>  |  <a href="blog.php?view=modify">Modify a Blog Entry</a>  |  
BLOG;
}
$header .= "<a href=\"blog.php?view=comment\">Post a comment</a> |  <a href=\"blog.php?view=modComment\">Modify a Comment</a>  |  <a href=\"blog.php?view=logout\">Logout</a>  |</div>";
if(isset($view))
{
	$form ="<div class=\"leftAdmin\" style=\"width:700px;\">";
	$form .= showCurrentPage($view,$admin,$v_users,$v_blog,$v_comments);
	//echo $form;
}

else
{
	if(isset($_POST['selectedFeed']))
	{
		$sqlStatement = "update users set rssFeed='".$_POST['selectedFeed']."' where username='".$user."';";
		writeSQL($sqlStatement);
	}
	if(isset($_POST['selectedStyle']))
	{
		$sqlStatement = "update users set stylesheet='".$_POST['selectedStyle']."' where username='".$user."';";
		writeSQL($sqlStatement);
	}
	$form =  "<div class=\"leftAdmin\" style=\"width:700px;\">\n";
	$form .= "<h1>Welcome to the User Admin & Blog Admin Panel, ".$user."</h1>\n";
	$form .= "<p>Please use the links in the navigation above to post comments, create entries (for admin's only), and change the look and feel of the PFW site. If you would like to log out, use the log out link in the navigation above.</p>\n";
	$form .= displayCurrentSettings($user);
	$form .= RSSFeed();
	$form .= chooseStyle();
	$form .= "<img src=\"images/blue.jpg\" class=\"stylePreview\" alt=\"Blue screenshot\"><img src=\"images/green.jpg\" class=\"stylePreview\" alt=\"Green screenshot\"><img src=\"images/default.jpg\" class=\"stylePreview\" alt=\"Default screenshot\">";
	$form .= "<div style=\"width:200px; position:relative; top:-25px;text-align:center; padding:15px;\">Blue Theme  |</div><div style=\"position:relative; top: -70px; left:230px;width:200px; text-align:center; padding:15px;\">Green Theme  |  </div><div style=\"position:relative; top: -115px; left:450px;width:200px; text-align:center; padding:15px;\">Default Theme</div>";
	
}

if(isset($user) || $authenticated =="true")
{
	//echo $user;
	echo $header.$form;
	//echo phpinfo();
}
else
{
	$result = "<script type=\"text/javascript\">\n";
	$result .= "window.location = \"index.php?page=blogLogIn\"\n";
	$result .="</script>\n";
	echo $result;
}
//echo phpinfo();
?>
</div>
</div>
</body>
</html>
