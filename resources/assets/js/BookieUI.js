/**
 * BookieUI singleton
 * -
 * Handles all basic interactions with the DOM
 **/
var BookieUI = {};
// Reset (for instance on smoothState page load)
BookieUI.reset = function(){
    if (!this.inited) return;

    this.trueInited = true;
    this.inited = false;
    this.header.inited = false;
    this.messages.inited = !!$(".message-container").length;
}
// Initialize all JS-side UI interactions
BookieUI.init = function(){
    if (this.inited) return;

    // initialize smoothState for smooth loading without the MVC structure
    if (!this.trueInited && matchMedia("max-width: 465px")) {
        var $body = $("html, body");
        
        $("#body").smoothState({
            onStart : { // animate out
                duration: 100,
                render: function(url, $cont) {
                    $(".page",$cont).addClass("fadeout");
                    $("#body > .loader").removeClass("hidden");

                    // animate to top
                    $body.animate({scrollTop: 0}, 100);
                }
            },
            onEnd : {
                duration: 0,
                render: function(url, $cont, $content) {
                    $body.css('cursor', 'auto');
                    $body.find('a').css('cursor', 'auto');
                    $cont.html($content);
                    BookieCore.init();
                }
            },
            development: true
        });
    }

    // create BookieForm's for each form (except inventories)
    BookieUI.forms = [];
    $("form").not(".inventory form").each(function(){
        BookieUI.forms.push( new BookieForm($(this)) );
    });

    // initialize all inventories
    BookieUI.inventories = [];
    $(".inventory").each(function(){
        BookieUI.inventories.push( new BookieInventory($(this)) );
    });

    // load twitter
    if (typeof twttr !== "undefined" && twttr.hasOwnProperty("widgets") && twttr.widgets.hasOwnProperty("load")) {
        twttr.widgets.load();
    }

    this.progressBar.init();
    this.messages.init();
    this.header.init();
    this.inited = true;
};

/**
 * BookieUI.header singleton
 * -
 * Handles everything header-related
 */
// Initialize the header UI interactions
BookieUI.header = {};
BookieUI.header.inited = false;
BookieUI.header.init = function(){
    if (this.inited) return;

    this.inited = true;

    var self = this,
        $header = $(".header"),
        scrollLimit,
        $active = $(".nav .item.active").length ? $(".nav .item.active") : $(".nav .item:first-of-type"),
        $indicator = $("#nav-indicator"),
        indicatorTimer;

    self.fixed = $(window).scrollTop() > scrollLimit;
    self.$elm = $header;
    self.$indicator = $indicator;
    self.$active = $active;

    // if this is an actual page load, not a smoothState one
    if (!BookieUI.trueInited) {
        // sticky
        $(window).scroll(function(){
            var scrollVal = $(window).scrollTop();
            if (!self.fixed && scrollVal > scrollLimit) {
                self.fixed = true;
                self.$elm.addClass("fixed");
            } else if (self.fixed && scrollVal < scrollLimit) {
                self.fixed = false;
                self.$elm.removeClass("fixed");
            }
        });

        // move indicator on resize
        $(window).resize(function(){
            if (!self.fixed) {
                scrollLimit = $(".nav").offset().top || $(".mobile-nav").offset().top;
            }
            self.moveIndicator(self.$active, true);
        });
    }
    $(window).resize();

    // indicator
    $(".nav > .item").hover(function(){
        clearTimeout(indicatorTimer);
        self.moveIndicator($(this));
    }, function(){
        indicatorTimer = setTimeout(function(){
            self.moveIndicator(self.$active);
        }, 500);
    });
};
// Move the header indicator to a given element
BookieUI.header.moveIndicator = function($elm, dontAnim){
    if (!$elm.length) return;
    
    if (dontAnim) { this.$indicator.addClass("no-anim"); }
    this.$indicator.css({
      left: $elm.position().left,
      width: $elm.width(),
      backgroundColor: $elm.css("color")
    })
    if (dontAnim) { // class is disabled too quickly for CSS to register
        var self = this;
        setTimeout(function(){self.$indicator.removeClass("no-anim")}, 5);
    }
};

/**
 * BookieUI.messages singleton
 * -
 * Handles adding/removing popup messages
 * Also acts as an array of visible messages
 **/
