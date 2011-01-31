<?php
include('db.inc.php');
if(isset($_COOKIE["loggedin"])){
	header("Location: http://mtl.parkr.me");
}else{
	if(isset($_POST['username']) && isset($_POST['password'])){
		if($_POST['username'] == USERNAME && $_POST['password'] == USERPASS){
			setcookie("loggedin", "true", time()+(60*60*12)); // 12 hours
			header("http://mtl.parkr.me");
		}else{
			$error = "<h3>Username/Password was incorrect</h3>";
		}
	}else{ ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<meta name="author" content="Parker Moore">
	<title>Log In: Montreal</title>
	<link href="/login.css" rel="stylesheet" media="screen">
	<!-- Date: 2010-12-27 -->
</head>
<body>
	<div id="container">
		<h1>Log In</h1>
		<?php echo isset($error) ? $error : ""; ?>
		<form action="/login" method="post">
			<input name="username" type="text">
			<input name="password" type="password">
			<input type="submit">
		</form>
	</div>
</body>
</html>
	
<?php }} ?>
