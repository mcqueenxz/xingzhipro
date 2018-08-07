<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>新增歌手专辑</title>
    <!--bootstrap 框架-->
    <link type="text/css" href="/css/bootstrap.css" rel="stylesheet" />
    <!--jQuery 框架-->
    <script type="text/javascript" src="/js/jquery-1.11.1.min.js"></script>
    <!--magnific-popup 框架-->
    <link type="text/css" href="/css/magnific-popup.css" rel="stylesheet" />
    <script type="text/javascript" src="/js/jquery.magnific-popup.min.js"></script>
    <!--提示信息弹出层 框架-->
    <script type="text/javascript" src="/layer/layer.js"></script>
    <script type="text/javascript" src="/layer/extend/layer.ext.js"></script>
    <!--图片上传控件-->
    <link rel="stylesheet" type="text/css" href="/css/uploadify.css" />
    <script type="text/javascript" src="/js/jquery.uploadify.min.js"></script>
    <style type="text/css">
        body { font-family: 'Microsoft YaHei', 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif; }
        a.color_while { color: #FFF; }
        a.color_while:hover { color: #ffd800; }
        a.color_garpwhile { color: #a3a1a1; }
    </style>
</head>
<body>
    <div style="padding:1rem;">
        <table class="table table-bordered table-condensed table-responsive">
            <tr>
                <td class="col-md-2 text-right table-vertical-align">专辑名称：</td>
                <td> <input type="text" class="form-control" id="albumname" name="albumname" /> </td>
            </tr>
            <tr>
                <td class="col-md-2 text-right table-vertical-align">语言类型：</td>
                <td>
                    <label> <input type="radio" checked="checked" value="国语" name="languages" />国语 </label>
                    <label> <input type="radio" value="粤语" name="languages" />粤语 </label>
                    <label> <input type="radio" value="英语" name="languages" />英语 </label>
                    <label> <input type="radio" value="日语" name="languages" />日语 </label>
                    <label> <input type="radio" value="韩语" name="languages" />韩语 </label>
                    <label> <input type="radio" value="韩语" name="languages" />法语 </label>
                    <label> <input type="radio" value="其它" name="languages" />其它 </label>
                </td>
            </tr>
            <tr>
                <td class="col-md-2 text-right table-vertical-align">发行年月：</td>
                <td>
                    <select id="issueyear"></select> <select id="issuemonth"></select>
                    <script type="text/javascript">
                        var currentyear = new Date();
                        for (var y = currentyear.getFullYear() ; y >= 1930; y--) {
                            $("<option value=\"" + y + "\">" + y + "</option>").appendTo($("#issueyear"));
                        }
                        for (var m = 1; m <= 12; m++) {
                            $("<option value=\"" + m + "\">" + m + "</option>").appendTo($("#issuemonth"));
                        }
                    </script>
                </td>
            </tr>
            <tr>
                <td class="col-md-2 text-right table-vertical-align">上传封面：</td>
                <td><input type="file" id="upfile" name="upfile" /></td>
            </tr>
            <tr>
                <td class="col-md-2 text-right table-vertical-align"></td>
                <td>
                    <input type="button" class="btn btn-primary" id="btnupload" name="btnupload" value="提交" />
                </td>
            </tr>
        </table>

        <script type="text/javascript">
            $("#upfile").uploadify({
                'auto': false,
                'fileObjName': 'filedata',
                'formData': {},
                'buttonText': '上传专辑',
                'swf': '/js/uploadify.swf',
                'uploader': '/api/addalbumn',
                'multi': true,
                'method': 'post',
                'onInit': function () { },
                'onUploadStart': function (file) {
                    var element = {};
                    element.sid = "<?php echo ($singerid); ?>";
                    element.albumname = $("#albumname").val();
                    element.issueyear = $("#issueyear").val();
                    element.issuemonth = $("#issuemonth").val();
                    element.languages = $("input[name='languages']:checked").val();//$("#languages").val();
                    $("#upfile").uploadify("settings", "formData", element);
                },
                'onUploadSuccess': function (file, data, response) {
                    var jsonVal = eval("(" + data + ")");
                    if (jsonVal.code > 0) {
                        layer.msg(jsonVal.msg);
                        setTimeout(function () {
                            window.open(window.parent.document.location.href, '_top');
                        }, 1000);
                    } else {
                        layer.msg(jsonVal.msg);
                    }
                },
                'onUploadError': function (file, errorCode,
                        errorMsg, errorString) {
                }
            });
            $("#btnupload").click(function () {
                $('#upfile').uploadify('upload');
            });
        </script>
    </div>
</body>
</html>