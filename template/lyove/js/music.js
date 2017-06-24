$(function() {
        lib.toggle({
                id:"#toggleItems",
                lid:"#toggleItemsCon",
                cid:"#toggleItemsCon > div"
        });
        lib.toggle({
                id:"#toggleItems1",
                lid:"#toggleItemsCon1",
                cid:"#toggleItemsCon1 > div"
        });
        lib.hover({
                id:".lt_music_list li"
        });
        lib.tab({
                id:"#tabMenu",
                idpre:"#tabMenu_Content"
        });
});