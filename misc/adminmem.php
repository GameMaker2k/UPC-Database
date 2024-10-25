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

    $FileInfo: adminmem.php - Last Update: 10/24/2024 Ver. 2.2.5 RC 1 - Author: cooldude2k $
*/
$File3Name = basename($_SERVER['SCRIPT_NAME']);
if ($File3Name == "adminmem.php" || $File3Name == "/adminmem.php") {
    chdir("../");
    require("./upc.php");
    exit();
}

if ($_GET['act'] == "deletemember" && isset($_GET['id']) && $_GET['id'] > 1) {
    $findmem = sqlite3_query($slite3, "SELECT COUNT(*) AS count FROM \"".$table_prefix."members\" WHERE \"id\"=".sqlite3_escape_string($slite3, $_GET['id'])." AND \"id\"<>1;");
    $nummems = sql_fetch_assoc($findmem);
    $numrows = $nummems['count'];
    if ($numrows > 0) {
        $delupc = sqlite3_query($slite3, "DELETE FROM \"".$table_prefix."members\" WHERE \"id\"=".sqlite3_escape_string($slite3, $_GET['id']).";");
        sqlite3_query($slite3, "UPDATE \"".$table_prefix."items\" SET \"userid\"=0 WHERE \"userid\"=".sqlite3_escape_string($slite3, $_GET['id']).";");
        sqlite3_query($slite3, "UPDATE \"".$table_prefix."items\" SET \"edituserid\"=0 WHERE \"edituserid\"='".sqlite3_escape_string($slite3, $_GET['id'])."';");
        sqlite3_query($slite3, "UPDATE \"".$table_prefix."pending\" SET \"userid\"=0 WHERE \"userid\"=".sqlite3_escape_string($slite3, $_GET['id']).";");
        sqlite3_query($slite3, "UPDATE \"".$table_prefix."modupc\" SET \"userid\"=0 WHERE \"userid\"=".sqlite3_escape_string($slite3, $_GET['id']).";");
    }
}
if ($_GET['act'] == "deletemember") { ?>
<!DOCTYPE html>
<html lang="en">
 <head>
<title> <?php echo $sitename; ?>: AdminCP : Delete Member </title>
<?php echo $metatags; ?>
 </head>
 <body>
  <center>
   <?php echo $navbar; ?>
   <h2>Delete Member</h2>
   <?php
   $findmem = sqlite3_query($slite3, "SELECT COUNT(*) AS count FROM \"".$table_prefix."members\" WHERE \"id\"<>1 ORDER BY \"id\" ASC;");
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
        $findmem = sqlite3_query($slite3, "SELECT * FROM \"".$table_prefix."members\" WHERE \"id\"<>1 ORDER BY \"id\" ASC LIMIT ".sqlite3_escape_string($slite3, $startoffset).", ".$display_per_page.";");
        if ($maxpage > $display_per_page && $_GET['page'] > 1) {
            $backpage = $_GET['page'] - 1;
            echo "<a href=\"".$url_admin_file."?act=deletemember&amp;page=".$backpage."\">Prev</a> --\n";
        }
        echo $numrows." members, displaying ".$pagestartshow." through ".$maxpage;
        if ($maxpage < $numrows) {
            $nextpage = $_GET['page'] + 1;
            echo "\n-- <a href=\"".$url_admin_file."?act=deletemember&amp;page=".$nextpage."\">Next</a>";
        }
        ?>
   <div><br /></div>
   <table>
   <tr><th>Delete Member</th><th>Email</th><th>IP Address</th><th>Last Active</th></tr>
   <?php
        while ($meminfo = sql_fetch_assoc($findmem)) { ?>
   <tr valign="top">
   <td><a href="<?php echo $url_admin_file; ?>?act=deletemember&amp;id=<?php echo $meminfo['id']; ?>" onclick="if(!confirm('Are you sure you want to delete member <?php echo htmlspecialchars($meminfo['name'], ENT_COMPAT | ENT_HTML5, "UTF-8"); ?>?')) { return false; }"><?php echo htmlspecialchars($meminfo['name'], ENT_COMPAT | ENT_HTML5, "UTF-8"); ?></a></td>
   <td><?php echo htmlspecialchars($meminfo['email'], ENT_COMPAT | ENT_HTML5, "UTF-8"); ?></td>
   <td nowrap="nowrap"><?php echo $meminfo['ip']; ?></td>
   <td nowrap="nowrap"><?php echo date("j M Y, g:i A T", $meminfo['lastactive']); ?></td>
   </tr>
   <?php } echo "   </table>   <div><br /></div>";
    }
    if ($numrows > 0) {
        if ($maxpage > $display_per_page && $_GET['page'] > 1) {
            $backpage = $_GET['page'] - 1;
            echo "<a href=\"".$url_admin_file."?act=deletemember&amp;page=".$backpage."\">Prev</a> --\n";
        }
        echo $numrows." members, displaying ".$pagestartshow." through ".$maxpage;
        if ($maxpage < $numrows) {
            $nextpage = $_GET['page'] + 1;
            echo "\n-- <a href=\"".$url_admin_file."?act=deletemember&amp;page=".$nextpage."\">Next</a>";
        }
    }
    ?>
  </center>
  <?php echo $endhtmltag; ?>
