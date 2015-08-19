	function getInfo()
	{
		
		myHttp = new HttpClient('GET',true,false,'text');
		
		if(arguments[0])
		{
			myHttp.makeRequest("helpers/handleChat.php?what="+arguments[0]+"&who="+who);
			document.getElementById('newName').value = "";
		} else
		{
			myHttp.makeRequest("helpers/handleChat.php");
		}
		myHttp.callback = function(jsonText)
		{
			//deal with JSON
			//alert(typeof(jsonText));
			var obj = eval(jsonText);
			var stuffForPage = '';
			//alert(obj);
			for(i in obj)
			{
				stuffForPage += "["+ obj[i]['timestamp'] + "] " + obj[i]['user'] + ": " + obj[i]['message'] + "<br />";
			}
			
			document.getElementById('chatBox').innerHTML = stuffForPage;
			
			var myDiv = document.getElementById('chatBox');
			myDiv.scrollTop = myDiv.scrollHeight;
		}
		if(!arguments[0])
		{ 
		
			getUsers();
			checkForChallenge();
		}
	}// JavaScript Document
	function checkForChallenge()
	{
		var result;
		myHttp = new HttpClient('GET',true,false,'text');
		var requestString = "helpers/handleChat.php?action=challenge";
		myHttp.makeRequest(requestString);
		myHttp.callback = function(jsonText)
		{
			var obj = eval(jsonText);
			if(obj != "" && obj != null)
			{
				window.location = "game.php";
			}
			else
			{
				setTimeout('getInfo()',2000);
			}
		}
	}
	
	function getUsers()
	{
		myHttp2 = new HttpClient('GET',true,false,'text');
		myHttp2.makeRequest("helpers/handleUsers.php");
		
		myHttp2.callback = function(jsonText)
		{
			var obj = eval(jsonText);
			var stuffForPage = '';
			for(i in obj)
			{
					stuffForPage += "<option id=\"list" + obj[i]['username'] + "\" value=\"" + obj[i]['username'] + "\">" + obj[i]['username'] + "</option>";
					userArray[i] = obj[i]['username'];
			}
			$('#userList').html(stuffForPage);
		}
	}