angular.module('portfolioApp', [
        'portfolioApp.controllers', function() {
        }
    ])
//Configure the  routes
    .config([
        '$routeProvider', function($routeProvider) {
            $routeProvider
                .when('/Home', {
                    templateUrl: '/app/partials/home.html',
                    controller: 'HomeController'
                })
                .when('/Resume', {
                    templateUrl: '/app/partials/resume.html',
                    controller: 'ResumeController'
                })
                .when('/Project/:Id', {
                    templateUrl: '/app/partials/project.html',
                    controller: 'ProjectController'
                })
                .otherwise({
                    redirectTo: '/Home'
                });
        }
    ]);