<?php

include_once("db.inc.php");

$string = $_POST['string'];
$text = $_POST['text'];

mysql_query("INSERT INTO `test` (`string`, `text`) VALUES ('$string', '$text')") or die(mysql_error());

?>