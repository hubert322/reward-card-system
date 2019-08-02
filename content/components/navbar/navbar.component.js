(function() {
    "use strict";

    angular.module("rewardCard")
        .component("navbar", {
            templateUrl: "./content/components/navbar/navbar.template.html",
            controller: "NavBarController"
        })
        .controller("NavBarController",
            [function NavBarController() {
                var ctrl = this;

            }]);
})();