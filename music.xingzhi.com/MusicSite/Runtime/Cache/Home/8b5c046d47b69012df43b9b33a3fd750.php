<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <link rel="shortcut icon" href="/image/x64.ico" />
    <title>随机试听歌曲</title>
    <link type="text/css" href="/css/bootstrap.min.css" rel="Stylesheet" />
    <link type="text/css" href="/css/buttons.css" rel="Stylesheet" />
    <link type="text/css" href="/css/font-awesome.min.css" rel="Stylesheet" />
    <script type="text/javascript" src="/js/jquery-1.11.1.min.js"></script>
    <style type="text/css">
        body { margin: 0; padding: 0; font-family: 微软雅黑; }
        ul, li, dd, dl, dt { margin: 0; padding: 0; }
        .bg { background: url('/image/songbg/101.jpg'); text-align: center; }
        .bg-blur { float: left; width: 100%; background-repeat: no-repeat; background-position: center; background-size: cover; -moz-filter: blur(3px); -webkit-filter: blur(11px); /*CSS滤镜属性;blur:设置对象的模糊效果.*/ -o-filter: blur(18px); -ms-filter: blur(18px); filter: blur(18px); }
        .content-front { position: absolute; left: 10px; right: 10px; top: 30px; padding: 10px; color: #FFF; }
        .title_cont p { font-size: 16px; }
        /*专辑区域*/
        .song_frame { width: 90%; margin: 0 auto; padding-top: 10px; }
        .layer_over_clear { overflow: hidden; border-bottom: dashed 0px #FFF; padding-bottom: 23px; }
        .layer_over { overflow: hidden; width: 60%; float: left; padding-bottom: 23px; }
        .title_cont { float: left; padding: 2px; margin-left: 30px; }
        .songword { list-style: none; }
        .songword li { padding-left: 3px; }
    </style>

</head>
<body>
    <div id="songbg" class="bg bg-blur"></div>
    <div class="content-front">
        <!--专辑区域-->
        <div class="song_frame">
            <div class="layer_over">
                <div style="float: left; width: 360px; padding: 2px;">
                    <img id="albumpic" src="/image/noalbumn.png" width="300px" alt="" />
                    <div style="padding-top: 2px; padding-bottom: 10px;">
                        <audio id="media" style="display:block;" controls="true"
                               autoplay="autoplay">
                            <source src="<?php echo ($songurl); ?>" />
                            你的浏览器不支持video标签。
                        </audio>
                    </div>
                    <div>
                        <a id="nextmusic" href="javascript:;" onclick="net_music()"
                           class="button button-3d button-primary button-rounded">下一首</a>
                    </div>
                </div>
                <div class="title_cont" id="song_info">
                    <p>
                        歌名：<span>-</span>
                    </p>
                    <p>
                        专辑：<span>-</span>
                    </p>
                    <p>
                        歌手：<span>-</span>
                    </p>
                    <p>
                        作词：<span>-</span>
                    </p>
                    <p>
                        作曲：<span>-</span>
                    </p>
                    <p>
                        编曲：<span>-</span>
                    </p>
                    <p>
                        时长：<span>-</span>
                    </p>
                    <p>
                        发行年份：<span>-</span>
                    </p>
                    <p>
                        播放次数：<span>-</span>
                    </p>
                </div>
            </div>
            <div style="padding-left: 15px; border-left: dashed 1px #FFF; color: #FFF; line-height: 14px; font-weight: blod; float: left; width: 39%;">
                <p>歌词：</p>
                <div style="max-height: 650px; min-height: 600px; overflow: auto;">
                    <div id="songword"
                         style="background: rgba(41, 104, 172, 0.45); padding-left: 5px; padding-bottom: 5px; padding-top: 5px;">
                        loading...
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $("#songbg").css("height", $(window).height() + "px");
        //获取播放器对象
        var p = $("#media")[0];
        p.volume = 0.6; //初始化音量
        //获取歌曲信息
        var songinfo = $("#song_info span");
        //记录标记
        var record = $("#hiflag");
        //歌曲暂停
        function pause_music() {
            var v = $("#pausemusic").attr("data-value");
            if (v === '' || v === 0) {
                p.play();
                $("#pausemusic").attr("data-value", "1");
                $("#pausemusic").html("播放");
            } else {
                p.pause();
                $("#pausemusic").attr("data-value", "0");
                $("#pausemusic").html("暂停");
            }
        }
        //下一首歌
        function net_music() {
            //p.pause();
            get_song_ran();
        }
        //获取歌曲信息
        function get_song_info(songid) {
            $.get("/apimusic/get_song_info", { songid: songid }, function (data) {
                var json = eval("(" + data + ")");
                $.each(json.result, function (i, k) {

                    $(songinfo[0]).html(k.songname);
                    $(songinfo[1]).html(k.albumname);
                    $(songinfo[2]).html(k.singername);
                    $(songinfo[3]).html(k.byword);
                    $(songinfo[4]).html(k.bymusic.substr(0, 26));
                    $(songinfo[4]).attr("title", k.bymusic);
                    $(songinfo[5]).html(k.bianqu);
                    $(songinfo[6]).html(k.times);
                    $(songinfo[7]).html(k.issueyear);
                    $(songinfo[8]).html(k.listentime);
                    $("#songword").html('暂无歌词');
                    if (k.songword != '') {
                        $("#songword").html(k.songword)
                    }
                    if (k.times === "00:00:00") {
                        var times = p.duration;
                        if (!isNaN(times)) {
                            $.ajax("/apimusic/set_song_duration",
                                    {
                                        data: { sid: k.id, tims: times },
                                        async: false,
                                        dataType: "jsonp",
                                        jsonp: "callback",
                                        crossDomain: true,
                                        success: function (json) {
                                            alert(json.result);
                                        }
                                    });
                        }
                    }
                    document.title = k.songname + "|" + k.singername + "|" + k.albumname;
                });
            });
        }
        //加载歌曲列表.
        function get_song_ran(songid) {
            $.ajax("/apimusic/get_song_random", {
                data: { sid: songid, songtype: 1 },
                async: false,
                dataType: "jsonp",
                jsonp: "callback",
                crossDomain: true,
                success: function (json) {
                    //alert(json.result[0]);
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
        //检测歌曲是否没有播放.
        setInterval(function () {
            if (p.currentTime == p.duration || p.ended) {
                get_song_ran();
            }
                //歌曲异常或者不存在时.刷新下一首歌.
            else if (p.readyState == 0 && p.ended == false && p.currentTime <= 0) {
                get_song_ran();
            }
        }, 2000);

        get_song_ran("<?php echo ($sid); ?>");
    </script>
</body>
</html>