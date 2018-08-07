<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE html>
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
</head>
<body>
    <div class="text-center top_header">音乐收藏站</div>
    <div style="padding: 1rem; margin-top: 5rem; padding-bottom: 5rem;">
        <ol class="breadcrumb">
            <li><a href="/">首页</a></li>
            <li class="active">歌手列表</li>
        </ol>
        <ul class="list-inline">
            <li>
                <a href="/music/addsinger" class="popup-add btn btn-primary btn-sm" id="search_pro">新增歌手</a>
            </li>
            <li><a class="btn btn-primary btn-sm" href="/music/singerlist">歌手</a></li>
            <li><a class="btn btn-primary btn-sm" href="/music/album_lib">专辑列表</a></li>
            <li>
                <a class="btn btn-primary btn-sm" href="javascript:;" target="_blank" onclick="random_song()">随便听听(<?php echo ($song_total); ?>)</a>
            </li>
            <li>
                <div class="form-group form-inline">
                    <input type="text" class="form-control input-sm" id="search" placeholder="输入歌手/歌曲名称" /> 
                    <a href="javascript:;" class="btn btn-primary btn-sm" id="btnsearch">检索</a>
                </div>
            </li>
        </ul>

        <div>
            <ul id="singler_list" class="list-inline">
                <li class="singer_list_txt_item">
                    <a href="javascript:;" class="singer_list_txt_link" title="暂无数据">暂无数据</a>
                </li>
            </ul>
        </div>

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

        $(document).ready(function () {
            //加载初始化图片列表、添加页面
            Xingzhi.initmagnificPopup.iframeLoad('.popup-gallery');
            Xingzhi.initmagnificPopup.iframeLoad('.popup-add');
            //获取图片列表.
            function get_singer(vindex, vrows) {
                $.ajax("/api/getsingerlist", {
                    data: { index: vindex, rows: vrows },
                    async: false,
                    dataType: "jsonp",
                    jsonp: "callback",
                    crossDomain: true,
                    success: function (json) {
                        console.log(json);
                        $('#singler_list').html("");
                        var shtml = "";
                        $.each(json.result, function (i, k) {
                            shtml += '<li class="singer_list_txt__item"><a href="/music/albumn_list/sid/' + k.id + '" class="singer_list_txt__link" title="' + k.singername + '">' + k.firstletter + ' ' + k.singername + ' (' + k.total + ')' + '</a><a class="singer_list_txt__link">[' + k.region + ']</a></li>';
                        });
                        $('#singler_list').html(shtml);
                    },
                    error: function (e) {
                        console.log('Error...' + e.message);
                    }
                });
            }
            get_singer();
        });

    </script>
    <div class="text-center bottom_foot">
        <ul class="list-inline">
            <li><a class="color_while" target="_blank" href="<?php echo ($ipadd); ?>:9004/">火车票</a></li>
            <li>
                <a class="color_while" target="_blank"
                   href="<?php echo ($ipadd); ?>:9006/weibo">微博会员</a>
            </li>
            <li>
                <a class="color_while" target="_blank"
                   href="<?php echo ($ipadd); ?>:9003/music">音乐</a>
            </li>
            <li><a class="color_while" target="_blank" href="<?php echo ($ipadd); ?>:9009/">街拍</a></li>
            <li><a class="color_while" target="_blank" href="<?php echo ($ipadd); ?>:9007/">腾讯会员</a></li>
            <li><a class="color_while" target="_blank" href="<?php echo ($ipadd); ?>/">相册</a></li>
            <li><a class="color_while" target="_blank" href="<?php echo ($ipadd); ?>:9010/">书籍</a></li>
            <li><a class="color_while" target="_blank" href="<?php echo ($ipadd); ?>:9600/">影片</a></li>
        </ul>
    </div>
</body>
</html>