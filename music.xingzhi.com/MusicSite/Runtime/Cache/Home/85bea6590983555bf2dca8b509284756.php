<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="/image/x64.ico">
    <title>歌手列表</title>
    <script type="text/javascript" src="/js/jquery-1.11.1.min.js"></script>
    <!--bootstrap主体框架引用.-->
    <link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css" />
    <script type="text/javascript" src="/js/bootstrap.js"></script>
    <!--弹出层引用-->
    <link rel="stylesheet" type="text/css" href="/css/magnific-popup.css" />
    <script type="text/javascript" src="/js/jquery.magnific-popup.min.js"></script>
    <!--弹层插件-->
    <link rel="stylesheet" type="text/css" href="/layer/skin/layer.css" />
    <script type="text/javascript" src="/layer/layer.js"></script>
    <script type="text/javascript" src="/layer/extend/layer.ext.js"></script>

    <script type="text/javascript" src="/js/xingzhi.js"></script>
    <link rel="stylesheet" type="text/css" href="/css/commonv1.css" />
    <style type="text/css">
        #singler_list { line-height: 2.5rem; }
        #singler_list li { min-width: 20%; }
    </style>
    <style type="text/css">
        .singer_list_txt { margin-right: -20px; overflow: hidden; margin-bottom: 60px; margin-left: 24px; }
        .singer_list_txt__item { float: left; width: 20%; }
        .singer_list_txt__link { float: left; max-width: 90%; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; font-size: 14px; line-height: 36px; }
        a:hover { color: #31c27c; text-decoration: none; }
        #contlist ul { }
        .songalbum { float: left; width: 224px; margin-left: 25px; margin-top: 18px; }
        .songalbum .imgframe { width: 250px; height: 230px; }
        .songalbum .imgframe img { width: 224px; max-height: 230px; border-radius: 5px; }
    </style>
    <script src="/js/jquery.easing.min.js"></script>
</head>
<body>
    <div class="text-center top_header">音乐收藏站</div>

    <div style="padding: 1rem; margin-top: 5rem; padding-bottom: 6rem; overflow: hidden;">
        <ol class="breadcrumb">
            <li><a href="/">首页</a></li>
            <li class="active">专辑列表</li>
        </ol>
        <!--Search-->
        <ul class="list-inline">
            <li>
                <a href="/music/add_albumn/sid/<?php echo ($singerid); ?>"
                   class="popup-add btn btn-primary btn-sm" id="search_pro">新增专辑</a>
            </li>
            <li><a class="btn btn-primary btn-sm" href="/music/singerlist">歌手</a></li>
            <li><a class="btn btn-primary btn-sm" href="/music/album_lib">专辑列表</a></li>
            <li> <a class="btn btn-primary btn-sm" href="javascript:;" target="_blank" onclick="random_song()">随便听听(<?php echo ($song_total); ?>)</a> </li>
            <li>
                <div class="form-group form-inline">
                    <input type="text" class="form-control input-sm" id="search" placeholder="输入歌手/歌曲名称" />
                    <a href="javascript:;" class="btn btn-primary btn-sm" id="btnsearch">检索</a>
                </div>
                <script type="text/javascript">
                    $("#btnsearch").click(function () {
                        var key = $("#search").val();
                        window.open("/music/search_song?key=" + escape(key), "_top");
                    });
                    //限制只能打开一个播放页面
                    function random_song() {
                        another = open('/music/song', 'play');
                    }
                </script>
            </li>
        </ul>
        <div class="select_type">
            <strong>筛选：</strong> <a href="javascript:;" onclick="setYear(1)">一零年代</a>
            <a href="javascript:;" style="margin-left: 15px;" onclick="setYear(2)">零零年代</a>
            <a href="javascript:;" style="margin-left: 15px;" onclick="setYear(3)">九十年代</a>
            <a href="javascript:;" style="margin-left: 15px;" onclick="setYear(4)">八十年代</a>
            <a href="javascript:;" style="margin-left: 15px;" onclick="setYear(5)">七十年代</a>
            <input type="hidden" value="0" id="hidyear" name="hidyear" />
        </div>

        <div id="contlist"></div>
    </div>
    
    <!--<div class="picframe">
        <div class="parea" id="contlist">
            <ul class="singer_list_txt">
                <li class="singer_list_txt__item">
                    <a href="javascript:;"
                       class="singer_list_txt__link" title="暂无数据">暂无数据</a>
                </li>
            </ul>
        </div>
    </div>-->
    <div id="pageArea"></div>
    <input type="hidden" value="0" id="hidPage" />
    <script type="text/javascript">
        function setYear(val) {
            $("#hidyear").val(val);
            get_album(0, 20);
        }
        function get_album(vindex, vrows) {
            $.ajax("/apimusic/album_library", {
                data: { index: vindex, rows: vrows, year: $("#hidyear").val() },
                async: false,
                dataType: "jsonp",
                jsonp: "callback",
                crossDomain: true,
                success: function (json) {
                    $('#contlist').html("");
                    var shtml = '<ul class="list-inline">';
                    $.each(json.result, function (i, k) {
                        shtml += '<li class="songalbum">';
                        shtml += '<div class="imgframe">';
                        shtml += '<a href="/music/songlist?sid=' + k.singerid + '&aid=' + k.id + '"><img src="<?php echo ($IMGDOMAIN); ?>' + k.thumbnail + '" /></a>';
                        shtml += '</div>';
                        shtml += '<div>' + Xingzhi.paging.cut_str(k.albumname, 10) + '</div>';
                        if (k.issuetime == null) {
                            shtml += '<div>' + k.issueyear + '</div>';
                        } else {
                            shtml += '<div>' + k.issueyear + '</div>';
                        }
                        shtml += '</li>';
                    });
                    shtml += "<ul>";
                    $('#contlist').animate({ opacity: 1 }, {
                        step: function (n) {
                            //rotating the images on the Y axis from 360deg to 0deg
                            ry = (1 - n) * 360;
                            //translating the images from 1000px to 0px
                            tz = (1 - n) * 1000;
                            //applying the transformation
                            $(this).css("transform", "rotateY(" + ry + "deg) translateZ(" + tz + "px)");
                        },
                        duration: 1000,
                        //some easing fun. Comes from the jquery easing plugin.
                        easing: 'easeOutQuart',
                    }).html(shtml);
                    Xingzhi.paging.show_page(json.total, vindex, vrows, '#pageArea', '');
                    $("#hidPage").val(vindex);
                },
                error: function (e) {
                    console.log('Error...' + e.message);
                }
            });
        }
        $(document).ready(function () {
            get_album(0, 20);
        });

    </script>
    <div class="text-center bottom_foot">
        <ul class="list-inline">
            <li><a class="color_while" target="_blank" href="<?php echo ($ipadd); ?>:9004/">火车票</a></li>
            <li> <a class="color_while" target="_blank" href="<?php echo ($ipadd); ?>:9006/weibo">微博会员</a> </li>
            <li> <a class="color_while" target="_blank" href="<?php echo ($ipadd); ?>:9003/music">音乐</a> </li>
            <li><a class="color_while" target="_blank" href="<?php echo ($ipadd); ?>:9009/">街拍</a></li>
            <li><a class="color_while" target="_blank" href="<?php echo ($ipadd); ?>:9007/">腾讯会员</a></li>
            <li><a class="color_while" target="_blank" href="<?php echo ($ipadd); ?>/">相册</a></li>
            <li><a class="color_while" target="_blank" href="<?php echo ($ipadd); ?>:9010/">书籍</a></li>
            <li><a class="color_while" target="_blank" href="<?php echo ($ipadd); ?>:9600/">影片</a></li>
        </ul>
    </div>
</body>
</html>