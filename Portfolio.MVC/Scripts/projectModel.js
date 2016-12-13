var ProjectModel = function (data) {
    var self = this;
    self.path = "/Content/projects/" + data.categoryId + "/";

    self.imageName = data.imageName;
    self.thumbSrc = self.path + "thumbs/" + self.imageName;
    self.largeSrc = self.path + "large/";
    self.displayText = (data.languages == null) ? data.softwareUsed : data.languages;
    self.projectDate = new Date(data.date).toLocaleDateString();
    self.title = data.title;
    self.description = data.description;
    self.URL = data.url;
    self.isVimeoFile = (self.URL != null && self.URL.toLowerCase().indexOf("vimeo") !== -1);
    self.isFlashFile = (self.URL != null && self.URL.toLowerCase().indexOf("swf") !== -1);

    self.largeSrc += (self.isFlashFile) ? self.URL : self.imageName;
}