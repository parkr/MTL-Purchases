<?php
# Returns one data set for one purchase.
function getPurchase($purchase_id){
	include_once('db.inc.php');
	$purchase = array();
	$result = mysql_query("SELECT * FROM `".PURCHASES_TABLE."` WHERE `id` = ".$purchase_id);
	if(is_resource($result)){
		$purchase['id'] = mysql_result($result, 0, 'id');
		$purchase['datetime'] = mysql_result($result, 0, 'datetime');
		$purchase['business'] = getBusiness(mysql_result($result, 0, 'business_id'));
		$purchase['payment_type'] = mysql_result($result, 0, 'payment_type');
		$purchase['card'] = mysql_result($result, 0, 'card');
		$purchase['currency'] = mysql_result($result, 0, 'currency');
		$purchase['amount'] = mysql_result($result, 0, 'amount');
		$purchase['purpose'] = mysql_result($result, 0, 'purpose');
		$purchase['items'] = mysql_result($result, 0, 'items');
		$purchase['actions'] = array('edit' => '/edit:'.$purchase['id'], 'delete' => '', 'after' => '/after:'.$purchases[$j]['id'], 'before' => '/before:'.$purchases[$j]['id'], 'delete' => '/delete:'.$purchase['id']);
	}
	return $purchase;
}

function printPurchase($id = null){
	if($id == null){
		echo "You need to input an id number before you can retrieve any purchases.";
	}else{
		$baseTab = "\t";
		$purchase = getPurchase($id);
		$output = '<table width="1000" border="0" cellspacing="0" cellpadding="0" id="purchases">';
		$output .= ("<tr class='actions'>\n".$baseTab."\t<th scope=\"col\" width='100'>datetime</th>\n".$baseTab."\t<th scope=\"col\">business</th>\n".$baseTab."\t<th scope=\"col\">payment type</th>\n".$baseTab."\t<th scope=\"col\">card</th>\n".$baseTab."\t<th scope=\"col\">currency</th>\n".$baseTab."\t<th scope=\"col\">amount</th>\n".$baseTab."\t<th scope=\"col\">purpose</th>\n".$baseTab."\t<th scope=\"col\">items</th>\n".$baseTab."</tr>\n");
		$output .= ($baseTab . "<tr".($p%2!=0 ? " class='altrow'" : "").">\n");
		$output .= ($baseTab . "\t<td>" . formatDate($purchase['datetime'])."</td>\n");
		$output .= ($baseTab . "\t<td>" . $purchase['business']['place_name']."</td>\n");
		$output .= ($baseTab . "\t<td>" . $purchase['payment_type']."</td>\n");
		$output .= ($baseTab . "\t<td>" . $purchase['card']."</td>\n");
		$output .= ($baseTab . "\t<td>" . $purchase['currency']."</td>\n");
		$output .= ($baseTab . "\t<td>$". $purchase['amount']."</td>\n");
		$output .= ($baseTab . "\t<td>" . $purchase['purpose']."</td>\n");
		$output .= ($baseTab . "\t<td>" . $purchase['items']."</td>\n");
		$output .= ($baseTab . "</tr>\n");
		$output .= "</table>";
		echo $output;
	}
}


