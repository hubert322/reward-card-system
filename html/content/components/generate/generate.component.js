(function () {
    "use strict";

    angular.module ("rewardCard")
        .component ("generate", {
            templateUrl: "./content/components/generate/generate.template.html",
            controller: "GenerateController"
        })

        .controller ("GenerateController",
        ["generateService",
        function GenerateController (generateService) {
            var ctrl = this;

            ctrl.$onInit = function () {
                ctrl.rewardCardAmount = "";
                ctrl.starAmount = "";
                ctrl.messageStatus = null;
                ctrl.rewardCardAmountText = null;
            };

            ctrl.isEnterPressed = function () {
                return event.keyCode === 13;
            };

            ctrl.generate = function () {
                ctrl.messageStatus = generateService.generate (ctrl.rewardCardAmount, ctrl.starAmount);
                if (ctrl.messageStatus === "plural") {
                    ctrl.rewardCardAmountText = ctrl.rewardCardAmount;
                }
                if (ctrl.messageStatus === "singular" || ctrl.messageStatus === "plural") {
                    resetElements ();
                }
            };

            function resetElements () {
                ctrl.rewardCardAmount = "";
                document.getElementById ("rewardCardAmount").focus ();

                ctrl.starAmount = "";
                document.getElementById ("starAmount").blur ();
            }
        }]);
} ());