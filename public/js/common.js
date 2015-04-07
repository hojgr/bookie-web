/**
 * BookieUI object
 * -
 * Handles all basic interactions with the DOM
 **/
var BookieUI = {};
// Initialize all JS-side UI interactions
BookieUI.init = function(){
    if (this.inited) return;

    // make all forms submit over AJAX
    $("*[type='submit']").click(function(e){
        var $this = $(this),
            name = $this.attr("name"),
            val = $this.attr("value"),
            $form = $this.closest("form"),
            $inp = $("input[type='hidden'][name='"+name+"']");

        // save clicked 'submit' button to hidden input
        if ($inp.length) {
            $inp.first().attr("value", val);
        } else {
            $form.prepend("<input type='hidden' name='"+name+"' value='"+val+"'>");
        }
    });
    $("form").submit(function(e){
        e.preventDefault();
        var $this = $(this),
            url = $this.attr("action"),
            data = $this.serialize();

        console.log(data);
        $.post(url, data);
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
        scrollLimit = $(".nav").offset().top,
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
    $(".nav .item").hover(function(){
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