using System.Web;
using System.Web.Optimization;

namespace Portfolio.MVC
{
    public class BundleConfig
    {
        public static void RegisterBundles(BundleCollection bundles)
        {
            bundles.Add(new ScriptBundle("~/bundles/angularBaseScripts").Include(
                        "~/Scripts/jquery-{version}.js",
                        "~/Scripts/bootstrap.js",
                        "~/Scripts/angular.js"));

            bundles.Add(new ScriptBundle("~/bundles/appScripts").Include(
                        "~/app/js/app.js",
                        "~/Scripts/projectModel.js",
                        "~/app/js/controllers.js"));

            bundles.Add(new ScriptBundle("~/bundles/baseScripts").Include(
                        "~/Scripts/jquery-{version}.js",
                        "~/Scripts/bootstrap.js"));

            bundles.Add(new ScriptBundle("~/bundles/knockout").Include(
                        "~/Scripts/knockout-{version}.js",
                        "~/Scripts/knockout.mapping-latest.js",
                        "~/Scripts/projectModel.js",
                        "~/Scripts/projectViewModel.js"));

            bundles.Add(new StyleBundle("~/Content/css").Include("~/Content/site.css"));

        }
    }
}