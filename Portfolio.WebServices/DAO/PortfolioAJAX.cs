using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using Portfolio.Library;

namespace Portfolio.WebServices.DAO
{
    public class PortfolioAJAX
    {
        public int Id { get; set; }
        public string Title { get; set; }
        public string Date { get; set; }
        public string Languages { get; set; }
        public string Software { get; set; }
        public string Description { get; set; }
        public string ThumbImage { get; set; }
        public string PreviewImage { get; set; }
        public string FullImage { get; set; }
        public string Url { get; set; }
        public string ExpandText { get; set; }
        public string CodeUrl { get; set; }
        public string SectionId { get; set; }

        public static PortfolioAJAX GetSerializedObject(tblPortfolio item)
        {
            var returnItem = new PortfolioAJAX()
            {
                Id = item.ItemId,
                Title = item.ItemTitle,
                Date = item.ItemDate.Value.ToShortDateString(),
                Description = item.ItemDescription,
                Url = string.Empty,
                ExpandText = (item.tblExpandText == null) ? string.Empty : item.tblExpandText.ExpandText,
                CodeUrl = (item.ItemCodeUrl == null) ? string.Empty : item.ItemCodeUrl,
                Languages = (item.ItemLanguage == null) ? string.Empty : item.ItemLanguage,
                Software = (item.ItemSoftware == null) ? string.Empty : item.ItemSoftware,
                ThumbImage = "images/thumbs/" + item.tblSection.SectionFolderName + "/" + item.ItemImageName,
                PreviewImage = "images/preview/" + item.tblSection.SectionFolderName + "/" + item.ItemImageName,
                FullImage = "images/fullsize/" + item.tblSection.SectionFolderName + "/" + item.ItemImageName,
                SectionId = item.ItemSectionId.Value.ToString(),
            };
            if (item.ItemWebUrl != null)
            {
                returnItem.Url = item.ItemWebUrl;
                if (!item.ItemWebUrl.Contains("http://") && item.ItemWebUrl !="None")
                {
                    returnItem.Url = "images/fullsize/" + item.tblSection.SectionFolderName + "/" + item.ItemWebUrl;
                }
            }
            return returnItem;
        }
    }
}
