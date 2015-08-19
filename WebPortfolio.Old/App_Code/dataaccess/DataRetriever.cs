using System.Collections;
using System.Collections.Generic;
using System.Data;
using System.Data.SqlClient;
using System.Text;
using System.Web;
using System.Web.ClientServices;
using System.Net;
using System.Xml;
using System.Configuration;

namespace WebPortfolio.dataaccess
{
    public class DataRetriever
    {
        protected SqlCommand selectCommand = null;
        protected SqlConnection connection = null;
        protected SqlDataReader sqlDr = null;
        protected string is_dsn = null;

        public DataRetriever()
        {
            is_dsn = ConfigurationManager.ConnectionStrings["WebPortfolio"].ConnectionString;
            if (is_dsn == null)
            {
                throw new ConfigurationErrorsException("Connection string is null!");
            }
        }

        //SEARCH THE DATABASE FOR A TERM
        //PARAMS: STRQUERY - WHAT THE USER TYPED
        //RETURNS: DATASET OF RESULTS
        public DataSet SearchPortfolio(string strQuery)
        {
            DataSet ds = new DataSet();
            SqlDataAdapter myDA = new SqlDataAdapter();
            connection = new SqlConnection(is_dsn);
            connection.Open();
            selectCommand = new SqlCommand();
            string strSelect = "select * from tblPortfolio p join tblSections s on p.ItemSectionId = s.SectionId INNER JOIN CONTAINSTABLE (tblPortfolio,*,@strQuery ) as ftt ON ftt.[KEY] = p.ItemId ORDER BY ftt.RANK DESC";
            selectCommand = new SqlCommand(strSelect, connection);
            selectCommand.Parameters.AddWithValue("@strQuery", strQuery);
            myDA.SelectCommand = selectCommand;
            myDA.Fill(ds);

            connection.Close();
            return ds;
        }

        //GET THE LIST OF THUMBNAILS FOR THAT SECTION
        //PARAMS: STRSECTIONID - WHAT THE USER TYPED
        //RETURNS: DATASET OF LIST OF THUMBNAILS
        public DataSet GetThumbs(string strSectionId)
        {
            DataSet ds = new DataSet();
            SqlDataAdapter myDA = new SqlDataAdapter();
            connection = new SqlConnection(is_dsn);
            connection.Open();
            selectCommand = new SqlCommand();

            selectCommand = new SqlCommand("select ItemId,ItemImageName,SectionFolderName from tblPortfolio p join tblSections s on p.ItemSectionId = s.SectionId where p.ItemSectionId = @strSectionId order by ItemDate desc", connection);
            selectCommand.Parameters.AddWithValue("@strSectionId", strSectionId);
            myDA.SelectCommand = selectCommand;
            myDA.Fill(ds);

            connection.Close();
            return ds;
        }

        //GET THE FEATURED ITEM FOR THE SECTION
        //PARAMS: SECTIONID - THE SECTION THE USER IS VIEWING
        //RETURNS: DICTIONARY OF THE INFORMATION FOR THE FEATURED ITEM
        public Dictionary<string, string> GetFeaturedItem(string SectionId)
        {
            SqlDataReader myDA = null;
            connection = new SqlConnection(is_dsn);
            connection.Open();
            selectCommand = new SqlCommand();
            string strStatement;
            strStatement = "select * from tblPortfolio p join tblSections s on p.ItemSectionId = s.SectionId join tblFeaturedItems f on p.ItemId = f.ItemId left join tblExpandText e on p.ItemExpandId = e.ExpandId where f.sectionId = @strSectionId";
            selectCommand = new SqlCommand(strStatement, connection);
            selectCommand.Parameters.AddWithValue("@strSectionId", SectionId);
            myDA = selectCommand.ExecuteReader(CommandBehavior.CloseConnection);

            Dictionary<string, string> list = new Dictionary<string, string>();
            while (myDA.Read())
            {
                list.Add("ItemId", myDA["ItemId"].ToString());
                list.Add("ItemTitle", myDA["ItemTitle"].ToString());
                list.Add("ItemDate", myDA["ItemDate"].ToString());
                list.Add("ItemLanguage", myDA["ItemLanguage"].ToString());
                list.Add("ItemSoftware", myDA["ItemSoftware"].ToString());
                list.Add("ItemDescription", myDA["ItemDescription"].ToString());
                list.Add("ItemImageName", myDA["ItemImageName"].ToString());
                list.Add("ItemFolderName", myDA["SectionFolderName"].ToString());
                list.Add("ItemWebUrl", myDA["ItemWebUrl"].ToString());
                list.Add("ItemCodeUrl", myDA["ItemCodeUrl"].ToString());
                list.Add("ExpandText", myDA["ExpandText"].ToString());
            }
            connection.Close();
            return list;
        }

