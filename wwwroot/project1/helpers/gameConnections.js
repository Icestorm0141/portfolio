// JavaScript Document
function newPlayer(handstring)
{
	var queryString = "helpers/handleGame.php?gameId="+gameId + handstring;
	myHttp = new HttpClient('GET',true,false,'text');
	myHttp.makeRequest(queryString);
	myHttp.callback = function()
	{
	}
}
function addPlayerToList(playerString)
{
	var  playerQString = "helpers/handleGame.php?gameId="+ gameId + playerString;
	myHttp = new HttpClient('GET',true,false,'text');
	myHttp.makeRequest(playerQString);
	myHttp.callback = function()
	{
	}
}
function addCardToHand(cardString)
{
	var  cardQString = "helpers/handleGame.php?"+cardString;
	myHttp = new HttpClient('GET',true,false,'text');
	myHttp.makeRequest(cardQString);
	myHttp.callback = function()
	{/*
		if(jsonText != null)
		{
			var obj = eval(jsonText);
			eval(obj[0]);
		}*/
	}
}
function changeLocation(cardString,toLoc)
{
	var  cardQString = "helpers/handleGame.php?sendTo="+toLoc+ "&gameId="+gameId+"&"+cardString;
	myHttp = new HttpClient('GET',true,false,'text');
	myHttp.makeRequest(cardQString);
	myHttp.callback = function(jsonText)
	{
		if(jsonText != null)
		{
			var obj = eval(jsonText);
			turn = obj[0];
			if(obj[1] != null) eval(obj[1]);
		}
	}
}
function checkForUsers()
{
	var requestString = "helpers/handleGame.php?request=users&gameId="+gameId + "&me=" + playerId;
	var index = 1;
	for(var i in playerArray)
	{
		//alert(playerArray[i].hand);
		if((playerArray[i].hand.length == 0 || playerArray[i].hand == "" || playerArray[i].hand == null) && i != playerId)
		{
			requestString +="&user"+index+"="+i;
		}
		index++;
	}
	
	myHttp = new HttpClient('GET',true,false,'text');
	myHttp.makeRequest(requestString);
	myHttp.callback = function(jsonText)
	{
		var handEval = "";
		if(jsonText != null)
		{
			var obj = eval(jsonText);
			for(var i in obj)
			{
				if(obj[0][i] != null)
				{
					var handList = obj[0][i][0]['handList'];
					var user = obj[0][i][0]['user'];
					redealCards(null,user,handList);
				}
			}
			handEval = obj[1][0];
		}
		
		dealHand();
		eval(handEval);
		playerArray[playerId].showHand();
		
	}
	
}
function checkForWin()
{
	var result = false;
	for(var i in playerArray)
	{
		if(playerArray[i].id != "" && playerArray[i].isReady == true)
		{
			if(playerArray[i].getNumCards() == 0 || $('#handContainer').children().length == 0)
			{
				result = true;
			}
		}
	}
	return result;
}

function checkForUpdates()
{
	var requestPlayerString = "helpers/handleGame.php?request=update&gameId="+gameId+"&myId="+playerId;
	var index = 1;
	for(var i in playerArray)
	{
		if(i != ""/* && i != playerId*/)
		{
			requestPlayerString +="&user"+index+"="+i;
		}
		index++;
	}
	
	myHttp = new HttpClient('GET',true,false,'text');
	myHttp.makeRequest(requestPlayerString);
	myHttp.callback = function(jsonText)
	{
		var winner = "";
		if(jsonText != null)
		{
			var obj = eval(jsonText);
			for(var i in obj[0])
			{
				if(obj[0][i] != null)
				{
					var handList = obj[0][i][0]['handList'];
					var user = obj[0][i][0]['user'];
					if(user != playerId)
					{
						redealCards(null,user,handList);
					}
					if(handList != null) playerArray[user].isReady = true;
					updateScore(user, obj[0][i][0]['currentPoints']);
				}
			}
			for(var i in obj[1])
			{
				if(obj[1][i] != null && obj[1][i] != "")
				{
					var newDiscard = obj[1][i][0]['inDiscard'];
					var newTable = obj[1][i][0]['onTable'];
					
					if(obj[1][i][0]['winner'] != "None")
					{
						winner = obj[1][i][0]['winner'];
					}
					//var newTurn = obj[1][i][0]['turn'];
					makeDiscardPile(null,newDiscard);
					makeTable(null,newTable);
					//changeTurn();
					//turn = newTurn;
				}
			}
			for(var i in obj[2])
			{
				eval(obj[2][i]);
			}
			$('#gameStatus').html("It is " + obj[1][0][0]['turn'] + ", player " + playerArray[obj[1][0][0]['turn']].playerNum + "'s, turn.");
			for(var i = 0; i < backCards.length-1; i++)
			{
				var player = eval("player"+(i+1));
				playerArray[player.id] = player;
				if(player.id != playerId)
				{
					backCards[i].updateCardTotal(playerArray[player.id].getNumCards());
				}
			}
		}
		var win = checkForWin();
		if(win == true || winner != "")
		{
			var winnerText = "Sorry, you lost. " + winner + " won this game.";
			if(win == true)
			{
				sendWin();
				winnerText = "CONGRATULATIONS! You won the game!";
			}
			displayWin(winnerText);
		} else 
		{
			setTimeout("checkForUpdates()",3000);
		}
	}
}
function sendWin()
{
	var  queryString = "helpers/handleGame.php?gameId="+ gameId + "&action=end";
	myHttp = new HttpClient('GET',true,false,'text');
	myHttp.makeRequest(queryString);
	myHttp.callback = function()
	{
	}
}
function endGame()
{
	var  queryString = "helpers/handleGame.php?gameId="+ gameId + "&action=restart&who="+playerId;
	myHttp = new HttpClient('GET',true,false,'text');
	myHttp.makeRequest(queryString);
	myHttp.callback = function()
	{
		window.location = "index.php";
	}
}
function displayWin(text)
{
	$('#container').appendDom([{
		tagName: 'div',
		id: 'disableDiv'
							   }]);
	$('#container').appendDom([{
      tagName : 'div',		//OUTER DIV
	  id: 'gameWinner',
	  childNodes : [{
			tagName: 'h4',
			innerHTML: text//TITLE
		},{
			tagName: 'a',
			id: 'endGame',		//CLOSE LINK
			href: '#',
			onclick : function() { endGame(); },
			innerHTML: 'End Game'
		}]
	  }]);
}