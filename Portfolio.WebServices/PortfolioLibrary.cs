using System;
using System.Collections.Generic;
using System.Linq;
using System.Data.Linq;
using System.Text;
using Portfolio.WebServices.DAO;
using Portfolio.Library;

namespace Portfolio.WebServices
{
    public class PortfolioLibrary
    {
        protected LINQLibraryDataContext DB = new LINQLibraryDataContext();

        public List<PortfolioAJAX> GetSection(int sectionId)
        {
            return (from s in DB.tblPortfolios
                    where s.ItemSectionId == sectionId
                    orderby s.ItemDate descending
                    select PortfolioAJAX.GetSerializedObject(s)).ToList();
        }
        public PortfolioAJAX GetItem(int itemId)
        {
            return (from p in DB.tblPortfolios
                    where p.ItemId == itemId
                    select PortfolioAJAX.GetSerializedObject(p)).FirstOrDefault();
        }
        public PortfolioAJAX GetFeaturedItem(int sectionId)
        {
            return (from f in DB.tblFeaturedItems
             where f.tblSection.SectionId == sectionId
             select PortfolioAJAX.GetSerializedObject(f.tblPortfolio)).FirstOrDefault();
        }
    }
}
