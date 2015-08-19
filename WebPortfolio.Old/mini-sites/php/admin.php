<?php
session_name('ajs2189');
session_start();
//echo phpinfo();
//include "tools.php";
include "adminLibrary.php";
$v_records = mySQLDoQuery("select * from trivia_topics");
$v_questions = mySQLDoQuery("select * from trivia_questions");
$v_answers = mySQLDoQuery("select * from trivia_answers");
$view = $_REQUEST['view'];
$subView = $_POST['subView'];
$v_subView = mySQLDoQuery("select * from $subView");


if($view == "logout")
{
	echo logOut("index.php");
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

$header = <<<EOT
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Project 2 - Trivia Quizzes Admin Panel</title>
<link rel="stylesheet" type="text/css" href="admin.css" />
</head>

<body>
<div id="container">
<img src="images/adminBanner.jpg" id="adminBanner" alt="" /><br />
<div id="adminNav">
|  <a href="admin.php">Admin Home</a>  |  <a href="admin.php?view=add">Add a Topic, Question, or Answer</a>  |  <a href="admin.php?view=modify">Modify a Topic, Question, or Answer</a>  |  <a href="admin.php?view=delete">Delete a Topic, Question, or Answer</a> |
  <a href="admin.php?view=logout">Logout</a>  |</div>
EOT;
if($subView == "trivia_topic") {
	$subView = "topic";
}
else if($subView == "trivia_Question") {
	$subView = "question";
}
else if($subView == "trivia_answers") {
	$subView = "answers";
}
if(isset($view))
{
	$form = showUpdateForm($view,$subView,$v_records,$v_questions,$v_answers);
	//echo $form;
}

else
{
	$form =  "<div class=\"leftAdmin\" style=\"width:700px;\">\n";
	$form .= "<h1>Welcome to the Administration Panel, ".$_SESSION['s_UserName']."</h1>\n";
	$form .= "<p>Please use the links in the navigation above to edit the trivia quizzes. If you would like to log out, you may use the link below, or the log out link in the navigation above.</p>\n";
	$form .= "<p><a href=\"admin.php?view=logout\">Log out</a></p>";
	$form .= "<p><a href=\"index.php\">Project 3 Home</a></a></div>\n";
}

if(isset($_SESSION['s_UserName']))
{
	//echo $_SESSION['s_UserName'];
	echo $header.$form;
}
else
{
	$result = "<script type=\"text/javascript\">\n";
	$result .= "window.location = \"index.php?page=login\"\n";
	$result .="</script>\n";
	echo $result;
}
//echo phpinfo();
?>
</div>
</div>
</body>
</html>
