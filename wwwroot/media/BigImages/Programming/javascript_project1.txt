
/*DATA ARRAYS */
var level1Array = new Array('Saltwater', 'Freshwater');
var level2Array = new Object();

level2Array['Saltwater'] = ['Large Saltwater', 'Medium Saltwater', 'Small Saltwater'];
level2Array['Freshwater'] = ['Large Freshwater', 'Medium Freshwater', 'Small Freshwater'];

level2Array['Large Saltwater'] = ['Butterflyfish','Blue Tang','ClownTriggerfish'];
level2Array['Medium Saltwater'] = ['Flame Angelfish','Pseudochromis','Carberryi Anthias','Firefish'];
level2Array['Small Saltwater'] = ['Clown Fish','Clown Goby','Yellowtail Damselfish'];

level2Array['Large Freshwater'] = ['Goldfish', 'Acei Cichlid'];
level2Array['Medium Freshwater'] = ['Rainbow Fish', 'Sword tail', 'Betta'];
level2Array['Small Freshwater'] = ['Clown Louch', 'Neon Tetra', 'Lemon Tetra','Red Fire Guppy'];
/* END OF THE DATA ARRAYS */


var validateArray = new Array(); //ARRAY OF VALIDATION STATUS'S FOR THE SAVE FORM
var cookieNum; //COOKIE NUMBER FOR MULTIPLE FISH SAVING OPTION

var noticeSpan = document.createElement('span');//NOTICE TO THE USER FOR SCREENSIZE
noticeSpan.setAttribute('id','noticeSpan');
noticeSpan.appendChild(document.createTextNode('Please note: this project is best viewed with a window width of at least 1024px.')); 

//THIS IF STATEMENT ESSENTIALLY IF THE USER HAS SAVED FISH WHICH IS INDICATED IF THERE IS A COOKIE NUM COOKIE. IF NOT IT SETS THE VALUE TO 1.
if(GetCookie('cookieNum') == null)
{
	cookieNum = 1;
} else {
	cookieNum=GetCookie('cookieNum');
}

if(GetCookie('email'))
{
	validateFromCookie('email');
	validateFromCookie('yourName');
}


//THIS DIV IS THE DIV THAT THE SAVED FISH GET ADDED TO WHEN THEY APPEAR ON THE SCREEN
var parentDiv = document.createElement('div');
parentDiv.setAttribute('class','savedFish');
 if(checkBrowser() == "modIE") { parentDiv.setAttribute('className','savedFish'); } //FIX FOR IE

checkBrowser(); 

/*This function checks to see what browser the user is running and forwards accordingly */
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

/*This function checks to see if the user has previously saved any fishes and if they have been added to the screen 
if they have. It then calls a function to add those fish to the screen.*/
function checkForFish()
{
	for(var indexNum = 1; GetCookie('myFish' + indexNum + 'URL') != null; indexNum++)
	{
		if(!document.getElementById('fish'+indexNum))
		{
			addSavedFish(indexNum,parentDiv);
		}
	}
}


