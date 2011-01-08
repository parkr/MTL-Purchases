<?php

include_once("db.inc.php");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>Test Ajax</title>
	<meta name="generator" content="TextMate http://macromates.com/">
	<meta name="author" content="Parker Moore">
	<!-- Date: 2011-01-08 -->
	<script src="http://code.jquery.com/jquery-1.4.4.js" type="text/javascript"></script> 
	<script type="text/javascript">
	function submit(){
		var string = $("#string").text();
		var text = $("#text").val();
		$.ajax({
			type: 'POST',
			url: 'test_add.php',
			data: 'string='+string+'&text='+text,
			success: function(msg){
				if(msg){
			    	$("#results").append(msg);
				}else{
					$("#results").append("Success!");
				}
			}
		});
	}
	function submitAlert(){
		var string = $("#string").val();
		var text = $("#text").val();
		alert(string + " " + text);
	}
	</script>
</head>
<body>
	<div id="results"></div>
	<div id="form">
		<form onsubmit="submitAlert()">
			<input type='text' name='string' id='string'><br />
			<textarea cols="45" rows="5"></textarea>
			<input type='submit' value='Test'>
		</form>
	</div>
</body>
</html>