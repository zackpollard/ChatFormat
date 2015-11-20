<html>
<head>
	<title>ChatFormat API Documentation</title>

	<link rel="stylesheet" type="text/css" href="http://chatformat.com/style/style.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
	<?php include_once("assets/analytics.php") ?>
	<div id="page-wrap">
		<h1>ChatFormat API</h1>
		<div class="chat-section">
			<p>Please note that the documentation is in no way complete.</p>

			<h3>Post a Chat Log</h3>
			<p>In order to post a chat log, send a POST request to <a href="http://api.chatformat.com/submit">http://api.chatformat.com/submit</a> with a paramater named "chat" containing the chat log you would like to send. It will return a JSON string similar to the one below:</p>
			<pre>{
  	"response": {
		"status": "success",
		"hash": "ABCDEFG",
		"url": "http://chatformat.com/ABCDEFG"
  	}
}</pre>
		</div>
</body>
</html>