(function () {
    "use strict";

    angular.module ("rewardCard")
        .component ("redeem", {
            templateUrl: "./content/components/redeem/redeem.template.html",
            controller: "RedeemController"
        })

        .controller ("RedeemController",
        ["redeemService", "qrScannerService",
        function RedeemController (redeemService, qrScannerService) {
            var ctrl = this;

            ctrl.$onInit = function () {
                ctrl.inputCode = "";
                ctrl.redeemStatus = "init";
                ctrl.starAmount = null;
                ctrl.cameraOn = false;
                ctrl.message = {
                    id: "badgeSplashContainer",
                    message: "Stars",
                    image: "./assets/images/badgeNotification/standard_star.svg"
                };

                qrScannerService.subscribe (setInputCodeAndRedeem);
            };

            function setInputCodeAndRedeem (inputCode) {
                ctrl.inputCode = inputCode;
                ctrl.redeem ();
            }

            ctrl.isEnterPressed = function (event) {
                return event.keyCode === 13;
            };

            ctrl.redeem = function () {
                ctrl.redeemStatus = "redeeming";
                redeemService.redeem (ctrl.inputCode)
                    .then (function (data) {
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

            ctrl.turnOffCamera = function () {
                ctrl.cameraOn = false;
            };

            function showSplash () {
                var manager = new BadgeNotificationManager ();
                var notifier = new BadgeNotification (ctrl.message, manager);
                notifier.show ();
            }
        }]);
} ());