# $result is a mysql result
# returns array ($purchases[$i]['field_name']) with all purchases from that result
function processPurchases($result, $stringTableFormat = false, $baseTab = "", $search = false, $searched= array()){
	/*
	1. Check if $result is valid mysql result
	2. Create array
	3. Iterate through each row, separating the data into the sub-array
	4. Output the array */
	if(is_resource($result)){
		$total = 0.0;
		$purchases = array();
		for($j=0; $j<mysql_num_rows($result); $j++){
			$purchases[$j]['id'] = mysql_result($result, $j, 'id');
			$purchases[$j]['datetime'] = mysql_result($result, $j, 'datetime');
			$purchases[$j]['business'] = getBusiness(mysql_result($result, $j, 'business_id'));
			$purchases[$j]['payment_type'] = mysql_result($result, $j, 'payment_type');
			$purchases[$j]['card'] = mysql_result($result, $j, 'card');
			$purchases[$j]['currency'] = mysql_result($result, $j, 'currency');
			$purchases[$j]['amount'] = mysql_result($result, $j, 'amount');
			if($search){
				$purchases[$j]['purpose'] = highlight($searched["purpose"], mysql_result($result, $j, 'purpose'));
				$purchases[$j]['items'] = highlight($searched["item"], mysql_result($result, $j, 'items'));
				$total += $purchases[$j]['amount'];
			}else{
				$purchases[$j]['purpose'] = mysql_result($result, $j, 'purpose');
				$purchases[$j]['items'] = mysql_result($result, $j, 'items');
			}
			$purchases[$j]['actions'] = array('edit' => '/edit:'.$purchases[$j]['id'], 'delete' => '', 'after' => '/after:'.$purchases[$j]['id'], 'before' => '/before:'.$purchases[$j]['id'], 'delete' => '/delete:'.$purchases[$j]['id']);
		}
		if($stringTableFormat){
			$output = "";
			$output .= ("<tr class='actions'>\n".$baseTab."\t<th scope=\"col\" width='100'>datetime</th>\n".$baseTab."\t<th scope=\"col\">business</th>\n".$baseTab."\t<th scope=\"col\">payment type</th>\n".$baseTab."\t<th scope=\"col\">card</th>\n".$baseTab."\t<th scope=\"col\">currency</th>\n".$baseTab."\t<th scope=\"col\">amount</th>\n".$baseTab."\t<th scope=\"col\">purpose</th>\n".$baseTab."\t<th scope=\"col\">items</th>\n".$baseTab."\t<th scope=\"col\">actions</th>\n".$baseTab."</tr>\n");
			for($p=0; $p<count($purchases); $p++){
				$output .= ($baseTab . "<tr".($p%2!=0 ? " class='altrow'" : "").">\n");
				$output .= ($baseTab . "\t<td><a href='".$purchases[$p]['actions']['edit']."' title='Edit'>" . formatDate($purchases[$p]['datetime'])."</a></td>\n");
				$output .= ($baseTab . "\t<td>" . $purchases[$p]['business']['place_name']."</td>\n");
				$output .= ($baseTab . "\t<td>" . $purchases[$p]['payment_type']."</td>\n");
				$output .= ($baseTab . "\t<td>" . $purchases[$p]['card']."</td>\n");
				$output .= ($baseTab . "\t<td>" . $purchases[$p]['currency']."</td>\n");
				$output .= ($baseTab . "\t<td>$". $purchases[$p]['amount']."</td>\n");
				$output .= ($baseTab . "\t<td>" . $purchases[$p]['purpose']."</td>\n");
				$output .= ($baseTab . "\t<td>" . $purchases[$p]['items']."</td>\n");
				$output .= ($baseTab . "\t<td>" . formatActions($purchases[$p]['actions'])."</td>\n");
				$output .= ($baseTab . "</tr>\n");
			}
			if($search){
				$output .= ($baseTab . "<tr".($p%2!=0 ? " class='altrow'" : "").">\n");
				$output .= ($baseTab . "<td></td>\n<td></td>\n<td></td>\n<td></td>\n");
				$output .= ($baseTab . "\t<td>Total:</td>\n");
				$output .= ($baseTab . "\t<td>$$total</td>\n");
				$output .= ($baseTab . "<td></td>\n<td></td>\n<td></td>\n");
				$output .= ($baseTab . "</tr>\n");
			}
			echo $output;
		}else{
			return $purchases;
		}
	}else{
		return "There was an error processing your request. Error: (#1) Resource result is not valid.";
	}
}

# formats the date from the MySQL DATETIME format a more readable version
# e.g. "2010-10-10 10:10:10" is converted to "Oct, 10"
function formatDate($date){
	$year = substr($date, 0, 4);
	$month = substr($date, 5, 2);
	$day = substr($date, 8, 2);
	//echo "$year-$month-$day";
	return date("M, j", mktime(0,0,0,$month,$day,$year));
}

# returns today's date in YYYY-MM-DD format
function getCurrDate(){
	return date("Y-m-d");
}

# returns string output of links for actions
function formatActions($actions){
	$actionOutput = "";
	$actionOutput .= '<a href="'.$actions['before'].'" alt="view transactions before this one" title="view transactions before this one">&laquo;</a> ';
	//$actionOutput .= '<a href="'.$actions['edit'].'" alt="edit this transaction" title="edit this transaction">edit</a> ';
	$actionOutput .= '<a href="'.$actions['delete'].'">&times;</a> ';
	$actionOutput .= '<a href="'.$actions['after'].'" alt="view transactions after this one" title="view transactions after this one">&raquo;</a>';
	return $actionOutput;
}

