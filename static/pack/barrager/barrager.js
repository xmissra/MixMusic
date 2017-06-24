(function($) {
        $.fn.barrager = function(barrage) {
                barrage = $.extend({
                        close:true,
                        top:0,
                        max:10,
                        speed:6,
                        color:"#fff",
                        old_ie_color:"#000000"
                }, barrage || {});
                var time = new Date().getTime();
                var barrager_id = "barrage_" + time;
                var id = "#" + barrager_id;
                var div_barrager = $("<div class='barrage' id='" + barrager_id + "'></div>").appendTo($(this));
                div_barrager.css("top", barrage.top + "px");
                div_barrager_box = $("<div class='barrage_box cl'></div>").appendTo(div_barrager);
                if (barrage.img) {
                        div_barrager_box.append("<span class='portrait z'></span>");
                        var img = $("<img src=''>").appendTo(id + " .barrage_box .portrait");
                        img.attr("src", barrage.img);
                }
                div_barrager_box.append(" <div class='z p'></div>");
                if (barrage.close) {
                        div_barrager_box.append(" <div class='close z'></div>");
                }
                var content = $("<span></span>").appendTo(id + " .barrage_box .p");
                content.attr({
                        id:barrage.id
                }).empty().append(barrage.info);
                if (navigator.userAgent.indexOf("MSIE 6.0") > 0 || navigator.userAgent.indexOf("MSIE 7.0") > 0 || navigator.userAgent.indexOf("MSIE 8.0") > 0) {
                        content.css("color", barrage.old_ie_color);
                } else {
                        content.css("color", barrage.color);
                }
                var i = 0;
                div_barrager.css("margin-right", i);
                var looper = setInterval(barrager, barrage.speed);
                function barrager() {
                        var window_width = $(window).width() + 500;
                        if (i < window_width) {
                                i += 1;
                                $(id).css("margin-right", i);
                        } else {
                                $(id).remove();
                                return false;
                        }
                }
                div_barrager_box.mouseover(function() {
                        clearInterval(looper);
                });
                div_barrager_box.mouseout(function() {
                        looper = setInterval(barrager, barrage.speed);
                });
                $(id + ".barrage .barrage_box .close").click(function() {
                        $(id).remove();
                });
        };
        $.fn.barrager.removeAll = function() {
                $(".barrage").remove();
        };
})(jQuery);