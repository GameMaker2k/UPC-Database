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

    $FileInfo: members.php - Last Update: 02/13/2012 Ver. 2.2.5 RC 1 - Author: cooldude2k $
*/
$File3Name = basename($_SERVER['SCRIPT_NAME']);
if ($File3Name=="members.php"||$File3Name=="/members.php") {
	chdir("../");
	require("./upc.php");
	exit(); }

if(($_GET['act']=="login"||$_GET['act']=="signin")&&
	isset($_POST['username'])&&isset($_POST['password'])) {
    $_POST['username'] = trim($_POST['username']);
    $_POST['username'] = remove_spaces($_POST['username']);
    if($_POST['username']=="") {
    header("Location: ".$website_url.$url_file."?act=login"); exit(); }
    if(strlen($_POST['username'])>30) {
    header("Location: ".$website_url.$url_file."?act=login"); exit(); }
    if(strlen($_POST['password'])>60||$_POST['password']==""||$_POST['password']==NULL) {
    header("Location: ".$website_url.$url_file."?act=login"); exit(); }
	$findme = sqlite3_query($slite3, "SELECT COUNT(*) AS COUNT FROM \"".$table_prefix."members\" WHERE name='".sqlite3_escape_string($slite3, $_POST['username'])."';");
	$numfindme = sql_fetch_assoc($findme);
	$numfmrows = $numfindme['COUNT'];
	if($numfmrows<1) { $_GET['act'] = "login"; }
	if($numfmrows>0) {
	$findme = sqlite3_query($slite3, "SELECT * FROM \"".$table_prefix."members\" WHERE name='".sqlite3_escape_string($slite3, $_POST['username'])."';"); 
	$userinfo = sql_fetch_assoc($findme); $NewHashSalt = salt_hmac();
	//Used if you forget your password will change on next login.
	if($userinfo['hashtype']=="NoHash") { $PasswordCheck = $_POST['password']; }
	if($userinfo['hashtype']=="NoHASH") { $PasswordCheck = $_POST['password']; }
	if($userinfo['hashtype']=="PlainText") { $PasswordCheck = $_POST['password']; }
	if($userinfo['hashtype']=="md2") { 
	$PasswordCheck = b64e_hmac($_POST['password'],$userinfo['timestamp'],$userinfo['salt'],"md2"); }
	if($userinfo['hashtype']=="md4") { 
	$PasswordCheck = b64e_hmac($_POST['password'],$userinfo['timestamp'],$userinfo['salt'],"md4"); }
	if($userinfo['hashtype']=="md5") { 
	$PasswordCheck = b64e_hmac($_POST['password'],$userinfo['timestamp'],$userinfo['salt'],"md5"); }
	if($userinfo['hashtype']=="sha1") { 
	$PasswordCheck = b64e_hmac($_POST['password'],$userinfo['timestamp'],$userinfo['salt'],"sha1"); }
	if($userinfo['hashtype']=="sha224") { 
	$PasswordCheck = b64e_hmac($_POST['password'],$userinfo['timestamp'],$userinfo['salt'],"sha224"); }
	if($userinfo['hashtype']=="sha256") { 
	$PasswordCheck = b64e_hmac($_POST['password'],$userinfo['timestamp'],$userinfo['salt'],"sha256"); }
	if($userinfo['hashtype']=="sha384") { 
	$PasswordCheck = b64e_hmac($_POST['password'],$userinfo['timestamp'],$userinfo['salt'],"sha384"); }
	if($userinfo['hashtype']=="sha512") { 
	$PasswordCheck = b64e_hmac($_POST['password'],$userinfo['timestamp'],$userinfo['salt'],"sha512"); }
	if($userinfo['hashtype']=="ripemd128") { 
	$PasswordCheck = b64e_hmac($_POST['password'],$userinfo['timestamp'],$userinfo['salt'],"ripemd128"); }
	if($userinfo['hashtype']=="ripemd160") { 
	$PasswordCheck = b64e_hmac($_POST['password'],$userinfo['timestamp'],$userinfo['salt'],"ripemd160"); }
	if($userinfo['hashtype']=="ripemd256") { 
	$PasswordCheck = b64e_hmac($_POST['password'],$userinfo['timestamp'],$userinfo['salt'],"ripemd256"); }
	if($userinfo['hashtype']=="ripemd320") { 
	$PasswordCheck = b64e_hmac($_POST['password'],$userinfo['timestamp'],$userinfo['salt'],"ripemd320"); }
	if($userinfo['hashtype']=="salsa10") { 
	$PasswordCheck = b64e_hmac($_POST['password'],$userinfo['timestamp'],$userinfo['salt'],"salsa10"); }
	if($userinfo['hashtype']=="salsa20") { 
	$PasswordCheck = b64e_hmac($_POST['password'],$userinfo['timestamp'],$userinfo['salt'],"salsa20"); }
	if($userinfo['hashtype']=="snefru") { 
	$PasswordCheck = b64e_hmac($_POST['password'],$userinfo['timestamp'],$userinfo['salt'],"snefru"); }
	if($userinfo['hashtype']=="snefru256") { 
	$PasswordCheck = b64e_hmac($_POST['password'],$userinfo['timestamp'],$userinfo['salt'],"snefru256"); }
	if($userinfo['hashtype']=="gost") { 
	$PasswordCheck = b64e_hmac($_POST['password'],$userinfo['timestamp'],$userinfo['salt'],"gost"); }
	if($userinfo['hashtype']=="joaat") { 
	$PasswordCheck = b64e_hmac($_POST['password'],$userinfo['timestamp'],$userinfo['salt'],"joaat"); }
	if($usehashtype=="md2") { 
	$NewPassword = b64e_hmac($_POST['password'],$userinfo['timestamp'],$NewHashSalt,"md2"); }
	if($usehashtype=="md4") { 
	$NewPassword = b64e_hmac($_POST['password'],$userinfo['timestamp'],$NewHashSalt,"md4"); }
	if($usehashtype=="md5") { 
	$NewPassword = b64e_hmac($_POST['password'],$userinfo['timestamp'],$NewHashSalt,"md5"); }
	if($usehashtype=="sha1") { 
	$NewPassword = b64e_hmac($_POST['password'],$userinfo['timestamp'],$NewHashSalt,"sha1"); }
	if($usehashtype=="sha224") { 
	$NewPassword = b64e_hmac($_POST['password'],$userinfo['timestamp'],$NewHashSalt,"sha224"); }
	if($usehashtype=="sha256") { 
	$NewPassword = b64e_hmac($_POST['password'],$userinfo['timestamp'],$NewHashSalt,"sha256"); }
	if($usehashtype=="sha384") { 
	$NewPassword = b64e_hmac($_POST['password'],$userinfo['timestamp'],$NewHashSalt,"sha384"); }
	if($usehashtype=="sha512") { 
	$NewPassword = b64e_hmac($_POST['password'],$userinfo['timestamp'],$NewHashSalt,"sha512"); }
	if($usehashtype=="ripemd128") { 
	$NewPassword = b64e_hmac($_POST['password'],$userinfo['timestamp'],$NewHashSalt,"ripemd128"); }
	if($usehashtype=="ripemd160") { 
	$NewPassword = b64e_hmac($_POST['password'],$userinfo['timestamp'],$NewHashSalt,"ripemd160"); }
	if($usehashtype=="ripemd256") { 
	$NewPassword = b64e_hmac($_POST['password'],$userinfo['timestamp'],$NewHashSalt,"ripemd256"); }
	if($usehashtype=="ripemd320") { 
	$NewPassword = b64e_hmac($_POST['password'],$userinfo['timestamp'],$NewHashSalt,"ripemd320"); }
	if($usehashtype=="salsa10") { 
	$NewPassword = b64e_hmac($_POST['password'],$userinfo['timestamp'],$NewHashSalt,"salsa10"); }
	if($usehashtype=="salsa20") { 
	$NewPassword = b64e_hmac($_POST['password'],$userinfo['timestamp'],$NewHashSalt,"salsa20"); }
	if($usehashtype=="snefru") { 
	$NewPassword = b64e_hmac($_POST['password'],$userinfo['timestamp'],$NewHashSalt,"snefru"); }
	if($usehashtype=="snefru256") { 
	$NewPassword = b64e_hmac($_POST['password'],$userinfo['timestamp'],$NewHashSalt,"snefru256"); }
	if($usehashtype=="gost") { 
	$NewPassword = b64e_hmac($_POST['password'],$userinfo['timestamp'],$NewHashSalt,"gost"); }
	if($usehashtype=="joaat") { 
	$NewPassword = b64e_hmac($_POST['password'],$userinfo['timestamp'],$NewHashSalt,"joaat"); }
	if($userinfo['password']!=$PasswordCheck) { $_GET['act'] = "login"; 
	header("Location: ".$website_url.$url_file."?act=login"); exit(); } 
	if($userinfo['password']==$PasswordCheck) {
	$findupc = sqlite3_query($slite3, "SELECT COUNT(*) AS COUNT FROM \"".$table_prefix."pending\" WHERE \"userid\"='".$userinfo['id']."';");
	$numupc = sql_fetch_assoc($findupc);
	$nummypendings = $numupc['COUNT'];
	$findupc = sqlite3_query($slite3, "SELECT COUNT(*) AS COUNT FROM \"".$table_prefix."items\" WHERE \"userid\"='".$userinfo['id']."';");
	$numupc = sql_fetch_assoc($findupc);
	$nummyitems = $numupc['COUNT'];
	if($userinfo['numitems']!=$nummyitems&&$userinfo['numpending']==$nummypendings) {
	sqlite3_query($slite3, "UPDATE \"".$table_prefix."members\" SET \"numitems\"=".$nummyitems." WHERE \"id\"=".$userinfo['id'].";"); }
	if($userinfo['numitems']==$nummyitems&&$userinfo['numpending']!=$nummypendings) {
	sqlite3_query($slite3, "UPDATE \"".$table_prefix."members\" SET \"numpending\"=".$nummypendings." WHERE \"id\"=".$userinfo['id'].";"); }
	if($userinfo['numitems']!=$nummyitems&&$userinfo['numpending']!=$nummypendings) {
	sqlite3_query($slite3, "UPDATE \"".$table_prefix."members\" SET \"numitems\"=".$nummyitems.",\"numpending\"=".$nummypendings." WHERE \"id\"=".$userinfo['id'].";"); }
	sqlite3_query($slite3, "UPDATE \"".$table_prefix."members\" SET \"lastactive\"='".time()."',\"ip\"='".sqlite3_escape_string($slite3, $usersip)."',\"password\"='".sqlite3_escape_string($slite3, $NewPassword)."',\"salt\"='".sqlite3_escape_string($slite3, $NewHashSalt)."',\"hashtype\"='".sqlite3_escape_string($slite3, $usehashtype)."' WHERE \"name\"='".$userinfo['name']."' AND \"id\"=".$userinfo['id'].";");
	setcookie("MemberName", $userinfo['name'], time() + (7 * 86400), $cbasedir, $cookieDomain);
	setcookie("MemberID", $userinfo['id'], time() + (7 * 86400), $cbasedir, $cookieDomain);
	setcookie("SessPass", $NewPassword, time() + (7 * 86400), $cbasedir, $cookieDomain); 
	$_GET['act'] = "lookup"; header("Location: ".$website_url.$url_file."?act=lookup"); exit(); } } }
