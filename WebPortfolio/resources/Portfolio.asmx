<%@ WebService Language="C#" Class="WebPortfolio.Ajax.WebPortfolio" %>

using System;
using System.Web;
using System.Web.Services;
using System.Web.Services.Protocols;
using Portfolio.WebServices.DAO;
using Portfolio.WebServices;
using System.Collections.Generic;

namespace WebPortfolio.Ajax
{
    [WebService(Namespace = "http://tempuri.org/")]
    [WebServiceBinding(ConformsTo = WsiProfiles.BasicProfile1_1)]
    // To allow this Web Service to be called from script, using ASP.NET AJAX, uncomment the following line. 
    [System.Web.Script.Services.ScriptService]
    public class WebPortfolio : System.Web.Services.WebService
    {

        [WebMethod]
        public List<PortfolioAJAX> GetSection(int sectionId)
        {
            return new PortfolioLibrary().GetSection(sectionId);
        }

        [WebMethod]
        public PortfolioAJAX GetItem(int itemId)
        {
            var returnValue = new PortfolioLibrary().GetItem(itemId);
            return returnValue;
        }
    }
}