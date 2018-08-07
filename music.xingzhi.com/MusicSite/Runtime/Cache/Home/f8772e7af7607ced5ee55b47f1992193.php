<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
    <style type="text/css">
        body { font-family: 'Microsoft YaHei', 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif; }
        a.color_while { color: #FFF; }
        a.color_while:hover { color: #ffd800; }
        a.color_garpwhile { color: #a3a1a1; }
        .top_header { position: fixed; top: 0; z-index: 100; background: #333; height: 5rem; color: #FFF; line-height: 5rem; width: 100%; }
        .bottom_foot { position: fixed; bottom: 0; z-index: 100; width: 100%; background: #333; height: 5rem; color: #FFF; line-height: 5rem; }
        /**自定义样式*/
        .table-vertical-align { vertical-align: middle !important; }
        .top_header { position: fixed; top: 0; z-index: 100; background: #333; height: 5rem; color: #FFF; line-height: 5rem; width: 100%; }
        .bottom_foot { position: fixed; bottom: 0; z-index: 100; width: 100%; background: #333; height: 5rem; color: #FFF; line-height: 5rem; }
    </style>
</head>
<body>
    <div class="text-center top_header"> 音乐收藏站 </div>

    <div style="padding:1rem; margin-top:5rem; padding-bottom:5rem;">
        <ol class="breadcrumb">
            <li class="active">首页</li>
        </ol>

        <ul class="list-inline">
            <li><a href="/weibo/addweibo" class="popup-add btn btn-info btn-sm" id="search_pro">歌手</a></li>
            <li>
                <div class="form-group form-inline">
                    <label for="exampleInputName2">检索</label>
                    <input type="text" class="form-control" id="exampleInputName2" placeholder="Jane Doe">
                    <button class="btn btn-primary" value="">检索</button>
                </div>
            </li>
        </ul>

    </div>

    

    <div class="text-center bottom_foot">
        <ul class="list-inline">
            <li><a class="color_while" target="_blank" href="<?php echo ($ipadd); ?>:9004/">火车票</a></li>
            <li><a class="color_while" target="_blank" href="<?php echo ($ipadd); ?>:9006/weibo">微博会员</a></li>
            <li><a class="color_while" target="_blank" href="<?php echo ($ipadd); ?>:9003/music">音乐</a></li>
            <li><a class="color_while" target="_blank" href="<?php echo ($ipadd); ?>:9009/">街拍</a></li>
            <li><a class="color_while" target="_blank" href="<?php echo ($ipadd); ?>:9007/">腾讯会员</a></li>
            <li><a class="color_while" target="_blank" href="<?php echo ($ipadd); ?>/">相册</a></li>
            <li><a class="color_while" target="_blank" href="<?php echo ($ipadd); ?>:9010/">书籍</a></li>
            <li><a class="color_while" target="_blank" href="<?php echo ($ipadd); ?>:9600/">影片</a></li>
        </ul>
    </div>
</body>
</html>