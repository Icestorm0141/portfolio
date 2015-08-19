<?php
	/*
	Purpose: represent a variable or object as a text string
	Input: variable or object
	Output: String
	*/
	function showObject($pOneObject, $label="object or variable") {
		$results = "<hr><pre>\n";
		$results .= "Value displayed: $label \n";
		$results .= print_r($pOneObject,true); //second arg enables to return string
		$results .= "</pre>\n";
		return $results;
	}	
function parseRSS($feed)
{
	
	$myRSS = simplexml_load_file($feed);
	$htmlString = "<h3>".$myRSS ->channel->title."</h3>\n";
	for($index = 1; $index<=3; $index++)
	{
		$htmlString .="<p><a href=\"".$myRSS ->channel->item[$index]->link."\">";
		$htmlString .=$myRSS ->channel->item[$index]->title."</a><br><br>".$myRSS ->channel->item[$index]->description."</p>\n";
	}
	
	return $htmlString;
}
	
	function logout($sendTo)
	{
		$v_expire = time()-36000;
		$v_path = "";
		$v_domain = "php.ajsteglinski.com";
		$v_secure=false;
		setcookie("loginNum","", $v_expire,$v_path,$v_domain,$v_secure);
		setcookie("s_UserName","", $v_expire,$v_path,$v_domain,$v_secure);
		header("Location: index.php");
	}
	
	function mySQLDoQuery($query)
	{
		$v_dbLink = mysql_connect("localhost","ajs2189","E54952kg4g");
		if($v_dbLink)
		{
			mysql_select_db("school");
			$v_TheQuery = $query;
			$v_TheResult = mysql_query($v_TheQuery);			
			if ($v_TheResult) 
			{
				while ($v_row = mysql_fetch_array ($v_TheResult, MYSQL_ASSOC)) 
				{
					$v_records[] = $v_row;
				}
			}
		}
		mysql_close($v_dbLink);
		//echo(showObject($v_records));
		return $v_records;
	}
	
	function authenticate($username,$password)
	{
		$results = "false";
		$v_records = mySQLDoQuery("select * from php_users");
		foreach ($v_records as $key => $v_CurrentRecord) 
		{
			if($v_CurrentRecord['username'] == $username && $v_CurrentRecord['password'] == $password)
			{
				$result = "true";
			}
		}
		return $result;
	}
	
	function authenticateByCookie($username,$cookie)
	{
		$results = "false";
		$v_records = mySQLDoQuery("select cookieNum from php_users");
		foreach ($v_records as $key => $v_CurrentRecord) 
		{
			if($v_CurrentRecord['cookieNum'] == $cookie && $v_CurrentRecord['username'] == $username);
			{
				$result = $v_CurrentRecord['username'];
			}
		}
		return $result;
	}
	
	function isUnique($username)
	{
		$result = "true";
		$v_records = mySQLDoQuery("select * from php_users");
		foreach ($v_records as $v_CurrentRecord) 
		{
			if($v_CurrentRecord['username'] == $username)
			{
				$result = "false";
			}
		}
		return $result;
	}
	
	/*Purpose: to load in an XML file
	Input: Filename
	Output: Simplexml object
	*/
	function loadXML($fileName)
	{
		$results = "";
		if(is_readable($fileName))
		{
			$xmlObject = simplexml_load_file($fileName);
			$results = $xmlObject;
		}
		return $results;
	}
	/*
	Purpose: To write a string of XML into a file
	Input: An XML String, Path to the file being written to (String)
	Output: Boolean. True of successfully written to file, false if unsuccessful
	*/
	function writeXML($xmlString,$filePath)
	{
		$success = "false";
		$fh = fopen($filePath,"w");
		flock($fh,LOCK_EX);
		if ($fh)
		{
			fwrite($fh,$xmlString);
			$success = "true";
		}
		else 
		{
			echo "Cannot write to the file";
		}
		flock($fh,LOCK_UN);
		fclose($fh);
		
		return $success;
	}
	
	function writeSQL($query)
	{
		$success = "false";
		$v_dbLink = mysql_connect("localhost","ajs2189","E54952kg4g");
		if($v_dbLink)
		{
			mysql_select_db("school");
			$v_TheQuery = $query;
			$v_TheResult = mysql_query($v_TheQuery);
			$success = "true";	
		}
		mysql_close($v_dbLink);
		return $success;	
	}
	
	/*
	Purpose: To position navigation images dynamically across the page in some sort of line
	Input: 	Number of files to position (Int.), X position to start at (Int.), Y position to start at (Int.),
			horizontal space between the images (Int.), vertical space between the images (Int.), 
			Path to the images without the filename (String)
	Output: String, HTML string to display the images with the positions in inline CSS.
	*/
	function positionNav($numFiles,$startX,$startY,$xSpace,$ySpace,$imageRoot)
	{
		$results = "";
		
		for($control=1; $control<=$numFiles; $control++)
		{
			$results .= "<img src='images/".($imageRoot.$control).".png' class='nav' style='top:".($startY+$control*$ySpace)."px; left:".($startX+$control*$xSpace)."px;' alt='Nav$control' />";
		}
		
		return $results;
	}
?>