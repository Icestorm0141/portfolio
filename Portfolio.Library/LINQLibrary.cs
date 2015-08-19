using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Configuration;

namespace Portfolio.Library
{
    public partial class LINQLibraryDataContext : System.Data.Linq.DataContext
    {
        public LINQLibraryDataContext() :
            base(ConfigurationManager.ConnectionStrings["WebPortfolio"].ConnectionString, mappingSource)
        { }
    }
}