<?php } if ($_GET['act'] == "validatemember" && isset($_GET['id']) && $_GET['id'] > 1) {
      $findmem = sqlite3_query($slite3, "SELECT COUNT(*) AS count FROM \"".$table_prefix."members\" WHERE \"id\"=".sqlite3_escape_string($slite3, $_GET['id'])." AND \"id\"<>1 AND \"validated\"='no';");
      $nummems = sql_fetch_assoc($findmem);
      $numrows = $nummems['count'];
      if ($numrows > 0) {
          sqlite3_query($slite3, "UPDATE \"".$table_prefix."members\" SET \"validated\"='yes' WHERE \"id\"=".sqlite3_escape_string($slite3, $_GET['id'])." AND \"id\"<>1;");
      }
  }
if ($_GET['act'] == "validatemember") { ?>
<!DOCTYPE html>
<html lang="en">
 <head>
<title> <?php echo $sitename; ?>: AdminCP : Validate Member </title>
<?php echo $metatags; ?>
 </head>
 <body>
  <center>
   <?php echo $navbar; ?>
   <h2>Validate Member</h2>
   <?php
   $findmem = sqlite3_query($slite3, "SELECT COUNT(*) AS count FROM \"".$table_prefix."members\" WHERE \"validated\"='no' AND \"id\"<>1 ORDER BY \"id\" ASC;");
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
        $findmem = sqlite3_query($slite3, "SELECT * FROM \"".$table_prefix."members\" WHERE \"validated\"='no' AND \"id\"<>1 ORDER BY \"id\" ASC LIMIT ".sqlite3_escape_string($slite3, $startoffset).", ".$display_per_page.";");
        if ($maxpage > $display_per_page && $_GET['page'] > 1) {
            $backpage = $_GET['page'] - 1;
            echo "<a href=\"".$url_admin_file."?act=validatemember&amp;page=".$backpage."\">Prev</a> --\n";
        }
        echo $numrows." members, displaying ".$pagestartshow." through ".$maxpage;
        if ($maxpage < $numrows) {
            $nextpage = $_GET['page'] + 1;
            echo "\n-- <a href=\"".$url_admin_file."?act=validatemember&amp;page=".$nextpage."\">Next</a>";
        }
        ?>
   <div><br /></div>
   <table>
   <tr><th>Validate Member</th><th>Email</th><th>IP Address</th><th>Last Active</th></tr>
   <?php
        while ($meminfo = sql_fetch_assoc($findmem)) { ?>
   <tr valign="top">
   <td><a href="<?php echo $url_admin_file; ?>?act=validatemember&amp;id=<?php echo $meminfo['id']; ?>"><?php echo htmlspecialchars($meminfo['name'], ENT_COMPAT | ENT_HTML5, "UTF-8"); ?></a></td>
   <td><?php echo htmlspecialchars($meminfo['email'], ENT_COMPAT | ENT_HTML5, "UTF-8"); ?></td>
   <td nowrap="nowrap"><?php echo $meminfo['ip']; ?></td>
   <td nowrap="nowrap"><?php echo date("j M Y, g:i A T", $meminfo['lastactive']); ?></td>
   </tr>
   <?php } echo "   </table>   <div><br /></div>";
    }
    if ($numrows > 0) {
        if ($maxpage > $display_per_page && $_GET['page'] > 1) {
            $backpage = $_GET['page'] - 1;
            echo "<a href=\"".$url_admin_file."?act=validatemember&amp;page=".$backpage."\">Prev</a> --\n";
        }
        echo $numrows." members, displaying ".$pagestartshow." through ".$maxpage;
        if ($maxpage < $numrows) {
            $nextpage = $_GET['page'] + 1;
            echo "\n-- <a href=\"".$url_admin_file."?act=validatemember&amp;page=".$nextpage."\">Next</a>";
        }
    }
    ?>
  </center>
  <?php echo $endhtmltag; ?>
