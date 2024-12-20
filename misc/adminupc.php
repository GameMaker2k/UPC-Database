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

    $FileInfo: adminupc.php - Last Update: 10/24/2024 Ver. 2.2.5 RC 1 - Author: cooldude2k $
*/
$File3Name = basename($_SERVER['SCRIPT_NAME']);
if ($File3Name == "adminupc.php" || $File3Name == "/adminupc.php") {
    chdir("../");
    require("./upc.php");
    exit();
}

if ($_GET['act'] == "deleteupc" && isset($_GET['upc']) && validate_ean13($_GET['upc']) === true) {
    $findupc = sqlite3_query($slite3, "SELECT COUNT(*) AS count FROM \"".$table_prefix."items\" WHERE \"upc\"='".sqlite3_escape_string($slite3, $_POST['upc'])."';");
    $numupc = sql_fetch_assoc($findupc);
    $numrows = $numupc['count'];
    if ($numrows > 0) {
        $findupc = sqlite3_query($slite3, "SELECT * FROM \"".$table_prefix."items\" WHERE \"upc\"='".sqlite3_escape_string($slite3, $_POST['upc'])."';");
        $upcinfo = sql_fetch_assoc($findupc);
        $delupc = sqlite3_query($slite3, "DELETE FROM \"".$table_prefix."items\" WHERE \"upc\"='".sqlite3_escape_string($slite3, $_POST['upc'])."';");
        $findupc = sqlite3_query($slite3, "SELECT COUNT(*) AS count FROM \"".$table_prefix."items\" WHERE \"userid\"='".sqlite3_escape_string($slite3, $upcinfo['userid'])."';");
        $numupc = sql_fetch_assoc($findupc);
        $nummyitems = $numupc['count'];
        sqlite3_query($slite3, "UPDATE \"".$table_prefix."members\" SET \"numitems\"=".sqlite3_escape_string($slite3, $nummyitems)." WHERE \"id\"=".sqlite3_escape_string($slite3, $upcinfo['userid']).";");
    }
    $findupc = sqlite3_query($slite3, "SELECT COUNT(*) AS count FROM \"".$table_prefix."modupc\" WHERE \"upc\"='".sqlite3_escape_string($slite3, $_POST['upc'])."';");
    $numupc = sql_fetch_assoc($findupc);
    $numrows = $numupc['count'];
    if ($numrows > 0) {
        $delupc = sqlite3_query($slite3, "DELETE FROM \"".$table_prefix."modupc\" WHERE \"upc\"='".sqlite3_escape_string($slite3, $_POST['upc'])."';");
    }
}

