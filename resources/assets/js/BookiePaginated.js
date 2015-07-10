/**
 * BookiePaginated class
 * -
 * Handles pagination on elements
 */
function BookiePaginated($elm, opts) {
	if (!$elm.length) return;

	opts = $.extend({}, this.defaults, opts);

	this.options = opts;
	this.$elm = $elm;
	this.page = 0;

	this.render();
};
BookiePaginated.prototype.defaults = {
	pageSize: 25, // elements pr. page
};
// Create the UI used to move from page to page
BookiePaginated.prototype.createUI = function(){
	var $ui = $('<ul class="pagination hidden"><li class="disabled">&lt;</li><div class="pages"></div><li class="disabled">&gt;</li></ul>'),
	    self = this;

	// make the left/right arrows work
	$ui.leftArrow = $ui.children(":first-child");
	$ui.rightArrow = $ui.children(":last-child");
	$ui.leftArrow.click(function(){
		if (this.classList.contains("disabled")) return true;

		self.page = Math.max( self.page - 1, 0 );
		self.render();
	});
	$ui.rightArrow.click(function(){
		if (this.classList.contains("disabled")) return true;

		++self.page;
		self.render();
	});

	// add to DOM and self
	$ui.insertAfter(this.$elm);
	this.$ui = $ui;
};
BookiePaginated.prototype.updateUI = function($children){
	if (!this.hasOwnProperty("$ui")) this.createUI();

	// if we only have one page, hide UI and end
	if ($children.length <= this.options.pageSize) {
		this.$ui.addClass("hidden");
		return;
	}

	var maxPage = Math.ceil( $children.length / this.options.pageSize ) - 1,
	    self = this;

	// disable/enable the left/right arrows
	this.$ui.leftArrow.toggleClass("disabled", this.page === 0);
	this.$ui.rightArrow.toggleClass("disabled", this.page >= maxPage);

	// add numbers
	function createPageLi(num){
		var $elm = $("<li>"+(num+1)+"</li>");

		if (num === self.page) $elm.addClass("active");

		$elm.click(function(){
			self.setPage(num);
		});
		return $elm;
	};

	var $pagesContainer = this.$ui.children(".pages");
	$pagesContainer.children().remove();

	// draw start/end and current page (+- 1) if not on either
	var shouldDraw = [0, this.page-1, this.page, this.page+1, maxPage];
	// make sure each page is only drawn once, and only actual pages
	shouldDraw = shouldDraw.filter(function(v, i, a){
		return a.indexOf( Math.max( Math.min( v, maxPage ) , 0 ) ) === i;
	});
	// actually create the elements
	for (var i = 0; i < shouldDraw.length; ++i) {
		var num = shouldDraw[i],
		    $elm = createPageLi(num);

		$pagesContainer.append( $elm );
		
		// create "..." for gaps
		if (num>0 && num<maxPage) {
			if (shouldDraw.indexOf(num-1) === -1) {
				$('<li class="disabled">...</li>').insertBefore($elm);
			}
			if (shouldDraw.indexOf(num+1) === -1) {
				$('<li class="disabled">...</li>').insertAfter($elm);
			}
		}
	}

	// make sure it's shown
	this.$ui.removeClass("hidden");
};
BookiePaginated.prototype.setPage = function(page){
	this.page = Math.max( 0, page );
	this.render();
};
// Apply pagination and filter/sort
BookiePaginated.prototype.render = function(){
	var $children = this.$elm.children(),
	    $elms = $children,
	    opts = this.options;

	$children.addClass("hidden");

	// sort/filter elements
	if (this.filter) $elms = $elms.filter(this.filter);
	if (this.sorter) $elms = $( BookieCore.mergeSort($elms, this.sorter) );

	// order them in the DOM
	if (this.sorter)
		this.$elm.prepend($elms);

	// update the UI
	this.updateUI($elms);

	// find the elements visible on page
	$elms = $elms.slice(opts.pageSize * this.page,
		                opts.pageSize * (this.page+1));

	// show the elements on the current page
	$elms.removeClass("hidden");
};
// Sets the function used for sorting elements
// Sorter follows Array.prototype.sort callback signature
BookiePaginated.prototype.setSorter = function(sorter){
	this.sorter = sorter;
	this.render();
};
BookiePaginated.prototype.removeSorter = function(){
	delete this.sorter;
	this.render();
};
// Sets the function used for filtering elements
// Filter has signature function(index, elm){}
BookiePaginated.prototype.setFilter = function(filter){
	this.filter = filter;
	this.render();
};
BookiePaginated.prototype.removeFilter = function(){
	delete this.filter;
	this.render();
};