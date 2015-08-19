using System.Web;
using System.Web.Optimization;

namespace MFBlog
{
    public class BundleConfig
    {
        public static void RegisterBundles(BundleCollection bundles)
        {
            bundles.Add(new ScriptBundle("~/bundles/jquery").Include(
                        "~/Scripts/jquery-2.*"));

            bundles.Add(new StyleBundle("~/bundles/css").Include("~/Content/site.css"));

        }
    }
}