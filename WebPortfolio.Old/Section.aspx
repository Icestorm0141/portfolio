<%@ Page Language="C#" AutoEventWireup="true" CodeBehind="Section.aspx.cs" MasterPageFile="/masters/Main.Master" Inherits="WebPortfolioOld._Section" %>
<asp:Content runat="server" ContentPlaceHolderID="head">
<script language="javascript" type="text/javascript">
    $(document).ready(function(e) {

        $("#lblFeatured").css("display", "block");
        var section = '<%=Request.QueryString["s"] %>';
        var item = '<%=Request.QueryString["i"] %>';
        $("#s_" + section).css("display", "block");
        if (item != null && item != "") {
        hideText();
        }
    });
</script>
</asp:Content>
<asp:Content ContentPlaceHolderID="ThumbPlaceholder" runat="server">
<div id="thumbPanel">
    <div id="thumbs">
        <asp:Panel runat="server" ID="pnlThumbs">
            <asp:UpdatePanel runat="server" ID="pnlThumbUpdate" UpdateMode="Conditional" ChildrenAsTriggers="false">
                <ContentTemplate>
                    <asp:ListView ID="lvThumbs" runat="server" ItemPlaceholderID="itemsGoHere">
                        <LayoutTemplate>
                           <ul id="thumblist">
                             <asp:PlaceHolder runat="server" ID="itemsGoHere"></asp:PlaceHolder>
                          </ul>
                        </LayoutTemplate>
                        <ItemTemplate>
                            <li>
                                <asp:LinkButton runat="server" OnClick="LoadImage" ID="ThumbLink" OnClientClick="hideText();">
                                    <asp:Image runat="server" ID="thumbImage" ImageUrl='<%#"/images/thumbs/" + Eval("SectionFolderName") + "/" + Eval("ItemImageName")%>' AlternateText='<%#Eval("ItemId") %>' />
                                </asp:LinkButton>
                            </li>
                        </ItemTemplate>
                    </asp:ListView> 
                </ContentTemplate>
            </asp:UpdatePanel>
        </asp:Panel> 
    </div>
    <img src="/images/arrow_up.png" title="Hold for faster scrolling" id="up" class="arrow" alt="Scroll up" />
    <img src="/images/arrow_down.png" title="Hold for faster scrolling" id="down" class="arrow" alt="Scroll down" />
</div>
</asp:Content>
<asp:Content ContentPlaceHolderID="ContentSectionPlaceHolder" runat="server">
    <asp:Image runat="server" ID="sectionImage" CssClass="titleImage" ImageUrl="/images/" />
    <div id="s_1" class="introText">
        <p>Since 2007 I have been working with professional clients and companies to develop websites. Originally I coded in HTML using PHP in the backend enabling me to expand my knowledge with server-side code to create more dynamically driven websites. In the summer of 2008 I began working with a small development company, <a href="http://www.nimbleuser.com">NimbleUser</a>, where I quickly picked up ASP.NET and C#. Since then my professional focus in web development has been using ASP.NET with C# codebehind or Visual Basic, a focus I hope to continue after graduation.</p>
    </div>
    <div id="s_2" class="introText">
        <p>As a Freshman at R.I.T. I began learning to code in ActioSnsript 2.0, followed by Actionscript 3.0 in 2007. This was the first Object Oriented coding language I ever programmed in and soon began to love it. Earlier versions of my portfolio were programmed in Actionscript 3.0, versions I still play around with attempting to increase the efficiency and extend my knowledge of the language.</p>
    </div>
    <div id="s_3" class="introText">
        <p>Part of my education as a New Media Interactive Development student includes classes in design and animation. While design has never been my speciality, I have learned the basics and can come up with designs and offer input when needed and required. In the winter quarter of 2010 I completed a 2D animation class and this quarter I am furthering this by taking a 3D animation class to further develop my skills in design and animation.</p>
    </div>
    <asp:UpdatePanel runat="server" ID="pnlUpdateContent" UpdateMode="Conditional">
    <Triggers>
    </Triggers>
        <ContentTemplate>
        <asp:Label runat="server" ID="lblItemId" Visible="false" />
		    
		    <div id="itemSection">
		    <div class="imageDiv">
                <asp:Image ID="itemPreview" runat="server" CssClass="itemPreview" Visible="false" />
                <br />
                <asp:HyperLink ID="lblExpand" runat="server" CssClass="expandText" Text="View Larger Image" />
                <br />
                <asp:HyperLink ID="lblCode" runat="server" CssClass="expandText" Target="Steglinski_Code" />
		        <br />
            </div>
		        <div class="detailsDiv">
		        <h3 id="lblFeatured" style="display:none;">Featured Item</h3>
                <h3 style="margin-bottom:-10px;" runat="server" id="lblTitle"></h3>
                <p id="lblDate" runat="server"></p>
                <p id="languages"><asp:Label runat="server" ID="lblLanguages" /></p>
                <p id="software"><asp:Label runat="server" ID="lblSoftware" /></p>
                <p runat="server" ID="lblDescription"></p>
                <asp:Label runat="server" ID="lblError" />
                </div>
            </div>
        </ContentTemplate>
    </asp:UpdatePanel>
</asp:Content>