# returns an array of the 4 different payment options, each containing a string.
# whichever payment is selected (in the database) will return the string 'checked = "checked"' for the form item
# for the edit page
function getSelectedPayment($payment_type){
	$selected = array();
	$selected['CASH'] = ($payment_type == "CASH" ? " checked=\"checked\"" : "");
	$selected['CREDIT'] = ($payment_type == "CREDIT" ? " checked=\"checked\"" : "");
	$selected['DEBIT'] = ($payment_type == "DEBIT" ? " checked=\"checked\"" : "");
	$selected['CREDIT/CASH'] = ($payment_type == "CREDIT/CASH" ? " checked=\"checked\"" : "");
	return $selected;
}

# returns an array of the 4 different cards, each containing a string.
# whichever card is selected (in the database) will return the string 'checked = "checked"' for the form item
# for the edit page
function getSelectedCard($card){
	$selected = array();
	$selected['NULL'] = ($card == null ? " selected=\"selected\"" : "");
	$selected['RBC/Interac'] = ($card == "RBC/Interac" ? " selected=\"selected\"" : "");
	$selected['Citizens Bank'] = ($card == "Citizens Bank" ? " selected=\"selected\"" : "");
	$selected['Gift Card'] = ($card == "Gift Card" ? " selected=\"selected\"" : "");
	return $selected;
}

# returns array ($business['field_name']) of requested array
function getBusiness($business_id){
	include_once('db.inc.php');
	$resultB = mysql_query("SELECT * FROM `".DATABASE_NAME."`.`".BUSINESSES_TABLE."` WHERE `id` = ".$business_id);
	$business['id'] = mysql_result($resultB, 0, 'id');
	$business['place_name'] = mysql_result($resultB, 0, 'place_name');
	$business['address'] = mysql_result($resultB, 0, 'address');
	$business['phone'] = mysql_result($resultB, 0, 'phone');
	return $business;
}

# returns business id
function getBusinessID($search_query){
	include_once("db.inc.php");
	str_replace("_", " ", $search_query);
	$resultB = mysql_query("SELECT * FROM `".DATABASE_NAME."`.`".BUSINESSES_TABLE."` WHERE `place_name` LIKE '%".$search_query."%'");
	if(!mysql_errno())
		$id = mysql_result($resultB, 0, "id");
	else
		$id = -1;
	return $id;
}

# returns array ($businesses[$i]['field_name']) with all businesses in montreal_businesses
function getBusinesses(){
	include_once('db.inc.php');
	$businesses = array();
	# get businesses from mysql table
	$result = mysql_query("SELECT * FROM `".BUSINESSES_TABLE."` ORDER BY `place_name` ASC");
	# ouput
	for($i=0; $i<mysql_num_rows($result); $i++){
		$businesses[$i]['id'] = mysql_result($result, $i, 'id');
		$businesses[$i]['place_name'] = mysql_result($result, $i, 'place_name');
		$businesses[$i]['address'] = mysql_result($result, $i, 'address');
		$businesses[$i]['phone'] = mysql_result($result, $i, 'phone');
	}
	return $businesses;
}

# prints (using echo function) the options for businesses (form)
function printBusinessesinForm($selected = ""){
	# get businesses
	$businesses = getBusinesses();
	# ouput
	for($k=0; $k<count($businesses); $k++){
		if($selected == $businesses[$k]['id']){$isselected=" selected='selected'";}else{$isselected="";}
		echo '<option value="'.$businesses[$k]['id'].'"'.$isselected.'>'.$businesses[$k]['place_name'].'</option>'."\n\t";
	}
}

# prints jump menu
function jumpMenu(){
	$output = '<form name="form" id="form">
	  <select name="jumpMenu" id="jumpMenu" onchange="jump(\'parent\',this,0)">
		<option value="">-- Select --</option>
	    <option value="/">DESC: Order By Date</option>
	    <option value="/asc">ASC: Order By Date</option>
		<option value="/fall-2010">Fall 2010</option>
		<option value="/winter-2011">Winter 2011</option>
		<option value="/logout">Logout</option>
	  </select>
	</form>';
	return $output;
}

