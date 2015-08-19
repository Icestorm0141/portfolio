//Card(parent,color,width,height,x,y)
function Player(id,num) {
	this.id = id;
	this.playerNum = num;
	this.isReady = false;
	this.hand = new Array();
}
Player.prototype.addCard = function(card)
{
	this.hand.push(card);
}

Player.prototype.getNumCards = function()
{
	return this.hand.length;
}

Player.prototype.showHand = function()
{
	for(var i=0; i<this.hand.length; i++)
	{
		//THE VALUES IN HERE DO NOT MATTER, THEY ARENT USED IN DISPLAYING THE HAND
		this.hand[i].showCard(0,0); 
	}
}
Player.prototype.resetHand = function()
{
	for(var i=0; i<this.hand.length; i++)
	{
		this.hand[i].player = ''; 
	}
	this.hand = new Array();
}

Player.prototype.buildQueries = function()
{
	var handString = "&user="+this.id;
	for(var i = 0; i<this.hand.length; i++)
	{
		handString += "&color" + (i+1) + "=" + this.hand[i].color + "&value" + (i+1) + "=" + this.hand[i].text;
	}
	newPlayer(handString);
	
	playerString= "&player"+this.playerNum+"="+this.id;
	addPlayerToList(playerString);
}
Player.prototype.appendCard = function(fromWhere)
{
	this.hand[this.hand.length-1].parent = "handContainer";
	this.hand[this.hand.length-1].showCard(0,0);
	var cardString = "user=" + this.id + "&color=" + this.hand[this.hand.length-1].color + "&value=" + this.hand[this.hand.length-1].text + "&from=" + fromWhere;
	addCardToHand(cardString);
}
Player.prototype.removeCard = function(card,toWhere)
{
	var cardString = "";
	for(var i = 0; i<this.hand.length; i++)
	{
		if(card == this.hand[i].id)
		{
			cardString = "user=" + this.id + "&removeColor=" + this.hand[i].color + "&removeValue=" + this.hand[i].text;
			this.hand.splice(i,1);
		}
	}
	if(cardString != "") changeLocation(cardString,toWhere);
	//if(toWhere == "discard") changeTurn();
	
}