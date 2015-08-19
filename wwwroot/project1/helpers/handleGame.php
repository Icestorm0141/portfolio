<?php
	session_name('ajs2189'); 
	session_start();
	include "../../../dbInfo.inc";
	include "commHelpers.php";
	include "gameFunctions.php";

	//NOW WE SET UP THE INDIVIDUAL PLAYERS AND THEIR HANDS
	if(isset($_GET['color1']))
	{	
		if($stmt = $mysqli->prepare("UPDATE 546_player SET handList = (SELECT GROUP_CONCAT(cardID) from 546_cards where (value = ? AND color = ?) OR (value = ? AND color = ?) OR (value = ? AND color = ?) OR (value = ? AND color = ?) OR (value = ? AND color = ?) OR (value = ? AND color = ?) OR (value = ? AND color = ?)) WHERE user = ?"))
		{
			$stmt->bind_param('sssssssssssssss',$_GET['value1'],$_GET['color1'],$_GET['value2'],$_GET['color2'],$_GET['value3'],$_GET['color3'],$_GET['value4'],$_GET['color4'],$_GET['value5'],$_GET['color5'],$_GET['value6'],$_GET['color6'],$_GET['value7'],$_GET['color7'],$_GET['user']);
			$stmt->execute();
			$stmt->close();
		}
	}
	
	//SET UP THE PLAYER LISTS NOW THAT THE PLAYERS ARE ALL SET
	if(isset($_GET['player1']))
	{
		$player = "player1";
	} 
	else if(isset($_GET['player2']))
	{
		$player = "player2";
	} 
	else if(isset($_GET['player3']))
	{
		$player = "player3";
	} 
	else if(isset($_GET['player4']))
	{
		$player = "player4";
	}
	if(isset($player))				
	{
		
		if($stmt = $mysqli->prepare("UPDATE 546_playerlist SET $player = (SELECT playerID from 546_player WHERE user = ?) WHERE gameId = ?;"))
		{
			$stmt->bind_param('si',$_GET[$player],$_GET['gameId']);
			$stmt->execute();
			$stmt->close();
		}
	}
	
	// ADD A CARD TO THE USERS HAND BY APPENDING IT TO THE END OF THE LIST
	if(isset($_GET['color']))	
	{
		if($_GET['from'] == "deck")
		{
			$_SESSION[$_GET['user']."_deckClicked"] = "true";
		}
		if($stmt = $mysqli->prepare("UPDATE 546_player SET handList = CONCAT(handList, CONCAT(',',(SELECT cardId FROM 546_cards WHERE color = ? AND value = ?))) WHERE user = ?;"))
		{
			$stmt->bind_param('sss',$_GET['color'],$_GET['value'],$_GET['user']);
			$stmt->execute();
			$stmt->close();
		}
	}
	
	// REMOVE A CARD FROM USERS LIST OF CARDS
		//*****NOTE: THE SQL STATEMENT BELOW WAS FOUND ON GOOGLE AT http://dev.mysql.com/doc/refman/5.0/en/string-functions.html
		//***** DO A FIND ON THE WORDS 'my formula'
	if(isset($_GET['sendTo']))	
	{
		if($_GET['sendTo'] == 'user')
		{
			$table = "546_game";
			$column = "inDiscard";
			$where = "gameID";
			$bindTo = $_GET['gameId'];
			$toReturn[0] = $_SESSION['turnUsers'];
			$toReturn[1] = "readyToDiscard()";
		}
		else 
		{ 
			$table = "546_player"; 
			$column = "handList"; 
			$where = "user"; 
			$bindTo = $_GET['user'];
		}
		if($stmt = $mysqli->prepare("UPDATE $table SET $column = TRIM(BOTH ',' FROM REPLACE(CONCAT(',' , $column, ','), CONCAT(',',(SELECT cardId FROM 546_cards WHERE color = ? AND value = ?), ',') , ',')) WHERE $where = ?"))
		{
			$stmt->bind_param('sss',$_GET['removeColor'],$_GET['removeValue'],$bindTo);
			$stmt->execute();
			$stmt->close();
		}
		
		if($_GET['sendTo'] == "discard")
		{
			$col = "inDiscard";
			
			//DEAL WITH CHANGING THE TURN NOW
			$turnInt = $_SESSION['turnInt'] +1;
			$toReturn[0] = "before ".$turnInt;
			if($turnInt > 2) $turnInt = 1;
			$_SESSION['turnUser'] = $_SESSION["pl@yer".$turnInt];
			$_SESSION['turnInt'] = $turnInt;
			///$toReturn[0] .= "turn".$_SESSION['turnUser'].$_SESSION['turnInt'].$_SESSION['pl@yer'.$turnInt];
			
			if($_SESSION['turnUser'] != $_GET['myId'])
			{
				$toReturn[1] = "changeTurn()";
			}
		}
		else if($_GET['sendTo'] == 'table')
		{
			$col = "onTable";
			$toReturn[0] = $_SESSION['turnUser'];
			switch($_GET['removeValue'])
			{
				case "K":
				case "Q":
				case "J":
				case "10": 
					$pointValue = 10;
					break;
				case "A":
					$pointValue = 15;
					break;
				default:
					$pointValue = 5;
					break;
			}
			if($stmt = $mysqli->prepare("UPDATE 546_player SET currentPoints = currentPoints + ? WHERE user = ?"))
			{
				$stmt->bind_param('is',$pointValue,$_SESSION['turnUser']);
				$stmt->execute();
				$stmt->close();
			}
		}
		if(isset($col))
		{
				$query = "UPDATE 546_game SET $col = CONCAT($col, CONCAT(',',(SELECT cardId FROM 546_cards WHERE color = ? AND value = ?))), turn = ? WHERE gameID = ?;";
			
			if($stmt = $mysqli->prepare($query))
			{
				$stmt->bind_param('ssss',$_GET['removeColor'],$_GET['removeValue'],$_SESSION['turnUser'],$_GET['gameId']);
				$stmt->execute();
				$stmt->close();
			}
		}
		if(isset($toReturn)) echo json_encode($toReturn);
	}
	
	//WE'RE GOING TO CHECK FOR RECENT UPDATES, LOOKING FOR:
	//	--inDiscard
	//	--onTable
	//	--each player's hand
	//	--turn
	if($_GET['request'] == "update")
	{
		$data = "";
		for($i = 1; $i < 5; $i++)
		{
			if(isset($_GET['user'.$i]))
			{
				if($stmt = $mysqli->prepare("SELECT handList,user,currentPoints FROM 546_player WHERE user = ?"))
				{
					$stmt->bind_param('s',$_GET['user'.$i]);
					$data[0][] = returnAssArray($stmt);
					$stmt->close();
				}
			}
			else
			{
				$data[0][] = null;
			}
		}
		if($stmt = $mysqli->prepare("SELECT inDiscard,onTable,turn,winner FROM 546_game WHERE gameID = ?"))
		{
			$stmt->bind_param('s',$_GET['gameId']);
			$data[1][] = returnAssArray($stmt);
			$stmt->close();
		}
		//SYNC TURN
		$_SESSION['turnUser'] = $data[1][0][0]['turn'];
		
		//SYNCING TURN INTS
		for($i = 1; $i < 4; $i++)
		{
			if($_SESSION['turnUser'] == $_SESSION['pl@yer'.$i])
			{
				$_SESSION['turnInt'] = $i;
			}
		}
		//ENABLING EVERYTHING IF IT JUST BECAME MY TURN
		if($_SESSION['turnUser'] == $_GET['myId'] && $_SESSION[$_GET['myId'].'_UpdatedTurn'] == "false")
		{
			$data[2][] = "$('#handContainer').sortable('enable');";
			$data[2][] .= "$('#table').sortable('enable')";
			$data[2][] .= "$('#discard').sortable('enable')";
			$data[2][] .= "$('#deck').parent().bind('click',deckClick);";
			$_SESSION[$_GET['myId'].'_UpdatedTurn'] = "true";
			if($_SESSION[$_GET['myId']."_deckClicked"] != "false")
			{
				$data[2][] .= "readyToDiscard()";
			}
		} 
		//IF IT ISNT MY TURN, KEEP EVERYTHING DISABLED
		else if($_SESSION['turnUser'] != $_GET['myId'])
		{
			$data[2][] = "changeTurn()";
			$_SESSION[$_GET['myId'].'_UpdatedTurn'] = "false";
			$_SESSION[$_GET['myId'].'_deckClicked'] = "false";
		}
		
		if(isset($data)) echo json_encode($data);
	}
	else if($_GET['request'] == "users")
	{
		for($i = 1; $i < 5; $i++)
		{
			if(isset($_GET['user'.$i]))
			{
				$player = 'player'.$i;
				if($stmt = $mysqli->prepare("SELECT handList, user FROM 546_player where user = ?"))
				{
					$stmt->bind_param('s',$_GET['user'.$i]);
					$userData[0][] = returnAssArray($stmt);
					$stmt->close();
				}
			}
			else
			{
				$userdata[0][] = null;
			}
		}
		$me = $_GET['me'];
		$action = checkForCurrentGame($me);
		if($action != null) 
		{
			$userData[1][] = "redealCards($action,\"$me\",null);";
		} else $userData[1][] = "playerArray[playerId].buildQueries();";
		if(isset($userData)) echo json_encode($userData);
	}
	if($_GET['action'] == "end")
	{
		if($stmt = $mysqli->prepare("UPDATE 546_game SET winner = ?"))
		{
			$stmt->bind_param('s',$_SESSION['pl@yerId']);
			$stmt->execute();
			$stmt->close();
		}
		if($stmt = $mysqli->prepare("UPDATE users SET gamesWon = gamesWon+1 WHERE username = ?"))
		{
			$stmt->bind_param('s',$_SESSION['pl@yerId']);
			$stmt->execute();
			$stmt->close();
		}
	}
	if($_GET['action'] == "restart")
	{
		for($i = 1; isset($_SESSION['pl@yer'.$i]); $i++)
		{
			if($stmt = $mysqli->prepare("DELETE FROM 546_player WHERE playerID = (SELECT player".$i." FROM 546_playerlist WHERE gameID = ?)"))
			{
				$stmt->bind_param('s',$_GET['gameId']);
				$stmt->execute();
				$stmt->close();
			}
		}
		if($stmt = $mysqli->prepare("DELETE FROM 546_game WHERE gameID = ?"))
		{
			$stmt->bind_param('s',$_GET['gameId']);
			$stmt->execute();
			$stmt->close();
		}
		if($stmt = $mysqli->prepare("DELETE FROM 546_playerlist WHERE gameID = ?"))
		{
			$stmt->bind_param('s',$_GET['gameId']);
			$stmt->execute();
			$stmt->close();
		}
		if($stmt = $mysqli->prepare("UPDATE users SET activeGameId = NULL WHERE username=?"))
		{
			$stmt->bind_param('s',$_GET['who']);
			$stmt->execute();
			$stmt->close();
		}
		
	}
?>