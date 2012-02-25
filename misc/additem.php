<?php
/*
    This program is free software; you can redistribute it and/or modify
    it under the terms of the Revised BSD License.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    Revised BSD License for more details.

    Copyright 2011-2012 Cool Dude 2k - http://idb.berlios.de/
    Copyright 2011-2012 Game Maker 2k - http://intdb.sourceforge.net/
    Copyright 2011-2012 Kazuki Przyborowski - https://github.com/KazukiPrzyborowski

    $FileInfo: additem.php - Last Update: 02/13/2012 Ver. 2.2.5 RC 1 - Author: cooldude2k $
*/
$File3Name = basename($_SERVER['SCRIPT_NAME']);
if ($File3Name=="additem.php"||$File3Name=="/additem.php") {
	chdir("../");
	require("./upc.php");
	exit(); }

if(strlen($_POST['upc'])>0&&strlen($_POST['upc'])!=8&&strlen($_POST['upc'])!=12&&strlen($_POST['upc'])!=13) {
	$_GET['act'] = "lookup"; header("Location: ".$website_url.$url_file."?act=add"); exit(); }
if($_GET['act']=="add"&&isset($_POST['upc'])) {
$findupc = sqlite3_query($slite3, "SELECT COUNT(*) AS COUNT FROM \"".$table_prefix."items\" WHERE upc='".sqlite3_escape_string($slite3, $ean13)."';"); 
$numupc = sql_fetch_assoc($findupc);
$numrows = $numupc['COUNT'];
if($numrows>0) { $_GET['act'] = "lookup"; 
	header("Location: ".$website_url.$url_file."?act=lookup&upc=".$_POST['upc']); exit(); } }
if($_GET['act']=="add"&&!isset($_POST['upc'])) { $_GET['act'] = "lookup"; 
	header("Location: ".$website_url.$url_file."?act=lookup"); exit(); }
if($_GET['act']=="add"&&isset($_POST['upc'])&&strlen($_POST['upc'])==8&&
	validate_upce($_POST['upc'])===false) { 
	$_GET['act'] = "lookup"; header("Location: ".$website_url.$url_file."?act=lookup"); exit(); }
if($_GET['act']=="add"&&isset($_POST['upc'])&&strlen($_POST['upc'])==12&&
	validate_upca($_POST['upc'])===false) { 
	$_GET['act'] = "lookup"; header("Location: ".$website_url.$url_file."?act=lookup"); exit(); }
if($_GET['act']=="add"&&isset($_POST['upc'])&&strlen($_POST['upc'])==13&&
	validate_ean13($_POST['upc'])===false) { 
	$_GET['act'] = "lookup"; header("Location: ".$website_url.$url_file."?act=lookup"); exit(); }
if($_GET['act']=="add"&&isset($_POST['upc'])&&
	(preg_match("/^02/", $_POST['upc'])||preg_match("/^04/", $_POST['upc'])||
	preg_match("/^05/", $_POST['upc'])||preg_match("/^09/", $_POST['upc'])||
	preg_match("/^(98[1-3])/", $_POST['upc'])||preg_match("/^(99[0-9])/", $_POST['upc'])||
	preg_match("/^(97[7-9])/", $_POST['upc'])||preg_match("/^2/", $_POST['upc']))) { 
	$_GET['act'] = "lookup"; header("Location: ".$website_url.$url_file."?act=lookup&upc=".$_POST['upc']); exit(); }
if($_GET['act']=="add"&&!isset($_COOKIE['MemberName'])&&!isset($_COOKIE['MemberID'])&&
	!isset($_COOKIE['SessPass'])) { $_GET['act'] = "lookup"; 
	header("Location: ".$website_url.$url_file."?act=lookup&upc=".$_POST['upc']); exit(); }
if($_GET['act']=="add"&&$usersiteinfo['validated']=="no") { $_GET['act'] = "lookup"; 
	header("Location: ".$website_url.$url_file."?act=lookup"); exit(); }
