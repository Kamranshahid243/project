/*
 * $("element").viewPortWidth(widthInPercentageOfViewPort):
 * */
(function($) {
    $.fn.viewPortWidth = function(width) {
        var element = $(this);
        var newWidth =  $(window).width() * width / 100;
        element.css({ width: newWidth+"px" });
        $(window).resize( function() {
            var newWidth =  $(window).width() * width / 100;
            element.css({ width: newWidth+"px" });
        });
        return this;
    };
}(jQuery));
/*
 * $("element").viewPortHeight(heightInPercentageOfViewPort):
 * */
(function ( $ ) {
    $.fn.viewPortHeight = function(height) {
        var element = $(this);
        var newHeight =  $(window).height() * height / 100;
        element.css({ height: newHeight+"px" });
        $(window).resize( function() {
            var newHeight =  $(window).height() * height / 100;
            element.css({ height: newHeight+"px" });
        });
        return this;
    };
}( jQuery ));
/*
* $("element").showLoader:
* shows the loader inside the element
* $("element").hideLoader:
* hides the loader
* */
(function ( $ ) {
    var loaderMarkup = '<span class="loader"><i class="fa fa-cog fa-spin spinner"></i></span>';
    $.fn.showLoader = function() {
        return this.each(function () {
            // show loader
            $(this).append(loaderMarkup);

            // vars
            var elem = $(this),
                loaderWrapper = elem.children(".loader"),
                loader = loaderWrapper.children(".spinner"),
                height = elem.height(),
                winHeight = $(window).height()
                ;
            //console.log("elemHeight: "+height);
            // height should not be too large
            if( height > winHeight ) height = winHeight;
            //console.log("winHeight: "+winHeight);
            //console.log("elemHeight: "+height);
            //console.log("loaderWrapper.height: "+loaderWrapper.height());
            var marginTop = 0.1*height,
                loaderSize = height - (marginTop * 2);
            //console.log("marginTop: "+marginTop);
            //console.log("loaderSize: "+loaderSize);

            // adjust css
            elem.css({
                position: "relative"
            });
            loaderWrapper.css({
                position: "absolute",
                left: 0,
                top: 0,
                width: "100%",
                height: "100%",
                backgroundColor: "rgba(0,0,0,0.3)",
                textAlign: "center",
                color: "#fff",
                zIndex: 9999
            });
            //console.log("loaderWrapper.outerHeight: "+loaderWrapper.outerHeight());
            //console.log("loader.height(): "+loader.height());
            loader.css({
                fontSize: loaderSize + "px",
                position: "absolute",
                //top: ((loaderWrapper.outerHeight() - loader.height())/2)+"px",
                top: ((height - loaderSize)/2)+"px",
                left: ((loaderWrapper.width() - loaderSize)/2)+"px"
                //left: ((loaderWrapper.width() - 1.1*loader.width())/2)+"px"
            });

            // disable event propagation when loader is present
            loaderWrapper.click(function () {
                return false;
            });

            // for chaining purpose
            return this;
        });

    };

    $.fn.hideLoader = function() {
        $(this).children(".loader").remove();
        return this;
    };

}( jQuery ));
/*
 * $("element").makeBackdrop():
 * makes the element full width and height as the view-port
 * and adds a semitransparent background
 * */
(function ( $ ) {
    $.fn.makeBackdrop = function() {
        $(this).css({
            position: 'fixed',
            zIndex: 9999,
            top: 0,
            width: "100%",
            height: "100%",
            backgroundColor: "rgba(0,0,0,0.5)"
        });
        return this;
    };
}( jQuery ));

/*
 * $("element").viewPortCenter():
 * positions the element to the center of the screen
 * */
(function ( $ ) {
    $.fn.viewPortCenter = function() {
        var elemHeight = $(this).height(),
            elemWidth = $(this).width(),
            parent = $(window),
            parentHeight = parent.height(),
            parentWidth = parent.width(),
            top = (parentHeight - elemHeight) / 2,
            left = (parentWidth - elemWidth) / 2;
        $(this).css({
            position: 'fixed',
            zIndex: 9999,
            top: top+"px",
            left: left+"px"
        });
        return this;
    };
}( jQuery ));
/*
 * $.showLoader:
 * shows the loader on the whole screen
 * $.hideLoader:
 * hides the loader
 * */
(function($){
    $.showLoader = function () {
        var markup = '<span id="loader-wrapper"><i class="fa fa-cog fa-spin" id="spinner"></i></span>';
        $("body").prepend(markup);

        var wrapper = $("#loader-wrapper");
        var loader = $("#spinner");

        function resizeLoader(){
            var parent = $(window),
                parentHeight = parent.height(),
                parentWidth = parent.width(),
                maxSize = parentHeight > parentWidth ? parentWidth : parentHeight,
                fontSize = maxSize * 0.6;
            loader.css({ fontSize: fontSize+"px" });
        }

        wrapper.makeBackdrop();
        resizeLoader();
        loader.viewPortCenter();
        $(window).resize( function() {
            wrapper.makeBackdrop();
            resizeLoader();
            loader.viewPortCenter();
        });
    };

    $.hideLoader = function() {
        $("#loader-wrapper").remove();
        return this;
    };

})(jQuery);
/*
 * $.showMessage:
 * shows an animated, dismiss-able message on the center of the screen
 * $.hideMessage:
 * hides the message
 * */
(function($){
    $.showMessage = function (msg,type) {
        type = type || "info";
        var markup =
            "<div id='message-wrapper'>" +
            "<div id='message' " +
            "class='alert alert-"+type+"'>" +
            msg+"<i class='fa fa-remove'></i>" +
            "</div>" +
            "</div>";

        $("body").prepend(markup);

        var wrapper = $("#message-wrapper");
        var msgDiv = $("#message");
        wrapper.makeBackdrop();
        msgDiv.css({
            position: 'absolute',
            margin: 0,
            width: '80%',
            left: '10%',
            top: '-10%',
            cursor: "pointer"
        });

        msgDiv.find(".fa").css({
            position: 'absolute',
            right: '0.5em',
            top: '0.5em'
        });

        var elemHeight = msgDiv.height(),
            parent = $(window),
            parentHeight = parent.height(),
            top = (parentHeight - elemHeight) / 2;
        msgDiv.animate({
            top: top+'px'
        }, 500, 'easeOutCirc', function() {
            msgDiv.click(function () {
                wrapper.remove();
            });
        });
        $(window).resize( function() {
            wrapper.makeBackdrop();
            msgDiv.viewPortCenter();
        });
    };
})(jQuery);