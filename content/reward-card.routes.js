let app = angular.module("rewardCard", ["ngRoute"]);

app.config (function($routeProvider) {
    $routeProvider

    .when("/", {
        template: "<home></home>"
    })

    .when("/generate", {
        template: "<generate></generate>"
    })
})