BookieUI.messages = [];
BookieUI.messages.inited = false;
BookieUI.messages.init = function(){
    if (this.inited) return;

    this.$container = $(".popup");
    this.inited = true;
};
BookieUI.messages.add = function(type, html, time) {
    if (!this.inited) this.init();

    // create the message element
    var $msg = $('<div class="message '+type+'"></div>')
                    .html(html)
                    .appendTo(this.$container),
        msg = $msg[0];

    BookieUI.messages.push(msg);

    // method to remove the message
    msg._removeable = true;
    msg._removeFunc = function self(){
        // if we're allowed to remove (ie. not hovering)
        if (msg._removeable) {
            clearTimeout(msg._removeTimer);

            // fade it out, then delete+remove from message list
            $msg.fadeOut(200, function(){
                var index = BookieUI.messages.indexOf(msg);
                if (index !== -1) { BookieUI.messages.splice(index,1); }

                $msg.remove();
            });
        // if not allowed, try again in .25 seconds
        } else {
            msg._removeTimer = setTimeout(self, 250);
        }
    };

    // make sure the message isn't removed while hovering it
    $msg.hover(
            function(){
                // on mouseover, disallow removal
                this._removeable = false;
                clearTimeout(this._removeTimer);
            },
            function(){
                // on mouseout, remove after 1.5 s
                this._removeable = true;

                if (typeof time === "number" && time > 0)
                    msg._removeTimer = setTimeout(this._removeFunc, 1500);
            });

    // and that it is when clicking it
    if (typeof time === "number") {
        $msg.click(function(){
            this._removeable = true;
            this._removeFunc();
        });
        $msg.css({cursor: "pointer"});
    }

    // if time is given, remove message after time milliseconds
    if (typeof time === "number" && time > 0) {
        msg._removeTimer = setTimeout(msg._removeFunc, time);
    }

    return $msg;
};
BookieUI.messages.addText = function(type, text, time) {
    // sanitize HTML
    var div = document.createElement("div");
    div.innerHTML = text;

    return this.add(type, div.textContent, time);
};
BookieUI.messages.remove = function(elm) {
    if (elm instanceof jQuery) elm = elm[0];

    if (!elm._removeFunc) return;

    elm._removeable = true;
    elm._removeFunc();
};
BookieUI.messages.setType = function($elm, type) {
    if (!($elm instanceof jQuery)) $elm = $(elm);

    $elm.removeClass("error warning success");
    $elm.addClass(type);
};

/**
 * BookieUI.popup class
 * -
 * Handles persistent popups, updated through our API
 **/
BookieUI.popup = function(token){
    if (BookieUI.popup.instance) return instance;
    
    token = token || $("input[name='_token']").val();
    if (!token) return;

    this.$elm = BookieUI.messages.add("",
        "<p class='text-center'>Loading...</p>");
    this.token = token;
    this.tickInterval = setInterval(this.tick.bind(this), 1000);

    this.update();
    this.updateInterval = setInterval(this.update.bind(this), 5000);

    // make sure we don't have multiple popups going at a time
    BookieUI.popup.instance = this;
};
BookieUI.popup.prototype.tick = function(){
    // update the time left display
    var $time = $(".time-left", this.$elm),
        time = parseInt($time.text());

    time = Math.max( 0, time - 1 );

    if (time === 0) {
        this.$elm.html("<p class='text-center'>The offer has expired.</p>");
        return;
    }

    $time.text( time );
};
BookieUI.popup.prototype.update = function(){
    var that = this,
        data = { "_token": this.token };

    if (this.state) {
        data.state = this.state;
    }

    BookieAPI.GET("/api/core/popup",
        data,
        function success(data){
            if (data.ignore) return;

            // change the popup content
            if (data.success && data.html) {
                that.$elm.html(data.html);
            }
            // change the popup type
            if (data.success && data.hasOwnProperty("type")) {
                BookieUI.messages.setType( that.$elm , data.type );
            }
            // store the last received state
            if (data.success && data.state) {
                that.state = data.state;
            }
        },
        function error(xhr, status, err){
            that.$elm.html("<p class='text-center'>Loading...</p><p>Failed to connect: "+err+"</p>");
            BookieUI.messages.setType( that.$elm , "error" );
        });
};
BookieUI.popup.prototype.destroy = function(){
    clearInterval(this.tickInterval);
    clearInterval(this.updateInterval);
    delete BookieUI.popup.instance;
    BookieUI.messages.remove( this.$elm[0] );
};

/**
 * BookieUI.progressBar singleton
 * -
 * Handles moving the progress bar.
 * Also provides method for getting an XHR
 * instance that shows progress
 **/
BookieUI.progressBar = {};
BookieUI.progressBar.inited = false;
BookieUI.progressBar.init = function(){
    if (this.inited) return;

    this.inited = true;
    this.progress = this.targetProgress = 0;
    this.visible = false;
    this.$elm = $("#progress-bar");

    // tie into jQuery AJAX requests
    // unfortunately loading sites doesn't support 
    // total size, so we use global events instead
    // start: 20%, complete: 100%
    /*var self = this;
    $(document).ajaxStart(function(e){
        self.setTarget(10);
        self.setProgress(2);
    });
    $(document).ajaxComplete(function(){
        self.setProgress(10);
    });*/
};
BookieUI.progressBar.getXHR = function(){
    var xhr = new XMLHttpRequest();
    var bar = BookieUI.progressBar;
    xhr.addEventListener("readystatechange", function(){
        switch(xhr.readyState) {
            case 1:
                bar.setTarget(10);
                bar.setProgress(1);
                break;
            case 2:
                bar.setProgress(2);
                break;
            case 3:
                bar.setProgress(5);
                break;
            case 4:
                bar.setProgress(10);
                break;
        }
    });
    return xhr;
};
BookieUI.progressBar.setProgress = function(val){
    if (!this.inited) return;

    this.progress = Math.max(0,val);

    this.draw();
};
BookieUI.progressBar.setTarget = function(val){
    if (!this.inited) return;

    this.targetProgress = Math.max(0, val);
};
BookieUI.progressBar.draw = function() {
    if (!this.inited) return;

    // set to relevant width
    if (this.targetProgress) {
        var w = Math.round(this.progress/this.targetProgress*100);
        this.$elm.show();
        this.$elm.width(w+"%");
    }

    // if finished, reset
    if (this.progress >= this.targetProgress) {
        this.progress = this.targetProgress = 0;
        this.visible = false;

        var self = this;
        setTimeout(function(){
            self.$elm.fadeOut(100, function(){
                self.$elm.width("0");
            });
        }, 100);
    } else {
        this.visible = true;
    }
};