<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>{$meta->retrieve('title', ' :) ')|escape}</title>
		<meta name="description" content="{$meta->retrieve('description', ', ')|escape}">
		<meta name="keywords" content="{$meta->retrieve('keywords', ', ')|escape}">
		{$meta->retrieve('js')}
		{$meta->retrieve('css')}
	</head>
	<body>
		<h1>So it works :)</h1>
	</body>
</html>
