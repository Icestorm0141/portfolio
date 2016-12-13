/// <reference path="knockout-3.3.0.debug.js"/>
/// <reference path="jquery-2.1.4.min.js"/>
/// <reference path="~/Scripts/projectModel.js" />
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