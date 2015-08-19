<%@ Page Language="C#" AutoEventWireup="true" CodeFile="Default.aspx.cs" MasterPageFile="~/masters/Main.Master"
    Inherits="WebPortfolio.Default" %>

<asp:Content ContentPlaceHolderID="head" runat="server">

    <script language="javascript" type="text/javascript">
        $(document).ready(function (e) {

            var section = '<%=Request.QueryString["s"] %>';
            if (section == "") section = "welcome";
            $("#s_" + section).show();


        });
    </script>

    <style type="text/css">
        #infoPanel { width: 800px; }
        .titleImage { margin-left: -10px; }
    </style>
</asp:Content>
<asp:Content ContentPlaceHolderID="ThumbPlaceholder" runat="server">
</asp:Content>
<asp:Content ContentPlaceHolderID="ContentSectionPlaceHolder" runat="server">
    <asp:Image runat="server" ID="imgSectionHeader" CssClass="titleImage" AlternateText="Welcome!" />
    <div id="description">
        <div id="s_welcome" class="section">
            <img src="images/section_pages/IMG_4380_a.jpg" alt="Meet Me!" style="padding: 0;
                margin: 0 0 5px 20px; width: 250px; border: 5px solid white;" />
            <div style="clear: right; float: right; width: 250px; text-align: right;">
                <em>phone: 585.732.9515<br />
                    email: <a href="mailto:anna.steglinski@gmail.com">anna.steglinski@gmail.com</a><br />
                    <a href="/documents/resume.pdf" target="_blank">my resume</a></em></div>
            <p>
                My name is Anna Steglinski. I'm a graduate (May 2010) of Rochester Institute of
                Technology where I studied <a href="http://igm.rit.edu/node/142">New Media Interactive
                    Development</a> (New Media I.D.). As a New Media I.D. student, my education
                focused on web development using PHP and Flash. In contrast, my professional career
                has almost solely been using ASP.NET, and C#. Currently I am a .NET Developer for
                <a href="http://www.ehealthtechnologies.net">eHealth Technologies</a>, a position
                that I started in January 2013.
            </p>
            <p>
                Upon graduating from RIT, I accepted a position with <a href="http://www.brandintegrity.com">
                    Brand Integrity</a>; a local software company that specializes in employee engagement.
                I was hired as the sole full-time developer in 2010 and was responsible for providing customer support as well as bug
                fixes and the development of new features for their proprietary software <a href="http://www.potentialpoint.com">
                    Potential Point</a>. In
                the two and half years that I was with <a href="http://www.brandintegrity.com">Brand
                    Integrity</a> the team grew to three full time developers along with a few interns
                from RIT. Together we worked within the agile framework of SCRUM to complete 2-4
                week sprints and monthly releases. With the growth of the team my responsibilities
                grew to include mentoring the interns, helping them learn how to program in a business
                environment, which was a role that I found both challenging and rewarding. In the
                future I hope to continue to have the opportunity to mentor young developers in
                order to give them the same opportunities I had as a student.
            </p>
            <p>
                In my four years at RIT, I held a number of freelance and part-time web development
                jobs during the school year. During the summers between classes I completed 3 three-month
                internships with local web development and software companies. From the summer of
                2008 until January 2009 I worked on the development team at <a href="http://www.nimbleuser.com">
                    NimbleUser</a> <em>(formerly VanDamme Associates, Inc.)</em> as co-op and part-time
                worker converting website designs into ASP.NET web projects as well as integrating
                them with <a href="http://www.ektron.com">Ektron Content Management System.</a>.
                In the summer of 2009 I worked for the <a href="http://www.layer8group.com">Layer 8
                    Group</a> where I helped develop custom administration pages in VB.NET as well
                as convert PSD designs into cross-browser compatible HTML/CSS websites that were
                integrated with DotNetNuke. In the fall of 2009 I completed my final co-op at <a
                    href="http://www.grantsoffice.com">Grants Office, LLC</a> where I spent 3 months
                developing a better search function for their grants database as well as a way to
                automate the process of creating research reports for their clients. In an ongoing
                effort to enhance their website I continued to work with them on a part-time basis
                over the course of my final year in college.</p>
            <p>
                I am not actively seeking employment opportunities; however I am always willing
                to hear what opportunities are available. Please feel free to <a href="mailto: anna.steglinski@gmail.com">
                    contact me</a> with anything you feel I might be interested in.
            </p>
        </div>
        <div id="s_4" class="section">
            <img src="images/section_pages/IMG_4380_a.jpg" alt="Meet Me!" style="padding: 0;
                margin: 0 0 5px 20px; width: 250px; border: 5px solid white;" />
            <div style="clear: right; float: right; width: 250px; text-align: right;">
                <em>phone: 585.732.9515<br />
                    email: <a href="mailto:anna.steglinski@gmail.com">anna.steglinski@gmail.com</a><br />
                    <a href="/documents/resume.pdf" target="_blank">my resume</a></em></div>
            
        </div>
    </div>
</asp:Content>
