<%@ Page Language="C#" AutoEventWireup="true" CodeFile="Section.aspx.cs" MasterPageFile="~/masters/Main.Master"
    Inherits="WebPortfolio.Section" %>

<asp:Content ContentPlaceHolderID="ThumbPlaceholder" runat="server">
    <div id="thumbPanel">
        <div id="thumbs">
            <asp:Repeater ID="rptThumbs" runat="server" OnItemDataBound="rptThumbs_OnItemDataBound">
                <HeaderTemplate>
                    <ul id="thumblist">
                </HeaderTemplate>
                <ItemTemplate>
                    <li><a iclass="thumb" onclick='loadItem(<%#Eval("Id") %>)'>
                        <asp:Image runat="server" ID="imgThumb" />
                    </a></li>
                </ItemTemplate>
                <FooterTemplate>
                    </ul>
                </FooterTemplate>
            </asp:Repeater>
        </div>
        <img src="images/arrow_up.png" title="Hold for faster scrolling" id="up" class="arrow"
            alt="Scroll up" />
        <img src="images/arrow_down.png" title="Hold for faster scrolling" id="down" class="arrow"
            alt="Scroll down" />
    </div>
</asp:Content>
<asp:Content ContentPlaceHolderID="ContentSectionPlaceHolder" runat="server">

    <asp:Image runat="server" ID="imgSectionHeader" CssClass="titleImage" />
    <div id="s_1" class="introText">
        <p>
            Since 2007 I have been working with professional clients and companies to develop
            websites. Originally I coded in HTML using PHP in the backend enabling me to expand
            my knowledge with server-side code to create more dynamically driven websites. In
            the summer of 2008 I began working with a small development company, <a href="http://www.nimbleuser.com">
                NimbleUser</a>, where I quickly picked up ASP.NET and C#. Since then my professional
            focus in web development has been using ASP.NET with C# codebehind or Visual Basic.</p>
    </div>
    <div id="s_2" class="introText">
        <p>
            As a Freshman at R.I.T. I began learning to code in ActioSnsript 2.0, followed by
            Actionscript 3.0 in 2007. This was the first Object Oriented coding language I ever
            programmed in and soon began to love it. Earlier versions of my portfolio were programmed
            in Actionscript 3.0, versions I still play around with attempting to increase the
            efficiency and extend my knowledge of the language.</p>
    </div>
    <div id="s_3" class="introText">
        <p>
            Part of my education as a New Media Interactive Development student included classes
            in design and animation. While design has never been my speciality, I have learned
            the basics and can come up with designs and offer input when needed and required.
            In the winter quarter of 2010 I completed a 2D animation class and continued on
            to a 3D animation class to further develop my skills in design and animation.</p>
    </div>
    <asp:HiddenField runat="server" ID="hdnItemId" />
    <div id="itemSection">
        <div class="imageDiv">
            <asp:Image ID="imgPreview" runat="server" CssClass="itemPreview" Visible="false" />
            <br />
            <asp:HyperLink ID="hypExpand" runat="server" CssClass="expandText largeImage hidden"
                Text="View Larger Image" />
            <br />
            <asp:HyperLink ID="hypCode" runat="server" CssClass="expandText code hidden" Target="Steglinski_Code" />
            <br />
        </div>
        <div class="detailsDiv">
            <h3>
                <asp:Label runat="server" ID="lblTitle"></asp:Label></h3>
            <asp:Label ID="lblDate" runat="server" />
            <p id="languages">
                <asp:Label runat="server" ID="lblLanguageLabel" CssClass="label hidden" Text="Languages: " />
                <asp:Label runat="server" ID="lblLanguages" /></p>
            <p id="software">
                <asp:Label runat="server" ID="lblSoftwareLabel" CssClass="label hidden" Text="Software: "></asp:Label>
                <asp:Label runat="server" ID="lblSoftware" /></p>
            <asp:Panel runat="server" ID="pnlDescription"><asp:Literal runat="server" ID="litDescription"></asp:Literal>
            </asp:Panel>
            <asp:Label runat="server" ID="lblError" />
        </div>
    </div>
    <div id="imageModal">
        <img id="largeImage" style="width:800px;" />
    </div>
</asp:Content>
<asp:Content ID="Content1" runat="server" ContentPlaceHolderID="head">

    <script language="javascript" type="text/javascript">
        $(document).ready(function (e) {

            $("#lblFeatured").css("display", "block");
            var section = '<%=Request.QueryString["s"] %>';
            $("#s_" + section).css("display", "block");

            $("#imageModal").dialog({
                autoOpen: false,
                width: 850,
                height:600,
                resizable: false,
                open: function (type, data) {
                    $(this).parent().appendTo("form");
                }
            });
        });
        function loadItem(itemId) {
            WebPortfolio.Ajax.WebPortfolio.GetItem(itemId, function (results) {
                if (results != null) {
                    var expandText = $("#<%=hypExpand.ClientID %>");
                    var codeText = $("#<%=hypCode.ClientID %>");
                    hideText();
                    $("#<%=lblTitle.ClientID %>").html(results.Title);
                    $("#<%=lblDate.ClientID %>").html(results.Date);
                    $("#<%=imgPreview.ClientID %>").attr("src", results.PreviewImage);
                    $("#<%=pnlDescription.ClientID %>").html(results.Description);
                    if (results.ExpandText != "" || results.ExpandText != "None") {

                        expandText.html(results.ExpandText).unbind("click");
                        if (results.Url != "" && results.Url != "None") {
                            expandText.attr({
                                href: results.Url,
                                target: "_blank"
                            });
                        }
                        else {
                            expandText.attr("href","").click(function () {
                                $("#imageModal").dialog("open");
                                return false;
                            });
                            $("#imageModal").dialog("option","title", results.Title);
                            $("#largeImage").attr({
                                src: results.FullImage,
                                alt: results.title
                            });
                        }
                        expandText.removeClass("hidden");
                    }
                    else {
                        expandText.addClass("hidden");
                    }

                    if (results.Languages != "") {
                        $("#<%=lblLanguages.ClientID %>").html(results.Languages);
                        $("#languages span").removeClass("hidden");
                    }
                    else {
                        $("#languages span").addClass("hidden");
                    }

                    if (results.Software != "") {
                        $("#<%=lblSoftware.ClientID %>").html(results.Software);
                        $("#software").removeClass("hidden");
                    }
                    else {
                        $("#software").addClass("hidden");
                    }

                    if (results.CodeUrl != "") {
                        codeText.html("View the Code");
                        codeText.attr("href", results.CodeUrl);
                        codeText.removeClass("hidden");
                    }
                    else {
                        codeText.addClass("hidden");
                    }
                }
            });
            return false;
        }
    </script>

</asp:Content>
