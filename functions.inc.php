<?php
#
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
		$purchase['actions'] = array('edit' => '/edit:'.$purchase['id'], 'delete' => '', 'after' => '/after:'.$purchases[$j]['id'], 'before' => '/before:'.$purchases[$j]['id']);
	}
	return $purchase;
}


# $result is a mysql result
# returns array ($purchases[$i]['field_name']) with all purchases from that result
function processPurchases($result, $stringTableFormat = false, $baseTab = ""){
	/*
	1. Check if $result is valid mysql result
	2. Create array
	3. Iterate through each row, separating the data into the sub-array
	4. Output the array */
	if(is_resource($result)){
		$purchases = array();
		for($j=0; $j<mysql_num_rows($result); $j++){
			$purchases[$j]['id'] = mysql_result($result, $j, 'id');
			$purchases[$j]['datetime'] = mysql_result($result, $j, 'datetime');
			$purchases[$j]['business'] = getBusiness(mysql_result($result, $j, 'business_id'));
			$purchases[$j]['payment_type'] = mysql_result($result, $j, 'payment_type');
			$purchases[$j]['card'] = mysql_result($result, $j, 'card');
			$purchases[$j]['currency'] = mysql_result($result, $j, 'currency');
			$purchases[$j]['amount'] = mysql_result($result, $j, 'amount');
			$purchases[$j]['purpose'] = mysql_result($result, $j, 'purpose');
			$purchases[$j]['items'] = mysql_result($result, $j, 'items');
			$purchases[$j]['actions'] = array('edit' => '/edit:'.$purchases[$j]['id'], 'delete' => '', 'after' => '/after:'.$purchases[$j]['id'], 'before' => '/before:'.$purchases[$j]['id']);
		}
		if($stringTableFormat){
			$output = "";
			$output .= ("<tr class='actions'>\n".$baseTab."\t<th scope=\"col\" width='100'>datetime</th>\n".$baseTab."\t<th scope=\"col\">business</th>\n".$baseTab."\t<th scope=\"col\">payment type</th>\n".$baseTab."\t<th scope=\"col\">card</th>\n".$baseTab."\t<th scope=\"col\">currency</th>\n".$baseTab."\t<th scope=\"col\">amount</th>\n".$baseTab."\t<th scope=\"col\">purpose</th>\n".$baseTab."\t<th scope=\"col\">items</th>\n".$baseTab."\t<th scope=\"col\">actions</th>\n".$baseTab."</tr>\n");
			for($p=0; $p<count($purchases); $p++){
				$output .= ($baseTab . "<tr".($p%2!=0 ? " class='altrow'" : "").">\n");
				$output .= ($baseTab . "\t<td>" . formatDate($purchases[$p]['datetime'])."</td>\n");
				$output .= ($baseTab . "\t<td>" . $purchases[$p]['business']['place_name']."</td>\n");
				$output .= ($baseTab . "\t<td>" . $purchases[$p]['payment_type']."</td>\n");
				$output .= ($baseTab . "\t<td>" . $purchases[$p]['card']."</td>\n");
				$output .= ($baseTab . "\t<td>" . $purchases[$p]['currency']."</td>\n");
				$output .= ($baseTab . "\t<td>" . $purchases[$p]['amount']."</td>\n");
				$output .= ($baseTab . "\t<td>" . $purchases[$p]['purpose']."</td>\n");
				$output .= ($baseTab . "\t<td>" . $purchases[$p]['items']."</td>\n");
				$output .= ($baseTab . "\t<td>" . formatActions($purchases[$p]['actions'])."</td>\n");
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

#
function formatDate($date){
	$year = substr($date, 0, 4);
	$month = substr($date, 5, 2);
	$day = substr($date, 8, 2);
	//echo "$year-$month-$day";
	return date("M, j", mktime(0,0,0,$month,$day,$year));
}

# returns string output of links for actions
function formatActions($actions){
	$actionOutput = "";
	$actionOutput .= '<a href="'.$actions['before'].'" alt="view transactions before this one" title="view transactions before this one">before</a> ';
	$actionOutput .= '<a href="'.$actions['edit'].'" alt="edit this transaction" title="edit this transaction">edit</a> ';
	$actionOutput .= '<a href="'.$actions['after'].'" alt="view transactions after this one" title="view transactions after this one">after</a>';
	//$actionOutput .= ' <a href="'.$actions['delete'].'">delete</a>';
	return $actionOutput;
}

#
function getSelectedPayment($payment_type){
	$selected = array();
	$selected['CASH'] = ($payment_type == "CASH" ? " checked=\"checked\"" : "");
	$selected['CREDIT'] = ($payment_type == "CREDIT" ? " checked=\"checked\"" : "");
	$selected['DEBIT'] = ($payment_type == "DEBIT" ? " checked=\"checked\"" : "");
	$selected['CREDIT/CASH'] = ($payment_type == "CREDIT/CASH" ? " checked=\"checked\"" : "");
	return $selected;
}

#
function getSelectedCard($card){
	$selected = array();
	$selected['NULL'] = ($card == null ? " selected=\"selected\"" : "");
	$selected['RBC/Interac'] = ($card == "RBC/Interac" ? " selected=\"selected\"" : "");
	$selected['Citizens Bank'] = ($card == "Citizens Bank" ? " selected=\"selected\"" : "");
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
		if($selected == $businesses[$k]['id']){$selected=" selected='selected'";}else{$selected="";}
		echo '<option value="'.$businesses[$k]['id'].'"'.$selected.'>'.$businesses[$k]['place_name'].'</option>'."\n\t";
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
	  </select>
	</form>';
	return $output;
}

#
function addToDatabase($post){
	include_once('db.inc.php');
	
	$datetime = $post['datetime'];
	$business_id = $post['business_id'];
	$payment_type = $post['payment_type'];
	$card = $post['card'];
	$currency = $post['currency'];
	$amount = $post['amount'];
	$purpose = $post['purpose'];
	$items = $post['items'];
	
	if($card == "NULL"){
		$query = "INSERT INTO `parkrm04_life`.`montreal_purchases` (`id`, `datetime`, `business_id`, `payment_type`, `card`, `currency`, `amount`, `purpose`, `items`) VALUES (NULL, '$datetime', '$business_id', '$payment_type', NULL, '$currency', '$amount', '$purpose', '$items')";
	}else{
		$query = "INSERT INTO `parkrm04_life`.`montreal_purchases` (`id`, `datetime`, `business_id`, `payment_type`, `card`, `currency`, `amount`, `purpose`, `items`) VALUES (NULL, '$datetime', '$business_id', '$payment_type', '$card', '$currency', '$amount', '$purpose', '$items')";
	}
	mysql_query($query) or die(mysql_error());
	header("Location: http://mtl.parkr.me");
}

#
function updateInDatabase($post){
	include_once('db.inc.php');
	
	$id = $post['id'];
	$datetime = $post['datetime'];
	$business_id = $post['business_id'];
	$payment_type = $post['payment_type'];
	$card = $post['card'];
	$currency = $post['currency'];
	$amount = $post['amount'];
	$purpose = $post['purpose'];
	$items = $post['items'];
	
	if($card == "NULL"){
		$query = "UPDATE `parkrm04_life`.`montreal_purchases` SET `datetime` = '$datetime', `business_id` = '$business_id', `payment_type` = '$payment_type', `card` = NULL, `currency` = '$currency', `amount` = '$amount', `purpose` = '$purpose', `items` = '$items' WHERE `montreal_purchases`.`id` = $id";
	}else{
		$query = "UPDATE `parkrm04_life`.`montreal_purchases` SET `datetime` = '$datetime', `business_id` = '$business_id', `payment_type` = '$payment_type', `card` = '$card', `currency` = '$currency', `amount` = '$amount', `purpose` = '$purpose', `items` = '$items' WHERE `montreal_purchases`.`id` = $id";
	}
	mysql_query($query) or die(mysql_error());
	header("Location: http://mtl.parkr.me");
}
?>