(function() {
    "use strict";

    angular.module("rewardCard")
        .component("home", {
            templateUrl: "/content/js/angular/home/home.template.html",
            controller: "HomeController"
        })
        .controller("HomeController",
        [function HomeController() {
            var ctrl = this;
            
            ctrl.generate = () => {
                alert("Generate");
            };

            ctrl.redeem = () => {
                alert("Redeem");
            };
        }]);
})();