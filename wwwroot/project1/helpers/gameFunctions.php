<?php
session_name('ajs2189'); 
session_start();

function findCurrentGame()
{
	if(!isset($_SESSION['s_Us3rName']))
	{
		header("Location: index.php?from=game");
	}
	else
	{
		include "../../dbInfo.inc";
		if($stmt = $mysqli->prepare("SELECT username,activeGameId FROM users WHERE activeGameId = (SELECT activeGameId FROM users WHERE username = ?)"))
		{
			$stmt->bind_param('s',$_SESSION['s_Us3rName']);
			$data = returnAssArray($stmt);
			$stmt->close();
		}
		$_SESSION['g@meId'] = $data[0]['activeGameId'];
		//echo "game: ".$_SESSION['s_Us3rName'];
		$_SESSION['pl@yerId'] = $_SESSION['s_Us3rName'];
		$_SESSION[$_SESSION['pl@yerId']."_deckClicked"] = "false";
		for($i =0; $i < count($data); $i++)
		{
			$_SESSION['pl@yer'.($i+1)] = $data[$i]['username'];
		}
	}
}

	function showObject($pOneObject, $label="object or variable") {
		$results = "<hr><pre>\n";
		$results .= "Value displayed: $label \n";
		$results .= print_r($pOneObject,true); //second arg enables to return string
		$results .= "</pre>\n";
		return $results;
	}
//DEAL PLAYERS HAND FROM THE DATABASE
function checkForCurrentGame($player)
{
	include "../../../dbInfo.inc";
	if($stmt = $mysqli->prepare("SELECT handList FROM 546_player WHERE user = '$player'"))
	{
		$data = returnAssArray($stmt);
		//$data = json_encode($data);
		$stmt->close();
	}
	if($data != null && $data[0]['handList'] != null) return json_encode($data);
	else return null;
}

function addPlayer($player)
{	
	include "../../dbInfo.inc";
	if($stmt = $mysqli->prepare("INSERT INTO 546_player (`playerID`, `currentPoints`, `user`, `handList`) VALUES (NULL, '0', ?, NULL);"))
	{
		$stmt->bind_param('s',$player);
		$stmt->execute();
		$stmt->close();
	}
	$_SESSION[$player.'added'] = "true";
}

//MAKE THE DISCARD FROM THE DATABASE
function dealDiscard($game,$me)
{
	include "../../dbInfo.inc";
	//echo $gameId;
	if($stmt = $mysqli->prepare("SELECT inDiscard,turn FROM 546_game WHERE gameID = ?"))
	{
		$stmt->bind_param('i',$game);
		$data = returnAssArray($stmt);
		$stmt->close();
	}
	
	//FIGURE OUT WHOSE TURN IT IS
	for($i = 1; $i < 4; $i++)
	{
		if($data[0]['turn'] == $_SESSION['pl@yer'.$i])
		{
			$_SESSION['turnInt'] = $i;
			$_SESSION[$me."_UpdatedTurn"] = "false";
		}
	}
	return json_encode($data);
	//return $data;
}

//PUT CARDS ON THE TABLE BASED ON WHAT IS IN THE DATABASE
function dealTable($game)
{
	include "../../dbInfo.inc";
	//echo $gameId;
	if($stmt = $mysqli->prepare("SELECT onTable FROM 546_game WHERE gameID = ?"))
	{
		$stmt->bind_param('i',$game);
		$data = returnAssArray($stmt);
		$stmt->close();
	}
	return json_encode($data);
	//return $data;
}
?>