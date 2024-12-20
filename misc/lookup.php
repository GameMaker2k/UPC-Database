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

    $FileInfo: lookup.php - Last Update: 10/24/2024 Ver. 2.2.5 RC 1 - Author: cooldude2k $
*/
$File3Name = basename($_SERVER['SCRIPT_NAME']);
if ($File3Name == "lookup.php" || $File3Name == "/lookup.php") {
    chdir("../");
    require("./upc.php");
    exit();
}

if ($_GET['act'] == "lookup" && isset($_POST['upc']) && strlen($_POST['upc']) == 8 &&
    validate_upce($_POST['upc']) === false) {
    $_GET['act'] = "lookup";
    header("Location: ".$website_url.$url_file."?act=lookup");
    exit();
}
if ($_GET['act'] == "lookup" && isset($_POST['upc']) && strlen($_POST['upc']) == 12 &&
    validate_upca($_POST['upc']) === false) {
    $_GET['act'] = "lookup";
    header("Location: ".$website_url.$url_file."?act=lookup");
    exit();
}
if ($_GET['act'] == "lookup" && isset($_POST['upc']) && strlen($_POST['upc']) == 13 &&
    validate_ean13($_POST['upc']) === false) {
    $_GET['act'] = "lookup";
    header("Location: ".$website_url.$url_file."?act=lookup");
    exit();
}
if ($_GET['act'] == "lookup") {
    $lookupupc = null;
    if (isset($_POST['upc']) && is_numeric($_POST['upc'])) {
        $lookupupc = $_POST['upc'];
    }
    if (isset($_POST['upc']) && !is_numeric($_POST['upc'])) {
        $lookupupc = null;
    }
    if (!isset($_POST['upc'])) {
        $lookupupc = null;
    }
}

 if ($_GET['act'] == "editupc" && validate_ean13($_GET['upc']) === true && $_GET['subact'] === "editupc") {
      if (!isset($_POST['description']) || !isset($_POST['sizeweight'])) {
          $_GET['upc'] = null;
          $_GET['subact'] = null;
      }
      if (!isset($_POST['description'])) {
          $_POST['description'] = null;
      }
      if (!isset($_POST['sizeweight'])) {
          $_POST['sizeweight'] = null;
      }
      $_POST['description'] = trim($_POST['description']);
      $_POST['description'] = remove_spaces($_POST['description']);
      $_POST['sizeweight'] = trim($_POST['sizeweight']);
      $_POST['sizeweight'] = remove_spaces($_POST['sizeweight']);
      if ($add_quantity_row === true) {
          $_POST['quantity'] = trim($_POST['quantity']);
          $_POST['quantity'] = remove_spaces($_POST['quantity']);
      }
      if ($add_quantity_row === false) {
          $_POST['quantity'] = null;
      }
      if (strlen($_POST['description']) > 150) {
          $_GET['upc'] = null;
          $_GET['subact'] = null;
      }
      if (strlen($_POST['sizeweight']) > 30) {
          $_GET['upc'] = null;
          $_GET['subact'] = null;
      }
      if (strlen($_POST['quantity']) > 30 && $add_quantity_row === true) {
          $_GET['upc'] = null;
          $_GET['subact'] = null;
      }
      if ($_POST['description'] == "" || $_POST['description'] == null) {
          $_GET['upc'] = null;
          $_GET['subact'] = null;
      }
      if ($_POST['sizeweight'] == "" || $_POST['sizeweight'] == null) {
          $_GET['upc'] = null;
          $_GET['subact'] = null;
      }
      if (($_POST['quantity'] == "" || $_POST['quantity'] == null) && $add_quantity_row === true) {
          $_GET['upc'] = null;
          $_GET['subact'] = null;
      }
      $findupc = sqlite3_query($slite3, "SELECT COUNT(*) AS count FROM \"".$table_prefix."items\" WHERE \"upc\"='".sqlite3_escape_string($slite3, $_POST['upc'])."';");
      $numupc = sql_fetch_assoc($findupc);
      $numrows = $numupc['count'];
      if ($numrows <= 0) {
          $_GET['upc'] = null;
          $_GET['subact'] = null;
      }
      if ($numrows > 0) {
          $itemvalidated = "no";
          if ($usersiteinfo['admin'] == "yes") {
              $itemvalidated = "yes";
          }
          if ($usersiteinfo['admin'] == "no" && $_COOKIE['MemberID'] > 1 && $validate_items === false) {
              $itemvalidated = "yes";
          }
          if ($usersiteinfo['admin'] == "no" && $_COOKIE['MemberID'] > 1 && $validate_items === true &&
              $usersiteinfo['validateitems'] == "yes") {
              $itemvalidated = "no";
          }
          if ($usersiteinfo['admin'] == "no" && $_COOKIE['MemberID'] > 1 && $validate_items === true &&
              $usersiteinfo['validateitems'] == "no") {
              $itemvalidated = "yes";
          }
          if ($add_quantity_row === true) {
              sqlite3_query($slite3, "INSERT INTO \"".$table_prefix."modupc\" (\"upc\", \"description\", \"sizeweight\", \"quantity\", \"validated\", \"delrequest\", \"delreqreason\", \"userid\", \"username\", \"timestamp\", \"lastupdate\", \"edituserid\", \"editname\", \"ip\", \"editip\") VALUES ('".sqlite3_escape_string($slite3, $_POST['upc'])."', '".sqlite3_escape_string($slite3, $_POST['description'])."', '".sqlite3_escape_string($slite3, $_POST['sizeweight'])."', '".sqlite3_escape_string($slite3, $_POST['quantity'])."', '".sqlite3_escape_string($slite3, $itemvalidated)."', 'no', '', ".sqlite3_escape_string($slite3, $_COOKIE['MemberID']).", '".sqlite3_escape_string($slite3, $_COOKIE['MemberName'])."', ".time().", ".time().", ".sqlite3_escape_string($slite3, $_COOKIE['MemberID']).", '".sqlite3_escape_string($slite3, $_COOKIE['MemberName'])."', '".sqlite3_escape_string($slite3, $usersip)."', '".sqlite3_escape_string($slite3, $usersip)."');");
          }
          if ($add_quantity_row === false) {
              sqlite3_query($slite3, "INSERT INTO \"".$table_prefix."modupc\" (\"upc\", \"description\", \"sizeweight\", \"quantity\", \"validated\", \"delrequest\", \"delreqreason\", \"userid\", \"username\", \"timestamp\", \"lastupdate\", \"edituserid\", \"editname\", \"ip\", \"editip\") VALUES ('".sqlite3_escape_string($slite3, $_POST['upc'])."', '".sqlite3_escape_string($slite3, $_POST['description'])."', '".sqlite3_escape_string($slite3, $_POST['sizeweight'])."', '', '".sqlite3_escape_string($slite3, $itemvalidated)."', 'no', '', ".sqlite3_escape_string($slite3, $_COOKIE['MemberID']).", '".sqlite3_escape_string($slite3, $_COOKIE['MemberName'])."', ".time().", ".time().", ".sqlite3_escape_string($slite3, $_COOKIE['MemberID']).", '".sqlite3_escape_string($slite3, $_COOKIE['MemberName'])."', '".sqlite3_escape_string($slite3, $usersip)."', '".sqlite3_escape_string($slite3, $usersip)."');");
          }
          $_GET['upc'] = "lookup";
          $_GET['subact'] = null;
      }
  }
