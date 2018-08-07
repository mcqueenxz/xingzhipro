<?php if (!defined('THINK_PATH')) exit();?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta name="viewport" content="width=device-width" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>随机试听歌曲</title>
<link rel="Shortcut Icon" href="/image/_64X64.ico" type="image/x-icon" />
<link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css" />
<link rel="stylesheet" type="text/css" href="/css/common.css" />
<link rel="stylesheet" type="text/css"
	href="/css/jquery.toastmessage.css" />
<link rel="stylesheet" type="text/css" href="/css/magnific-popup.css" />
<link rel="stylesheet" type="text/css" href="/css/uploadify.css" />
<style type="text/css">
/**标题文字数据展示框架*/
.picframe .parea .tit-list {
	float: left;
	width: 220px;
	border: solid 2px #FFF;
	margin-left: 32px;
	margin-top: 25px;
	background: #FFF;
	border-radius: 5px;
	overflow: hidden;
}

.picframe .parea .tit-list:hover {
	border: solid 2px #bc0000;
}

.picframe .parea .tit-list .tit-info {
	line-height: 23px;
}

.picframe .parea .tit-list .tit-info li {
	height: 25px;
	padding-left: 5px;
}
/**火车票备选站样式**/
.ticketSty, .ticketStyEnd, .traintype {
	text-indent: 1px;
}

.ticketSty a, .ticketStyEnd a, .traintype a {
	color: #989a9a;
	text-decoration: none;
	margin-left: 5px;
}

.ticketSty a:hover, .ticketStyEnd a:hover, .traintype a:hover {
	color: #aa0202
}

.sstation {
	color: #d2550c
}