if(($_GET['act']=="join"||$_GET['act']=="signup")&&
	isset($_POST['username'])&&isset($_POST['email'])&&
	isset($_POST['password'])&&isset($_POST['passwordcheck'])&&
	$_POST['password']==$_POST['passwordcheck']) {
    $_POST['username'] = trim($_POST['username']);
    $_POST['username'] = remove_spaces($_POST['username']);
    $_POST['email'] = trim($_POST['email']);
    $_POST['email'] = remove_spaces($_POST['email']);
    if($_POST['username']==""||$_POST['username']==NULL) {
    header("Location: ".$website_url.$url_file."?act=join"); exit(); }
    if($_POST['email']==""||$_POST['email']==NULL) {
    header("Location: ".$website_url.$url_file."?act=join"); exit(); }
    if(strlen($_POST['username'])>30) {
    header("Location: ".$website_url.$url_file."?act=join"); exit(); }
    if(strlen($_POST['password'])>60||$_POST['password']==""||$_POST['password']==NULL) {
    header("Location: ".$website_url.$url_file."?act=join"); exit(); }
	$UserJoined = time(); $HashSalt = salt_hmac();
	if($usehashtype=="md2") { 
	$NewPassword = b64e_hmac($_POST['password'],$UserJoined,$HashSalt,"md2"); }
	if($usehashtype=="md4") { 
	$NewPassword = b64e_hmac($_POST['password'],$UserJoined,$HashSalt,"md4"); }
	if($usehashtype=="md5") { 
	$NewPassword = b64e_hmac($_POST['password'],$UserJoined,$HashSalt,"md5"); }
	if($usehashtype=="sha1") { 
	$NewPassword = b64e_hmac($_POST['password'],$UserJoined,$HashSalt,"sha1"); }
	if($usehashtype=="sha224") { 
	$NewPassword = b64e_hmac($_POST['password'],$UserJoined,$HashSalt,"sha224"); }
	if($usehashtype=="sha256") { 
	$NewPassword = b64e_hmac($_POST['password'],$UserJoined,$HashSalt,"sha256"); }
	if($usehashtype=="sha384") { 
	$NewPassword = b64e_hmac($_POST['password'],$UserJoined,$HashSalt,"sha384"); }
	if($usehashtype=="sha512") { 
	$NewPassword = b64e_hmac($_POST['password'],$UserJoined,$HashSalt,"sha512"); }
	if($usehashtype=="ripemd128") { 
	$NewPassword = b64e_hmac($_POST['password'],$UserJoined,$HashSalt,"ripemd128"); }
	if($usehashtype=="ripemd160") { 
	$NewPassword = b64e_hmac($_POST['password'],$UserJoined,$HashSalt,"ripemd160"); }
	if($usehashtype=="ripemd256") { 
	$NewPassword = b64e_hmac($_POST['password'],$UserJoined,$HashSalt,"ripemd256"); }
	if($usehashtype=="ripemd320") { 
	$NewPassword = b64e_hmac($_POST['password'],$UserJoined,$HashSalt,"ripemd320"); }
	if($usehashtype=="salsa10") { 
	$NewPassword = b64e_hmac($_POST['password'],$UserJoined,$HashSalt,"salsa10"); }
	if($usehashtype=="salsa20") { 
	$NewPassword = b64e_hmac($_POST['password'],$UserJoined,$HashSalt,"salsa20"); }
	if($usehashtype=="snefru") { 
	$NewPassword = b64e_hmac($_POST['password'],$UserJoined,$HashSalt,"snefru"); }
	if($usehashtype=="snefru256") { 
	$NewPassword = b64e_hmac($_POST['password'],$UserJoined,$HashSalt,"snefru256"); }
	if($usehashtype=="gost") { 
	$NewPassword = b64e_hmac($_POST['password'],$UserJoined,$HashSalt,"gost"); }
	if($usehashtype=="joaat") { 
	$NewPassword = b64e_hmac($_POST['password'],$UserJoined,$HashSalt,"joaat"); }
sqlite3_query($slite3, "INSERT INTO \"".$table_prefix."members\" (\"name\", \"password\", \"hashtype\", \"email\", \"timestamp\", \"lastactive\", \"validateitems\", \"validated\", \"numitems\", \"numpending\", \"admin\", \"ip\", \"salt\") VALUES ('".sqlite3_escape_string($slite3, $_POST['username'])."', '".sqlite3_escape_string($slite3, $NewPassword)."', '".sqlite3_escape_string($slite3, $usehashtype)."', '".sqlite3_escape_string($slite3, $_POST['email'])."', ".sqlite3_escape_string($slite3, $UserJoined).", ".sqlite3_escape_string($slite3, $UserJoined).", 'yes', 'no', 0, 0, 'no', '".sqlite3_escape_string($slite3, $usersip)."', '".sqlite3_escape_string($slite3, $HashSalt)."');"); 
$usersid = sqlite3_last_insert_rowid($slite3);
if($usersid>1&&$validate_members===false) { sqlite3_query($slite3, "UPDATE \"".$table_prefix."members\" SET \"validated\"='yes' WHERE \"name\"='".$_POST['username']."' AND \"id\"=".$usersid.";"); }
if($usersid==1) { sqlite3_query($slite3, "UPDATE \"".$table_prefix."members\" SET \"validated\"='yes',\"admin\"='yes' WHERE \"name\"='".$_POST['username']."' AND \"id\"=1;"); }
setcookie("MemberName", $_POST['username'], time() + (7 * 86400), $cbasedir, $cookieDomain);
setcookie("MemberID", $usersid, time() + (7 * 86400), $cbasedir, $cookieDomain);
setcookie("SessPass", $NewPassword, time() + (7 * 86400), $cbasedir, $cookieDomain);
$_GET['act'] = "lookup"; header("Location: ".$website_url.$url_file."?act=lookup"); exit(); }
if($_GET['act']=="join"||$_GET['act']=="signup") { ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
 <head>
<title> <?php echo $sitename; ?>: Create an Account </title>
<?php echo $metatags; ?>
 </head>

 <body>
  <center>
   <?php echo $navbar; ?>
   <h2>Create an Account</h2>
   <form action="<?php echo $website_url.$url_file; ?>?act=join" method="post">
    <table>
    <tr><td style="text-align: center;">Username:</td><td><input type="text" name="username" /></td></tr>
    <tr><td style="text-align: center;">Password:</td><td><input type="password" name="password" /></td></tr>
    <tr><td style="text-align: center;">Confirm Password:</td><td><input type="password" name="passwordcheck" /></td></tr>
    <tr><td style="text-align: center;">Email address:</td><td><input type="text" name="email" /></td></tr>
   </table>
   <div><br /><input type="submit" value="Sign Up!" /></div>
   </form>
  </center>
 </body>
</html>
<?php } if($_GET['act']=="login"||$_GET['act']=="signin") { ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
 <head>
<title> <?php echo $sitename; ?>: Log In </title>
<?php echo $metatags; ?>
 </head>

 <body>
  <center>
   <?php echo $navbar; ?>
   <h2>Log In</h2>
   <form action="<?php echo $website_url.$url_file; ?>?act=login" method="post">
    <table>
    <tr><td style="text-align: center;">Username:</td><td><input type="text" name="username" /></td></tr>
    <tr><td style="text-align: center;">Password:</td><td><input type="password" name="password" /></td></tr>
   </table>
   <div><br /><input type="submit" value="Log In!" /></div>
   </form>
  </center>
 </body>
</html>
<?php } if($_GET['act']=="usr"||$_GET['act']=="user") { 
if($_GET['id']<=0) { $_GET['id'] = NULL; }
if(!is_numeric($_GET['id'])&&!isset($_COOKIE['MemberID'])) {
	$_GET['id'] = 1; }
if(!is_numeric($_GET['id'])&&isset($_COOKIE['MemberID'])&&!is_numeric($_COOKIE['MemberID'])) {
	$_GET['id'] = 1; }
if(!is_numeric($_GET['id'])&&isset($_COOKIE['MemberID'])&&is_numeric($_COOKIE['MemberID'])) {
	$_GET['id'] = $_COOKIE['MemberID']; }
$findmem = sqlite3_query($slite3, "SELECT COUNT(*) AS COUNT FROM \"".$table_prefix."members\" WHERE \"id\"=".$_GET['id'].";");
$nummems = sql_fetch_assoc($findmem);
$numrows = $nummems['COUNT'];
if($numrows<=0) { $_GET['id'] = 1;
$findmem = sqlite3_query($slite3, "SELECT COUNT(*) AS COUNT FROM \"".$table_prefix."members\" WHERE \"id\"=".$_GET['id'].";");
$nummems = sql_fetch_assoc($findmem);
$numrows = $nummems['COUNT']; }
if($numrows>0) { 
$findmem = sqlite3_query($slite3, "SELECT * FROM \"".$table_prefix."members\" WHERE \"id\"=".$_GET['id'].";"); 
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
<title> <?php echo $sitename; ?>: UPC Database User Info </title>
<?php echo $metatags; ?>
 </head>

 <body>
  <center>
   <?php echo $navbar; ?>
   <h2>UPC Database User Info</h2>
    <table>
     <tr><td>Username:</td><td><?php echo htmlspecialchars($meminfo['name'], ENT_HTML401, "UTF-8"); ?></td></tr>
	 <?php if((isset($_COOKIE['MemberID'])&&$_COOKIE['MemberID']==$meminfo['id'])||
			  ($usersiteinfo['admin']=="yes")) { ?>
     <tr><td>Email:</td><td><?php echo htmlspecialchars($meminfo['email'], ENT_HTML401, "UTF-8"); ?></td></tr>
	 <?php } ?>
     <tr><td>Items Entered:</td><td><?php echo $nummyitems; ?></td></tr>
     <tr><td>Items Entered:</td><td><?php echo $nummypendings; ?></td></tr>
     <tr><td>Item Edit Requests:</td><td><?php echo $nummymods; ?></td></tr>
     <tr><td>Last Active:</td><td><?php echo date("j M Y, g:i A T", $meminfo['lastactive']); ?></td></tr>
	 <?php if((isset($_COOKIE['MemberID'])&&$_COOKIE['MemberID']==$meminfo['id'])||
			  ($usersiteinfo['admin']=="yes")) { ?>
     <tr><td>IP Address:</td><td><?php echo $meminfo['ip']; ?></td></tr>
	 <?php } ?>
    </table>
    <form action="<?php echo $website_url.$url_file; ?>?act=lookup" method="get">
    <input type="hidden" name="act" value="lookup" />
    <div><br /></div>
    <table>
     <tr><td style="text-align: center;"><input type="text" name="upc" size="16" maxlength="13" value="<?php echo $lookupupc; ?>" /> <input type="submit" value="Look Up UPC" /></td></tr>
    </table>
   </form>
  </center>
 </body>
</html>
<?php } } ?>