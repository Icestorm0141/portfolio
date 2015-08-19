using System;
using System.Data;
using System.Web.UI.WebControls;
using WebPortfolio.dataaccess;

namespace WebPortfolioOld
{
    public partial class SearchResults : System.Web.UI.Page
    {
        public Image imgThumbPreview; 
        public DataRetriever myDr = new DataRetriever();

        protected void Page_Load(object sender, EventArgs e)
        {
            try
            {
                string strQuery = Request.QueryString["q"];
                DataSet myDS = myDr.SearchPortfolio(strQuery);

                gvSearchResults.DataSource = myDS;
                gvSearchResults.DataBind();
                string strResult = myDS.Tables[0].Rows.Count.ToString();
                if (strResult == "0") lblSupp.Visible = true;
                if (strResult == "1")
                    strResult += " result";
                else strResult += " results";
                lblCount.Text = strResult;
            }
            catch (Exception evt)
            {
                lblError.Text = "Sorry, there appears to be a problem with your query. Please try your search again.";
            }
            //dlThumbs.DataSource = thumbList;
            //dlThumbs.DataBind();
        }
    }
}