if($_GET['act']=="add"&&isset($_POST['upc'])&&
	 isset($_POST['description'])&&isset($_POST['sizeweight'])) {
$_POST['description'] = trim($_POST['description']);
$_POST['description'] = remove_spaces($_POST['description']);
$_POST['sizeweight'] = trim($_POST['sizeweight']);
$_POST['sizeweight'] = remove_spaces($_POST['sizeweight']);
if($add_quantity_row===true) {
$_POST['quantity'] = trim($_POST['quantity']);
$_POST['quantity'] = remove_spaces($_POST['quantity']); }
if($add_quantity_row===false) { $_POST['quantity'] = null; }
if(strlen($_POST['description'])>150) {
header("Location: ".$website_url.$url_file."?act=add&upc=".$_GET['upc']); exit(); }
if(strlen($_POST['sizeweight'])>30) {
header("Location: ".$website_url.$url_file."?act=add&upc=".$_GET['upc']); exit(); }
if(strlen($_POST['quantity'])>30&&$add_quantity_row===true) {
header("Location: ".$website_url.$url_file."?act=add&upc=".$_GET['upc']); exit(); }
if($_POST['description']==""||$_POST['description']==NULL) {
header("Location: ".$website_url.$url_file."?act=add&upc=".$_GET['upc']); exit(); }
if($_POST['sizeweight']==""||$_POST['sizeweight']==NULL) {
header("Location: ".$website_url.$url_file."?act=add&upc=".$_GET['upc']); exit(); }
if(($_POST['quantity']==""||$_POST['quantity']==NULL)&&$add_quantity_row===true) {
header("Location: ".$website_url.$url_file."?act=add&upc=".$_GET['upc']); exit(); }
$findusrinfo = sqlite3_query($slite3, "SELECT * FROM \"".$table_prefix."members\" WHERE \"id\"=".$_COOKIE['MemberID'].";"); 
$getuserinfo = sql_fetch_assoc($findusrinfo); 
$fixcount = sqlite3_query($slite3, "SELECT COUNT(*) AS COUNT FROM \"".$table_prefix."pending\" WHERE \"userid\"='".$getuserinfo['id']."';");
$numfixcount = sql_fetch_assoc($fixcount);
$nummypendings = $numfixcount['COUNT'];
$fixcount = sqlite3_query($slite3, "SELECT COUNT(*) AS COUNT FROM \"".$table_prefix."items\" WHERE \"userid\"='".$getuserinfo['id']."';");
$numfixcount = sql_fetch_assoc($fixcount);
$nummyitems = $numfixcount['COUNT'];
if($getuserinfo['numitems']!=$nummyitems) {
	$getuserinfo['numitems'] = $nummyitems; }
if($getuserinfo['numpending']!=$nummypendings) {
	$getuserinfo['numpending'] = $nummypendings; }
$newnumitems = $getuserinfo['numitems'];
$newnumpending = $getuserinfo['numpending'];
if($usersiteinfo['admin']=="yes") {
$newnumitems = $getuserinfo['numitems'] + 1; }
if($usersiteinfo['admin']=="no"&&$validate_items===true&&$usersiteinfo['validateitems']=="yes") {
$newnumpending = $getuserinfo['numpending'] + 1; }
if($usersiteinfo['admin']=="no"&&$validate_items===true&&$usersiteinfo['validateitems']=="no") {
$newnumitems = $getuserinfo['numitems'] + 1; }
if($usersiteinfo['admin']=="no"&&$validate_items===false) {
$newnumitems = $getuserinfo['numitems'] + 1; }
sqlite3_query($slite3, "UPDATE \"".$table_prefix."members\" SET \"lastactive\"='".time()."',\"numitems\"=".$newnumitems.",\"numpending\"=".$newnumpending.",\"ip\"='".$usersip."' WHERE \"id\"=".$_COOKIE['MemberID'].";");
$itemvalidated = "no";
if($_COOKIE['MemberID']==1) { $itemvalidated = "yes"; }
if($usersiteinfo['admin']=="yes") { $itemvalidated = "yes"; }
if($usersiteinfo['admin']=="no"&&$_COOKIE['MemberID']>1&&$validate_items===false) { $itemvalidated = "yes"; }
if($usersiteinfo['admin']=="no"&&$_COOKIE['MemberID']>1&&$validate_items===true&&
	$usersiteinfo['validateitems']=="yes") { $itemvalidated = "no"; }
if($usersiteinfo['admin']=="no"&&$_COOKIE['MemberID']>1&&$validate_items===true&&
	$usersiteinfo['validateitems']=="no") { $itemvalidated = "yes"; }
if($usersiteinfo['admin']=="yes") {
sqlite3_query($slite3, "INSERT INTO \"".$table_prefix."items\" (\"upc\", \"description\", \"sizeweight\", \"quantity\", \"validated\", \"delrequest\", \"userid\", \"username\", \"timestamp\", \"lastupdate\", \"edituserid\", \"editname\", \"ip\", \"editip\") VALUES ('".sqlite3_escape_string($slite3, $_POST['upc'])."', '".sqlite3_escape_string($slite3, $_POST['description'])."', '".sqlite3_escape_string($slite3, $_POST['sizeweight'])."', '".sqlite3_escape_string($slite3, $_POST['quantity'])."', '".sqlite3_escape_string($slite3, $itemvalidated)."', 'no', ".sqlite3_escape_string($slite3, $_COOKIE['MemberID']).", '".sqlite3_escape_string($slite3, $_COOKIE['MemberName'])."', ".time().", ".time().", ".sqlite3_escape_string($slite3, $_COOKIE['MemberID']).", '".sqlite3_escape_string($slite3, $_COOKIE['MemberName'])."', '".sqlite3_escape_string($slite3, $usersip)."', '".sqlite3_escape_string($slite3, $usersip)."');"); }
if($usersiteinfo['admin']=="no"&&$validate_items===false) {
sqlite3_query($slite3, "INSERT INTO \"".$table_prefix."items\" (\"upc\", \"description\", \"sizeweight\", \"quantity\", \"validated\", \"delrequest\", \"userid\", \"username\", \"timestamp\", \"lastupdate\", \"edituserid\", \"editname\", \"ip\", \"editip\") VALUES ('".sqlite3_escape_string($slite3, $_POST['upc'])."', '".sqlite3_escape_string($slite3, $_POST['description'])."', '".sqlite3_escape_string($slite3, $_POST['sizeweight'])."', '".sqlite3_escape_string($slite3, $_POST['quantity'])."', '".sqlite3_escape_string($slite3, $itemvalidated)."', 'no', ".sqlite3_escape_string($slite3, $_COOKIE['MemberID']).", '".sqlite3_escape_string($slite3, $_COOKIE['MemberName'])."', ".time().", ".time().", ".sqlite3_escape_string($slite3, $_COOKIE['MemberID']).", '".sqlite3_escape_string($slite3, $_COOKIE['MemberName'])."', '".sqlite3_escape_string($slite3, $usersip)."', '".sqlite3_escape_string($slite3, $usersip)."');"); }
if($usersiteinfo['admin']=="no"&&$validate_items===true&&$usersiteinfo['validateitems']=="yes") {
sqlite3_query($slite3, "INSERT INTO \"".$table_prefix."pending\" (\"upc\", \"description\", \"sizeweight\", \"quantity\", \"validated\", \"delrequest\", \"userid\", \"username\", \"timestamp\", \"lastupdate\", \"ip\") VALUES ('".sqlite3_escape_string($slite3, $_POST['upc'])."', '".sqlite3_escape_string($slite3, $_POST['description'])."', '".sqlite3_escape_string($slite3, $_POST['sizeweight'])."', '".sqlite3_escape_string($slite3, $_POST['quantity'])."', '".sqlite3_escape_string($slite3, $itemvalidated)."', 'no', ".sqlite3_escape_string($slite3, $_COOKIE['MemberID']).", '".sqlite3_escape_string($slite3, $_COOKIE['MemberName'])."', ".time().", ".time().", '".sqlite3_escape_string($slite3, $usersip)."');"); }
if($usersiteinfo['admin']=="no"&&$validate_items===true&&$usersiteinfo['validateitems']=="no") {
sqlite3_query($slite3, "INSERT INTO \"".$table_prefix."items\" (\"upc\", \"description\", \"sizeweight\", \"quantity\", \"validated\", \"delrequest\", \"userid\", \"username\", \"timestamp\", \"lastupdate\", \"edituserid\", \"editname\", \"ip\", \"editip\") VALUES ('".sqlite3_escape_string($slite3, $_POST['upc'])."', '".sqlite3_escape_string($slite3, $_POST['description'])."', '".sqlite3_escape_string($slite3, $_POST['sizeweight'])."', '".sqlite3_escape_string($slite3, $_POST['quantity'])."', '".sqlite3_escape_string($slite3, $itemvalidated)."', 'no', ".sqlite3_escape_string($slite3, $_COOKIE['MemberID']).", '".sqlite3_escape_string($slite3, $_COOKIE['MemberName'])."', ".time().", ".time().", ".sqlite3_escape_string($slite3, $_COOKIE['MemberID']).", '".sqlite3_escape_string($slite3, $_COOKIE['MemberName'])."', '".sqlite3_escape_string($slite3, $usersip)."', '".sqlite3_escape_string($slite3, $usersip)."');"); }
$_GET['act'] = "lookup"; header("Location: ".$website_url.$url_file."?act=lookup&upc=".$_POST['upc']); exit(); }
if($_GET['act']=="add"&&isset($_POST['upc'])) { ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
 <head>
<title> <?php echo $sitename; ?>: Add New Entry </title>
<?php echo $metatags; ?>
 </head>
 <body>
  <center>
   <?php echo $navbar; ?>
   <h2>Add New Entry</h2>
   <table>
   <?php if($upce!==NULL&&validate_upce($upce)===true) { ?>
   <tr><td>UPC-E</td><td width="50"></td><td><img src="<?php echo $website_url.$barcode_file; ?>?act=upce&amp;upc=<?php echo $upce; ?>" alt="<?php echo $upce; ?>" title="<?php echo $upce; ?>" /></td></tr>
   <?php } if($upca!==NULL&&validate_upca($upca)===true) { ?>
   <tr><td>UPC-A</td><td width="50"></td><td><img src="<?php echo $website_url.$barcode_file; ?>?act=upca&amp;upc=<?php echo $upca; ?>" alt="<?php echo $upca; ?>" title="<?php echo $upca; ?>" /></td></tr>
   <?php } if($ean13!==NULL&&validate_ean13($ean13)===true) { ?>
   <tr><td>EAN/UCC-13</td><td width="50"></td><td><img src="<?php echo $website_url.$barcode_file; ?>?act=ean13&amp;upc=<?php echo $ean13; ?>" alt="<?php echo $ean13; ?>" title="<?php echo $ean13; ?>" /></td></tr>
   <?php } ?>
   </table>
   <div><br /></div>
   <form action="<?php echo $website_url.$url_file; ?>?act=add" method="post">
    <table>
    <tr><td style="text-align: center;">Description: <input type="text" name="description" size="50" maxlength="150" /></td></tr>
    <tr><td style="text-align: center;">Size/Weight: <input type="text" name="sizeweight" size="30" maxlength="30" /></td></tr>
    <?php if($add_quantity_row===true) { ?><tr><td style="text-align: center;">Quantity: <input type="text" name="quantity" size="30" maxlength="30" /></td></tr><?php } ?>
   </table>
   <input type="hidden" name="upc" value="<?php echo $_POST['upc']; ?>" />
   <div><br /><input type="submit" value="Save New Entry" /> <input type="reset" value="Clear" /></div>
   </form>
  </center>
 </body>
</html>
<?php } ?>