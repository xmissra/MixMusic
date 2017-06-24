$(function() {
        $("#btntop").live({
                mouseover:function() {
                        $("html,body").animate({
                                scrollTop:0
                        }, 1e4);
                },
                mouseout:function() {
                        $("html,body").stop();
                }
        });
        $("#btnbottom").live({
                mouseover:function() {
                        $("html,body").animate({
                                scrollTop:document.body.clientHeight
                        }, 1e4);
                },
                mouseout:function() {
                        $("html,body").stop();
                }
        });
        $("#btntop").click(function() {
                $("html,body").stop();
                $("html,body").animate({
                        scrollTop:0
                }, 100);
        });
        $("#btnbottom").click(function() {
                $("html,body").stop();
                $("html,body").animate({
                        scrollTop:document.body.clientHeight
                }, 100);
        });
});