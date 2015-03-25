<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>

	<p id="a"></p>

	<?php include('includes/scripts.include.php'); ?>

	<script type="text/javascript">
		qnum = 1;
		anum = 1;
		function generateAnswer(){
			var div = document
			questionid = "q" + qnum;
			anum += 1;
			answerid = questionid + "a" + anum;
			var g = document.createElement("label");
			g_html = $(g).addClass("col-md-4")
			.addClass("control-label")
			.attr('for', answerid)
			.html();

			alert(g_html);

			var f = document.createElement("div");
			$(f).addClass("form-group")
			.addClass("disabled")
			.append(g_html);

			return $(f).html();
		}

		alert(generateAnswer());
	</script>

</body>
</html>