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
    // sort by price
    this.paginated.setSorter(this.sorters.value.bind(this));

    // bind the sorting/filtering UI
    this.bindUI();
    this.sortDir = 1;
    this.searchStr = "";

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
        } else {
            return;
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

    this.paginated.render();
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
    // reenable all inventories
    var invs = BookieUI.inventories;
    for (var i = 0; i < invs.length; ++i) {
        invs[i].toggle(true);
    }

    // show message
    BookieAPI.handleError.apply(null, arguments);
};
// Bind the sorting/filtering UI
BookieInventory.prototype.bindUI = function(){
    var that = this,
        $ui = $(".inventory-ui", this.$elm),
        iconMapping = {
            "sorters": ["value", "quality"],
            "filters": ["stattrak", "stickers", "misc"]
        },
        $icons = {
            "sorters": $(),
            "filters": $()
        },
        paginatedBinders = {
            "sorters": this.paginated.setSorter.bind(this.paginated),
            "filters": function(filter){
                that.paginated.clearFilters(true);
                that.paginated.addFilter(filter);
            }
        };

    // bind all click handlers for icons
    for (var k in iconMapping) {
        if (!iconMapping.hasOwnProperty(k)) continue;

        for (var i = 0; i < iconMapping[k].length; ++i) {
            // make sure we use this iterations i,k in the click handler
            (function(i,k){
                // get element, attach click handler
                var $elm = $("i."+iconMapping[k][i], $ui)
                                .click(function(){
                                    var func = that[k][iconMapping[k][i]].bind(that);
                                    if (!func) return;

                                    // clear filters if disabling a filter
                                    if (k === "filters" && $(this).hasClass("active")) {
                                        $(this).removeClass("active");
                                        that.paginated.clearFilters();
                                        return;
                                    }

                                    // reset all icons
                                    $icons[k].removeClass("active");

                                    // activate self
                                    $(this).addClass("active");

                                    // apply
                                    paginatedBinders[k](func);
                                });

                // save to appropriate list
                $icons[k] = $elm.add($icons[k]);
            })(i,k);
        }
    }

    // bind sorting direction
    $("i.dir", $ui).click(function(){
        $(this).toggleClass("asc desc");
        that.sortDir = that.sortDir - (2*that.sortDir); // toggle 1 <-> -1
        that.paginated.render();
    })

    // bind search
    $("input[type='search']", $ui).on("input", function(){
        var val = $(this).val().trim();
        if (!val && !that.searchStr) return;

        // reset icons
        $icons.filters.removeClass("active");

        // apply
        that.searchStr = val;
        paginatedBinders.filters(that.filters.search.bind(that));
    });
};
// Various inventory-specific sorters for the pagination
BookieInventory.prototype.sorters = {
    value: function(a,b){
        var p1 = a.value || $(".item-price", a).text()-0,
            p2 = b.value || $(".item-price", b).text()-0;

        a.value = p1;
        b.value = p2;

        var dir = this.sortDir || 1;
        p1 *= dir;
        p2 *= dir;

        // handle unparseable values (move to top)
        if (isNaN(p1))
            p1 = -999 * dir;
        if (isNaN(p2))
            p2 = -999 * dir;

        return p2-p1;
    },

    quality: (function(){
        var qualities = ["Contraband", "Melee", "Covert", "Classified", "Restricted", "Mil-Spec", "Industrial", "Consumer"];
        var sorter = function(a,b){
            var q1 = a.quality || $(".item-quality", a).text(),
                q2 = b.quality || $(".item-quality", b).text();

            // convert eg. "Classified Pistol" -> "Classified"
            if (!a.quality || !b.quality) {
                for (var i = 0; i < qualities.length; ++i) {
                    if (q1.indexOf(qualities[i]) !== -1)
                        q1 = qualities[i];
                    if (q2.indexOf(qualities[i]) !== -1)
                        q2 = qualities[i];
                }
            }

            a.quality = q1;
            b.quality = q2;

            var dir = this.sortDir || 1,
                ind1 = qualities.indexOf(q1) * dir,
                ind2 = qualities.indexOf(q2) * dir;

            // handle non-skins (eg. "Base Grade Container")
            if (ind1 === -1)
                ind1 = 999 * dir;
            if (ind2 === -1)
                ind2 = 999 * dir;

            return ind1 - ind2;
        };

        return sorter;
    })()
};
// Various inventory-specific filters for the pagination
BookieInventory.prototype.filters = {
    stattrak: function(i, elm){
        return !!$(".item-stattrak", elm).length;
    },
    stickers: function(i, elm){
        var q = $(".item-quality", elm).text();

        return q.indexOf("Sticker") !== -1;
    },
    misc: (function(){
        var blacklist = ["Sticker", "Contraband", "Melee", "Covert", "Classified", "Restricted", "Mil-Spec", "Industrial", "Consumer"]
        var filter = function(i, elm){
            var q = $(".item-quality", elm).text();

            for (var i = 0; i < blacklist.length; ++i) {
                if (q.indexOf(blacklist[i]) !== -1)
                    return false;
            }

            return true;
        };

        return filter;
    })(),
    search: (function(){
        var regexpChars = /[^0-9a-z]/g,
            regexpSpace = /(\s){2,}/g;

        var filter = function(i, elm){
            var str = this.searchStr.trim().toLowerCase();

            // remove non-nums/non-chars, and limit to 1 space in a row
            str = str.replace(regexpChars, " ").replace(regexpSpace, "$1");

            if (!str) return true;

            var data = [
                        $(".item-exterior", elm).text(),
                        $(".item-quality", elm).text(),
                        $(".tip h4", elm).text()
                       ];

            // return true if any data matches search str
            for (var i = 0; i < data.length; ++i) {
                var d = data[i].toLowerCase()
                               .replace(regexpChars, " ").replace(regexpSpace, "$1");
                if (d.indexOf( str ) !== -1) {
                    return true;
                }
            }

            return false;
        };

        return filter;
    })()
};