<?php

include_once("db.inc.php");

$place_name = $_POST['place_name'];
$address = $_POST['address'];
$phone = $_POST['phone'];
if($phone == "+1"){
	$phone = "";
}

if($phone == "" || $address == ""){
	if($phone == "" && $address == ""){
		mysql_query("INSERT INTO `montreal_businesses` (`place_name`, `address`, `phone`) VALUES ('$place_name', NULL, NULL)") or die(mysql_error());
	}elseif($phone == "" && $address != ""){
		mysql_query("INSERT INTO `montreal_businesses` (`place_name`, `address`, `phone`) VALUES ('$place_name', '$address', NULL)") or die(mysql_error());
	}elseif($phone != "" && $address == ""){
		mysql_query("INSERT INTO `montreal_businesses` (`place_name`, `address`, `phone`) VALUES ('$place_name', NULL, '$phone')") or die(mysql_error());
	}
}else{
	mysql_query("INSERT INTO `montreal_businesses` (`place_name`, `address`, `phone`) VALUES ('$place_name', '$address', '$phone')") or die(mysql_error());
}

?>