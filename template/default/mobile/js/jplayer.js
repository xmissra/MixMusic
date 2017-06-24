$(document).ready(function() {
        var player = $("#player"), add = $("#player-wrapper #volumeAdd"), remove = $("#player-wrapper #volumeRemove"), next = $("#player-wrapper #forwardPlay"), previous = $("#player-wrapper #backwardPlay"), name = $("#player-wrapper #songName"), volume = $("#player-wrapper #volume"), xy = $(".xy"), links = $(".song_list__link"), order = $("#player-wrapper #orderPlay"), repeat = $("#player-wrapper #repeatPlay");
        var song = 0;
        var counts = 0;
        var status = 0;
        var stream = {
                mp3:""
        };
        var songs = new Array();
        var ids = "";
        var tags = document.getElementsByTagName("big");
        for (var i = 0; i < tags.length; i++) {
                ids += tags[i].innerHTML + ",";
        }
        ids = ids + "]";
        ids = ids.replace(/,\]/g, "");
        ids = ids.replace(/\]/g, 0);
        $.ajax({
                url:temp_url + "source/json.php?type=jplayer&ids=" + ids,
                type:"GET",
                async:false,
                dataType:"json",
                beforeSend:function() {},
                success:function(json) {
                        $.each(json, function(index, value) {
                                var song = new Array();
                                song["name"] = value.song_name;
                                song["path"] = value.song_path;
                                songs[index] = song;
                                counts = index;
                        });
                },
                complete:function() {}
        });
        which();
        player.jPlayer({
                ready:function() {
                        $(this).jPlayer("setMedia", stream).jPlayer("play");
                },
                play:function() {
                        name.html(songs[song]["name"]);
                        var NO = 0;
                        xy.each(function() {
                                $(this).prev().prev().hide();
                                $(this).prev().show();
                                if (NO == song) {
                                        $(this).prev().prev().attr("src", temp_url + "css/playing.gif");
                                        $(this).prev().prev().show();
                                        $(this).prev().hide();
                                }
                                NO++;
                        });
                },
                pause:function() {
                        var NO = 0;
                        xy.each(function() {
                                if (NO == song) {
                                        $(this).prev().prev().attr("src", temp_url + "css/pause.gif");
                                }
                                NO++;
                        });
                },
                volumechange:function(event) {
                        volume.text(event.jPlayer.options.volume);
                },
                ended:function() {
                        if (status == 1) {
                                player.jPlayer("setMedia", stream).jPlayer("play");
                        } else {
                                next.click();
                        }
                },
                swfPath:"dist/jplayer",
                supplied:"mp3",
                cssSelectorAncestor:"#player-wrapper"
        });
        function which() {
                stream = {
                        mp3:songs[song]["path"]
                };
                player.jPlayer("setMedia", stream).jPlayer("play");
        }
        links.click(function() {
                song = $(this).data("key") - 1;
                which();
                return false;
        });
        next.click(function() {
                song++;
                if (song > counts) {
                        song = 0;
                }
                which();
                return false;
        });
        previous.click(function() {
                song--;
                if (song < 0) {
                        song = counts;
                }
                which();
                return false;
        });
        add.click(function(event) {
                var vol = parseFloat(volume.text()) * 10;
                if (vol < 10) {
                        player.jPlayer("volume", (vol + 1) / 10);
                }
                return false;
        });
        remove.click(function(event) {
                var vol = parseFloat(volume.text()) * 10;
                if (vol > 0) {
                        player.jPlayer("volume", (vol - 1) / 10);
                }
                return false;
        });
        repeat.click(function(event) {
                $(this).addClass("hide");
                order.removeClass("hide");
                status = 0;
        });
        order.click(function(event) {
                $(this).addClass("hide");
                repeat.removeClass("hide");
                status = 1;
        });
});