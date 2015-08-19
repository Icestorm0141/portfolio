package fishTankCode{
	import flash.display.MovieClip;
	import flash.events.*
	import flash.media.*;
	public class bubble extends MovieClip{
		
		private var myDoc:Document; //variable to put the Document class in
		public var popBubble:Sound; //new Bubble popping sound
		
		public function bubble (anX,aY, doc:Document)
		{
			popBubble = new Pop();//seting the sound variable to the actual sound
			var ch:SoundChannel=popBubble.play(); //sound channel
			ch.stop();
			x=anX;
			y=aY;
			myDoc=doc;
			addEventListener (Event.ENTER_FRAME,everyFrame);
		}
		
		//every frame the bubbles check for the top of the tank, and if myFishy has decided to pop them and moves up the tank
		public function everyFrame(e:Event){
			//this.setAlpha();
			checkForTop();
			testForPop();
			this.y-=10;
			
		}
		//checks for the top of the tank, if its there, it goes invisible
		public function checkForTop(){
			if(this.y<=(stage.stageHeight/2)-(myDoc.fishTank.height/2)+50){
				this.alpha=0;
			}
		}
		
		//checks to see if the users fish has popped the bubble
		public function testForPop() {
				//for (var j=0; j<myDocfoodArray.length; j++) {
					if (myDoc.myFishy.hitTestObject(this) && myDoc.myFishy.visible==true && this.visible==true) {
						popBubble.play( );
						this.visible=false;
						//myDoc.removeChild(this);
						//myDoc.bubbleArray.splice(this,1);
					//}
			}
		}
		
	}
}