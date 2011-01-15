<?php
if(!isset($_COOKIE["loggedin"])){
	header("Location: http://mtl.parkr.me/login");
}
include_once('functions.inc.php');
include_once('db.inc.php');
function getTotalSpent(){
	$total_spent = 0.0;
	$result = mysql_query("SELECT `amount` FROM `".PURCHASES_TABLE."`");
	for($i=0; $i<mysql_num_rows($result); $i++){
		$total_spent += mysql_result($result, $i, 'amount');
	}
	return $total_spent;
}
$total_spent = getTotalSpent();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="author" content="Parker Moore">
	<title>Purchases in Montréal</title>
	<link href="/default.css" rel="stylesheet" media="screen" />
	<style type="text/css">
		body {
			background-color:rgba(242, 226, 5, 0.5);
		}
		#background {
			position:absolute;
			top:0;
			left:0;
			background-image:url('/pinstripes.png');
			filter:alpha(opacity=20);
			height:100%;
			min-height:1000px;
			width:100%;
			opacity:.30;
		}
		.small_box {
			width:400px;
			padding:10px;
			background-color:rgba(242, 226, 5, 0.5);
			margin:5px;
			float:left;
			height:300px;
			font-size:64px;
			text-align:center;
		}
		#clear {
			padding:0;
			margin:0;
			top:200px;
		}
		#data_logo {
			margin: 0 auto;
			width:234px;
		}
	</style>
	<script src="http://code.jquery.com/jquery-1.4.4.js" type="text/javascript"></script>
	<script src="/mtl.js" type="text/javascript"></script>
</head>
<body>
	<div id="background">&nbsp;</div>
	<div id="container" style="width:860px;z-index:1">
		<header id="data_logo"><a href="/"><img src="/data.png" height="154" width="234" border="0"></a></header>
		<section id="clear">
			<section class="small_box" id="total_spent">
				$<?php echo $total_spent."\n"; ?>
			</section><!-- Total Spent -->
			<section class="small_box" id="average_spent"><!-- Average Spent (Per Day) --></section>
			<section class="small_box" id="top_reasons"><!-- Top Reasons --></section>
			<section class="small_box" id="top_items"><!-- Top Items --></section>
			<section class="small_box" id="top_businesses"><!-- Top Businesses --></section>
			<section class="small_box" id="top_payment_types"><!-- Top Payment Types --></section>
			<section class="large_box" id="spending_by_date"><!-- Graph of Spending By Date --></section>
		</section>
	</div>
	<script type="text/javascript">
	<!--
		//$("#clear").css('top', 200);
	// -->
	</script>
</body>
</html>
