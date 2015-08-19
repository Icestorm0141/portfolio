﻿using System.Collections;
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

        public DataSet GetThumbs(string strSectionId)
        {
            DataSet ds = new DataSet();
            SqlDataAdapter myDA = new SqlDataAdapter();
            // _o_search_params.CheckIntegrity();
            connection = new SqlConnection(is_dsn);
            connection.Open();
            selectCommand = new SqlCommand();

            selectCommand = new SqlCommand("select ItemId,ItemImageName,ItemFolderName from tblPortfolio p join tblSections s on p.ItemSectionId = s.SectionId where p.ItemSectionId = @strSectionId", connection);
            //selectCommand.CommandType = CommandType.StoredProcedure;
            selectCommand.Parameters.AddWithValue("@strSectionId", strSectionId);
            //selectCommand.Parameters.AddWithValue("@strUrl", sUrl);
            //ds = selectCommand.ExecuteScalar();
            myDA.SelectCommand = selectCommand;
            myDA.Fill(ds);

            connection.Close();
            return ds;
        }
        public Dictionary<string, string> GetFeaturedItem(string SectionId)
        {
            SqlDataReader myDA = null;
            connection = new SqlConnection(is_dsn);
            connection.Open();
            selectCommand = new SqlCommand();
            string strStatement;
            strStatement = "select * from tblPortfolio p join tblFeaturedItems f on p.ItemId = f.ItemId left join tblExpandText e on p.ItemExpandId = e.ExpandId where f.sectionId = @strSectionId";
            selectCommand = new SqlCommand(strStatement, connection);
            //selectCommand.CommandType = CommandType.StoredProcedure;
            selectCommand.Parameters.AddWithValue("@strSectionId", SectionId);
            myDA = selectCommand.ExecuteReader(CommandBehavior.CloseConnection);

            Dictionary<string, string> list = new Dictionary<string, string>();
            while (myDA.Read())
            {
                list.Add("ItemId", myDA["ItemId"].ToString());
                list.Add("ItemTitle", myDA["ItemTitle"].ToString());
                list.Add("ItemDate", myDA["ItemDate"].ToString());
                list.Add("ItemLanguages", myDA["ItemLanguages"].ToString());
                list.Add("ItemDescription", myDA["ItemDescription"].ToString());
                list.Add("ItemImageName", myDA["ItemImageName"].ToString());
                list.Add("ItemFolderName", myDA["ItemFolderName"].ToString());
                list.Add("ItemWebUrl", myDA["ItemWebUrl"].ToString());
                list.Add("ItemCodeUrl", myDA["ItemCodeUrl"].ToString());
                list.Add("ExpandText", myDA["ExpandText"].ToString());
            }
            connection.Close();
            return list;
        }

        public Dictionary<string,string> GetItemDetails(string ItemId)
        {
            SqlDataReader myDA = null;
            connection = new SqlConnection(is_dsn);
            connection.Open();
            selectCommand = new SqlCommand();
            string strStatement;
            strStatement = "select * from tblPortfolio p join tblSections s on p.ItemSectionId = s.SectionId left join tblExpandText e on p.ItemExpandId = e.ExpandId where p.ItemId = @strItemId";
            selectCommand = new SqlCommand(strStatement, connection);
            //selectCommand.CommandType = CommandType.StoredProcedure;
            selectCommand.Parameters.AddWithValue("@strItemId", ItemId);
            myDA = selectCommand.ExecuteReader(CommandBehavior.CloseConnection);

            Dictionary<string, string> list = new Dictionary<string, string>();
            while (myDA.Read())
            {
                list.Add("ItemId", myDA["ItemId"].ToString());
                list.Add("ItemTitle", myDA["ItemTitle"].ToString());
                list.Add("ItemDate", myDA["ItemDate"].ToString());
                list.Add("ItemLanguages", myDA["ItemLanguages"].ToString());
                list.Add("ItemDescription", myDA["ItemDescription"].ToString());
                list.Add("SectionName", myDA["SectionName"].ToString());
                list.Add("ItemImageName", myDA["ItemImageName"].ToString());
                list.Add("ItemFolderName", myDA["ItemFolderName"].ToString());
                list.Add("ItemWebUrl", myDA["ItemWebUrl"].ToString());
                list.Add("ItemCodeUrl", myDA["ItemCodeUrl"].ToString());
                list.Add("ExpandText", myDA["ExpandText"].ToString());
            }
            connection.Close();
            return list;
        }

        public string GetSectionImage(string sectionId)
        {
            SqlDataReader myDA = null;
            connection = new SqlConnection(is_dsn);
            connection.Open();
            selectCommand = new SqlCommand();
            string strStatement;
            strStatement = "select * from tblSections where SectionId = @strSectionId";
            selectCommand = new SqlCommand(strStatement, connection);
            //selectCommand.CommandType = CommandType.StoredProcedure;
            selectCommand.Parameters.AddWithValue("@strSectionId", sectionId);
            myDA = selectCommand.ExecuteReader(CommandBehavior.CloseConnection);
            myDA.Read();
            string sectionImage = myDA["SectionImageName"].ToString();
            connection.Close();
            return sectionImage;
        }
    }
}