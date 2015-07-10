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
// `Array.prototype.sort` isn't stable. Merge sort is.
BookieCore.mergeSort = (function(){
	// from http://stackoverflow.com/a/7730507/645768
	function mergeSort(arr, compare){
		var len = arr.length,
		    mid = Math.floor(len / 2);

		// handle default compare
		if (!compare) {
			compare = function(a,b){ return a-b; }
		}

		// can't split if single-element array
		if (len < 2)
			return arr;

		// merge the two halfs in order
		return merge(
			mergeSort( arr.slice(0, mid) , compare ),
			mergeSort( arr.slice(mid, len) , compare ),
			compare
		);
	}

	function merge(a, b, compare) {
		var res = [];

		// while we haven't merged fully
		while (a.length || b.length) {
			// if there are elements from both halfs
			if (a.length && b.length) {
				// compare and insert the appropriate
				if ( compare(a[0], b[0]) <= 0 ) {
					res.push(a[0]);
					a = a.slice(1);
				} else {
					res.push(b[0]);
					b = b.slice(1);
				}
			// otherwise, insert whichever half still has elements
			} else if (a.length) {
				res.push(a[0]);
				a = a.slice(1);
			} else {
				res.push(b[0]);
				b = b.slice(1);
			}
		}
		return res;
	}

	return mergeSort;
})();
$(BookieCore.init);