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
    this.queue.inited = !!$("#queue").length;
}
// Initialize all JS-side UI interactions
BookieUI.init = function(){
    if (this.inited) return;

    // initialize smoothState for smooth loading without the MVC structure
    if (!this.trueInited && matchMedia("max-width: 465px")) {
        var $body = $("html, body");
        
        $("#body").smoothState({
            callback: init, // call init when the DOM is ready
            onStart : { // animate out
                duration: 100,
                render: function(url, $cont) {
                    $(".page",$cont).addClass("fadeout");
                    $("#body > .loader").removeClass("hidden");
                }
            },
            onEnd: { // remove the loader
                duration: 0,
                render: function(url, $cont, $new){
                    $body.css('cursor', 'auto');
                    $body.find('a').css('cursor', 'auto');
                    $cont.html($new);
                    $cont.removeClass("fadeout");
                }
            },
            development: true
        });
    }

    // create BookieForm's for each form
    $("form").each(function(){
        new BookieForm($(this));
    });

    // initialize all inventories
    $(".inventory").each(function(){
        var inv = new BookieInventory($(this));
    });

    // load twitter
    if (typeof twttr !== "undefined" && twttr.widgets.hasOwnProperty("load")) {
        twttr.widgets.load();
    }

    this.progressBar.init();
    this.messages.init();
    this.queue.init();
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
 * BookieUI.queue singleton
 * -
 * Handles setting/hiding the queue
 */
BookieUI.queue = {};
BookieUI.queue.inited = false;
BookieUI.queue.init = function(){
    if (this.inited) return;

    this.$elm = $('<div id="queue"></div>').hide().appendTo("body");
    this.inited = true;
};
BookieUI.queue.set = function(html){
    if (!this.inited) this.init();

    this.$elm.html(html);
    this.$elm.fadeIn(200);
};
BookieUI.queue.remove = function(){
    if (!this.inited) return;

    var self = this;
    self.inited = false;
    this.$elm.fadeOut(200, function(){
        self.$elm.remove();
    });
}

/**
 * BookieUI.messages singleton
 * -
 * Handles adding/removing simple text-only messages
 * Also acts as an array of visible messages
 **/
BookieUI.messages = [];
BookieUI.messages.inited = false;
BookieUI.messages.init = function(){
    if (this.inited) return;

    this.$container = $('<div class="message-container"></div>').insertBefore(".page");
    this.inited = true;
};
BookieUI.messages.add = function(type, text) {
    if (!this.inited) this.init();

    // create the message element
    var $msg = $('<div class="message message-'+type+'"></div>')
                    .text(text)
                    .appendTo(this.$container);
    BookieUI.messages.push($msg[0]);

    // remove the message after 3.5 seconds
    $msg[0]._removeable = true;
    $msg[0]._removeFunc = function self(){
        // if we're allowed to remove
        if ($msg[0]._removeable) {
            clearTimeout($msg[0]._removeTimer);

            // fade it out, then delete+remove from message list
            $msg.fadeOut(200, function(){
                var index = BookieUI.messages.indexOf($msg[0]);
                if (index !== -1) { BookieUI.messages.splice(index,1); }

                $msg.remove();
            });
        // if not allowed, try again in .25 seconds
        } else {
            $msg[0]._removeTimer = setTimeout(self, 250);
        }
    };
    $msg[0]._removeTimer = setTimeout($msg[0]._removeFunc, 3500);

    // make sure the message isn't removed while hovering it
    $msg.hover(
            function(){
                // on mouseover, disallow removal
                this._removeable = false;
                clearTimeout(this._removeTimer);
            },
            function(){
                // on mouseout, remove after 2.5 s
                this._removeable = true;
                $msg[0]._removeTimer = setTimeout(this._removeFunc, 2500);
            })
    // and that it is when clicking it
        .click(function(){
            this._removeable = true;
            this._removeFunc();
        });


    return $msg;
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

/**
 * jQuery document.onready
 * -
 * Triggers once the DOM has loaded
 **/
function init(){
    BookieUI.reset();
    BookieUI.init();
}
$(init);