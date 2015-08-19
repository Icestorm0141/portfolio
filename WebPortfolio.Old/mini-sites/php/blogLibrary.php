<?php
include "tools.php";

	function displayCurrentSettings($user)
	{
		$v_users = mySQLDoQuery("select * from php_users");
		$result = "<h3>Your Current Settings</h3>";
		foreach($v_users as $key =>$value)
		{
			if($value['username'] == $user)
			{
				$result .="<p><strong>Your current RSS Feed is: </strong>".$value['rssFeed']."</p>\n";
				$result .="<p><strong>Your current stylesheet is:</strong> ".$value['stylesheet']."</p>\n";
			}
		}
		return $result;
	}
	
	function RSSFeed() {
		$feedForm = "<form action=\"blog.php\" method=\"post\">\n";
		$feedForm .= "Choose your RSS Feed: &nbsp; &nbsp;<select name=\"selectedFeed\">\n";
		$feedForm .= "<option value=\"christianPostEnt.rss\"/>Christian Entertainment News from The Christian Post</option>\n";
		$feedForm .= "<option value=\"christianSociety.rss\"/>Christianity in Socieity from The Christian Post</option>\n";
		$feedForm .= "<option value=\"christianNews.rss\"/>Christian News from ChristiansUnited.com</option>\n";
		$feedForm .= "<option value=\"skepChristian.rss\"/>Atheism vs. Creationism from SkepticalChristian.com</option>\n";
		$feedForm .= "</select>";
		$feedForm .= "<input type=\"submit\" value=\"Select\" /></form><br/><br/>";
		
		return $feedForm;
	}
	
	function chooseStyle() {
		$feedForm = "<form action=\"blog.php\" method=\"post\">\n";
		$feedForm .= "Choose your Stylesheet: &nbsp; &nbsp;<select name=\"selectedStyle\">\n";
		$feedForm .= "<option value=\"blue.css\"/>Blue Theme</option>\n";
		$feedForm .= "<option value=\"riverStyle.css\"/>Green Theme</option>\n";
		$feedForm .= "<option value=\"portal.css\"/>Default - Parchment</option>\n";
		$feedForm .= "</select>";
		$feedForm .= "<input type=\"submit\" value=\"Select\" /></form><br/><br/>";
		
		return $feedForm;
	}
	
function blogAdmin($username,$v_users)
{
	$result = "false";
	foreach($v_users as $key =>$value)
	{
		if($username == $value['username'])
		{
			if($value['adminPriv']=="true")
			{
				$result = "true";
			}
		}
	}
	
	return $result;
}

