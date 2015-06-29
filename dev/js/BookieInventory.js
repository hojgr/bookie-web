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

    // paginate the inventory
    this.paginated = new BookiePaginated(this.$itemHolder);

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