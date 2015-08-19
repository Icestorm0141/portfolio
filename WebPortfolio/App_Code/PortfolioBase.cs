using System;
using System.Collections.Generic;
using System.Linq;
using System.Data.Linq;
using System.Web;
using Portfolio.Library;
using Portfolio.WebServices;
using System.Web.UI.WebControls;

/// <summary>
/// Summary description for PortfolioBase
/// </summary>
public class PortfolioBase : System.Web.UI.Page
{
    private int _sectionId = -2;
    protected int SectionId
    {
        get
        {
            if (_sectionId <= 0)
            {
                int.TryParse(Request.QueryString["s"], out _sectionId);
            }
            return _sectionId;
        }
    }

    protected PortfolioLibrary library = new PortfolioLibrary();
    public LINQLibraryDataContext DB = new LINQLibraryDataContext();
    public void LoadSectionImage(Image sectionImage)
    {
        //BIND TITLE IMAGE
        var imageName = (from s in DB.tblSections
                            where s.SectionId == SectionId
                            select s.SectionImageName).FirstOrDefault();
        if(string.IsNullOrEmpty(imageName))
        {
            imageName = "welcome.png";
        }
        sectionImage.ImageUrl = "images/" + imageName;
    }
}