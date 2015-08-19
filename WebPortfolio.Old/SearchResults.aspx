<%@ Page Language="C#" AutoEventWireup="true" CodeBehind="SearchResults.aspx.cs" MasterPageFile="/masters/Main.Master" Inherits="WebPortfolioOld.SearchResults" %>

<asp:Content ContentPlaceHolderID="head" runat="server">
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
		    <asp:Image runat="server" ID="sectionImage" CssClass="titleImage" ImageUrl="/images/search_section.png" /><br />
        <p>Your search came back with <asp:Label runat="server" ID="lblCount" />.
        <asp:Label runat="server" ID="lblSupp" Text="Please try your search again" Visible="false" /><br />
        <asp:Label runat="server" ID="lblError" /></p>
    <asp:GridView ID="gvSearchResults" runat="server" AllowPaging="true" AllowSorting="true" PageSize="50" AutoGenerateColumns="false" DataKeyNames="ItemId"  GridLines="None">
        <HeaderStyle CssClass="searchResultsHeader"/>
        <RowStyle CssClass="searchResults" VerticalAlign="Top"/>
        <Columns>
			<asp:TemplateField>
				<ItemStyle CssClass="tableContent" VerticalAlign="Top" Width="90" BorderStyle="None" />
				<ItemTemplate>
                        <asp:Image runat="server" ID="thumbImage" ImageUrl='<%#"/images/thumbs/" + Eval("SectionFolderName") + "/" + Eval("ItemImageName")%>' AlternateText='<%#Eval("ItemId") %>' />
				</ItemTemplate>
			</asp:TemplateField>
			<asp:HyperLinkField SortExpression="ItemTitle" DataTextField="ItemTitle" DataNavigateUrlFields="SectionId,ItemId" DataNavigateUrlFormatString="Section.aspx?s={0}&i={1}" HeaderText="Title" />
			<asp:BoundField DataField="ItemLanguage" SortExpression="ItemLanguage" HeaderText="Languages" />
			<asp:BoundField DataField="ItemSoftware" SortExpression="ItemSoftware" HeaderText="Software" />
			<asp:TemplateField HeaderText="Date Created" ItemStyle-Width="15%" SortExpression="ItemDate">
				<ItemTemplate>
				    <%# ((DateTime)Eval("ItemDate")).ToString("MMMM yyyy")%>
				</ItemTemplate>
			</asp:TemplateField>
        </Columns>
        <PagerStyle HorizontalAlign="Center" VerticalAlign="Middle" />
    </asp:GridView>
</asp:Content>