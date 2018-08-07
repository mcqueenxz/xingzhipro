<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="/image/x64.ico">
    <title>火车票统计</title>
    <link rel="stylesheet" type="text/css" href="/css/bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="/css/magnific-popup.css" />
    <script type="text/javascript" src="/js/jquery-3.3.1.min.js"></script>
    <script type="text/javascript" src="/js/bootstrap.js"></script>
    <script type="text/javascript" src="/js/jquery.magnific-popup.min.js"></script>
    <style type="text/css">
        body { font-family: 'Microsoft YaHei', 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif; }
        a.color_while { color:#FFF; }
        a.color_while:hover { color:#ffd800; }
        .top_header { position: fixed; top: 0; z-index: 100; background: #333; height: 5rem; color: #FFF; line-height: 5rem; width: 100%; }
        .bottom_foot { position: fixed; bottom: 0; z-index: 100; width: 100%; background: #333; height: 5rem; color: #FFF; line-height: 5rem; }
    </style>
</head>
<body>
    <div class="text-center top_header">
        火车票统计
    </div>
    <div style="padding:1rem; padding-bottom:5.5rem; margin-top:5rem;">
        <ol class="breadcrumb">
            <li><a href="/">首页</a></li>
            <li class="active">车票信息列表</li>
        </ol>

        <ul class="list-inline">
            <li><a href="/reailwayinfo/addticket" class="popup-add-railway" id="search_pro">新增车票</a> | 按年查看：</li>
            <li><a href="/reailwayinfo/index?stime=2014-01-01&etime=2014-12-31" class="text-primary">2014</a></li>
            <li><a href="/reailwayinfo/index?stime=2015-01-01&etime=2015-12-31" class="text-primary">2015</a></li>
            <li><a href="/reailwayinfo/index?stime=2016-01-01&etime=2016-12-31" class="text-primary">2016</a></li>
            <li><a href="/reailwayinfo/index?stime=2017-01-01&etime=2017-12-31" class="text-primary">2017</a></li>
            <li><a href="/reailwayinfo/index?stime=2018-01-01&etime=2018-12-31" class="text-primary">2018</a></li>
        </ul>
        <table class="table table-condensed table-hover table-bordered text-center table-striped">
            <thead>
                <tr>
                    <th class="col-sm-1 text-center">车次</th>
                    <th class="col-sm-2 text-center">发车时间</th>
                    <th class="col-sm-1 text-center">出发站</th>
                    <th class="col-sm-1 text-center">到达站</th>
                    <th class="col-sm-1 text-center">价格</th>
                    <th class="col-sm-1 text-center">车厢号</th>
                    <th class="col-sm-1 text-center">座位号</th>
                    <th class="col-sm-1 text-center">座位类型</th>
                    <th class="col-sm-1 text-center">列车类型</th>
                    <th class="col-sm-1 text-center">售卖站</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                <?php if(is_array($reailway)): $i = 0; $__LIST__ = $reailway;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$data): $mod = ($i % 2 );++$i;?><tr>
                        <td><?php echo ($data["reailwaycode"]); ?></td>
                        <td><?php echo (substr($data["begintime"],0,16)); ?></td>
                        <td><?php echo ($data["sstation"]); ?></td>
                        <td><?php echo ($data["estation"]); ?></td>
                        <td><p class="text-danger">￥<?php echo ($data["amount"]); ?></p></td>
                        <td><?php echo ($data["reailwaynum"]); ?> 车</td>
                        <td><?php echo ($data["seatnum"]); ?></td>
                        <td><?php echo ($data["reailwayseattype"]); ?></td>
                        <td><?php echo ($data["reailwaytype"]); ?></td>
                        <td><?php echo ($data["buystation"]); ?></td>
                        <td class="text-left">
                            <a class="btn btn-primary btn-xs">修改</a>
                            <a class="btn btn-danger btn-xs">删除</a>
                        </td>
                    </tr><?php endforeach; endif; else: echo "" ;endif; ?>
            </tbody>
        </table>
        <!--<ul class="pagination">
            <li><a href="#">«</a></li>
            <li><a href="#">1</a></li>
            <li><a href="#">2</a></li>
            <li class="disabled"><a href="#">3</a></li>
            <li><a href="#">4</a></li>
            <li><a href="#">5</a></li>
            <li class="active"><a href="#">6</a></li>
            <li><a href="#">»</a></li>
        </ul>-->
    </div>

    <script type="text/javascript">
        $(document).ready(function () {
            //加载网页
            $('.popup-add-railway').magnificPopup({
                disableOn: 800,
                type: 'iframe',
                mainClass: 'mfp-fade',
                removalDelay: 160,
                preloader: false,
                fixedContentPos: true
            });
        });
    </script>

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
    <!--<button type="button" class="btn btn-default" title="刷新">
        <span class="glyphicon glyphicon-repeat"></span>
    </button>-->
    
   
</body>
</html>