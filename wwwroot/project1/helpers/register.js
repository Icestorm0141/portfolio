
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
		var requestString = "handleRegistration.php?un=" + $('#s_UserName').val() + "&pw=" + $('#s_pw').val() + "&email=" + $('#s_email').val();
		myHttp.makeRequest(requestString);
		
	}
		
	}