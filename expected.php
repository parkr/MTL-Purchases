<?php
include_once("auth.inc.php");
if(!session_open()){
	header("Location: http://mtl.parkr.me/login");
}
if($_GET['commit']){
	$redirect = "Location: /add/".$_GET['commit'];
	header($redirect);
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
	div#form_expected {
		margin: 0 auto;
		width: 250px;
		text-align: center;
	}
	div#form_expected input, div#form_expected select{
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
	echo "</table>";
}elseif($_GET['action'] == "add"){
	printExpectedForm();
}elseif($_GET['action'] == "submit"){
	if($_POST){
		if($_POST['action'] == "add"){
			echo "Submitting...";
			$query = "INSERT INTO `".EXPECTED_TABLE."` (`id`, `month`, `item`, `purpose`, `cost`) VALUES ";
			$query .= "(NULL, '".$_POST['month']."', '".$_POST['item']."', '".$_POST['purpose']."', '".$_POST['cost']."')";
			mysql_query($query) or die(mysql_error());
			echo "done.";
			returnInThree("/expected");
		}elseif($_POST['action'] == "edit"){
			echo "Updating...";
			$query = "UPDATE `".EXPECTED_TABLE."` SET `purpose` = '".$_POST['purpose']."', `month`='".$_POST['month']."', `item`='".$_POST['item']."', `cost`=".$_POST['cost']." WHERE `id`=".$_POST['id'];
			mysql_query($query) or die(mysql_error());
			echo "done.";
			returnInThree("/expected");
		}else{
			echo "<br />Error.";
		}
		$_POST = null;
	}else{
		echo "You need to submit a form, first.";
	}
}elseif($_GET['edit'] && $_GET['edit'] != ""){
	printExpectedForm($_GET['edit']);
}elseif($_GET['delete'] && $_GET['delete'] != ""){
	echo "Deleting...";
	$query = "DELETE FROM `".EXPECTED_TABLE."` WHERE `id`=".$_GET['delete'];
	mysql_query($query) or die(mysql_error());
	echo "done.";
	returnInThree("/expected");
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