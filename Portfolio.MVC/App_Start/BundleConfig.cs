using System.Web;
using System.Web.Optimization;

namespace Portfolio.MVC
{
    public class BundleConfig
    {
        public static void RegisterBundles(BundleCollection bundles)
        {
            bundles.Add(new ScriptBundle("~/bundles/jquery").Include(
                        "~/Scripts/jquery-1.*"));


            bundles.Add(new StyleBundle("~/Content/css").Include("~/Content/site.css"));

        }
    }
}