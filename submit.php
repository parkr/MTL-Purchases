<?php

include "db.inc.php";
include "functions.inc.php";
if(isset($_POST)){
	foreach ($_POST as $key => $value) { 
		$_POST[$key] = mysql_real_escape_string($value); 
	}
	if($_POST['action'] == "add"){
		addToDatabase($_POST);
	}elseif($_POST['action'] == "edit"){
		updateInDatabase($_POST);
	}elseif($_POST['action'] == "add_business"){
		addBusiness($_POST);
	}elseif($_POST['action'] == "edit_business"){
		updateBusiness($_POST);
	}elseif($_POST['action'] == "delete"){
		deletePurchase($_POST);
	}else{
		echo "There was a problem with your request.";
	}
}

?>