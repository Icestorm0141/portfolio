using System;
using System.Web.UI;
using System.Linq;

namespace WebPortfolio
{
    public partial class Default : PortfolioBase
    {
        protected void Page_Load(object sender, EventArgs e)
        {
            //DateTime bday = new DateTime(1988, 03, 23);
            //litAge.Text = (DateTime.Now.Year - bday.Year).ToString();
            if (!Page.IsPostBack)
            {
                LoadSectionImage(imgSectionHeader);
            }

        }
    }
}