/*This function adds a saved fish to the stage as well as a button to reset everything and one to allow the user to play with 
their fish in a flash game. When this button is clicked, the user is forwarded to a php page which builds an XML file with the 
name of the images in it and then forwards the user to the flash page. This flash document loads in the appropriate fish that 
the user selected. */
function addSavedFish(indexNum,parentDiv)
{
	var fishURL = GetCookie('myFish'+indexNum+'URL');
	var yourName = GetCookie('yourName');
	//alert(fishURL + "direct cookie" + GetCookie(
	var myBody = document.getElementsByTagName('body')[0];
	
	//removeElement('myFish');
	//var parentDiv = document.createElement('div');
	//parentDiv.setAttribute('class','savedFish');
	
	var anImage = document.createElement('img');
	anImage.setAttribute('id','fish'+indexNum);
	anImage.setAttribute('src', 'Flash/images/'+fishURL);
	//anImage.style.left = '500px';
	anImage.setAttribute('alt', fishURL);
	parentDiv.appendChild(anImage);
	
	if(!document.getElementById('playBtn')) 
	{
		var playBtn = document.createElement('input');
		playBtn.setAttribute('type','submit');
		playBtn.setAttribute('id','playBtn');
		playBtn.setAttribute('value','Play with your Fish');
		playBtn.onclick = function() { window.location="buildxml.php"; }
		//saveBtn.onclick = function() { SetCookie("myFish1URL",newFishName.toLowerCase()+".png"); }
		 myBody.appendChild(playBtn); 
		 
		 var resetBtn = document.createElement('input');
		resetBtn.setAttribute('type','submit');
		resetBtn.setAttribute('id','resetBtn');
		resetBtn.setAttribute('value','Reset Fish');
		resetBtn.onclick = function() { removeFish(); }
		myBody.appendChild(resetBtn);
		 
		 var label = document.createElement('h3');
		 label.appendChild(document.createTextNode(GetCookie('yourName') +'\'s Fish:'));
		 myBody.appendChild(label);
	 }
	
	myBody.appendChild(parentDiv);
}


/*The below function removes all the users cookies and reloads the page to reset to everything. While the button 
doesnt appear until the user has saved a fish, it has no need to as the user has nothing to reset. They can backtrack
accordingly at anypoint before they save a fish and get back to the beginning.*/
function removeFish()
{
	for(var indexNum = 1; GetCookie('myFish' + indexNum + 'URL') != null; indexNum++)
	{
		DeleteCookie('myFish' + indexNum + 'URL');
	}
	DeleteCookie('yourName');
	DeleteCookie('cookieNum');
	DeleteCookie('email');
	window.location = "index.html";
}

/*The bellow function is the main contructor of this page. It loads the different menus 
based on the arrays above. It also tells the browser to see if the user has previously saved fishes.*/
function loadMenu(levelNum,value) 
{
	checkForFish();
	var myBody = document.getElementsByTagName('body')[0];
	myBody.appendChild(noticeSpan);
	
	if((level2Array[value] != undefined || levelNum ==1))
	{
		//alert(levelNum);
		var myBody = document.getElementsByTagName('body')[0];
		var parentElement = document.createElement('select');
		parentElement.setAttribute('id','select'+levelNum);
		//parentElement.onchange= function() { loadMenu(eval('level'+(levelNum+1)+'Array'), eval((levelNum + 1)),this.value) }
		var mybrowser = checkBrowser();
		if(mybrowser == "gecko")
		{
			parentElement.setAttribute('onchange',"loadMenu((" +(levelNum + 1)+"),this.value)");
		} else if(mybrowser == "modIE")
		{
			parentElement.setAttribute('onchange',function() { loadMenu((levelNum+1),this.value); } );
		}
		
		parentElement.appendChild(document.createElement('option'));
		
		if(levelNum == 1)
		{
			for(var i = 0; i<level1Array.length; i++)
			{
				var anOption = document.createElement('option');
				anOption.setAttribute('value',level1Array[i]);
				anOption.appendChild(document.createTextNode(level1Array[i]));
				parentElement.appendChild(anOption);
			}
		} else {
				for(var k = levelNum-1; document.getElementById('select'+(k+1)) != null; k++)
				{
						//document.getElementById('select'+(k+1)).parentNode.removeChild(document.getElementById('select'+(k+1)));
						removeElement('select'+(k+1));
				}
				removeElement('myFish');
				removeElement('descripSpan');
				for(var j = 0; j < level2Array[value].length; j++)
				{
					var anOption = document.createElement('option');
					anOption.setAttribute('value',level2Array[value][j]);
					anOption.appendChild(document.createTextNode(level2Array[value][j]));
					parentElement.appendChild(anOption);
				}
			}
			myBody.appendChild(parentElement);
		} else {
			loadFish(value);
		}
	}
	
	
/* The below function loads the image of the fish that the user selected onto the page and displays text telling the user what
they selected. It also gives the user a button to save the fish if they desire to. */

