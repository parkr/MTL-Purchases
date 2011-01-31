<?php
if(!isset($_COOKIE["loggedin"])){
	header("Location: http://mtl.parkr.me/login");
}
include "db.inc.php";
include "functions.inc.php";
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
<title>Add Purchase</title>
<link href="/fleur-de-lis.png" rel="icon" type="image/png">
<link href="/default.css" rel="stylesheet" media="screen">
<script src="http://code.jquery.com/jquery-1.4.4.js" type="text/javascript"></script> 
<script src="/mtl.js" type="text/javascript"></script>
</head>

<body><div id="container"><h1 align="center">Add Purchase</h1><form method="post" name="inputform" id="inputform" action="/submit">
<input name="action" type="hidden" value="add" />
<table width="700" border="0" cellspacing="0" cellpadding="0" style="width:600px;margin:0 auto;padding:0">
  <tr>
    <td>Date:</td>
    <td><input name="datetime" type="text" value="<?php echo getCurrDate(); ?>" /> <span class="format footnote">(Format: YYYY-MM-DD HH:MM:SS)</span></td>
  </tr>
  <tr>
    <td>Business:</td>
    <td><select name="business_id">
      <?php printBusinessesinForm(); ?>
    </select></td>
  </tr>
  <tr>
    <td>Payment Type:</td>
    <td><p>
      <label>
        <input type="radio" name="payment_type" value="CASH" id="payment_type_0" />
        Cash</label>
      <br />
      <label>
        <input type="radio" name="payment_type" value="DEBIT" id="payment_type_1" />
        Debit</label>
      <br />
      <label>
        <input type="radio" name="payment_type" value="CREDIT" id="payment_type_2" />
        Credit</label>
      <br />
      <label>
        <input type="radio" name="payment_type" value="CREDIT/CASH" id="payment_type_3" />
        Credit/Cash</label>
      <br />
    </p></td>
  </tr>
  <tr>
    <td>Card:</td>
    <td><select name="card" id="card">
      <option value="NULL">NONE</option>
      <option value="RBC/Interac">Interac</option>
      <option value="Citizens Bank">Citizen's Bank</option>
      </select></td>
  </tr>
  <tr>
    <td>Currency:</td>
    <td><select name="currency" id="currency">
      <option value="CAD">CAD</option>
      <option value="USD">USD</option>
    </select></td>
  </tr>
  <tr>
    <td>Amount:</td>
    <td>$
      <input type="text" name="amount" id="amount" /></td>
  </tr>
  <tr>
    <td>Purpose:</td>
    <td><textarea name="purpose" id="purpose" cols="45" rows="5"></textarea><br/>
      <span class="footnote">(comma-separated)</span></td>
  </tr>
  <tr>
    <td>Items:</td>
    <td><textarea name="items" id="items" cols="45" rows="5"></textarea><br/>
      <span class="footnote">(comma-separated)</span></td>
  </tr>
  	<tr>
		<td></td>
		<td><input type="submit" value="Add"></td>
	</tr>
</table>
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
<title>Edit Purchase</title>
<link href="/fleur-de-lis.png" rel="icon" type="image/png">
<link href="/default.css" rel="stylesheet" media="screen">
<script src="http://code.jquery.com/jquery-1.4.4.js" type="text/javascript"></script> 
<script src="/mtl.js" type="text/javascript"></script>
</head>
<?php $purchase = getPurchase($_GET['edit']); ?>

<body><div id="container"><h1 align="center">Edit Purchase</h1><form action="/submit" method="post" name="inputform" id="inputform">
<input name="id" type="hidden" value="<?php echo $purchase['id']; ?>" />
<input name="action" type="hidden" value="edit" />
<table width="700" border="0" cellspacing="0" cellpadding="0" style="width:700px;margin:0 auto;">
  <tr>
    <td>Date:</td>
    <td><input name="datetime" type="text" value="<?php echo $purchase['datetime'];  ?>" /> <span class="format">(Format: YYYY-MM-DD HH:MM:SS)</span></td>
  </tr>
  <tr>
    <td>Business:</td>
    <td><select name="business_id">
      <?php printBusinessesinForm($purchase['business']['id']); ?>
    </select></td>
  </tr>
  <tr>
    <td>Payment Type:</td>
    <?php $isSelectedPayment = getSelectedPayment($purchase['payment_type']); ?>
    <td><p>
      <label>
        <input type="radio" name="payment_type" value="CASH" id="payment_type_0"<?php echo $isSelectedPayment['CASH']; ?> />
        Cash</label>
      <br />
      <label>
        <input type="radio" name="payment_type" value="DEBIT" id="debit"<?php echo $isSelectedPayment['DEBIT']; ?> />
        Debit</label>
      <br />
      <label>
        <input type="radio" name="payment_type" value="CREDIT" id="payment_type_2"<?php echo $isSelectedPayment['CREDIT']; ?> />
        Credit</label>
      <br />
      <label>
        <input type="radio" name="payment_type" value="CREDIT/CASH" id="payment_type_3"<?php echo $isSelectedPayment['CREDIT/CASH']; ?> />
        Credit/Cash</label>
      <br />
    </p></td>
  </tr>
  <tr>
    <td>Card:</td>
    <?php $isSelectedCard = getSelectedCard($purchase['card']); ?>
    <td><select name="card" id="card">
      <option value="NULL"<?php echo $isSelectedCard['NULL']; ?>>NONE</option>
      <option value="RBC/Interac"<?php echo $isSelectedCard['RBC/Interac']; ?>>Interac</option>
      <option value="Citizens Bank"<?php echo $isSelectedCard['Citizens Bank']; ?>>Citizen's Bank</option>
      </select></td>
  </tr>
  <tr>
    <td>Currency:</td>
    <td><select name="currency" id="currency">
      <option value="CAD"<?php echo $purchase['currency']=="CAD" ? " selected='selected'" : ""; ?>>CAD</option>
      <option value="USD"<?php echo $purchase['currency']=="USD" ? " selected='selected'" : ""; ?>>USD</option>
    </select></td>
  </tr>
  <tr>
    <td>Amount:</td>
    <td>$
      <input type="text" name="amount" id="amount" value="<?php echo $purchase['amount'] ?>" /></td>
  </tr>
  <tr>
    <td>Purpose:</td>
    <td><textarea name="purpose" id="purpose" cols="45" rows="5"><?php echo $purchase['purpose']; ?></textarea>
      (comma-separated)</td>
  </tr>
  <tr>
    <td>Items:</td>
    <td><textarea name="items" id="items" cols="45" rows="5"><?php echo $purchase['items']; ?></textarea> 
      (comma-separated)</td>
  </tr>
	<tr>
		<td></td>
		<td><input type="submit" value="Edit"></td>
	</tr>
</table>
</form>
</div>
<div id="return"><a href="/">Return</a></div>
<script type="text/javascript">
	repositionReturn();
</script>
</body>
</html>
<?php endif; ?>