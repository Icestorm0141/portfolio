<?php
	include "tools.php";
	function displayBlog()
	{
		$v_records = mySQLDoQuery("select * from blog order by entryID desc");
		$v_comments = mySQLDoQuery("select * from comments");
		$result = "<div style=\"margin-top:-10px;\">";
		$count =0;
		foreach($v_records as $key => $value)
		{
			if($count<3)
			{
				$result .="<h3>".$value['entryTitle']."<span style=\"font-size:12px; font-weight:normal;\"> by <em>".$value['username']."</em></span></h3>";
				$result .="<p style=\"margin-top:-10px; font-size:12px;\">posted on ".$value['timeModified']."</p>";
				$result .="<p>".$value['entry']."</p>";
				foreach($v_comments as $cKey =>$cValue)
				{
					if($value['entryID'] == $cValue['entryID'])
					{
						$result .="<p><strong>Comment:</strong> ".$cValue['comment']." by <em>".$cValue['username']."</em>.</p>";
					}
				}
				$result .= "<hr>";
				$count++;
			}
		}
		$result .="</div>";
		return $result;
	}
	
	function getFeed($user)
	{
		$feed = "http://vega.it.rit.edu/~ajs2189/pfw/project3/RSS/";
		$v_users = mySQLDoQuery("select * from php_users");
		foreach($v_users as $key => $value)
		{
			if($value['username'] == $user)
			{
				$feed .= $value['rssFeed']; 
			}
		}
		return $feed;
	}
	
	function isValid($user)
	{
		$v_users = mySQLDoQuery("select * from php_users");
		$results = "false";
		foreach($v_users as $key => $value)
		{
			if($value['username'] == $user)
			{
				$results = "true";
			}
		}
		return $results;
	}
	
	function getStyle($user)
	{
		$v_users = mySQLDoQuery("select * from php_users");
		foreach($v_users as $key => $value)
		{
			if($value['username'] == $user)
			{
				$style .= $value['stylesheet']; 
			}
		}
		return $style;
	}
	
	function currentWeather($feed)
	{
		
		$myRSS = simplexml_load_file($feed);
		$htmlString = "<h2>".$myRSS ->channel->title."</h2>\n";
		//echo $myRSS->channel->item[0]->link;
		$htmlString .="<p style=\"position:relative; top:-200px;\"><a href=\"".$myRSS ->channel->item[0]->link."\">";
		$htmlString .=$myRSS ->channel->item[0]->title."</a><br><br>".$myRSS ->channel->item[0]->description."</p>\n";
		return $htmlString;
	}
	function displayWeather()
	{
		ini_set("soap.wsdl_cache_enabled", 0);
		$sClient = new SoapClient("http://vega.it.rit.edu/~gig/soap/weather/weatherStation.wsdl");
		$s_State = $_POST['state'];
		if(isset($_POST['city']))
		{
			$output = "<h3> Your current weather: </h3>\n";
			$response = $sClient->getStation($_POST['city']);
			$rssFeed = "http://www.weather.gov/data/current_obs/".$response.".rss";
			$output .= currentWeather($rssFeed);
		}
		else if(isset($s_State))
		{			
			$v_Cities = $sClient ->getCities($s_State);
			
			$output = "<h3> See your current weather</h3>";
			$output .= "<p>Choose a city</p>";
			$output .= "<form name=\"cityform\" action=\"".$_SERVER['PHP_SELF'] . "\" method=\"post\">\n";
			$output .="<select name=\"city\" onchange=\"cityform.submit()\">\n";
			foreach ($v_Cities as $key => $value)
			{
				$output .="<option value=\"$value\">".$value."</option>\n";
			}
			$output .="</select><br/><br/>\n";
			$output .="</form>";
		}
		
		else {
			$v_States = $sClient->getStates();
			$output = "<h3> See your current weather</h3>";
			$output .= "<p>Choose a state</p>";
			$output .= "<form name=\"stateform\" action=\"".$_SERVER['PHP_SELF'] . "\" method=\"post\">\n";
			$output .="<select name=\"state\" onchange=\"stateform.submit()\">\n";
			foreach ($v_States as $key => $value)
			{
				$output .="<option value=\"$value\">".$value."</option>\n";
			}
			$output .="</select><br/><br/>\n";
			$output .="</form>";
		}
		
		return $output;
	}
	
	function registerForm() {
		$registerForm = "<h2>New User Registration: </h2>";
		$registerForm .= "<form action=\"" . $_SERVER['PHP_SELF'] . "\" method=\"post\">\n";
		$registerForm .= "<table border=\"0\">\n";
		$registerForm .= "<tr><td><b>Choose a username:</b> <input type=\"text\" name=\"r_UserName\"><br><br></td></tr>\n";
		$registerForm .= "<tr><td><b>Choose a password:</b> <input type=\"password\" name=\"r_Password\"><br><br></td></tr>\n";
		$registerForm .= "<tr><td><b>Your email address:</b> <input type=\"text\" name=\"r_Email\"><br><br></td></tr>\n";
		$registerForm .= "<tr><td align=\"right\"><input type=\"Submit\" Value=\"Register\"></td></tr>\n";
		$registerForm .= "</table></form>";
		
		return $registerForm;		
	}
	
	function displayForm($title,$page) {
		$logInForm = "<h2>$title Log In: </h2>";
		$logInForm .= "<p>For guest access, use Username: pfw; Password: admin.</p>";
		$logInForm .= "<form action=\"index.php?page=$page\" method=\"post\">\n";
		$logInForm .= "<table border=\"0\">\n";
		$logInForm .= "<tr><td><b>Username:</b> <input type=\"text\" name=\"s_UserName\"><br><br></td></tr>\n";
		$logInForm .= "<tr><td><b>Password:</b> <input type=\"password\" name=\"t_Password\"><br><br></td></tr>\n";
		$logInForm .= "<tr><td align=\"right\"><input type=\"Submit\" Value=\"Login\"></td></tr>\n";
		$logInForm .= "</table></form>";
		return $logInForm;
		}	
	
	function callAuthentication($title,$bad,$goTo) {
		$result = "";
		$salt = "GodRocks";	
		$v_expire = time()*3600;
		$v_path = "";
		$v_domain = "php.ajsteglinski.com";
		$username = $_REQUEST['s_UserName'];
		$password = $_REQUEST['t_Password'];
		$v_secure=false;
		/*if(authenticate($_SESSION['s_UserName'],crypt($_SESSION['s_Password'],$salt))== "true")
		{
				$result = "<script type=\"text/javascript\">\n";
				$result .= "window.location = \"$goTo.php\"\n";
				$result .="</script>\n";
		}
		if($result == "")
		{
			$result = "<p>Sorry that username and password do not match our records. Please try logging in again.</p>";
			$result .= displayForm($title,$bad);
		}*/
		if(isset($_REQUEST['loginNum']))
		{
			if(authenticateByCookie($username, $_REQUEST['loginNum']) != "false")
			{
				$result = "<script type=\"text/javascript\">\n";
				$result .= "window.location = \"$goTo.php\"\n";
				$result .="</script>\n";
				//echo $goTo.".php";
			}
		}
		else if(authenticate($username,crypt($password,$salt)) == "true")
		{
			$ranNum = rand(1,100);
			setcookie("loginNum",$ranNum, $v_expire,$v_path,$v_domain,$v_secure);
			setcookie("s_UserName",$username, $v_expire,$v_path,$v_domain,$v_secure);
			writeSQL("update users set cookieNum='$ranNum' where username='$username'");
			$result = "<script type=\"text/javascript\">\n";
			$result .= "window.location = \"$goTo.php\"\n";
			$result .="</script>\n";
		}
		else if(!isset($username))
		{
			$result .= displayForm($title,$bad);
		}
		else if(authenticate($username,crypt($password,$salt)) != "true")
		{
			$result = "<p>Sorry that username and password do not match our records. Please try logging in again.</p>";
			$result .= displayForm($title,$bad);
		}
		return $result;
	}
	
	function callQuestionFunc() {

	$indexNum = $_GET['index'];				//INDEX OF THE QUESTION THEY WISH TO SEE
	settype($indexNum, "int");				//SETS THE INDEX NUMBER TO AN INTEGER
	settype($categoryIndex, "int");			//SETS THE INDEX NUMBER TO AN INTEGER
	if(isset($categoryIndex))
	{	
		$result = displayQuestion($indexNum);				//DISPLAYS THE TRIVIA QUESTION THAT THE USER PICKED
	}
	return $result;
}

