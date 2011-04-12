<?php
include_once("auth.inc.php");
if(!session_open()){
	header("Location: http://mtl.parkr.me/login");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Expected: Purchases in Montréal</title>
<link href="/img/fleur-de-lis.png" rel="icon" type="image/png">
<link href="/default.css" rel="stylesheet" media="screen">
<script src="http://code.jquery.com/jquery-1.4.4.js" type="text/javascript"></script> 
<script src="/mtl.js" type="text/javascript"></script>
<style type="text/css">
	div#add_expected {
		margin: 0 auto;
		width: 250px;
		text-align: center;
	}
	div#add_expected input, div#add_expected select{
		font-size: 20px;
	}
</style>
</head>

<body>
	<div id="container">
		<h1 align="center">Expected: Purchases in Montréal</h1>
<?php
include_once('db.inc.php');
include_once('functions.inc.php');
if($_GET['action'] == "view"){
	echo "<table width=\"1000\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" id=\"purchases\">";
	$query = "SELECT * FROM `".EXPECTED_TABLE."` ORDER BY `id` DESC";
	$result = mysql_query($query) or die(mysql_error());
	processExpected($result, "\t");
	echo "Viewing.";
	echo "</table>";
}elseif($_GET['action'] == "add"){
	echo "<div id=\"add_expected\">\n";
	echo "<form id=\"add_expected\" method=\"post\" action=\"/expected/submit\">\n";
	echo "\t<select name=\"month\">\n";
	echo "\t\t<option value=\"01\">January</option>\n";
	echo "\t\t<option value=\"02\">February</option>\n";
	echo "\t\t<option value=\"03\">March</option>\n";
	echo "\t\t<option value=\"04\">April</option>\n";
	echo "\t\t<option value=\"05\">May</option>\n";
	echo "\t\t<option value=\"06\">June</option>\n";
	echo "\t\t<option value=\"07\">July</option>\n";
	echo "\t\t<option value=\"08\">August</option>\n";
	echo "\t\t<option value=\"09\">September</option>\n";
	echo "\t\t<option value=\"10\">October</option>\n";
	echo "\t\t<option value=\"11\">November</option>\n";
	echo "\t\t<option value=\"12\">December</option>\n";
	echo "\t</select><br />\n";
	echo "\tItem:<input type=\"text\" name=\"item\"><br />\n";
	echo "\tPurpose:<input type=\"text\" name=\"purpose\"><br />\n";
	echo "\tCost: <input type=\"text\" name=\"cost\"><br />\n";
	echo "\t<input type=\"submit\" value=\"Add\">\n";
	echo "</form>\n";
	echo "</div>\n";
}elseif($_GET['action'] == "submit"){
	echo "Submitting.";
	if($_POST){
		print_r($_POST);
		$query = "INSERT INTO `".EXPECTED_TABLE."` (`id`, `month`, `item`, `purpose`, `cost`) VALUES (NULL, '".$_POST['month']."', '".$_POST['item']."', '".$_POST['purpose']."', '".$_POST['cost']."')";
		mysql_query($query);
		echo "<br/>Completed.";
		$_POST = null;
	}else{
		echo "<br/>You need to submit a form, first.";
	}
	
}

?>
		<div id="jumping"><?php echo jumpMenu(); ?></div>
		<? if($_GET['action'] != "add"):?><div id="addLink" onclick="addExpected()">Add</div><?endif;?>
		<? if($_GET['action'] == "add"):?><div id="addLink" onclick="javascript:window.location='/expected';">Back</div><?endif;?>
	</div>
	<script type="text/javascript"> 
		cufonn();
		repositionAdd();
		repositionJump();
	</script>
</body>
</html>