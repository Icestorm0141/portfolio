using System;
using System.Linq;
using System.Web.UI;
using System.Web.UI.WebControls;
using Portfolio.Library;
using Portfolio.WebServices.DAO;
using System.Web;
using System.Collections.Generic;

namespace WebPortfolio
{
    public partial class Section : PortfolioBase
    {
        protected void Page_Load(object sender, EventArgs e)
        {
            if(!Page.IsPostBack)
            {
                    LoadSectionImage(imgSectionHeader);
                    var images = library.GetSection(SectionId);
                    rptThumbs.DataSource = images;
                    rptThumbs.DataBind();
                    LoadFeatured();
            }
            
        }

        protected void rptThumbs_OnItemDataBound(object sender, RepeaterItemEventArgs e)
        {
            if (e.Item.ItemType == ListItemType.Item || e.Item.ItemType == ListItemType.AlternatingItem)
            {
                PortfolioAJAX item = (PortfolioAJAX)e.Item.DataItem;
                Image imgThumb = (Image)e.Item.FindControl("imgThumb");

                imgThumb.ImageUrl = item.ThumbImage;
                imgThumb.AlternateText = item.Title;
            }
        }

        protected void LoadFeatured()
        {
            var featuredItem = library.GetFeaturedItem(SectionId);
            if (featuredItem != null)
            {
                imgPreview.Visible = true;
                lblTitle.Text = featuredItem.Title;
                lblDate.Text = featuredItem.Date;
                litDescription.Text = featuredItem.Description;
                imgPreview.ImageUrl = featuredItem.PreviewImage;
                if(!string.IsNullOrEmpty(featuredItem.Languages))
                {
                    lblLanguageLabel.CssClass = lblLanguageLabel.CssClass.Replace("hidden", "");
                    lblLanguages.Text = featuredItem.Languages;
                }
                if (!string.IsNullOrEmpty(featuredItem.Software))
                {
                    lblSoftwareLabel.CssClass = lblSoftwareLabel.CssClass.Replace("hidden", "");
                    lblSoftware.Text = featuredItem.Software;
                }
                if (!string.IsNullOrEmpty(featuredItem.Url))
                {
                    hypExpand.CssClass = hypExpand.CssClass.Replace("hidden", "");
                    hypExpand.NavigateUrl = featuredItem.Url;
                    hypExpand.Target = "_blank";
                    hypExpand.Text = featuredItem.ExpandText;
                }
                if (!string.IsNullOrEmpty(featuredItem.CodeUrl))
                {
                    hypCode.CssClass = hypCode.CssClass.Replace("hidden", "");
                    hypCode.NavigateUrl = featuredItem.CodeUrl;
                }
            };
        }
    }
}
