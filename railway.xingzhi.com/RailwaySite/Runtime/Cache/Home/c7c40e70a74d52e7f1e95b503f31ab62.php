<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<meta name="viewport" content="width=device-width" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>银行卡信息</title>
	<link rel="Shortcut Icon" href="/image/_64X64.ico" type="image/x-icon" />
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
    <script type="text/javascript" src="/My97DatePicker/WdatePicker.js"></script>
    <script type="text/javascript" src="/js/jquery.magnific-popup.min.js"></script>
    <script type="text/javascript" src="/js/jquery.uploadify.min.js" ></script>
<style type="text/css">
    .banktab { width:100%; line-height:32px; }
    .banktab thead{ font-weight:bold;}
    .banktab td { text-align:center;}
    .banktab td.t1 { width:20%;}
</style>
</head>
<body>
    <div class="nav">
        <div class="lst">
            <a href="javascript:;" class="core">银行卡</a>
        </div>
    </div>

    <div class="small_nav">
        <a href="/">首页</a>&gt; 银行卡
    </div>

    <div class="select_type">
        <a href="/bankinfo/addbankinfo" class="popup-add" id="search_pro">新增银行卡</a>
    </div>

    <div class="picframe">
    	<!-- Contents List -->
        <div class="parea" id="contlist">
        
        	<table class="banktab">
                <thead>
                    <tr>
                        <td class="t1">银行名称</td>
                        <td>操作</td>
                    </tr>
                </thead>
                <tbody>
                <?php if(is_array($bankinfo)): $i = 0; $__LIST__ = $bankinfo;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
                        <td><?php echo ($vo["bankname"]); ?></td>
                        <td>
                            <a href="javascript:;">增加新卡</a>
                        </td>
                    </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                </tbody>
            </table>
        
        </div>
        <!-- Pager Index -->
        <input type="hidden" value="0" id="hidPage" />
    </div>

	<script type="text/javascript">
        $(document).ready(function () {
            //加载网页
            $('.popup-add').magnificPopup({
                disableOn: 800,
                type: 'iframe',
                mainClass: 'mfp-fade',
                removalDelay: 160,
                preloader: false,
                fixedContentPos: true
            });
        });
	</script>

    <!--     页面底部 -->
<div class="foots">
    <div style="margin-top:10px;">邢智个人数据系统</div>
    <div style="margin-top:10px;">&copy;2007 - 2017 </div>
    <div style="margin-top:10px;">
        <a style="color:#428bca" target="_blank" href="http://127.0.0.1:9004/">火车票</a>
        <a style="color:#428bca" target="_blank" href="http://127.0.0.1:9006/weibo">微博会员</a>
        <a style="color:#428bca" target="_blank" href="javascript:;">淘女郎</a>
        <a style="color:#428bca" target="_blank" href="http://127.0.0.1:9007/">腾讯会员</a>
        <a style="color:#428bca" target="_blank" href="http://127.0.0.1:9003/music">音乐</a>
        <a style="color:#428bca" target="_blank" href="http://127.0.0.1:9009/">街拍</a>
        <a style="color:#428bca" target="_blank" href="http://127.0.0.1:9010/">书籍</a>
    </div>
</div>

</body>
</html>