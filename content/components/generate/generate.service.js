(function () {
    "use strict";

    angular.module ("rewardCard")
        .service ("generateService",
        ["downloadFile",
        function generateService (downloadFile) {
            var service = this;
            var GENERATE_MAX = 1000;

            service.generate = function (rewardCardAmount, starAmount) {
                if (!isPositiveInteger (rewardCardAmount) || !isPositiveInteger (starAmount)) {
                    return "invalid"
                }
                if (rewardCardAmount >= GENERATE_MAX) {
                    return "max"
                }

                var url = "/api/reward-cards?rewardCardAmount=" + rewardCardAmount + "&starAmount=" + starAmount;

                downloadFile (url);

                return rewardCardAmount == 1 ? "singular" : "plural";
            };

            function isPositiveInteger (number) {
                var n = Math.floor (Number (number));
                return n !== Infinity && String (n) === number && n > 0;
            }
        }]);
} ());