.estation {
	color: #347516
}
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
.cidai_bottom {
	line-height: 32px;
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
		<a href="/">首页</a>
	</div>
	<div class="select_type">
		<a href="/music/singerlist">歌手</a> | <a href="/music/album_lib">专辑列表</a>
		| <a href="javascript:;" target="_blank" onclick="random_song()">随便听听(<?php echo ($song_total); ?>)</a>
		| <input type="text" id="search" /> <a href="javascript:;"
			id="btnsearch">检索</a>

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
			<div style="width: 95%; margin: 0 auto;">
				<div style="">
					<div style="overflow: hidden;">
						<div style="float: left; width: 300px;">
							<div style="padding: 0px 0px 5px 0px;">
								<img id="albumpic" width="300px" height="302px"
									src="<?php echo ($thumbnail); ?>" />
							</div>
							<div style="padding: 0px 0px 5px 0px;">
								<audio id="media" style="display:block;" controls="true"
									autoplay="autoplay"> <source src="<?php echo ($songurl); ?>" />
								你的浏览器不支持video标签。 </audio>
							</div>
						</div>
						<div style="float: left; width: 320px; margin-left: 50px;">
							<div style="padding: 0px 0px 20px 0px; height: 305px;">
								<ul class="cidai_bottom" id="song_info">
									<li><strong>歌曲：</strong> <span id="sp_songname"><?php echo ($songname); ?></span></li>
									<li><strong>时长：</strong> <span id="sp_times"><?php echo ($times); ?></span>
									</li>
									<li><strong>歌手：</strong> <span id="sp_singername"><?php echo ($singername); ?></span></li>
									<li><strong>作词：</strong> <span id="sp_byword"><?php echo ($byword); ?></span>
									</li>
									<li><strong>作曲：</strong> <span id="sp_bymusic"><?php echo ($bymusic); ?></span>
									</li>
									<li><strong>编曲：</strong> <span id="sp_bianqu"><?php echo ($bianqu); ?></span>
									</li>
									<li><strong>时长：</strong> <span id="sp_albumname"><?php echo ($albumname); ?></span>
									</li>
									<li><input type="hidden" id="isuptime" value="0" /></li>
								</ul>
							</div>
							<div>
								<a href="javascript:pause_music();" id="nextmusic"
									data-value="1">播放</a> <a href="javascript:net_music();"
									id="nextmusic">换一首</a>
							</div>
						</div>
						<div style="float: left; width: 320px; margin-left: 10px;">
							歌词：
							<div>暂无歌词</div>
						</div>
					</div>
				</div>
				<script type="text/javascript">
                    //获取播放器对象
                    var p = $("#media")[0];
                    p.volume = 0.6; //初始化音量 
                    //获取歌曲信息
                    var songinfo = $("#song_info span");
                    //记录标记
                    var record = $("#hiflag");
                    //歌曲暂停
                    function pause_music() {
                        var v = $("#nextmusic").attr("data-value");
                        if (v === '' || v === 0) {
                            p.play();
                            $("#nextmusic").attr("data-value", "1");
                            $("#nextmusic").html("播放");
                        } else {
                            p.pause();
                            $("#nextmusic").attr("data-value", "0");
                            $("#nextmusic").html("暂停");
                        }
                    }
                    //下一首歌
                    function net_music() {
                        //p.pause();
                        get_song_ran();
                    }
                    //获取歌曲信息
                    function get_song_info(songid) {
                        $.get("/apimusic/get_song_info", {songid: songid}, function (data) {
                            var json = eval("(" + data + ")");
                            $.each(json.result, function (i, k) {
                                $(songinfo[0]).html(k.songname);
                                $(songinfo[3]).html(k.byword);
                                $(songinfo[4]).html(k.bymusic);
                                $(songinfo[5]).html(k.bianqu);
                                $(songinfo[6]).html(k.times);
                                if (k.times === "00:00:00") {
                                    var times = p.duration;
                                    $.ajax("/apimusic/set_song_duration",
                                            {
                                                data: {sid: k.id, tims: times},
                                                async: false,
                                                dataType: "jsonp",
                                                jsonp: "callback",
                                                crossDomain: true,
                                                success: function (json) {
                                                    alert(json.result);
                                                }
                                            });
                                }
                                document.title = k.songname;
                            });
                        });
                    }
                    //加载歌曲列表.
                    function get_song_ran(songid) {
                        $.ajax("/apimusic/get_song_random", {
                            data: {sid: songid},
                            async: false,
                            dataType: "jsonp",
                            jsonp: "callback",
                            crossDomain: true,
                            success: function (json) {
                                var url = "<?php echo ($MUSICDOMAIN); ?>" + json.result[0].path + "?r=" + Math.random();
                                $("#media").attr("src", url);
                                $("#albumpic").attr("src", "<?php echo ($IMGDOMAIN); ?>" + json.result[0].thumbnail);
                                get_song_info(json.result[0].id);
                            },
                            error: function (e) {
                                console.log('Error...' + e.message);
                            }
                        });
                    }
                    setInterval(function () {
                        if (p.ended) {
                            get_song_ran();
                        } else {
                            if (p.readyState === 0 || p.readyState === 1) {
                                get_song_ran();
                            }
                        }
                    }, 2100);
                    get_song_ran("<?php echo ($sid); ?>");
                </script>
			</div>
		</div>
		<!--     页面底部 -->
		<div class="foots">
			<div style="margin-top: 10px;">邢智个人数据系统</div>
			<div style="margin-top: 10px;">&copy;2007 - 2017</div>
			<div style="margin-top: 10px;">
				<a style="color: #428bca" href="http://127.0.0.1:9004/reailwayinfo">火车票</a>
				<a style="color: #428bca" href="http://127.0.0.1:9000/weibo">微博会员</a>
				<a style="color: #428bca" href="javascript:;">淘女郎</a> <a
					style="color: #428bca" href="http://127.0.0.1:9000/oicq/oicqlist">腾讯会员</a>
				<a style="color: #428bca" href="http://127.0.0.1:9003/music">音乐</a>
			</div>
		</div>

</body>
</html>