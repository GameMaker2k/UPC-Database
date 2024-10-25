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

    $FileInfo: listitem.php - Last Update: 10/24/2024 Ver. 2.2.5 RC 1 - Author: cooldude2k $
*/
$File3Name = basename($_SERVER['SCRIPT_NAME']);
if ($File3Name == "listitem.php" || $File3Name == "/listitem.php") {
    chdir("../");
    require("./upc.php");
    exit();
}

if ($_GET['act'] == "neighbor" && !isset($_POST['upc'])) {
    $_GET['act'] = "lookup";
    header("Location: ".$website_url.$url_file."?act=lookup");
    exit();
}
if ($_GET['act'] == "neighbors" && !isset($_POST['upc'])) {
    $_GET['act'] = "lookup";
    header("Location: ".$website_url.$url_file."?act=lookup");
    exit();
}
if ($_GET['act'] == "latest") { ?>
<!DOCTYPE html>
<html lang="en">
 <head>
<title> <?php echo $sitename; ?>: Latest Submissions </title>
<?php echo $metatags; ?>
 </head>
 <body>
  <center>
   <?php echo $navbar; ?>
   <h2>Latest Submissions</h2>
   <?php
   if (!isset($_GET['page'])) {
       $_GET['page'] = 1;
   }
    if (!is_numeric($_GET['page'])) {
        $_GET['page'] = 1;
    }
    $meminfo = null;
    $addonurl = null;
    if ($_GET['id'] <= 0) {
        $_GET['id'] = null;
    }
    if (!is_numeric($_GET['id'])) {
        $_GET['id'] = null;
    }
    if ($_GET['id'] > 0 && $_GET['id'] !== null) {
        $findmem = sqlite3_query($slite3, "SELECT COUNT(*) AS count FROM \"".$table_prefix."members\" WHERE \"id\"=".sqlite3_escape_string($slite3, $_GET['id']).";");
        $nummems = sql_fetch_assoc($findmem);
        $numrows = $nummems['count'];
        if ($numrows <= 0) {
            $_GET['id'] = null;
        }
        if ($numrows > 0) {
            $addonurl = "&amp;id=".$_GET['id'];
            $findmem = sqlite3_query($slite3, "SELECT * FROM \"".$table_prefix."members\" WHERE \"id\"=".sqlite3_escape_string($slite3, $_GET['id']).";");
            $meminfo = sql_fetch_assoc($findmem);
        }
    }
    if ($meminfo === null) {
        $findupc = sqlite3_query($slite3, "SELECT COUNT(*) AS count FROM \"".$table_prefix."items\" ORDER BY \"lastupdate\" DESC;");
    }
    if ($meminfo !== null) {
        $findupc = sqlite3_query($slite3, "SELECT COUNT(*) AS count FROM \"".$table_prefix."items\" WHERE \"userid\"='".sqlite3_escape_string($slite3, $_GET['id'])."' ORDER BY \"lastupdate\" DESC;");
    }
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
        if ($meminfo === null) {
            $findupc = sqlite3_query($slite3, "SELECT * FROM \"".$table_prefix."items\" ORDER BY \"lastupdate\" DESC LIMIT ".sqlite3_escape_string($slite3, $startoffset).", ".$display_per_page.";");
        }
        if ($meminfo !== null) {
            $findupc = sqlite3_query($slite3, "SELECT * FROM \"".$table_prefix."items\" WHERE \"userid\"='".sqlite3_escape_string($slite3, $_GET['id'])."' ORDER BY \"lastupdate\" DESC LIMIT ".sqlite3_escape_string($slite3, $startoffset).", ".$display_per_page.";");
        }
        if ($maxpage > $display_per_page && $_GET['page'] > 1) {
            $backpage = $_GET['page'] - 1;
            echo "<a href=\"".$url_file."?act=latest".$addonurl."&amp;page=".$backpage."\">Prev</a> --\n";
        }
        echo $numrows." items, displaying ".$pagestartshow." through ".$maxpage;
        if ($maxpage < $numrows) {
            $nextpage = $_GET['page'] + 1;
            echo "\n-- <a href=\"".$url_file."?act=latest".$addonurl."&amp;page=".$nextpage."\">Next</a>";
        }
        ?>
   <div><br /></div>
   <table>
   <tr><th>EAN/UCC</th><th>Description</th><th>Size/Weight</th><?php if ($add_quantity_row === true) { ?><th>Quantity</th><?php } ?><th>Last Mod</th></tr>
   <?php
        while ($upcinfo = sql_fetch_assoc($findupc)) {
            ?>
   <tr valign="top">
   <td><a href="<?php echo $url_file; ?>?act=lookup&amp;upc=<?php echo $upcinfo['upc']; ?>"><?php echo $upcinfo['upc']; ?></a></td>
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
            echo "<a href=\"".$url_file."?act=latest".$addonurl."&amp;page=".$backpage."\">Prev</a> --\n";
        }
        echo $numrows." items, displaying ".$pagestartshow." through ".$maxpage;
        if ($maxpage < $numrows) {
            $nextpage = $_GET['page'] + 1;
            echo "\n-- <a href=\"".$url_file."?act=latest".$addonurl."&amp;page=".$nextpage."\">Next</a>";
        }
    }
    ?>
   <div><br /></div>
   <form name="upcform" action="<?php echo $url_file; ?>?act=lookup" onsubmit="if(validate_str_size(document.upcform.upc.value)==false) { return false; }" method="get">
    <input type="hidden" name="act" value="lookup" />
    <table>
    <tr><td style="text-align: center;"><input type="text" name="upc" size="16" maxlength="13" value="<?php echo $lookupupc; ?>" /> <input type="submit" value="Look Up UPC" /></td></tr>
   </table>
   </form>
  </center>
  <?php echo $endhtmltag; ?>
