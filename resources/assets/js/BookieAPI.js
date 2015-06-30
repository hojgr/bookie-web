/**
 * BookieAPI singleton
 * -
 * Proxy for API requests, handling shared logic
 **/
var BookieAPI = {};
// Send a request using an object of jQuery AJAX options
BookieAPI.sendRequest = function(opts){
	if (!opts.url) return;

	// wrap the success/error callbacks in our API handling logic
	if (!opts.success) {
		opts.success = function(){};
	}
	if (!opts.error) {
		opts.error = this.handleError;
	}
	opts.success = this.handleSuccess.bind({callback: opts.success});

	// perform the AJAX request
	return $.ajax(opts);
};
// Send a GET request to a given URL
BookieAPI.GET = function(url, data, success, error) {
	if (data instanceof Function) {
		error = success;
		success = data;
		data = "";
	};

	return this.sendRequest({
		url: url,
		data: data,
		method: "GET",
		success: success,
		error: error
	});
};
// Send a POST request to a given URL
BookieAPI.POST = function(url, data, success, error) {
	return this.sendRequest({
		url: url,
		method: "POST",
		data: data,
		success: success,
		error: error
	});
}
// Handle any request that doesn't respond with an HTTP error
BookieAPI.handleSuccess = function(data){
	if (typeof data === "string") {
		try { data = JSON.parse(data); }
		catch (e) {
			console.error("API responded with ",data);
			data = {success: false};
		}
	}

	// default to error if not a success
	if (!data.success && !data.messageType && !data.popupType) {
		data.messageType = "error";
		data.popupType = "error";
	}

	// show messages if applicable
	if (!data.ignore) {
		if (data.message) {
			BookieUI.messages.addText(
					data.messageType || "",
					data.message);
		}
		if (data.popup) {
			BookieUI.messages.add(
					data.popupType || "",
					data.popup);
		}
	}

	// call the original success handler with the data
	this.callback(data);
};
// Fallback handler for requests that respond with an HTTP error
BookieAPI.handleError = function(xhr, status, err){
	console.log("Failed",arguments);

	BookieUI.messages.addText(
			"error",
			"Failed to connect: "+err);
};