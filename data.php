<?php
if(!isset($_COOKIE["loggedin"])){
	header("Location: http://mtl.parkr.me/login");
}
include_once('functions.inc.php');
include_once('db.inc.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="author" content="Parker Moore">
	<title>Purchases in Montréal</title>
	<link href="/default.css" rel="stylesheet" media="screen" />
	<script src="http://code.jquery.com/jquery-1.4.4.js" type="text/javascript"></script>
	<script src="/mtl.js" type="text/javascript"></script>
</head>
<body>
	<div id="container">
		<header><a href="/" id="data_logo"><img src="/data.png" height="154" width="234" border="0"></a></header>
		<section class="small_box" id="total_spent"><!-- Total Spent --></section>
		<section class="small_box"><!-- Average Spent (Per Day) --></section>
		<section class="small_box"><!-- Top Reasons --></section>
		<section class="small_box"><!-- Top Items --></section>
		<section class="small_box"><!-- Top Businesses --></section>
		<section class="small_box"><!-- Top Payment Types --></section>
		<section class="large_box"><!-- Graph of Spending By Date --></section>
	</div>
	<script type="text/javascript">
	<!--
		alert($("#data_logo").width);
		$("#data_logo").css('position', 'absolute');
		$("#data_logo").css('left', $("#container").offset().left+($("#data_logo").width/2));
		$("#data_logo").css('top', 10);
		$("#data_logo").css('font-size', 30);
	// -->
	</script>
</body>
</html>
