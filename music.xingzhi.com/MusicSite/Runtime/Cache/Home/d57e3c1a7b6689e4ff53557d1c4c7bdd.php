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
    <!--在线编辑器-->
    <script charset="utf-8" src="/kindeditor/kindeditor-all-min.js"></script>
    <script charset="utf-8" src="/kindeditor/lang/zh-CN.js"></script>
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
                <td class="col-md-2 text-right table-vertical-align">歌曲名称：</td>
                <td>
                    <input type="text" class="form-control" id="songname" name="songname" />
                    <div>
                        <input type="radio" id="songtype1" name="songtype" value="1" checked="checked" />歌曲
                        <input type="radio" id="songtype2" name="songtype" value="2" />音乐
                    </div>
                </td>
            </tr>
            <tr>
                <td class="col-md-2 text-right table-vertical-align"><label>作词：</label></td>
                <td>
                    <input type="text" class="form-control" id="byword" name="byword" />
                </td>
            </tr>
            <tr>
                <td class="col-md-2 text-right table-vertical-align"><label>作曲：</label></td>
                <td>
                    <input type="text" class="form-control" id="bymusic" name="bymusic" />
                </td>
            </tr>
            <tr>
                <td class="col-md-2 text-right table-vertical-align"><label>编曲：</label></td>
                <td>
                    <input type="text" class="form-control" id="bianqu" name="bianqu" />
                </td>
            </tr>
            <tr>
                <td class="col-md-2 text-right table-vertical-align">合唱：</td>
                <td>
                    <input type="text" class="form-control" id="feat" name="feat" />
                </td>
            </tr>
            <tr>
                <td class="col-md-2 text-right table-vertical-align">备注信息：</td>
                <td>
                    <input type="text" class="form-control" id="notes" name="notes" />
                </td>
            </tr>
            <tr>
                <td class="col-md-2 text-right table-vertical-align">添加文件：</td>
                <td>
                    <input type="file" id="upfile" name="upfile" />
                </td>
            </tr>
            <tr>
                <td class="col-md-2 text-right table-vertical-align">歌词</td>
                <td>
                    <textarea id="songword" name="songword"><?php echo ($song[0]["songword"]); ?></textarea>
                </td>
            </tr>
            <tr>
                <td class="col-md-2 text-right table-vertical-align"> </td>
                <td>
                    <input type="button" class="btn btn-primary" id="btnupload" name="btnupload" value="提交" />
                </td>
            </tr>
        </table>
        <script type="text/javascript">
                var editor;
                KindEditor.ready(function (K) {
                    editor = K.create('#songword', {
                        resizeType: 1,
                        allowPreviewEmoticons: false,
                        allowImageUpload: false,
                        height: '250px',
                        items: [
							'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold', 'italic', 'underline',
							'removeformat', '|', 'justifyleft', 'justifycenter', 'justifyright', 'insertorderedlist',
							'insertunorderedlist', '|', 'emoticons', 'image', 'link']
                    });
                });

                $("#upfile").uploadify({
                    'auto': false,
                    'fileObjName': 'filedata',
                    'formData': {},
                    'buttonText': '上传歌曲',
                    'swf': '/js/uploadify.swf',
                    'fileTypeExts': "*.mp3;*.wma;*.m4a",
                    'uploader': '/apimusic/add_song',
                    'multi': true,
                    'method': 'post',
                    'onInit': function () {

                    },
                    'onSelect': function (file) {
                        var s1 = file.name;
                        $("#songname").val(file.name.substring(0, s1.lastIndexOf('.')));
                    },
                    'onUploadStart': function (file) {
                        var element = {};
                        element.sid = '<?php echo ($sid); ?>';
                        element.aid = "<?php echo ($aid); ?>";
                        element.songname = $("#songname").val();
                        element.byword = $("#byword").val();
                        element.bymusic = $("#bymusic").val();
                        element.bianqu = $("#bianqu").val();
                        element.feat = $("#feat").val();
                        element.notes = $("#notes").val();
                        element.songtype = $("input[name='songtype']:checked").val();
                        //增加歌词添加
                        element.songword = editor.html();
                        $("#upfile").uploadify("settings", "formData", element);
                    },
                    'onUploadSuccess': function (file, data, response) {
                        var jsonVal = eval("(" + data + ")");
                        layer.msg(jsonVal.msg);
                        setTimeout(function () {
                            window.open(window.parent.document.location.href, '_top');
                        }, 1000);
                        //window.open(window.parent.document.location.href, '_top');

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