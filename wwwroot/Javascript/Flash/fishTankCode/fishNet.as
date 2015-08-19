package fishTankCode{
	import flash.display.MovieClip;
	import flash.events.*
	public class fishNet extends MovieClip{
		
		public function fishNet (anX,aY)
		{
			this.x =anX; //the x coordinate of the fishNet
			this.y =aY; //the y coordinate of the fishNet
		}
		
		
		//Function that moves the net around
		public function moveMyNet(oneX,oneY){
			//These if statements decide which side of the screen the net will appear on
			if(oneX<=1){
				this.scaleX = -1;
				this.x=stage.stageWidth-100;
				this.y=250;
				this.gotoAndPlay("Scooping");
			}
			else if(oneX<=2){
				this.scaleX = 1;
				this.y=250;
				this.x=100;
				this.gotoAndPlay("Scooping");
			}
		}
		
	}
}