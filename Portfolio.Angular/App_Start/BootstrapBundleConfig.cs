using System.Web.Optimization;
using Portfolio.Angular;

[assembly: WebActivatorEx.PostApplicationStartMethod(typeof(BootstrapBundleConfig), "RegisterBundles")]

namespace Portfolio.Angular
{
	public class BootstrapBundleConfig
	{
		public static void RegisterBundles()
		{
			// Add @Styles.Render("~/Content/bootstrap") in the <head/> of your _Layout.cshtml view
			// For Bootstrap theme add @Styles.Render("~/Content/bootstrap-theme") in the <head/> of your _Layout.cshtml view
			// Add @Scripts.Render("~/bundles/bootstrap") after jQuery in your _Layout.cshtml view
			// When <compilation debug="true" />, MVC4 will render the full readable version. When set to <compilation debug="false" />, the minified version will be rendered automatically
			BundleTable.Bundles.Add(new ScriptBundle("~/bundles/bootstrap").Include("~/Scripts/bootstrap.js"));
			BundleTable.Bundles.Add(new StyleBundle("~/Content/css/bootstrap").Include("~/Content/bootstrap.css"));
			BundleTable.Bundles.Add(new StyleBundle("~/Content/css/bootstrap-theme").Include("~/Content/bootstrap-theme.css"));
		}
	}
}