function loadFish(fishName)
{
	var spaceKey = / /gi;
    var newFishName = fishName.replace(spaceKey,"");
	var imageFish = "Flash/images/" + newFishName.toLowerCase() + ".png";
	var myBody = document.getElementsByTagName('body')[0];
	
	removeElement('myFish');
	var parentDiv = document.createElement('div');
	parentDiv.setAttribute('id','myFish');
	
	var anImage = document.createElement('img');
	anImage.setAttribute('src', imageFish);
	anImage.style.left = '500px';
	anImage.setAttribute('alt', fishName);
	anImage.setAttribute('id','fishImg');
	parentDiv.appendChild(anImage);
	
	var saveBtn = document.createElement('input');
	saveBtn.setAttribute('type','submit');
	saveBtn.setAttribute('value','Save Your Fish');
	saveBtn.onclick = function() { saveForm(newFishName.toLowerCase()+".png"); }
	//saveBtn.onclick = function() { SetCookie("myFish1URL",newFishName.toLowerCase()+".png"); }
	parentDiv.appendChild(saveBtn);
	
	removeElement('descripSpan');
	var descripSpan = document.createElement('span');
	descripSpan.setAttribute('id','descripSpan');
	
	var descripText = "You choose a " + document.getElementById('select3').value.toLowerCase() + " which is a " + document.getElementById('select2').value.toLowerCase() + " fish.";
	descripSpan.appendChild(document.createTextNode(descripText));
	myBody.appendChild(descripSpan);
	
	myBody.appendChild(parentDiv);
	
	swim();
}


/*The below function makes the fish swim from left to right when selected by the user */
function swim() {
		var fish = document.getElementById('fishImg');
		if(parseInt(fish.style.left) >=50) {
			fish.style.left = parseInt(fish.style.left) - 10 + 'px';
			
		window.setTimeout("swim()",50);
		}
}	

/*The below function takes in the id of an element on the page, checks to see if it exists and removes it if it does */
function removeElement(what)
{
	if(document.getElementById(what) != null)
	{
		document.getElementById(what).parentNode.removeChild(document.getElementById(what));
	}
}

/* The below function loads the form to allow the user to save their selected fish */
function saveForm(fishURL)
{
	var myBody = document.getElementsByTagName('body')[0];
	var backDiv = document.createElement('div');
	backDiv.setAttribute('id','backDiv');
	myBody.appendChild(backDiv);
	
	var parentDiv = document.createElement('div');
	var leftDiv = document.createElement('div');
	leftDiv.setAttribute('id','leftDiv');
	var rightDiv = document.createElement('div');
	rightDiv.setAttribute('id','rightDiv');
	parentDiv.setAttribute('id','formDiv');

	leftDiv.appendChild(document.createTextNode("Your Fish: "));
	leftDiv.appendChild(document.createElement('br'));
	var input2 = document.createElement('input');
	input2.setAttribute('type','text');
	input2.setAttribute('name','fishURL');
	input2.setAttribute('disabled','disabled');
	input2.setAttribute('value',fishURL);
	input2.onblur = function() { validate(this); }
	rightDiv.appendChild(input2);
	rightDiv.appendChild(document.createElement('br'));
	
	leftDiv.appendChild(document.createTextNode("Your Name: "));
	leftDiv.appendChild(document.createElement('br'));
	var input3 = document.createElement('input');
	input3.setAttribute('type','text');
	input3.setAttribute('name','yourName');
	if(GetCookie('yourName') != null) { input3.setAttribute('value',GetCookie('yourName')); }
	input3.setAttribute('id','yourName');
	input3.onblur = function() { validate(this); }
	rightDiv.appendChild(input3);
	rightDiv.appendChild(document.createElement('br'));
	
	leftDiv.appendChild(document.createTextNode("Your Email: "));
	leftDiv.appendChild(document.createElement('br'));
	var input4 = document.createElement('input');
	input4.setAttribute('type','text');
	input4.setAttribute('name','email');
	input4.setAttribute('id','email');
	if(GetCookie('email') != null) { input4.setAttribute('value',GetCookie('email')); }
	input4.onblur = function() { validate(this); }
	rightDiv.appendChild(input4);
	rightDiv.appendChild(document.createElement('br'));
	
	var cancelBtn = document.createElement('input');
	cancelBtn.setAttribute('type','submit');
	cancelBtn.setAttribute('value','Cancel');
	cancelBtn.onclick = function() { removeElement('formDiv');removeElement('backDiv'); }
	//cancelBtn.setAttribute('onclick','removeForm()');
	parentDiv.appendChild(cancelBtn);
	
	var saveBtn = document.createElement('input');
	saveBtn.setAttribute('type','submit');
	saveBtn.setAttribute('value','Save');
	saveBtn.onclick = function() { validatedForm(fishURL); }
	rightDiv.appendChild(saveBtn);
	
	parentDiv.appendChild(leftDiv);
	parentDiv.appendChild(rightDiv);
	myBody.appendChild(parentDiv);
	
}


