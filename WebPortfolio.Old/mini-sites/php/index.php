<?php
	session_name('ajs2189'); 
	session_start();
	include "indexLibrary.php";
	include "triviaLibrary.php";
	$_SESSION['s_UserName'] = $_REQUEST['s_UserName'];
	$_SESSION['s_Password'] = $_REQUEST['t_Password'];
	$username = $_REQUEST['s_UserName'];
	$password = $_POST['t_Password'];
	$salt = "GodRocks";	
	if(isset($username) && isValid($username)=="true")
	{
		$user = $_REQUEST['s_UserName'];
	}
	else {
		$user = "default";
	}
//	include "tools.php";
	$stylesheet = getStyle($user);

$header .= <<<EOT
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>P.F.W. Portal Homepage</title>
EOT;
$header .="<link rel=\"stylesheet\" type=\"text/css\" href=\"$stylesheet\" />";
$header .= <<<EOT
</head>

<!--A WORKING VERSION OF THIS CODE CAN BE SEEN ONLINE AT HTTP://PHP.AJSTEGLINSKI.COM/INDEX.PHP-->
<body>
<div id="container">
<div id="parchment"></div>
<div id="bannerContainer">
<div id="banner"><span style="display:none;">PFW Portal Homepage</span></div>
</div>
<div id="navContainer">
</div>
<a href="index.php?page=RSS" id="nav1"><span class="navText">News Feed</span></a>
<a href="index.php?page=blog" id="nav2"><span class="navText">Blog</span></a>
<a href="index.php?page=register" id="nav3"><span class="navText">Register</span></a>
<a href="index.php?page=pastQuizzes" id="nav4"><span class="navText">Past Trivia Quizzes</span></a>
<div id="content">
EOT;
$pageView = $_GET['page'];
$register = $_POST['r_UserName'];


$feed = getFeed($user);

if(isset($register))
{
	if(isUnique($register)=="true")
	{
		$sqlStatement ="insert into users values('$register','".crypt($_POST['r_Password'],'GodRocks')."','".$_POST['r_Email']."','false','portal.css','christianNews.rss','');";
		writeSQL($sqlStatement);
		//$content = $sqlStatement;
	}
	else{
		$content = "<p>That username is already taken. Please register again and choose an alternate username.</p>";
		$content .= registerForm();
	}
}

if($pageView == "admin" && isset($_SESSION['s_UserName']) || $pageView =="login" || $pageView =="admin")
{
	if($pageView=="login")
	{
		$content = "<p>You must log in to view the admin page. Please log in now.</p>";
	}
		$content.= callAuthentication("Administrative","admin","admin");
}

else if($pageView =="blogLogIn" || $pageView =="blog")
{
	$content  = "<h2 style=\"margin-bottom:0px;\">PFW Project 3 Blog</h2>";
	$content  .= "<div style=\"position:relative; top:-20px; text-align:right;\"><a href=\"index.php?page=blogLogIn\">Log in to create an entry <br>or comment on one</a></div>";
	if($pageView =="blogLogIn")
	{
			 $content .= callAuthentication("Blog","blogLogIn","blog");
	}
	$content .= displayBlog();
}

else if($pageView =="RSS" || $pageView =="RSSlogIn")
{		
	$content  .= "<div style=\"position:relative; top:00px; text-align:right;\"><a href=\"index.php?page=RSSlogIn\">Log in to customize this news feed.</a></div>";
	if($pageView =="RSSlogIn")
	{
			//$content .= displayForm("News Feed Admin ","RSSlogIn");
			$content .= callAuthentication("News Feed Admin ","RSSlogIn","blog");
	}
	$content .= parseRSS($feed);
}

else if($pageView == "register")
{
		$content = registerForm();
}

else {

	//$content .= displayWeather();
	$content .="<hr>";
	$content .= parseRSS($feed);
//	$content .= phpinfo();
 
}


$mid ="</div><div id='pastQuizzes'><img src=\"images/trivia.png\" id=\"trivia\" alt=\"Trivia Questions\" />";
$category = $_REQUEST['category'];	
if($_GET['page'] == "pastQuizzes")
{
	//DISPLAYS PREVIOUS QUIZ QUESTIONS
	if($category == "topic")
	{
		$chosenCategory = $_GET['chosen'];
		if(isset($chosenCategory))
		{
			$trivia= displayTopics($chosenCategory,"results");
		}
	}
	
	else if($category =="question")
	{
		$trivia .= callQuestionFunc();
	}
	else if($category=="results")
	{
		$trivia .= callResultsFunct();
	}
	else 
	{
		$trivia .= displayCategories("Past Trivia Categories: ","closed");		//DISPLAYS TRIVIA CATEGORIES
	}
	$trivia .= displayBackLinks();
}

$mid2 ="</div><div id=\"quizContainer\"><img src=\"images/trivia.png\" id=\"trivia\" alt=\"Trivia Questions\" />";
$category = $_REQUEST['category'];	
if($category == "topic")
{
	$chosenCategory = $_GET['chosen'];		//GETS VALUE OF THE CATEGORY THAT THE USER CHOSE
	if(isset($chosenCategory))
	{
		$trivia2 .= displayTopics($chosenCategory,"topic");	//DISPLAYS THE TOPICS FOR THAT CATEGORY
	}
}

else if($category =="question")
{
	$trivia2 .= callQuestionFunc();
}

else if($category=="results")
{
	$trivia2 .= callResultsFunct();
}
//END OF DISPLAYING VOTES

//SHOW TRIVIA CATEGORIES
else 
{
	$trivia2 .= displayCategories("Current Quiz Category: ","active")."\n";		//DISPLAYS TRIVIA CATEGORIES
}
$trivia2 .= displayBackLinks();
$footer .="</div>";

if($_GET['page'] == "pastQuizzes")
{
	$jsScript = "<script type=\"text/javascript\" language=\"javascript\">\n";
	$jsScript .= "document.getElementById(\"quizContainer\").style.display = \"none\";\n";
	$jsScript .= "document.getElementById(\"pastQuizzes\").style.display = \"block\";\n";
	$jsScript .= "</script>\n";
	$footer .= $jsScript;
}
$footer .="</div></body></html>";
echo $header.$content.$mid.$trivia.$mid2.$trivia2.$footer;
?>