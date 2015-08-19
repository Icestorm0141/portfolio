using System;
using System.Web.UI;
using System.Web.UI.WebControls;
using WebPortfolio.dataaccess;

namespace WebPortfolioOld
{
    public partial class _Default : System.Web.UI.Page
    {
        public Image imgThumbPreview; 
        public DataRetriever myDr = new DataRetriever();

        protected void Page_Load(object sender, EventArgs e)
        {
            DateTime bday = new DateTime(1988, 03, 23);
            litAge.Text = (DateTime.Now.Year - bday.Year).ToString();
            if(!Page.IsPostBack)
            {
                string sectionUrl = "";
                try
                {
                    //BIND TITLE IMAGE
                    sectionUrl = myDr.GetSectionImage(Request.QueryString.Get("s"));
                }
                catch (Exception evt)
                {
                    //IF I CANNOT FIND THE SECTION IN THE DATABASE, DEFAULT TO THE WELCOME URL
                    //lblError.Text = evt.Message;
                    sectionUrl = "welcome.png";
                }

                sectionImage.ImageUrl += sectionUrl;
            }
            
        }
    }
}
