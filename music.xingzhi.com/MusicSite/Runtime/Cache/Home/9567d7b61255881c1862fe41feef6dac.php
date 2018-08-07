<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="shortcut icon" href="/image/x64.ico">
<title>音乐收藏站点</title>
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
<link rel="stylesheet" type="text/css" href="css/commonv1.css" />
</head>
<body>

	<div class="text-center top_header">音乐收藏站</div>
	<div style="padding: 1rem; margin-top: 5rem; padding-bottom: 5rem;">
		<ol class="breadcrumb">
			<li class="active">首页</li>
		</ol>

		<ul class="list-inline">
			<li><a class="btn btn-primary btn-sm" href="/music/singerlist">歌手</a></li>
			<li><a class="btn btn-primary btn-sm" href="/music/album_lib">专辑列表</a></li>
			<li><a class="btn btn-primary btn-sm" href="javascript:;"
				target="_blank" onclick="random_song()">随便听听(<?php echo ($song_total); ?>)</a></li>
			<!--<li>|</li>-->
			<li>
				<div class="form-group form-inline">
					<input type="text" class="form-control input-sm" id="search"
						placeholder="输入歌手/歌曲名称" /> <a href="javascript:;"
						class="btn btn-primary btn-sm" id="btnsearch">检索</a>
				</div>
			</li>
		</ul>
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

		<div>
			<table class="table table-responsive">
				<tr>
					<td>
						<p>热门歌曲</p>
						<ul class="list-unstyled" id="song_hot_list"
							style="line-height: 2.6rem;">
							<li>暂无数据</li>
						</ul>
					</td>
					<td>
						<p>新增歌曲</p>
						<ul class="list-unstyled" id="song_new_list"
							style="line-height: 2.6rem;">
							<li>暂无数据</li>
						</ul>
					</td>
					<td>
						<p>最近试听</p>
						<ul class="list-unstyled" id="song_near_list"
							style="line-height: 2.6rem;">
							<li>暂无数据</li>
						</ul>
					</td>
					<td>
						<p>作词人</p>
						<ul class="list-unstyled" id="song_byword_list"
							style="line-height: 2.6rem;">
							<li>暂无数据</li>
						</ul>
					</td>
				</tr>
			</table>
		</div>

	</div>
	<script type="text/javascript">
        //限制只能打开一个播放页面
        function open_song(songid) {
            another = open('/music/song?sid=' + songid, 'play');
        }
        function search_person(val) {
            var key = val;
            window.open("/music/search_song?key=" + escape(key), "_top");
        }
        function StringFormat(arguments) {
            if (arguments.length === 0)
                return null;
            var str = arguments[0];
            for (var i = 1; i < arguments.length; i++) {
                var re = new RegExp('\\{' + (i - 1) + '\}', 'gm');
                str = str.replace(re, arguments[i]);
            }
            return str;
        }
        function get_song(type, objid) {
            var url = "";
            if (type === "hot") {
                url = "/apimusic/get_hot_song";
            }
            if (type === "new") {
                url = "/apimusic/get_new_song";
            }
            if (type === "near") {
                url = "/apimusic/get_record_song";
            }
            if (type === "byword") {
                url = "/apimusic/get_byword";
            }
            if (url !== "") {
                $.ajax(url, {
                    data: { index: 0, rows: 15 },
                    async: false,
                    dataType: "jsonp",
                    jsonp: "callback",
                    crossDomain: true,
                    success: function (json) {
                        $(objid).html("");
                        var shtml = '';
                        $.each(json.result, function (i, k) {
                            if (type === "byword") {
                                shtml += '<li><a href="javascript:;" onclick="search_person(\'' + k.byword + '\')">' + k.byword + ' (' + k.total + ')</a></li>';
                            } else {
                                if (type === "near") {
                                    shtml += '<li><a href="javascript:;" onclick="open_song(' + k.id + ')">' + k.songname + '-(' + k.singername + ')' + '</a></li>';
                                } else {
                                    shtml += '<li><a href="javascript:;" onclick="open_song(' + k.id + ')">' + k.songname + '-(' + k.singername + ')' + '</a></li>';
                                }
                            }
                        });
                        $(objid).html(shtml);
                    },
                    error: function (e) {
                        console.log('Error...' + e.message);
                    }
                });
            }
        }
        $(function () {
            get_song('hot', '#song_hot_list');
            get_song('new', '#song_new_list');
            get_song('near', '#song_near_list');
            get_song('byword', '#song_byword_list');
            //get_record_song
        });
        //get_new_song
    </script>
	<div class="text-center bottom_foot">
		<ul class="list-inline">
			<li><a class="color_while" target="_blank" href="<?php echo ($ipadd); ?>:9004/">火车票</a></li>
			<li><a class="color_while" target="_blank"
				href="<?php echo ($ipadd); ?>:9006/weibo">微博会员</a></li>
			<li><a class="color_while" target="_blank"
				href="<?php echo ($ipadd); ?>:9003/music">音乐</a></li>
			<li><a class="color_while" target="_blank" href="<?php echo ($ipadd); ?>:9009/">街拍</a></li>
			<li><a class="color_while" target="_blank" href="<?php echo ($ipadd); ?>:9007/">腾讯会员</a></li>
			<li><a class="color_while" target="_blank" href="<?php echo ($ipadd); ?>/">相册</a></li>
			<li><a class="color_while" target="_blank" href="<?php echo ($ipadd); ?>:9010/">书籍</a></li>
			<li><a class="color_while" target="_blank" href="<?php echo ($ipadd); ?>:9600/">影片</a></li>
		</ul>
	</div>
</body>
</html>