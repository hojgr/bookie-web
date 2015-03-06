$(document).ready(function() {
    $(".matchbox").click(function() {
        window.location = "match/" + $(this).data('mid');
    });
});