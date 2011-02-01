<?php
include('db.inc.php');
include('auth.inc.php');
if(isset($_GET['action'])){
	if($_GET['action'] == "logout"){
		logout();
		?>
			<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
			<html>
			<head>
				<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
				<meta http-equiv="Cache-Control" content="public, must-revalidate">
				<!--<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">-->
				<meta name="author" content="Parker Moore">
				<title>Log Out: Montreal</title>
				<link href="/fleur-de-lis.png" rel="icon" type="image/png">
				<link href="/login.css" rel="stylesheet" media="screen">
				<script type="text/javascript" src="cookies.js"></script>
			</head>
			<body>
				<div id="container">
					<h1>Success</h1>
					<p>You have successfully been logged out.</p>
					<p>Change your mind? <a href="/login">Log back in.</a></p>
				</div>
				<script type="text/javascript">
					delete_cookie("PHPSESSID", "/" , "mtl.parkr.me");
				</script>
			</body>
			</html>
		<?php
	}elseif($_GET['action'] == "login"){
		if(session_open()){
			header("Location: http://mtl.parkr.me");
		}else{
			if(isset($_POST['username']) && isset($_POST['password'])){
				if(login($_POST['username'], $_POST['password'])){
					?><script>window.location="/";</script><?php
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
			<link href="/fleur-de-lis.png" rel="icon" type="image/png">
			<link href="/login.css" rel="stylesheet" media="screen">
			<script type="text/javascript" src="cookies.js"></script>
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
			<script type="text/javascript">
				if(get_cookie("PHPSESSID")) window.location = '/';
			</script>
		</body>
		</html>

		<?php 
				}
			}
	}
}?>