if ($_GET['act'] == "editupc" && validate_ean13($_GET['upc']) === true && $_GET['subact'] === null) {
    $findupc = sqlite3_query($slite3, "SELECT COUNT(*) AS count FROM \"".$table_prefix."items\" WHERE \"upc\"='".sqlite3_escape_string($slite3, $_POST['upc'])."';");
    $numupc = sql_fetch_assoc($findupc);
    $numrows = $numupc['count'];
    if ($numrows <= 0) {
        $_GET['upc'] = null;
    }
    if ($numrows > 0) {
        $findupc = sqlite3_query($slite3, "SELECT * FROM \"".$table_prefix."items\" WHERE \"upc\"='".sqlite3_escape_string($slite3, $_GET['upc'])."';");
        $upcinfo = sql_fetch_assoc($findupc);
        ?>
<!DOCTYPE html>
<html lang="en">
 <head>
<title> <?php echo $sitename; ?>: Edit UPC Request </title>
<?php echo $metatags; ?>
 </head>
 <body>
  <center>
   <?php echo $navbar; ?>
   <h2>Edit UPC</h2>
   <table>
   <?php if ($upce !== null && validate_upce($upce) === true) { ?>
   <tr><td>UPC-E</td><td width="50"></td><td><img src="<?php echo $barcode_file; ?>?act=upce&amp;upc=<?php echo $upce; ?>" alt="<?php echo $upce; ?>" title="<?php echo $upce; ?>" /></td></tr>
   <?php } if ($upca !== null && validate_upca($upca) === true) { ?>
   <tr><td>UPC-A</td><td width="50"></td><td><img src="<?php echo $barcode_file; ?>?act=upca&amp;upc=<?php echo $upca; ?>" alt="<?php echo $upca; ?>" title="<?php echo $upca; ?>" /></td></tr>
   <?php } if ($ean13 !== null && validate_ean13($ean13) === true) { ?>
   <tr><td>EAN/UCC-13</td><td width="50"></td><td><img src="<?php echo $barcode_file; ?>?act=ean13&amp;upc=<?php echo $ean13; ?>" alt="<?php echo $ean13; ?>" title="<?php echo $ean13; ?>" /></td></tr>
   <?php } ?>
   </table>
   <div><br /></div>
   <form action="<?php echo $url_file; ?>?act=editupc" method="post">
    <table>
    <tr><td style="text-align: center;">Description: <input type="text" name="description" size="50" maxlength="150" value="<?php echo htmlspecialchars($upcinfo['description'], ENT_COMPAT | ENT_HTML5, "UTF-8"); ?>" /></td></tr>
    <tr><td style="text-align: center;">Size/Weight: <input type="text" name="sizeweight" size="30" maxlength="30" value="<?php echo htmlspecialchars($upcinfo['sizeweight'], ENT_COMPAT | ENT_HTML5, "UTF-8"); ?>" /></td></tr>
    <?php if ($add_quantity_row === true) { ?><tr><td style="text-align: center;">Quantity: <input type="text" name="quantity" size="30" maxlength="30"  value="<?php echo htmlspecialchars($upcinfo['quantity'], ENT_COMPAT | ENT_HTML5, "UTF-8"); ?>" /></td></tr><?php } ?>
   </table>
   <input type="hidden" name="upc" value="<?php echo $_GET['upc']; ?>" />
   <input type="hidden" name="subact" value="editupc" />
   <div><br /><input type="submit" value="Save Entry" /> <input type="reset" value="Clear" /></div>
   </form>
  </center>
  <?php echo $endhtmltag; ?>
<?php }
    }  if ($_GET['act'] == "deleteupc" && validate_ean13($_GET['upc']) === true) {
        sqlite3_query($slite3, "UPDATE \"".$table_prefix."items\" SET \"delrequest\"='yes',\"delreqreason\"='Delete This' WHERE \"upc\"='".sqlite3_escape_string($slite3, $_POST['upc'])."';");
		$_GET['act'] = "lookup";
	} if ($_GET['act'] == "lookup") {
    if (isset($_POST['upc'])) {
        $findupc = sqlite3_query($slite3, "SELECT COUNT(*) AS count FROM \"".$table_prefix."items\" WHERE \"upc\"='".sqlite3_escape_string($slite3, $ean13)."';");
        $numupc = sql_fetch_assoc($findupc);
        $numrows = $numupc['count'];
        if ($numrows > 0) {
            $findupc = sqlite3_query($slite3, "SELECT * FROM \"".$table_prefix."items\" WHERE \"upc\"='".sqlite3_escape_string($slite3, $ean13)."';");
            $upcinfo = sql_fetch_assoc($findupc);
        }
        $oldnumrows = $numrows;
        if ($oldnumrows < 1) {
            $findupc = sqlite3_query($slite3, "SELECT COUNT(*) AS count FROM \"".$table_prefix."pending\" WHERE \"upc\"='".sqlite3_escape_string($slite3, $ean13)."';");
            $numupc = sql_fetch_assoc($findupc);
            $numrows = $numupc['count'];
            if ($numrows > 0) {
                $findupc = sqlite3_query($slite3, "SELECT * FROM \"".$table_prefix."pending\" WHERE upc='".sqlite3_escape_string($slite3, $ean13)."';");
                $upcinfo = sql_fetch_assoc($findupc);
                $upcinfo['validated'] = "no";
            }
        }
    }
    ?>
<!DOCTYPE html>
<html lang="en">
 <head>
  <?php if (!isset($_POST['upc'])) { ?>
<title> <?php echo $sitename; ?>: Item Lookup </title>
  <?php } if (isset($_POST['upc']) && $numrows > 0 && $upcinfo['validated'] == "yes" &&
        (!preg_match("/^02/", $_POST['upc']) && !preg_match("/^04/", $_POST['upc']) &&
        !preg_match("/^05/", $_POST['upc']) && !preg_match("/^09/", $_POST['upc']) &&
        !preg_match("/^(98[1-3])/", $_POST['upc']) && !preg_match("/^(99[0-9])/", $_POST['upc']) &&
        !preg_match("/^(97[7-9])/", $_POST['upc']) && !preg_match("/^2/", $_POST['upc']))) { ?>
<title> <?php echo $sitename; ?>: Item Record </title>
  <?php } if (isset($_POST['upc']) && $numrows > 0 && $upcinfo['validated'] == "no" &&
        (!preg_match("/^02/", $_POST['upc']) && !preg_match("/^04/", $_POST['upc']) &&
        !preg_match("/^05/", $_POST['upc']) && !preg_match("/^09/", $_POST['upc']) &&
        !preg_match("/^(98[1-3])/", $_POST['upc']) && !preg_match("/^(99[0-9])/", $_POST['upc']) &&
        !preg_match("/^(97[7-9])/", $_POST['upc']) && !preg_match("/^2/", $_POST['upc']))) { ?>
<title> <?php echo $sitename; ?>: Item Found </title>
  <?php } if (isset($_POST['upc']) && $numrows == 0 &&
        (!preg_match("/^02/", $_POST['upc']) && !preg_match("/^04/", $_POST['upc']) &&
        !preg_match("/^05/", $_POST['upc']) && !preg_match("/^09/", $_POST['upc']) &&
        !preg_match("/^(98[1-3])/", $_POST['upc']) && !preg_match("/^(99[0-9])/", $_POST['upc']) &&
        !preg_match("/^(97[7-9])/", $_POST['upc']) && !preg_match("/^2/", $_POST['upc']))) { ?>
<title> <?php echo $sitename; ?>: Item Not Found </title>
  <?php } if (isset($_POST['upc']) && preg_match("/^02/", $_POST['upc'])) { ?>
<title> <?php echo $sitename; ?>: Random Weight UPC </title>
  <?php } if (isset($_POST['upc']) && preg_match("/^04/", $_POST['upc'])) { ?>
<title> <?php echo $sitename; ?>: Dummy UPC </title>
  <?php } if (isset($_POST['upc']) && preg_match("/^2/", $_POST['upc'])) { ?>
<title> <?php echo $sitename; ?>: Dummy UPC </title>
  <?php } if (isset($_POST['upc']) &&
        (preg_match("/^05/", $_POST['upc']) || preg_match("/^09/", $_POST['upc']))) { ?>
<title> <?php echo $sitename; ?>: Coupon Decode </title>
  <?php } if (isset($_POST['upc']) &&
        (preg_match("/^(98[1-3])/", $_POST['upc']) || preg_match("/^(99[0-9])/", $_POST['upc']))) { ?>
<title> <?php echo $sitename; ?>: Coupon Decode </title>
  <?php } if (isset($_POST['upc']) &&
        (preg_match("/^(97[7-9])/", $_POST['upc']))) { ?>
<title> <?php echo $sitename; ?>: Bookland ISBN/ISMN/ISSN </title>
  <?php } ?>
<?php echo $metatags; ?>
 </head>

 <body>
  <center>
   <?php echo $navbar; ?>
   <?php if (isset($_POST['upc']) && preg_match("/^02/", $_POST['upc'])) {
       $RandWeight = get_upca_vw_info($upca);
       $price_split = str_split($RandWeight['price'], 2);
       $RandWeight['price'] = ltrim($price_split[0].".".$price_split[1], "0");
       ?>
   <h2>Random Weight UPC</h2>
   <div>Random weight (number system 2) UPCs are a way of price-marking an item. The first (number system) digit is always 2.<br />  The next 5 (6?) digits are locally assigned (meaning anybody can use them for whatever they want).<br /> The next 5 (4?) are the price (2 decimal places), and the last digit is the check digit, calculated normally.</div>
   <table>
   <tr><td width="125">UPC-A</td><td width="50"><img src="<?php echo $barcode_file; ?>?act=upca&amp;upc=<?php echo $upca; ?>" alt="<?php echo $upca; ?>" title="<?php echo $upca; ?>" /></td></tr>
   <tr><td width="125">Product Code</td><td width="50"><?php echo $RandWeight['code']; ?></td></tr>
   <tr><td width="125">Price</td><td width="50"><?php echo $RandWeight['price']; ?></td></tr>
   </table>
   <div><br /></div>
   <?php } if (isset($_POST['upc']) &&
        (preg_match("/^05/", $_POST['upc']) || preg_match("/^09/", $_POST['upc']))) {
       $CouponInfo = get_upca_coupon_info($upca);
       $CouponInfo['vinfo'] = get_upca_coupon_value_code($CouponInfo['value']);
       ?>
   <h2>Coupon Decode</h2>
   <div>Manufacturer: <?php echo $CouponInfo['manufacturer']; ?><br /><br /></div>
   <div>Coupon Family: <?php echo $CouponInfo['family']; ?><br /><br /></div>
   <div>Coupon Value: <?php echo $CouponInfo['vinfo']; ?><br /><br /></div>
   <div>Coupon UPCs are not unique to coupons as other UPCs are to items.<br />  The coupon UPC has its meaning embedded in it.<br />  Therefore, there's no need to store coupon UPCs in the database.</div>
   <table>
   <tr><td width="125">UPC-A</td><td width="50"><img src="<?php echo $barcode_file; ?>?act=upca&amp;upc=<?php echo $upca; ?>" alt="<?php echo $upca; ?>" title="<?php echo $upca; ?>" /></td></tr>
   </table>
   <div><br /></div>
   <?php } if (isset($_POST['upc']) &&
        (preg_match("/^(98[1-3])/", $_POST['upc']) || preg_match("/^(99[0-9])/", $_POST['upc']))) {
       ?>
   <h2>Coupon Decode</h2>
   <div>Coupon UPCs are not unique to coupons as other UPCs are to items.<br />  The coupon UPC has its meaning embedded in it.<br />  Therefore, there's no need to store coupon UPCs in the database.</div>
   <table>
   <tr><td width="125">EAN/UCC-13</td><td width="50"></td><td><img src="<?php echo $barcode_file; ?>?act=ean13&amp;upc=<?php echo $ean13; ?>" alt="<?php echo $ean13; ?>" title="<?php echo $ean13; ?>" /></td></tr>
   </table>
   <div><br /></div>
   <?php } if (isset($_POST['upc']) && preg_match("/^04/", $_POST['upc'])) {
       ?>
   <h2>Dummy UPC</h2>
   <div>Dummy (number system 4) UPCs are for private use.<br />  This means anybody (typically a retailer) that needs to assign a UPC to an item that doesn't already have one, can use any number system 4 UPC it chooses.<br />  Most importantly, they can know that by doing so, they won't pick one that may already be used.<br />  So, such a UPC can and does mean something different depending on who you ask, and there's no reason to try to keep track of what products these correspond to.</div>
   <table>
   <tr><td width="125">UPC-A</td><td width="50"><img src="<?php echo $barcode_file; ?>?act=upca&amp;upc=<?php echo $upca; ?>" alt="<?php echo $upca; ?>" title="<?php echo $upca; ?>" /></td></tr>
   </table>
   <div><br /></div>
   <?php } if (isset($_POST['upc']) && preg_match("/^2/", $_POST['upc'])) {
       ?>
   <h2>Dummy UPC</h2>
   <div>Dummy (number system 2) UPCs are for private use.<br />  This means anybody (typically a retailer) that needs to assign a UPC to an item that doesn't already have one, can use any number system 2 UPC it chooses.<br />  Most importantly, they can know that by doing so, they won't pick one that may already be used.<br />  So, such a UPC can and does mean something different depending on who you ask, and there's no reason to try to keep track of what products these correspond to.</div>
   <table>
   <tr><td width="125">EAN/UCC-13</td><td width="50"></td><td><img src="<?php echo $barcode_file; ?>?act=ean13&amp;upc=<?php echo $ean13; ?>" alt="<?php echo $ean13; ?>" title="<?php echo $ean13; ?>" /></td></tr>
   </table>
   <div><br /></div>
   <?php } if (isset($_POST['upc']) && preg_match("/^(97[7-9])/", $_POST['upc'])) {
       $eanhrefs = null;
       $eanhrefe = null;
       if (validate_isbn13($ean13) === true) {
           $eantype = "ISBN";
           $eanprefix = "978";
           $eanprint = print_convert_isbn13_to_isbn10($ean13);
           $eanprint = "<a href=\"http://www.amazon.com/gp/search?keywords=".urlencode($eanprint)."&ie=UTF8\" onclick=\"window.open(this.href);return false;\">".$eanprint."</a>";
       }
       if (validate_ismn13($ean13) === true) {
           $eantype = "ISMN";
           $eanprefix = "977";
           $eanprint = print_convert_ismn13_to_ismn10($ean13);
       }
       if (validate_issn13($ean13) === true) {
           $eantype = "ISSN";
           $eanprefix = "979";
           $eanprint = print_convert_issn13_to_issn8($ean13);
       }
       ?>
   <h2>Bookland ISBN/ISMN/ISSN</h2>
   <div>This is a Bookland <?php echo $eantype; ?> code, which means it's an <?php echo $eantype; ?> number encoded as an EAN/UCC-13.<br /> You can tell this by the first three digits of the EAN/UCC-13 (<?php echo $eanprefix; ?>). The numbers after that are the <?php echo $eantype; ?>.<br /> You'll notice the last digits differ, though -- EAN/UCC-13 and <?php echo $eantype; ?> calculate their check digits differently<br /> (in fact, the check 'digit' on an <?php echo $eantype; ?> can be a digit or the letter X).</div>
   <table>
   <tr><td width="125">EAN/UCC-13</td><td width="50"></td><td><img src="<?php echo $barcode_file; ?>?act=ean13&amp;upc=<?php echo $ean13; ?>" alt="<?php echo $ean13; ?>" title="<?php echo $ean13; ?>" /></td></tr>
   <tr><td width="125"><?php echo $eantype; ?></td><td width="50"></td><td><center><?php echo $eanprint; ?></center></td></tr>
   </table>
   <div><br /></div>
   <?php } if (!isset($_POST['upc']) &&
        (!preg_match("/^02/", $_POST['upc']) && !preg_match("/^04/", $_POST['upc']) &&
        !preg_match("/^05/", $_POST['upc']) && !preg_match("/^09/", $_POST['upc']) &&
        !preg_match("/^(98[1-3])/", $_POST['upc']) && !preg_match("/^(99[0-9])/", $_POST['upc']) &&
        !preg_match("/^(97[7-9])/", $_POST['upc']) && !preg_match("/^2/", $_POST['upc']))) { ?>
   <h2>Item Lookup</h2>
   <h3>Instructions</h3>
   <div>Enter the all digits printed on the UPC bar code, including any numbers<br />to the right or left of the bar code itself, even if they don't line up<br />with the main row of numbers.  This should be 13 digits for an EAN/UCC-13,<br />12 digits for a Type A UPC code, or 8 digits for a Type-E (zero-suppressed)<br />UPC code.  Anything other than 8 or 12 digits is <b>not</b> a UPC code!<br />(And just because it's 8 or 12 digits doesn't mean it <b>is</b> a UPC.)<br /><b>You must enter every digit here.</b><br /></div>
   <div><br />If you have a barcode scanner that outputs plain numbers, you should be<br />able to use it to enter the UPC number here.<br /><br /></div>
   <?php } if (isset($_POST['upc']) && $numrows > 0 && $upcinfo['validated'] == "yes" &&
        (!preg_match("/^02/", $_POST['upc']) && !preg_match("/^04/", $_POST['upc']) &&
        !preg_match("/^05/", $_POST['upc']) && !preg_match("/^09/", $_POST['upc']) &&
        !preg_match("/^(98[1-3])/", $_POST['upc']) && !preg_match("/^(99[0-9])/", $_POST['upc']) &&
        !preg_match("/^(97[7-9])/", $_POST['upc']) && !preg_match("/^2/", $_POST['upc']))) { ?>
   <h2>Item Record</h2>
   <table>
   <?php if ($upce !== null && validate_upce($upce) === true) { ?>
   <tr><td>UPC-E</td><td width="50"></td><td><img src="<?php echo $barcode_file; ?>?act=upce&amp;upc=<?php echo $upce; ?>" alt="<?php echo $upce; ?>" title="<?php echo $upce; ?>" /></td></tr>
   <?php } if ($upca !== null && validate_upca($upca) === true) { ?>
   <tr><td>UPC-A</td><td width="50"></td><td><img src="<?php echo $barcode_file; ?>?act=upca&amp;upc=<?php echo $upca; ?>" alt="<?php echo $upca; ?>" title="<?php echo $upca; ?>" /></td></tr>
   <?php } if ($ean13 !== null && validate_ean13($ean13) === true) { ?>
   <tr><td>EAN/UCC-13</td><td width="50"></td><td><img src="<?php echo $barcode_file; ?>?act=ean13&amp;upc=<?php echo $ean13; ?>" alt="<?php echo $ean13; ?>" title="<?php echo $ean13; ?>" /></td></tr>
   <?php } ?>
   <tr><td>Description</td><td width="50"></td><td><?php echo htmlspecialchars($upcinfo['description'], ENT_COMPAT | ENT_HTML5, "UTF-8"); ?></td></tr>
   <tr><td>Size/Weight</td><td width="50"></td><td><?php echo htmlspecialchars($upcinfo['sizeweight'], ENT_COMPAT | ENT_HTML5, "UTF-8"); ?></td></tr>
   <?php if ($add_quantity_row === true) { ?><tr><td>Quantity</td><td width="50"></td><td><?php echo htmlspecialchars($upcinfo['quantity'], ENT_COMPAT | ENT_HTML5, "UTF-8"); ?></td></tr><?php } ?>
   <tr><td>Issuing Country</td><td width="50"></td><td><?php echo get_gs1_prefix($ean13); ?></td></tr>
   <tr><td>Created</td><td width="50"></td><td><?php echo date("j M Y, g:i A T", $upcinfo['timestamp']); ?></td></tr>
   <tr><td>Created By</td><td width="50"></td><td><?php if ($upcinfo['userid'] > 0) { ?><a href="<?php echo $url_file."?act=user&amp;id=".$upcinfo['userid']; ?>"><?php } echo $upcinfo['username']; ?><?php if ($upcinfo['userid'] > 0) { ?></a><?php } ?></td></tr>
   <?php if ((isset($_COOKIE['MemberID']) && $_COOKIE['MemberID'] == $meminfo['id']) ||
                  ($usersiteinfo['admin'] == "yes")) { ?>
   <tr><td>Created By IP</td><td width="50"></td><td><?php echo $upcinfo['ip']; ?></td></tr>
   <?php } if ($upcinfo['timestamp'] > $upcinfo['lastupdate']) { ?>
   <tr><td>Last Modified</td><td width="50"></td><td><?php echo date("j M Y, g:i A T", $upcinfo['lastupdate']); ?></td></tr>
   <tr><td>Last Modified By</td><td width="50"></td><td><?php if ($upcinfo['edituserid'] > 0) { ?><a href="<?php echo $url_file."?act=user&amp;id=".$upcinfo['edituserid']; ?>"><?php } echo $upcinfo['editname'];
       if ($upcinfo['edituserid'] > 0) { ?></a><?php } ?></td></tr>
   <?php if ((isset($_COOKIE['MemberID']) && $_COOKIE['MemberID'] == $meminfo['id']) ||
                  ($usersiteinfo['admin'] == "yes")) { ?>
   <tr><td>Last Modified By IP</td><td width="50"></td><td><?php echo $upcinfo['editip']; ?></td></tr>
   <?php }
   } ?>
   </table>
   <div><br /></div>
   <?php if ($usersiteinfo['admin'] == "yes" && $upcinfo['validated'] == "yes") { ?>
   <a href="<?php echo $url_admin_file; ?>?act=editupc&amp;upc=<?php echo $ean13; ?>">Edit UPC</a> | <a href="<?php echo $url_admin_file; ?>?act=deleteupc&amp;upc=<?php echo $ean13; ?>" onclick="if(!confirm('Are you sure you want to delete UPC <?php echo $ean13; ?>?')) { return false; }">Delete UPC</a><br />
   <?php } if ($usersiteinfo['admin'] == "no" && $upcinfo['validated'] == "yes") { ?>
   <a href="<?php echo $url_file; ?>?act=editupc&amp;upc=<?php echo $ean13; ?>">Edit UPC Request</a> | <a href="<?php echo $url_file; ?>?act=deleteupc&amp;upc=<?php echo $ean13; ?>" onclick="if(!confirm('Are you sure you want to delete UPC <?php echo $ean13; ?>?')) { return false; }">Delete UPC Request</a><br />
   <?php } ?>
   <a href="<?php echo $url_file; ?>?act=neighbors&amp;upc=<?php echo $ean13; ?>&amp;page=1">List Neighboring Items</a><br />
   <!--<a href="/editform.asp?upc=<?php echo $ean13; ?>">Submit Modification Request</a><br />-->
   <!--<a href="/deleteform.asp?upc=<?php echo $ean13; ?>">Submit Deletion Request</a><br />-->
   <!--<br /><br /></div>-->
   <div><br /></div>
   <?php } if (isset($_POST['upc']) && $numrows > 0 && $upcinfo['validated'] == "no" &&
    (!preg_match("/^02/", $_POST['upc']) && !preg_match("/^04/", $_POST['upc']) &&
    !preg_match("/^05/", $_POST['upc']) && !preg_match("/^09/", $_POST['upc']) &&
    !preg_match("/^(98[1-3])/", $_POST['upc']) && !preg_match("/^(99[0-9])/", $_POST['upc']) &&
    !preg_match("/^(97[7-9])/", $_POST['upc']) && !preg_match("/^2/", $_POST['upc']))) { ?>
   <h2>Item Found</h2>
   <div>The UPC you were looking for currently is in the database but has not been validated yet.<br /><br /></div>
   <table>
   <?php if ($upce !== null && validate_upce($upce) === true) { ?>
   <tr><td>UPC-E</td><td width="50"></td><td><img src="<?php echo $barcode_file; ?>?act=upce&amp;upc=<?php echo $upce; ?>" alt="<?php echo $upce; ?>" title="<?php echo $upce; ?>" /></td></tr>
   <?php } if ($upca !== null && validate_upca($upca) === true) { ?>
   <tr><td>UPC-A</td><td width="50"></td><td><img src="<?php echo $barcode_file; ?>?act=upca&amp;upc=<?php echo $upca; ?>" alt="<?php echo $upca; ?>" title="<?php echo $upca; ?>" /></td></tr>
   <?php } if ($ean13 !== null && validate_ean13($ean13) === true) { ?>
   <tr><td>EAN/UCC-13</td><td width="50"></td><td><img src="<?php echo $barcode_file; ?>?act=ean13&amp;upc=<?php echo $ean13; ?>" alt="<?php echo $ean13; ?>" title="<?php echo $ean13; ?>" /></td></tr>
   <?php } ?>
   </table>
   <div><br />Please try coming back later.<br /><br /></div>
   <?php } if (isset($_POST['upc']) && $numrows == 0 &&
    (!preg_match("/^02/", $_POST['upc']) && !preg_match("/^04/", $_POST['upc']) &&
    !preg_match("/^05/", $_POST['upc']) && !preg_match("/^09/", $_POST['upc']) &&
    !preg_match("/^(98[1-3])/", $_POST['upc']) && !preg_match("/^(99[0-9])/", $_POST['upc']) &&
    !preg_match("/^(97[7-9])/", $_POST['upc']) && !preg_match("/^2/", $_POST['upc']))) { ?>
   <h2>Item Not Found</h2>
   <div>The UPC you were looking for currently has no record in the database.<br /><br /></div>
   <table>
   <?php if ($upce !== null && validate_upce($upce) === true) { ?>
   <tr><td>UPC-E</td><td width="50"></td><td><img src="<?php echo $barcode_file; ?>?act=upce&amp;upc=<?php echo $upce; ?>" alt="<?php echo $upce; ?>" title="<?php echo $upce; ?>" /></td></tr>
   <?php } if ($upca !== null && validate_upca($upca) === true) { ?>
   <tr><td>UPC-A</td><td width="50"></td><td><img src="<?php echo $barcode_file; ?>?act=upca&amp;upc=<?php echo $upca; ?>" alt="<?php echo $upca; ?>" title="<?php echo $upca; ?>" /></td></tr>
   <?php } if ($ean13 !== null && validate_ean13($ean13) === true) { ?>
   <tr><td>EAN/UCC-13</td><td width="50"></td><td><img src="<?php echo $barcode_file; ?>?act=ean13&amp;upc=<?php echo $ean13; ?>" alt="<?php echo $ean13; ?>" title="<?php echo $ean13; ?>" /></td></tr>
   <?php } ?>
   </table>
   <div><br />Even though this item is not on file here, looking at some of its
   <a href="<?php echo $url_file; ?>?act=neighbors&amp;upc=<?php echo $ean13; ?>&amp;page=1">close neighbors</a>
   may give you an idea what this item might be, or who manufactures it.<br /></div>
   <div><br />If you know what this item is, and would like to contribute to the database
   by providing a description for this item, please
   <a href="<?php echo $url_file; ?>?act=add&amp;upc=<?php echo $ean13; ?>">CLICK HERE</a>.<br /><br /></div>
   <?php } ?>
   <form name="upcform" action="<?php echo $url_file; ?>?act=lookup" onsubmit="if(validate_str_size(document.upcform.upc.value)==false) { return false; }" method="get">
    <input type="hidden" name="act" value="lookup" />
    <table>
    <tr><td style="text-align: center;"><input type="text" name="upc" size="16" maxlength="13" value="<?php echo $lookupupc; ?>" /> <input type="submit" value="Look Up UPC" /></td></tr>
   </table>
   </form>
  </center>
  <?php echo $endhtmltag; ?>
<?php } if ($_GET['act'] == "check" || $_GET['act'] == "checkdigit") { ?>
<!DOCTYPE html>
<html lang="en">
 <head>
<title> <?php echo $sitename; ?>: Check Digit Calculator </title>
<?php echo $metatags; ?>
 </head>
 <body>
  <center>
   <?php echo $navbar; ?>
   <h2>Check Digit Calculator</h2>
   <h3>Instructions</h3>
   <div>Enter a product code WITHOUT ITS CHECK DIGIT!  DO NOT omit leading zeros.<br />This will be 12 digits for an EAN, JAN, or UCC-13, 11 digits for a UPC-A,<br />or 7 digits for a UPC-E.  There is no support here for EAN/UCC-8 yet.<br /><br /></div>
   <form method="post" action="<?php echo $url_file."?act=checkdigit"; ?>">
   <b>EAN/UCC</b>: <input type="text" name="checkupc" size="15" maxlength="12" /><div><br /></div>
   <div><input type="submit" value="Calculate Check Digit" /></div>
   </form>
   <div><br /></div>
   <?php if (isset($_POST['checkupc']) && is_numeric($_POST['checkupc']) &&
   (strlen($_POST['checkupc']) == 7 || strlen($_POST['checkupc']) == 11 || strlen($_POST['checkupc']) == 12)) {
       if (strlen($_POST['checkupc']) == 7) {
           $check_upce = fix_upce_checksum($_POST['checkupc']);
           $check_upca = convert_upce_to_upca($check_upce);
           $check_ean13 = convert_upca_to_ean13($check_upca);
       }
       if (strlen($_POST['checkupc']) == 11) {
           $check_upca = fix_upca_checksum($_POST['checkupc']);
           $check_upce = convert_upca_to_upce($check_upca);
           $check_ean13 = convert_upca_to_ean13($check_upca);
       }
       if (strlen($_POST['checkupc']) == 12) {
           $check_ean13 = fix_ean13_checksum($_POST['checkupc']);
           $check_upca = convert_ean13_to_upca($check_ean13);
           $check_upce = convert_upca_to_upce($check_upca);
       }
       ?>
   <table>
   <?php if ($check_ean13 !== null && validate_ean13($check_ean13) === true) { ?>
   <tr><td>EAN/UCC-13:</td><td><?php echo $check_ean13; ?></td></tr>
   <?php } if ($check_upca !== null && validate_upca($check_upca) === true) { ?>
   <tr><td>UPC-A:</td><td><?php echo $check_upca; ?></td></tr>
   <?php } if ($check_upce !== null && validate_upce($check_upce) === true) { ?>
   <tr><td>UPC-E:</td><td><?php echo $check_upce; ?></td></tr>
   <?php } ?>
   <tr><td colspan="2"><a href="<?php echo $url_file."?act=lookup&amp;upc=".$check_ean13; ?>">Click here</a> to look up this UPC in the database.</td></tr>
   </table>
   <?php } ?>
  </center>
  <?php echo $endhtmltag; ?>
<?php } if ($_GET['act'] == "terms" || $_GET['act'] == "termsofuse") { ?>
<!DOCTYPE html>
<html lang="en">
 <head>
<title> <?php echo $sitename; ?>: Web Site Terms of Use </title>
<?php echo $metatags; ?>
 </head>
 <body>
  <center>
   <?php echo $navbar; ?>
   <h2>Web Site Terms of Use</h2>
   <?php
       if (file_exists("./terms.txt")) {
           echo file_get_contents("./terms.txt");
           ?>
   <div>Last updated <?php echo date("j M Y", filemtime("./terms.txt")); ?>.</div>
   <?php }
       if (!file_exists("./terms.txt")) {
           if (file_exists("./terms.html")) {
               echo file_get_contents("./terms.txt");
               ?>
   <div>Last updated <?php echo date("j M Y", filemtime("./terms.html")); ?>.</div>
   <?php }
           if (!file_exists("./terms.html")) {
               if (file_exists("./termsofuse.txt")) {
                   echo file_get_contents("./termsofuse.txt");
                   ?>
   <div>Last updated <?php echo date("j M Y", filemtime("./termsofuse.txt")); ?>.</div>
   <?php }
               if (!file_exists("./termsofuse.txt")) {
                   if (file_exists("./termsofuse.html")) {
                       echo file_get_contents("./termsofuse.html");
                       ?>
   <div>Last updated <?php echo date("j M Y", filemtime("./termsofuse.html")); ?>.</div>
   <?php }
                   if (!file_exists("./termsofuse.html")) {
                       /*echo "";*/
                   }
               }
           }
       }
      ?>
  </center>
  <?php echo $endhtmltag; ?>
<?php } if ($_GET['act'] == "stats" || $_GET['act'] == "statistics") {
      $findupc = sqlite3_query($slite3, "SELECT COUNT(*) AS count FROM \"".$table_prefix."items\";");
      $countemp = sql_fetch_assoc($findupc);
      $numitems = number_format($countemp['count']);
      $findupc = sqlite3_query($slite3, "SELECT COUNT(*) AS count FROM \"".$table_prefix."items\" WHERE \"upc\" NOT LIKE '0%';");
      $countemp = sql_fetch_assoc($findupc);
      $numean13 = number_format($countemp['count']);
      $findupc = sqlite3_query($slite3, "SELECT COUNT(*) AS count FROM \"".$table_prefix."items\" WHERE \"upc\" LIKE '0%';");
      $countemp = sql_fetch_assoc($findupc);
      $numupca = number_format($countemp['count']);
      $findupc = sqlite3_query($slite3, "SELECT COUNT(*) AS count FROM \"".$table_prefix."pending\";");
      $countemp = sql_fetch_assoc($findupc);
      $numpendings = number_format($countemp['count']);
      $findupc = sqlite3_query($slite3, "SELECT COUNT(*) AS count FROM \"".$table_prefix."members\" WHERE \"validated\"='yes';");
      $countemp = sql_fetch_assoc($findupc);
      $nummembers = number_format($countemp['count']);
      $dbsize = _format_bytes(filesize($sdb_file));
      ?>
<!DOCTYPE html>
<html lang="en">
 <head>
<title> <?php echo $sitename; ?>: Database Statistics </title>
<?php echo $metatags; ?>
 </head>
 <body>
  <center>
   <?php echo $navbar; ?>
   <h2>Database Statistics</h2>
   <table>
   <tr><td>Total Item Entries:</td><td align="right"><?php echo $numitems; ?></td></tr>
   <tr><td>UPC (non-EAN13) Entries:</td><td align="right"><?php echo $numupca; ?></td></tr>
   <tr><td>EAN13 (non-UPC) Entries:</td><td align="right"><?php echo $numean13; ?></td></tr>
   <tr><td>Total size of database:</td><td align="right"><?php echo $dbsize; ?></td></tr>
   <tr><td>Total Updates Pending:</td><td align="right"><?php echo $numpendings; ?></td></tr>
   <tr><td>Active User Accounts:</td><td align="right"><?php echo $nummembers; ?></td></tr>
  </table>
 </center>
  <?php echo $endhtmltag;
  } ?>
