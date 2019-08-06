(function() {
    "use strict";

    angular.module("rewardCard")
        .config (function($routeProvider, $locationProvider) {
            $routeProvider
                .when("/", {
                    template: "<home></home>"
                })
                .when("/generate", {
                    template: "<generate></generate>"
                })
                .when("/redeem", {
                    template: "<redeem></redeem>"
                });
            $locationProvider.html5Mode(true);
        });
})();