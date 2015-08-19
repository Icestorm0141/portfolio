<?php
include "dbInfo.inc";
include "scripts/commHelpers.php";	
session_name('ecoTheory'); 
//session_start();


if(isset($_GET['action']))
{
	if($_GET['action'] == "new")
	{
		if($stmt = $mysqli->prepare("INSERT INTO Player (firstName,lastName,gamerTag,production,roleID) values(?,?,?,NULL,?)"))
		{
			$stmt->bind_param("ssss",$_GET['first'],$_GET['last'],$_GET['tag'],$_GET['role']);
			//DUH - ONLY CALL WHEN RETURNING VALUES FROM DB
			//$data = returnAssArray($stmt);
			$stmt->execute();
			$stmt->close();
			$_SESSION['gamerT@g'] = $_GET['tag'];
		}
	}
	if($_GET['action'] == "prod")
	{
		if($stmt = $mysqli->prepare("UPDATE Player set production = ? where gamerTag = ?"))
		{
			$stmt->bind_param("ss",$_GET['amt'],$_GET['tag']);
			//DUH - ONLY CALL WHEN RETURNING VALUES FROM DB
			//$data = returnAssArray($stmt);
			$stmt->execute();
			$stmt->close();
		}
	}
	if($_GET['action'] == "update")
	{
		if($stmt = $mysqli->prepare("SELECT DATA HERE JOIN ON ROLENAME"))
		{
			$stmt->bind_param("s",$_GET['role']);
			$data = returnAssArray($stmt);
			$stmt->close();
		}
		//DO MATH HERE
		//$data[i]['production'] 		//example of how to grab production value
		$dataArray = array("total"=>$totalval);
		//loop through players and say:
		//$dataArray[i] = $playertotal;
		
			header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
			header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
			header("Cache-Control: no-store, no-cache, must-revalidate");
			header("Cache-Control: post-check=0, pre-check=0", false);
			header("Pragma: no-cache");
			//MUST change the content-type
			header("Content-Type:text/plain");
			// This will become the response value for the XMLHttpRequest object

			// Need to fix this last line. Errors out when running action=new
			//echo (json_encode($dataArray);

	}
}
?>