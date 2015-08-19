﻿using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.Mvc;
using Portfolio.Library;
using Portfolio.WebServices;

namespace Portfolio.MVC.Controllers
{
    public class ProjectsController : BaseController
    {
        public ProjectsController(PortfolioContext ent, PortfolioManager manager)
            : base(ent, manager)
        {
            
        }
        public ViewResult Index(int id)
        {
            var projects = _manager.GetProjectsByCategory(id);
            return View(projects);
        }

        public ViewResult IndexMvvm(int id)
        {
            return View();
        }
        public ViewResult Fun(int id)
        {
            var projects = _manager.GetProjectsByCategory(id);
            return View(projects);
        }
    }
}