function showCurrentPage($view,$admin,$v_users,$v_blog,$v_comments)
{
	//echo showObject($v_answers);
	if($view == "create" && $admin =="true")
	{
		$form = "<h2>Post a New Blog Entry: </h2>\n";
		$form .= "<form action=\"" . $_SERVER['PHP_SELF'] . "\" method=\"post\">\n";
		$form .= "<input type=\"hidden\" name=\"view\" value=\"complete\">\n";
		$form .= "<input type=\"hidden\" name=\"action\" value=\"add\">\n";
		$form .= "<input type=\"hidden\" name=\"username\" value=\"".$_REQUEST['s_UserName']."\">\n";
		$form .= "<input type=\"hidden\" name=\"timeModified\" value=\"".date('D M d,Y')." at ".date('g:i A')."\">\n";
		$form .= "<strong>Entry Title:</strong><input type=\"text\" name=\"entryTitle\" size=\"57\"><br><br>\n";
		$form .= "<strong>Entry:</strong><br> <textarea cols=\"50\" rows=\"10\" name=\"entry\"></textarea><br>\n";
		$form .= "<input type=\"Submit\" Value=\"Post\"/>\n";
		$form .= "</form>";
	}
	else if($view == "complete" && $_POST['action'] =="add")
	{
		$form .="<p>Task completed successfully. Thank you for your participation.</p>";
		$updateStatus = "insert into blog values('','".$_POST['username']."','".$_POST['entryTitle']."','".$_POST['entry']."','".$_POST['timeModified']."');";
		writeSQL($updateStatus);
	}
	else if($view =="modify" && $admin =="true" && $_GET['entryID']==NULL)
	{
		$form ="<h2>Select Entry to Modify:</h2> ";
		$form .="<ul>";
		foreach($v_blog as $key =>$value)
		{
			$form .="<li><a href=\"blog.php?view=modify&amp;entryID=".$value['entryID']."\">".$value['entryTitle']."</a></li>";
		}
		$form .="</ul>";
	}
	else if($view == "modify" && $admin == "true" && isset($_GET['entryID']))
	{
		foreach($v_blog as $key =>$value)
		{
			if($value['entryID']==$_GET['entryID'])
			{
				$entryTitle = $value['entryTitle'];
				$entry = $value['entry'];
			}
		}
		
		$form = "<h2>Modify a Blog Entry: </h2>\n";
		$form .= "<form action=\"" . $_SERVER['PHP_SELF'] . "\" method=\"post\">\n";
		$form .= "<input type=\"hidden\" name=\"view\" value=\"complete\">\n";
		$form .= "<input type=\"hidden\" name=\"action\" value=\"modify\">\n";
		$form .= "<input type=\"hidden\" name=\"entryID\" value=\"".$_GET['entryID']."\">\n";
		$form .= "<input type=\"hidden\" name=\"username\" value=\"".$_REQUEST['s_UserName']."\">\n";
		$form .= "<input type=\"hidden\" name=\"timeModified\" value=\"".date('D M d,Y')." at ".date('g:i A')."\">\n";
		$form .= "<strong>Entry Title:</strong><input type=\"text\" name=\"entryTitle\" size=\"57\" value=\"$entryTitle\"><br><br>\n";
		$form .= "<strong>Entry:</strong><br> <textarea cols=\"50\" rows=\"10\" name=\"entry\">$entry</textarea><br>\n";
		$form .= "<input type=\"Submit\" Value=\"Update Entry\"/>\n";
		$form .= "</form>";
	}
	else if($view == "complete" && $_POST['action'] =="modify")
	{
		$form .="<p>Task completed successfully. Thank you for your participation.</p>";
		$updateStatus = "update blog set entryTitle='".$_POST['entryTitle']."',entry='".$_POST['entry']."',timeModified='".$_POST['timeModified']."' where entryID='".$_POST['entryID']."';";
		writeSQL($updateStatus);
	}
	else if($view =="comment")
	{
		$form ="<h2>Post a New Comment:</h2> ";
		$form .= "<form action=\"" . $_SERVER['PHP_SELF'] . "\" method=\"post\">\n";
		$form .= "<input type=\"hidden\" name=\"view\" value=\"complete\">\n";
		$form .= "<input type=\"hidden\" name=\"action\" value=\"comment\">\n";
		$form .= "<input type=\"hidden\" name=\"username\" value=\"".$_REQUEST['s_UserName']."\">\n";
		$form .= "<input type=\"hidden\" name=\"timeStamp\" value=\"".date('D M d,Y')." at ".date('g:i A')."\">\n";
		$form .= "Post comment to entry: <select type=\"hidden\" name=\"entryID\">";
		foreach($v_blog as $key =>$value)
		{
			$form .= "<option value=\"".$value['entryID']."\">".$value['entryTitle']."</option>";
		}
		$form .="</select><br><br>\n";
		$form .= "<strong>Comment:</strong><br> <textarea cols=\"50\" rows=\"10\" name=\"comment\"></textarea><br>\n";
		$form .= "<input type=\"Submit\" Value=\"Post Comment\"/>\n";
		$form .= "</form>";
	}
	else if($view == "complete" && $_POST['action'] =="comment")
	{
		$form .="<p>Task completed successfully. Thank you for your participation.</p>";
		$updateStatus = "insert into comments values('','".$_POST['entryID']."','".$_POST['username']."','".$_POST['comment']."','".$_POST['timeModified']."');";
		writeSQL($updateStatus);
	}
	else if($view =="modComment" && $_GET['commentID']==NULL)
	{
		$form ="<h2>Select a Comment to Modify:</h2> ";
		$form .="<ul style=\"width: 250px;\">";
		$usersComments = "";
		foreach($v_comments as $key =>$value)
		{
			if($admin == "true")
			{
				$usersComments .="<li style=\"width: 200px; overflow:hidden;height:17px;\"><a href=\"blog.php?view=modComment&amp;commentID=".$value['commentID']."\">".$value['comment']."</a></li>";
			}
			else if($_REQUEST['s_UserName'] == $value['username'])
			{
				$usersComments .="<li style=\"width: 200px;overflow:hidden;height:17px;\"><a href=\"blog.php?view=modComment&amp;commentID=".$value['commentID']."\">".$value['comment']."</a></li>";
			}
		}
		if($usersComments == "")
		{
		echo "meep";
			$usersComments = "<li>You do not have the privileges to edit all comments, and you have not commented on any entries.</li>";
		}
		$form .=$usersComments;
		$form .="</ul>";
	}
	else if($view == "modComment" && isset($_GET['commentID']))
	{
		foreach($v_comments as $key =>$value)
		{
			if($value['commentID']==$_GET['commentID'])
			{
				$comment = $value['comment'];
				$entryID = $value['entryID'];
			}
		}
		
		$form = "<h2>Modify a Comment: </h2>\n";
		$form .= "<form action=\"" . $_SERVER['PHP_SELF'] . "\" method=\"post\">\n";
		$form .= "<input type=\"hidden\" name=\"view\" value=\"complete\">\n";
		$form .= "<input type=\"hidden\" name=\"action\" value=\"modComment\">\n";
		$form .= "<input type=\"hidden\" name=\"commentID\" value=\"".$_GET['commentID']."\">\n";
		$form .= "<input type=\"hidden\" name=\"username\" value=\"".$_REQUEST['s_UserName']."\">\n";
		$form .= "<input type=\"hidden\" name=\"timeStamp\" value=\"".date('D M d,Y')." at ".date('g:i A')."\">\n";
		$form .= "Post comment to entry: <select type=\"hidden\" name=\"entryID\">";
		foreach($v_blog as $key =>$value)
		{
			if($value['entryID'] == $entryID)
			{
				$form .= "<option value=\"".$value['entryID']."\" selected>".$value['entryTitle']."</option>";
			}
			else {
				$form .= "<option value=\"".$value['entryID']."\">".$value['entryTitle']."</option>";
			}
			
		}
		$form .="</select><br><br>\n";
		$form .= "<strong>Comment:</strong><br> <textarea cols=\"50\" rows=\"10\" name=\"comment\">$comment</textarea><br>\n";
		$form .= "<input type=\"Submit\" Value=\"Update Comment\"/>\n";
		$form .= "</form>";
	}
	else if($view == "complete" && $_POST['action'] =="modComment")
	{
		$form .="<p>Task completed successfully. Thank you for your participation.</p>";
		$updateStatus = "update comments set comment='".$_POST['comment']."',timeStamp='".$_POST['timeStamp']."',entryID='".$_POST['entryID']."' where commentID='".$_POST['commentID']."';";
		writeSQL($updateStatus);
	}
	return $form;
}
?>