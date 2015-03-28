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
        var txt = "Show livestreams";
        if ($streamContainer.hasClass("hidden")) {
            txt = "Hide livestreams";
        }
        $(this).text(txt);
        $streamContainer.toggleClass("hidden");
    });
    $(".languages li").click(function(){
        var $streamElm = $("#"+this.getAttribute("for"));
        console.log(this,$streamElm);
        $(".stream.active").removeClass("active").hide();
        $streamElm.addClass("active").show();
    });

    // inventories
    $(".inventory .itembox").click(function(){
        var $this = $(this),
            inv = $(this).closest(".inventory")[0],
            $btns = $(inv.getAttribute("data-bound-buttons"));

        $this.toggleClass("selected");

        // add to inventory's list of items
        if (!inv.selectedItems) { inv.selectedItems = [] }
        var items = inv.selectedItems;

        if ($this.hasClass("selected")) {
            items.push(this);
        } else {
            var i = items.indexOf(this);

            if (i !== -1) items.splice(i, 1);
        }

        if (items.length) { $btns.prop("disabled", false) }
        else { $btns.prop("disabled", true) }
    });
});