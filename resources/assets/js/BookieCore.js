/**
 * BookieCore singleton
 * -
 * Handles various methods not applicable for other files
 **/
BookieCore = {};
// Called when the DOM is ready
BookieCore.init = function(){
	BookieUI.reset();
	BookieUI.init();
};
// Reloads the current page, using smoothState
BookieCore.reload = function(){
	var smooth = $("#body").smoothState().data("smoothState");
	if (smooth) {
		smooth.clear(smooth.href);
		smooth.load(smooth.href);
	} else {
		window.location.reload();
	}
};
// Sanitize an HTML string
BookieCore.sanitize = function(html){
	var div = document.createElement("div");
	div.innerHTML = html;
	return div.textContent;
};
$(BookieCore.init);