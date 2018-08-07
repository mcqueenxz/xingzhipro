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

</head>

<body>
<div class="opera_frame">
    <div class="opear_layer">
        <form action="/bankinfo/addbankinfo?tspam=<?php echo ($tspan); ?>" method="post">
            <table>
                <tr>
                    <td width="16%">银行名称</td>
                    <td>
                        <input class="inputsty" name="" id="" />
                    </td>
                </tr>
                <tr>
                    <td width="20%"></td>
                    <td>
                        <input type="button" class="buttons" id="btnSubmit" name="btnSubmit" value="提 交" />
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>
</body>
</html>