using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.Mvc;
using Portfolio.Library;
using Portfolio.MVC.Helpers;
using Portfolio.MVC.Models;
using Portfolio.WebServices;

namespace Portfolio.MVC.Controllers
{
    public class ProjectsController : BaseController
    {
        private ProjectModel devModel;
        private ProjectModel funModel;

        public ProjectsController(PortfolioContext ent, PortfolioManager manager)
            : base(ent, manager)
        {
            devModel = new ProjectModel()
            {
                PageTitle = "Development Samples",
                SubTitle = "Over the years I've had the priviledge of working for numerous companies.",
                Description = "I've worked on varying types of .NET projects. From SaaS applications, to internal web applications, to public facing websites. ",
                SubDescription = "Here are a few personal projects along with some from my professional career.",
                Note = "Note: due to the nature of some projects, I'm unable to show examples of some of my most recent positions."
            };

            funModel = new ProjectModel()
            {
                PageTitle = "Just for Fun",
                SubTitle = "I have to admit, most of my free time is spent away from the computer.",
                Description = "However, there have been a few projects that I'm particularly fond of that I would love to share.",
                SubDescription = "Here are a few of those fun projects. "
            };
        }
        public ViewResult Index(int id)
        {
            devModel.Projects = _manager.GetProjectsByCategory(id);
            devModel.CategoryId = id;
            devModel.Method = "IndexMvvm";
            return View(devModel);
        }

        public ViewResult IndexMvvm(int id)
        {
            devModel.Projects = _manager.GetProjectsByCategory(id);
            devModel.CategoryId = id;
            devModel.IsMvcVersion = false;
            devModel.Method = "Index";
            return View(devModel);
        }

        public ViewResult Fun(int id)
        {
            funModel.Projects = _manager.GetProjectsByCategory(id);
            funModel.CategoryId = id;
            funModel.Method = "FunMvvm";
            return View("Index", funModel);
        }

        public ViewResult FunMvvm(int id)
        {
            funModel.Projects = _manager.GetProjectsByCategory(id);
            funModel.CategoryId = id;
            devModel.IsMvcVersion = false;
            funModel.Method = "FunMvvm";
            return View("IndexMvvm", funModel);
        }
        public PartialViewResult GetProjectDetails(int id)
        {
            var model = _manager.GetProjectById(id);
            return PartialView("_ProjectMVCDetail", model);
        }

        public JsonNetResult GetProjectsByCategory(int id)
        {
            return new JsonNetResult() { Data = _manager.GetProjectsByCategory(id), JsonRequestBehavior = JsonRequestBehavior.AllowGet };
        }
    }
}
