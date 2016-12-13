using System.Web.Mvc;
using Portfolio.Library;
using Portfolio.WebServices;

namespace Portfolio.Angular.Controllers
{
    public class BaseController : Controller
    {
        protected readonly PortfolioContext _ent;
        protected readonly PortfolioManager _manager;

        public BaseController(PortfolioContext ent, PortfolioManager manager)
        {
            _ent = ent;
            _manager = manager;
            ViewBag.Categories = _manager.GetCategories();
        }
    }
}
