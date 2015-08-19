var svgns = "http://www.w3.org/2000/svg";

var cardValues = new Array("A","2","3","4","5","6","7","8","9","10","J","Q","K");
var cardColors = new Array("red","yellow","green","blue");
var playerArray = new Array(4);	//ARRAY OF PLAYERS
var backCards = new Array();	//ARRAY OF OPPONENTS CARDS
var deckArray = new Array();	//ARRAY OF CARDS IN THE DECK
var tableConnect = new Array(53);
var inDiscard;
var GAMEX = 20;
var GAMEY = 40;

function init()
{
	//get the gameContainer DIV, swap the ID & offset it
	$('#gameContainer').attr({id:'game_'+gameId, class : 'game',style: 'top: '+ GAMEY + 'px;left: ' + GAMEX + 'px;'});
	
	$('#game_'+gameId).appendDom([{		//create div for the current players cards
		tagName: 'ul',
		id: 'handContainer'
	}]);
	$('#game_'+gameId).appendDom([{		//create div for the opponents placeholder cards and append it to the DOM
		tagName: 'div',
		id: 'playerCards'
	}]);	
	$('#game_'+gameId).appendDom([{		//create div for the opponents placeholder cards and append it to the DOM
		tagName: 'span',
		class: 'placeholder-card'
	}]);
	
	$('#game_'+gameId).append($('#table').css({position:'relative',top:'150px'}));
	$('#game_'+gameId).append($('#discard'));
	//populate the arrays of cards
	var rowCount = 1;
	for(var j = 0; j < cardColors.length; j++)
	{
		var color = cardColors[j];
		deckArray[color]=new Array();
		for(var i = 0; i < cardValues.length; i++)
		{
			var value = cardValues[i];
			tableConnect[rowCount] = color + "," + value;
										//Card(parent,			,value,	color,width,height,x,y)
			deckArray[color][value] = new Card("handContainer", "card" + j + i,value,color);
			rowCount++;
		}
		
	}
	dealCards();
}

function dealCards()
{
	//setting up users
	for(var i = 0; i<playerArray.length; i++)
	{
		var player = eval("player"+(i+1));
		playerArray[player.id] = player;
		$('#scoreCard').appendDom([{		//create div for the opponents placeholder cards and append it to the DOM
			tagName: 'div',
			id: 'player'+(i+1)+'_score',
			innerHTML: 'Player ' + (i+1)
		}]);
		if(player.id != playerId)		//if the player isnt me, create a placeholder card
		{
			backCards[i] = new Card("playerCards", "player"+(i+1),"Player " + (i+1),"backside");
			backCards[i].showCard(675+(i*70),530);
		}
	}
	
	//check for new users
	checkForUsers();
	checkForUpdates();
}

function redealCards(jsonText,whichPlayer,cardList)
{
	if(jsonText != null) 
	{
		var obj = eval(jsonText);
		var tempCards = obj[0]['handList'];
	} else 
	{
		tempCards = cardList;
	}
	if(tempCards != null && tempCards != "")
	{
		var cards = new Array();
		cards = tempCards.split(",");
		//reset old cards
		playerArray[whichPlayer].resetHand();
		for(var i = 0; i < cards.length; i++)
		{
			var whichcard = tableConnect[cards[i]].split(",");
			deckArray[whichcard[0]][whichcard[1]].removeFromDeck();
			deckArray[whichcard[0]][whichcard[1]].setPlayer(whichPlayer);
			playerArray[whichPlayer].addCard(deckArray[whichcard[0]][whichcard[1]]);
		}
	}
}

function dealHand()
{
	for(var c = 0; c<7; c++)
	{
		var whichCard = selectCard();
		whichCard.setPlayer(playerId);
		whichCard.removeFromDeck();
		playerArray[playerId].addCard(whichCard);
	}
}