# code to add a transaction to the database
function addToDatabase($post){
	include_once('db.inc.php');

	$datetime = clean($post['datetime']);
	$business_id = clean($post['business_id']);
	$payment_type = clean($post['payment_type']);
	$card = clean($post['card']);
	$currency = clean($post['currency']);
	$amount = clean($post['amount']);
	$purpose = clean($post['purpose']);
	$items = clean($post['items']);

	if($card == "NULL"){
		$query = "INSERT INTO `".PURCHASES_TABLE."` (`id`, `datetime`, `business_id`, `payment_type`, `card`, `currency`, `amount`, `purpose`, `items`) VALUES (NULL, '$datetime', '$business_id', '$payment_type', NULL, '$currency', '$amount', '$purpose', '$items')";
	}else{
		$query = "INSERT INTO `".PURCHASES_TABLE."` (`id`, `datetime`, `business_id`, `payment_type`, `card`, `currency`, `amount`, `purpose`, `items`) VALUES (NULL, '$datetime', '$business_id', '$payment_type', '$card', '$currency', '$amount', '$purpose', '$items')";
	}
	mysql_query($query) or die(mysql_error());
	$_SESSION['success'] = "add";
	header("Location: http://mtl.parkr.me/?success=add");
}

# code to edit / update this particular transaction in the database
function updateInDatabase($post){
	include_once('db.inc.php');

	$id = clean($post['id']);
	$datetime = clean($post['datetime']);
	$business_id = clean($post['business_id']);
	$payment_type = clean($post['payment_type']);
	$card = clean($post['card']);
	$currency = clean($post['currency']);
	$amount = clean($post['amount']);
	$purpose = clean($post['purpose']);
	$items = clean($post['items']);

	if($card == "NULL"){
		$query = "UPDATE `".PURCHASES_TABLE."` SET `datetime` = '$datetime', `business_id` = '$business_id', `payment_type` = '$payment_type', `card` = NULL, `currency` = '$currency', `amount` = '$amount', `purpose` = '$purpose', `items` = '$items' WHERE `montreal_purchases`.`id` = $id";
	}else{
		$query = "UPDATE `".PURCHASES_TABLE."` SET `datetime` = '$datetime', `business_id` = '$business_id', `payment_type` = '$payment_type', `card` = '$card', `currency` = '$currency', `amount` = '$amount', `purpose` = '$purpose', `items` = '$items' WHERE `montreal_purchases`.`id` = $id";
	}
	mysql_query($query) or die(mysql_error());
	$_SESSION['success'] = "upd";
	header("Location: http://mtl.parkr.me/?success=upd");
}

function addBusiness($post){
	include_once('db.inc.php');
	$place_name = clean($post['place_name']);
	$address = clean($post['address']);
	$phone = clean($post['phone']);
	if($phone == "+1"){
		$phone = "";
	}
	if($phone == "" || $address == ""){
		if($phone == "" && $address == ""){
			mysql_query("INSERT INTO `".BUSINESSES_TABLE."` (`place_name`, `address`, `phone`) VALUES ('$place_name', NULL, NULL)") or die(mysql_error());
		}elseif($phone == "" && $address != ""){
			mysql_query("INSERT INTO `".BUSINESSES_TABLE."` (`place_name`, `address`, `phone`) VALUES ('$place_name', '$address', NULL)") or die(mysql_error());
		}elseif($phone != "" && $address == ""){
			mysql_query("INSERT INTO `".BUSINESSES_TABLE."` (`place_name`, `address`, `phone`) VALUES ('$place_name', NULL, '$phone')") or die(mysql_error());
		}
	}else{
		mysql_query("INSERT INTO `montreal_businesses` (`place_name`, `address`, `phone`) VALUES ('$place_name', '$address', '$phone')") or die(mysql_error());
	}
	$_SESSION['success'] = "addb";
	header("Location: http://mtl.parkr.me/?success=addb");
}

