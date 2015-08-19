<?php

	function showObject($pOneObject, $label="object or variable") {
		$results = "<hr><pre>\n";
		$results .= "Value displayed: $label \n";
		$results .= print_r($pOneObject,true); //second arg enables to return string
		$results .= "</pre>\n";
		return $results;
	}
	function displayForm() 
	{
		include "includes/loginForm.php";
	}
	
	function displayChat()
	{
		include "forward.php";
	}
	
	function isValid($user)
	{
		include "../../dbInfo.inc";
		if($stmt = $mysqli->prepare("SELECT * FROM users"))
		{
			$stmt->bind_param("ss",$username,$password);
			$data = returnAssArray($stmt);
			$stmt->close();
			if($data[0]['username'] == $username)
			{
				$results = "true";
			}
		}
		return $results;
	}
	
	
	
?>