<?php if (!defined('THINK_PATH')) exit();?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta name="viewport" content="width=device-width" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo ($songname); ?></title>
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
</head>
<body>
	<div class="nav">
		<div class="lst">
			<a href="javascript:;" class="core">音乐站点</a>
		</div>
	</div>
	<div class="small_nav">
        <?php echo ($songname); ?>
    </div>
	<div class="picframe">
		<div class="parea" id="contlist">
			<div style="width: 880px; margin: 0 auto; overflow: hidden;">
				<div
					style="width: 350px; display: block; float: left; border-right: solid 1px #808080; padding-right: 15px;">
					<div>
						<img width="280px" src="<?php echo ($thumbnail); ?>" />
					</div>
					<div style="overflow: hidden; text-align: left;" id="song_info">
						<div>
							<strong>歌名：</strong> <span id="sp_songname"><?php echo ($songname); ?></span>
						</div>
						<div>
							<strong>歌手：</strong> <span id="sp_singername"><?php echo ($singername); ?></span>
						</div>
						<div>
							<strong>作词：</strong> <span id="sp_byword"><?php echo ($byword); ?></span>
						</div>
						<div>
							<strong>作曲：</strong> <span id="sp_bymusic"><?php echo ($bymusic); ?></span>
						</div>
						<div>
							<strong>编曲：</strong> <span id="sp_bianqu"><?php echo ($bianqu); ?></span>
						</div>
						<div>
							<strong>专辑：</strong> <span id="sp_albumname"><?php echo ($albumname); ?></span>
						</div>
						<div>
							<strong>时长：</strong> <span id="sp_times">00:00</span>
						</div>
					</div>
					<div>
						<audio id="media" style="" controls="true" autoplay="autoplay"> <source
							src="" /> 你的浏览器不支持video标签。 </audio>
						<input type="hidden" value="<?php echo ($songid); ?>" id="hiflag" />
						<input type="hidden" value="0" id="hipflag" />
						<div style="padding-top: 10px;">
							<div
								style="height: 12px; width: 100%; border: solid 1px #000000;">
								<div style="height: 10px; background-color: #2084aa"
									id="barline"></div>
							</div>

							<a href="javascript:;" id="pausemusic" data-value="1">播放</a> <a
								href="javascript:;" id="nextmusic">下一首</a> <span
								id="sp_begin_times">00:00</span>/<span id="sp_saler_times">00:00</span>
						</div>
					</div>
				</div>
				<div
					style="width: 500px; display: block; float: left; margin-left: 10px;">
					<ul id="songlist" style="line-height: 25px;"></ul>
					<script type="text/javascript">
                        //获取播放器对象
                        var p = $("#media")[0];
                        //初始化播放器音量.
                        p.volume = 0.4;
                        //获取歌曲信息
                        var songinfo = $("#song_info span");
                        //记录标记
                        var record = $("#hiflag");
                        /**
                         * 初始化歌曲列表
                         * @returns {undefined}
                         */
                        function get_song_list() {
                            //加载歌曲列表.
                            $.ajax("/apimusic/get_song_list", {
                                data: { aid: "<?php echo ($aid); ?>" },
                                async: false,
                                dataType: "jsonp",
                                jsonp: "callback",
                                crossDomain: true,
                                success: function (json) {
                                    $("#songlist").html("");
                                    var shtml = "";
                                    var flag = 0;
                                    $.each(json.result, function (i, k) {
                                        if (k.id === "<?php echo ($songid); ?>") {
                                            $("#hiflag").val(k.id);
                                        }
                                        if (k.filetype === "mp3" || k.filetype === "m4a") {
                                            shtml += "<li> >> <a href='javascript:;' data-flag='" + flag + "' data-id='" + k.id + "' data-type='" + k.filetype + "' data-path='" + escape(k.path) + "'>" + k.songname + "</a></li>";
                                            flag++;
                                        } else {
                                            shtml += "<li> >> <strong style='color:#d6d6d6'>" + k.songname + " (无法播放)&nbsp;</strong></li>";
                                        }
                                    });
                                    $("#songlist").html(shtml);
                                    //选择歌曲点击事件
                                    $("#songlist").find("li a").click(function () {
                                        $("#hiflag").val($(this).attr("data-id"));
                                        get_play_list();
                                    });
                                    get_play_list();
                                    check_play_isover();
                                },
                                error: function (e) {
                                    console.log('Error...' + e.message);
                                }
                            });
                        }

                        /**
                         * 获取当前播放歌曲信息
                         * @returns {undefined}
                         */
                        function get_play_list() {
                            var listbox = $("#songlist").find("li a");
                            for (var i = 0; i < listbox.length; i++) {
                                //获取当前歌曲标识
                                var current_song = parseInt(record.val());
                                //获取歌曲列表标识
                                var list_song = parseInt($(listbox[i]).attr("data-id"));
                                //获取歌曲类型
                                var type = $(listbox[i]).attr("data-type");
                                if (current_song === list_song) {
                                    get_song_info(current_song);
                                    var url = "<?php echo ($MUSICDOMAIN); ?>" + unescape($(listbox[i]).attr("data-path"));
                                    play_core_setting(url);
                                    if ((i + 1) >= listbox.length) {
                                        $("#hiflag").val($(listbox[0]).attr("data-id"));
                                        break;
                                    } else {
                                        $("#hiflag").val($(listbox[i + 1]).attr("data-id"));
                                        break;
                                    }
                                }
                            }
                        }
                        /**
                         * 歌曲播放设置
                         * @param {type} url
                         * @returns {undefined}
                         */
                        function play_core_setting(url) {
                            $("#media").attr("src", url);
                            var playCheck = setInterval(function () {
                                if (p.readyState === 4) {
                                    song_time_long("#sp_times", p.duration);
                                    song_time_long("#sp_saler_times", p.duration);
                                    clearInterval(playCheck);
                                }
                            }, 1000);

                            setInterval(function () {
                                //count_music_salertime("#sp_saler_times", p.duration, p.currentTime, 1);
                                count_music_salertime("#sp_begin_times", p.duration, p.currentTime, 0);
                                var v = (p.currentTime / p.duration) * 100;
                                $("#barline").css("width", v + "%");
                            }, 999);
                        }
                        //播放器监听
                        //p.addEventListener("timeupdate", function () {
                            
                        //}, false);
                        /**
                         * 计算歌曲的时间
                         * @param {type} obj 标签id
                         * @param {type} total 总时长(秒)
                         * @returns {undefined}
                         */
                        function song_time_long(obj, total) {
                            var time_munite = parseInt(total / 60);
                            var time_second = parseInt(total % 60);
                            var time_result_string = "";
                            if (time_munite < 10) {
                                time_result_string = "0" + time_munite;
                            } else {
                                time_result_string = time_munite;
                            }
                            if (time_second < 10) {
                                time_result_string += ":0" + time_second;
                            } else {
                                time_result_string += ":" + time_second;
                            }
                            $(obj).html(time_result_string);
                        }
                        /**
                         * 计算剩余时间
                         * @returns {undefined}
                         */
                        function count_music_salertime(obj, total, currentTime, op) {
                            if (op == 1) {
                                var slaey = (total - currentTime);
                                song_time_long(obj, slaey);
                            } else {
                                song_time_long(obj, currentTime);
                            }
                        }

                        /**
                         * 获取歌曲信息
                         * @param {type} songid
                         * @returns {undefined}
                         */
                        function get_song_info(songid) {
                            //获取歌曲信息
                            $.get("/apimusic/get_song_info", { songid: songid }, function (data) {
                                var json = eval("(" + data + ")");
                                $.each(json.result, function (i, k) {
                                    $(songinfo[0]).html(k.songname);
                                    $(songinfo[2]).html(k.byword);
                                    $(songinfo[3]).html(k.bymusic);
                                    $(songinfo[4]).html(k.bianqu);
                                    //$(songinfo[6]).html(k.times);
                                    document.title = k.songname;
                                });
                            });
                        }
                        /**
                         * 检测音频是否播放完毕.
                         * @returns {undefined}
                         */
                        function check_play_isover() {
                            //http://www.w3school.com.cn/tags/html_ref_audio_video_dom.asp
                            setInterval(function () {
                                if (p.ended) {
                                    get_play_list();
                                } else {
                                    if (p.readyState === 0 || p.readyState === 1) {
                                        get_play_list();
                                    }
                                }
                            }, 1500);
                        }
                        /**
                         * 歌曲暂停
                         * @returns {undefined}
                         */
                        $("#pausemusic").click(function () {
                            var v = $(this).attr("data-value");
                            //alert($(obj));
                            if (v === '' || v === "0") {
                                p.play();
                                $(this).attr("data-value", "1");
                                $(this).html("播放");
                            } else {
                                p.pause();
                                $(this).attr("data-value", "0");
                                $(this).html("暂停");
                            }
                        });
                        /**
                         * 下一首歌
                         * @returns {undefined}
                         */
                        $("#nextmusic").click(function () {
                            get_play_list();
                        });
                        //加载初始化列表
                        get_song_list();
                    </script>
				</div>
			</div>
		</div>
	</div>
	<!--     页面底部 -->
	<div class="foots">
		<div style="margin-top: 10px;">邢智个人数据系统</div>
		<div style="margin-top: 10px;">&copy;2007 - 2017</div>
		<div style="margin-top: 10px;">
			<a style="color: #428bca" target="_blank"
				href="http://127.0.0.1:9004/reailwayinfo">火车票</a> <a
				style="color: #428bca" target="_blank"
				href="http://127.0.0.1:9000/weibo">微博会员</a> <a
				style="color: #428bca" target="_blank" href="javascript:;">淘女郎</a> <a
				style="color: #428bca" target="_blank"
				href="http://127.0.0.1:9000/oicq/oicqlist">腾讯会员</a> <a
				style="color: #428bca" target="_blank"
				href="http://127.0.0.1:9003/music">音乐</a>
		</div>
	</div>

</body>
</html>