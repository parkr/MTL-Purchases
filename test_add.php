<?php

include_once("db.inc.php");

$post_contents = "";
foreach($_POST as $key => $val){
	$post_contents .= "[$key=>$val]";
}
$get_contents = "";
foreach($_GET as $key => $val){
	$get_contents .= "[$key=>$val]";
}

$type = 'POST';
$string = addslashes(htmlspecialchars($_POST['string']));
$text = addslashes(htmlspecialchars($_POST['text']));
if($string=="" && $text==""){
	$type = 'GET';
	$string = addslashes(htmlspecialchars($_GET['string']));
	$text = addslashes(htmlspecialchars($_GET['text']));
	$_GET = null;
}

mysql_query("INSERT INTO `test` (`type`, `string`, `text`, `get_contents`, `post_contents`) VALUES ('$type', '$string', '$text', '$get_contents', '$post_contents')") or die(mysql_error());

?>