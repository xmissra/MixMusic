window.onload = function() {
        var oIco = document.getElementById("ico");
        var aBtn = oIco.getElementsByTagName("a");
        var oSlide = document.getElementById("slide");
        var oUl = oSlide.getElementsByTagName("ul");
        var aLi = oUl[0].getElementsByTagName("li");
        var oBtnLeft = document.getElementById("btnLeft");
        var oBtnRight = document.getElementById("btnRight");
        var iNow = 0;
        for (var i = 0; i < aBtn.length; i++) {
                aBtn[i].index = i;
                aBtn[i].onmouseover = function() {
                        move(this.index);
                };
        }
        oBtnRight.onclick = function() {
                iNow++;
                move(iNow);
        };
        oBtnLeft.onclick = function() {
                iNow--;
                move(iNow);
        };
        var curIndex = 0;
        var timeInterval = 3e3;
        setInterval(change, timeInterval);
        function change() {
                if (curIndex == aBtn.length) {
                        curIndex = 0;
                } else {
                        move(curIndex);
                        curIndex += 1;
                }
        }
        function move(index) {
                if (index > aLi.length - 2) {
                        index = 0;
                        iNow = index;
                }
                if (index < 0) {
                        index = aLi.length - 2;
                        iNow = index;
                }
                for (var n = 0; n < aBtn.length; n++) {
                        aBtn[n].className = "";
                }
                aBtn[index].className = "current";
                var _src = aLi[index].getElementsByTagName("img")[0].src;
                var _title = aLi[index].getElementsByTagName("img")[0].title;
                var _onclick = aLi[index].getElementsByTagName("img")[0].onclick;
                aLi[aLi.length - 1].getElementsByTagName("img")[0].src = _src;
                aLi[aLi.length - 1].getElementsByTagName("img")[0].title = _title;
                aLi[aLi.length - 1].getElementsByTagName("img")[0].onclick = _onclick;
        }
};