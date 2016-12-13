angular.module('portfolioApp.controllers', [
        function() {
        }
    ])
    .controller('ResumeController', [
        '$scope', function($scope) {
            $scope.model = {};
            $scope.model.Title = "Resume";

        }
    ])
    .controller('ProjectController', [
        '$scope', '$routeParams', function($scope, $routeParams) {
            $scope.model = {};
            $scope.model.Id = $routeParams.Id;
            $scope.model.Title = "Resume";

            $http({
                    url: '/Projects/GetProjectDetails/' + $scope.model.Id,
                    method: "GET"
                })
                .success(function(data, status, headers, config) {
                    var tempProjects = [];
                    $.each(data, function(key, value) {
                        tempProjects.push(new ProjectModel(value));
                    });
                    $scope.model.projects = tempProjects;

                    $scope.model.isAjaxInProgress = false;
                })
                .error(function(data, status, headers, config) {
                    $scope.model.errorMessage = "Error  occurred  status:" + status;

                    $scope.model.isAjaxInProgress = false;
                });

            $scope.model.activeProject = [];
            $scope.model.setActiveProject = function(project) {
                $scope.model.activeProject = project;
            };
        }
    ])
    .controller('MenuController', [
        '$scope', function ($scope) {
            $scope.model = {};
            $scope.model.menuItems = [];
            $http({
                url: '/Home/GetMenuItems',
                method: "GET"
            })
            .success(function (data, status, headers, config) {
                $scope.model.menuItems = data;

                $scope.model.isAjaxInProgress = false;
            })
            .error(function (data, status, headers, config) {
                $scope.model.errorMessage = "Error  occurred  status:" + status;

                $scope.model.isAjaxInProgress = false;
            });
        }
    ]);