<?php } if ($_GET['act'] == "editmember" && isset($_GET['id']) && $_GET['id'] > 1 && $_GET['subact'] == "editmember") {
      if (!isset($_POST['username'])) {
          $_POST['username'] = null;
      }
      if (!isset($_POST['validateitems'])) {
          $_POST['validateitems'] = "yes";
      }
      if (!isset($_POST['admin'])) {
          $_POST['admin'] = "no";
      }
      if ($_POST['admin'] != "no" && $_POST['admin'] != "yes") {
          $_POST['admin'] = "yes";
      }
      if ($_POST['validateitems'] != "no" && $_POST['validateitems'] != "yes") {
          $_POST['validateitems'] = "yes";
      }
      $_POST['username'] = trim($_POST['username']);
      $_POST['username'] = remove_spaces($_POST['username']);
      if ($_POST['username'] == "" || $_POST['username'] == null) {
          $_GET['id'] = null;
          $_GET['subact'] = null;
      }
      if ($_GET['subact'] != null && $_GET['id'] != null) {
          $findmem = sqlite3_query($slite3, "SELECT COUNT(*) AS count FROM \"".$table_prefix."members\" WHERE \"id\"=".sqlite3_escape_string($slite3, $_GET['id'])." AND \"id\"<>1;");
          $nummems = sql_fetch_assoc($findmem);
          $numrows = $nummems['count'];
          if ($numrows > 0) {
              $findmem = sqlite3_query($slite3, "SELECT * FROM \"".$table_prefix."members\" WHERE \"id\"=".sqlite3_escape_string($slite3, $_GET['id'])." AND \"id\"<>1;");
              $meminfo = sql_fetch_assoc($findmem);
              $tryfindmem = sqlite3_query($slite3, "SELECT * FROM \"".$table_prefix."members\" WHERE \"name\"=".sqlite3_escape_string($slite3, $_POST['username']).";");
              $trymeminfo = sql_fetch_assoc($findmem);
              if (!isset($trymeminfo['id'])) {
                  $trymeminfo['id'] = $meminfo['id'];
              }
              $findupc = sqlite3_query($slite3, "SELECT COUNT(*) AS count FROM \"".$table_prefix."pending\" WHERE \"userid\"='".sqlite3_escape_string($slite3, $meminfo['id'])."';");
              $numupc = sql_fetch_assoc($findupc);
              $nummypendings = $numupc['count'];
              $findupc = sqlite3_query($slite3, "SELECT COUNT(*) AS count FROM \"".$table_prefix."items\" WHERE \"userid\"='".sqlite3_escape_string($slite3, $meminfo['id'])."';");
              $numupc = sql_fetch_assoc($findupc);
              $nummyitems = $numupc['count'];
              if ($meminfo['numitems'] != $nummyitems && $meminfo['numpending'] == $nummypendings) {
                  sqlite3_query($slite3, "UPDATE \"".$table_prefix."members\" SET \"numitems\"=".sqlite3_escape_string($slite3, $nummyitems)." WHERE \"id\"=".sqlite3_escape_string($slite3, $meminfo['id']).";");
              }
              if ($meminfo['numitems'] == $nummyitems && $meminfo['numpending'] != $nummypendings) {
                  sqlite3_query($slite3, "UPDATE \"".$table_prefix."members\" SET \"numpending\"=".sqlite3_escape_string($slite3, $nummypendings)." WHERE \"id\"=".sqlite3_escape_string($slite3, $meminfo['id']).";");
              }
              if ($meminfo['numitems'] != $nummyitems && $meminfo['numpending'] != $nummypendings) {
                  sqlite3_query($slite3, "UPDATE \"".$table_prefix."members\" SET \"numitems\"=".sqlite3_escape_string($slite3, $nummyitems).",\"numpending\"=".sqlite3_escape_string($slite3, $nummypendings)." WHERE \"id\"=".sqlite3_escape_string($slite3, $meminfo['id']).";");
              }
              if ($trymeminfo['id'] != $meminfo['id']) {
                  sqlite3_query($slite3, "UPDATE \"".$table_prefix."members\" SET \"validateitems\"='".sqlite3_escape_string($slite3, $_POST['validateitems'])."',\"admin\"='".sqlite3_escape_string($slite3, $_POST['admin'])."' WHERE \"id\"=".sqlite3_escape_string($slite3, $meminfo['id']).";");
                  $_GET['id'] = null;
                  $_GET['subact'] = null;
              }
              if ($trymeminfo['id'] == $meminfo['id']) {
                  sqlite3_query($slite3, "UPDATE \"".$table_prefix."members\" SET \"name\"='".sqlite3_escape_string($slite3, $_POST['username'])."',\"validateitems\"='".sqlite3_escape_string($slite3, $_POST['validateitems'])."',\"admin\"='".sqlite3_escape_string($slite3, $_POST['admin'])."' WHERE \"id\"=".sqlite3_escape_string($slite3, $meminfo['id']).";");
                  sqlite3_query($slite3, "UPDATE \"".$table_prefix."items\" SET \"username\"='".sqlite3_escape_string($slite3, $_POST['username'])."' WHERE \"username\"='".sqlite3_escape_string($slite3, $meminfo['name'])."';");
                  sqlite3_query($slite3, "UPDATE \"".$table_prefix."items\" SET \"editname\"='".sqlite3_escape_string($slite3, $_POST['username'])."' WHERE \"editname\"='".sqlite3_escape_string($slite3, $meminfo['name'])."';");
                  sqlite3_query($slite3, "UPDATE \"".$table_prefix."pending\" SET \"username\"='".sqlite3_escape_string($slite3, $_POST['username'])."' WHERE \"username\"='".sqlite3_escape_string($slite3, $meminfo['name'])."';");
                  sqlite3_query($slite3, "UPDATE \"".$table_prefix."modupc\" SET \"username\"='".sqlite3_escape_string($slite3, $_POST['username'])."' WHERE \"username\"='".sqlite3_escape_string($slite3, $meminfo['name'])."';");
                  $_GET['id'] = null;
                  $_GET['subact'] = null;
              }
          }
      }
  }
