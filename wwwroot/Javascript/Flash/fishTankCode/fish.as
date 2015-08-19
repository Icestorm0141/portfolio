package fishTankCode
{
	import flash.display.*;
	import flash.events.*;
	import flash.net.*;

	public class fish extends MovieClip
	{
		private var xSpeed:Number;//Xspeed of the fish
		private var ySpeed:Number;//Yspeed of the fish
		private var myDoc:Document;//variable to hold the Document class in
		public var goingRight:Boolean;//Boolean to tell anything that the fish is going right
		public var goingLeft:Boolean;//Boolean that tells anything the fish is going left
		private var flippedLeft:Boolean;//Boolean to see if the fish has already been mirrored left
		private var flippedRight:Boolean;//Boolean to see if the fish has already been mirrored right
		public var prev_x:Number;//previous value for the mouse's X
		public var pLoader:Loader;
		public var whichFish:String;

		public function fish (anX:Number, aY:Number, doc:Document, fishToLoad:String)
		{
			this.x =anX;
			flippedLeft=false;
			flippedRight=false;
			this.y =aY;
			myDoc=doc;
			prev_x= this.x;
			whichFish = fishToLoad;
			
			pLoader = new Loader();
			addChild(pLoader);
			loadFish();
			
			this.addEventListener(MouseEvent.MOUSE_UP,makeCurrent);
			addEventListener (Event.ENTER_FRAME,directionCheck);
		}
		
		public function loadFish()
		{
			var fileToLoad:URLRequest = new URLRequest(whichFish);
			pLoader.load(fileToLoad);
		}
		//Function to choose which fish you want
		public function makeCurrent(e:MouseEvent){
			myDoc.chooseFish(this);
		}
		//Sets the speed of the fish as they move around
		public function setSpeed (xSpd:Number, ySpd:Number)
		{
			xSpeed =xSpd;
			ySpeed =ySpd;
		}
		
		//Actually Moves the fish & checks for the fish tank walls
		public function moveFish ()
		{
			x+=xSpeed;
			y+=ySpeed;
			checkForWalls ();
		}
		
		//sets the X value for the users fish and checks to see which direction the mouse is moving & flips the
		//fish accordingly
		public function setX(newX:Number)
		{
			this.x = newX;
			var difference_x = newX - prev_x;
			if (difference_x <= 0) {
				myDoc.myFishy.scaleX=1;
			} else if (difference_x > 0) {
				myDoc.myFishy.scaleX=-1;
			}
			prev_x = newX;

		}
		//flips all the other "auto" fish according to which direction they are going
		public function directionCheck(e:Event){
			
			if(xSpeed>=0){
				goingRight=true;
				
				if(flippedLeft==false){
					this.scaleX=-1;
					this.x=this.x+this.width;
					flippedLeft=true
				}
				flippedRight=false;
			}
			else if(xSpeed<0){
				goingLeft=true;
				if(flippedRight==false){
				this.scaleX=1;
					this.x=this.x-this.width;
					flippedRight=true;
				}
				flippedLeft=false;
			}
		}
		//checks for the walls of the fishtank
		private function checkForWalls ()
		{
			//check for right wall and negate xSpeed if I'm past it
			if (x >=stage.stageWidth)
			{
				this.xSpeed= xSpeed * (-1);
			}
			//check for left wall and negate xSpeed if I'm past it
			if (x <= 0)
			{
				this.xSpeed= xSpeed * (-1);
			}
			//check for top wall and negate xSpeed if I'm past it
			if (y <= 165)
			{
				this.ySpeed= ySpeed * (-1);
			}
			//check for bottom wall and negate xSpeed if I'm past it
			if (y >=stage.stageHeight-165)
			{
				this.ySpeed= ySpeed * (-1);
			}
		}
	}
}