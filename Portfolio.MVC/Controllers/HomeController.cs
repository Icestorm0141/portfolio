using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.Mvc;
using Portfolio.Library;
using Portfolio.MVC.Helpers;
using Portfolio.WebServices;

namespace Portfolio.MVC.Controllers
{
    public class HomeController : BaseController
    {
        public HomeController(PortfolioContext ent, PortfolioManager manager)
            : base(ent, manager)
        {
            
        }

        public JsonNetResult GetMenuItems()
        {
            return new JsonNetResult() { Data = _manager.GetCategories()};
        }
        public ActionResult Index()
        {
            return View("Index");
        }

        public ViewResult Resume()
        {
            return View("Resume");
        }

    }
}
