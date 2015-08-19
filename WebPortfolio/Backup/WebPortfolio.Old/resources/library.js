// JavaScript Document
var timer;
var speed = 10;
function focusSearch() {
    if ($(".search").val() == "search") {
        $(".search").val("");
    }
}
function swapContent(toContent) {
    var fadeFrom;
    var fadeTo;
    var newTop = 0; //$("#s_welcome").offset().top;
    $("#description").children().each(function(i) {
        //$(this).css("top", $("#s_welcome").css("top"));
        if (i != 0) {
            $(this).css("top", "-" + newTop + "px");
        }
        newTop += $(this).height() + 10;
        if ($(this).css("display") == "block") {
            fadeFrom = this;
        }
    });
    //var section = '<%=Request.QueryString["s"] %>';
    //if (section == "") section = "welcome";
    fadeTo = "#s_" + toContent;
    //fadeFrom = "#s_welcome";
    $(fadeFrom).removeClass("section");
    $(fadeFrom).fadeOut("slow", function() { $(this).css("visibility", "hidden").css("display", "block"); });
    $(fadeTo).fadeIn("slow", function() { $(this).css("visibility", "visible"); });
}
$(document).ready(function() {

    $(".search").focusout(function() { if ($(this).val() == "") $(this).val("search"); });

    //----CREATING THE MENU 'IMAGE SWAPS' ----//
    $('#menu li img.swap').mouseover(function() {
        $(this).css("top", "0px");
    }).mouseout(function() { $(this).css("top", "-97px"); });

    //--- CREATING THE FADE EFFECTS ON THE SECTION THUMBS ---//
    $("#thumblist li img").mouseover(function() {
        $(this).fadeTo("slow", 1);
    }).mouseout(function() {
        $(this).fadeTo("slow", .3);
    }).css("opacity", .3);

    $('.search').keyup(function(e) {
        if (e.keyCode == 13) {
            window.location.href = "SearchResults.aspx?q=" + $('.search').val();
            return false;
        }
    });
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