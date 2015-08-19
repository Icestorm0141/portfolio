using System;
using System.Web.UI;

namespace WebPortfolioOld.masters
{
    public partial class Main : System.Web.UI.MasterPage
    {
        protected void Page_Load(object sender, EventArgs e)
        {
        }
        public ScriptManager smScriptManagerProp 
        {
            get{return smScriptManager;}
        }
    }
}
