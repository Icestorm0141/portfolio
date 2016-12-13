using System.Web.Mvc;
using Portfolio.Library;
using Portfolio.WebServices;

namespace Portfolio.Angular.Controllers
{
    public class HomeController : BaseController
    {
        public HomeController(PortfolioContext ent, PortfolioManager manager)
            : base(ent, manager)
        {
            
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
