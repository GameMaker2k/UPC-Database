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

    $FileInfo: adminmem.php - Last Update: 02/13/2012 Ver. 2.2.5 RC 1 - Author: cooldude2k $
*/
$File3Name = basename($_SERVER['SCRIPT_NAME']);
if ($File3Name=="adminmem.php"||$File3Name=="/adminmem.php") {
	chdir("../");
	require("./upc.php");
	exit(); }

if($_GET['act']=="deletemember"&&isset($_GET['id'])&&$_GET['id']>1) {
$findmem = sqlite3_query($slite3, "SELECT COUNT(*) AS COUNT FROM \"".$table_prefix."members\" WHERE \"id\"=".$_GET['id']." AND \"id\"<>1;");
$nummems = sql_fetch_assoc($findmem);
$numrows = $nummems['COUNT'];
if($numrows>0) {
$delupc = sqlite3_query($slite3, "DELETE FROM \"".$table_prefix."members\" WHERE \"id\"=".$_GET['id'].";"); 
sqlite3_query($slite3, "UPDATE \"".$table_prefix."items\" SET \"userid\"=0 WHERE \"userid\"=".$_GET['id'].";");
sqlite3_query($slite3, "UPDATE \"".$table_prefix."items\" SET \"edituserid\"=0 WHERE \"edituserid\"='".$_GET['id']."';");
sqlite3_query($slite3, "UPDATE \"".$table_prefix."pending\" SET \"userid\"=0 WHERE \"userid\"=".$_GET['id'].";"); 
sqlite3_query($slite3, "UPDATE \"".$table_prefix."modupc\" SET \"userid\"=0 WHERE \"userid\"=".$_GET['id'].";"); } }
if($_GET['act']=="deletemember") { ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
 <head>
<title> <?php echo $sitename; ?>: AdminCP : Delete Member </title>
<?php echo $metatags; ?>
 </head>
 <body>
  <center>
   <?php echo $navbar; ?>
   <h2>Delete Member</h2>
   <?php
   $findmem = sqlite3_query($slite3, "SELECT COUNT(*) AS COUNT FROM \"".$table_prefix."members\" WHERE \"id\"<>1 ORDER BY \"id\" DESC;"); 
   $nummems = sql_fetch_assoc($findmem);
   $numrows = $nummems['COUNT'];
   if($numrows>0) {
   $maxpage = $_GET['page'] * 20;
   if($maxpage>$numrows) { $maxpage = $numrows; }
   $pagestart = $maxpage - 20;
   if($pagestart<0) { $pagestart = 0; }
   $pagestartshow = $pagestart + 1;
   $findmem = sqlite3_query($slite3, "SELECT * FROM \"".$table_prefix."members\" WHERE \"id\"<>1 ORDER BY \"id\" ASC LIMIT ".$pagestart.", ".$maxpage.";"); 
   if($maxpage>20&&$_GET['page']>1) {
   $backpage = $_GET['page'] - 1;
   echo "<a href=\"".$website_url.$url_admin_file."?act=deletemember&amp;page=".$backpage."\">Prev</a> --\n"; }
   echo $numrows." members, displaying ".$pagestartshow." through ".$maxpage;
   if($pagestart<($numrows - 20)) {
   $nextpage = $_GET['page'] + 1;
   echo "\n-- <a href=\"".$website_url.$url_admin_file."?act=deletemember&amp;page=".$nextpage."\">Next</a>"; }
   ?>
   <div><br /></div>
   <table class="list">
   <tr><th>Delete Member</th><th>Email</th><th>IP Address</th><th>Last Active</th></tr>
   <?php
   while ($meminfo = sql_fetch_assoc($findmem)) { ?>
   <tr valign="top">
   <td><a href="<?php echo $website_url.$url_admin_file; ?>?act=deletemember&amp;id=<?php echo $meminfo['id']; ?>&amp;page=1" onclick="if(!confirm('Are you sure you want to delete member <?php echo htmlspecialchars($meminfo['name'], ENT_HTML401, "UTF-8"); ?>?')) { return false; }"><?php echo htmlspecialchars($meminfo['name'], ENT_HTML401, "UTF-8"); ?></a></td>
   <td><?php echo htmlspecialchars($meminfo['email'], ENT_HTML401, "UTF-8"); ?></td>
   <td nowrap="nowrap"><?php echo $meminfo['ip']; ?></td>
   <td nowrap="nowrap"><?php echo date("j M Y, g:i A T", $meminfo['lastactive']); ?></td>
   </tr>
   <?php } echo "   </table>   <div><br /></div>"; }
   if($numrows>0) {
   if($maxpage>20&&$_GET['page']>1) {
   $backpage = $_GET['page'] - 1;
   echo "<a href=\"".$website_url.$url_admin_file."?act=deletemember&amp;page=".$backpage."\">Prev</a> --\n"; }
   echo $numrows." members, displaying ".$pagestartshow." through ".$maxpage;
   if($pagestart<($numrows - 20)) {
   $nextpage = $_GET['page'] + 1;
   echo "\n-- <a href=\"".$website_url.$url_admin_file."?act=deletemember&amp;page=".$nextpage."\">Next</a>"; } }
   ?>
  </center>
 </body>
</html>
<?php } if($_GET['act']=="validatemember"&&isset($_GET['id'])&&$_GET['id']>1) {
$findmem = sqlite3_query($slite3, "SELECT COUNT(*) AS COUNT FROM \"".$table_prefix."members\" WHERE \"id\"=".$_GET['id']." AND \"id\"<>1 AND \"validated\"='no';");
$nummems = sql_fetch_assoc($findmem);
$numrows = $nummems['COUNT'];
if($numrows>0) { 
sqlite3_query($slite3, "UPDATE \"".$table_prefix."members\" SET \"validated\"='yes' WHERE \"id\"=".$_GET['id']." AND \"id\"<>1;"); } }
if($_GET['act']=="validatemember") { ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
 <head>
<title> <?php echo $sitename; ?>: AdminCP : Validate Member </title>
<?php echo $metatags; ?>
 </head>
 <body>
  <center>
   <?php echo $navbar; ?>
   <h2>Validate Member</h2>
   <?php
   $findmem = sqlite3_query($slite3, "SELECT COUNT(*) AS COUNT FROM \"".$table_prefix."members\" WHERE \"validated\"='no' AND \"id\"<>1 ORDER BY \"id\" DESC;"); 
   $nummems = sql_fetch_assoc($findmem);
   $numrows = $nummems['COUNT'];
   if($numrows>0) {
   $maxpage = $_GET['page'] * 20;
   if($maxpage>$numrows) { $maxpage = $numrows; }
   $pagestart = $maxpage - 20;
   if($pagestart<0) { $pagestart = 0; }
   $pagestartshow = $pagestart + 1;
   $findmem = sqlite3_query($slite3, "SELECT * FROM \"".$table_prefix."members\" WHERE \"validated\"='no' AND \"id\"<>1 ORDER BY \"id\" ASC LIMIT ".$pagestart.", ".$maxpage.";"); 
   if($maxpage>20&&$_GET['page']>1) {
   $backpage = $_GET['page'] - 1;
   echo "<a href=\"".$website_url.$url_admin_file."?act=validatemember&amp;page=".$backpage."\">Prev</a> --\n"; }
   echo $numrows." members, displaying ".$pagestartshow." through ".$maxpage;
   if($pagestart<($numrows - 20)) {
   $nextpage = $_GET['page'] + 1;
   echo "\n-- <a href=\"".$website_url.$url_admin_file."?act=validatemember&amp;page=".$nextpage."\">Next</a>"; }
   ?>
   <div><br /></div>
   <table class="list">
   <tr><th>Validate Member</th><th>Email</th><th>IP Address</th><th>Last Active</th></tr>
   <?php
   while ($meminfo = sql_fetch_assoc($findmem)) { ?>
   <tr valign="top">
   <td><a href="<?php echo $website_url.$url_admin_file; ?>?act=validatemember&amp;id=<?php echo $meminfo['id']; ?>&amp;page=1"><?php echo htmlspecialchars($meminfo['name'], ENT_HTML401, "UTF-8"); ?></a></td>
   <td><?php echo htmlspecialchars($meminfo['email'], ENT_HTML401, "UTF-8"); ?></td>
   <td nowrap="nowrap"><?php echo $meminfo['ip']; ?></td>
   <td nowrap="nowrap"><?php echo date("j M Y, g:i A T", $meminfo['lastactive']); ?></td>
   </tr>
   <?php } echo "   </table>   <div><br /></div>"; }
   if($numrows>0) {
   if($maxpage>20&&$_GET['page']>1) {
   $backpage = $_GET['page'] - 1;
   echo "<a href=\"".$website_url.$url_admin_file."?act=validatemember&amp;page=".$backpage."\">Prev</a> --\n"; }
   echo $numrows." members, displaying ".$pagestartshow." through ".$maxpage;
   if($pagestart<($numrows - 20)) {
   $nextpage = $_GET['page'] + 1;
   echo "\n-- <a href=\"".$website_url.$url_admin_file."?act=validatemember&amp;page=".$nextpage."\">Next</a>"; } }
   ?>
  </center>
 </body>
</html>
<?php } if($_GET['act']=="editmember"&&isset($_GET['id'])&&$_GET['id']>1&&$_GET['subact']==="editmember") { 
if(!isset($_POST['username'])) { $_POST['username'] = NULL; }
if(!isset($_POST['validateitems'])) { $_POST['validateitems'] = "yes"; }
if(!isset($_POST['admin'])) { $_POST['admin'] = "no"; }
if($_POST['admin']!="no"&&$_POST['admin']!="yes") { $_POST['admin'] = "yes"; }
if($_POST['validateitems']!="no"&&$_POST['validateitems']!="yes") { $_POST['validateitems'] = "yes"; }
$_POST['username'] = trim($_POST['username']);
$_POST['username'] = remove_spaces($_POST['username']);
if($_POST['username']==""||$_POST['username']==NULL) {
	$_GET['id'] = NULL; $_GET['subact'] = NULL; }
if($_GET['subact']!=NULL&&$_GET['id']!=NULL) {
$findmem = sqlite3_query($slite3, "SELECT COUNT(*) AS COUNT FROM \"".$table_prefix."members\" WHERE \"id\"=".$_GET['id']." AND \"id\"<>1;");
$nummems = sql_fetch_assoc($findmem);
$numrows = $nummems['COUNT'];
if($numrows>0) { 
$findmem = sqlite3_query($slite3, "SELECT * FROM \"".$table_prefix."members\" WHERE \"id\"=".$_GET['id']." AND \"id\"<>1;"); 
$meminfo = sql_fetch_assoc($findmem);
$tryfindmem = sqlite3_query($slite3, "SELECT * FROM \"".$table_prefix."members\" WHERE \"name\"=".$_POST['username'].";"); 
$trymeminfo = sql_fetch_assoc($findmem);
if(!isset($trymeminfo['id'])) { $trymeminfo['id'] = $meminfo['id']; }
$findupc = sqlite3_query($slite3, "SELECT COUNT(*) AS COUNT FROM \"".$table_prefix."pending\" WHERE \"userid\"='".$meminfo['id']."';");
$numupc = sql_fetch_assoc($findupc);
$nummypendings = $numupc['COUNT'];
$findupc = sqlite3_query($slite3, "SELECT COUNT(*) AS COUNT FROM \"".$table_prefix."items\" WHERE \"userid\"='".$meminfo['id']."';");
$numupc = sql_fetch_assoc($findupc);
$nummyitems = $numupc['COUNT'];
if($meminfo['numitems']!=$nummyitems&&$meminfo['numpending']==$nummypendings) {
sqlite3_query($slite3, "UPDATE \"".$table_prefix."members\" SET \"numitems\"=".$nummyitems." WHERE \"id\"=".$meminfo['id'].";"); }
if($meminfo['numitems']==$nummyitems&&$meminfo['numpending']!=$nummypendings) {
sqlite3_query($slite3, "UPDATE \"".$table_prefix."members\" SET \"numpending\"=".$nummypendings." WHERE \"id\"=".$meminfo['id'].";"); }
if($meminfo['numitems']!=$nummyitems&&$meminfo['numpending']!=$nummypendings) {
sqlite3_query($slite3, "UPDATE \"".$table_prefix."members\" SET \"numitems\"=".$nummyitems.",\"numpending\"=".$nummypendings." WHERE \"id\"=".$meminfo['id'].";"); }
if($trymeminfo['id']!=$meminfo['id']) {
sqlite3_query($slite3, "UPDATE \"".$table_prefix."members\" SET \"validateitems\"='".$_POST['validateitems']."',\"admin\"='".$_POST['admin']."' WHERE \"id\"=".$meminfo['id'].";"); 
$_GET['id'] = NULL; $_GET['subact'] = NULL; }
if($trymeminfo['id']==$meminfo['id']) {
sqlite3_query($slite3, "UPDATE \"".$table_prefix."members\" SET \"name\"='".$_POST['username']."',\"validateitems\"='".$_POST['validateitems']."',\"admin\"='".$_POST['admin']."' WHERE \"id\"=".$meminfo['id'].";"); 
sqlite3_query($slite3, "UPDATE \"".$table_prefix."items\" SET \"username\"='".$_POST['username']."' WHERE \"username\"='".$meminfo['name']."';"); 
sqlite3_query($slite3, "UPDATE \"".$table_prefix."items\" SET \"editname\"='".$_POST['username']."' WHERE \"editname\"='".$meminfo['name']."';"); 
sqlite3_query($slite3, "UPDATE \"".$table_prefix."pending\" SET \"username\"='".$_POST['username']."' WHERE \"username\"='".$meminfo['name']."';"); 
sqlite3_query($slite3, "UPDATE \"".$table_prefix."modupc\" SET \"username\"='".$_POST['username']."' WHERE \"username\"='".$meminfo['name']."';"); 
$_GET['id'] = NULL; $_GET['subact'] = NULL; } } } } 
if($_GET['act']=="editmember"&&isset($_GET['id'])&&$_GET['id']>1&&$_GET['subact']===NULL) { 
$findmem = sqlite3_query($slite3, "SELECT COUNT(*) AS COUNT FROM \"".$table_prefix."members\" WHERE \"id\"=".$_GET['id']." AND \"id\"<>1;");
$nummems = sql_fetch_assoc($findmem);
$numrows = $nummems['COUNT'];
if($numrows<0) { $_GET['id'] = NULL; }
if($numrows>0) { 
$findmem = sqlite3_query($slite3, "SELECT * FROM \"".$table_prefix."members\" WHERE \"id\"=".$_GET['id']." AND \"id\"<>1;"); 
$meminfo = sql_fetch_assoc($findmem);
$findupc = sqlite3_query($slite3, "SELECT COUNT(*) AS COUNT FROM \"".$table_prefix."items\" WHERE \"userid\"='".$meminfo['id']."';");
$nummems = sql_fetch_assoc($findupc);
$nummyitems = $nummems['COUNT'];
$findupc = sqlite3_query($slite3, "SELECT COUNT(*) AS COUNT FROM \"".$table_prefix."pending\" WHERE \"userid\"='".$meminfo['id']."';");
$nummems = sql_fetch_assoc($findupc);
$nummypendings = $nummems['COUNT'];
$findupc = sqlite3_query($slite3, "SELECT COUNT(*) AS COUNT FROM \"".$table_prefix."modupc\" WHERE \"userid\"='".$meminfo['id']."';");
$nummems = sql_fetch_assoc($findupc);
$nummymods = $nummems['COUNT'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
 <head>
<title> <?php echo $sitename; ?>: AdminCP : Edit Member </title>
<?php echo $metatags; ?>
 </head>
 <body>
  <center>
   <?php echo $navbar; ?>
   <h2>Edit Member</h2>
   <form action="<?php echo $website_url.$url_admin_file; ?>?act=editmember" method="post">
    <table>
    <tr><td style="text-align: center;">Username:</td><td><input type="text" name="username" value="<?php echo htmlspecialchars($meminfo['name'], ENT_HTML401, "UTF-8"); ?>" /></td></tr>
    <tr><td style="text-align: center;">New Items Unvalidated:</td><td><select name="validateitems"><option value="yes"<?php if($meminfo['validateitems']=="yes") { ?> selected="selected"<?php } ?>>Yes</option><option value="no"<?php if($meminfo['validateitems']=="no") { ?> selected="selected"<?php } ?>>No</option></select></td></tr>
    <tr><td style="text-align: center;">Has Admin Power:</td><td><select name="admin"><option value="yes"<?php if($meminfo['admin']=="yes") { ?> selected="selected"<?php } ?>>Yes</option><option value="no"<?php if($meminfo['admin']=="no") { ?> selected="selected"<?php } ?>>No</option></select></td></tr>
    <tr><td style="text-align: center;">Items Entered:</td><td><?php echo $nummyitems; ?></td></tr>
    <tr><td style="text-align: center;">Pending Items:</td><td><?php echo $nummypendings; ?></td></tr>
    <tr><td style="text-align: center;">Item Edit Requests:</td><td><?php echo $nummymods; ?></td></tr>
   </table>
   <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>" />
   <input type="hidden" name="subact" value="editmember" />
   <div><br /><input type="submit" value="Edit Member" /></div>
   </form>
  </center>
 </body>
</html>
<?php } } if($_GET['act']=="editmember"&&!isset($_GET['id'])&&$_GET['subact']===NULL) { ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
 <head>
<title> <?php echo $sitename; ?>: AdminCP : Edit Member </title>
<?php echo $metatags; ?>
 </head>
 <body>
  <center>
   <?php echo $navbar; ?>
   <h2>Edit Member</h2>
   <?php
   $findmem = sqlite3_query($slite3, "SELECT COUNT(*) AS COUNT FROM \"".$table_prefix."members\" WHERE \"id\"<>1 ORDER BY \"id\" DESC;"); 
   $nummems = sql_fetch_assoc($findmem);
   $numrows = $nummems['COUNT'];
   if($numrows>0) {
   $maxpage = $_GET['page'] * 20;
   if($maxpage>$numrows) { $maxpage = $numrows; }
   $pagestart = $maxpage - 20;
   if($pagestart<0) { $pagestart = 0; }
   $pagestartshow = $pagestart + 1;
   $findmem = sqlite3_query($slite3, "SELECT * FROM \"".$table_prefix."members\" WHERE \"id\"<>1 ORDER BY \"id\" DESC LIMIT ".$pagestart.", ".$maxpage.";"); 
   if($maxpage>20&&$_GET['page']>1) {
   $backpage = $_GET['page'] - 1;
   echo "<a href=\"".$website_url.$url_admin_file."?act=editmember&amp;page=".$backpage."\">Prev</a> --\n"; }
   echo $numrows." members, displaying ".$pagestartshow." through ".$maxpage;
   if($pagestart<($numrows - 20)) {
   $nextpage = $_GET['page'] + 1;
   echo "\n-- <a href=\"".$website_url.$url_admin_file."?act=editmember&amp;page=".$nextpage."\">Next</a>"; }
   ?>
   <div><br /></div>
   <table class="list">
   <tr><th>Edit Member</th><th>Email</th><th>IP Address</th><th>Last Active</th></tr>
   <?php
   while ($meminfo = sql_fetch_assoc($findmem)) { ?>
   <tr valign="top">
   <td><a href="<?php echo $website_url.$url_admin_file; ?>?act=editmember&amp;id=<?php echo $meminfo['id']; ?>&amp;page=1"><?php echo htmlspecialchars($meminfo['name'], ENT_HTML401, "UTF-8"); ?></a></td>
   <td><?php echo htmlspecialchars($meminfo['email'], ENT_HTML401, "UTF-8"); ?></td>
   <td nowrap="nowrap"><?php echo $meminfo['ip']; ?></td>
   <td nowrap="nowrap"><?php echo date("j M Y, g:i A T", $meminfo['lastactive']); ?></td>
   </tr>
   <?php } echo "   </table>   <div><br /></div>"; }
   if($numrows>0) {
   if($maxpage>20&&$_GET['page']>1) {
   $backpage = $_GET['page'] - 1;
   echo "<a href=\"".$website_url.$url_admin_file."?act=editmember&amp;page=".$backpage."\">Prev</a> --\n"; }
   echo $numrows." members, displaying ".$pagestartshow." through ".$maxpage;
   if($pagestart<($numrows - 20)) {
   $nextpage = $_GET['page'] + 1;
   echo "\n-- <a href=\"".$website_url.$url_admin_file."?act=editmember&amp;page=".$nextpage."\">Next</a>"; } }
   ?>
  </center>
 </body>
</html>
<?php } ?>