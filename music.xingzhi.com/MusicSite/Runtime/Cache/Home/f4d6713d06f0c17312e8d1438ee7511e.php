<?php if (!defined('THINK_PATH')) exit();?>﻿
<!DOCTYPE html>
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
</head>
<body>
    <div class="text-center top_header">音乐收藏站</div>

    <div style="padding: 1rem; margin-top: 5rem; padding-bottom: 6rem; overflow: hidden;">
        <ol class="breadcrumb">
            <li><a href="/">首页</a></li>
            <li><a href="/music/singerlist">歌手列表</a> </li>
            <li class="active"><?php echo ($singername); ?>专辑列表</li>
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
        <div id="contlist"></div>
    </div>

    <script type="text/javascript">
        $(document).ready(function () {

            Xingzhi.initmagnificPopup.iframeLoad('.popup-gallery');
            Xingzhi.initmagnificPopup.iframeLoad('.popup-add');
            //获取歌手专辑列表
            function get_album(vindex, vrows) {
                $.ajax("/api/getalbumlist", {
                    data: { index: vindex, rows: vrows, singerId: "<?php echo ($singerid); ?>" },
                    async: false,
                    dataType: "jsonp",
                    jsonp: "callback",
                    crossDomain: true,
                    success: function (json) {
                        $('#contlist').html("");
                        var shtml = "<ul class=\"list-inline\">";
                        //alert(json.result);
                        $.each(json.result, function (i, k) {
                            shtml += '<li class="songalbum">';
                            shtml += '<div class="imgframe">';
                            shtml += '<a href="/music/songlist?sid=' + k.singerid + '&aid=' + k.id + '"><img src="<?php echo ($IMGDOMAIN); ?>' + k.thumbnail + '" /></a>';
                            shtml += '</div>';
                            shtml += '<div>' + k.albumname + '</div>';
                            shtml += '<div>' + k.issueyear + '</div>';
                            shtml += '</li>';
                        });
                        shtml += "<ul>";
                        $('#contlist').html(shtml);
                    },
                    error: function (e) {
                        console.log('Error...' + e.message);
                    }
                });
            }
            get_album(0, 10000);
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