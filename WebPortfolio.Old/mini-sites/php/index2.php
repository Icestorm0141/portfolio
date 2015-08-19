<?php
	session_name('ajs2189'); 
	session_start();
	
	
	$_SESSION['s_UserName'] = $_REQUEST['s_UserName'];
	$_SESSION['s_Password'] = $_REQUEST['t_Password'];
//	include "tools.php";
	include "indexLibrary.php";
	include "triviaLibrary.php";

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>P.F.W. Portal Homepage</title>
<link rel="stylesheet" type="text/css" href="portal.css" />
</head>

<!--A WORKING VERSION OF THIS CODE CAN BE SEEN ONLINE AT VEGA.IT.RIT.EDU/~AJS2189/PFW/PROJECT2/INDEX.PHP-->
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
<?php
$pageView = $_GET['page'];
$register = $_POST['r_UserName'];

if(isset($_SESSION['s_UserName']))
{
	$user = $_SESSION['s_UserName'];
}
else {
	$user = "default";
}
echo $user;
$feed = getFeed($user);

if(isset($register))
{
	if(isUnique($register)=="true")
	{
		$sqlStatement ="insert into users values('$register','".crypt($_POST['r_Password'],'GodRocks')."','".$_POST['r_Email']."','','');";
		writeSQL($sqlStatement);
		$content = $sqlStatement;
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
	if (!isset($_SESSION['s_UserName'])) 
	{
		$content .= displayForm("Administrative","admin");
	} 
	else if(isset($_SESSION['s_UserName']) && $pageView == "admin")
	{
		echo callAuthentication("Administrative","admin","admin");
	}
}

else if($pageView =="blogLogIn" || $pageView =="blog")
{
	$content  = "<h2 style=\"margin-bottom:0px;\">PFW Project 3 Blog</h2>";
	$content  .= "<div style=\"position:relative; top:-20px; text-align:right;\"><a href=\"index.php?page=blogLogIn\">Log in to create an entry <br>or comment on one</a></div>";
	if($pageView =="blogLogIn")
	{
		if (!isset($_SESSION['s_UserName'])) 
		{ //first time here, so display a form
			$content .= displayForm("Blog","blogLogIn");
		} 
		else if(isset($_SESSION['s_UserName']) && $pageView == "blogLogIn")
		{
			 echo callAuthentication("Blog","blogLogIn","blog");
		}
	}
	$content .= displayBlog();
}

else if($pageView =="RSS" || $pageView =="RSSlogIn")
{		
	$content  .= "<div style=\"position:relative; top:00px; text-align:right;\"><a href=\"index.php?page=RSSlogIn\">Log in to customize this news feed.</a></div>";
	if($pageView =="RSSlogIn")
	{
		if(!isset($_SESSION['s_UserName'])) 
		{ //first time here, so display a form
			$content .= displayForm("News Feed Admin ","RSSlogIn");
		} 
		else if(isset($_SESSION['s_UserName']) && $pageView == "RSSlogIn")
		{
			 echo callAuthentication("News Feed Admin ","RSSlogIn","blog");
		}
	}
	$content .= parseRSS($feed);
}

else if($pageView == "register")
{
		$content = registerForm();
}

else {

	$content .= displayWeather();
	$content .="<hr>";
	$content .= parseRSS($feed);
 
}

echo $content;
?>
</div>
<div id='pastQuizzes'>

<img src="images/trivia.png" id="trivia" alt="Trivia Questions" />

<?php
$category = $_REQUEST['category'];	
if($_GET['page'] == "pastQuizzes")
{
	//DISPLAYS PREVIOUS QUIZ QUESTIONS
	if($category == "topic")
	{
		$chosenCategory = $_GET['chosen'];
		if(isset($chosenCategory))
		{
			echo displayTopics($chosenCategory,"results");
		}
	}
	
	else if($category =="question")
	{
		echo callQuestionFunc();
	}
	else if($category=="results")
	{
		echo callResultsFunct();
	}
	else 
	{
		echo displayCategories("Past Trivia Categories: ","closed");		//DISPLAYS TRIVIA CATEGORIES
	}
	echo displayBackLinks();
}
?>
</div>
<div id="quizContainer">
<img src="images/trivia.png" id="trivia" alt="Trivia Questions" />

<?php
$category = $_REQUEST['category'];	
if($category == "topic")
{
	$chosenCategory = $_GET['chosen'];		//GETS VALUE OF THE CATEGORY THAT THE USER CHOSE
	if(isset($chosenCategory))
	{
		echo displayTopics($chosenCategory,"topic");	//DISPLAYS THE TOPICS FOR THAT CATEGORY
	}
}

else if($category =="question")
{
	echo callQuestionFunc();
}

else if($category=="results")
{
	echo callResultsFunct();
}
//END OF DISPLAYING VOTES

//SHOW TRIVIA CATEGORIES
else 
{
	echo displayCategories("Current Quiz Category: ","active")."\n";		//DISPLAYS TRIVIA CATEGORIES
}
echo displayBackLinks();
?></div>

<?php
if($_GET['page'] == "pastQuizzes")
{
	$jsScript = "<script type=\"text/javascript\" language=\"javascript\">\n";
	$jsScript .= "document.getElementById(\"quizContainer\").style.display = \"none\";\n";
	$jsScript .= "document.getElementById(\"pastQuizzes\").style.display = \"block\";\n";
	$jsScript .= "</script>\n";
	echo $jsScript;
}

?>
</div>
</body>
</html>
