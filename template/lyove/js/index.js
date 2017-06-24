$(function() {
        function c(e, m) {
                e = $(e) ? $(e) :e;
                e.addClass(m).siblings().removeClass(m);
        }
        function b(e) {
                if ($("#actor").is(":animated") == false) {
                        d += e;
                        if (d != -1 && d != h) $("#actor").animate({
                                marginLeft:-d * f + "px"
                        }, j); else if (d == -1) {
                                d = h - 1;
                                $("#actor").css({
                                        marginLeft:-(f * (d - 1)) + "px"
                                });
                                $("#actor").animate({
                                        marginLeft:-(f * d) + "px"
                                }, j);
                        } else if (d == h) {
                                d = 0;
                                $("#actor").css({
                                        marginLeft:-f + "px"
                                });
                                $("#actor").animate({
                                        marginLeft:"0px"
                                }, j);
                        }
                        c($("#numInner span").eq(d), "on");
                }
        }
        function g(e) {
                if ($("#actor").css("marginLeft") != -e * f + "px") {
                        $("#actor").css("marginLeft", -e * f + "px");
                        $("#actor").fadeOut(0, function() {
                                $("#actor").fadeIn(500);
                        });
                }
        }
        function a() {
                k = setInterval(function() {
                        b(1);
                }, 5e3);
        }
        function i() {
                k && clearInterval(k);
        }
        var k = false, n = "", j = 500, f = 560, h = $("#actor li").length, l = h * 18, o = (f - (l + 26)) / 2, d = 0;
        $("#actor").width(f * h);
        $("#actor li").each(function() {
                n += "<span></span>";
        });
        $("#numInner").width(l).html(n);
        $("#imgPlay .mc").width(l);
        $("#imgPlay .num").css("left", o);
        $("#numInner").css("left", o + 13);
        $("#numInner span:first").addClass("on");
        $("#numInner span").click(function() {
                d = $(this).index();
                g(d);
                c($("#numInner span").eq(d), "on");
        });
        $("#imgPlay").hover(function() {
                i();
        }, function() {
                a();
        });
        a();
});
$(function() {
        function c(e, m) {
                e = $(e) ? $(e) :e;
                e.addClass(m).siblings().removeClass(m);
        }
        function b(e) {
                if ($("#xt_actor").is(":animated") == false) {
                        d += e;
                        if (d != -1 && d != h) $("#xt_actor").animate({
                                marginLeft:-d * ff + "px"
                        }, j); else if (d == -1) {
                                d = h - 1;
                                $("#xt_actor").css({
                                        marginLeft:-(ff * (d - 1)) + "px"
                                });
                                $("#xt_actor").animate({
                                        marginLeft:-(ff * d) + "px"
                                }, j);
                        } else if (d == h) {
                                d = 0;
                                $("#xt_actor").css({
                                        marginLeft:-ff + "px"
                                });
                                $("#xt_actor").animate({
                                        marginLeft:"0px"
                                }, j);
                        }
                        c($("#xt_numInner span").eq(d), "on");
                }
        }
        function g(e) {
                if ($("#xt_actor").css("marginLeft") != -e * ff + "px") {
                        $("#xt_actor").css("marginLeft", -e * ff + "px");
                        $("#xt_actor").fadeOut(0, function() {
                                $("#xt_actor").fadeIn(500);
                        });
                }
        }
        function a() {
                k = setInterval(function() {
                        b(1);
                }, 5e3);
        }
        function i() {
                k && clearInterval(k);
        }
        var k = false, n = "", j = 500, ff = 900, h = $("#xt_numInner span").length, l = h * 18, o = (ff - (l + 26)) / 2, d = 0;
        $("#xt_actor").width(ff * h);
        $("#xt_imgPlay .mc").width(l);
        $("#xt_imgPlay .num").css("left", o);
        $("#xt_numInner").css("left", o + 13);
        $("#xt_numInner span:first").addClass("on");
        $("#xt_imgPlay .xt_next").click(function() {
                b(1);
        });
        $("#xt_imgPlay .xt_prev").click(function() {
                b(-1);
        });
        $("#xt_numInner span").click(function() {
                d = $(this).index();
                g(d);
                c($("#xt_numInner span").eq(d), "on");
        });
        $("#xt_imgPlay").hover(function() {
                i();
        }, function() {
                a();
        });
        a();
});
$(function() {
        function c(e, m) {
                e = $(e) ? $(e) :e;
                e.addClass(m).siblings().removeClass(m);
        }
        function b(e) {
                if ($("#hdxt_actor").is(":animated") == false) {
                        d += e;
                        if (d != -1 && d != h) $("#hdxt_actor").animate({
                                marginLeft:-d * ff + "px"
                        }, j); else if (d == -1) {
                                d = h - 1;
                                $("#hdxt_actor").css({
                                        marginLeft:-(ff * (d - 1)) + "px"
                                });
                                $("#hdxt_actor").animate({
                                        marginLeft:-(ff * d) + "px"
                                }, j);
                        } else if (d == h) {
                                d = 0;
                                $("#hdxt_actor").css({
                                        marginLeft:-ff + "px"
                                });
                                $("#hdxt_actor").animate({
                                        marginLeft:"0px"
                                }, j);
                        }
                        c($("#hdxt_numInner span").eq(d), "on");
                }
        }
        function g(e) {
                if ($("#hdxt_actor").css("marginLeft") != -e * ff + "px") {
                        $("#hdxt_actor").css("marginLeft", -e * ff + "px");
                        $("#hdxt_actor").fadeOut(0, function() {
                                $("#hdxt_actor").fadeIn(500);
                        });
                }
        }
        function a() {
                k = setInterval(function() {
                        b(1);
                }, 5e3);
        }
        function i() {
                k && clearInterval(k);
        }
        var k = false, n = "", j = 500, ff = 900, h = $("#hdxt_numInner span").length, l = h * 18, o = (ff - (l + 26)) / 2, d = 0;
        $("#hdxt_actor").width(ff * h);
        $("#hdxt_imgPlay .mc").width(l);
        $("#hdxt_imgPlay .num").css("left", o);
        $("#hdxt_numInner").css("left", o + 13);
        $("#hdxt_numInner span:first").addClass("on");
        $("#hdxt_imgPlay .hdxt_next").click(function() {
                b(1);
        });
        $("#hdxt_imgPlay .hdxt_prev").click(function() {
                b(-1);
        });
        $("#hdxt_numInner span").click(function() {
                d = $(this).index();
                g(d);
                c($("#hdxt_numInner span").eq(d), "on");
        });
        $("#hdxt_imgPlay").hover(function() {
                i();
        }, function() {
                a();
        });
        a();
});
$(function() {
        lib.hover();
        lib.menu();
        lib.scroll({
                rightid:"div#lun_up",
                leftid:"div#lun_down",
                wndid:"div#lunhuan",
                contid:"div#news_lunCon",
                ftx:"dl",
                type:"top"
        });
        lib.tab({
                id:"#tabMenu",
                idpre:"#tabMenu_Content"
        });
        lib.submit({
                id:"#ycbtn",
                formid:"#ycplay"
        });
        lib.submit({
                id:"#hottopbtn",
                formid:"#hottop100"
        });
        lib.submit({
                id:"#newtopbtn",
                formid:"#newtop100"
        });
});