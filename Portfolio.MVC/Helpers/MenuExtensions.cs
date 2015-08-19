using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.Mvc;
using System.Web.Mvc.Html;
using Portfolio.Library;

namespace Portfolio.MVC.Helpers
{
    public static class MenuExtensions
    {
        public static MvcHtmlString MenuItem(
            this HtmlHelper htmlHelper,
            Category category
        )
        {
            var hiddenClass = !category.IsMobileVisible ? "hidden-xs" : null;
            return MenuItem(htmlHelper, category.Name, category.Action, category.Controller, category.CategoryId, hiddenClass);
        }

        public static MvcHtmlString MenuItem(this HtmlHelper htmlHelper, string text, string action, string controller, int? categoryId = null, string cssClasses = null)
        {
            var li = new TagBuilder("li");
            var routeData = htmlHelper.ViewContext.RouteData;
            var currentAction = routeData.GetRequiredString("action");
            var currentController = routeData.GetRequiredString("controller");
            if (string.Equals(currentAction, action, StringComparison.OrdinalIgnoreCase) &&
                string.Equals(currentController, controller, StringComparison.OrdinalIgnoreCase))
            {
                li.AddCssClass("active");
            }
            if (!string.IsNullOrEmpty(cssClasses))
            {
                li.AddCssClass(cssClasses);
            }
            if (categoryId != null)
            {
                li.InnerHtml = htmlHelper.ActionLink(text, action, controller,new { id = categoryId.Value },new {}).ToHtmlString();
            }
            else
            {
                li.InnerHtml = htmlHelper.ActionLink(text, action, controller).ToHtmlString();
            }
            return MvcHtmlString.Create(li.ToString());
        }
    }
}