<?php } if (isset($_GET['upc']) && ($_GET['act'] == "neighbor" || $_GET['act'] == "neighbors")) { ?>
<!DOCTYPE html>
<html lang="en">
 <head>
<title> <?php echo $sitename; ?>: Item Neighbors </title>
<?php echo $metatags; ?>
 </head>
 <body>
  <center>
   <?php echo $navbar; ?>
   <h2>Item Neighbors</h2>
   <?php
    if (!isset($_GET['page'])) {
        $_GET['page'] = 1;
    }
      if (!is_numeric($_GET['page'])) {
          $_GET['page'] = 1;
      }
      $meminfo = null;
      $addonurl = null;
      if ($_GET['id'] <= 0) {
          $_GET['id'] = null;
      }
      if (!is_numeric($_GET['id'])) {
          $_GET['id'] = null;
      }
      if ($_GET['id'] > 0 && $_GET['id'] !== null) {
          $findmem = sqlite3_query($slite3, "SELECT COUNT(*) AS count FROM \"".$table_prefix."members\" WHERE \"id\"=".sqlite3_escape_string($slite3, $_GET['id']).";");
          $nummems = sql_fetch_assoc($findmem);
          $numrows = $nummems['count'];
          if ($numrows <= 0) {
              $_GET['id'] = null;
          }
          if ($numrows > 0) {
              $addonurl = "&amp;id=".$_GET['id'];
              $findmem = sqlite3_query($slite3, "SELECT * FROM \"".$table_prefix."members\" WHERE \"id\"=".sqlite3_escape_string($slite3, $_GET['id']).";");
              $meminfo = sql_fetch_assoc($findmem);
          }
      }
      preg_match("/^(\d{7})/", $_GET['upc'], $fix_matches);
      $findprefix = $fix_matches[1];
      if ($meminfo === null) {
          $findupc = sqlite3_query($slite3, "SELECT COUNT(*) AS count FROM \"".$table_prefix."items\" WHERE \"upc\" LIKE '".sqlite3_escape_string($slite3, $findprefix)."%' ORDER BY \"upc\" ASC;");
      }
      if ($meminfo !== null) {
          $findupc = sqlite3_query($slite3, "SELECT COUNT(*) AS count FROM \"".$table_prefix."items\" WHERE \"upc\" AND \"userid\"='".sqlite3_escape_string($slite3, $_GET['id'])."' LIKE '".sqlite3_escape_string($slite3, $findprefix)."%' ORDER BY \"upc\" ASC;");
      }
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
              $pagestartshow = 0;
          }
          if ($startoffset < 0) {
              $startoffset = 0;
          }
          if ($meminfo === null) {
              $findupc = sqlite3_query($slite3, "SELECT * FROM \"".$table_prefix."items\" WHERE \"upc\" LIKE '".sqlite3_escape_string($slite3, $findprefix)."%' ORDER BY \"upc\" ASC;");
          }
          if ($meminfo !== null) {
              $findupc = sqlite3_query($slite3, "SELECT * FROM \"".$table_prefix."items\" WHERE \"upc\" LIKE '".sqlite3_escape_string($slite3, $findprefix)."%' AND \"userid\"='".sqlite3_escape_string($slite3, $_GET['id'])."' ORDER BY \"upc\" ASC;");
          }
          if ($maxpage > $display_per_page && $_GET['page'] > 1) {
              $backpage = $_GET['page'] - 1;
              echo "<a href=\"".$url_file."?act=neighbor".$addonurl."&amp;page=".$backpage."\">Prev</a> --\n";
          }
          echo $numrows." items, displaying ".$pagestartshow." through ".$maxpage;
          if ($maxpage < $numrows) {
              $nextpage = $_GET['page'] + 1;
              echo "\n-- <a href=\"".$url_file."?act=neighbor".$addonurl."&amp;page=".$nextpage."\">Next</a>";
          }
          ?>
   <div><br /></div>
   <table>
   <tr><th>EAN/UCC</th><th>Description</th><th>Size/Weight</th><?php if ($add_quantity_row === true) { ?><th>Quantity</th><?php } ?><th>Last Mod</th></tr>
   <?php
          while ($upcinfo = sql_fetch_assoc($findupc)) {
              ?>
   <tr valign="top">
   <td><a href="<?php echo $url_file; ?>?act=lookup&amp;upc=<?php echo $upcinfo['upc']; ?>"><?php echo $upcinfo['upc']; ?></a></td>
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
              echo "<a href=\"".$url_file."?act=neighbor".$addonurl."&amp;page=".$backpage."\">Prev</a> --\n";
          }
          echo $numrows." items, displaying ".$pagestartshow." through ".$maxpage;
          if ($maxpage < $numrows) {
              $nextpage = $_GET['page'] + 1;
              echo "\n-- <a href=\"".$url_file."?act=neighbor".$addonurl."&amp;page=".$nextpage."\">Next</a>";
          }
      }
      ?>
   <div><br /></div>
   <form action="<?php echo $url_file; ?>?act=lookup" method="get">
    <input type="hidden" name="act" value="lookup" />
    <table>
    <tr><td style="text-align: center;"><input type="text" name="upc" size="16" maxlength="13" value="<?php echo $lookupupc; ?>" /> <input type="submit" value="Look Up UPC" /></td></tr>
   </table>
   </form>
  </center>
  <?php echo $endhtmltag; ?>
