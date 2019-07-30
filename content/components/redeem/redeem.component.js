(function () {
    "use strict";

    angular.module ("shared")
        .component ("rewardCardRedeem", {
            templateUrl: "/shared/js/angular/reward-card/reward-card-redeem.template.html",
            controller: "RewardCardRedeemController"
        })

        .controller ("RewardCardRedeemController",
        ["rewardCardService", "qrScanner",
        function RewardCardRedeemController (rewardCardService, qrScanner) {
            var ctrl = this;

            ctrl.$onInit = function () {
                ctrl.inputCode = "";
                ctrl.redeemStatus = "init";
                ctrl.starAmount = null;
                ctrl.cameraOn = false;
                qrScanner.subscribe (setInputCodeAndRedeem);
            };

            function setInputCodeAndRedeem (inputCode) {
                ctrl.inputCode = inputCode;
                ctrl.redeem ();
            }

            ctrl.isEnterPressed = function () {
                return event.keyCode === 13;
            };

            ctrl.redeem = function () {
                console.log ("Read Input Code!");
                ctrl.redeemStatus = "redeeming";
                rewardCardService.redeem (ctrl.inputCode)
                    .then (function (data) {
                        console.log (data);
                        ctrl.redeemStatus = data.redeemStatus;
                        ctrl.starAmount = data.starAmount;
                        ctrl.cameraOn = false;
                        if (ctrl.redeemStatus === "successful") {
                            showSplash();
                        }
                    });
            };

            ctrl.openCamera = function () {
                ctrl.cameraOn = true;
            };

            ctrl.cameraInit = function () {
                qrScanner.setIsScanning (false);
            };

            function showSplash () {
                try {
                    console.log (window.BadgeNotification);
                    var manager = new BadgeNotificationManager ();
                    var notifier = new BadgeNotification ({"id": "badgeSplashContainer", "message": "Stars", "image": "/images/standard_materials/standard_star.svg"}, manager);
                    notifier.show ();
                }
                catch (error) {
                    console.log (error);
                }
            }
        }]);
} ());