if ($_GET['act'] == "undeleteupc" && isset($_GET['upc']) && validate_ean13($_GET['upc']) === true) {
    sqlite3_query($slite3, "UPDATE \"".$table_prefix."items\" SET \"delrequest\"='no' WHERE \"upc\"='".sqlite3_escape_string($slite3, $_GET['upc'])."' AND \"delrequest\"='yes';");
	$_GET['act'] = "upcdelrequests";
}
if ($_GET['act'] == "deleteupc") { ?>
<!DOCTYPE html>
<html lang="en">
 <head>
<title> <?php echo $sitename; ?>: AdminCP : Delete UPC </title>
<?php echo $metatags; ?>
 </head>
 <body>
  <center>
   <?php echo $navbar; ?>
   <h2>Delete UPC</h2>
   <?php
   $findupc = sqlite3_query($slite3, "SELECT COUNT(*) AS count FROM \"".$table_prefix."items\" ORDER BY \"lastupdate\" DESC;");
    $numupc = sql_fetch_assoc($findupc);
    $numrows = $numupc['count'];
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
        $findupc = sqlite3_query($slite3, "SELECT * FROM \"".$table_prefix."items\" ORDER BY \"lastupdate\" ASC LIMIT ".sqlite3_escape_string($slite3, $startoffset).", ".$display_per_page.";");
        if ($maxpage > $display_per_page && $_GET['page'] > 1) {
            $backpage = $_GET['page'] - 1;
            echo "<a href=\"".$url_admin_file."?act=deleteupc&amp;page=".$backpage."\">Prev</a> --\n";
        }
        echo $numrows." items, displaying ".$pagestartshow." through ".$maxpage;
        if ($maxpage < $numrows) {
            $nextpage = $_GET['page'] + 1;
            echo "\n-- <a href=\"".$url_admin_file."?act=deleteupc&amp;page=".$nextpage."\">Next</a>";
        }
        ?>
   <div><br /></div>
   <table>
   <tr><th>Delete EAN/UCC</th><th>Description</th><th>Size/Weight</th><?php if ($add_quantity_row === true) { ?><th>Quantity</th><?php } ?><th>Last Mod</th></tr>
   <?php
        while ($upcinfo = sql_fetch_assoc($findupc)) { ?>
   <tr valign="top">
   <td><a href="<?php echo $url_admin_file; ?>?act=deleteupc&amp;upc=<?php echo $upcinfo['upc']; ?>" onclick="if(!confirm('Are you sure you want to delete UPC <?php echo $upcinfo['upc']; ?>?')) { return false; }"><?php echo $upcinfo['upc']; ?></a></td>
   <td><?php echo htmlspecialchars($upcinfo['description'], ENT_COMPAT | ENT_HTML5, "UTF-8"); ?></td>
   <td nowrap="nowrap"><?php echo htmlspecialchars($upcinfo['sizeweight'], ENT_COMPAT | ENT_HTML5, "UTF-8"); ?></td>
   <?php if ($add_quantity_row === true) { ?><td nowrap="nowrap"><?php echo htmlspecialchars($upcinfo['quantity'], ENT_COMPAT | ENT_HTML5, "UTF-8"); ?></td><?php } ?>
   <td nowrap="nowrap"><?php echo date("j M Y, g:i A T", $upcinfo['lastupdate']); ?></td>
   </tr>
   <?php } echo "   </table>   <div><br /></div>";
    }
    if ($numrows > 0) {
        if ($maxpage > $display_per_page && $_GET['page'] > 1) {
            $backpage = $_GET['page'] - 1;
            echo "<a href=\"".$url_admin_file."?act=deleteupc&amp;page=".$backpage."\">Prev</a> --\n";
        }
        echo $numrows." items, displaying ".$pagestartshow." through ".$maxpage;
        if ($maxpage < $numrows) {
            $nextpage = $_GET['page'] + 1;
            echo "\n-- <a href=\"".$url_admin_file."?act=deleteupc&amp;page=".$nextpage."\">Next</a>";
        }
    }
    ?>
  </center>
  <?php echo $endhtmltag; ?>
