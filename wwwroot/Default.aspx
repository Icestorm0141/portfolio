<%@ Page Language="C#" AutoEventWireup="true" CodeBehind="Default.aspx.cs" MasterPageFile="/masters/Main.Master" Inherits="WebPortfolio._Default" %>

<asp:Content ContentPlaceHolderID="head" runat="server">
<script language="javascript">
    $(document).ready(function(e) {

        var section = '<%=Request.QueryString["s"] %>';
        if (section == "") section = "welcome";
        $("#s_" + section).css("display", "block");
    });
</script>
<style type="text/css">
#infoPanel
{
	width:800px;
}
.titleImage
{
	margin-left:-10px;
}
</style>
</asp:Content>
<asp:Content ContentPlaceHolderID="ThumbPlaceholder" runat="server">
</asp:Content>
<asp:Content ContentPlaceHolderID="ContentSectionPlaceHolder" runat="server">

		    <asp:Image runat="server" ID="sectionImage" CssClass="titleImage" ImageUrl="/images/" />
    <div id="description">
    <div id="s_welcome" class="section">
    <img src="images/section_pages/IMG_4380_a.jpg" alt="Meet Me!" style="padding:0; margin: 0 0 5px 20px; width:250px; border:5px solid white;" />
    <div style="clear:right; float:right; width:250px; text-align:right;"><em>phone: 413.231.7582<br />
    email: <a href="mailto:ajs2189@rit.edu">ajs2189@rit.edu</a><br />
    <a href="/documents/resume.pdf" target="_blank">my resume</a></em></div>
    <p>
    Hello and welcome to my portfolio! I'm Anna Steglinski, a fourth-year student at Rochester Institute of Technology studying <a href="http://igm.rit.edu/node/142">New Media Interactive Development</a> (New Media I.D.). As a New Media I.D. student I specialize in web development with a focus in ASP.NET developement, and C# web programming with additional experience with <a href="http://www.jquery.com">JQuery</a>. Currently I am completing my final quarter at R.I.T. and am on course to graduate in May 2010. </p> 
    
<p>As a developer I have spent the past four years working with various companies doing part-time and freelance development work. These companies include <a href="http://we.rit.edu">WE@RIT</a>, <a href="http://www.kevinmarkey.com">Kevin Markey</a>, and <a href="http://www.textureplus.com">Texture Plus</a>. I just completed my final co-op at <a href="http://www.grantsoffice.com">Grants Office, LLC</a> where I spent 3 months developing a better search function for their grants database as well as a way to automate the process of creating research reports for their clients. In an ongoing effort to inhance their website I have continued to work with them on a part-time basis over the course of this school year.</p> 
<p>In the summer of 2009 I worked for the <a href="http://www.layer8group.com">Layer 8 Group</a> where I helped develop custom administration pages in VB.NET as well as convert PSD designs into cross-browser compatible HTML/CSS websites that were integrated with DotNetNuke. From the summer of 2008 until January 2009 I worked on the development team at <a href="http://www.nimbleuser.com">NimbleUser</a> <em>(formlerly VanDamme Associates, Inc.)</em> as co-op and part-time worker converting website designs into ASP.NET web projects as well as integrating them with <a href="http://www.ektron.com">Ektron Content Management System.</a></p>

