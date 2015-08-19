using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;

namespace MFBlog.Models
{
    public class BlogFeed
    {
        public DateTime PublishDate { get; set; }
        public string Title { get; set; }
        public string Url { get; set; }
        public string Content { get; set; }
    }
}