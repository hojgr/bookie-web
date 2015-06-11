/**
 * BookieUI singleton
 * -
 * Handles all basic interactions with the DOM
 **/
var BookieUI = {};
// Initialize all JS-side UI interactions
BookieUI.init = function(){
    if (this.inited) return;

    // send the clicked 'submit' button as a POST param
    $("*[type='submit']").click(function(e){
        var $this = $(this),
            name = $this.attr("name"),
            val = $this.attr("value"),
            $form = $this.closest("form"),
            $inp = $("input[type='hidden'][name='"+name+"']");

        // save clicked 'submit' button to hidden input
        if (name && val) {
            if ($inp.length) {
                $inp.first().attr("value", val);
            } else {
                $form.prepend("<input type='hidden' name='"+name+"' value='"+val+"'>");
            }
        }
    });
    // make all forms submit over AJAX
    $("form").submit(function(e){
        e.preventDefault();
        var $this = $(this),
            url = $this.attr("action"),
            data = $this.serialize();

        console.log(data);
        $.post(url, data, function(data){
            // received message is JSON, as defined in our API documentation
            // if action failed, show error message
            if (!data.success) {
                var msgType = data.messageType ? data.messageType : "error",
                    msg = data.message ? data.message : "Whoops! Looks like something went wrong.";
                
                BookieUI.messages.add(msgType, msg);
                return;
            }

            if (data.hasOwnProperty("message")) {
                var msgType = data.messageType ? data.messageType : "default";

                BookieUI.messages.add(msgType, data.message);
                return;
            }
            if (data.hasOwnProperty("queue")) {
                BookieUI.queue.set(data.queue);
                return;
            }
        });
    });

    // initialize all inventories
    $(".inventory").each(function(){
        var inv = new BookieInventory($(this));
    });

    this.initHeader();
    this.inited = true;
};
// Initialize the header UI interactions
BookieUI.initHeader = function(){
    if (this.inited) return;

    var self = this,
        $header = $(".header"),
        scrollLimit = $(".nav").offset().top || $(".mobile-nav").offset().top,
        $active = $(".nav .item.active, .nav .item:first-of-type"),
        $indicator = $("#nav-indicator"),
        indicatorTimer;

    self.header = {
        fixed: $(window).scrollTop() > scrollLimit,
        $elm: $header,
        $indicator: $indicator
    };

    // sticky
    $(window).scroll(function(){
        var scrollVal = $(window).scrollTop();
        if (!self.header.fixed && scrollVal > scrollLimit) {
            self.header.fixed = true;
            $header.addClass("fixed");
        } else if (self.header.fixed && scrollVal < scrollLimit) {
            self.header.fixed = false;
            $header.removeClass("fixed");
        }
    });

    // indicator
    $(".nav > .item").hover(function(){
        clearTimeout(indicatorTimer);
        self.moveIndicator($(this));
    }, function(){
        indicatorTimer = setTimeout(function(){
            self.moveIndicator($active);
        }, 500);
    });

    // move indicator on resize
    $(window).resize(function(){
        self.moveIndicator($active);
    }).resize();
};
// Move the header indicator to a given element
BookieUI.moveIndicator = function($elm){
    if (!$elm.length) return;
    
    this.header.$indicator.css({
      left: $elm.position().left,
      width: $elm.width(),
      backgroundColor: $elm.css("color")
    })
};

/**
 * BookieUI.queue singleton
 * -
 * Handles setting/hiding the queue
 */
BookieUI.queue = {};
BookieUI.queue.inited = false;
BookieUI.queue.init = function(){
    if (this.inited) { return; }

    this.$elm = $('<div id="queue"></div>').hide().appendTo("body");
    this.inited = true;
};
BookieUI.queue.set = function(html){
    if (!this.inited) { this.init(); }

    this.$elm.html(html);
    this.$elm.fadeIn(200);
};
BookieUI.queue.remove = function(){
    if (!this.inited) { return; }

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
    if (this.inited) { return; }

    this.$container = $('<div class="message-container"></div>').insertBefore(".page");
    this.inited = true;
};
BookieUI.messages.add = function(type, text) {
    if (!this.inited) { this.init(); }

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
 * BookieInventory class
 * -
 * Handles all interaction with inventories
 **/
function BookieInventory($elm, opts) {
    if (!$elm.length) return;

    this.options = $.extend({}, this.defaults, opts);
    this.$elm = $elm;
    this.$items = $(".itembox", $elm);
    this.$form = $("form", $elm);
    this.$buttons = $(".btn-holder button", this.$form);
    this.$selectedHolder = $(".item-holder", this.$form);
    this.$itemHolder = $(".inventory-holder", $elm);
    this.selectedItems = [];

    this.$items.click(this.getItemClickHandler());
}
// Default settings for inventories
BookieInventory.prototype.defaults = {
    maxItems: 10
};
// Returns a function to be used as click event listener for items
BookieInventory.prototype.getItemClickHandler = function(){
    if (this.clickFunction) return this.clickFunction;

    var inv = this;
    // the actual click event listener
    return this.clickFunction = function(){
        var selectedInd = inv.selectedItems.indexOf(this),
            selected = selectedInd !== -1,
            $this = $(this);

        if (selected) {
            inv.selectedItems.splice(selectedInd, 1);
            $(this).appendTo(inv.$itemHolder);
        } else if (inv.selectedItems.length < inv.options.maxItems) {
            inv.selectedItems.push(this);
            $(this).appendTo(inv.$selectedHolder);
        }

        inv.clickHandler();
    };
};
// Called on the inventory when an item has been clicked
BookieInventory.prototype.clickHandler = function(){
    if (this.selectedItems.length) {
        this.$buttons.removeAttr("disabled");
    } else {
        this.$buttons.attr("disabled", "true");
    }
};



/**
 * jQuery document.onready
 * -
 * Triggers once the DOM has loaded
 **/
$(function() {
    BookieUI.init();
});