<p>Currently I am looking for full-time or contract employment beginning June 2010. If you have a position available that you believe match my skill set, please contact me via email or phone. I hope to hear from you, but in the meantime have a look around my portfolio.
</p>
    </div>
    <div id="s_5" class="section">
    <a href="http://socialaser.cias.rit.edu"><img src="images/section_pages/header.png" alt="Socialaser" /></a>
    <p style="float:right;clear:right;">
    <a href="http://www.twitter.com/socialaser"><img src="images/section_pages/twittericon.png" alt="Follow Us on Twitter" /></a>
    <a href="http://www.flickr.com/photos/socialaser"><img src="images/section_pages/flickr.png" alt="Flickr Photos" /></a>
    <a href="http://www.vimeo.com/socialaser"><img src="images/section_pages/vimeo.png" alt="Vimeo Videos" /></a>
    </p>
    <h2>What is SociaLaser?</h2>
    <p><a href="http://socialaser.cias.rit.edu">SociaLaser</a> is my New Media Interactive Development senior capstone project. 
    The SociaLaser team consists of 6 members: <br />
    <ul>
        <li>Anna Steglinski (Developer, Project Manager)</li>
        <li><a href="http://www.richardvuong.com">Rich Vuong</a> (Developer)</li>
        <li><a href="http://www.virtualmatter.org">Kevin Whitfield</a> (Hardware)</li>
        <li><a href="http://work.beecombs.com/">Nick Tassone</a> (Designer)</li>
        <li><a href="http://www.jasoncaryl.com">Jason Caryl</a> (Designer)</li>
        <li><a href="http://cias.rit.edu/~tsc2484/portfolio/portfolio.html">Trevor Crandall</a> (Designer)</li>
    </ul> 
    Together we are working to create an <em>"an immersive environment synchronizing laser light mechanics with physical user input through a multi-touch interface and laser light display."</em>
    What does that mean? We are developing a multi-touch table through which users can collaborate to create their own laser light show. </p>
    
    <p>Our project will be showcased at <a href="http://www.rit.edu/imagine/">Imagine RIT</a> on May 1st! Be sure to come check us out. Until then keep up on our progress by visiting our blog: <a href="http://socialaser.cias.rit.edu">http://socialaser.cias.rit.edu</a>.</p>
    
    </div>
    <div id="s_4" class="section">
        <img src="images/section_pages/IMG_4380_a.jpg" alt="Meet Me!" style="padding:0; margin: 0 0 5px 20px; width:250px; border:5px solid white;" />
        <div style="clear:right; float:right; width:250px; text-align:right;"><em>phone: 413.231.7582<br />
        email: <a href="mailto:ajs2189@rit.edu">ajs2189@rit.edu</a><br />
        <a href="/documents/resume.pdf" target="_blank">my resume</a></em></div>
        <p>
        I'm Anna Steglinski! I'm 21 and currently attending Rochester Institute of Technology for <a href="http://igm.rit.edu/node/142">New Media Interactive Development</a> (New Media I.D.). I was born and raised in the Western Massachusetts area, living in Huntington, MA until 2006 when I moved out to Rochester, NY to attend school. I'm in my fourth and final year at R.I.T. and am really looking forward to graduating this coming May and finally have my degree in Web Development, something I've been working towards for about 10 years now.</p> 
        
        <p>I started making websites in 6th grade (2000), creating my first Harry Potter website using Homestead's page maker. Eventually enjoyed this so much I taught myself HTML and began to expand and improve my website. Over the course of a few years it evolved eventually becoming Bludgers 'N Broomsticks. I kept with this site until 10th grade (2004) where I sold it to one of the volunteer staff members that I had "working" for me keeping the information up to date. The site eventually had become a collaborative effort between me and a few volunteers who had various jobs from creating new content, gathering news, or updating content. However the entire site was primarily managed by myself. </p> 
        <p>My junior year of high school I joined with a few other developers to create an online web-hosting business called Revo Hosting. As one of the co-owners I saw to the daily maintence of the website, managed the company's expenditures and helped gather new customers. Eventually as my senior year approached I  had less time to be involved with the company and gave control of it over to one of the other owners. </p>

        <p>In 2006 I started my formal education at R.I.T. in the New Media Interactive Development program (formerly Information Technology - New Media). Since then I have been learning to code and develop in numerous languages such as Actionscript, JavaScript, PHP, HTML, CSS, learning new techniques to make websites more practical and efficient - such as having content driven from a database. As part of my graduation requirements I am required to complete three quarters (each ten weeks long) of full-time paid work in the field of my major (Co-op's). I completed my first block in the summer of 2008 with <a href="http://www.nimbleuser.com">NimbleUser</a>, my second block in the summer of 2009 with the <a href="http://www.layer8group.com">Layer 8 Group</a>, and my final block in the fall of 2009 with the <a href="http://www.grantsoffice.com">Grants Office, LLC.</a>  Over the course of these Co-op's I learned to code and program in ASP.NET with C# and Visual Basic as code behind, getting my hands dirty with SQL Server. This area has become my speciality and is the field I hope to go into after graduation. 
        </p>
        <p>For a full list of my skills please reference my <a href="/documents/resume.pdf" target="_blank">resume</a>.</p>
    </div>
    </div>
</asp:Content>