<?php } if ($_GET['act'] == "search" && (isset($_POST['searchterms']) || isset($_POST['searchterms']))) {
      if (!isset($_POST['searchterms']) && isset($_GET['searchterms'])) {
          $_POST['searchterms'] = $_GET['searchterms'];
      }
      $_POST['searchterms'] = trim($_POST['searchterms']);
      $_POST['searchterms'] = remove_spaces($_POST['searchterms']);
      if (strlen($_POST['searchterms']) > 100 || strlen($_POST['searchterms']) <= 3) {
          $_POST['searchterms'] = null;
      }
      if ($_POST['searchterms'] == "" || $_POST['searchterms'] == null) {
          header("Location: ".$website_url.$url_file."?act=search");
          exit();
      }
      ?>
<!DOCTYPE html>
<html lang="en">
 <head>
<title> <?php echo $sitename; ?>: Search Results for &quot;<?php echo htmlspecialchars($_POST['searchterms'], ENT_COMPAT | ENT_HTML5, "UTF-8"); ?>&quot; </title>
<?php echo $metatags; ?>
 </head>
 <body>
  <center>
   <?php echo $navbar; ?>
   <h2>Search Results for &quot;<?php echo htmlspecialchars($_POST['searchterms'], ENT_COMPAT | ENT_HTML5, "UTF-8"); ?>&quot;</h2>
   <?php
         if (!isset($_GET['page'])) {
             $_GET['page'] = 1;
         }
      if (!is_numeric($_GET['page'])) {
          $_GET['page'] = 1;
      }
      preg_match("/^(\d{7})/", $_GET['upc'], $fix_matches);
      $findprefix = $fix_matches[1];
      $findupc = sqlite3_query($slite3, "SELECT COUNT(*) AS count FROM \"".$table_prefix."items\" WHERE \"description\" LIKE '%".sqlite3_escape_string($slite3, $_POST['searchterms'])."%';");
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
              $pagestartshow = 0;
          }
          if ($startoffset < 0) {
              $startoffset = 0;
          }
          $findupc = sqlite3_query($slite3, "SELECT * FROM \"".$table_prefix."items\" WHERE \"description\" LIKE '%".sqlite3_escape_string($slite3, $_POST['searchterms'])."%';");
          if ($maxpage > $display_per_page && $_GET['page'] > 1) {
              $backpage = $_GET['page'] - 1;
              echo "<a href=\"".$url_file."?act=search&amp;searchterms=".htmlspecialchars($_GET['searchterms'], ENT_COMPAT | ENT_HTML5, "UTF-8").$addonurl."&amp;page=".$backpage."\">Prev</a> --\n";
          }
          echo $numrows." items, displaying ".$pagestartshow." through ".$maxpage;
          if ($maxpage < $numrows) {
              $nextpage = $_GET['page'] + 1;
              echo "\n-- <a href=\"".$url_file."?act=search&amp;searchterms=".htmlspecialchars($_GET['searchterms'], ENT_COMPAT | ENT_HTML5, "UTF-8").$addonurl."&amp;page=".$nextpage."\">Next</a>";
          }
          ?>
   <div><br /></div>
   <table>
   <tr><th>EAN/UCC</th><th>Description</th><th>Size/Weight</th><?php if ($add_quantity_row === true) { ?><th>Quantity</th><?php } ?><th>Last Mod</th></tr>
   <?php
          while ($upcinfo = sql_fetch_assoc($findupc)) {
              ?>
   <tr valign="top">
   <td><a href="<?php echo $url_file; ?>?act=lookup&amp;upc=<?php echo $upcinfo['upc']; ?>"><?php echo $upcinfo['upc']; ?></a></td>
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
              echo "<a href=\"".$url_file."?act=search&amp;searchterms=".htmlspecialchars($_GET['searchterms'], ENT_COMPAT | ENT_HTML5, "UTF-8").$addonurl."&amp;page=".$backpage."\">Prev</a> --\n";
          }
          echo $numrows." items, displaying ".$pagestartshow." through ".$maxpage;
          if ($maxpage < $numrows) {
              $nextpage = $_GET['page'] + 1;
              echo "\n-- <a href=\"".$url_file."?act=search&amp;searchterms=".htmlspecialchars($_GET['searchterms'], ENT_COMPAT | ENT_HTML5, "UTF-8").$addonurl."&amp;page=".$nextpage."\">Next</a>";
          }
      }
      ?>
   <div><br /></div>
   <form action="<?php echo $url_file; ?>?act=search" method="post">
    <table>
    <tr><td style="text-align: center;">Search String:</td><td><input type="text" name="searchterms" size="40" maxlength="100" value="<?php echo htmlspecialchars($_POST['searchterms'], ENT_COMPAT | ENT_HTML5, "UTF-8"); ?>"></td></tr>
   </table>
   <div><br /><input type="submit" value="Search">&nbsp;<input type="reset" value="Clear"></div>
   </form>
  </center>
  <?php echo $endhtmltag; ?>
<?php } if ($_GET['act'] == "search" && !isset($_POST['searchterms'])) { ?>
<!DOCTYPE html>
<html lang="en">
 <head>
<title> <?php echo $sitename; ?>: Search by Description </title>
<?php echo $metatags; ?>
 </head>

 <body>
  <center>
   <?php echo $navbar; ?>
   <h2>Search by Description</h2>
   <form action="<?php echo $url_file; ?>?act=search" method="post">
    <table>
    <tr><td style="text-align: center;">Search String:</td><td><input type="text" name="searchterms" size="40" maxlength="100"></td></tr>
   </table>
   <div><br /><input type="submit" value="Search">&nbsp;<input type="reset" value="Clear"></div>
   </form>
  </center>
  <?php echo $endhtmltag;
  } ?>