<?php } if (($_GET['act'] == "approveedit" || $_GET['act'] == "rejectedit") && isset($_GET['id'])) {
      $findupc = sqlite3_query($slite3, "SELECT COUNT(*) AS count FROM \"".$table_prefix."modupc\" WHERE \"id\"=".sqlite3_escape_string($slite3, $_POST['id']).";");
      $numupc = sql_fetch_assoc($findupc);
      $numrows = $numupc['count'];
      if ($numrows > 0) {
		  if($_GET['act'] == "approveedit") {
                $findupc = sqlite3_query($slite3, "SELECT * FROM \"".$table_prefix."modupc\" WHERE \"id\"='".sqlite3_escape_string($slite3, $_POST['id'])."';");
                $upcinfo = sql_fetch_assoc($findupc);
                if ($add_quantity_row === true) {
                    sqlite3_query($slite3, "UPDATE \"".$table_prefix."items\" SET \"description\"='".sqlite3_escape_string($slite3, $upcinfo['description'])."',\"sizeweight\"='".sqlite3_escape_string($slite3, $upcinfo['sizeweight'])."',\"quantity\"='".sqlite3_escape_string($slite3, $upcinfo['quantity'])."',\"edituserid\"=".sqlite3_escape_string($slite3, $upcinfo['userid']).",\"editname\"='".sqlite3_escape_string($slite3, $upcinfo['username'])."',\"editip\"='".sqlite3_escape_string($slite3, $upcinfo['ip'])."',\"lastupdate\"=".sqlite3_escape_string($slite3, $upcinfo['lastupdate'])." WHERE \"upc\"='".sqlite3_escape_string($slite3, $upcinfo['upc'])."';");
                }
                if ($add_quantity_row === false) {
                    sqlite3_query($slite3, "UPDATE \"".$table_prefix."items\" SET \"description\"='".sqlite3_escape_string($slite3, $upcinfo['description'])."',\"sizeweight\"='".sqlite3_escape_string($slite3, $upcinfo['sizeweight'])."',\"edituserid\"=".sqlite3_escape_string($slite3, $upcinfo['userid']).",\"editname\"='".sqlite3_escape_string($slite3, $upcinfo['username'])."',\"editip\"='".sqlite3_escape_string($slite3, $upcinfo['ip'])."',\"lastupdate\"=".sqlite3_escape_string($slite3, $upcinfo['lastupdate'])." WHERE \"upc\"='".sqlite3_escape_string($slite3, $upcinfo['upc'])."';");
                }
		  }
          $delupc = sqlite3_query($slite3, "DELETE FROM \"".$table_prefix."modupc\" WHERE \"id\"=".sqlite3_escape_string($slite3, $_POST['id']).";");
          $_GET['act'] = "upceditrequests";
      }
  } if ($_GET['act'] == "validateupc" && isset($_GET['upc']) && validate_ean13($_GET['upc']) === true) {
      $findupc = sqlite3_query($slite3, "SELECT COUNT(*) AS count FROM \"".$table_prefix."pending\" WHERE \"upc\"='".sqlite3_escape_string($slite3, $_POST['upc'])."';");
      $numupc = sql_fetch_assoc($findupc);
      $numrows = $numupc['count'];
      if ($numrows > 0) {
          $findupc = sqlite3_query($slite3, "SELECT * FROM \"".$table_prefix."pending\" WHERE \"upc\"='".sqlite3_escape_string($slite3, $_POST['upc'])."';");
          $upcinfo = sql_fetch_assoc($findupc);
          if ($add_quantity_row === true) {
			  sqlite3_query($slite3, "INSERT INTO \"".$table_prefix."items\" (\"upc\", \"description\", \"sizeweight\", \"quantity\", \"validated\", \"delrequest\", \"delreqreason\", \"userid\", \"username\", \"timestamp\", \"lastupdate\", \"edituserid\", \"editname\", \"ip\", \"editip\") VALUES ('".sqlite3_escape_string($slite3, $upcinfo['upc'])."', '".sqlite3_escape_string($slite3, $upcinfo['description'])."', '".sqlite3_escape_string($slite3, $upcinfo['sizeweight'])."', '".sqlite3_escape_string($slite3, $upcinfo['quantity'])."', 'yes', 'no', '', ".sqlite3_escape_string($slite3, $upcinfo['userid']).", '".sqlite3_escape_string($slite3, $upcinfo['username'])."', ".sqlite3_escape_string($slite3, $upcinfo['timestamp']).", ".sqlite3_escape_string($slite3, $upcinfo['lastupdate']).", ".sqlite3_escape_string($slite3, $upcinfo['userid']).", '".sqlite3_escape_string($slite3, $upcinfo['username'])."', '".sqlite3_escape_string($slite3, $upcinfo['ip'])."', '".sqlite3_escape_string($slite3, $upcinfo['ip'])."');");
		  }
          if ($add_quantity_row === false) {
			  sqlite3_query($slite3, "INSERT INTO \"".$table_prefix."items\" (\"upc\", \"description\", \"sizeweight\", \"quantity\", \"validated\", \"delrequest\", \"delreqreason\", \"userid\", \"username\", \"timestamp\", \"lastupdate\", \"edituserid\", \"editname\", \"ip\", \"editip\") VALUES ('".sqlite3_escape_string($slite3, $upcinfo['upc'])."', '".sqlite3_escape_string($slite3, $upcinfo['description'])."', '".sqlite3_escape_string($slite3, $upcinfo['sizeweight'])."', '', 'yes', 'no', '', ".sqlite3_escape_string($slite3, $upcinfo['userid']).", '".sqlite3_escape_string($slite3, $upcinfo['username'])."', ".sqlite3_escape_string($slite3, $upcinfo['timestamp']).", ".sqlite3_escape_string($slite3, $upcinfo['lastupdate']).", ".sqlite3_escape_string($slite3, $upcinfo['userid']).", '".sqlite3_escape_string($slite3, $upcinfo['username'])."', '".sqlite3_escape_string($slite3, $upcinfo['ip'])."', '".sqlite3_escape_string($slite3, $upcinfo['ip'])."');");
		  }
          $delupc = sqlite3_query($slite3, "DELETE FROM \"".$table_prefix."pending\" WHERE \"upc\"='".sqlite3_escape_string($slite3, $_POST['upc'])."';");
          $findupc = sqlite3_query($slite3, "SELECT COUNT(*) AS count FROM \"".$table_prefix."pending\" WHERE \"userid\"='".sqlite3_escape_string($slite3, $upcinfo['userid'])."';");
          $numupc = sql_fetch_assoc($findupc);
          $nummypendings = $numupc['count'];
          $findupc = sqlite3_query($slite3, "SELECT COUNT(*) AS count FROM \"".$table_prefix."items\" WHERE \"userid\"='".sqlite3_escape_string($slite3, $upcinfo['userid'])."';");
          $numupc = sql_fetch_assoc($findupc);
          $nummyitems = $numupc['count'];
          sqlite3_query($slite3, "UPDATE \"".$table_prefix."members\" SET \"numitems\"=".sqlite3_escape_string($slite3, $nummyitems).",\"numpending\"=".sqlite3_escape_string($slite3, $nummypendings)." WHERE \"id\"=".sqlite3_escape_string($slite3, $upcinfo['userid']).";");
      }
  }
