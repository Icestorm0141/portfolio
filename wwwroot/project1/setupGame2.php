<?php
    session_name('ajs2189'); 
	session_start();
	
	include "../../dbInfo.inc";
	$gameId = rand(10,999);
	
	$_SESSION['pl@yer1'] = "ajs2189";
	$_SESSION['pl@yer2'] = "pfw";
	$_SESSION['pl@yer3'] = "IEUser";
	$_SESSION['pl@yer4'] = "testChrome";
	
	if($stmt = $mysqli->prepare("INSERT INTO 546_playerlist (`listID`, `player1`, `player2`, `player3`, `player4`, `gameId`) VALUES (NULL, '', NULL, NULL, NULL, $gameId);"))
	{
		$stmt->execute();
		$stmt->close();
	}
	if($stmt = $mysqli->prepare("INSERT INTO 546_game (`gameID`, `listID`, `inDiscard`, `onTable`,`turn`) VALUES (?, (SELECT listID from 546_playerlist where gameId = ?), '', '',?);"))
	{
		$stmt->bind_param('iis',$gameId,$gameId,$_SESSION['pl@yer1']);
		$stmt->execute();
		$stmt->close();
	}
	
	$_SESSION['g@meId'] = $gameId;
	$_SESSION['pl@yerId'] = "ajs2189";
	$_SESSION[$_SESSION['pl@yerId']."_deckClicked"] = "false";
	header("Location: game.php");
?>