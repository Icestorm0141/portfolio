using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using Portfolio.Library;


namespace Portfolio.WebServices
{
    public class PortfolioManager
    {
        #region Dependencies
        private PortfolioContext _ent;

        #endregion
        public PortfolioManager(PortfolioContext ent)
        {
            _ent = ent;
        }

        public List<Category> GetCategories()
        {
            var categories = _ent.Categories.OrderBy(c => c.CategoryId).ToList();
            //var categories = new List<Category>
            //{
            //    new Category()
            //    {
            //        Action = "Index",
            //        CategoryId = 1,
            //        Controller = "Projects",
            //        Name = "Work Samples",
            //        IsMobileVisible = true
            //    },
            //    new Category()
            //    {
            //        Action = "Fun",
            //        CategoryId = 1,
            //        Controller = "Projects",
            //        Name = "Just For Fun",
            //        IsMobileVisible = false
            //    },
            //    new Category()
            //    {
            //        Action = "Resume",
            //        CategoryId = 1,
            //        Controller = "Home",
            //        Name = "Resume",
            //        IsMobileVisible = true
            //    }
            //};
            return categories;
            //return _ent.Categories.ToList();
        }

        public List<Project> GetProjectsByCategory(int categoryId)
        {
            var projects = _ent.Projects.Where(p => p.CategoryId == categoryId).ToList()
                .Select(p => new Project()
                {
                    CategoryId = p.CategoryId,
                    Date = p.Date,
                    Description = p.Description,
                    ImageName = p.ImageName,
                    Languages = p.Languages,
                    ProjectId = p.ProjectId,
                    SoftwareUsed = p.SoftwareUsed,
                    Title = p.Title,
                    Url = p.Url
                });
            
            //var projects = new List<Project>
            //{
            //    new Project()
            //    {
            //        CategoryId = 1,
            //        ImageName = "image_0012.jpg",
            //        Title = "Nimble User - New York State Association of Health Care Providers",
            //        Languages = "HTML, CSS, Javascript, XSLT, jQuery, ASP.NET, C#",
            //        Date = new DateTime(2008,08,31)
            //    },
            //    new Project()
            //    {
            //        CategoryId = 1,
            //        ImageName = "image_0013.jpg",
            //        Title = "Nimble User - SIA Online",
            //        Languages = "HTML, CSS, XSLT, jQuery, ASP.NET, C#",
            //        Date = new DateTime(2008,08,30)
            //    }
            //};
            return projects.OrderByDescending( p => p.Date).ToList();
        }

        public Project GetProjectById(int projectId)
        {
            return _ent.Projects.Single(p => p.ProjectId == projectId);
        }
    }
}
