<?php if (!defined('THINK_PATH')) exit();?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Insert title here</title>
<script charset="utf-8" src="/kindeditor/kindeditor-all-min.js"></script>
<script charset="utf-8" src="/kindeditor/lang/zh-CN.js"></script>
</head>
<body>
	<textarea id="editor_id" name="content"
		style="width: 700px; height: 300px;">

</textarea>
	<script>
        KindEditor.ready(function(K) {
                window.editor = K.create('#editor_id');
        });
</script>
</body>
</html>