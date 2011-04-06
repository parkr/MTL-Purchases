<?php
include_once("auth.inc.php");
if(!session_open()){
	header("Location: http://mtl.parkr.me/login");
}
include_once('functions.inc.php');
include_once('db.inc.php');
$has_searched = false;
if($q && !$e){
	$e = null;
	$q = urlencode(mysql_real_escape_string($q));
	$q = urldecode($q);
	if(!$q){
		$q = null;
		$error = "You may not use special characters<br>in your queries. Please try again. (in q)";
	}else{
		// Check for special fields!
		$query = "SELECT * FROM `".PURCHASES_TABLE."` WHERE ";
		$stuff = explode("--", $q);
		$things = array();
		foreach ($stuff as $thing){
			$key = substr($thing, 0, strpos($thing, ":"));
			$value = substr($thing, strpos($thing, ":")+1);
			$things[$key] = $value;
		}
		if(stristr($q, 'from') !== FALSE){
			$id = getBusinessID($things["from"]);
			if($id > 0){
				$query.= ($inserted) ? "AND " : "";
				$query .= "`business_id` = $id ";
				$inserted = true;
			}else{
				$error = "Could not find the business.";
			}
		}
		if(stristr($q, 'after') !== FALSE){
			$datetime = $things["after"];
			$query.= ($inserted) ? "AND " : "";
			$query .= "`datetime` >= '$datetime' ";
			$inserted = true;
		}
		if(stristr($q, 'before') !== FALSE){
			$datetime = $things["before"];
			$query.= ($inserted) ? "AND " : "";
			$query .= "`datetime` <= '$datetime' ";
			$inserted = true;
		}
		if(stristr($q, 'paytype') !== FALSE){
			$paytype = $things["paytype"];
			$query.= ($inserted) ? "AND " : "";
			$query .= "`payment_type` LIKE '$paytype' ";
			$inserted = true;
		}
		if(stristr($q, 'purpose') !== FALSE){
			$purpose = $things["purpose"];
			$query.= ($inserted) ? "AND " : "";
			$query .= "`purpose` LIKE '%{$purpose}%' ";
			$inserted = true;
		}
		if(stristr($q, 'item') !== FALSE){
			$item = $things["item"];
			$query.= ($inserted) ? "AND " : "";
			$query .= "`items` LIKE '%{$item}%' ";
			$inserted = true;
		}
		$query = trim($query).";";
		if(count($stuff) == 1 && stristr($stuff[0], ':') === FALSE){
			$thing = $stuff[0];
			$query = "SELECT * FROM `".PURCHASES_TABLE."` WHERE `items` LIKE '%{$thing}%' OR `purpose` LIKE '%{$thing}%' ORDER BY `datetime` ASC";
			$things["item"] = $thing;
			$things["purpose"] = $thing;
		}
	}
}else{
	if($e=="special_chars"){
		$error = "You may not use special characters<br>in your queries. Please try again.<br>(Your query: '$q')";
	}else{
		$error = "Please enter a query.";
	}
	$q = null;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Search: Purchases in Montréal</title>
<link href="/img/fleur-de-lis.png" rel="icon" type="image/png">
<link href="/default.css" rel="stylesheet" media="screen">
<link href="/search.css" rel="stylesheet" media="screen">
<script src="http://code.jquery.com/jquery-1.5.2.min.js" type="text/javascript"></script> 
<script src="/mtl.js" type="text/javascript"></script>
</head>

<body>
	<div id="container">
		<h1 align="center">Search: Purchases in Montréal</h1>
		<table width="1000" border="0" cellspacing="0" cellpadding="0" id="purchases">
		<?php 
		if($q && !$e){
			if($error && $error != ""){
				show($error);
			}
			$result = mysql_query($query);
			if(mysql_num_rows($result) > 0){
				processPurchases($result, true, "\t\t", true, $things);
				$has_searched = true;
			}else{
				show("Nothing was found.");
				$has_searched = true;
			}
		}else{
			show($error);
		}
		?>
		</table>
		<div id="jumping"><?php echo jumpMenu(); ?></div>
		<div id="instructions_container">
			<span id="instructions_hover">Hover for<br>Instructions</span>
			<div id="instructions">
				You may use one of the following to<br>specify something of that type:
				<ul>
					<li><code>item</code></li>
					<li><code>purpose</code></li>
					<li><code>from</code></li>
					<li><code>after</code></li>
					<li><code>before</code></li>
					<li><code>paytype</code></li>
				</ul>
				<span id="further">
					Follow it with a ':' and the value<br>that you're looking for.<br>
					If you are only looking for an item<br>or purpose, feel free to enter just<br>that, excluding the specifier.
				</span>
			</div>
		</div>
	</div>
	<div id="add" class="hide"></div>
	<div id="searchwrapper"><form method="get" action="/index.php">
	<input type="text" class="searchbox" name="s" value="<?php echo str_replace("--", " ", $q); ?>" />
	<input type="image" src="/img/magnifying_glass.png" class="searchbox_submit" value="" />
	</form></div>
	<div id="back_button"><a href="/search">&larr;Back</a></div>
<script type="text/javascript"> 
	repositionAdd();
	repositionJump();
	repositionSearch("search");
	<?php if($has_searched){echo "\tback_to_search();";} ?>
	right_instructions();
</script>
</body>
</html>