if ($_GET['act'] == "editmember" && isset($_GET['id']) && $_GET['id'] > 1 && $_GET['subact'] === null) {
    $findmem = sqlite3_query($slite3, "SELECT COUNT(*) AS count FROM \"".$table_prefix."members\" WHERE \"id\"=".sqlite3_escape_string($slite3, $_GET['id'])." AND \"id\"<>1;");
    $nummems = sql_fetch_assoc($findmem);
    $numrows = $nummems['count'];
    if ($numrows < 0) {
        $_GET['id'] = null;
    }
    if ($numrows > 0) {
        $findmem = sqlite3_query($slite3, "SELECT * FROM \"".$table_prefix."members\" WHERE \"id\"=".sqlite3_escape_string($slite3, $_GET['id'])." AND \"id\"<>1;");
        $meminfo = sql_fetch_assoc($findmem);
        $findupc = sqlite3_query($slite3, "SELECT COUNT(*) AS count FROM \"".$table_prefix."items\" WHERE \"userid\"='".sqlite3_escape_string($slite3, $meminfo['id'])."';");
        $nummems = sql_fetch_assoc($findupc);
        $nummyitems = $nummems['count'];
        $findupc = sqlite3_query($slite3, "SELECT COUNT(*) AS count FROM \"".$table_prefix."pending\" WHERE \"userid\"='".sqlite3_escape_string($slite3, $meminfo['id'])."';");
        $nummems = sql_fetch_assoc($findupc);
        $nummypendings = $nummems['count'];
        $findupc = sqlite3_query($slite3, "SELECT COUNT(*) AS count FROM \"".$table_prefix."modupc\" WHERE \"userid\"='".sqlite3_escape_string($slite3, $meminfo['id'])."';");
        $nummems = sql_fetch_assoc($findupc);
        $nummymods = $nummems['count'];
        ?>
<!DOCTYPE html>
<html lang="en">
 <head>
<title> <?php echo $sitename; ?>: AdminCP : Edit Member </title>
<?php echo $metatags; ?>
 </head>
 <body>
  <center>
   <?php echo $navbar; ?>
   <h2>Edit Member</h2>
   <form action="<?php echo $url_admin_file; ?>?act=editmember" method="post">
    <table>
    <tr><td style="text-align: center;">Username:</td><td><input type="text" name="username" value="<?php echo htmlspecialchars($meminfo['name'], ENT_COMPAT | ENT_HTML5, "UTF-8"); ?>" /></td></tr>
    <tr><td style="text-align: center;">New Items Unvalidated:</td><td><select name="validateitems"><option value="yes"<?php if ($meminfo['validateitems'] == "yes") { ?> selected="selected"<?php } ?>>Yes</option><option value="no"<?php if ($meminfo['validateitems'] == "no") { ?> selected="selected"<?php } ?>>No</option></select></td></tr>
    <tr><td style="text-align: center;">Has Admin Power:</td><td><select name="admin"><option value="yes"<?php if ($meminfo['admin'] == "yes") { ?> selected="selected"<?php } ?>>Yes</option><option value="no"<?php if ($meminfo['admin'] == "no") { ?> selected="selected"<?php } ?>>No</option></select></td></tr>
    <tr><td style="text-align: center;">Items Entered:</td><td><?php echo $nummyitems; ?></td></tr>
    <tr><td style="text-align: center;">Pending Items:</td><td><?php echo $nummypendings; ?></td></tr>
    <tr><td style="text-align: center;">Item Edit Requests:</td><td><?php echo $nummymods; ?></td></tr>
   </table>
   <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>" />
   <input type="hidden" name="subact" value="editmember" />
   <div><br /><input type="submit" value="Edit Member" /></div>
   </form>
  </center>
  <?php echo $endhtmltag; ?>
<?php }
    } if ($_GET['act'] == "editmember" && !isset($_GET['id']) && $_GET['subact'] === null) { ?>
<!DOCTYPE html>
<html lang="en">
 <head>
<title> <?php echo $sitename; ?>: AdminCP : Edit Member </title>
<?php echo $metatags; ?>
 </head>
 <body>
  <center>
   <?php echo $navbar; ?>
   <h2>Edit Member</h2>
   <?php
       $findmem = sqlite3_query($slite3, "SELECT COUNT(*) AS count FROM \"".$table_prefix."members\" WHERE \"id\"<>1 ORDER BY \"id\" ASC;");
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
            $findmem = sqlite3_query($slite3, "SELECT * FROM \"".$table_prefix."members\" WHERE \"id\"<>1 ORDER BY \"id\" ASC LIMIT ".sqlite3_escape_string($slite3, $startoffset).", ".$display_per_page.";");
            if ($maxpage > $display_per_page && $_GET['page'] > 1) {
                $backpage = $_GET['page'] - 1;
                echo "<a href=\"".$url_admin_file."?act=editmember&amp;page=".$backpage."\">Prev</a> --\n";
            }
            echo $numrows." members, displaying ".$pagestartshow." through ".$maxpage;
            if ($maxpage < $numrows) {
                $nextpage = $_GET['page'] + 1;
                echo "\n-- <a href=\"".$url_admin_file."?act=editmember&amp;page=".$nextpage."\">Next</a>";
            }
            ?>
   <div><br /></div>
   <table>
   <tr><th>Edit Member</th><th>Email</th><th>IP Address</th><th>Last Active</th></tr>
   <?php
            while ($meminfo = sql_fetch_assoc($findmem)) { ?>
   <tr valign="top">
   <td><a href="<?php echo $url_admin_file; ?>?act=editmember&amp;id=<?php echo $meminfo['id']; ?>"><?php echo htmlspecialchars($meminfo['name'], ENT_COMPAT | ENT_HTML5, "UTF-8"); ?></a></td>
   <td><?php echo htmlspecialchars($meminfo['email'], ENT_COMPAT | ENT_HTML5, "UTF-8"); ?></td>
   <td nowrap="nowrap"><?php echo $meminfo['ip']; ?></td>
   <td nowrap="nowrap"><?php echo date("j M Y, g:i A T", $meminfo['lastactive']); ?></td>
   </tr>
   <?php } echo "   </table>   <div><br /></div>";
        }
        if ($numrows > 0) {
            if ($maxpage > $display_per_page && $_GET['page'] > 1) {
                $backpage = $_GET['page'] - 1;
                echo "<a href=\"".$url_admin_file."?act=editmember&amp;page=".$backpage."\">Prev</a> --\n";
            }
            echo $numrows." members, displaying ".$pagestartshow." through ".$maxpage;
            if ($maxpage < $numrows) {
                $nextpage = $_GET['page'] + 1;
                echo "\n-- <a href=\"".$url_admin_file."?act=editmember&amp;page=".sqlite3_escape_string($slite3, $nextpage)."\">Next</a>";
            }
        }
        ?>
  </center>
  <?php echo $endhtmltag;
    } ?>