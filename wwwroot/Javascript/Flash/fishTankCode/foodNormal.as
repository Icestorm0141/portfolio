package fishTankCode{
	import flash.display.MovieClip;
	import flash.events.*
	import flash.media.*;
	public class foodNormal extends MovieClip{

		private var myDoc:Document;//Variable for the Document class
		public var crunchSound:Sound;//variable for the eatting sound
		public var isMoving:Boolean; //Boolean to tell if the food is moving
		private var incremented:Boolean; //Boolean to tell if the score has incremented yet
		
		public function foodNormal (anX:Number,aY:Number,doc:Document)
		{			
			crunchSound = new crunch();//setting the variable to an actual crunch sound
			var ch:SoundChannel=crunchSound.play();//crunch sound channel
			ch.stop();
			isMoving = true;
			x=anX;
			y=aY;
			myDoc=doc;
			incremented=false;
			addEventListener (Event.ENTER_FRAME,moveFood);
		}
		//Tests for a hit between the food and the fish
		public function testForHit() {
			for (var i=0; i<myDoc.fishArray.length; i++) {
					if (myDoc.fishArray[i].hitTestObject(this) && myDoc.fishArray[i].visible==true && this.visible==true) {
						if(myDoc.fishArray[i]==myDoc.myFishy &&incremented==false && this.visible==true){
							//If the food is hit by the user's fish, the score is incremented, as long as it hasnt done
							//the increment yet
							myDoc.score++;
							incremented=true;
						}
						crunchSound.play( );//plays the crunch sound when any fish eats a piece of food
						this.visible=false; //makes the piece of food invisible when the fish eat it
				}
			}
			incremented=false; //resets the increment boolean to be ready for another collision with the fish
		}
		
		//moves the food around the stage
		public function moveFood(e:Event){
			testForHit();
			if(isMoving){ //if my food is moving then the food should fall and fade out
				this.y+=5;
				this.alpha-=.03
				if(this.alpha<=0){ //if the food isnt visible, then move it somewhere around the screen.
					this.x=Math.random()*stage.stageWidth;
					this.y=(Math.random() *(stage.stageHeight-330))+165;
					this.alpha=1;
					isMoving = false;
				}
			}
		}
		
		
	}
}