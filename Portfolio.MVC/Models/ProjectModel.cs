using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using Portfolio.Library;

namespace Portfolio.MVC.Models
{
    public class ProjectModel
    {
        public string PageTitle { get; set; }
        public string SubTitle { get; set; }
        public string Description { get; set; }
        public string SubDescription { get; set; }
        public string Note { get; set; }
        public int CategoryId { get; set; }
        public bool IsMvcVersion { get; set; }
        public string Method { get; set; }

        public string LinkLabel
        {
            get {
                return IsMvcVersion ? "See this page bound with MVVM" : "See this page bound with MVC";
            }
        }

        public List<Project> Projects { get; set; }

        public ProjectModel()
        {
            IsMvcVersion = true;
        }
    }
}