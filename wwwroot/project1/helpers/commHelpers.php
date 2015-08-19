<?php

	session_name('ajs2189'); 
	session_start();
function makeToken($user){
	//uniqid - Gets a prefixed unique identifier based on the current time in microseconds.
	return base64_encode(uniqid($user.'_', true));
}

function destroyToken($secToken){
	include "../../../dbInfo.inc";

	if($stmt = $mysqli->prepare("UPDATE users set securityToken='', loggedIn='0' where securityToken=?")){
			$stmt->bind_param("s",$secToken);
			$stmt->execute();
			$stmt->close();	
	 }
}

function createHash($inText, $saltHash=NULL, $mode='sha1'){ 
	// hash the text // 
	$textHash = hash($mode, $inText); 
	// set where salt will appear in hash // 
	$saltStart = strlen($inText); 
	// if no salt given create random one // 
	if($saltHash == NULL) { 
		$saltHash = hash($mode, uniqid(rand(), true)); 
	} 
	// add salt into text hash at pass length position and hash it // 
	if($saltStart > 0 && $saltStart < strlen($saltHash)) { 
		$textHashStart = substr($textHash,0,$saltStart); 
		$textHashEnd = substr($textHash,$saltStart,strlen($saltHash)); 
		$outHash = hash($mode, $textHashEnd.$saltHash.$textHashStart); 
	} elseif($saltStart > (strlen($saltHash)-1)) { 
		$outHash = hash($mode, $textHash.$saltHash); 
	} else { 
		$outHash = hash($mode, $saltHash.$textHash); 
	} 
	// put salt at front of hash // 
	$output = $saltHash.$outHash; 
	return $output; 
} 
function returnAssArray ($stmt){
	$stmt->execute();
	$stmt->store_result();
 	$meta = $stmt->result_metadata();
    $bindVarsArray = array();
    
	//using the stmt, get it's metadata (so we can get the name of the name=val pair for the associate array)!
	while ($column = $meta->fetch_field()) {
    	$bindVarsArray[] = &$results[$column->name];
    }

	//bind it!
	call_user_func_array(array($stmt, 'bind_result'), $bindVarsArray);

	//now, go through each row returned,
	while($stmt->fetch()) {
    	$clone = array();
        foreach ($results as $k => $v) {
        	$clone[$k] = $v;
        }
        $data[] = $clone;
    }
	return $data;
    //return json_encode($data);
}


	function authenticate($username,$password)
	{
		include "../../dbInfo.inc";
		$results = "false";
		if($stmt = $mysqli->prepare("SELECT username,password FROM users where username = ? and password = ?"))
		{
			$stmt->bind_param("ss",$username,$password);
			$data = returnAssArray($stmt);
			$stmt->close();
			if($data[0]['username'] == $username && $data[0]['password'] == $password)
			{
				$results = "true";
			}
		}
		else
		{
			$results = "false";
		}
		return $results;
	}
	
	function authenticateByCookie($username,$cookie)
	{
		include "../../dbInfo.inc";
		$results = "false";
		
		if($stmt = $mysqli->prepare("SELECT securityToken FROM users"))
		{
			$data = returnAssArray($stmt);
			$stmt->close();
			if($v_CurrentRecord[0]['securityToken'] == $cookie && $v_CurrentRecord[0]['username'] == $username);
			{
				$results = $v_CurrentRecord['username'];
			}
		}
		echo $results;
		return $results;
	}
	
	function callAuthentication($title,$bad,$goTo) 
	{
		$results = "";
		$salt = "GodRocks";	
		$username = $_REQUEST['b_UserName'];
		$password = $_REQUEST['b_Password'];
		$v_secure=false;

		if(isset($_SESSION['token']))
		{
			//echo "in here";
			if(authenticateByCookie($username, $_SESSION['token']) != "false")
			{
				$results = "true";
			}
		}
		else
		{
			$authenticated = authenticate($username,crypt($password,$salt));
			if($authenticated == "true")
			{
				include "../../dbInfo.inc";
				$ranNum = rand(1,100);
				$token = makeToken($username);
				if($stmt=$mysqli->prepare("UPDATE users SET securityToken=? WHERE username=?"))
				{
					$stmt->bind_param("ss",$token,$username);
					$stmt->execute();
					$stmt->close();
				}
				if($stmt = $mysqli->prepare("UPDATE users SET loggedIn = '1',activeGameId = NULL WHERE username = ?"))
				{
					$stmt->bind_param("s",$username);
					$stmt->execute();
					$stmt->close();
				}
				$_SESSION['token'] = $token;
				$_SESSION['s_Us3rName'] = $username;
				$results = "true";
			}
			else if(!isset($username))
			{
				$results = "false";
			}
			else if($authenticated != "true")
			{
				$results = "<p>Sorry that username and password do not match our records. Please try logging in again.</p>";
			}
		}
		return $results;
	}
?>