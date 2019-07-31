// From LAZ

(function($, window){
    var instance,
        selector = '#badge-notification-container',
        container = '<div id="badge-notification-container"></div>';

    var BadgeNotificationManager = function(cookieKey) {
        this.cookieKey = cookieKey || 'BADGES';

        this.notifications = {};
        this.currentNotification = null;
        this.cookies = new CookieManager();
        this.isActive = false;

        this.onBadgeDisplayCompletes = [];

        this.onNextBadgeDisplayComplete = function(func){
            this.onBadgeDisplayCompletes.push(func);
        };

        if($(selector).length === 0) {
            $('body').append(container);
        }

        this.$parent = $(selector);
    };

    BadgeNotificationManager.prototype.checkForMessages = function() {
        var self = this,
            badges = this.getNewBadges();

        badges.forEach(function(message) {
            self.addMessage(message)
        });

        this.showNextInQueue();
    };

    BadgeNotificationManager.prototype.addMessage = function(message) {
        var notification = new BadgeNotification(message, this);
        this.notifications[notification.id] = notification;
    };

    BadgeNotificationManager.prototype.onMessageCleanup = function(badgeNotification) {
        badgeNotification.$view.remove();
        this.currentNotification = null;
        delete this.notifications[badgeNotification.id];
        this.isActive = false;
        this.showNextInQueue();
    };

    BadgeNotificationManager.prototype.showNextInQueue = function() {
        var self = this;
        this.currentNotification = this.getNextInQueue();
        if(this.currentNotification === null && !this.isActive && Object.keys(this.notifications).length === 0) {
            setTimeout(function() {self._complete()}, 0);
        } else if(this.currentNotification && !this.isActive) { // Next item in queue and not currently being displayed.
            this.isActive = true;
            this.currentNotification.show();
        }
    };

    BadgeNotificationManager.prototype.getNextInQueue = function() {
        var id = Object.keys(this.notifications).pop();
        if (id) {
            return this.notifications[id];
        }
        return null;

    };

    BadgeNotificationManager.prototype.getNewBadges = function() {
        var badgesList, notificationJson,
            badges = this.cookies.get(this.cookieKey);
        this.cookies.remove(this.cookieKey);

        if(notificationJson = this.decodeCookie(badges)) {
            badgesList = JSON.parse(notificationJson);
        }

        return badgesList || [];
    };

    BadgeNotificationManager.prototype.decodeCookie = function(cookie) {
        if(cookie) {
            return atob(
                decodeURIComponent(cookie)
            );
        }
    };

    BadgeNotificationManager.prototype._complete = function() {
        this.onBadgeDisplayCompletes.forEach(function(func) {func()});

        this.onBadgeDisplayCompletes = [];
    };

    BadgeNotificationManager.getInstance = function() {
        if (!instance) {
            instance = new BadgeNotificationManager();
            $(function(){
                $( document ).ajaxComplete(function() {
                    instance.checkForMessages();
                });
            });
        }
        return instance;
    };

    BadgeNotificationManager.listenForJQueryAjaxCalls = function() {
        var manager = BadgeNotificationManager.getInstance();

        manager.checkForMessages();
    };

    BadgeNotificationManager.checkForMessages = function() {
        BadgeNotificationManager
            .getInstance()
            .checkForMessages();
    };

    _.mixin({
        guid : function(){
            return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
                var r = Math.random()*16|0, v = c == 'x' ? r : (r&0x3|0x8);
                return v.toString(16);
            });
        }
    });

    function CookieManager() {
    }

    CookieManager.prototype.get = function(key) {
        var cookies = document.cookie.split(';').reduce(function(dict, pair){
            pair = pair.split('=');
            dict[pair[0].trim()] = pair[1];
            return dict;
        }, {});

        if(key) {
            return cookies[key];
        } else {
            return cookies;
        }
    };

    CookieManager.prototype.remove = function(key) {
        document.cookie = key+'=;expires=Thu, 01 Jan 1970 00:00:01 GMT;path=/';
    };

    window.BadgeNotificationManager = BadgeNotificationManager;

})(jQuery, window);