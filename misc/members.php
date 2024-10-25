<?php
/*
    This program is free software; you can redistribute it and/or modify
    it under the terms of the Revised BSD License.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    Revised BSD License for more details.

    Copyright 2011-2024 Cool Dude 2k - http://idb.berlios.de/
    Copyright 2011-2024 Game Maker 2k - http://intdb.sourceforge.net/
    Copyright 2011-2024 Kazuki Przyborowski - https://github.com/KazukiPrzyborowski

    $FileInfo: members.php - Last Update: 10/24/2024 Ver. 2.2.5 RC 1 - Author: cooldude2k $
*/
$File3Name = basename($_SERVER['SCRIPT_NAME']);
if ($File3Name == "members.php" || $File3Name == "/members.php") {
    chdir("../");
    require("./upc.php");
    exit();
}

if (($_GET['act'] == "login" || $_GET['act'] == "signin") &&
    isset($_POST['username']) && isset($_POST['password'])) {
    $_POST['username'] = trim($_POST['username']);
    $_POST['username'] = remove_spaces($_POST['username']);
    if ($_POST['username'] == "") {
        header("Location: ".$website_url.$url_file."?act=login");
        exit();
    }
    if (strlen($_POST['username']) > 30) {
        header("Location: ".$website_url.$url_file."?act=login");
        exit();
    }
    if (strlen($_POST['password']) > 60 || $_POST['password'] == "" || $_POST['password'] == null) {
        header("Location: ".$website_url.$url_file."?act=login");
        exit();
    }
    $findme = sqlite3_query($slite3, "SELECT COUNT(*) AS count FROM \"".$table_prefix."members\" WHERE name='".sqlite3_escape_string($slite3, $_POST['username'])."';");
    $numfindme = sql_fetch_assoc($findme);
    $numfmrows = $numfindme['count'];
    if ($numfmrows < 1) {
        $_GET['act'] = "login";
    }
    if ($numfmrows > 0) {
        $findme = sqlite3_query($slite3, "SELECT * FROM \"".$table_prefix."members\" WHERE name='".sqlite3_escape_string($slite3, $_POST['username'])."';");
        $userinfo = sql_fetch_assoc($findme);
        $NewHashSalt = salt_hmac();
        //Used if you forget your password will change on next login.
        if ($userinfo['hashtype'] == "NoHash") {
            $PasswordCheck = $_POST['password'];
        }
        if ($userinfo['hashtype'] == "NoHASH") {
            $PasswordCheck = $_POST['password'];
        }
        if ($userinfo['hashtype'] == "PlainText") {
            $PasswordCheck = $_POST['password'];
        }
        if ($userinfo['hashtype'] == "md2") {
            $PasswordCheck = b64e_hmac($_POST['password'], $userinfo['timestamp'], $userinfo['salt'], "md2");
        }
        if ($userinfo['hashtype'] == "md4") {
            $PasswordCheck = b64e_hmac($_POST['password'], $userinfo['timestamp'], $userinfo['salt'], "md4");
        }
        if ($userinfo['hashtype'] == "md5") {
            $PasswordCheck = b64e_hmac($_POST['password'], $userinfo['timestamp'], $userinfo['salt'], "md5");
        }
        if ($userinfo['hashtype'] == "sha1") {
            $PasswordCheck = b64e_hmac($_POST['password'], $userinfo['timestamp'], $userinfo['salt'], "sha1");
        }
        if ($userinfo['hashtype'] == "sha224") {
            $PasswordCheck = b64e_hmac($_POST['password'], $userinfo['timestamp'], $userinfo['salt'], "sha224");
        }
        if ($userinfo['hashtype'] == "sha256") {
            $PasswordCheck = b64e_hmac($_POST['password'], $userinfo['timestamp'], $userinfo['salt'], "sha256");
        }
        if ($userinfo['hashtype'] == "sha384") {
            $PasswordCheck = b64e_hmac($_POST['password'], $userinfo['timestamp'], $userinfo['salt'], "sha384");
        }
        if ($userinfo['hashtype'] == "sha512") {
            $PasswordCheck = b64e_hmac($_POST['password'], $userinfo['timestamp'], $userinfo['salt'], "sha512");
        }
        if ($userinfo['hashtype'] == "ripemd128") {
            $PasswordCheck = b64e_hmac($_POST['password'], $userinfo['timestamp'], $userinfo['salt'], "ripemd128");
        }
        if ($userinfo['hashtype'] == "ripemd160") {
            $PasswordCheck = b64e_hmac($_POST['password'], $userinfo['timestamp'], $userinfo['salt'], "ripemd160");
        }
        if ($userinfo['hashtype'] == "ripemd256") {
            $PasswordCheck = b64e_hmac($_POST['password'], $userinfo['timestamp'], $userinfo['salt'], "ripemd256");
        }
        if ($userinfo['hashtype'] == "ripemd320") {
            $PasswordCheck = b64e_hmac($_POST['password'], $userinfo['timestamp'], $userinfo['salt'], "ripemd320");
        }
        if ($userinfo['hashtype'] == "salsa10") {
            $PasswordCheck = b64e_hmac($_POST['password'], $userinfo['timestamp'], $userinfo['salt'], "salsa10");
        }
        if ($userinfo['hashtype'] == "salsa20") {
            $PasswordCheck = b64e_hmac($_POST['password'], $userinfo['timestamp'], $userinfo['salt'], "salsa20");
        }
        if ($userinfo['hashtype'] == "snefru") {
            $PasswordCheck = b64e_hmac($_POST['password'], $userinfo['timestamp'], $userinfo['salt'], "snefru");
        }
        if ($userinfo['hashtype'] == "snefru256") {
            $PasswordCheck = b64e_hmac($_POST['password'], $userinfo['timestamp'], $userinfo['salt'], "snefru256");
        }
        if ($userinfo['hashtype'] == "gost") {
            $PasswordCheck = b64e_hmac($_POST['password'], $userinfo['timestamp'], $userinfo['salt'], "gost");
        }
        if ($userinfo['hashtype'] == "joaat") {
            $PasswordCheck = b64e_hmac($_POST['password'], $userinfo['timestamp'], $userinfo['salt'], "joaat");
        }
        if ($usehashtype == "md2") {
            $NewPassword = b64e_hmac($_POST['password'], $userinfo['timestamp'], $NewHashSalt, "md2");
        }
        if ($usehashtype == "md4") {
            $NewPassword = b64e_hmac($_POST['password'], $userinfo['timestamp'], $NewHashSalt, "md4");
        }
        if ($usehashtype == "md5") {
            $NewPassword = b64e_hmac($_POST['password'], $userinfo['timestamp'], $NewHashSalt, "md5");
        }
        if ($usehashtype == "sha1") {
            $NewPassword = b64e_hmac($_POST['password'], $userinfo['timestamp'], $NewHashSalt, "sha1");
        }
        if ($usehashtype == "sha224") {
            $NewPassword = b64e_hmac($_POST['password'], $userinfo['timestamp'], $NewHashSalt, "sha224");
        }
        if ($usehashtype == "sha256") {
            $NewPassword = b64e_hmac($_POST['password'], $userinfo['timestamp'], $NewHashSalt, "sha256");
        }
        if ($usehashtype == "sha384") {
            $NewPassword = b64e_hmac($_POST['password'], $userinfo['timestamp'], $NewHashSalt, "sha384");
        }
        if ($usehashtype == "sha512") {
            $NewPassword = b64e_hmac($_POST['password'], $userinfo['timestamp'], $NewHashSalt, "sha512");
        }
        if ($usehashtype == "ripemd128") {
            $NewPassword = b64e_hmac($_POST['password'], $userinfo['timestamp'], $NewHashSalt, "ripemd128");
        }
        if ($usehashtype == "ripemd160") {
            $NewPassword = b64e_hmac($_POST['password'], $userinfo['timestamp'], $NewHashSalt, "ripemd160");
        }
        if ($usehashtype == "ripemd256") {
            $NewPassword = b64e_hmac($_POST['password'], $userinfo['timestamp'], $NewHashSalt, "ripemd256");
        }
        if ($usehashtype == "ripemd320") {
            $NewPassword = b64e_hmac($_POST['password'], $userinfo['timestamp'], $NewHashSalt, "ripemd320");
        }
        if ($usehashtype == "salsa10") {
            $NewPassword = b64e_hmac($_POST['password'], $userinfo['timestamp'], $NewHashSalt, "salsa10");
        }
        if ($usehashtype == "salsa20") {
            $NewPassword = b64e_hmac($_POST['password'], $userinfo['timestamp'], $NewHashSalt, "salsa20");
        }
        if ($usehashtype == "snefru") {
            $NewPassword = b64e_hmac($_POST['password'], $userinfo['timestamp'], $NewHashSalt, "snefru");
        }
        if ($usehashtype == "snefru256") {
            $NewPassword = b64e_hmac($_POST['password'], $userinfo['timestamp'], $NewHashSalt, "snefru256");
        }
        if ($usehashtype == "gost") {
            $NewPassword = b64e_hmac($_POST['password'], $userinfo['timestamp'], $NewHashSalt, "gost");
        }
        if ($usehashtype == "joaat") {
            $NewPassword = b64e_hmac($_POST['password'], $userinfo['timestamp'], $NewHashSalt, "joaat");
        }
        if ($userinfo['password'] != $PasswordCheck) {
            $_GET['act'] = "login";
            header("Location: ".$website_url.$url_file."?act=login");
            exit();
        }
        if ($userinfo['password'] == $PasswordCheck) {
            $findupc = sqlite3_query($slite3, "SELECT COUNT(*) AS count FROM \"".$table_prefix."pending\" WHERE \"userid\"='".sqlite3_escape_string($slite3, $userinfo['id'])."';");
            $numupc = sql_fetch_assoc($findupc);
            $nummypendings = $numupc['count'];
            $findupc = sqlite3_query($slite3, "SELECT COUNT(*) AS count FROM \"".$table_prefix."items\" WHERE \"userid\"='".sqlite3_escape_string($slite3, $userinfo['id'])."';");
            $numupc = sql_fetch_assoc($findupc);
            $nummyitems = $numupc['count'];
            if ($userinfo['numitems'] != $nummyitems && $userinfo['numpending'] == $nummypendings) {
                sqlite3_query($slite3, "UPDATE \"".$table_prefix."members\" SET \"numitems\"=".sqlite3_escape_string($slite3, $nummyitems)." WHERE \"id\"=".sqlite3_escape_string($slite3, $userinfo['id']).";");
            }
            if ($userinfo['numitems'] == $nummyitems && $userinfo['numpending'] != $nummypendings) {
                sqlite3_query($slite3, "UPDATE \"".$table_prefix."members\" SET \"numpending\"=".sqlite3_escape_string($slite3, $nummypendings)." WHERE \"id\"=".sqlite3_escape_string($slite3, $userinfo['id']).";");
            }
            if ($userinfo['numitems'] != $nummyitems && $userinfo['numpending'] != $nummypendings) {
                sqlite3_query($slite3, "UPDATE \"".$table_prefix."members\" SET \"numitems\"=".sqlite3_escape_string($slite3, $nummyitems).",\"numpending\"=".sqlite3_escape_string($slite3, $nummypendings)." WHERE \"id\"=".sqlite3_escape_string($slite3, $userinfo['id']).";");
            }
            sqlite3_query($slite3, "UPDATE \"".$table_prefix."members\" SET \"lastactive\"='".time()."',\"ip\"='".sqlite3_escape_string($slite3, $usersip)."',\"password\"='".sqlite3_escape_string($slite3, $NewPassword)."',\"salt\"='".sqlite3_escape_string($slite3, $NewHashSalt)."',\"hashtype\"='".sqlite3_escape_string($slite3, $usehashtype)."' WHERE \"name\"='".sqlite3_escape_string($slite3, $userinfo['name'])."' AND \"id\"=".sqlite3_escape_string($slite3, $userinfo['id']).";");
            setcookie("MemberName", $userinfo['name'], time() + (7 * 86400), $cbasedir, $cookieDomain);
            setcookie("MemberID", $userinfo['id'], time() + (7 * 86400), $cbasedir, $cookieDomain);
            setcookie("SessPass", $NewPassword, time() + (7 * 86400), $cbasedir, $cookieDomain);
            $_GET['act'] = "lookup";
            header("Location: ".$website_url.$url_file."?act=lookup");
            exit();
        }
    }
}
if (($_GET['act'] == "join" || $_GET['act'] == "signup") &&
    isset($_POST['username']) && isset($_POST['email']) &&
    isset($_POST['password']) && isset($_POST['passwordcheck']) &&
    $_POST['password'] == $_POST['passwordcheck']) {
    $_POST['username'] = trim($_POST['username']);
    $_POST['username'] = remove_spaces($_POST['username']);
    $_POST['email'] = trim($_POST['email']);
    $_POST['email'] = remove_spaces($_POST['email']);
    if ($_POST['username'] == "" || $_POST['username'] == null) {
        header("Location: ".$website_url.$url_file."?act=join");
        exit();
    }
    if ($_POST['email'] == "" || $_POST['email'] == null) {
        header("Location: ".$website_url.$url_file."?act=join");
        exit();
    }
    if (strlen($_POST['username']) > 30) {
        header("Location: ".$website_url.$url_file."?act=join");
        exit();
    }
    if (strlen($_POST['password']) > 60 || $_POST['password'] == "" || $_POST['password'] == null) {
        header("Location: ".$website_url.$url_file."?act=join");
        exit();
    }
    $UserJoined = time();
    $HashSalt = salt_hmac();
    if ($usehashtype == "md2") {
        $NewPassword = b64e_hmac($_POST['password'], $UserJoined, $HashSalt, "md2");
    }
    if ($usehashtype == "md4") {
        $NewPassword = b64e_hmac($_POST['password'], $UserJoined, $HashSalt, "md4");
    }
    if ($usehashtype == "md5") {
        $NewPassword = b64e_hmac($_POST['password'], $UserJoined, $HashSalt, "md5");
    }
    if ($usehashtype == "sha1") {
        $NewPassword = b64e_hmac($_POST['password'], $UserJoined, $HashSalt, "sha1");
    }
    if ($usehashtype == "sha224") {
        $NewPassword = b64e_hmac($_POST['password'], $UserJoined, $HashSalt, "sha224");
    }
    if ($usehashtype == "sha256") {
        $NewPassword = b64e_hmac($_POST['password'], $UserJoined, $HashSalt, "sha256");
    }
    if ($usehashtype == "sha384") {
        $NewPassword = b64e_hmac($_POST['password'], $UserJoined, $HashSalt, "sha384");
    }
    if ($usehashtype == "sha512") {
        $NewPassword = b64e_hmac($_POST['password'], $UserJoined, $HashSalt, "sha512");
    }
    if ($usehashtype == "ripemd128") {
        $NewPassword = b64e_hmac($_POST['password'], $UserJoined, $HashSalt, "ripemd128");
    }
    if ($usehashtype == "ripemd160") {
        $NewPassword = b64e_hmac($_POST['password'], $UserJoined, $HashSalt, "ripemd160");
    }
    if ($usehashtype == "ripemd256") {
        $NewPassword = b64e_hmac($_POST['password'], $UserJoined, $HashSalt, "ripemd256");
    }
    if ($usehashtype == "ripemd320") {
        $NewPassword = b64e_hmac($_POST['password'], $UserJoined, $HashSalt, "ripemd320");
    }
    if ($usehashtype == "salsa10") {
        $NewPassword = b64e_hmac($_POST['password'], $UserJoined, $HashSalt, "salsa10");
    }
    if ($usehashtype == "salsa20") {
        $NewPassword = b64e_hmac($_POST['password'], $UserJoined, $HashSalt, "salsa20");
    }
    if ($usehashtype == "snefru") {
        $NewPassword = b64e_hmac($_POST['password'], $UserJoined, $HashSalt, "snefru");
    }
    if ($usehashtype == "snefru256") {
        $NewPassword = b64e_hmac($_POST['password'], $UserJoined, $HashSalt, "snefru256");
    }
    if ($usehashtype == "gost") {
        $NewPassword = b64e_hmac($_POST['password'], $UserJoined, $HashSalt, "gost");
    }
    if ($usehashtype == "joaat") {
        $NewPassword = b64e_hmac($_POST['password'], $UserJoined, $HashSalt, "joaat");
    }
    sqlite3_query($slite3, "INSERT INTO \"".$table_prefix."members\" (\"name\", \"password\", \"hashtype\", \"email\", \"timestamp\", \"lastactive\", \"canviewsite\", \"validateitems\", \"canaddupc\", \"canmakeeditreq\", \"canmakedelreq\", \"canuseupcapi\", \"validated\", \"bantime\", \"numitems\", \"numpending\", \"numdelreq\", \"admin\", \"ip\", \"salt\") VALUES ('".sqlite3_escape_string($slite3, $_POST['username'])."', '".sqlite3_escape_string($slite3, $NewPassword)."', '".sqlite3_escape_string($slite3, $usehashtype)."', '".sqlite3_escape_string($slite3, $_POST['email'])."', ".sqlite3_escape_string($slite3, $UserJoined).", ".sqlite3_escape_string($slite3, $UserJoined).", 'yes', 'no', 'yes', 'yes', 'yes', 'yes', 'no', 0, 0, 0, 0, 'no', '".sqlite3_escape_string($slite3, $usersip)."', '".sqlite3_escape_string($slite3, $HashSalt)."');");
    $usersid = sqlite3_last_insert_rowid($slite3);
    if ($usersid > 1 && $validate_members === false) {
        sqlite3_query($slite3, "UPDATE \"".$table_prefix."members\" SET \"validated\"='yes' WHERE \"name\"='".sqlite3_escape_string($slite3, $_POST['username'])."' AND \"id\"=".sqlite3_escape_string($slite3, $usersid).";");
    }
    if ($usersid == 1) {
        sqlite3_query($slite3, "UPDATE \"".$table_prefix."members\" SET \"validated\"='yes',\"admin\"='yes' WHERE \"name\"='".sqlite3_escape_string($slite3, $_POST['username'])."' AND \"id\"=1;");
    }
    setcookie("MemberName", $_POST['username'], time() + (7 * 86400), $cbasedir, $cookieDomain);
    setcookie("MemberID", $usersid, time() + (7 * 86400), $cbasedir, $cookieDomain);
    setcookie("SessPass", $NewPassword, time() + (7 * 86400), $cbasedir, $cookieDomain);
    $_GET['act'] = "lookup";
    header("Location: ".$website_url.$url_file."?act=lookup");
    exit();
}
if ($_GET['act'] == "join" || $_GET['act'] == "signup") { ?>
<!DOCTYPE html>
<html lang="en">
 <head>
<title> <?php echo $sitename; ?>: Create an Account </title>
<?php echo $metatags; ?>
 </head>

 <body>
  <center>
   <?php echo $navbar; ?>
   <h2>Create an Account</h2>
   <form action="<?php echo $url_file; ?>?act=join" method="post">
    <table>
    <tr><td style="text-align: center;">Username:</td><td><input type="text" name="username" /></td></tr>
    <tr><td style="text-align: center;">Password:</td><td><input type="password" name="password" /></td></tr>
    <tr><td style="text-align: center;">Confirm Password:</td><td><input type="password" name="passwordcheck" /></td></tr>
    <tr><td style="text-align: center;">Email address:</td><td><input type="text" name="email" /></td></tr>
   </table>
   <div><br /><input type="submit" value="Sign Up!" /></div>
   </form>
  </center>
  <?php echo $endhtmltag; ?>
<?php } if ($_GET['act'] == "login" || $_GET['act'] == "signin") { ?>
<!DOCTYPE html>
<html lang="en">
 <head>
<title> <?php echo $sitename; ?>: Log In </title>
<?php echo $metatags; ?>
 </head>

 <body>
  <center>
   <?php echo $navbar; ?>
   <h2>Log In</h2>
   <form action="<?php echo $url_file; ?>?act=login" method="post">
    <table>
    <tr><td style="text-align: center;">Username:</td><td><input type="text" name="username" /></td></tr>
    <tr><td style="text-align: center;">Password:</td><td><input type="password" name="password" /></td></tr>
   </table>
   <div><br /><input type="submit" value="Log In!" /></div>
   </form>
  </center>
  <?php echo $endhtmltag; ?>
<?php } if ($_GET['act'] == "usr" || $_GET['act'] == "user") {
      if (!isset($_GET['id']) && !isset($_COOKIE['MemberID'])) {
          $_GET['id'] = 1;
      }
      if (!isset($_GET['id']) && isset($_COOKIE['MemberID']) && is_numeric($_COOKIE['MemberID'])) {
          $_GET['id'] = intval($_COOKIE['MemberID']);
      }
      if (!isset($_GET['id']) && isset($_COOKIE['MemberID']) && !is_numeric($_COOKIE['MemberID'])) {
          $_GET['id'] = 1;
      }
      if (!is_numeric($_GET['id']) && !isset($_COOKIE['MemberID'])) {
          $_GET['id'] = 1;
      }
      if (!is_numeric($_GET['id']) && isset($_COOKIE['MemberID']) && !is_numeric($_COOKIE['MemberID'])) {
          $_GET['id'] = 1;
      }
      if (!is_numeric($_GET['id']) && isset($_COOKIE['MemberID']) && is_numeric($_COOKIE['MemberID'])) {
          $_GET['id'] = intval($_COOKIE['MemberID']);
      }
      if ($_GET['id'] <= 0) {
          $_GET['id'] = 1;
      }
      $findmem = sqlite3_query($slite3, "SELECT COUNT(*) AS count FROM \"".$table_prefix."members\" WHERE \"id\"=".sqlite3_escape_string($slite3, $_GET['id']).";");
      $nummems = sql_fetch_assoc($findmem);
      $numrows = $nummems['count'];
      if ($numrows <= 0) {
          $_GET['id'] = 1;
          $findmem = sqlite3_query($slite3, "SELECT COUNT(*) AS count FROM \"".$table_prefix."members\" WHERE \"id\"=".sqlite3_escape_string($slite3, $_GET['id']).";");
          $nummems = sql_fetch_assoc($findmem);
          $numrows = $nummems['count'];
      }
      if ($numrows > 0) {
          $findmem = sqlite3_query($slite3, "SELECT * FROM \"".$table_prefix."members\" WHERE \"id\"=".sqlite3_escape_string($slite3, $_GET['id']).";");
          $meminfo = sql_fetch_assoc($findmem);
          /*
          $findupc = sqlite3_query($slite3, "SELECT COUNT(*) AS count FROM \"".$table_prefix."items\" WHERE \"userid\"='".sqlite3_escape_string($slite3, $meminfo['id'])."';");
          $nummems = sql_fetch_assoc($findupc);
          $nummyitems = $nummems['count'];
          $findupc = sqlite3_query($slite3, "SELECT COUNT(*) AS count FROM \"".$table_prefix."pending\" WHERE \"userid\"='".sqlite3_escape_string($slite3, $meminfo['id'])."';");
          $nummems = sql_fetch_assoc($findupc);
          $nummypendings = $nummems['count'];
          */
          $nummyitems = $meminfo['numitems'];
          $nummypendings = $meminfo['numpending'];
          $findupc = sqlite3_query($slite3, "SELECT COUNT(*) AS count FROM \"".$table_prefix."modupc\" WHERE \"userid\"='".sqlite3_escape_string($slite3, $meminfo['id'])."';");
          $nummems = sql_fetch_assoc($findupc);
          $nummymods = $nummems['count'];
          ?>
<!DOCTYPE html>
<html lang="en">
 <head>
<title> <?php echo $sitename; ?>: UPC Database User Info </title>
<?php echo $metatags; ?>
 </head>

 <body>
  <center>
   <?php echo $navbar; ?>
   <h2>UPC Database User Info</h2>
    <table>
     <tr><td>Username:</td><td><?php echo htmlspecialchars($meminfo['name'], ENT_COMPAT | ENT_HTML5, "UTF-8"); ?></td></tr>
	 <?php if ((isset($_COOKIE['MemberID']) && $_COOKIE['MemberID'] == $meminfo['id']) ||
                        ($usersiteinfo['admin'] == "yes")) { ?>
     <tr><td>Email:</td><td><?php echo htmlspecialchars($meminfo['email'], ENT_COMPAT | ENT_HTML5, "UTF-8"); ?></td></tr>
	 <?php } ?>
     <tr><td>Items Entered:</td><td><?php if ($nummyitems > 0) { ?><a href="<?php echo $url_file; ?>?act=latest&amp;id=<?php echo $meminfo['id']; ?>&amp;page=1"><?php } echo $nummyitems;
          if ($nummyitems > 0) { ?></a><?php } ?></td></tr>
     <tr><td>Pending Items:</td><td><?php echo $nummypendings; ?></td></tr>
     <tr><td>Item Edit Requests:</td><td><?php echo $nummymods; ?></td></tr>
     <tr><td>Last Active:</td><td><?php echo date("j M Y, g:i A T", $meminfo['lastactive']); ?></td></tr>
	 <?php if ((isset($_COOKIE['MemberID']) && $_COOKIE['MemberID'] == $meminfo['id']) ||
                   ($usersiteinfo['admin'] == "yes")) { ?>
     <tr><td>IP Address:</td><td><?php echo $meminfo['ip']; ?></td></tr>
	 <?php } ?>
    </table>
   <?php if ($usersiteinfo['admin'] == "yes" && $meminfo['id'] > 1) { ?>
   <a href="<?php echo $url_admin_file; ?>?act=editmember&amp;id=<?php echo $meminfo['id']; ?>">Edit User</a> | <a href="<?php echo $url_admin_file; ?>?act=deletemember&amp;id=<?php echo $meminfo['id']; ?>" onclick="if(!confirm('Are you sure you want to delete member <?php echo htmlspecialchars($meminfo['name'], ENT_COMPAT | ENT_HTML5, "UTF-8"); ?>?')) { return false; }">Delete User</a><br />
   <?php } ?>
    <form action="<?php echo $url_file; ?>?act=lookup" method="get">
    <input type="hidden" name="act" value="lookup" />
    <div><br /></div>
    <table>
     <tr><td style="text-align: center;"><input type="text" name="upc" size="16" maxlength="13" value="<?php echo $lookupupc; ?>" /> <input type="submit" value="Look Up UPC" /></td></tr>
    </table>
   </form>
  </center>
  <?php echo $endhtmltag; ?>
<?php }
      } if ($_GET['act'] == "usrs" || $_GET['act'] == "users") { ?>
<!DOCTYPE html>
<html lang="en">
 <head>
<title> <?php echo $sitename; ?>: UPC Database User Info </title>
<?php echo $metatags; ?>
 </head>

 <body>
  <center>
   <?php echo $navbar; ?>
   <h2>UPC Database User Info</h2>
   <?php
       $findmem = sqlite3_query($slite3, "SELECT COUNT(*) AS count FROM \"".$table_prefix."members\" ORDER BY \"id\" ASC;");
          $nummems = sql_fetch_assoc($findmem);
          $numrows = $nummems['count'];
          if ($numrows > 0) {
              $maxpage = $_GET['page'] * $display_per_page;
              if ($maxpage > $numrows) {
                  $maxpage = $numrows;
              }
              $pagestartshow = ($maxpage - $display_per_page) + 1;
              $startoffset = $maxpage - $display_per_page;
              if ($pagestartshow < 0) {
                  $pagestartshow = 1;
              }
              if ($startoffset < 0) {
                  $startoffset = 0;
              }
              if ($numrows < $display_per_page) {
                  $maxpage = $numrows;
              }
              $findmem = sqlite3_query($slite3, "SELECT * FROM \"".$table_prefix."members\" ORDER BY \"id\" ASC LIMIT ".sqlite3_escape_string($slite3, $startoffset).", ".$display_per_page.";");
              if ($maxpage > $display_per_page && $_GET['page'] > 1) {
                  $backpage = $_GET['page'] - 1;
                  echo "<a href=\"".$url_file."?act=users&amp;page=".$backpage."\">Prev</a> --\n";
              }
              echo $numrows." members, displaying ".$pagestartshow." through ".$maxpage;
              if ($maxpage < $numrows) {
                  $nextpage = $_GET['page'] + 1;
                  echo "\n-- <a href=\"".$url_file."?act=users&amp;page=".$nextpage."\">Next</a>";
              }
              ?>
   <div><br /></div>
   <table>
   <tr><th>Member Name</th><th>Email</th><th>Entered</th><th>Pending</th><th>Last Active</th></tr>
   <?php
              while ($meminfo = sql_fetch_assoc($findmem)) { ?>
   <tr valign="top">
   <td><a href="<?php echo $url_file; ?>?act=user&amp;id=<?php echo $meminfo['id']; ?>"><?php echo htmlspecialchars($meminfo['name'], ENT_COMPAT | ENT_HTML5, "UTF-8"); ?></a></td>
   <td><?php echo htmlspecialchars($meminfo['email'], ENT_COMPAT | ENT_HTML5, "UTF-8"); ?></td>
   <td nowrap="nowrap"><?php if ($meminfo['numitems'] > 0) { ?><a href="<?php echo $url_file; ?>?act=latest&amp;id=<?php echo $meminfo['id']; ?>&amp;page=1"><?php } echo $meminfo['numitems'];
                  if ($meminfo['numitems'] > 0) { ?></a><?php } ?></td>
   <td nowrap="nowrap"><?php echo $meminfo['numpending']; ?></td>
   <td nowrap="nowrap"><?php echo date("j M Y, g:i A T", $meminfo['lastactive']); ?></td>
   </tr>
   <?php } echo "   </table>   <div><br /></div>";
          }
          if ($numrows > 0) {
              if ($maxpage > $display_per_page && $_GET['page'] > 1) {
                  $backpage = $_GET['page'] - 1;
                  echo "<a href=\"".$url_file."?act=users&amp;page=".$backpage."\">Prev</a> --\n";
              }
              echo $numrows." members, displaying ".$pagestartshow." through ".$maxpage;
              if ($maxpage < $numrows) {
                  $nextpage = $_GET['page'] + 1;
                  echo "\n-- <a href=\"".$url_file."?act=users&amp;page=".$nextpage."\">Next</a>";
              }
          }
          ?>
  </center>
  <?php echo $endhtmltag;
      } ?>