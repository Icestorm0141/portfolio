//------------------------------------------------------------------------------
// <auto-generated>
//     This code was generated from a template.
//
//     Manual changes to this file may cause unexpected behavior in your application.
//     Manual changes to this file will be overwritten if the code is regenerated.
// </auto-generated>
//------------------------------------------------------------------------------

namespace Portfolio.Library
{
    using System;
    using System.Collections.Generic;
    
    public partial class Project
    {
        public int ProjectId { get; set; }
        public string Title { get; set; }
        public string Description { get; set; }
        public System.DateTime Date { get; set; }
        public string SoftwareUsed { get; set; }
        public string Languages { get; set; }
        public string ImageName { get; set; }
        public string WebUrl { get; set; }
        public int CategoryId { get; set; }
    
        public virtual Category Category { get; set; }
    }
}