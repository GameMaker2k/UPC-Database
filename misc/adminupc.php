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

    $FileInfo: adminupc.php - Last Update: 02/13/2012 Ver. 2.2.5 RC 1 - Author: cooldude2k $
*/
$File3Name = basename($_SERVER['SCRIPT_NAME']);
if ($File3Name=="adminupc.php"||$File3Name=="/adminupc.php") {
	chdir("../");
	require("./upc.php");
	exit(); }

if($_GET['act']=="deleteupc"&&isset($_GET['upc'])&&validate_ean13($_GET['upc'])===true) {
$findupc = sqlite3_query($slite3, "SELECT COUNT(*) AS COUNT FROM \"".$table_prefix."items\" WHERE \"upc\"='".$_POST['upc']."';");
$numupc = sql_fetch_assoc($findupc);
$numrows = $numupc['COUNT'];
if($numrows>0) {
$findupc = sqlite3_query($slite3, "SELECT * FROM \"".$table_prefix."items\" WHERE upc='".sqlite3_escape_string($slite3, $_POST['upc'])."';"); 
$upcinfo = sql_fetch_assoc($findupc);
$delupc = sqlite3_query($slite3, "DELETE FROM \"".$table_prefix."items\" WHERE \"upc\"='".$_POST['upc']."';"); 
$findupc = sqlite3_query($slite3, "SELECT COUNT(*) AS COUNT FROM \"".$table_prefix."items\" WHERE \"userid\"='".$upcinfo['userid']."';");
$numupc = sql_fetch_assoc($findupc);
$nummyitems = $numupc['COUNT'];
sqlite3_query($slite3, "UPDATE \"".$table_prefix."members\" SET \"numitems\"=".$nummyitems." WHERE \"id\"=".$upcinfo['userid'].";"); } 
$findupc = sqlite3_query($slite3, "SELECT COUNT(*) AS COUNT FROM \"".$table_prefix."modupc\" WHERE \"upc\"='".$_POST['upc']."';");
$numupc = sql_fetch_assoc($findupc);
$numrows = $numupc['COUNT'];
if($numrows>0) {
$delupc = sqlite3_query($slite3, "DELETE FROM \"".$table_prefix."modupc\" WHERE \"upc\"='".$_POST['upc']."';"); } }
if($_GET['act']=="deleteupc") { ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
 <head>
<title> <?php echo $sitename; ?>: AdminCP : Delete UPC </title>
<?php echo $metatags; ?>
 </head>
 <body>
  <center>
   <?php echo $navbar; ?>
   <h2>Delete UPC</h2>
   <?php
   $findupc = sqlite3_query($slite3, "SELECT COUNT(*) AS COUNT FROM \"".$table_prefix."items\" ORDER BY \"lastupdate\" DESC;"); 
   $numupc = sql_fetch_assoc($findupc);
   $numrows = $numupc['COUNT'];
   if($numrows>0) {
   $maxpage = $_GET['page'] * 20;
   if($maxpage>$numrows) { $maxpage = $numrows; }
   $pagestart = $maxpage - 20;
   if($pagestart<0) { $pagestart = 0; }
   $pagestartshow = $pagestart + 1;
   $findupc = sqlite3_query($slite3, "SELECT * FROM \"".$table_prefix."items\" ORDER BY \"lastupdate\" ASC LIMIT ".$pagestart.", ".$maxpage.";"); 
   if($maxpage>20&&$_GET['page']>1) {
   $backpage = $_GET['page'] - 1;
   echo "<a href=\"".$website_url.$url_admin_file."?act=deleteupc&amp;page=".$backpage."\">Prev</a> --\n"; }
   echo $numrows." items, displaying ".$pagestartshow." through ".$maxpage;
   if($pagestart<($numrows - 20)) {
   $nextpage = $_GET['page'] + 1;
   echo "\n-- <a href=\"".$website_url.$url_admin_file."?act=deleteupc&amp;page=".$nextpage."\">Next</a>"; }
   ?>
   <div><br /></div>
   <table class="list">
   <tr><th>Delete EAN/UCC</th><th>Description</th><th>Size/Weight</th><?php if($add_quantity_row===true) { ?><th>Quantity</th><?php } ?><th>Last Mod</th></tr>
   <?php
   while ($upcinfo = sql_fetch_assoc($findupc)) { ?>
   <tr valign="top">
   <td><a href="<?php echo $website_url.$url_admin_file; ?>?act=deleteupc&amp;upc=<?php echo $upcinfo['upc']; ?>&amp;page=1" onclick="if(!confirm('Are you sure you want to delete UPC <?php echo $upcinfo['upc']; ?>?')) { return false; }"><?php echo $upcinfo['upc']; ?></a></td>
   <td><?php echo htmlspecialchars($upcinfo['description'], ENT_HTML401, "UTF-8"); ?></td>
   <td nowrap="nowrap"><?php echo htmlspecialchars($upcinfo['sizeweight'], ENT_HTML401, "UTF-8"); ?></td>
   <?php if($add_quantity_row===true) { ?><td nowrap="nowrap"><?php echo htmlspecialchars($upcinfo['quantity'], ENT_HTML401, "UTF-8"); ?></td><?php } ?>
   <td nowrap="nowrap"><?php echo date("j M Y, g:i A T", $upcinfo['lastupdate']); ?></td>
   </tr>
   <?php } echo "   </table>   <div><br /></div>"; }
   if($numrows>0) {
   if($maxpage>20&&$_GET['page']>1) {
   $backpage = $_GET['page'] - 1;
   echo "<a href=\"".$website_url.$url_admin_file."?act=deleteupc&amp;page=".$backpage."\">Prev</a> --\n"; }
   echo $numrows." items, displaying ".$pagestartshow." through ".$maxpage;
   if($pagestart<($numrows - 20)) {
   $nextpage = $_GET['page'] + 1;
   echo "\n-- <a href=\"".$website_url.$url_admin_file."?act=deleteupc&amp;page=".$nextpage."\">Next</a>"; } }
   ?>
  </center>
 </body>
</html>
<?php } if($_GET['act']=="validateupc"&&isset($_GET['upc'])&&validate_ean13($_GET['upc'])===true) {
$findupc = sqlite3_query($slite3, "SELECT COUNT(*) AS COUNT FROM \"".$table_prefix."pending\" WHERE \"upc\"='".$_POST['upc']."';");
$numupc = sql_fetch_assoc($findupc);
$numrows = $numupc['COUNT'];
if($numrows>0) {
$findupc = sqlite3_query($slite3, "SELECT * FROM \"".$table_prefix."pending\" WHERE upc='".sqlite3_escape_string($slite3, $_POST['upc'])."';"); 
$upcinfo = sql_fetch_assoc($findupc);  
sqlite3_query($slite3, "INSERT INTO \"".$table_prefix."items\" (\"upc\", \"description\", \"sizeweight\", \"quantity\", \"validated\", \"delrequest\", \"userid\", \"username\", \"timestamp\", \"lastupdate\", \"edituserid\", \"editname\", \"ip\", \"editip\") VALUES ('".sqlite3_escape_string($slite3, $upcinfo['upc'])."', '".sqlite3_escape_string($slite3, $upcinfo['description'])."', '".sqlite3_escape_string($slite3, $upcinfo['sizeweight'])."', '".sqlite3_escape_string($slite3, $upcinfo['quantity'])."', 'yes', 'no', ".sqlite3_escape_string($slite3, $upcinfo['userid']).", '".sqlite3_escape_string($slite3, $upcinfo['username'])."', ".$upcinfo['timestamp'].", ".$upcinfo['lastupdate'].", ".sqlite3_escape_string($slite3, $upcinfo['userid']).", '".sqlite3_escape_string($slite3, $upcinfo['username'])."', '".sqlite3_escape_string($slite3, $upcinfo['ip'])."', '".sqlite3_escape_string($slite3, $upcinfo['ip'])."');");
$delupc = sqlite3_query($slite3, "DELETE FROM \"".$table_prefix."pending\" WHERE \"upc\"='".$_POST['upc']."';"); 
$findupc = sqlite3_query($slite3, "SELECT COUNT(*) AS COUNT FROM \"".$table_prefix."pending\" WHERE \"userid\"='".$upcinfo['userid']."';");
$numupc = sql_fetch_assoc($findupc);
$nummypendings = $numupc['COUNT'];
$findupc = sqlite3_query($slite3, "SELECT COUNT(*) AS COUNT FROM \"".$table_prefix."items\" WHERE \"userid\"='".$upcinfo['userid']."';");
$numupc = sql_fetch_assoc($findupc);
$nummyitems = $numupc['COUNT'];
sqlite3_query($slite3, "UPDATE \"".$table_prefix."members\" SET \"numitems\"=".$nummyitems.",\"numpending\"=".$nummypendings." WHERE \"id\"=".$upcinfo['userid'].";"); } }
if($_GET['act']=="validateupc") { ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
 <head>
<title> <?php echo $sitename; ?>: AdminCP : Validate UPC </title>
<?php echo $metatags; ?>
 </head>
 <body>
  <center>
   <?php echo $navbar; ?>
   <h2>Validate UPC</h2>
   <?php
   $findupc = sqlite3_query($slite3, "SELECT COUNT(*) AS COUNT FROM \"".$table_prefix."pending\" ORDER BY \"lastupdate\" DESC;"); 
   $numupc = sql_fetch_assoc($findupc);
   $numrows = $numupc['COUNT'];
   if($numrows>0) {
   $maxpage = $_GET['page'] * 20;
   if($maxpage>$numrows) { $maxpage = $numrows; }
   $pagestart = $maxpage - 20;
   if($pagestart<0) { $pagestart = 0; }
   $pagestartshow = $pagestart + 1;
   $findupc = sqlite3_query($slite3, "SELECT * FROM \"".$table_prefix."pending\" ORDER BY \"lastupdate\" ASC LIMIT ".$pagestart.", ".$maxpage.";"); 
   if($maxpage>20&&$_GET['page']>1) {
   $backpage = $_GET['page'] - 1;
   echo "<a href=\"".$website_url.$url_admin_file."?act=deleteupc&amp;page=".$backpage."\">Prev</a> --\n"; }
   echo $numrows." items, displaying ".$pagestartshow." through ".$maxpage;
   if($pagestart<($numrows - 20)) {
   $nextpage = $_GET['page'] + 1;
   echo "\n-- <a href=\"".$website_url.$url_admin_file."?act=deleteupc&amp;page=".$nextpage."\">Next</a>"; }
   ?>
   <div><br /></div>
   <table class="list">
   <tr><th>Validate EAN/UCC</th><th>Description</th><th>Size/Weight</th><?php if($add_quantity_row===true) { ?><th>Quantity</th><?php } ?><th>Last Mod</th></tr>
   <?php
   while ($upcinfo = sql_fetch_assoc($findupc)) { ?>
   <tr valign="top">
   <td><a href="<?php echo $website_url.$url_admin_file; ?>?act=validateupc&amp;upc=<?php echo $upcinfo['upc']; ?>&amp;page=1"><?php echo $upcinfo['upc']; ?></a></td>
   <td><?php echo htmlspecialchars($upcinfo['description'], ENT_HTML401, "UTF-8"); ?></td>
   <td nowrap="nowrap"><?php echo htmlspecialchars($upcinfo['sizeweight'], ENT_HTML401, "UTF-8"); ?></td>
   <?php if($add_quantity_row===true) { ?><td nowrap="nowrap"><?php echo htmlspecialchars($upcinfo['quantity'], ENT_HTML401, "UTF-8"); ?></td><?php } ?>
   <td nowrap="nowrap"><?php echo date("j M Y, g:i A T", $upcinfo['lastupdate']); ?></td>
   </tr>
   <?php } echo "   </table>   <div><br /></div>"; }
   if($numrows>0) {
   if($maxpage>20&&$_GET['page']>1) {
   $backpage = $_GET['page'] - 1;
   echo "<a href=\"".$website_url.$url_admin_file."?act=validateupc&amp;page=".$backpage."\">Prev</a> --\n"; }
   echo $numrows." items, displaying ".$pagestartshow." through ".$maxpage;
   if($pagestart<($numrows - 20)) {
   $nextpage = $_GET['page'] + 1;
   echo "\n-- <a href=\"".$website_url.$url_admin_file."?act=validateupc&amp;page=".$nextpage."\">Next</a>"; } }
   ?>
  </center>
 </body>
</html>
<?php } if($_GET['act']=="editupc"&&validate_ean13($_GET['upc'])===true&&$_GET['subact']==="editupc") { 
if(!isset($_POST['description'])||!isset($_POST['sizeweight'])) { 
	$_GET['upc'] = NULL; $_GET['subact'] = NULL; }
if(!isset($_POST['description'])) { $_POST['description'] = NULL; }
if(!isset($_POST['sizeweight'])) { $_POST['sizeweight'] = NULL; }
$_POST['description'] = trim($_POST['description']);
$_POST['description'] = remove_spaces($_POST['description']);
$_POST['sizeweight'] = trim($_POST['sizeweight']);
$_POST['sizeweight'] = remove_spaces($_POST['sizeweight']);
if($add_quantity_row===true) {
$_POST['quantity'] = trim($_POST['quantity']);
$_POST['quantity'] = remove_spaces($_POST['quantity']); }
if($add_quantity_row===false) { $_POST['quantity'] = null; }
if(strlen($_POST['description'])>150) {
	$_GET['upc'] = NULL; $_GET['subact'] = NULL; }
if(strlen($_POST['sizeweight'])>30) { 
	$_GET['upc'] = NULL; $_GET['subact'] = NULL; }
if(strlen($_POST['quantity'])>30&&$add_quantity_row===true) {
	$_GET['upc'] = NULL; $_GET['subact'] = NULL; }
if($_POST['description']==""||$_POST['description']==NULL) { 
	$_GET['upc'] = NULL; $_GET['subact'] = NULL; }
if($_POST['sizeweight']==""||$_POST['sizeweight']==NULL) { 
	$_GET['upc'] = NULL; $_GET['subact'] = NULL; }
if(($_POST['quantity']==""||$_POST['quantity']==NULL)&&$add_quantity_row===true) {
	$_GET['upc'] = NULL; $_GET['subact'] = NULL; }
$findupc = sqlite3_query($slite3, "SELECT COUNT(*) AS COUNT FROM \"".$table_prefix."items\" WHERE \"upc\"='".$_POST['upc']."';");
$numupc = sql_fetch_assoc($findupc);
$numrows = $numupc['COUNT'];
if($numrows<=0) { $_GET['upc'] = NULL; $_GET['subact'] = NULL; }
if($numrows>0) {
if($add_quantity_row===true) {
sqlite3_query($slite3, "UPDATE \"".$table_prefix."items\" SET \"description\"='".sqlite3_escape_string($slite3, $_POST['description'])."',\"sizeweight\"='".sqlite3_escape_string($slite3, $_POST['sizeweight'])."',\"quantity\"='".sqlite3_escape_string($slite3, $_POST['quantity'])."' WHERE \"upc\"='".$_GET['upc']."';"); }
if($add_quantity_row===false) {
sqlite3_query($slite3, "UPDATE \"".$table_prefix."items\" SET \"description\"='".sqlite3_escape_string($slite3, $_POST['description'])."',\"sizeweight\"='".sqlite3_escape_string($slite3, $_POST['sizeweight'])."' WHERE \"upc\"='".$_GET['upc']."';"); }
$_GET['upc'] = NULL; $_GET['subact'] = NULL; } }
if($_GET['act']=="editupc"&&validate_ean13($_GET['upc'])===true&&$_GET['subact']===NULL) { 
$findupc = sqlite3_query($slite3, "SELECT COUNT(*) AS COUNT FROM \"".$table_prefix."items\" WHERE \"upc\"='".$_GET['upc']."';");
$numupc = sql_fetch_assoc($findupc);
$numrows = $numupc['COUNT'];
if($numrows<=0) { $_GET['upc'] = NULL; }
if($numrows>0) {
$findupc = sqlite3_query($slite3, "SELECT * FROM \"".$table_prefix."items\" WHERE upc='".sqlite3_escape_string($slite3, $_GET['upc'])."';"); 
$upcinfo = sql_fetch_assoc($findupc);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
 <head>
<title> <?php echo $sitename; ?>: AdminCP : Edit UPC </title>
<?php echo $metatags; ?>
 </head>
 <body>
  <center>
   <?php echo $navbar; ?>
   <h2>Edit UPC</h2>
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
   <form action="<?php echo $website_url.$url_admin_file; ?>?act=editupc" method="post">
    <table>
    <tr><td style="text-align: center;">Description: <input type="text" name="description" size="50" maxlength="150" value="<?php echo htmlspecialchars($upcinfo['description'], ENT_HTML401, "UTF-8"); ?>" /></td></tr>
    <tr><td style="text-align: center;">Size/Weight: <input type="text" name="sizeweight" size="30" maxlength="30" value="<?php echo htmlspecialchars($upcinfo['sizeweight'], ENT_HTML401, "UTF-8"); ?>" /></td></tr>
    <?php if($add_quantity_row===true) { ?><tr><td style="text-align: center;">Quantity: <input type="text" name="quantity" size="30" maxlength="30"  value="<?php echo htmlspecialchars($upcinfo['quantity'], ENT_HTML401, "UTF-8"); ?>" /></td></tr><?php } ?>
   </table>
   <input type="hidden" name="upc" value="<?php echo $_GET['upc']; ?>" />
   <input type="hidden" name="subact" value="editupc" />
   <div><br /><input type="submit" value="Save Entry" /> <input type="reset" value="Clear" /></div>
   </form>
  </center>
 </body>
</html>
<?php } } if($_GET['act']=="editupc"&&validate_ean13($_GET['upc'])===false) { ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
 <head>
<title> <?php echo $sitename; ?>: AdminCP : Edit UPC </title>
<?php echo $metatags; ?>
 </head>
 <body>
  <center>
   <?php echo $navbar; ?>
   <h2>Edit UPC</h2>
   <?php
   $findupc = sqlite3_query($slite3, "SELECT COUNT(*) AS COUNT FROM \"".$table_prefix."items\" ORDER BY \"lastupdate\" DESC;"); 
   $numupc = sql_fetch_assoc($findupc);
   $numrows = $numupc['COUNT'];
   if($numrows>0) {
   $maxpage = $_GET['page'] * 20;
   if($maxpage>$numrows) { $maxpage = $numrows; }
   $pagestart = $maxpage - 20;
   if($pagestart<0) { $pagestart = 0; }
   $pagestartshow = $pagestart + 1;
   $findupc = sqlite3_query($slite3, "SELECT * FROM \"".$table_prefix."items\" ORDER BY \"lastupdate\" ASC LIMIT ".$pagestart.", ".$maxpage.";"); 
   if($maxpage>20&&$_GET['page']>1) {
   $backpage = $_GET['page'] - 1;
   echo "<a href=\"".$website_url.$url_admin_file."?act=editupc&amp;page=".$backpage."\">Prev</a> --\n"; }
   echo $numrows." items, displaying ".$pagestartshow." through ".$maxpage;
   if($pagestart<($numrows - 20)) {
   $nextpage = $_GET['page'] + 1;
   echo "\n-- <a href=\"".$website_url.$url_admin_file."?act=editupc&amp;page=".$nextpage."\">Next</a>"; }
   ?>
   <div><br /></div>
   <table class="list">
   <tr><th>Edit EAN/UCC</th><th>Description</th><th>Size/Weight</th><?php if($add_quantity_row===true) { ?><th>Quantity</th><?php } ?><th>Last Mod</th></tr>
   <?php
   while ($upcinfo = sql_fetch_assoc($findupc)) { ?>
   <tr valign="top">
   <td><a href="<?php echo $website_url.$url_admin_file; ?>?act=editupc&amp;upc=<?php echo $upcinfo['upc']; ?>&amp;page=1"><?php echo $upcinfo['upc']; ?></a></td>
   <td><?php echo htmlspecialchars($upcinfo['description'], ENT_HTML401, "UTF-8"); ?></td>
   <td nowrap="nowrap"><?php echo htmlspecialchars($upcinfo['sizeweight'], ENT_HTML401, "UTF-8"); ?></td>
   <?php if($add_quantity_row===true) { ?><td nowrap="nowrap"><?php echo htmlspecialchars($upcinfo['quantity'], ENT_HTML401, "UTF-8"); ?></td><?php } ?>
   <td nowrap="nowrap"><?php echo date("j M Y, g:i A T", $upcinfo['lastupdate']); ?></td>
   </tr>
   <?php } echo "   </table>   <div><br /></div>"; }
   if($numrows>0) {
   if($maxpage>20&&$_GET['page']>1) {
   $backpage = $_GET['page'] - 1;
   echo "<a href=\"".$website_url.$url_admin_file."?act=editupc&amp;page=".$backpage."\">Prev</a> --\n"; }
   echo $numrows." items, displaying ".$pagestartshow." through ".$maxpage;
   if($pagestart<($numrows - 20)) {
   $nextpage = $_GET['page'] + 1;
   echo "\n-- <a href=\"".$website_url.$url_admin_file."?act=editupc&amp;page=".$nextpage."\">Next</a>"; } }
   ?>
  </center>
 </body>
</html>
<?php } if($_GET['act']=="upcdelrequests") { ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
 <head>
<title> <?php echo $sitename; ?>: AdminCP : UPC Delete Requests </title>
<?php echo $metatags; ?>
 </head>
 <body>
  <center>
   <?php echo $navbar; ?>
   <h2>UPC Delete Requests</h2>
  </center>
 </body>
</html>
<?php } if($_GET['act']=="upceditrequests") { ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
 <head>
<title> <?php echo $sitename; ?>: AdminCP : UPC Edit Requests </title>
<?php echo $metatags; ?>
 </head>
 <body>
  <center>
   <?php echo $navbar; ?>
   <h2>UPC Edit Requests</h2>
  </center>
 </body>
</html>
<?php } ?>