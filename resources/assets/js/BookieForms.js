/**
 * BookieForm class
 * -
 * Handles all custom form functionality
 **/
var BookieForm = function($elm){
	if (!$elm.length) return;

    this.$elm = $elm;

	// send the clicked 'submit' button as a POST param
    $("[type='submit']", $elm).click(this.submitClickHandler);

    // make verified inputs verify themselves
    $("input[data-verify-url]", $elm).on("input", this.verifyChangeHandler.bind(this));

    // make form submit over AJAX
    $elm.submit(this.submitHandler.bind(this));
};
// Saves the name and value of the clicked `submit` button to a hidden input
BookieForm.prototype.submitClickHandler = function(e){
    var $this = $(this),
        name = $this.attr("name"),
        val = $this.attr("value"),
        $form = $this.closest("form"),
        $inp = $("input[type='hidden'][name='"+name+"']", $form);

    // save clicked 'submit' button to hidden input
    if (name && val) {
        if ($inp.length) {
            $inp.first().attr("value", val);
        } else {
            $form.prepend("<input type='hidden' name='"+name+"' value='"+val+"'>");
        }
    }
}
// Send the form over AJAX instead of reloading
BookieForm.prototype.submitHandler = function(e){
    e.preventDefault();
    var $elm = this.$elm,
        url = $elm.attr("action"),
        data = $elm.serialize();

    // Submit
    BookieAPI.sendRequest({
        type: "POST",
        url: url,
        data: data,
        success: this.submitSuccessHandler,
        xhr: BookieUI.progressBar.getXHR
    });
};
// Success handler for form submission
BookieForm.prototype.submitSuccessHandler = function(data){
    // messages and popups are handled by BookieAPI
    if (!data.message && !data.popup) {
        if (data.success) {
            BookieUI.messages.addText(
                "success",
                $this.attr("data-success-text") || "Submitted succesfully!");
        } else {
            BookieUI.messages.addText(
                "error",
                $this.attr("data-error-text") || "Whoops! Looks like something went wrong. Try reloading.");
        }
    }
};
BookieForm.prototype.verifyChangeHandler = function(e){
    var that = e.target,
        form = this,
        $holder = $(that.parentNode);

    // reset timer/state, and stop verifying if currently verifying
    clearTimeout(that.changeTimeout);
    $holder.removeClass("verified error warning");
    if (that.verifying) {
        form.inputs.stopVerification(that);
        return;
    }

    // verify input if no change event has happened for 1 second
    that.changeTimeout = setTimeout(
        form.inputs.startVerification.bind(form, that)
    , 1000);
};
BookieForm.prototype.inputs = {};
BookieForm.prototype.inputs.startVerification = function(elm){
    var val = elm.value,
        $holder = $(elm.parentNode),
        url = elm.getAttribute("data-verify-url"),
        that = this;

    if (!$holder.length || !val || !url) return;

    // do a GET call to the verification URL
    elm.verifying = true;
    elm.verifyingID = elm.verifyingID + 1 || 1;
    $holder.addClass("verifying");

    BookieAPI.GET(url,
        {tradeURL: elm.value},
        this.inputs.onVerification.bind(this, elm, elm.verifyingID),
        function(){
            that.inputs.showWarning(elm, "Could not reach validation server");
            that.inputs.stopVerification(elm);
        });
};
BookieForm.prototype.inputs.stopVerification = function(elm){
    var $holder = $(elm.parentNode);

    if (!$holder.length) return;

    elm.verifying = false;
    $holder.removeClass("verifying");
};
BookieForm.prototype.inputs.onVerification = function(elm, ID, json){
    // abort early if a new verification has started
    if (elm.verifyingID !== ID) return;

    if (!json.success) {
        this.inputs.showWarning(elm, "Could not be validated");
    } else if (!json.valid) {
        this.inputs.showError(elm, "Input is invalid");
    } else {
        this.inputs.showVerified(elm);
    }

    this.inputs.stopVerification(elm);
};
BookieForm.prototype.inputs.onVerificationError = function(elm){
    this.inputs.showWarning(elm, "Could not reach the validation server");
};
BookieForm.prototype.inputs.showWarning = function(elm, msg) {
    console.log("WARNING: ",msg," (on ",elm,")");
};
BookieForm.prototype.inputs.showError = function(elm, msg) {
    var $holder = $(elm.parentNode);
    $holder.addClass("error");
}
BookieForm.prototype.inputs.showVerified = function(elm) {
    var $holder = $(elm.parentNode);
    $holder.addClass("verified");
}
