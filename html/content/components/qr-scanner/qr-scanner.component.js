(function() {

    var app = angular.module("rewardCard");

    app.component("qrScanner", {
        templateUrl: "./content/components/qr-scanner/qr-scanner.template.html",
        controller: "qrScannerController"
    });

    app.controller('qrScannerController', qrScannerController);
    qrScannerController.$inject = ['qrScannerService'];

    function qrScannerController(qrScannerService) {
        var ctrl = this;

        ctrl.$onInit = function()  {
            ctrl.video = document.createElement("video");
            ctrl.canvasElement = document.getElementById("canvas");
            ctrl.canvas = ctrl.canvasElement.getContext("2d");
            ctrl.loadingMessage = document.getElementById("loadingMessage");

            ctrl.start();
        };

        ctrl.start = function() {
            navigator.mediaDevices.getUserMedia({ video: { facingMode: "environment" } })
                .then(function(stream) {
                    ctrl.video.srcObject = stream;
                    ctrl.video.setAttribute("playsinline", true);
                    ctrl.video.play();
                    ctrl.request = requestAnimationFrame(ctrl.tick);
                });
        };

        ctrl.tick = function() {
            ctrl.loadingMessage.innerText = "Loading video...";
            if (ctrl.video.readyState === ctrl.video.HAVE_ENOUGH_DATA)
            {
                ctrl.loadingMessage.hidden = true;
                ctrl.canvasElement.hidden = false;
                ctrl.canvasElement.height = ctrl.video.videoHeight;
                ctrl.canvasElement.width = ctrl.video.videoWidth;
                ctrl.canvas.drawImage(ctrl.video, 0, 0, ctrl.canvasElement.width, ctrl.canvasElement.height);
                var imageData = ctrl.canvas.getImageData(0, 0, ctrl.canvasElement.width, ctrl.canvasElement.height);
                var code = jsQR(imageData.data, imageData.width, imageData.height, {
                    inversionAttempts: "dontInvert",
                });
                if (code && code.data !== "")
                {
                    qrScanner.setString(code.data);
                    ctrl.cleanUp();
                    return;
                }
            }
            ctrl.request = requestAnimationFrame(ctrl.tick);
        };

        ctrl.cleanUp = function() {
            cancelAnimationFrame (ctrl.request);
            ctrl.video.srcObject.getTracks ()[0].stop ();
        };

        ctrl.$onDestroy = function() {
            ctrl.cleanUp();
        }
    }
})();