function callResultsFunct() {
	$answerChoice = $_REQUEST['choices'];		//GETS THE VALUE OF THE CHOICE THAT USER PICKED
	$indexNum = $_REQUEST['index'];				//INDEX OF THE QUESTION THAT THE USER SELECTED
	$referrer = $_REQUEST['referred'];			//PAGE THAT REFERRED THE USER TO RESULTS. USED FOR ACTIVE/INACTIVE QUESTIONS
	settype($indexNum, "int");					//NEXT 2 LINES SET INDEX NUMBERS FROM THE URL TO INTEGERS
	settype($answerChoice, "int");		
	writeSQL("UPDATE trivia_answers SET numVotes = numVotes +1 WHERE answerID =$answerChoice");
	$totalVotes = readVotes($indexNum);
	$results = displayResults($answerChoice,$indexNum,$referrer);			//DISPLAYS THE RESULTS
	$results .= "<p>Total votes: ".readVotes($indexNum)."</p>";	
	
	return $results;
}

function displayBackLinks() 
{	
	$results ="<p style=\"position:absolute; top:25px; left:190px;\"><a href=\"index.php?page=admin\">Admin Login</a></p>";
	$results .="<div id='backLink'><p><a href='javascript:history.go(-1)'>Return to Previous Page</a></p>";
	$results .="<p><a href='index.php'>Return to Quiz Home</a></p>";
	$results .="</div>";
	return $results;
}
?>