if ($_GET['act'] == "validateupc") { ?>
<!DOCTYPE html>
<html lang="en">
 <head>
<title> <?php echo $sitename; ?>: AdminCP : Validate UPC </title>
<?php echo $metatags; ?>
 </head>
 <body>
  <center>
   <?php echo $navbar; ?>
   <h2>Validate UPC</h2>
   <?php
   $findupc = sqlite3_query($slite3, "SELECT COUNT(*) AS count FROM \"".$table_prefix."pending\" ORDER BY \"lastupdate\" DESC;");
    $numupc = sql_fetch_assoc($findupc);
    $numrows = $numupc['count'];
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
        $findupc = sqlite3_query($slite3, "SELECT * FROM \"".$table_prefix."pending\" ORDER BY \"lastupdate\" ASC LIMIT ".sqlite3_escape_string($slite3, $startoffset).", ".$display_per_page.";");
        if ($maxpage > $display_per_page && $_GET['page'] > 1) {
            $backpage = $_GET['page'] - 1;
            echo "<a href=\"".$url_admin_file."?act=deleteupc&amp;page=".$backpage."\">Prev</a> --\n";
        }
        echo $numrows." items, displaying ".$pagestartshow." through ".$maxpage;
        if ($maxpage < $numrows) {
            $nextpage = $_GET['page'] + 1;
            echo "\n-- <a href=\"".$url_admin_file."?act=deleteupc&amp;page=".$nextpage."\">Next</a>";
        }
        ?>
   <div><br /></div>
   <table>
   <tr><th>Validate EAN/UCC</th><th>Description</th><th>Size/Weight</th><?php if ($add_quantity_row === true) { ?><th>Quantity</th><?php } ?><th>Last Mod</th></tr>
   <?php
        while ($upcinfo = sql_fetch_assoc($findupc)) { ?>
   <tr valign="top">
   <td><a href="<?php echo $url_admin_file; ?>?act=validateupc&amp;upc=<?php echo $upcinfo['upc']; ?>"><?php echo $upcinfo['upc']; ?></a></td>
   <td><?php echo htmlspecialchars($upcinfo['description'], ENT_COMPAT | ENT_HTML5, "UTF-8"); ?></td>
   <td nowrap="nowrap"><?php echo htmlspecialchars($upcinfo['sizeweight'], ENT_COMPAT | ENT_HTML5, "UTF-8"); ?></td>
   <?php if ($add_quantity_row === true) { ?><td nowrap="nowrap"><?php echo htmlspecialchars($upcinfo['quantity'], ENT_COMPAT | ENT_HTML5, "UTF-8"); ?></td><?php } ?>
   <td nowrap="nowrap"><?php echo date("j M Y, g:i A T", $upcinfo['lastupdate']); ?></td>
   </tr>
   <?php } echo "   </table>   <div><br /></div>";
    }
    if ($numrows > 0) {
        if ($maxpage > $display_per_page && $_GET['page'] > 1) {
            $backpage = $_GET['page'] - 1;
            echo "<a href=\"".$url_admin_file."?act=validateupc&amp;page=".$backpage."\">Prev</a> --\n";
        }
        echo $numrows." items, displaying ".$pagestartshow." through ".$maxpage;
        if ($maxpage < $numrows) {
            $nextpage = $_GET['page'] + 1;
            echo "\n-- <a href=\"".$url_admin_file."?act=validateupc&amp;page=".$nextpage."\">Next</a>";
        }
    }
    ?>
  </center>
  <?php echo $endhtmltag; ?>
