/**
 * BookieForm class
 * -
 * Handles all custom form functionality
 **/
var BookieForm = function($elm){
    console.log("BookieForm called on ",$elm[0]);

	if (!$elm.length) return;

	// send the clicked 'submit' button as a POST param
    $("[type='submit']", $elm).click(this.submitClickHandler);

    // make form submit over AJAX
    $elm.submit(this.submitHandler);
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
    var $this = $(this),
        url = $this.attr("action"),
        data = $this.serialize();

    $.ajax({
        type: "POST",
        url: url,
        data: data,
        success: function(data){
            // received message is JSON, as defined in our API documentation
            // if action failed, show error message
            if (!data.success) {
                var msgType = data.messageType ? data.messageType : "error",
                    msg = data.message ? data.message : "Whoops! Looks like something went wrong.";
                
                BookieUI.messages.add(msgType, msg);
                return;
            }

            if (data.hasOwnProperty("message")) {
                var msgType = data.messageType ? data.messageType : "default";

                BookieUI.messages.add(msgType, data.message);
                return;
            }
            if (data.hasOwnProperty("queue")) {
                BookieUI.queue.set(data.queue);
                return;
            }
        },
        xhr: BookieUI.progressBar.getXHR
    });
}