<?php
include('db.inc.php');
if(isset($_COOKIE["loggedin"])){
	header("Location: http://mtl.parkr.me");
}else{
	if(isset($_POST['username']) && isset($_POST['password'])){
		if($_POST['username'] == USERNAME && $_POST['password'] == USERPASS){
			setcookie("loggedin", "true", time()+(60*60*12));
			header("http://mtl.parkr.me/login");
		}else{
			$error = "<h3>Username/Password was incorrect</h3>";
		}
	}else{ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>Log In: Montreal</title>
	<meta name="author" content="Parker Moore">
	<link href="default.css" rel="stylesheet" media="screen">
	<script src="http://code.jquery.com/jquery-1.4.4.js" type="text/javascript"></script> 
	<script src="/mtl.js" type="text/javascript"></script>
	<!-- Date: 2010-12-27 -->
</head>
<body>
	<div id="container">
		<h1>Log In</h1>
		<?php echo isset($error) ? $error : ""; ?>
		<form action="/login" method="post"><input name="username" type="text" /><input name="password" type="password" /><input type="submit"></form>
	</div>
</body>
</html>
	
<?php }} ?>