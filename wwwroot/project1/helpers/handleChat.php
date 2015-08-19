<?php
	include "../../../dbInfo.inc";
	include "commHelpers.php";
	include "../tools.php";
	session_name('ajs2189'); 
	session_start();
	
	if(!isset($_GET['action']))
	{
		if(isset($_GET['what']))
		{
			if($stmt = $mysqli->prepare("INSERT into 546_chat values ('',?,?,'".date("h:i:s")."')"))
			{
				$stmt->bind_param("ss",$_GET['what'],$_GET['who']);
				$stmt->execute();
				$stmt->close();
			}
		}
		
		if($stmt = $mysqli->prepare("SELECT message,user,timestamp FROM 546_chat"))
		{
			$data = returnAssArray($stmt);
			//$data = json_encode($data);
			$stmt->close();
		}
		
		
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
		//this line MUST be here, it declares the content-type
		header('Content-Type: text/plain'); 
		//$x = json_encode(array('chatData'=>$data,'activeUsers'=>$userData)); // This will become the response value for the XMLHttpRequest object
		//$y = json_decode($x);
		//echo($x);
		echo json_encode($data);
	}
	if($_GET['action'] == "challenge")
	{
		if($stmt = $mysqli->prepare("SELECT activeGameId FROM users WHERE username = ?"))
		{
			$stmt->bind_param("s",$_SESSION['s_Us3rName']);
			$data = returnAssArray($stmt);
			if($data[0]['activeGameId'] == null) $data = "";
			//$data = json_encode($data);
			$stmt->close();
			if($data != "") echo json_encode($data);
			else echo $data;
		}
	}
?>