function selectCard()
{
	var randVal = cardValues[Math.round(Math.random()*(cardValues.length-1))];
	var randCol = cardColors[Math.round(Math.random()*(cardColors.length-1))];
	
	while(deckArray[randCol][randVal].inDeck != "true")
	{
		randVal = cardValues[Math.round(Math.random()*(cardValues.length-1))];
		randCol = cardColors[Math.round(Math.random()*(cardColors.length-1))];
	}
	var card = deckArray[randCol][randVal];
	return card;
}
function makeDiscardPile(jsonText,cardList)
{
	if(jsonText != null)
	{
		var obj = eval(jsonText);
		var tempDiscards = obj[0]['inDiscard'];
	} else 
	var tempDiscards = cardList;
	if(inDiscard != tempDiscards)
	{
		inDiscard = tempDiscards;
		if(tempDiscards != "" && tempDiscards != null)
		{
			var cards = new Array();
			cards = tempDiscards.split(",");
			//reset old cards
			//playerArray[playerId].resetHand();
			$('#discard').empty();
			for(var i = 0; i < cards.length; i++)
			{
				if(cards[i] != "")
				{
					var whichcard = tableConnect[cards[i]].split(",");
					deckArray[whichcard[0]][whichcard[1]].setInDiscard(true);
					deckArray[whichcard[0]][whichcard[1]].removeFromDeck();
					deckArray[whichcard[0]][whichcard[1]].showCard(0,0);
				}
			}
		}
	}
}
function makeTable(jsonText,cardList)
{
	if(jsonText != null)
	{
		var obj = eval(jsonText);
		var tempTable = obj[0]['onTable'];
	} else
	var tempTable = cardList;
	
	if(tempTable != "" && tempTable != null)
	{
		var cards = new Array();
		cards = tempTable.split(",");
		for(var i = 0; i < cards.length; i++)
		{
			if(cards[i] != "")
			{
				var whichcard = tableConnect[cards[i]].split(",");
				deckArray[whichcard[0]][whichcard[1]].setInDiscard(false);
				deckArray[whichcard[0]][whichcard[1]].setOnTable(true);
				deckArray[whichcard[0]][whichcard[1]].removeFromDeck();
				deckArray[whichcard[0]][whichcard[1]].showCard(0,0);
			}
		}
		}
}
function moveCard(cardId,where)
{
	var whichcard = cardId.split("_");
	var card = deckArray[whichcard[0]][whichcard[1]];
	if(where == "discard")
	{
		card.setInDiscard(true);
		card.setOnTable(false);
	}
	else if(where =="table")
	{
		card.setOnTable(true);
		card.setInDiscard(false);
	}
	card.setPlayer('');
	playerArray[playerId].removeCard(cardId,where);
}

function moveFromDiscard(item)
{
	var cardId = $(item).children().children().attr("id");
	var sibCards = $("#"+cardId).parent().parent().nextAll();
	$(item).remove();
	var whichcard = cardId.split("_");
	
	var firstCard = deckArray[whichcard[0]][whichcard[1]];
	playerArray[playerId].addCard(firstCard);
	playerArray[playerId].appendCard("discard");
	firstCard.setInDiscard(false);
	firstCard.setPlayer(playerId);
	cardString = "user=" + playerId + "&removeColor=" + firstCard.color + "&removeValue=" + firstCard.text;
	changeLocation(cardString,"user");
	for(var i = 0; i< sibCards.length; i++)
	{
		var nextCardId = $(sibCards[i]).children().children().attr("id");
		var nextCard = nextCardId.split("_");
		var deckCard = deckArray[nextCard[0]][nextCard[1]];
		playerArray[playerId].addCard(deckCard);
		playerArray[playerId].appendCard("discard");
		deckCard.setInDiscard(false);
		deckCard.setPlayer(playerId);
		
		cardString = "user=" + playerId + "&removeColor=" + deckCard.color + "&removeValue=" + deckCard.text;
		changeLocation(cardString,"user");
	}
}

function deckClick()
{
	//alert("hi");
	var newCard = selectCard();
	playerArray[playerId].addCard(newCard);
	playerArray[playerId].appendCard("deck");
	readyToDiscard();
	//$('#handContainer').addClass('connect-sort-discard');
	//$('#discard').sortable('refresh');
}
function changeTurn()
{
	$('#discard').removeClass('connected-sortable');
	$('#handContainer').addClass('connect-sort-discard');
	$('#handContainer').sortable('refresh');
	$('#discard').sortable('refresh');
	$('#deck').parent().unbind('click',deckClick);
	$('#handContainer').sortable('disable');
	$('#discard').sortable('disable');
	$('#table').sortable('disable');
}
function readyToDiscard()
{
	$('#handContainer').removeClass('connect-sort-discard');
	$('#discard').sortable('refresh');
	$('#deck').parent().unbind('click',deckClick);
	//#('#discard').children().unbind('click');
	$('#discard').addClass('connected-sortable');
	$('#handContainer').sortable('refresh');
}
function updateScore(player,value)
{
	var playerNum = playerArray[player].playerNum;
	$("#player"+playerNum+"_score").html('Player '+ playerNum + ": " + value + " points");
}