<?php } if ($_GET['act'] == "editupc" && validate_ean13($_GET['upc']) === true && $_GET['subact'] === "editupc") {
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
          if ($add_quantity_row === true) {
              sqlite3_query($slite3, "UPDATE \"".$table_prefix."items\" SET \"description\"='".sqlite3_escape_string($slite3, $_POST['description'])."',\"sizeweight\"='".sqlite3_escape_string($slite3, $_POST['sizeweight'])."',\"quantity\"='".sqlite3_escape_string($slite3, $_POST['quantity'])."' WHERE \"upc\"='".sqlite3_escape_string($slite3, $_POST['upc'])."';");
          }
          if ($add_quantity_row === false) {
              sqlite3_query($slite3, "UPDATE \"".$table_prefix."items\" SET \"description\"='".sqlite3_escape_string($slite3, $_POST['description'])."',\"sizeweight\"='".sqlite3_escape_string($slite3, $_POST['sizeweight'])."' WHERE \"upc\"='".sqlite3_escape_string($slite3, $_POST['upc'])."';");
          }
          $_GET['upc'] = null;
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
<title> <?php echo $sitename; ?>: AdminCP : Edit UPC </title>
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
   <form action="<?php echo $url_admin_file; ?>?act=editupc" method="post">
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
    } if ($_GET['act'] == "editupc" && validate_ean13($_GET['upc']) === false) { ?>
<!DOCTYPE html>
<html lang="en">
 <head>
<title> <?php echo $sitename; ?>: AdminCP : Edit UPC </title>
<?php echo $metatags; ?>
 </head>
 <body>
  <center>
   <?php echo $navbar; ?>
   <h2>Edit UPC</h2>
   <?php
       $findupc = sqlite3_query($slite3, "SELECT COUNT(*) AS count FROM \"".$table_prefix."items\" ORDER BY \"lastupdate\" DESC;");
        $numupc = sql_fetch_assoc($findupc);
        $numrows = $numupc['count'];
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
            $findupc = sqlite3_query($slite3, "SELECT * FROM \"".$table_prefix."items\" ORDER BY \"lastupdate\" ASC LIMIT ".sqlite3_escape_string($slite3, $startoffset).", ".$display_per_page.";");
            if ($maxpage > $display_per_page && $_GET['page'] > 1) {
                $backpage = $_GET['page'] - 1;
                echo "<a href=\"".$url_admin_file."?act=editupc&amp;page=".$backpage."\">Prev</a> --\n";
            }
            echo $numrows." items, displaying ".$pagestartshow." through ".$maxpage;
            if ($maxpage < $numrows) {
                $nextpage = $_GET['page'] + 1;
                echo "\n-- <a href=\"".$url_admin_file."?act=editupc&amp;page=".$nextpage."\">Next</a>";
            }
            ?>
   <div><br /></div>
   <table>
   <tr><th>Edit EAN/UCC</th><th>Description</th><th>Size/Weight</th><?php if ($add_quantity_row === true) { ?><th>Quantity</th><?php } ?><th>Last Mod</th></tr>
   <?php
            while ($upcinfo = sql_fetch_assoc($findupc)) { ?>
   <tr valign="top">
   <td><a href="<?php echo $url_admin_file; ?>?act=editupc&amp;upc=<?php echo $upcinfo['upc']; ?>"><?php echo $upcinfo['upc']; ?></a></td>
   <td><?php echo htmlspecialchars($upcinfo['description'], ENT_COMPAT | ENT_HTML5, "UTF-8"); ?></td>
   <td nowrap="nowrap"><?php echo htmlspecialchars($upcinfo['sizeweight'], ENT_COMPAT | ENT_HTML5, "UTF-8"); ?></td>
   <?php if ($add_quantity_row === true) { ?><td nowrap="nowrap"><?php echo htmlspecialchars($upcinfo['quantity'], ENT_COMPAT | ENT_HTML5, "UTF-8"); ?></td><?php } ?>
   <td nowrap="nowrap"><?php echo date("j M Y, g:i A T", $upcinfo['lastupdate']); ?></td>
   </tr>
   <?php } echo "   </table>   <div><br /></div>";
        }
        if ($numrows > 0) {
            if ($maxpage > $display_per_page && $_GET['page'] > 1) {
                $backpage = $_GET['page'] - 1;
                echo "<a href=\"".$url_admin_file."?act=editupc&amp;page=".$backpage."\">Prev</a> --\n";
            }
            echo $numrows." items, displaying ".$pagestartshow." through ".$maxpage;
            if ($maxpage < $numrows) {
                $nextpage = $_GET['page'] + 1;
                echo "\n-- <a href=\"".$url_admin_file."?act=editupc&amp;page=".$nextpage."\">Next</a>";
            }
        }
        ?>
  </center>
  <?php echo $endhtmltag; ?>
