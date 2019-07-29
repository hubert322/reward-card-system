(function() {
    "use strict";

    angular.module("rewardCard")
        .component("home", {
            templateUrl: "./content/components/home/home.template.html",
            controller: "HomeController"
        })
        .controller("HomeController",
        [function HomeController() {
            var ctrl = this;

        }]);
})();