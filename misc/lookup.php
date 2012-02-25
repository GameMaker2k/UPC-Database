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

    $FileInfo: lookup.php - Last Update: 02/13/2012 Ver. 2.2.5 RC 1 - Author: cooldude2k $
*/
$File3Name = basename($_SERVER['SCRIPT_NAME']);
if ($File3Name=="lookup.php"||$File3Name=="/lookup.php") {
	chdir("../");
	require("./upc.php");
	exit(); }

if($_GET['act']=="lookup"&&isset($_POST['upc'])&&strlen($_POST['upc'])==8&&
	validate_upce($_POST['upc'])===false) { 
	$_GET['act'] = "lookup"; header("Location: ".$website_url.$url_file."?act=lookup"); exit(); }
if($_GET['act']=="lookup"&&isset($_POST['upc'])&&strlen($_POST['upc'])==12&&
	validate_upca($_POST['upc'])===false) { 
	$_GET['act'] = "lookup"; header("Location: ".$website_url.$url_file."?act=lookup"); exit(); }
if($_GET['act']=="lookup"&&isset($_POST['upc'])&&strlen($_POST['upc'])==13&&
	validate_ean13($_POST['upc'])===false) { 
	$_GET['act'] = "lookup"; header("Location: ".$website_url.$url_file."?act=lookup"); exit(); }