        //GET THE DETAILS FOR AN ITEM
        //PARAMS: ITEMID - THE ID OF THE ITEM THE USER WISHES TO SEE
        //RETURNS: DICTIONARY OF THE INFORMATION FOR THE ITEM
        public Dictionary<string,string> GetItemDetails(string ItemId)
        {
            SqlDataReader myDA = null;
            connection = new SqlConnection(is_dsn);
            connection.Open();
            selectCommand = new SqlCommand();
            string strStatement;
            strStatement = "select * from tblPortfolio p join tblSections s on p.ItemSectionId = s.SectionId left join tblExpandText e on p.ItemExpandId = e.ExpandId where p.ItemId = @strItemId";
            selectCommand = new SqlCommand(strStatement, connection);
            selectCommand.Parameters.AddWithValue("@strItemId", ItemId);
            myDA = selectCommand.ExecuteReader(CommandBehavior.CloseConnection);

            Dictionary<string, string> list = new Dictionary<string, string>();
            while (myDA.Read())
            {
                list.Add("ItemId", myDA["ItemId"].ToString());
                list.Add("ItemTitle", myDA["ItemTitle"].ToString());
                list.Add("ItemDate", myDA["ItemDate"].ToString());
                list.Add("ItemLanguage", myDA["ItemLanguage"].ToString());
                list.Add("ItemSoftware", myDA["ItemSoftware"].ToString());
                list.Add("ItemDescription", myDA["ItemDescription"].ToString());
                list.Add("SectionName", myDA["SectionName"].ToString());
                list.Add("ItemImageName", myDA["ItemImageName"].ToString());
                list.Add("ItemFolderName", myDA["SectionFolderName"].ToString());
                list.Add("ItemWebUrl", myDA["ItemWebUrl"].ToString());
                list.Add("ItemCodeUrl", myDA["ItemCodeUrl"].ToString());
                list.Add("ExpandText", myDA["ExpandText"].ToString());
            }
            connection.Close();
            return list;
        }

        //GET THE LANGUAGES FOR THE ITEM REQUESTED                      //USED WHEN DATABASE IS NORMALIZED
        //PARAMS: ITEMID - THE ID OF THE ITEM                           //NOT ACTIVE RIGHT NOW
        //RETURNS: ARRAYLIST OF LANGUAGES TO EASILY LOOP THROUGH
        public ArrayList GetLanguages(string ItemId)
        {
            SqlDataReader myDA = null;
            connection = new SqlConnection(is_dsn);
            connection.Open();
            selectCommand = new SqlCommand();
            string strStatement;
            strStatement = "select languageName from tblPortfolioLanguage pl join tblLanguage l on l.LanguageId = pl.LanguageId where pl.PortfolioId = @strItemId";
            selectCommand = new SqlCommand(strStatement, connection);
            selectCommand.Parameters.AddWithValue("@strItemId", ItemId);
            myDA = selectCommand.ExecuteReader(CommandBehavior.CloseConnection);

            ArrayList list = new ArrayList();
            while (myDA.Read())
            {
                list.Add(myDA["languageName"].ToString());
            }
            connection.Close();
            return list;
        }
        //GET THE SOFTWARES USED FOR THE ITEM REQUESTED                      //USED WHEN DATABASE IS NORMALIZED
        //PARAMS: ITEMID - THE ID OF THE ITEM                                //NOT ACTIVE RIGHT NOW
        //RETURNS: ARRAYLIST OF SOFTWARE
        public ArrayList GetSoftware(string ItemId)
        {
            SqlDataReader myDA = null;
            connection = new SqlConnection(is_dsn);
            connection.Open();
            selectCommand = new SqlCommand();
            string strStatement;
            strStatement = "select softwareName from tblPortfolioSoftware ps join tblSoftware s on s.softwareId = ps.softwareId where ps.PortfolioId = @strItemId";
            selectCommand = new SqlCommand(strStatement, connection);
            selectCommand.Parameters.AddWithValue("@strItemId", ItemId);
            myDA = selectCommand.ExecuteReader(CommandBehavior.CloseConnection);

            ArrayList list = new ArrayList();
            while (myDA.Read())
            {
                list.Add(myDA["softwareName"].ToString());
            }
            connection.Close();
            return list;
        }

        //GET THE NAME OF THE SECTION IMAGE
        //PARAMS: SECTIONID - ID OF THE SECTION REQUESTED
        //RETURNS: STRING NAME OF THE IMAGE
        public string GetSectionImage(string sectionId)
        {
            SqlDataReader myDA = null;
            connection = new SqlConnection(is_dsn);
            connection.Open();
            selectCommand = new SqlCommand();
            string strStatement;
            strStatement = "select SectionImageName from tblSections where SectionId = @strSectionId";
            selectCommand = new SqlCommand(strStatement, connection);
            selectCommand.Parameters.AddWithValue("@strSectionId", sectionId);
            myDA = selectCommand.ExecuteReader(CommandBehavior.CloseConnection);
            myDA.Read();
            string sectionImage = myDA["SectionImageName"].ToString();
            connection.Close();
            return sectionImage;
        }
    }
}
