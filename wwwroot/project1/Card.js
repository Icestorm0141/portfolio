//Card(parent,color,width,height,x,y)
function Card(myParent,id,text,color) {
	this.parent = myParent;
	this.width = 60;
	this.height = 85;
	this.color = color;
	this.text = text;
	
	//initialize the other instance vars
	this.onTable = false;
	this.inDeck = "true";
	this.inDiscard = false;
	this.player = '';
	this.numCards = 7;
	
	if(this.color != "backside") {
		this.id = color + "_" + text;
	} else {
		this.id = id; 
	}
	//create it...
	this.object = this.createCard();
	
	//this.myBBox = this.getMyBBox();
	
}
Card.prototype.createCard = function()
{
	var cardType = "li";
	if(this.color == 'backside')
	{	cardType = "span"; }
	var card = document.createElement(cardType);
	var svgEle = document.createElementNS(svgns,"svg");
	svgEle.setAttributeNS(null,'version','1.1');
	svgEle.setAttributeNS(null,'height','85px');
	svgEle.setAttributeNS(null,'width','85px');
	
	var cardG = document.createElementNS(svgns,"g");
	cardG.setAttributeNS(null,"id",this.id);
	
	var cardEle = document.createElementNS(svgns,"rect");
	cardEle.setAttributeNS(null,"width",this.width+"px");
	cardEle.setAttributeNS(null,"height",this.height+"px");
	cardEle.setAttributeNS(null,"class",this.color);
	cardEle.setAttributeNS(null,"rx",10+"px");
	cardEle.setAttributeNS(null,"ry",10+"px");
	
	var cardtxt = document.createElementNS(svgns,"text");
	cardtxt.setAttributeNS(null,"x",5+"px");
	cardtxt.setAttributeNS(null,"y",35+"px");
	if(this.color == "backside") cardtxt.setAttributeNS(null,"y",25+"px");
	cardtxt.appendChild(document.createTextNode(this.text));
	
	cardG.appendChild(cardEle);
	cardG.appendChild(cardtxt);
	svgEle.appendChild(cardG);
	card.appendChild(svgEle);
	
	if(this.color == "backside" && this.text != "Deck")
	{
		var cardtxt2 = document.createElementNS(svgns,"text");
		cardtxt2.setAttributeNS(null,"x","8px");
		cardtxt2.setAttributeNS(null,"y","65px");
		cardtxt2.setAttributeNS(null,"style","font-size:14px");
		cardtxt2.setAttributeNS(null,"id",this.id + "_text");
		//cardtxt2.appendChild(this.updateCardTotal());
		cardG.appendChild(cardtxt2);
	}
	return card;
}
Card.prototype.updateCardTotal = function(numCards)
{
	//var cardText = document.createTextNode(numCards + " cards");
	$("#"+this.id+"_text").html(numCards + " cards");
	//return cardText;
}

Card.prototype.showCard = function(x,y)
{
	//this.object.setAttribute('style','top: '+ y +'px; left: '+ x +'px;');
	document.getElementById(this.parent).appendChild(this.object);
	if(this.color == "backside") this.object.setAttribute('style','top: '+ y +'px; left: '+ x +'px; position:absolute;')		
	//document.getElementById(this.id).firstChild.setAttributeNS(null,"transform","translate("+x+","+y+")");
}
Card.prototype.setPlayer = function(who)
{
	this.player = who;
}
Card.prototype.setOnTable = function(value)
{
	this.parent = "table";
	this.onTable = value;
}
Card.prototype.removeFromDeck = function()
{
	this.inDeck = "false";
}
Card.prototype.setInDiscard = function(value)
{
	this.parent = "discard";
	this.inDiscard = value;
}