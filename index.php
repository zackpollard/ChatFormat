<html>
<head>
	<title>ChatFormat</title>

	<link rel="stylesheet" type="text/css" href="https://chatformat.com/style/style.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
	<?php include_once("assets/analytics.php") ?>
	<div id="page-wrap">
		<h1>ChatFormat</h1>
		<div id="validation"></div>
		<form action="submit.php" method="post" onsubmit="return validateForm()" id="form">
			<textarea name="chat" placeholder="Paste your conversation here" id="text"></textarea>
			<input type="submit" value="Format!">
			<label>*Note: By clicking the button above, you agree to our <a href="https://chatformat.com/terms">Terms of Use</a> and <a href="https://chatformat.com/privacy">Privacy Policy</a>.</label>
		</form>
		<?php include_once("assets/footer.php"); ?>
	</div>
	<script type="text/javascript" src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
	<script type="text/javascript">
		function validateForm() {
			var x = $("#text").val();
			if (x == null || x == "") {
				$(".error").remove();
				$("#validation").append('<div class="error">Please paste your log into the text field.</div>');
				$(".error").delay(2000).fadeOut(800);
				return false;
			}
		}
	</script>
</body>
</html>