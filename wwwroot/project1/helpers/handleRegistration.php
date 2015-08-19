<?php
	include "../../../dbInfo.inc";
	//INSERT INTO `ajs2189`.`users` (`username`, `password`, `email`, `adminPriv`, `loggedIn`, `cookieNum`, `securityToken`) VALUES ('test', 'GoszLZnpVFPds', 'ajs2189@rit.edu', 'false', '0', '0', '');
	if($stmt = $mysqli->prepare("INSERT INTO users (username ,password ,email ,loggedIn ,securityToken,gamesWon,activeGameId) VALUES (?, ?, ?, '0', '',0,NULL);"))
	{
		$stmt->bind_param('sss',$_GET['un'],crypt($_GET['pw'],"GodRocks"),$_GET['email']);
		$stmt->execute();
		//$data = json_encode($data);
		$stmt->close();
	}
?>







