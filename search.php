<?php
if(!isset($_COOKIE["loggedin"])){
	header("Location: http://mtl.parkr.me/login");
}
include_once('functions.inc.php');
include_once('db.inc.php');
if($q){
	$q = urlencode(mysql_real_escape_string($q));
	$q = urldecode($q);
	$query = "SELECT * FROM `".PURCHASES_TABLE."` WHERE `items` LIKE '%{$q }%' ORDER BY `datetime` ASC";
}else{
	$error = "Please enter a query.";
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Search: Purchases in Montréal</title>
<link href="/default.css" rel="stylesheet" media="screen">
<script src="http://code.jquery.com/jquery-1.4.4.js" type="text/javascript"></script> 
<script src="/mtl.js" type="text/javascript"></script>
</head>

<body>
	<div id="container">
		<h1 align="center">Search: Purchases in Montréal</h1>
		<table width="1000" border="0" cellspacing="0" cellpadding="0" id="purchases">
		<?php 
		if($q){
			$result = mysql_query($query);
			if(mysql_num_rows($result) > 0){
				processPurchases($result, true, "\t\t", true, "$q");
			}else{
				show("Nothing was found.");
			}
		}else{
			echo $error;
		}
		?>
		</table>
		<div id="jumping"><?php echo jumpMenu(); ?></div>
	</div>
	<div id="add" class="hide"></div>
	<div id="searchwrapper"><form method="get" action="/index.php">
	<input type="text" class="searchbox" name="s" value="<?php echo $q ?>" />
	<input type="image" src="/magnifying_glass.png" class="searchbox_submit" value="" />
	</form></div>
<script type="text/javascript"> 
	repositionAdd();
	repositionJump();
	repositionSearch("search");
</script>
</body>
</html>