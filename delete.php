<?php
include_once("functions.inc.php");
$id = $_GET['id'];

?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"
   "http://www.w3.org/TR/html4/strict.dtd">

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="author" content="Parker Moore">
	<title>Delete: Purchases in Montreal</title>
	<link href="/fleur-de-lis.png" rel="icon" type="image/png">
	<link href="/default.css" rel="stylesheet" media="screen">
	<script src="http://code.jquery.com/jquery-1.4.4.js" type="text/javascript"></script> 
	<script src="/mtl.js" type="text/javascript"></script>
</head>
<body>
	<div id="container"> 
		<h1 align="center">Purchases in Montréal</h1>
		<? printPurchase($id); ?>
		<form action="/submit" method="post" id="deleteform">
			<input type="hidden" name="action" value="delete">
			<input type="hidden" name="id" value="<? echo $id; ?>">
			<input type="submit" name="submit" id="delete" value="Delete">
		</form>
	</div>
	<script type="text/javascript">
		cufonn();
	</script>
</body>
</html>
