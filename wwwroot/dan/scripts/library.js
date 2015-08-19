var roles = new Array("Luxury","Intermediate","Subsistence");



$(document).ready(function(){

	setName();

	//checkForUpdates();

});

function closeWindow(which)

{

	//alert("in here");

	//$('body').remove($('formDiv'));

	if($('#'+which) != null)

	{

		//document.getElementById('formDiv').parentNode.removeChild($('formDiv'));

		$('#' + which).remove();

	}

}

function setName()

{

	if(document.getElementById('playerList') == null)

	{

	$('#container').appendDom([{

		tagName: 'div',

		id: 'disableDiv'

							   }]);

	$('#container').appendDom([{

      tagName : 'div',		//OUTER DIV

	  id: 'tagBox',

	  childNodes : [{

			tagName: 'span',

			className:'label',

			innerHTML: 'Enter Game Name: '	 //Game Name

		},{

			tagName: 'input',

			id: 'playerTag',

			type: 'text'

		},{

			tagName: 'br'

		},{

			tagName: 'span',

			className:'label',

			innerHTML: 'Enter First Name: '	 //Player Name

		},{

			tagName: 'input',

			id: 'playerFirst',

			type: 'text'

		},{

			tagName: 'br'

		},{

			tagName: 'span',

			className:'label',

			innerHTML: 'Enter Last Name: '	 //Player Last Name

		},{

			tagName: 'input',

			id: 'playerLast',

			type: 'text'

		},{

			tagName: 'br'

		}]

	  }]);

	var template = [

                {

                   tagName: 'span',

				   className:'label',

                   innerHTML:'Select Role: '

                    },{

                      

                            tagName:'select',

                            name:'ddlRole',

                            id:'ddlRole',

                            childNodes:[]

                },{

			tagName: 'br'

		}];  

                for(i in roles)

                {

					var index = parseInt(i);

                   template[1].childNodes.push({

                            tagName:'option',

                            value:index+1+'',

                            innerHTML:roles[i]

                   });

                }

                $('#tagBox').appendDom(template);

		$('#tagBox').appendDom([{

			tagName: 'div',

		  	childNodes : [{	//REGISTER BUTTON 

				tagName : 'button',

				id: 'btn',

				innerHTML : 'Okay',

				onclick : function() { createUser(); } 

				}]

		}]);

	}

}
function updateProd()
{
	//gamerTag
	var prod = $("#txtProduction").val();
	
	var amt = parseInt($('#txtProduction').val());
	var indMax = 0;
	if(role == "Luxury")
	{
		indMax = 10;	
	}
	
	if(prod <= indMax && prod > 0)
	{
		$('#indVal').html(amt);
		
		var inputString = "input.php?action=prod&amt=" + prod + "&tag=" + gamerTag;
		
		$('#txtProduction').val(amt);
		
		myHttp = new HttpClient('GET',true,false,'text');
		
			myHttp.makeRequest(inputString);
		
			myHttp.callback = function()
		
			{
			}
			
		
	}
}
function createUser()

{
	if($("#playerFirst").val() != "" & $("#playerLast").val() != "" & $("#playerTag").val() != "")
	{
	var first = $("#playerFirst").val();

	var last = $("#playerLast").val();

	var gamerTag = $("#playerTag").val();

	var role = $("#ddlRole option:selected").val();

	var inputString = "input.php?action=new&first=" + first + "&last=" + last + "&tag=" + gamerTag + "&role=" + role;

	

		myHttp = new HttpClient('GET',true,false,'text');
	
		myHttp.makeRequest(inputString);
	
		myHttp.callback = function()
	
		{
			window.location = "gameLayout.php?user="+gamerTag;
		}
	}
}

function addProduction(howMuch)

{

	var src = $(image).attr("src");

	var amt = parseInt($('#txtProduction').val());

	amt += howMuch;

	$('#txtProduction').val(amt);

	$('#indVal').html(amt);

	appendImage(src);

	updateProduction(amt);

}

function updateProduction(howMuch)

{

	var inputString = "input.php?action=prod&amt=" + howMuch+"&tag="+gamerTag;

	myHttp = new HttpClient('GET',true,false,'text');

	myHttp.makeRequest(inputString);

	myHttp.callback = function()

	{

	}

}

function appendImage(src)

{

	$('#playArea').appendDom([{

		tagName: 'img',

		src: src,

		className: 'prod'

	}]);

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

		if(jsonText != null)

		{

			var obj = eval(jsonText);

			for(var i in obj)

			{

				//do some jquery to append to the right place

			}

		}

		

			setTimeout("checkForUpdates()",5000);

	}

}