if($_GET['act']=="lookup") { 
$lookupupc = NULL;
if(isset($_POST['upc'])&&is_numeric($_POST['upc'])) { $lookupupc = $_POST['upc']; }
if(isset($_POST['upc'])&&!is_numeric($_POST['upc'])) { $lookupupc = NULL; }
if(!isset($_POST['upc'])) { $lookupupc = NULL; } }
if($_GET['act']=="lookup") { 
if(isset($_POST['upc'])) {
$findupc = sqlite3_query($slite3, "SELECT COUNT(*) AS COUNT FROM \"".$table_prefix."items\" WHERE upc='".sqlite3_escape_string($slite3, $ean13)."';"); 
$numupc = sql_fetch_assoc($findupc);
$numrows = $numupc['COUNT'];
if($numrows>0) {
$findupc = sqlite3_query($slite3, "SELECT * FROM \"".$table_prefix."items\" WHERE upc='".sqlite3_escape_string($slite3, $ean13)."';"); 
$upcinfo = sql_fetch_assoc($findupc); }
$oldnumrows = $numrows;
if($oldnumrows<1) {
$findupc = sqlite3_query($slite3, "SELECT COUNT(*) AS COUNT FROM \"".$table_prefix."pending\" WHERE upc='".sqlite3_escape_string($slite3, $ean13)."';"); 
$numupc = sql_fetch_assoc($findupc);
$numrows = $numupc['COUNT']; 
if($numrows>0) {
$findupc = sqlite3_query($slite3, "SELECT * FROM \"".$table_prefix."pending\" WHERE upc='".sqlite3_escape_string($slite3, $ean13)."';"); 
$upcinfo = sql_fetch_assoc($findupc); 
$upcinfo['validated'] = "no"; } } }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
 <head>
  <?php if(!isset($_POST['upc'])) { ?>
<title> <?php echo $sitename; ?>: Item Lookup </title>
  <?php } if(isset($_POST['upc'])&&$numrows>0&&$upcinfo['validated']=="yes"&&
	(!preg_match("/^02/", $_POST['upc'])&&!preg_match("/^04/", $_POST['upc'])&&
	!preg_match("/^05/", $_POST['upc'])&&!preg_match("/^09/", $_POST['upc'])&&
	!preg_match("/^(98[1-3])/", $_POST['upc'])&&!preg_match("/^(99[0-9])/", $_POST['upc'])&&
	!preg_match("/^(97[7-9])/", $_POST['upc'])&&!preg_match("/^2/", $_POST['upc']))) { ?>
<title> <?php echo $sitename; ?>: Item Record </title>
  <?php } if(isset($_POST['upc'])&&$numrows>0&&$upcinfo['validated']=="no"&&
	(!preg_match("/^02/", $_POST['upc'])&&!preg_match("/^04/", $_POST['upc'])&&
	!preg_match("/^05/", $_POST['upc'])&&!preg_match("/^09/", $_POST['upc'])&&
	!preg_match("/^(98[1-3])/", $_POST['upc'])&&!preg_match("/^(99[0-9])/", $_POST['upc'])&&
	!preg_match("/^(97[7-9])/", $_POST['upc'])&&!preg_match("/^2/", $_POST['upc']))) { ?>
<title> <?php echo $sitename; ?>: Item Found </title>
  <?php } if(isset($_POST['upc'])&&$numrows===0&&
	(!preg_match("/^02/", $_POST['upc'])&&!preg_match("/^04/", $_POST['upc'])&&
	!preg_match("/^05/", $_POST['upc'])&&!preg_match("/^09/", $_POST['upc'])&&
	!preg_match("/^(98[1-3])/", $_POST['upc'])&&!preg_match("/^(99[0-9])/", $_POST['upc'])&&
	!preg_match("/^(97[7-9])/", $_POST['upc'])&&!preg_match("/^2/", $_POST['upc']))) { ?>
<title> <?php echo $sitename; ?>: Item Not Found </title>
  <?php } if(isset($_POST['upc'])&&preg_match("/^02/", $_POST['upc'])) { ?>
<title> <?php echo $sitename; ?>: Random Weight UPC </title>
  <?php } if(isset($_POST['upc'])&&preg_match("/^04/", $_POST['upc'])) { ?>
<title> <?php echo $sitename; ?>: Dummy UPC </title>
  <?php } if(isset($_POST['upc'])&&preg_match("/^2/", $_POST['upc'])) { ?>
<title> <?php echo $sitename; ?>: Dummy UPC </title>
  <?php } if(isset($_POST['upc'])&&
	(preg_match("/^05/", $_POST['upc'])||preg_match("/^09/", $_POST['upc']))) { ?>
<title> <?php echo $sitename; ?>: Coupon Decode </title>
  <?php } if(isset($_POST['upc'])&&
	(preg_match("/^(98[1-3])/", $_POST['upc'])||preg_match("/^(99[0-9])/", $_POST['upc']))) { ?>
<title> <?php echo $sitename; ?>: Coupon Decode </title>
  <?php } if(isset($_POST['upc'])&&
	(preg_match("/^(97[7-9])/", $_POST['upc']))) { ?>
<title> <?php echo $sitename; ?>: Bookland ISBN/ISMN/ISSN </title>
  <?php } ?>
<?php echo $metatags; ?>
 </head>

 <body>
  <center>
   <?php echo $navbar; ?>
   <?php if(isset($_POST['upc'])&&preg_match("/^02/", $_POST['upc'])) { 
   $RandWeight = get_upca_vw_info($upca);
   $price_split = str_split($RandWeight['price'], 2);
   $RandWeight['price'] = ltrim($price_split[0].".".$price_split[1], "0"); 
   ?>
   <h2>Random Weight UPC</h2>
   <div>Random weight (number system 2) UPCs are a way of price-marking an item. The first (number system) digit is always 2.<br />  The next 5 (6?) digits are locally assigned (meaning anybody can use them for whatever they want).<br /> The next 5 (4?) are the price (2 decimal places), and the last digit is the check digit, calculated normally.</div>
   <table>
   <tr><td width="125">UPC-A</td><td width="50"><img src="<?php echo $website_url.$barcode_file; ?>?act=upca&amp;upc=<?php echo $upca; ?>" alt="<?php echo $upca; ?>" title="<?php echo $upca; ?>" /></td></tr>
   <tr><td width="125">Product Code</td><td width="50"><?php echo $RandWeight['code']; ?></td></tr>
   <tr><td width="125">Price</td><td width="50"><?php echo $RandWeight['price']; ?></td></tr>
   </table>
   <div><br /></div>
   <?php } if(isset($_POST['upc'])&&
	(preg_match("/^05/", $_POST['upc'])||preg_match("/^09/", $_POST['upc']))) {
   $CouponInfo = get_upca_coupon_info($upca);
   ?>
   <h2>Coupon Decode</h2>
   <div>Manufacturer: <?php echo $CouponInfo['manufacturer']; ?><br /><br /></div>
   <div>Coupon Family: <?php echo $CouponInfo['family']; ?><br /><br /></div>
   <div>Coupon Value: <?php echo $CouponInfo['value']; ?><br /><br /></div>
   <div>Coupon UPCs are not unique to coupons as other UPCs are to items.<br />  The coupon UPC has its meaning embedded in it.<br />  Therefore, there's no need to store coupon UPCs in the database.</div>
   <table>
   <tr><td width="125">UPC-A</td><td width="50"><img src="<?php echo $website_url.$barcode_file; ?>?act=upca&amp;upc=<?php echo $upca; ?>" alt="<?php echo $upca; ?>" title="<?php echo $upca; ?>" /></td></tr>
   </table>
   <div><br /></div>
   <?php } if(isset($_POST['upc'])&&
	(preg_match("/^(98[1-3])/", $_POST['upc'])||preg_match("/^(99[0-9])/", $_POST['upc']))) {
   ?>
   <h2>Coupon Decode</h2>
   <div>Coupon UPCs are not unique to coupons as other UPCs are to items.<br />  The coupon UPC has its meaning embedded in it.<br />  Therefore, there's no need to store coupon UPCs in the database.</div>
   <table>
   <tr><td width="125">EAN/UCC-13</td><td width="50"></td><td><img src="<?php echo $website_url.$barcode_file; ?>?act=ean13&amp;upc=<?php echo $ean13; ?>" alt="<?php echo $ean13; ?>" title="<?php echo $ean13; ?>" /></td></tr>
   </table>
   <div><br /></div>
   <?php } if(isset($_POST['upc'])&&preg_match("/^04/", $_POST['upc'])) { 
   ?>
   <h2>Dummy UPC</h2>
   <div>Dummy (number system 4) UPCs are for private use.<br />  This means anybody (typically a retailer) that needs to assign a UPC to an item that doesn't already have one, can use any number system 4 UPC it chooses.<br />  Most importantly, they can know that by doing so, they won't pick one that may already be used.<br />  So, such a UPC can and does mean something different depending on who you ask, and there's no reason to try to keep track of what products these correspond to.</div>
   <table>
   <tr><td width="125">UPC-A</td><td width="50"><img src="<?php echo $website_url.$barcode_file; ?>?act=upca&amp;upc=<?php echo $upca; ?>" alt="<?php echo $upca; ?>" title="<?php echo $upca; ?>" /></td></tr>
   </table>
   <div><br /></div>
   <?php } if(isset($_POST['upc'])&&preg_match("/^2/", $_POST['upc'])) { 
   ?>
   <h2>Dummy UPC</h2>
   <div>Dummy (number system 2) UPCs are for private use.<br />  This means anybody (typically a retailer) that needs to assign a UPC to an item that doesn't already have one, can use any number system 2 UPC it chooses.<br />  Most importantly, they can know that by doing so, they won't pick one that may already be used.<br />  So, such a UPC can and does mean something different depending on who you ask, and there's no reason to try to keep track of what products these correspond to.</div>
   <table>
   <tr><td width="125">EAN/UCC-13</td><td width="50"></td><td><img src="<?php echo $website_url.$barcode_file; ?>?act=ean13&amp;upc=<?php echo $ean13; ?>" alt="<?php echo $ean13; ?>" title="<?php echo $ean13; ?>" /></td></tr>
   </table>
   <div><br /></div>
   <?php } if(isset($_POST['upc'])&&preg_match("/^(97[7-9])/", $_POST['upc'])) {
   $eanhrefs = NULL; $eanhrefe = NULL;
   if(validate_isbn13($ean13)===true) {
   $eantype = "ISBN"; $eanprefix = "978";
   $eanprint = print_convert_isbn13_to_isbn10($ean13); 
   $eanprint = "<a href=\"http://www.amazon.com/gp/search?keywords=".urlencode($eanprint)."&ie=UTF8\" onclick=\"window.open(this.href);return false;\">".$eanprint."</a>"; }
   if(validate_ismn13($ean13)===true) {
   $eantype = "ISMN"; $eanprefix = "977";
   $eanprint = print_convert_ismn13_to_ismn10($ean13); }
   if(validate_issn13($ean13)===true) {
   $eantype = "ISSN"; $eanprefix = "979";
   $eanprint = print_convert_issn13_to_issn8($ean13); }
   ?>
   <h2>Bookland ISBN/ISMN/ISSN</h2>
   <div>This is a Bookland <?php echo $eantype; ?> code, which means it's an <?php echo $eantype; ?> number encoded as an EAN/UCC-13.<br /> You can tell this by the first three digits of the EAN/UCC-13 (<?php echo $eanprefix; ?>). The numbers after that are the <?php echo $eantype; ?>.<br /> You'll notice the last digits differ, though -- EAN/UCC-13 and <?php echo $eantype; ?> calculate their check digits differently<br /> (in fact, the check 'digit' on an <?php echo $eantype; ?> can be a digit or the letter X).</div>
   <table>
   <tr><td width="125">EAN/UCC-13</td><td width="50"></td><td><img src="<?php echo $website_url.$barcode_file; ?>?act=ean13&amp;upc=<?php echo $ean13; ?>" alt="<?php echo $ean13; ?>" title="<?php echo $ean13; ?>" /></td></tr>
   <tr><td width="125"><?php echo $eantype; ?></td><td width="50"></td><td><center><?php echo $eanprint; ?></center></td></tr>
   </table>
   <div><br /></div>
   <?php } if(!isset($_POST['upc'])&&
	(!preg_match("/^02/", $_POST['upc'])&&!preg_match("/^04/", $_POST['upc'])&&
	!preg_match("/^05/", $_POST['upc'])&&!preg_match("/^09/", $_POST['upc'])&&
	!preg_match("/^(98[1-3])/", $_POST['upc'])&&!preg_match("/^(99[0-9])/", $_POST['upc'])&&
	!preg_match("/^(97[7-9])/", $_POST['upc'])&&!preg_match("/^2/", $_POST['upc']))) { ?>
   <h2>Item Lookup</h2>
   <?php } if(isset($_POST['upc'])&&$numrows>0&&$upcinfo['validated']=="yes"&&
	(!preg_match("/^02/", $_POST['upc'])&&!preg_match("/^04/", $_POST['upc'])&&
	!preg_match("/^05/", $_POST['upc'])&&!preg_match("/^09/", $_POST['upc'])&&
	!preg_match("/^(98[1-3])/", $_POST['upc'])&&!preg_match("/^(99[0-9])/", $_POST['upc'])&&
	!preg_match("/^(97[7-9])/", $_POST['upc'])&&!preg_match("/^2/", $_POST['upc']))) { ?>
   <h2>Item Record</h2>
   <table>
   <?php if($upce!==NULL&&validate_upce($upce)===true) { ?>
   <tr><td>UPC-E</td><td width="50"></td><td><img src="<?php echo $website_url.$barcode_file; ?>?act=upce&amp;upc=<?php echo $upce; ?>" alt="<?php echo $upce; ?>" title="<?php echo $upce; ?>" /></td></tr>
   <?php } if($upca!==NULL&&validate_upca($upca)===true) { ?>
   <tr><td>UPC-A</td><td width="50"></td><td><img src="<?php echo $website_url.$barcode_file; ?>?act=upca&amp;upc=<?php echo $upca; ?>" alt="<?php echo $upca; ?>" title="<?php echo $upca; ?>" /></td></tr>
   <?php } if($ean13!==NULL&&validate_ean13($ean13)===true) { ?>
   <tr><td>EAN/UCC-13</td><td width="50"></td><td><img src="<?php echo $website_url.$barcode_file; ?>?act=ean13&amp;upc=<?php echo $ean13; ?>" alt="<?php echo $ean13; ?>" title="<?php echo $ean13; ?>" /></td></tr>
   <?php } ?>
   <tr><td>Description</td><td width="50"></td><td><?php echo htmlspecialchars($upcinfo['description'], ENT_HTML401, "UTF-8"); ?></td></tr>
   <tr><td>Size/Weight</td><td width="50"></td><td><?php echo htmlspecialchars($upcinfo['sizeweight'], ENT_HTML401, "UTF-8"); ?></td></tr>
   <?php if($add_quantity_row===true) { ?><tr><td>Quantity</td><td width="50"></td><td><?php echo htmlspecialchars($upcinfo['quantity'], ENT_HTML401, "UTF-8"); ?></td></tr><?php } ?>
   <tr><td>Issuing Country</td><td width="50"></td><td><?php echo get_gs1_prefix($ean13); ?></td></tr>
   <tr><td>Created</td><td width="50"></td><td><?php echo date("j M Y, g:i A T", $upcinfo['timestamp']); ?></td></tr>
   <tr><td>Created By</td><td width="50"></td><td><a href="<?php echo $website_url.$url_file."?act=user&id=".$upcinfo['userid']; ?>"><?php echo $upcinfo['username']; ?></a></td></tr>
   <?php if((isset($_COOKIE['MemberID'])&&$_COOKIE['MemberID']==$meminfo['id'])||
			  ($usersiteinfo['admin']=="yes")) { ?>
   <tr><td>Created By IP</td><td width="50"></td><td><?php echo $upcinfo['ip']; ?></td></tr>
   <?php } if($upcinfo['timestamp']>$upcinfo['lastupdate']) { ?>
   <tr><td>Last Modified</td><td width="50"></td><td><?php echo date("j M Y, g:i A T", $upcinfo['lastupdate']); ?></td></tr>
   <tr><td>Last Modified By</td><td width="50"></td><td><a href="<?php echo $website_url.$url_file."?act=user&id=".$upcinfo['edituserid']; ?>"><?php echo $upcinfo['editname']; ?></a></td></tr>
   <?php if((isset($_COOKIE['MemberID'])&&$_COOKIE['MemberID']==$meminfo['id'])||
			  ($usersiteinfo['admin']=="yes")) { ?>
   <tr><td>Last Modified By IP</td><td width="50"></td><td><?php echo $upcinfo['editip']; ?></td></tr>
   <?php } } ?>
   </table>
   <div><br /></div>
   <a href="<?php echo $website_url.$url_file; ?>?act=neighbors&amp;upc=<?php echo $ean13; ?>&amp;page=1">List Neighboring Items</a><br />
   <!--<a href="/editform.asp?upc=0012345000065">Submit Modification Request</a><br />-->
   <!--<a href="/deleteform.asp?upc=0012345000065">Submit Deletion Request</a><br />-->
   <!--<br /><br /></div>-->
   <div><br /></div>
   <?php } if(isset($_POST['upc'])&&$numrows>0&&$upcinfo['validated']=="no"&&
	(!preg_match("/^02/", $_POST['upc'])&&!preg_match("/^04/", $_POST['upc'])&&
	!preg_match("/^05/", $_POST['upc'])&&!preg_match("/^09/", $_POST['upc'])&&
	!preg_match("/^(98[1-3])/", $_POST['upc'])&&!preg_match("/^(99[0-9])/", $_POST['upc'])&&
	!preg_match("/^(97[7-9])/", $_POST['upc'])&&!preg_match("/^2/", $_POST['upc']))) { ?>
   <h2>Item Found</h2>
   <div>The UPC you were looking for currently is in the database but has not been validated yet.<br /><br /></div>
   <table>
   <?php if($upce!==NULL&&validate_upce($upce)===true) { ?>
   <tr><td>UPC-E</td><td width="50"></td><td><img src="<?php echo $website_url.$barcode_file; ?>?act=upce&amp;upc=<?php echo $upce; ?>" alt="<?php echo $upce; ?>" title="<?php echo $upce; ?>" /></td></tr>
   <?php } if($upca!==NULL&&validate_upca($upca)===true) { ?>
   <tr><td>UPC-A</td><td width="50"></td><td><img src="<?php echo $website_url.$barcode_file; ?>?act=upca&amp;upc=<?php echo $upca; ?>" alt="<?php echo $upca; ?>" title="<?php echo $upca; ?>" /></td></tr>
   <?php } if($ean13!==NULL&&validate_ean13($ean13)===true) { ?>
   <tr><td>EAN/UCC-13</td><td width="50"></td><td><img src="<?php echo $website_url.$barcode_file; ?>?act=ean13&amp;upc=<?php echo $ean13; ?>" alt="<?php echo $ean13; ?>" title="<?php echo $ean13; ?>" /></td></tr>
   <?php } ?>
   </table>
   <div><br />Please try coming back later.<br /><br /></div>
   <?php } if(isset($_POST['upc'])&&$numrows===0&&
	(!preg_match("/^02/", $_POST['upc'])&&!preg_match("/^04/", $_POST['upc'])&&
	!preg_match("/^05/", $_POST['upc'])&&!preg_match("/^09/", $_POST['upc'])&&
	!preg_match("/^(98[1-3])/", $_POST['upc'])&&!preg_match("/^(99[0-9])/", $_POST['upc'])&&
	!preg_match("/^(97[7-9])/", $_POST['upc'])&&!preg_match("/^2/", $_POST['upc']))) { ?>
   <h2>Item Not Found</h2>
   <div>The UPC you were looking for currently has no record in the database.<br /><br /></div>
   <table>
   <?php if($upce!==NULL&&validate_upce($upce)===true) { ?>
   <tr><td>UPC-E</td><td width="50"></td><td><img src="<?php echo $website_url.$barcode_file; ?>?act=upce&amp;upc=<?php echo $upce; ?>" alt="<?php echo $upce; ?>" title="<?php echo $upce; ?>" /></td></tr>
   <?php } if($upca!==NULL&&validate_upca($upca)===true) { ?>
   <tr><td>UPC-A</td><td width="50"></td><td><img src="<?php echo $website_url.$barcode_file; ?>?act=upca&amp;upc=<?php echo $upca; ?>" alt="<?php echo $upca; ?>" title="<?php echo $upca; ?>" /></td></tr>
   <?php } if($ean13!==NULL&&validate_ean13($ean13)===true) { ?>
   <tr><td>EAN/UCC-13</td><td width="50"></td><td><img src="<?php echo $website_url.$barcode_file; ?>?act=ean13&amp;upc=<?php echo $ean13; ?>" alt="<?php echo $ean13; ?>" title="<?php echo $ean13; ?>" /></td></tr>
   <?php } ?>
   </table>
   <div><br />Even though this item is not on file here, looking at some of its
   <a href="<?php echo $website_url.$url_file; ?>?act=neighbors&amp;upc=<?php echo $ean13; ?>&amp;page=1">close neighbors</a>
   may give you an idea what this item might be, or who manufactures it.<br /></div>
   <div><br />If you know what this item is, and would like to contribute to the database
   by providing a description for this item, please
   <a href="<?php echo $website_url.$url_file; ?>?act=add&amp;upc=<?php echo $ean13; ?>">CLICK HERE</a>.<br /><br /></div>
   <?php } ?>
   <form action="<?php echo $website_url.$url_file; ?>?act=lookup" method="get">
    <input type="hidden" name="act" value="lookup" />
    <table>
    <tr><td style="text-align: center;"><input type="text" name="upc" size="16" maxlength="13" value="<?php echo $lookupupc; ?>" /> <input type="submit" value="Look Up UPC" /></td></tr>
   </table>
   </form>
  </center>
 </body>
</html>
<?php } if($_GET['act']=="check"||$_GET['act']=="checkdigit") { ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
 <head>
<title> <?php echo $sitename; ?>: Check Digit Calculator </title>
<?php echo $metatags; ?>
 </head>
 <body>
  <center>
   <?php echo $navbar; ?>
   <h2>Check Digit Calculator</h2>
   <form method="post" action="<?php echo $website_url.$url_file."?act=checkdigit"; ?>">
   <b>EAN/UCC</b>: <input type="text" name="checkupc" size="15" maxlength="12" /><div><br /></div>
   <div><input type="submit" value="Calculate Check Digit" /></div>
   </form>
   <div><br /></div>
   <?php if(isset($_POST['checkupc'])&&is_numeric($_POST['checkupc'])&&
   (strlen($_POST['checkupc'])==7||strlen($_POST['checkupc'])==11||strlen($_POST['checkupc'])==12)) { 
   if(strlen($_POST['checkupc'])==7) {
   $check_upce = fix_upce_checksum($_POST['checkupc']);
   $check_upca = convert_upce_to_upca($check_upce);
   $check_ean13 = convert_upca_to_ean13($check_upca); }
   if(strlen($_POST['checkupc'])==11) {
   $check_upca = fix_upca_checksum($_POST['checkupc']);
   $check_upce = convert_upca_to_upce($check_upca);
   $check_ean13 = convert_upca_to_ean13($check_upca); }
   if(strlen($_POST['checkupc'])==12) {
   $check_ean13 = fix_ean13_checksum($_POST['checkupc']);
   $check_upca = convert_ean13_to_upca($check_ean13);
   $check_upce = convert_upca_to_upce($check_upca); }
   ?>
   <table>
   <?php if($check_ean13!==NULL&&validate_ean13($check_ean13)===true) { ?>
   <tr><td>EAN/UCC-13:</td><td><?php echo $check_ean13; ?></td></tr>
   <?php } if($check_upca!==NULL&&validate_upca($check_upca)===true) { ?>
   <tr><td>UPC-A:</td><td><?php echo $check_upca; ?></td></tr>
   <?php } if($check_upce!==NULL&&validate_upce($check_upce)===true) { ?>
   <tr><td>UPC-E:</td><td><?php echo $check_upce; ?></td></tr>
   <?php } ?>
   <tr><td colspan="2"><a href="<?php echo $website_url.$url_file."?act=lookup&amp;upc=".$check_ean13; ?>">Click here</a> to look up this UPC in the database.</td></tr>
   </table>
   <?php } ?>
  </center>
 </body>
</html>
<?php } ?>