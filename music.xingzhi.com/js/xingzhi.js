var Xingzhi = new Object();
Xingzhi.MsgType = {
    TopRight: "top-right",
    TopCenter: "top-center",
    MiddleCenter: "middle-center",
    MiddleRight: "middle-right",
    Notice: "notice",
    Warning: "warning",
    Error: "error",
    Success: "success"
}

Xingzhi.showMsg = function (str, type, time, w) {
    $().toastmessage('showToast', {
        text: str,
        sticky: false,
        position: Xingzhi.MsgType.MiddleCenter, // 'middle-right',
        type: type,
        stayTime: time,
        closeText: '',
        width: w,
        close: function () {
            console.log("toast is closed ...");
        }
    });
}

Xingzhi.gloable = {
    inital: function () {
        $(window).scroll(function () {
            var scroll = $(window).scrollTop();
            $(".nav").css("top", scroll + "px");
            if (scroll > 40) {
                $(".nav").css("opacity", "0.9");
            } else {
                $(".nav").css("opacity", "1");
            }
            if (scroll > 50) {
                $(".goup").css("right", "11.5px");
                $(".goup").css("-webkit-transform", "10deg");
                $(".goup").css("-moz-transform", "10deg");
            } else {
                $(".goup").css("right", "-300px");
            }
        });
    }
}

Xingzhi.myphoto = {
    inital: function () {
        var ph = $(window).height();
        $(".opear_layer").css("min-height", (ph * 0.7) + "px");
    }
}
//初始化加载页面控件.
Xingzhi.initmagnificPopup = {
    iframeLoad: function (styleName) {
        $(styleName).magnificPopup({
            disableOn: 700,
            type: 'iframe',
            mainClass: 'mfp-fade',
            removalDelay: 160,
            preloader: false,
            fixedContentPos: false
        });
    },
    imageLoad: function (styleName) {
        //加载列表
        $(styleName).magnificPopup({
            delegate: '.pic-list .pic-show a',
            type: 'image',
            tLoading: '...图片加载中...',
            mainClass: 'mfp-img-mobile',
            gallery: {
                enabled: true,
                navigateByImgClick: true,
                preload: [0, 1] // Will preload 0 - before current, and 1 after the current image
            },
            image: {
                tError: '<a href="%url%">The image #%curr%</a> could not be loaded.',
                titleSrc: function (item) {
                    return item.el.attr('title') + ' - <a href="' + item.el.attr('href') + '" target="_blank" style="color:#FFF">查看原图</a>';
                }
            }
        });
    }
}

Xingzhi.paging = {
    /*
     * total	总行数
     * index	索引页
     * rows		显示行
     * vdate	日期参数
     * obj1		数据绑定控件id
     */
    show_page: function (total, index, rows, obj1, funname) {
        if(funname === '' || funname === null){
            funname = "get_album";
        }
        var page = 0;
        if (total % rows === 0)
            page = parseInt(total / rows);
        else
            page = parseInt(total / rows) + 1;

        var htmls = "<div class=\"current-page\">";
        htmls += "<div class=\"page-frame\">";
        if (index <= 0) {
            htmls += "<a class=\"page-area first-page\" href=\"javascript:;\">首页</a>";
            htmls += "<a class=\"page-area prive-page\" href=\"javascript:;\">上一页</a>";
        } else {
            htmls += "<a class=\"page-area first-page\" href=\"javascript:;\" onclick=\""+funname+"(0, " + rows + ")\">首页</a>";
            htmls += "<a class=\"page-area prive-page\" href=\"javascript:;\" onclick=\""+funname+"(" + (index - 1) + ", " + rows + ")\">上一页</a>";
        }
        htmls += "<a class=\"page-area pagenow\"> " + (index + 1) + " / " + page + " 页</a>";
        if ((index + 1) < page) {
            htmls += "<a class=\"page-area next-page\" href=\"javascript:;\" onclick=\""+funname+"(" + (index + 1) + ", " + rows + ")\">下一页</a>";
            htmls += "<a class=\"page-area last-page\" href=\"javascript:;\" onclick=\""+funname+"(" + (page - 1) + ", " + rows + ")\">尾页</a>";
        } else {
            htmls += "<a class=\"page-area next-page\" href=\"javascript:;\">下一页</a>";
            htmls += "<a class=\"page-area last-page\" href=\"javascript:;\">尾页</a>";
        }
        htmls += "<a class=\"page-area page-data\">共有  " + total + " 条数据</a>";
        htmls += "</div></div>";
        $(obj1).html(htmls);
    },
    //初始化加载数据.
    initPagingForWindow: function (index) {
        //var docWidth = $(window).width();
        getPhotoList(index, 12);
    },
    //计算图片大小. 
    countSize: function (bt) {
        var size = 0;
        if (bt < 1024) {
            return size + " BT";
        } else {
            size = bt / 1024;
            if (size < 1024) {
                return size.toFixed(2) + " KB";
            } else {
                size = size / 1024;
                return size.toFixed(2) + " MB";
            }
        }
    },
    /**
     * 截取时间字符串
     * val	日期值
     * op	操作模式.1.截取.0.不截取
     */
    split_time_str: function (val, op) {
        if (val == '')
            return val;
        if (op == 1)
            return val.substr(0, 10);
        else
            return val;
    },
    /**
     * 截取字符串
     */
    cut_str: function (str, max) {
        if (str.length > max) {
            return str.substring(0, max) + " ... ";
        } else {
            return str;
        }
    }
}