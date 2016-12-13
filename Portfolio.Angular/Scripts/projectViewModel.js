/// <reference path="knockout-3.3.0.debug.js"/>
/// <reference path="jquery-2.1.4.min.js"/>
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
ko.bindingHandlers.showModal = {
    init: function (element, valueAccessor) { },
    update: function (element, valueAccessor) {
        var value = valueAccessor();
        if (ko.utils.unwrapObservable(value)) {
            $(element).modal('show');
        }
        else {
            $(element).modal('hide');
        }
    }
};
var ProjectViewModel = function (modelData) {
    var self = this;
    var mapping = {
        create: function (options) {
            return new ProjectModel(options.data);
        }
    };

    self.projects = ko.mapping.fromJS([], mapping);
    self.activeProject = ko.observable();
    self.setActiveProject = function (project) {
        self.activeProject(project);
    };
    $.ajax({
        url: modelData.ActionUrls.GetProjects,
        data: { id: modelData.CategoryId },
        success: function (data) {
            ko.mapping.fromJS(data, self.projects);
        }
    });


}