<?php } if ($_GET['act'] == "upcdelrequests") { ?>
<!DOCTYPE html>
<html lang="en">
 <head>
<title> <?php echo $sitename; ?>: AdminCP : UPC Delete Requests </title>
<?php echo $metatags; ?>
 </head>
 <body>
  <center>
   <?php echo $navbar; ?>
   <h2>UPC Delete Requests</h2>
   <?php
   $findupc = sqlite3_query($slite3, "SELECT COUNT(*) AS count FROM \"".$table_prefix."items\" WHERE delrequest=\"yes\" ORDER BY \"lastupdate\" DESC;");
    $numupc = sql_fetch_assoc($findupc);
    $numrows = $numupc['count'];
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
        $findupc = sqlite3_query($slite3, "SELECT * FROM \"".$table_prefix."items\" WHERE delrequest=\"yes\" ORDER BY \"lastupdate\" ASC LIMIT ".sqlite3_escape_string($slite3, $startoffset).", ".$display_per_page.";");
        if ($maxpage > $display_per_page && $_GET['page'] > 1) {
            $backpage = $_GET['page'] - 1;
            echo "<a href=\"".$url_admin_file."?act=deleteupc&amp;page=".$backpage."\">Prev</a> --\n";
        }
        echo $numrows." items, displaying ".$pagestartshow." through ".$maxpage;
        if ($maxpage < $numrows) {
            $nextpage = $_GET['page'] + 1;
            echo "\n-- <a href=\"".$url_admin_file."?act=deleteupc&amp;page=".$nextpage."\">Next</a>";
        }
        ?>
   <div><br /></div>
   <table>
   <tr><th>Keep EAN/UCC</th><th>Delete EAN/UCC</th><th>Description</th><th>Size/Weight</th><?php if ($add_quantity_row === true) { ?><th>Quantity</th><?php } ?><th>Last Mod</th></tr>
   <?php
        while ($upcinfo = sql_fetch_assoc($findupc)) { ?>
   <tr valign="top">
   <td><a href="<?php echo $url_admin_file; ?>?act=undeleteupc&amp;upc=<?php echo $upcinfo['upc']; ?>"><?php echo $upcinfo['upc']; ?></a></td>
   <td><a href="<?php echo $url_admin_file; ?>?act=deleteupc&amp;upc=<?php echo $upcinfo['upc']; ?>" onclick="if(!confirm('Are you sure you want to delete UPC <?php echo $upcinfo['upc']; ?>?')) { return false; }"><?php echo $upcinfo['upc']; ?></a></td>
   <td><?php echo htmlspecialchars($upcinfo['description'], ENT_COMPAT | ENT_HTML5, "UTF-8"); ?></td>
   <td nowrap="nowrap"><?php echo htmlspecialchars($upcinfo['sizeweight'], ENT_COMPAT | ENT_HTML5, "UTF-8"); ?></td>
   <?php if ($add_quantity_row === true) { ?><td nowrap="nowrap"><?php echo htmlspecialchars($upcinfo['quantity'], ENT_COMPAT | ENT_HTML5, "UTF-8"); ?></td><?php } ?>
   <td nowrap="nowrap"><?php echo date("j M Y, g:i A T", $upcinfo['lastupdate']); ?></td>
   </tr>
   <?php } echo "   </table>   <div><br /></div>";
    }
    if ($numrows > 0) {
        if ($maxpage > $display_per_page && $_GET['page'] > 1) {
            $backpage = $_GET['page'] - 1;
            echo "<a href=\"".$url_admin_file."?act=deleteupc&amp;page=".$backpage."\">Prev</a> --\n";
        }
        echo $numrows." items, displaying ".$pagestartshow." through ".$maxpage;
        if ($maxpage < $numrows) {
            $nextpage = $_GET['page'] + 1;
            echo "\n-- <a href=\"".$url_admin_file."?act=deleteupc&amp;page=".$nextpage."\">Next</a>";
        }
    }
    ?>
  </center>
  <?php echo $endhtmltag; ?>
