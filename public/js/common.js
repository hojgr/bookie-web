$(function() {
    // sticky header
    var $header = $(".header"),
        headerLimit = $(".nav").offset().top;
    $(window).scroll(function(){
        var scrollVal = $(window).scrollTop();
        if (scrollVal > headerLimit) {
            $header.addClass("fixed");
        } else {
            $header.removeClass("fixed");
        }
    });

    // header indicator
    var $active = $(".item.active, .item:first-of-type"),
        $indicator = $("#nav-indicator"),
        indicatorTimer;

    $(".nav li").hover(function(){
        clearTimeout(indicatorTimer);
        moveIndicator($(this));
    }, function(){
        indicatorTimer = setTimeout(function(){
            moveIndicator($active);
        }, 500);
    });

    $(window).resize(function(){
        moveIndicator($active);
    }).resize();

    function moveIndicator($elm){
      $indicator.css({
        left: $elm.position().left,
        width: $elm.width(),
        backgroundColor: $elm.css("color")
      })
    }

    // match streams
    var $streamContainer = $(".stream-container");
    $(".streams > a").click(function(){
        $streamContainer.toggleClass("hidden");
    });
    $(".languages li").click(function(){
        var $streamElm = $("#"+this.getAttribute("for"));
        console.log(this,$streamElm);
        $(".stream.active").removeClass("active").hide();
        $streamElm.addClass("active").show();
    });
});