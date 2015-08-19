<?php
    session_name('ajs2189'); 
	session_start();
	if($_GET['action'] == "new")
	{
		include "../../dbInfo.inc";
		$gameId = rand(10,999);
		
		$_SESSION['pl@yer1'] = $_GET['player1'];
		$_SESSION['pl@yer2'] = $_GET['player2'];
		$_SESSION['pl@yer3'] = $_GET['player3'];
		$_SESSION['pl@yer4'] = $_GET['player4'];
		
		if($stmt = $mysqli->prepare("INSERT INTO 546_playerlist (`listID`, `player1`, `player2`, `player3`, `player4`, `gameId`) VALUES (NULL, '', NULL, NULL, NULL, $gameId);"))
		{
			$stmt->execute();
			$stmt->close();
		}
		if($stmt = $mysqli->prepare("INSERT INTO 546_game (`gameID`, `listID`, `inDiscard`, `onTable`,`turn`,`winner`) VALUES (?, (SELECT listID from 546_playerlist where gameId = ?), '', '',?,'None');"))
		{
			$stmt->bind_param('iis',$gameId,$gameId,$_SESSION['pl@yer1']);
			$stmt->execute();
			$stmt->close();
		}
		for($i = 1; isset($_SESSION['pl@yer'.$i]); $i++)
		{
			if($stmt = $mysqli->prepare("UPDATE users SET activeGameId = ? WHERE username = ?"))
			{
				$stmt->bind_param('is',$gameId,$_SESSION['pl@yer'.$i]);
				$stmt->execute();
				$stmt->close();
			}
		}
	}
	//header("Location: game.php");
?>