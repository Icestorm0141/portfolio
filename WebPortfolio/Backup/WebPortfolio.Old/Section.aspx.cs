using System;
using System.Collections.Generic;
using System.Data;
using System.Web.UI;
using System.Web.UI.WebControls;
using WebPortfolio.dataaccess;

namespace WebPortfolioOld
{
    public partial class _Section : System.Web.UI.Page
    {
        public Image imgThumbPreview; 
        public DataRetriever myDr = new DataRetriever();

        protected void Page_Load(object sender, EventArgs e)
        {
            string strRequest = Request.QueryString["s"];
            if (strRequest == "" || strRequest == null) Response.Redirect("Default.aspx");
            if(!Page.IsPostBack)
            {
                string strItem = Request.QueryString["i"];
                try
                {
                    //BIND TITLE IMAGE
                    sectionImage.ImageUrl += myDr.GetSectionImage(strRequest);
                }
                catch (Exception evt)
                {
                    lblError.Text = evt.Message;
                }
                if (strItem != null)
                {
                    //SHOW ITEM REQUESTED IN THE URL 
                    try
                    {
                        Dictionary<string, string> itemData = myDr.GetItemDetails(strItem);
                        ViewImage(itemData);
                    }
                    catch (Exception evt)
                    {
                        lblError.Text = "Sorry, the request you made was not valid. Please click one of the section links above to view items in my portfolio.";
                    }

                }
                else
                {
                    try
                    {
                        //GET FEATURED ITEM
                        Dictionary<string, string> itemData = myDr.GetFeaturedItem(strRequest);
                        ViewImage(itemData);
                    }
                    catch (Exception evt)
                    {
                        lblError.Text = "Sorry, something appears to have gone wrong. Try your task again.";
                    }
                }

                try
                {
                    //GET LIST OF THUMBS
                    DataSet thumbList = myDr.GetThumbs(strRequest);
                    lvThumbs.DataSource = thumbList;
                    lvThumbs.DataBind();

                    LinkButton btnThumbLink = (LinkButton)lvThumbs.Items[2].FindControl("ThumbLink");

                    imgThumbPreview = (Image)lvThumbs.Items[2].FindControl("thumbImage");
                    ((WebPortfolioOld.masters.Main)Master).smScriptManagerProp.RegisterAsyncPostBackControl(btnThumbLink);
                }
                catch (Exception evt)
                {
                    lblError.Text = "Sorry, there was a problem loading the thumbnails for the section you requested. Please click one of the current sections on the navigation above.";
                    pnlThumbs.Visible = false;
                }
            }
            
            //dlThumbs.DataSource = thumbList;
            //dlThumbs.DataBind();
        }
        protected void LoadImage(object sender, EventArgs e)
        {
            //LOAD THE IMAGE CLICKED

            //Response.Write("hi!");
            //lblError.Text = "It worked!";
            LinkButton senderLink = (LinkButton)sender;
            imgThumbPreview = (Image)senderLink.FindControl("thumbImage");
            Dictionary<string, string> itemData = myDr.GetItemDetails(imgThumbPreview.AlternateText);
            lblItemId.Text = imgThumbPreview.AlternateText;
            ViewImage(itemData);

            pnlUpdateContent.Update();
        }
        protected void ViewImage(Dictionary<string, string> itemData)
        {
            //LOAD THE PREVIEW IMAGE
            itemPreview.ImageUrl = "/images/preview/" + itemData["ItemFolderName"] + "/" + itemData["ItemImageName"];
            lblTitle.InnerText = itemData["ItemTitle"];         //DISPLAY TITLE
            DateTime itemDate = Convert.ToDateTime(itemData["ItemDate"]);       //CONVERT SQL DATETIME TO C#
            lblDate.InnerText = String.Format("{0:MMMM yyyy}", itemDate);       //DISPLAY DATE OF ITEM

            //BELOW IS FOR A MORE NORMALIZED DATABASE WITH SOFTWARE AND LANGUAGES IN THEIR OWN TABLES
            //THIS WAS NOT PRACTICAL FOR THE SIZE OF MY PORTFOLIO
            //
            //ArrayList arrLang = myDr.GetLanguages(itemData["ItemId"]);
            //if (arrLang.Count > 0)
            //{
            //    string strLanuages = arrLang[0].ToString();
            //    for (int count = 1; count < arrLang.Count; count++)
            //    {
            //        strLanuages += ", " + arrLang[count].ToString();
            //    }
            //    lblLanguages.Text = "<strong>Programming Languages: </strong>" + strLanuages;
            //}
            //ArrayList arrSoft = myDr.GetSoftware(itemData["ItemId"]);
            //if (arrLang.Count > 0)
            //{
            //    string strSoftware = arrSoft[0].ToString();
            //    for (int count = 1; count < arrSoft.Count; count++)
            //    {
            //        strSoftware += ", " + arrSoft[count].ToString();
            //    }
            //    lblSoftware.Text = "<strong>Software: </strong>" + strSoftware;
            //}

            lblLanguages.Text = "<strong>Programming Languages: </strong>" + itemData["ItemLanguage"];      //DISPLAY LANGUAGES OF ITEM
            lblSoftware.Text = "<strong>Software: </strong>" + itemData["ItemSoftware"];        //DISPLAY SOFTWARE USED
            lblDescription.InnerHtml = itemData["ItemDescription"];     //DISPLAY THE DESCRIPTION

            //IF THERE IS A LARGER IMAGE OR EXAMPLE, DISPLAY THE LINK
            lblExpand.Text = itemData["ExpandText"];
            lblExpand.Visible = true;

            //IF THERE IS A CODE SAMPLE AVAILABLE, DISPLAY THE LINK
            if (itemData["ItemCodeUrl"] != null && itemData["ItemCodeUrl"] != "")
            {
                lblCode.Text = "View Code Example";
                lblCode.NavigateUrl = "/images/fullsize/" + itemData["ItemFolderName"] + "/" + itemData["ItemCodeUrl"];
            }
            else
            {
                lblCode.Text = "";
            }

            //IF THERE IS A WEBSITE AVAILABLE, SHOW THE LINK
            string fullUrl = "/images/fullsize/" + itemData["ItemFolderName"] + "/";
            if (itemData["ItemWebUrl"].Contains("http://"))
            {
                fullUrl = itemData["ItemWebUrl"];
            }
            else if (itemData["ItemWebUrl"] == "None")
            {
                fullUrl = "";
                lblExpand.Visible = false;
            }
            else if (itemData["ItemWebUrl"] != "" && itemData["ItemWebUrl"] != null)
            {
                fullUrl += itemData["ItemWebUrl"];
            }
            else
            {
                fullUrl += itemData["ItemImageName"];
            }
            lblExpand.Target = "SteglinskiPortfolio";
            lblExpand.NavigateUrl = fullUrl;

            itemPreview.Visible = true;

        }
    }
}
