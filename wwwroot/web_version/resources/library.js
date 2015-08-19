// JavaScript Document
var timer;
var speed = 10;

$(document).ready(function(){
//   $.fn.canvasSwap.defaults.suffix = '_hover';
//   $('#menu li img.swap').canvasSwap();
//----CREATING THE MENU 'IMAGE SWAPS' ----//
$('#menu li img.swap').mouseover(function() {
$(this).css("top","0px");
}).mouseout(function(){$(this).css("top","-97px");});
   
   //--- CREATING THE FADE EFFECTS ON THE SECTION THUMBS ---//
    $("#thumblist li img").mouseover(function () {
      $(this).fadeTo("slow", 1);
    }).mouseout(function(){
	  $(this).fadeTo("slow",.3);
	}).css("opacity",.3);
//--Calling init function --//
pageInit();
});

function pageInit()
{
    //-----RESIZE THUMBLIST HEIGHT IF THERE ARE TOO FEW THUMBS ---//
    var listHeight = $("#thumblist").children().length;
    listHeight *= 62; //Multiply by the height of the thumbnails + their padding
    
    if(listHeight < $("#thumbs").height())
    {
        var newHeight = parseInt(listHeight - 1);
        $("#thumbs").height(newHeight);
    }
    //-----CREATE SCROLLING EFFECTS FOR ARROWS ----//
    $("#down").mouseover(function(){
       scrollDown();
      // alert("hi!");
    }).mouseout(function(){clearTimeout(timer)});
    
    $("#up").mouseover(function(){
       scrollUp();
    }).mouseout(function(){clearTimeout(timer)});
    $("#up").mousedown(function(){speed *= 2;}).mouseup(function(){speed /= 2;});
    $("#down").mousedown(function(){speed *= 2;}).mouseup(function(){speed /= 2;});
}
function scrollDown()
{
    var containerY = parseInt($("#thumbs").css("top"));     
    var containerEnd = (containerY + parseInt($("#thumbs").height()));
    
    var oldY = parseInt($("#thumblist").css("top"));
    var thumbsEnd = (oldY + parseInt($("#thumblist").height()));
    //$("#debug").append(containerY);
    if(thumbsEnd >= (containerEnd+7))
    {
        $("#thumblist").css("top",(oldY - speed) + "px");
        timer = setTimeout("scrollDown();",50);
    }
}
function scrollUp()
{
    var containerY = parseInt($("#thumbs").css("top"));
    
    var oldY = parseInt($("#thumblist").css("top"));
    if(oldY <= (containerY - 7))
    {
        $("#thumblist").css("top",(oldY + speed) + "px");
        timer = setTimeout("scrollUp();",50);
    }
}
function hideText() 
{
    $(".introText").css("display", "none");
    $("#lblFeatured").css("display", "none");
    
}