/*This function goes through and validates the given input box. If it is the email box it not only checks to see if it is null
but it checks if it is a valid email address. It then pushes the result of this validation onto an array. */
function validate(what)
{
	var result = true;
	removeElement('invalid');
	var invalid = document.createElement('span');
	invalid.setAttribute('id','invalid');
	if(what.value == "")
	{
		result = false;
		invalid.appendChild(document.createTextNode("Please check that every field is filled in."));
	}
	else if(what.name == 'email')
	{
		var filter=/^.+@.+\..{2,3}$/;
		if (!filter.test(what.value))
		{
			result = false;
			invalid.appendChild(document.createTextNode("Please enter a valid email."));
		}
	}
	if(result == false) { 
		document.getElementById('leftDiv').parentNode.appendChild(invalid);
	}
	validateArray[what.name] = result;
	//alert(validateArray[what.name]);
	return result;
}
function validateFromCookie(cookieName)
{
	var result = true;
	if(GetCookie(cookieName) == "")
	{
		result = false;
		DeleteCookie(cookieName);
	}
	else if(cookieName == 'email')
	{	
		var filter=/^.+@.+\..{2,3}$/;
		if (!filter.test(GetCookie(cookieName)))
		{
			result = false;
			DeleteCookie(cookieName)
		}
	}
	validateArray[cookieName] = result;
}

/*This function validates the form by comparing the number of text input attributes to the number of previously validated inputs. 
If they match and all the previously validated attributes were valid, it loads the fish to the page and sets the appropriate cookies*/
function validatedForm(fishURL)
{
	var inputCount = 0;
	var inputArray = new Array();
	result = true;
	for(var i = 0; i<document.getElementsByTagName('INPUT').length; i++)
	{
		if (document.getElementsByTagName('INPUT')[i].type == 'text')
		{
			inputCount++;
			inputArray.push(document.getElementsByTagName('INPUT')[i].name);
		}
	}
	var validateLength = 1;
	for(obj in validateArray)
	{
		validateLength++;
	}
	//alert(validateLength);
		//alert(validateLength + "and the input count: " + inputArray.length);
	if(inputCount == validateLength)
	{
		for(var j = 0; j<inputArray.length; j++)
		{
			//alert(validateArray[j]);
			if(validateArray[inputArray[j]] == false)
			{
				result = false;
				break;
			}
		}
	}
	else { result = false; }
	if(result == true)
	{
		SetCookie("myFish"+cookieNum+"URL",fishURL);
		SetCookie("yourName",document.getElementById('yourName').value);
		//SetCookie("myFish"+cookieNum+"Name",document.getElementById('fishName').value);
		SetCookie("email",document.getElementById('email').value);
		
		removeElement('formDiv');
		removeElement('backDiv');
		removeElement('myFish');
		//alert("set cookie");
		checkForFish();
		cookieNum++;
		SetCookie('cookieNum',cookieNum);
	}
}