<?php } if ($_GET['act'] == "upceditrequests") { ?>
<!DOCTYPE html>
<html lang="en">
 <head>
<title> <?php echo $sitename; ?>: AdminCP : UPC Edit Requests </title>
<?php echo $metatags; ?>
 </head>
 <body>
  <center>
   <?php echo $navbar; ?>
   <h2>UPC Edit Requests</h2>
   <?php
       $findupc = sqlite3_query($slite3, "SELECT COUNT(*) AS count FROM \"".$table_prefix."modupc\" ORDER BY \"lastupdate\" DESC;");
        $numupc = sql_fetch_assoc($findupc);
        $numrows = $numupc['count'];
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
            $findupc = sqlite3_query($slite3, "SELECT * FROM \"".$table_prefix."modupc\" ORDER BY \"lastupdate\" ASC LIMIT ".sqlite3_escape_string($slite3, $startoffset).", ".$display_per_page.";");
            if ($maxpage > $display_per_page && $_GET['page'] > 1) {
                $backpage = $_GET['page'] - 1;
                echo "<a href=\"".$url_admin_file."?act=editupc&amp;page=".$backpage."\">Prev</a> --\n";
            }
            echo $numrows." items, displaying ".$pagestartshow." through ".$maxpage;
            if ($maxpage < $numrows) {
                $nextpage = $_GET['page'] + 1;
                echo "\n-- <a href=\"".$url_admin_file."?act=editupc&amp;page=".$nextpage."\">Next</a>";
            }
            ?>
   <div><br /></div>
   <table>
   <tr><th>Edit EAN/UCC</th><th>Description</th><th>Size/Weight</th><?php if ($add_quantity_row === true) { ?><th>Quantity</th><?php } ?><th>Last Mod</th></tr>
   <?php
            while ($upcinfo = sql_fetch_assoc($findupc)) { ?>
   <tr valign="top">
   <td><a href="<?php echo $url_admin_file; ?>?act=editupc&amp;upc=<?php echo $upcinfo['upc']; ?>"><?php echo $upcinfo['upc']; ?></a></td>
   <td><?php echo htmlspecialchars($upcinfo['description'], ENT_COMPAT | ENT_HTML5, "UTF-8"); ?></td>
   <td nowrap="nowrap"><?php echo htmlspecialchars($upcinfo['sizeweight'], ENT_COMPAT | ENT_HTML5, "UTF-8"); ?></td>
   <?php if ($add_quantity_row === true) { ?><td nowrap="nowrap"><?php echo htmlspecialchars($upcinfo['quantity'], ENT_COMPAT | ENT_HTML5, "UTF-8"); ?></td><?php } ?>
   <td nowrap="nowrap"><?php echo date("j M Y, g:i A T", $upcinfo['lastupdate']); ?></td>
   </tr>
   <?php } echo "   </table>   <div><br /></div>";
        }
        if ($numrows > 0) {
            if ($maxpage > $display_per_page && $_GET['page'] > 1) {
                $backpage = $_GET['page'] - 1;
                echo "<a href=\"".$url_admin_file."?act=editupc&amp;page=".$backpage."\">Prev</a> --\n";
            }
            echo $numrows." items, displaying ".$pagestartshow." through ".$maxpage;
            if ($maxpage < $numrows) {
                $nextpage = $_GET['page'] + 1;
                echo "\n-- <a href=\"".$url_admin_file."?act=editupc&amp;page=".$nextpage."\">Next</a>";
            }
        }
        ?>
  </center>
  <?php echo $endhtmltag;
  } ?>