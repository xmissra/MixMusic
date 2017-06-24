$(function() {
        $(".nav_home").live({
                mouseover:function() {
                        $(".sub_mv").hide();
                        $(".sub_mymusic").hide();
                        $(".sub_lib").show();
                }
        });
        $(".nav_mv").live({
                mouseover:function() {
                        $(".sub_lib").hide();
                        $(".sub_mymusic").hide();
                        $(".sub_mv").show();
                }
        });
        $(".nav_mymusic").live({
                mouseover:function() {
                        $(".sub_lib").hide();
                        $(".sub_mv").hide();
                        $(".sub_mymusic").show();
                }
        });
        $(".nav_musicvip").live({
                mouseover:function() {
                        $(".sub_lib").hide();
                        $(".sub_mv").hide();
                        $(".sub_mymusic").hide();
                }
        });
        $(".main_top").live({
                mouseleave:function() {
                        if (_menu == "music") {
                                $(".sub_mv").hide();
                                $(".sub_mymusic").hide();
                                $(".sub_lib").show();
                        } else {
                                $(".sub_lib").hide();
                                $(".sub_mymusic").hide();
                                $(".sub_mv").show();
                        }
                }
        });
});