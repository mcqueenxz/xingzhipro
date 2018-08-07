<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <meta name="viewport" content="width=device-width" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>音乐站点</title>
    <link rel="Shortcut Icon" href="/image/x64.ico" type="image/x-icon" />
    <link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="/css/common.css" />
    <link rel="stylesheet" type="text/css"
          href="/css/jquery.toastmessage.css" />
    <link rel="stylesheet" type="text/css" href="/css/magnific-popup.css" />
    <link rel="stylesheet" type="text/css" href="/css/uploadify.css" />
    <style type="text/css">
        /**标题文字数据展示框架*/
        .picframe .parea .tit-list { float: left; width: 220px; border: solid 2px #FFF; margin-left: 32px; margin-top: 25px; background: #FFF; border-radius: 5px; overflow: hidden; }

        .picframe .parea .tit-list:hover { border: solid 2px #bc0000; }

        .picframe .parea .tit-list .tit-info { line-height: 23px; }

        .picframe .parea .tit-list .tit-info li { height: 25px; padding-left: 5px; }
        /**火车票备选站样式**/
        .ticketSty, .ticketStyEnd, .traintype { text-indent: 1px; }

        .ticketSty a, .ticketStyEnd a, .traintype a { color: #989a9a; text-decoration: none; margin-left: 5px; }

        .ticketSty a:hover, .ticketStyEnd a:hover, .traintype a:hover { color: #aa0202; }

        .sstation { color: #d2550c; }

        .estation { color: #347516; }
    </style>
    <script type="text/javascript" src="/js/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="/js/jquery.toastmessage.js"></script>
    <script type="text/javascript" src="/js/xingzhi.js"></script>
    <!--弹出层框架.引用-->
    <script type="text/javascript" src="/layer/layer.js"></script>
    <script type="text/javascript" src="/layer/extend/layer.ext.js"></script>
    <!--<script type="text/javascript" src="/My97DatePicker/WdatePicker.js"></script>-->
    <script type="text/javascript" src="/js/jquery.magnific-popup.min.js"></script>
    <script type="text/javascript" src="/js/jquery.uploadify.min.js"></script>

<style type="text/css">
.songfram {
	width: 1300px;
	margin: 0 auto;
}

.songfram .tit {
	overflow: hidden;
	line-height: 35px;
	font-weight: bold;
}

.songfram .list {
	overflow: hidden;
	line-height: 35px;
}

.songfram .f1 {
	float: left;
	width: 225px;
}

.songfram .f2 {
	float: left;
	width: 500px;
}
</style>
</head>
<body>
	<div class="nav">
	<div class="lst">
		<a href="javascript:;" class="core">音乐站点</a>
	</div>
</div>
	<div class="small_nav">
		<a href="/">首页</a> &gt; 检索
	</div>
	<div class="select_type">
		<a href="/music/singerlist">歌手</a>
|
<a href="/music/album_lib">专辑列表</a>
|
<a href="javascript:;" target="_blank" onclick="random_song()">随便听听(<?php echo ($song_total); ?>)</a>
|
<input type="text" id="search" placeholder="输入歌手/歌曲名称" />
<a href="javascript:;" id="btnsearch">检索</a>

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
			<div class="songfram">
				<ul class="tit">
					<li class="f2">歌曲</li>
					<li class="f1">歌手</li>
					<li class="f1">专辑</li>
					<li class="f1">&nbsp;</li>
				</ul>
				<ul class="list" id="songlist"></ul>
			</div>
		</div>
	</div>
	<div id="pageArea"></div>
	<input type="hidden" value="0" id="hidPage" />
	<script type="text/javascript">
    //限制只能打开一个播放页面
    function open_song(songid) {
        another = open('/music/song?sid=' + songid, 'play');
    }
    function get_song(vindex, vrows) {
        var keys = unescape("<?php echo ($key); ?>");
        $("#search").val(keys);
        $.ajax("/apimusic/search_song", {
            data: {index: vindex, rows: vrows, key: keys},
            async: false,
            dataType: "jsonp",
            jsonp: "callback",
            crossDomain: true,
            success: function (json) {
                $('#songlist').html("");
                var shtml = "";
                $.each(json.result, function (i, k) {
                    var isplay = false;
                    if (k.filetype === 'mp3' || k.filetype === 'm4a') {
                        isplay = true;
                    }
                    if (isplay) {
                        if (k.notes === null || k.notes === '') {
                            shtml += '<li class="f2"><a href="javascript:;" onclick="open_song(' + k.id + ')"><span title="' + k.songname + '">' + k.songname + '&nbsp;</span></a> <span style="color:#AFADA3">(' + k.listentime + ')</span></li>';
                        } else {
                            shtml += '<li class="f2"><a href="javascript:;" onclick="open_song(' + k.id + ')"><span title="' + k.songname + '">' + k.songname + '&nbsp;</span></a> <span style="color:#AFADA3"> (' + k.listentime + ') | (' + k.notes + ')</span></li>';
                        }
                    } else {
                        shtml += '<li class="f2">' + k.songname + '&nbsp;</span></li>';
                    }

                    if (k.feat === '' || k.feat === null)
                        shtml += '<li class="f1"><a href="/music/albumn_list?sid=' + k.singerid + '" style="color:#31c27c">' + k.singername + '</a>&nbsp;</li>';
                    else
                        shtml += '<li class="f1"><a href="/music/albumn_list?sid=' + k.singerid + '" style="color:#31c27c">' + k.singername + '</a>/' + k.feat + '&nbsp;</li>';

                    shtml += '<li class="f1"><a href="/music/songlist?sid=' + k.singerid + '&aid=' + k.albumnid + '" title="' + k.albumname + '">' + k.albumname + '&nbsp;</a></li>';
                    //shtml += '<li class="f1"><span title="' + k.byword + '">' + Xingzhi.paging.cut_str(k.byword, 10) + '&nbsp;</span></li>';
                    //if (isplay) {
                    //    shtml += '<li class="f1"> <a href="/music/editsong?songid=' + k.id + '" class="popup-edit">编辑</a> | <a href="javascript:;" onclick="open_song(' + k.id + ')">去听</a> | <a href="javascript:;">删除</a> </li>';
                    //} else {
                    //    shtml += '<li class="f1"> <a href="/music/editsong?songid=' + k.id + '" class="popup-edit">编辑</a></li>';
                    //}
                });
                //alert(json.total);
                $('#songlist').html(shtml);

                Xingzhi.paging.show_page(json.total, vindex, vrows, '#pageArea', 'get_song');
                $("#hidPage").val(vindex);

                //Xingzhi.initmagnificPopup.iframeLoad('.popup-edit');

            },
            error: function (e) {
                console.log('Error...' + e.message);
            }
        });
    }
    $(function () {
        get_song(0, 20);
    });

</script>

	<!--     页面底部 -->
<div class="foots">
	<div style="margin-top: 10px;">
		邢智个人数据系统 <a style="color: #428bca" href="/users/register">注册</a> <a
			style="color: #428bca" href="/users/login">登录</a>
	</div>
	<div style="margin-top: 10px;">&copy;2007 - 2017</div>
	<div style="margin-top: 10px;">
		<a style="color: #428bca" target="_blank"
			href="http://127.0.0.1:9004/">火车票</a> <a style="color: #428bca"
			target="_blank" href="http://127.0.0.1:9006/weibo">微博会员</a> <a
			style="color: #428bca" target="_blank" href="javascript:;">淘女郎</a> <a
			style="color: #428bca" target="_blank" href="http://127.0.0.1:9007/">腾讯会员</a>
		<a style="color: #428bca" target="_blank"
			href="http://127.0.0.1:9003/music">音乐</a> <a style="color: #428bca"
			target="_blank" href="http://127.0.0.1:9009/">街拍</a> <a
			style="color: #428bca" target="_blank" href="http://127.0.0.1:9010/">书籍</a>
		<a style="color: #428bca" target="_blank"
			href="http://myphto.xingzhi.com/">相册</a>
	</div>
</div>

</body>
</html>