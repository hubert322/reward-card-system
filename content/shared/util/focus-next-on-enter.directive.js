(function () {
    "use strict";

    angular.module("rewardCard")

        .directive("focusNextOnEnter", [function () {
            return {
                restrict: "A",
                link: function (scope, elm, attrs) {
                    elm.bind ("keyup", function (e) {
                        var code = e.keyCode || e.which;
                        if (code === 13) {
                            e.preventDefault ();
                            elm.next ().focus ();
                        }
                    })
                }
            }
        }])
}) ();