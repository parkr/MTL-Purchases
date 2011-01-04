<?php
if(!isset($_COOKIE["loggedin"])){
	header("Location: http://mtl.parkr.me/login");
}
include_once('functions.inc.php');
include_once('db.inc.php');
if($q){
	if($q == "asc"){
		$q = false;
		$query = "SELECT * FROM `".PURCHASES_TABLE."` ORDER BY `datetime` ASC";
	}elseif($q == "after"){
		$q = false;
		$purchase = getPurchase($purchase_id);
		$datetime = $purchase['datetime'];
		$query = "SELECT * FROM `".PURCHASES_TABLE."` WHERE `datetime` >= '$datetime' ORDER BY `datetime` ASC";
	}elseif($q == "before"){
		$q = false;
		$purchase = getPurchase($purchase_id);
		$datetime = $purchase['datetime'];
		$query = "SELECT * FROM `".PURCHASES_TABLE."` WHERE `datetime` <= '$datetime' ORDER BY `datetime` ASC";
	}elseif($q == "fall2010"){
		$q = false;
		$beginning = "2010-08-20 00:00:00";
		$end = "2011-01-01 00:00:00";
		$query = "SELECT * FROM `".PURCHASES_TABLE."` WHERE `datetime` >= '$beginning' AND `datetime` <= '$end' ORDER BY `datetime` ASC";
	}elseif($q == "winter2011"){
		$q = false;
		$beginning = "2011-01-02 00:00:00";
		$end = "2011-04-28 00:00:00";
		$query = "SELECT * FROM `".PURCHASES_TABLE."` WHERE `datetime` >= '$beginning' AND `datetime` <= '$end' ORDER BY `datetime` ASC";
	}
}else{
	$q = false;
	$query = "SELECT * FROM `".PURCHASES_TABLE."` ORDER BY `datetime` DESC";
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Purchases in Montréal</title>
<link href="default.css" rel="stylesheet" media="screen">
<script src="http://code.jquery.com/jquery-1.4.4.js" type="text/javascript"></script> 
<script src="/mtl.js" type="text/javascript"></script>
</head>

<body>
	<div id="container">
		<h1 align="center">Purchases in Montréal</h1>
		<table width="1000" border="0" cellspacing="0" cellpadding="0" id="purchases">
		<?php 
			processPurchases(mysql_query($query), true, "\t\t");
		?>
		</table>
		<div id="jumping"><?php echo jumpMenu(); ?></div>
		<div id="addLink"><a onclick="add();">Add</a></div>
	</div>
<script type="text/javascript"> 
	repositionAdd();
	repositionJump();
</script>
</body>
</html>