// JavaScript Document
function challengeUsers()
{
	var challengeString = "setupgame.php?action=new";
	$("#playerSelect option:selected").each(
		function(i) {
			challengeString += "&player" + (i+1) + "=" + this.value;								 
		});
	myHttp = new HttpClient('GET',true,false,'text');
	myHttp.makeRequest(challengeString);
	myHttp.callback = function()
	{
		window.location = "game.php";
	}
}

function checkBrowser()
{
	var browser;
	if(document.getElementById && document.attachEvent) {
		//I'm in IE - modern
		browser = 'modIE';
	} else if(document.getElementById){
		//Gecko
		browser='gecko';
	} else if(document.layers) {
		browser = 'unsupported';
	} else if(navigator.userAgent.indexOf('Mac') != -1 && navigator.appName.indexOf('Internet Explorer') != -1)
	{
		browser = 'unsupported';
	}
	
	if(browser == 'unsupported')
	{
		window.location = 'upgradeBrowser.html';
	}
	return browser;
}

function registerUser()
{
	var vArray = new Array($('#formDiv input').length);
	$('#formDiv input').each(
  	function(i)
   	{
       if($(this).val() == "")
	   {
		   $(this).css("border","2px solid red");
		   vArray[i] = false;
	   }
	   else
	   {
		   $(this).css("border","none");
		   vArray[i] = true;		   
	   }
   	}
 	);
	var result = "";
	for(var i = 0; i < vArray.length; i++)
	{
		if(vArray[i] == false)
		{
			result = false;
		}
	}
	if(result == "")
	{
		myHttp = new HttpClient('GET',true,false,'text');
		var requestString = "helpers/handleRegistration.php?un=" + $('#s_UserName').val() + "&pw=" + $('#s_pw').val() + "&email=" + $('#s_email').val();
		myHttp.makeRequest(requestString);
		myHttp.callback = function()
		{
		}
		var un = $('#s_UserName').val();
		$('#b_UserName').val(un);
		$('#b_Password').val($('#s_pw').val());
		closeWindow('formDiv');
	}
}


function openRegister()
{
	if(document.getElementById('formDiv') == null)
	{
	$('#container').appendDom([{
      tagName : 'div',		//OUTER DIV
	  id: 'formDiv',
	  childNodes : [{
		tagName: 'h4',
		innerHTML: 'New User Registration'	 //TITLE
		},{
		tagName: 'a',
		id: 'closeLink',		//CLOSE LINK
		href: '#',
		onclick : function() { closeWindow('formDiv'); },
		innerHTML: 'close'
		},{
        tagName: 'div',
		childNodes : [{
			tagName : 'span',	
			innerHTML : 'Username: '
		  }, {
			tagName : 'input',
			type : 'text' ,
			name : 's_UserName',
			id : 's_UserName'
		  }]
		},{
		  tagName: 'div',
		  childNodes : [{	//PASSWORD BOX
			tagName : 'span',
			innerHTML : 'Password: '
		  }, {
			tagName : 'input',
			type : 'password' ,
			name : 's_pw',
			id : 's_pw'
		  }]
		},{
		  tagName: 'div', //EMAIL INPUT BOX
		  childNodes : [{
			tagName : 'span',
			innerHTML : 'Email: '
		  }, {
			tagName : 'input',
			type : 'Text' ,
			name : 's_email',
			id : 's_email'
		  }]
		},{
		  tagName: 'div',
		  childNodes : [{	//REGISTER BUTTON 
			tagName : 'button',
			id: 'btn',
			innerHTML : 'Register!',
			onclick : function() { registerUser(); }
		  }]
		}]
	  }]);
	}
}
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

function selectPlayers()
{
	if(document.getElementById('playerList') == null)
	{
	$('#container').appendDom([{
		tagName: 'div',
		id: 'disableDiv'
							   }]);
	$('#container').appendDom([{
      tagName : 'div',		//OUTER DIV
	  id: 'playerList',
	  childNodes : [{
			tagName: 'h4',
			innerHTML: 'Select Players to Challenge: '	 //TITLE
		},{
			tagName: 'a',
			id: 'closeLink',		//CLOSE LINK
			href: '#',
			onclick : function() { closeWindow('playerList'); closeWindow('disableDiv'); },
			innerHTML: 'cancel'
		},{
			tagName: 'select',
			id: 'playerSelect',
			multiple: 'multiple',
			name: 'playerSelect'
		}]
	  }]);
		for(i in userArray)
		{
			var element = "<option id=\"users_" +userArray[i] + "\" value=\"" + userArray[i] + "\">" + userArray[i] + "</option>";
			$('#playerSelect').append(element);
		}
		$('#playerList').appendDom([{
			tagName: 'div',
		  	childNodes : [{	//REGISTER BUTTON 
				tagName : 'button',
				id: 'btn',
				innerHTML : 'Challenge!',
				onclick : function() { challengeUsers(); } 
				}]
		}]);
	}
}