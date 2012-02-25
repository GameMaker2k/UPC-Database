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

    $FileInfo: barcode.php - Last Update: 02/13/2012 Ver. 2.2.5 RC 1 - Author: cooldude2k $
*/

require("./settings.php");

if($usersiteinfo['admin']=="no") { 
	$_GET['act'] = "lookup"; header("Location: ".$website_url.$url_file."?act=lookup"); exit(); }

if(!isset($_COOKIE['MemberName'])||!isset($_COOKIE['MemberID'])||!isset($_COOKIE['SessPass'])) {
	$_GET['act'] = "lookup"; header("Location: ".$website_url.$url_file."?act=lookup"); exit(); }

if(!isset($_GET['act'])&&isset($_POST['act'])) { $_GET['act'] = $_POST['act']; }
if(!isset($_GET['act'])) { $_GET['act'] = "view"; }
if(!isset($_GET['subact'])&&isset($_POST['subact'])) { $_GET['subact'] = $_POST['subact']; }
if(!isset($_GET['subact'])) { $_GET['subact'] = NULL; }
if(!isset($_POST['upc'])&&isset($_GET['upc'])) { $_POST['upc'] = $_GET['upc']; }
if(!isset($_GET['upc'])&&isset($_POST['upc'])) { $_GET['upc'] = $_POST['upc']; }
if(!isset($_POST['upc'])) { $_POST['upc'] = NULL; }
if(!isset($_POST['id'])&&isset($_GET['id'])) { $_POST['id'] = $_GET['id']; }
if(!isset($_GET['id'])&&isset($_POST['id'])) { $_GET['id'] = $_POST['id']; }
if(!isset($_POST['id'])) { $_POST['id'] = NULL; }
if(strlen($_POST['upc'])>0&&(strlen($_POST['upc'])<13||strlen($_POST['upc'])>13)) {
	$_GET['act'] = "view"; header("Location: ".$website_url.$url_admin_file."?act=view"); exit(); }
if(strlen($_POST['upc'])>0&&validate_ean13($_POST['upc'])===false) { 
	$_GET['act'] = "view"; header("Location: ".$website_url.$url_admin_file."?act=view"); exit(); }

if(!isset($_GET['page'])&&isset($_POST['page'])) { $_GET['page'] = $_POST['page']; }
if(!isset($_GET['page'])) { $_GET['page'] = 1; }
if(!is_numeric($_GET['page'])) { $_GET['page'] = 1; }

$navbar = $navbar."<br />\n   <div><a href=\"".$website_url.$url_admin_file."?act=deleteupc\">Delete UPC</a> | <a href=\"".$website_url.$url_admin_file."?act=validateupc\">Validate UPC</a> | <a href=\"".$website_url.$url_admin_file."?act=editupc\">Edit UPC</a> | <a href=\"".$website_url.$url_admin_file."?act=upcdelrequests\">UPC Delete Requests</a> | <a href=\"".$website_url.$url_admin_file."?act=upceditrequests\">UPC Edit Request</a></div>";
$navbar = $navbar."\n   <div><a href=\"".$website_url.$url_admin_file."?act=deletemember\">Delete Member</a> | <a href=\"".$website_url.$url_admin_file."?act=validatemember\">Validate Member</a> | <a href=\"".$website_url.$url_admin_file."?act=editmember\">Edit Member</a></div>";

if($_GET['act']=="deleteupc"||$_GET['act']=="validateupc"||
	$_GET['act']=="editupc"||$_GET['act']=="upcdelrequests"||
	$_GET['act']=="upceditrequests") { 
require("./misc/adminupc.php"); }

if($_GET['act']=="deletemember"||$_GET['act']=="validatemember"||
	$_GET['act']=="editmember") { 
require("./misc/adminmem.php"); }

if($_GET['act']=="view") { ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
 <head>
<title> <?php echo $sitename; ?>: AdminCP </title>
<?php echo $metatags; ?>
 </head>
 <body>
  <center>
   <?php echo $navbar; ?>
   <h2>AdminCP</h2>
   <form action="<?php echo $website_url.$url_file; ?>?act=lookup" method="get">
    <input type="hidden" name="act" value="lookup" />
    <table>
     <tr><td style="text-align: center;"><input type="text" name="upc" size="16" maxlength="13" value="<?php echo $lookupupc; ?>" /> <input type="submit" value="Look Up UPC" /></td></tr>
    </table>
   </form>
  </center>
 </body>
</html>
<?php } 
sqlite3_query($slite3, "VACUUM;");
sqlite3_close($slite3); ?>