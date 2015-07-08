/**
 * BookieInventory class
 * -
 * Handles all interaction with inventories
 **/
function BookieInventory($elm, opts) {
    if (!$elm.length) return;

    var that = this;

    this.options = $.extend({}, this.defaults, opts);
    this.$elm = $elm;
    this.$items = $(".itembox", $elm);
    this.$form = $("form", $elm);
    this.$buttons = $(".btn-holder button", this.$form);
    this.$selectedHolder = $(".item-holder", this.$form);
    this.$itemHolder = $(".inventory-holder", $elm);
    this.disabled = this.$elm.hasClass("disabled");
    this.selectedItems = [];

    // any already selected items should be added to this.selectedItems
    $(".itembox", this.$selectedHolder).each(function(){
        that.getItemClickHandler.apply(that).apply(this);
    });

    // disable all inventories on submit
    this.$form.submit(function(){
        var invs = BookieUI.inventories;
        for (var i = 0; i < invs.length; ++i) {
            invs[i].toggle(false);
        }
    });

    // initialize form
    this.form = new BookieForm(this.$form);
    // inject custom logic before the form logic
    var _successHandler = this.form.submitSuccessHandler;
    this.form.submitSuccessHandler = function(data){
        that.submitSuccessHandler(data);
        _successHandler(data);
    };
    this.form.submitErrorHandler = this.submitErrorHandler;

    // paginate the inventory
    this.paginated = new BookiePaginated(this.$itemHolder);

    this.$items.click(this.getItemClickHandler());
}
// Default settings for inventories
BookieInventory.prototype.defaults = {
    maxItems: 10
};
// Toggle the inventory, optionally specify enabled/disabled
BookieInventory.prototype.toggle = function(enabled){
    // if enabled isn't set, set it to the opposite of current
    if (typeof enabled === "undefined") {
        enabled = this.disabled;
    }

    if (enabled) {
        this.$buttons.removeAttr("disabled");
    } else {
        this.$buttons.attr("disabled", !enabled+"");
    }
    this.disabled = !enabled;
    this.$elm.toggleClass("disabled", !enabled);
};
// Returns a function to be used as click event listener for items
BookieInventory.prototype.getItemClickHandler = function(){
    if (this.clickFunction) return this.clickFunction;

    var inv = this;
    // the actual click event listener
    return this.clickFunction = function(e){
        if (inv.disabled) return;

        // don't trigger if clicking the tooltip
        console.log(e);
        if (typeof e !== "undefined") {
            if ($(e.target).hasClass("tip") || $(e.target).parents(".tip").length) {
                return;
            }
        }

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
// Inventory-specific logic for when the items are submitted
BookieInventory.prototype.submitSuccessHandler = function(data){
    // reenable all inventories if not a success
    if (!data.success) {
        var invs = BookieUI.inventories;
        for (var i = 0; i < invs.length; ++i) {
            invs[i].toggle(true);
        }
    }
};
// Inventory-specific logic for when the items fail to submit
BookieInventory.prototype.submitErrorHandler = function(xhr, status, error){
    console.log("Inventory handling error");
    // reenable all inventories
    var invs = BookieUI.inventories;
    for (var i = 0; i < invs.length; ++i) {
        invs[i].toggle(true);
    }

    // show message
    BookieAPI.handleError.apply(null, arguments);
};