function updateBusiness($post){
	include_once('db.inc.php');
	$id = clean($post['id']);
	$place_name = clean($post['place_name']);
	$address = clean($post['address']);
	$phone = clean($post['phone']);
	if($phone == "+1"){
		$phone = "";
	}
	if($phone == "" || $address == ""){
		if($phone == "" && $address == ""){
			mysql_query("UPDATE `".BUSINESSES_TABLE."` SET `place_name` = '$place_name', `address` = NULL, `phone` = NULL WHERE `".BUSINESSES_TABLE."`.`id` = $id") or die(mysql_error());
		}elseif($phone == "" && $address != ""){
			mysql_query("UPDATE `".BUSINESSES_TABLE."` SET `place_name` = '$place_name', `address` = '$address', `phone` = NULL WHERE `".BUSINESSES_TABLE."`.`id` = $id") or die(mysql_error());
		}elseif($phone != "" && $address == ""){
			mysql_query("UPDATE `".BUSINESSES_TABLE."` SET `place_name` = '$place_name', `address` = NULL, `phone` = '$phone' WHERE `".BUSINESSES_TABLE."`.`id` = $id") or die(mysql_error());
		}
	}else{
		mysql_query("UPDATE `".BUSINESSES_TABLE."` SET `place_name` = '$place_name', `address` = '$address', `phone` = '$phone' WHERE `".BUSINESSES_TABLE."`.`id` = $id") or die(mysql_error());
	}
	$_SESSION['success'] = "updb";
	header("Location: http://mtl.parkr.me/?success=updb");
}

function deletePurchase($post){
	$id = $_POST['id'];
	mysql_query("DELETE FROM `".PURCHASES_TABLE."` WHERE `id` = $id") or die(mysql_error());
	$_SESSION['success'] = "del";
	header("Location: http://mtl.parkr.me/?success=del");
}

# clean up a search query
function clean_search($search_query){
	$search_query = urlencode($search_query);
	$search_query = clean($search_query);
	return $search_query;
}

# clean up some user input (forms)
function clean($dirty){
	include_once("db.inc.php");
	if (get_magic_quotes_gpc()) {
		$clean = mysql_real_escape_string(stripslashes($dirty));	 
	}else{
		$clean = mysql_real_escape_string($dirty);	
	}
	return htmlspecialchars(addslashes($clean));
}

# check if single or double quotes exist in the string
function containsQuotes($string){
	if(preg_match("/(\"|\')/i", $string)>0){
		return true;
	}else{
		if(strstr($string, "\"") || strstr($string, "'")){
			return true;
		}else{
			$string = htmlspecialchars($string);
			if(strstr($string, "%22") || strstr($string, "%27")){
				return true;
			}else{
				return false;
			}
		}
	}
}

function within($string, $search){
	return !(!strstr($string, $search) || !substr($string, $search));
}

function containsSpecialChars($string, $as_text=false){
	$not_accepted = array("%24", "%26", "%2C", "%2F", "%3B", "%3D", "%3F", "%40", "%22", "%3C", "%3E", "%23", "%25", "%7B", "%7D", "%7C", "%5C", "%5E", "%7E", "%5B", "%5D", "%60");
	// "%2B"
	// List obtained from: http://www.blooberry.com/indexdot/html/topics/urlencoding.htm
	foreach ($not_accepted as $hex){
		if(strpos($string, $hex) === true){
			if($as_text){
				return "Unacceptable: ".$hex." (".urldecode($hex).") at position [".strpos($string, urldecode($hex))."] in string '".$string."'";
			}else{
				return true;
			}
		}
	}
	return false;
}

function search($query){
	# TO BE SANITIZED
	$query = str_replace(" ", "--", $query);
	$search = clean_search($query);
	$search = clean($search);
	//echo $search;
	if(containsSpecialChars($search) != false){
		$s = false;
		// CONTAINS SPECIAL CHARS
		reroute("http://mtl.parkr.me/search?e=special_chars&q=".$search);
	}else{
		$s = false;
		reroute("http://mtl.parkr.me/search/$search/");
	}
}

# reroute
function reroute($new_page){
	header("Location:$new_page");
}

# special echo
function show($what){
	echo "<span class='centered'>$what</span>";
}

# highlight the inputted text
function highlight($what, $where){
	# search in where for what
	return str_ireplace($what, "<span class='highlighted'>$what</span>", $where);
}

function printSuccess($successKey){
	if($successKey == "upd"){
		$phrase = "You have successfully updated the purchase.";
	}elseif($successKey == "add"){
		$phrase = "You have successfully added the purchase.";
	}elseif($successKey == "del"){
		$phrase = "You have successfully deleted the purchase.";
	}elseif($successKey == "addb"){
		$phrase = "You have successfully added the business.";
	}elseif($successKey == "updb"){
		$phrase = "You have successfully updated the business.";
	}
	echo '<span class="success" style="display:none;">'.$phrase.'</span>';
}
?>