/**
 * BookieLightbox singleton
 * -
 * Handles the global lightbox
 */
var BookieLightbox = {};
BookieLightbox.init = function(){
	// main element
	this.$elm = $(".lightbox").removeClass("open");
	if (!this.$elm.length) {
		this.$elm = $("<div class='lightbox'></div>").appendTo("body");
	}

	// element in which content is placed
	this.$content = $(".content", this.$elm);
	if (!this.$content.length) {
		this.$content = $("<div class='content'></div>").appendTo(this.$elm);
	}

	// bind click
	if (!this.$elm[0].bound) {
		this.$elm[0].bound = true;
		this.$elm.click(this.close.bind(this));
	}
};
// Open the lightbox with some given data, and (optionally) element type
BookieLightbox.open = function(data, type){
	var gen = this.generators[type] || this.generators.image,
	    $cont = gen(data);

	// insert to DOM
	this.$content.empty()
	             .append($cont);
	this.$elm.addClass("open");
};
// Close the lightbox
BookieLightbox.close = function(){
	this.$elm.removeClass("open");
	this.$content.empty();
};
// Triggered on a lightbox-enabled element when it's clicked
BookieLightbox.handleElementClick = function(){
	var $this = $(this),
	    type = $this.attr("data-lightbox-type") || "image",
	    data = $this.attr("data-lightbox");

	if (!data) return;

	BookieLightbox.open(data, type);
};
// Generate the content for the lightbox, based on type
BookieLightbox.generators = {
	"image": function(url){
		return $("<img src='"+url+"'>");
	}
};
