<?php
if(!isset($_COOKIE["PHPSESSID"])){
	header("Location: http://mtl.parkr.me/login");
}
include_once("db.inc.php");
include_once("functions.inc.php");

if(isset($_POST['place_name']) && $_POST['place_name'] != ""){
	addBusiness($_POST);
}else{
	// Web form time!
	foreach ($_POST as $key => $value) { 
		$_POST[$key] = mysql_real_escape_string($value); 
	}
	foreach ($_GET as $key => $value){
		$_GET[$key] = mysql_real_escape_string($value);
	}
	 if(isset($_GET['new'])): ?>
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Add Business</title>
	<link href="/img/fleur-de-lis.png" rel="icon" type="image/png">
	<link href="/default.css" rel="stylesheet" media="screen">
	<script src="http://code.jquery.com/jquery-1.4.4.js" type="text/javascript"></script> 
	<script src="/mtl.js" type="text/javascript"></script>
	</head>

	<body><div id="container"><h1 align="center">Add Purchase</h1><form method="post" name="inputform" id="inputform" action="/submit">
	<input name="action" type="hidden" value="add_business" />
		Name<br /><input type='text' name='place_name' id='place_name' style='font-size:18px;padding:10px' cols="50"><br />
		Address<br /><textarea cols='45' rows='5' id='address' name='address' style='font-size:18px;padding:10px'></textarea><br />
		Phone Number<br /><input type='text' name='phone' id='phone' style='font-size:18px;padding:10px' value="+1" cols="50"><br />
		<input type='submit' value='Add Business' style='font-size:18px;padding:10px'>
	</form>
	</div>
	<div id="return"><a href="/">Return</a></div>
	<script type="text/javascript">
		repositionReturn();
	</script>
	</body>
	</html>
	<?php endif;
	if(isset($_GET['edit'])): ?>
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Edit Business</title>
	<link href="/img/fleur-de-lis.png" rel="icon" type="image/png">
	<link href="/default.css" rel="stylesheet" media="screen">
	<script src="http://code.jquery.com/jquery-1.4.4.js" type="text/javascript"></script> 
	<script src="/mtl.js" type="text/javascript"></script>
	</head>
	<?php $business = getBusiness($_GET['edit']); ?>

	<body><div id="container"><h1 align="center">Edit Purchase</h1><form action="/submit" method="post" name="inputform" id="inputform">
		<input name="id" type="hidden" value="<?php echo $business['id']; ?>" />
		<input name="action" type="hidden" value="edit_business" />
		Name<br /><input type='text' name='place_name' id='place_name' style='font-size:18px;padding:10px' cols="50" value="<?php echo $business['place_name']; ?>"><br />
		Address<br /><textarea cols='45' rows='5' id='address' name='address' style='font-size:18px;padding:10px'><?php echo $business['address']; ?></textarea><br />
		Phone Number<br /><input type='text' name='phone' id='phone' style='font-size:18px;padding:10px' value="+1" cols="50" value="<?php echo $business['phone']; ?>"><br />
		<input type='submit' value='Edit Business' style='font-size:18px;padding:10px'>
	</form>
	</div>
	<div id="return"><a href="/">Return</a></div>
	<script type="text/javascript">
		repositionReturn();
	</script>
	</body>
	</html>
	<?php endif; ?>	

	<?php
} ?>