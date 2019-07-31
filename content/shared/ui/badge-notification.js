// Frim LAZ

(function($, window){

    var _template = _.template('<div class="badge-notification" id="<%= id %>" style="z-index: 99999" >'+
                        '<div class="badge-notification-message-body">' +
                            '<div class="badgeNotification_purpleStar"></div>' +
                            '<div class="badgeNotification_purpleStarLeft"></div>' +
                            '<div class="badgeNotification_blueStar"></div>' +
                            '<div class="badgeNotification_blueStarLeft"></div>' +
                            '<div class="badgeNotification_pinkStar"></div>' +
                            '<div class="badgeNotification_pinkStarLeft"></div>' +
                            '<div class="badgeNotification_whiteStar"></div>' +
                            '<div class="badgeNotification_whiteStarLeft"></div>' +
                            '<div class="badgeNotification_greenStar"></div>' +
                            '<div class="badgeNotification_greenStarLeft"></div>' +
                            '<div class="badgeNotification_starBurst"></div>' +
                            '<div class="badgeNotification_middleStar"></div>' +
                            '<span class="badge-notification-message"><%= message %></span>' +
                            '<div class="badgeNotification_badgeWrapper">' +
                                '<object type="image/svg+xml" data="<%= image %>" alt="<%= name %> Badge" class="badgeNotification_badge" />' +
                            '</div>' +
                            '<img src="/images/student_portal/badgeEarnedText.svg" class="badgeNotification_badgeText"/>' +

                        '</div>' +
                        '<button class="badgeNotification_next bookroomSlider_button">Next</button>' +
                    '</div>');

    var BadgeNotification = function(message, manager) {
        this.id = _.guid();
        this.showTime = 800;
        this.timeout = 5000;
        this.manager = manager;
        this.$parent = manager.$parent;
        this.message = message;
        this.message.id = 'badge-notification-' + this.id;
        this.selector = '#'+this.message.id;
    };

    BadgeNotification.prototype.render = function() {
        var self = this;
        var $view = $(_template(this.message));
        this.$parent.append($view);
        this.$view = $(this.selector);
        this.$view.hide();
        this.$view.delegate('.badgeNotification_next', 'click', function() {
            self.cleanup();
        })
    };

    BadgeNotification.prototype.show = function() {
        this.render();
        this.$view.show(this.showTime);
    };

    BadgeNotification.prototype.hide = function() {
        this.$view.hide(this.showTime);
    };

    BadgeNotification.prototype.cleanup = function() {
        var self = this;

        self.manager.onMessageCleanup(self);
    };



    window.BadgeNotification = BadgeNotification;
})(jQuery, window);

