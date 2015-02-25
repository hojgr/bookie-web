$(document).ready(function() {

    $(document).on("click", ".bet .itembox", function() {
        var $this = $(this);
        if (($this).data("contains") === "empty" ) {
            return;
        }
        $this.fadeOut('slow', function() {
            $this.appendTo($(".inventory h1")).show();
            $('<div class="itembox" data-contains="empty">Empty</div>').appendTo($(".bet"));
        });
    });

    $(document).on("click", ".inventory .itembox", function() {
        var $this = $(this);

        $this.fadeOut('slow', function() {
            $(".bet .itembox[data-contains='empty']").first().replaceWith($this.show());
        });
    });
});