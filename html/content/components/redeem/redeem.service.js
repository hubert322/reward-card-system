(function () {
    "use strict";

    angular.module ("rewardCard")
        .service ("redeemService",
            ["$http", "$q",
            function redeemService ($http, $q) {
                var service = this;

                service.redeem = function (inputCode) {
                    if (inputCode === "") {
                        var defer = $q.defer ();
                        defer.resolve ({redeemStatus: "empty", starAmount: 0});
                        return defer.promise;
                    }

                    var data = {inputCode: inputCode};
                    return $http.patch("/api/reward-cards", data);
                };
            }]);
} ());