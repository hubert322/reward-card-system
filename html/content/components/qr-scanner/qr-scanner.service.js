(function(){
    'use strict';

    angular.module('rewardCard')
        .service('qrScannerService' , [
            function qrScannerService() {
                var service = this;

                var listeners = [];

                service.setString = function(string) {
                    publish(string);
                };

                service.subscribe = function(callback) {
                    listeners.push(callback);
                };

                service.unsubscribe = function(callback) {
                    for( var i = 0; i < listeners.length; ++i){
                        if ( listeners[i] === callback) {
                            listeners.splice(i, 1);
                            --i;
                        }
                    }
                };

                function publish(string) {
                    listeners.forEach(function (listener) {
                        listener(string);
                    })
                }
            }
        ]);
})();