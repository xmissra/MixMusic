(function(window, undefined) {
        var getContext = function() {
                return document.createElement("canvas").getContext("2d");
        };
        var getImageData = function(img, loaded) {
                var imgObj = new Image();
                var imgSrc = img.src || img;
                if (imgSrc.substring(0, 5) !== "data:") {
                        imgObj.crossOrigin = "Anonymous";
                }
                imgObj.onload = function() {
                        var context = getContext();
                        context.drawImage(imgObj, 0, 0);
                        var imageData = context.getImageData(0, 0, imgObj.width, imgObj.height);
                        loaded && loaded(imageData.data);
                };
                imgObj.src = imgSrc;
        };
        var makeRGB = function(name) {
                return [ "rgb(", name, ")" ].join("");
        };
        var mapPalette = function(palette) {
                return palette.map(function(c) {
                        return makeRGB(c.name);
                });
        };
        var BLOCKSIZE = 5;
        var PALETTESIZE = 10;
        var RGBaster = {};
        RGBaster.colors = function(img, opts) {
                opts = opts || {};
                var exclude = opts.exclude || [], paletteSize = opts.paletteSize || PALETTESIZE;
                getImageData(img, function(data) {
                        var length = img.width * img.height || data.length, colorCounts = {}, rgbString = "", rgb = [], colors = {
                                dominant:{
                                        name:"",
                                        count:0
                                },
                                palette:Array.apply(null, new Array(paletteSize)).map(Boolean).map(function(a) {
                                        return {
                                                name:"0,0,0",
                                                count:0
                                        };
                                })
                        };
                        var i = 0;
                        while (i < length) {
                                rgb[0] = data[i];
                                rgb[1] = data[i + 1];
                                rgb[2] = data[i + 2];
                                rgbString = rgb.join(",");
                                if (rgb.indexOf(undefined) !== -1) {
                                        i += BLOCKSIZE * 4;
                                        continue;
                                }
                                if (rgbString in colorCounts) {
                                        colorCounts[rgbString] = colorCounts[rgbString] + 1;
                                } else {
                                        colorCounts[rgbString] = 1;
                                }
                                if (exclude.indexOf(makeRGB(rgbString)) === -1) {
                                        var colorCount = colorCounts[rgbString];
                                        if (colorCount > colors.dominant.count) {
                                                colors.dominant.name = rgbString;
                                                colors.dominant.count = colorCount;
                                        } else {
                                                colors.palette.some(function(c) {
                                                        if (colorCount > c.count) {
                                                                c.name = rgbString;
                                                                c.count = colorCount;
                                                                return true;
                                                        }
                                                });
                                        }
                                }
                                i += BLOCKSIZE * 4;
                        }
                        if (opts.success) {
                                var palette = mapPalette(colors.palette);
                                opts.success({
                                        dominant:makeRGB(colors.dominant.name),
                                        secondary:palette[0],
                                        palette:palette
                                });
                        }
                });
        };
        window.RGBaster = window.RGBaster || RGBaster;
})(window);