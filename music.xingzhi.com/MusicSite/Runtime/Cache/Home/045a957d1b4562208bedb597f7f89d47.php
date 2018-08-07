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
            <tbody>
                <tr>
                    <td class="col-md-2 text-right table-vertical-align">歌曲名称：</td>
                    <td>
                        <input type="text" class="form-control" id="songname" name="songname" value="<?php echo ($song[0]["songname"]); ?>" />
                    </td>
                </tr>
                <tr>
                    <td class="col-md-2 text-right table-vertical-align">作词：</td>
                    <td>
                        <input type="text" class="form-control" id="byword" name="byword" value="<?php echo ($song[0]["byword"]); ?>" />
                    </td>
                </tr>
                <tr>
                    <td class="col-md-2 text-right table-vertical-align">作曲：</td>
                    <td>
                        <input type="text" class="form-control" id="bymusic" name="bymusic" value="<?php echo ($song[0]["bymusic"]); ?>" />
                    </td>
                </tr>
                <tr>
                    <td class="col-md-2 text-right table-vertical-align">编曲：</td>
                    <td>
                        <input type="text" class="form-control" id="bianqu" name="bianqu" value="<?php echo ($song[0]["bianqu"]); ?>" />
                    </td>
                </tr>
                <tr>
                    <td class="col-md-2 text-right table-vertical-align">组合/合唱：</td>
                    <td>
                        <input type="text" class="form-control" id="feat" name="feat" value="<?php echo ($song[0]["feat"]); ?>" />
                    </td>
                </tr>
                <tr>
                    <td class="col-md-2 text-right table-vertical-align">备注信息：</td>
                    <td>
                        <input type="text" class="form-control" id="notes" name="notes" col='50' value="<?php echo ($song[0]["notes"]); ?>" />
                    </td>
                </tr>
                <tr>
                    <td class="col-md-2 text-right table-vertical-align">歌词</td>
                    <td>
                        <textarea id="songword" name="songword"><?php echo ($song[0]["songword"]); ?></textarea>
                    </td>
                </tr>
                <tr>
                    <td class="col-md-2 text-right table-vertical-align"></td>
                    <td>
                        <input type="button" class="btn btn-primary" id="btnupload" name="btnupload" value="确认更新" />
                    </td>
                </tr>
            </tbody>
        </table>
        <script type="text/javascript">
	            var editor;
				KindEditor.ready(function(K) {
						editor = K.create('#songword', {
						resizeType : 1,
						allowPreviewEmoticons : false,
						allowImageUpload : false,
						height: '250px',
						items : [
							'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold', 'italic', 'underline',
							'removeformat', '|', 'justifyleft', 'justifycenter', 'justifyright', 'insertorderedlist',
							'insertunorderedlist', '|', 'emoticons', 'image', 'link']
					});
				});

				//修改歌曲操作.
                $("#btnupload").click(function () {
                    $.post("/api/editsong",
                            {
                                op: "edit",
                                songid: "<?php echo ($songid); ?>",
                                songname: $("#songname").val(),
                                byword: $("#byword").val(),
                                bymusic: $("#bymusic").val(),
                                bianqu: $("#bianqu").val(),
                                feat: $("#feat").val(),
                                notes: $("#notes").val(),
                                songword: editor.html()
                            },
                            function (data) {
                                var json = eval("(" + data + ")");
                                if (json.result > 0) {
                                    window.open(window.parent.document.location.href, '_top');
                                }
                            });
                });
        </script>
    </div>
</body>
</html>