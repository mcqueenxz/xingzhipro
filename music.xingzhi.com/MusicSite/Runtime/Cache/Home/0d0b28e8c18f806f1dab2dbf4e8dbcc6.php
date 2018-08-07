<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<meta name="viewport" content="width=device-width" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>音乐站点</title>
	<link rel="Shortcut Icon" href="/image/x64.ico" type="image/x-icon" />
    <link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="/css/common.css" />
    <link rel="stylesheet" type="text/css" href="/css/jquery.toastmessage.css" />
    <link rel="stylesheet" type="text/css" href="/css/magnific-popup.css" />
    <link rel="stylesheet" type="text/css" href="/css/uploadify.css" />
    <style type="text/css">
        /**标题文字数据展示框架*/
        .picframe .parea .tit-list { float: left; width: 220px; border: solid 2px #FFF;  margin-left: 32px; margin-top: 25px; background: #FFF; border-radius: 5px; overflow: hidden; }
        .picframe .parea .tit-list:hover{ border: solid 2px #bc0000; }
        .picframe .parea .tit-list .tit-info { line-height: 23px; }
        .picframe .parea .tit-list .tit-info li { height: 25px; padding-left: 5px; }
        /**火车票备选站样式**/
        .ticketSty, .ticketStyEnd, .traintype{ text-indent:1px;}
        .ticketSty a, .ticketStyEnd a,.traintype a{color:#989a9a; text-decoration:none; margin-left:5px;}
        .ticketSty a:hover, .ticketStyEnd a:hover,.traintype a:hover{color:#aa0202}
        .sstation{color:#d2550c}
        .estation{color:#347516}
    </style>
    <script type="text/javascript" src="/js/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="/js/jquery.toastmessage.js"></script>
    <script type="text/javascript" src="/js/xingzhi.js"></script>
    <!--弹出层框架.引用-->
    <script type="text/javascript" src="/layer/layer.js"></script>
    <script type="text/javascript" src="/layer/extend/layer.ext.js"></script>
    <!--<script type="text/javascript" src="/My97DatePicker/WdatePicker.js"></script>-->
    <script type="text/javascript" src="/js/jquery.magnific-popup.min.js"></script>
    <script type="text/javascript" src="/js/jquery.uploadify.min.js" ></script>
<style type="text/css">
    .singer_list_txt { margin-right: -20px; overflow: hidden; margin-bottom: 60px; margin-left: 24px; }
    .singer_list_txt__item { float: left; width: 20%; }
    .singer_list_txt__link { float: left; max-width: 90%; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; font-size: 14px; line-height: 36px; }
    a:hover {color: #31c27c;text-decoration: none;}
</style>
</head>
<body>
<div class="nav">
    <div class="lst">
        <a href="javascript:;" class="core">音乐站点</a>
    </div>
</div>

<div class="small_nav">
    <a href="/">首页</a> &gt; 歌手列表
</div>
<div class="select_type">
    <a href="/music/addsinger" class="popup-add" id="search_pro">新增歌手</a> | 
    <a href="/music/singerlist">歌手</a> | 
<a href="/music/album_lib">专辑列表</a> | 
<a href="javascript:;" target="_blank" onclick="random_song()">随便听听(<?php echo ($song_total); ?>)</a> |
<input type="text" id="search" placeholder="输入歌手/歌曲名称" /> <a href="javascript:;" id="btnsearch">检索</a>

<script type="text/javascript">
    $("#btnsearch").click(function(){
        var key = $("#search").val();
        window.open("/music/search_song?key=" + escape(key), "_top");
    });
    //限制只能打开一个播放页面
    function random_song() {
        another = open('/music/song', 'play');
    }
</script>
</div>
<div class="picframe">
    <div class="parea" id="contlist">
        <ul class="singer_list_txt">
            <li class="singer_list_txt__item"><a href="javascript:;" class="singer_list_txt__link" title="暂无数据">暂无数据</a></li>
        </ul>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        //加载初始化图片列表、添加页面
        Xingzhi.initmagnificPopup.iframeLoad('.popup-gallery');
        Xingzhi.initmagnificPopup.iframeLoad('.popup-add');
        //获取图片列表.
        function get_singer(vindex, vrows) {
            $.ajax("/apimusic/get_singer_list", {
                data: {index: vindex, rows: vrows},
                async: false,
                dataType: "jsonp",
                jsonp: "callback",
                crossDomain: true,
                success: function (json) {
                    $('.singer_list_txt').html("");
                    var shtml = "";
                    $.each(json.result, function (i, k) {
                        shtml += '<li class="singer_list_txt__item"><a href="/music/albumn_list/sid/' + k.id + '" class="singer_list_txt__link" title="' + k.singername + '">' +k.firstletter+' '+ k.singername + ' ('+k.total+')' + '</a><a class="singer_list_txt__link">['+k.region+']</a></li>';
                    });
                    $('.singer_list_txt').html(shtml);
                },
                error: function (e) {
                    console.log('Error...' + e.message);
                }
            });
        }
        get_singer();
    });
</script>
<!--     页面底部 -->
<div class="foots">
    <div style="margin-top:10px;">
    	邢智个人数据系统
    	<a style="color:#428bca"  href="/users/register">注册</a>
    	<a style="color:#428bca"  href="/users/login">登录</a>
    </div>
    <div style="margin-top:10px;">&copy;2007 - 2017 </div>
    <div style="margin-top:10px;">
        <a style="color:#428bca" target="_blank" href="http://127.0.0.1:9004/">火车票</a>
        <a style="color:#428bca" target="_blank" href="http://127.0.0.1:9006/weibo">微博会员</a>
        <a style="color:#428bca" target="_blank" href="javascript:;">淘女郎</a>
        <a style="color:#428bca" target="_blank" href="http://127.0.0.1:9007/">腾讯会员</a>
        <a style="color:#428bca" target="_blank" href="http://127.0.0.1:9003/music">音乐</a>
        <a style="color:#428bca" target="_blank" href="http://127.0.0.1:9009/">街拍</a>
        <a style="color:#428bca" target="_blank" href="http://127.0.0.1:9010/">书籍</a>
        <a style="color:#428bca" target="_blank" href="http://myphto.xingzhi.com/">相册</a>
    </div>
</div>

</body>
</html>