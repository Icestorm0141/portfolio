using System;
using System.Collections.Generic;
using System.Linq;
using System.Data;
using System.Data.Entity;
using System.Web;
using System.Web.Mvc;
using MFBlog.Models;
using System.Xml.Linq;
using System.ServiceModel.Syndication;
using System.Xml;
using Portfolio.Library;
using Microsoft.Practices.Unity;

namespace MFBlog.Controllers
{
    public class HomeController : Controller
    {

        #region Dependencies

        [Dependency]
        public PortfolioContext LibraryContext { get; set; }

        #endregion

        public ActionResult Index()
        {
            ViewBag.Title = "My Journey";
            return View("Index",GetPosts());
        }

        public ActionResult Post(int id)
        {
            var blogItem = LibraryContext.BlogPosts.Where(p => p.PostId == id).ToList();
            PopulateSideBar();
            ViewBag.Title = blogItem.Single().Title;
            ViewBag.PostTitle = ViewBag.Title;
            ViewBag.Posts = PopulateSideBar();
            return View("Index", blogItem);
        }
        public ActionResult MyStory()
        {
            return View("MyStory");
        }

        private List<BlogPost> PopulateSideBar()
        {
            var blogDataItems = LibraryContext.BlogPosts
                                .OrderByDescending(p => p.DatePublished)
                                .ToList();
            return blogDataItems;
        }
        private List<BlogPost> GetPosts()
        {
            var blogDataItems = PopulateSideBar();
            var xmlFeed = XDocument.Load(Server.MapPath(Url.Content("/Content/TestFeed.aspx")));
            //var xmlFeed = XDocument.Load("http://blogs.medifastcommunity.com/Blogs/Icestorm0141/Atom.aspx");
            XNamespace xmlns = "http://www.w3.org/2005/Atom";

            var items = xmlFeed.Descendants(xmlns + "feed")
                          .Elements(xmlns + "entry");
            foreach (var item in items)
            {
                var existsInDb = blogDataItems.Any(p => p.Title == item.Element(xmlns + "title").Value);
                if (!existsInDb)
                {
                    var feedItem = new BlogPost()
                    {
                        DatePublished = DateTime.Parse(item.Element(xmlns + "published").Value).ToUniversalTime().AddHours(12),
                        Title = item.Element(xmlns + "title").Value,
                        PostContent = item.Element(xmlns + "content").Value
                    };
                    LibraryContext.BlogPosts.Add(feedItem);
                    blogDataItems.Add(feedItem);
                }
            }
            LibraryContext.SaveChanges();
            ViewBag.Posts = blogDataItems;
            ViewBag.PostTitle = blogDataItems.OrderByDescending(p => p.DatePublished).First().Title;
            return blogDataItems.OrderByDescending(p => p.DatePublished).ToList();
            //Atom10FeedFormatter xmlFeed = new Atom10FeedFormatter();
            //using (XmlReader reader = XmlReader.Create("http://blogs.medifastcommunity.com/Blogs/Icestorm0141/Atom.aspx"))
            //{
            //    xmlFeed.ReadFrom(reader);
            //}

            //return xmlFeed.Feed.Items
            //              .Select(item => new BlogFeed()
            //              {
            //                  PublishDate = item.PublishDate.DateTime,
            //                  Title = item.Title.Text,
            //                  Content = item.Content.ToString()
            //              })
            //              .ToList();
        }

    }
}
