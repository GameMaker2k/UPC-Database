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

    $FileInfo: dumpfile.php - Last Update: 02/13/2012 Ver. 2.2.5 RC 1 - Author: cooldude2k $
*/
$File3Name = basename($_SERVER['SCRIPT_NAME']);
if ($File3Name=="dumpfile.php"||$File3Name=="/dumpfile.php") {
	chdir("../");
	require("./upc.php");
	exit(); }

if($_GET['act']=="csv"||$_GET['act']=="dumpcsv") { 
@header("Content-Type: text/csv; charset=UTF-8"); 
@header("Content-Disposition: attachment; filename=\"".$sqlitedatabase.".csv\"");
$deep_sub_act = null;
if(isset($_GET['deepsubact'])) { $deep_sub_act = $_GET['deepsubact']; }
if(isset($_GET['subact'])&&preg_match("/([a-z]+),([a-z]+)/", $_GET['subact'], $subact_part)) {
	$_GET['subact'] = $subact_part[1]; $deep_sub_act = $subact_part[2]; }
if($_GET['subact']=="random"||$_GET['subact']=="rand") {
$findupc = sqlite3_query($slite3, "SELECT * FROM \"".$table_prefix."items\" ORDER BY RANDOM() LIMIT 1;"); 
$upcinfo = sql_fetch_assoc($findupc); $_GET['upc'] = $upcinfo['upc']; $_GET['subact'] = "lookup"; }
?>
"upc", "description", "sizeweight"<?php if($add_quantity_row===true) { ?>, "quantity"<?php } ?>
<?php
if($_GET['subact']=="neighbor"||$_GET['subact']=="neighbors") {
if(!isset($_GET['upc'])||!is_numeric($_GET['upc'])) { 
	$_GET['upc'] = null; $_GET['subact'] = NULL; }
preg_match("/^(\d{7})/", $_GET['upc'], $fix_matches); 
$findprefix = $fix_matches[1];
if($deep_sub_act===null||$deep_sub_act=="upc") {
$findupc = sqlite3_query($slite3, "SELECT COUNT(*) AS COUNT FROM \"".$table_prefix."items\" WHERE \"upc\" LIKE '".$findprefix."%' ORDER BY \"upc\" ASC;"); }
if($deep_sub_act=="id") {
$findupc = sqlite3_query($slite3, "SELECT COUNT(*) AS COUNT FROM \"".$table_prefix."items\" WHERE \"upc\" LIKE '".$findprefix."%' ORDER BY \"id\" ASC;"); }
if($deep_sub_act=="lastupdate") {
$findupc = sqlite3_query($slite3, "SELECT COUNT(*) AS COUNT FROM \"".$table_prefix."items\" WHERE \"upc\" LIKE '".$findprefix."%' ORDER BY \"lastupdate\" DESC;"); }
$numupc = sql_fetch_assoc($findupc);
$numrows = $numupc['COUNT'];
if($numrows>0) {
if($deep_sub_act===null||$deep_sub_act=="upc") {
$dumpupc = sqlite3_query($slite3, "SELECT * FROM \"".$table_prefix."items\" WHERE \"upc\" LIKE '".$findprefix."%' ORDER BY \"upc\" ASC;"); }
if($deep_sub_act=="id") {
$dumpupc = sqlite3_query($slite3, "SELECT * FROM \"".$table_prefix."items\" WHERE \"upc\" LIKE '".$findprefix."%' ORDER BY \"id\" ASC;"); } 
if($deep_sub_act=="latest") {
$dumpupc = sqlite3_query($slite3, "SELECT * FROM \"".$table_prefix."items\" WHERE \"upc\" LIKE '".$findprefix."%' ORDER BY \"lastupdate\" DESC;"); } } }
if($_GET['subact']=="search"&&!isset($_GET['searchterms'])) {
	$_GET['upc'] = null; $_GET['subact'] = NULL; }
if($_GET['subact']=="search"&&isset($_GET['searchterms'])) {
$_GET['searchterms'] = trim($_GET['searchterms']);
$_GET['searchterms'] = remove_spaces($_GET['searchterms']); }
if((strlen($_GET['searchterms'])>100||strlen($_GET['searchterms'])<=3)&&
	$_GET['subact']=="search") {
	$_GET['upc'] = null; $_GET['subact'] = NULL; }
if($_GET['subact']=="search"&&isset($_GET['searchterms'])) {
if($deep_sub_act===null||$deep_sub_act=="upc") {
$findupc = sqlite3_query($slite3, "SELECT COUNT(*) AS COUNT FROM \"".$table_prefix."items\" WHERE \"description\" LIKE '%".sqlite3_escape_string($slite3, $_GET['searchterms'])."%' ORDER BY \"upc\" ASC;"); }
if($deep_sub_act=="id") {
$findupc = sqlite3_query($slite3, "SELECT COUNT(*) AS COUNT FROM \"".$table_prefix."items\" WHERE \"description\" LIKE '%".sqlite3_escape_string($slite3, $_GET['searchterms'])."%' ORDER BY \"id\" ASC;"); }
if($deep_sub_act=="latest") {
$findupc = sqlite3_query($slite3, "SELECT COUNT(*) AS COUNT FROM \"".$table_prefix."items\" WHERE \"description\" LIKE '%".sqlite3_escape_string($slite3, $_GET['searchterms'])."%' ORDER BY \"lastupdate\" DESC;"); }
$numupc = sql_fetch_assoc($findupc);
$numrows = $numupc['COUNT'];
if($numrows>0) {
if($deep_sub_act===null||$deep_sub_act=="upc") {
$dumpupc = sqlite3_query($slite3, "SELECT * FROM \"".$table_prefix."items\" WHERE \"description\" LIKE '%".sqlite3_escape_string($slite3, $_GET['searchterms'])."%' ORDER BY \"upc\" ASC;"); }
if($deep_sub_act=="id") {
$dumpupc = sqlite3_query($slite3, "SELECT * FROM \"".$table_prefix."items\" WHERE \"description\" LIKE '%".sqlite3_escape_string($slite3, $_GET['searchterms'])."%' ORDER BY \"id\" ASC;"); }
if($deep_sub_act=="latest") {
$dumpupc = sqlite3_query($slite3, "SELECT * FROM \"".$table_prefix."items\" WHERE \"description\" LIKE '%".sqlite3_escape_string($slite3, $_GET['searchterms'])."%' ORDER BY \"lastupdate\" DESC;"); } } }
if($_GET['subact']=="lookup") {
if(!isset($_GET['upc'])||!is_numeric($_GET['upc'])) { 
	$_GET['upc'] = null; $_GET['subact'] = NULL; }
$findupc = sqlite3_query($slite3, "SELECT COUNT(*) AS COUNT FROM \"".$table_prefix."items\" WHERE \"upc\"='".$_GET['upc']."';"); 
$numupc = sql_fetch_assoc($findupc);
$numrows = $numupc['COUNT'];
if($numrows>0) {
$dumpupc = sqlite3_query($slite3, "SELECT * FROM \"".$table_prefix."items\" WHERE \"upc\"='".$_GET['upc']."' ORDER BY \"upc\" ASC;"); } }
if($_GET['subact']==NULL||$_GET['subact']=="upc") {
$findupc = sqlite3_query($slite3, "SELECT COUNT(*) AS COUNT FROM \"".$table_prefix."items\" ORDER BY \"upc\" ASC;"); 
$numupc = sql_fetch_assoc($findupc);
$numrows = $numupc['COUNT'];
$dumpupc = sqlite3_query($slite3, "SELECT * FROM \"".$table_prefix."items\" ORDER BY \"upc\" ASC;"); } 
if($_GET['subact']=="id") {
$findupc = sqlite3_query($slite3, "SELECT COUNT(*) AS COUNT FROM \"".$table_prefix."items\" ORDER BY \"id\" ASC;"); 
$numupc = sql_fetch_assoc($findupc);
$numrows = $numupc['COUNT'];
$dumpupc = sqlite3_query($slite3, "SELECT * FROM \"".$table_prefix."items\" ORDER BY \"id\" ASC;"); } 
if($_GET['subact']=="latest") {
$findupc = sqlite3_query($slite3, "SELECT COUNT(*) AS COUNT FROM \"".$table_prefix."items\" ORDER BY \"lastupdate\" DESC;"); 
$numupc = sql_fetch_assoc($findupc);
$numrows = $numupc['COUNT'];
$dumpupc = sqlite3_query($slite3, "SELECT * FROM \"".$table_prefix."items\" ORDER BY \"lastupdate\" DESC;"); } 
if($dumpupc!=NULL) {
while ($upcinfo = sql_fetch_assoc($dumpupc)) {
$upcinfo['description'] = str_replace("\"", "\"\"", $upcinfo['description']);
$upcinfo['sizeweight'] = str_replace("\"", "\"\"", $upcinfo['sizeweight']);
if($add_quantity_row===true) {
$upcinfo['quantity'] = str_replace("\"", "\"\"", $upcinfo['quantity']); }
?>
"<?php echo $upcinfo['upc']; ?>", "<?php echo $upcinfo['description']; ?>", "<?php echo $upcinfo['sizeweight']; ?>"<?php if($add_quantity_row===true) { ?>, "<?php echo $upcinfo['quantity']; ?>"<?php } ?>
<?php } } } if($_GET['act']=="xml"||$_GET['act']=="dumpxml") { 
$deep_sub_act = null;
if(isset($_GET['deepsubact'])) { $deep_sub_act = $_GET['deepsubact']; }
if(isset($_GET['subact'])&&preg_match("/([a-z]+),([a-z]+)/", $_GET['subact'], $subact_part)) {
	$_GET['subact'] = $subact_part[1]; $deep_sub_act = $subact_part[2]; }
if($_GET['subact']=="random"||$_GET['subact']=="rand") {
$findupc = sqlite3_query($slite3, "SELECT * FROM \"".$table_prefix."items\" ORDER BY RANDOM() LIMIT 1;"); 
$upcinfo = sql_fetch_assoc($findupc); $_GET['upc'] = $upcinfo['upc']; $_GET['subact'] = "lookup"; }
@header("Content-Type: text/xml; charset=UTF-8"); 
echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
echo "<?xml-stylesheet type=\"text/xsl\" href=\"".$website_url.$url_file."?act=xslt\"?>\n";
?>
<!DOCTYPE <?php echo $sqlitedatabase; ?> [
<!ELEMENT <?php echo $sqlitedatabase; ?> (item*)>
<!ELEMENT item (upc,description,sizeweight)>
<!ELEMENT upc (#PCDATA)>
<!ELEMENT description (#PCDATA)>
<!ELEMENT sizeweight (#PCDATA)>
]>

<<?php echo $sqlitedatabase; ?>>

<?php
if($_GET['subact']=="neighbor"||$_GET['subact']=="neighbors") {
if(!isset($_GET['upc'])||!is_numeric($_GET['upc'])) { 
	$_GET['upc'] = null; $_GET['subact'] = NULL; }
preg_match("/^(\d{7})/", $_GET['upc'], $fix_matches); 
$findprefix = $fix_matches[1];
if($deep_sub_act===null||$deep_sub_act=="upc") {
$findupc = sqlite3_query($slite3, "SELECT COUNT(*) AS COUNT FROM \"".$table_prefix."items\" WHERE \"upc\" LIKE '".$findprefix."%' ORDER BY \"upc\" ASC;"); }
if($deep_sub_act=="id") {
$findupc = sqlite3_query($slite3, "SELECT COUNT(*) AS COUNT FROM \"".$table_prefix."items\" WHERE \"upc\" LIKE '".$findprefix."%' ORDER BY \"id\" ASC;"); }
if($deep_sub_act=="latest") {
$findupc = sqlite3_query($slite3, "SELECT COUNT(*) AS COUNT FROM \"".$table_prefix."items\" WHERE \"upc\" LIKE '".$findprefix."%' ORDER BY \"lastupdate\" DESC;"); }
$numupc = sql_fetch_assoc($findupc);
$numrows = $numupc['COUNT'];
if($numrows>0) {
if($deep_sub_act===null||$deep_sub_act=="upc") {
$dumpupc = sqlite3_query($slite3, "SELECT * FROM \"".$table_prefix."items\" WHERE \"upc\" LIKE '".$findprefix."%' ORDER BY \"upc\" ASC;"); }
if($deep_sub_act=="id") {
$dumpupc = sqlite3_query($slite3, "SELECT * FROM \"".$table_prefix."items\" WHERE \"upc\" LIKE '".$findprefix."%' ORDER BY \"upc\" ASC;"); }
if($deep_sub_act=="latest") {
$dumpupc = sqlite3_query($slite3, "SELECT * FROM \"".$table_prefix."items\" WHERE \"upc\" LIKE '".$findprefix."%' ORDER BY \"lastupdate\" DESC;"); } } }
if($_GET['subact']=="search"&&!isset($_GET['searchterms'])) {
	$_GET['upc'] = null; $_GET['subact'] = NULL; }
if($_GET['subact']=="search"&&isset($_GET['searchterms'])) {
$_GET['searchterms'] = trim($_GET['searchterms']);
$_GET['searchterms'] = remove_spaces($_GET['searchterms']); }
if((strlen($_GET['searchterms'])>100||strlen($_GET['searchterms'])<=3)&&
	$_GET['subact']=="search") {
	$_GET['upc'] = null; $_GET['subact'] = NULL; }
if($_GET['subact']=="search"&&isset($_GET['searchterms'])) {
if($deep_sub_act===null||$deep_sub_act=="upc") {
$findupc = sqlite3_query($slite3, "SELECT COUNT(*) AS COUNT FROM \"".$table_prefix."items\" WHERE \"description\" LIKE '%".sqlite3_escape_string($slite3, $_GET['searchterms'])."%' ORDER BY \"upc\" ASC;"); }
if($deep_sub_act=="id") {
$findupc = sqlite3_query($slite3, "SELECT COUNT(*) AS COUNT FROM \"".$table_prefix."items\" WHERE \"description\" LIKE '%".sqlite3_escape_string($slite3, $_GET['searchterms'])."%' ORDER BY \"id\" ASC;"); }
if($deep_sub_act=="latest") {
$findupc = sqlite3_query($slite3, "SELECT COUNT(*) AS COUNT FROM \"".$table_prefix."items\" WHERE \"description\" LIKE '%".sqlite3_escape_string($slite3, $_GET['searchterms'])."%' ORDER BY \"lastupdate\" DESC;"); }
$numupc = sql_fetch_assoc($findupc);
$numrows = $numupc['COUNT'];
if($numrows>0) {
if($deep_sub_act===null||$deep_sub_act=="upc") {
$dumpupc = sqlite3_query($slite3, "SELECT * FROM \"".$table_prefix."items\" WHERE \"description\" LIKE '%".sqlite3_escape_string($slite3, $_GET['searchterms'])."%' ORDER BY \"upc\" ASC;"); }
if($deep_sub_act=="id") {
$dumpupc = sqlite3_query($slite3, "SELECT * FROM \"".$table_prefix."items\" WHERE \"description\" LIKE '%".sqlite3_escape_string($slite3, $_GET['searchterms'])."%' ORDER BY \"id\" ASC;"); }
if($deep_sub_act=="latest") {
$dumpupc = sqlite3_query($slite3, "SELECT * FROM \"".$table_prefix."items\" WHERE \"description\" LIKE '%".sqlite3_escape_string($slite3, $_GET['searchterms'])."%' ORDER BY \"lastupdate\" DESC;"); } } }
if($_GET['subact']=="lookup") {
if(!isset($_GET['upc'])||!is_numeric($_GET['upc'])) { 
	$_GET['upc'] = null; $_GET['subact'] = NULL; }
$findupc = sqlite3_query($slite3, "SELECT COUNT(*) AS COUNT FROM \"".$table_prefix."items\" WHERE \"upc\"='".$_GET['upc']."';"); 
$numupc = sql_fetch_assoc($findupc);
$numrows = $numupc['COUNT'];
if($numrows>0) {
$dumpupc = sqlite3_query($slite3, "SELECT * FROM \"".$table_prefix."items\" WHERE \"upc\"='".$_GET['upc']."' ORDER BY \"upc\" ASC;"); } }
if($_GET['subact']==NULL||$_GET['subact']=="upc") {
$findupc = sqlite3_query($slite3, "SELECT COUNT(*) AS COUNT FROM \"".$table_prefix."items\" ORDER BY \"upc\" ASC;"); 
$numupc = sql_fetch_assoc($findupc);
$numrows = $numupc['COUNT'];
$dumpupc = sqlite3_query($slite3, "SELECT * FROM \"".$table_prefix."items\" ORDER BY \"upc\" ASC;"); } 
if($_GET['subact']=="id") {
$findupc = sqlite3_query($slite3, "SELECT COUNT(*) AS COUNT FROM \"".$table_prefix."items\" ORDER BY \"id\" ASC;"); 
$numupc = sql_fetch_assoc($findupc);
$numrows = $numupc['COUNT'];
$dumpupc = sqlite3_query($slite3, "SELECT * FROM \"".$table_prefix."items\" ORDER BY \"id\" ASC;"); } 
if($_GET['subact']=="latest") {
$findupc = sqlite3_query($slite3, "SELECT COUNT(*) AS COUNT FROM \"".$table_prefix."items\" ORDER BY \"lastupdate\" DESC;"); 
$numupc = sql_fetch_assoc($findupc);
$numrows = $numupc['COUNT'];
$dumpupc = sqlite3_query($slite3, "SELECT * FROM \"".$table_prefix."items\" ORDER BY \"lastupdate\" DESC;"); } 
if($dumpupc==NULL) {
echo "<item>\n</item>\n\n"; }
if($dumpupc!=NULL) {
while ($upcinfo = sql_fetch_assoc($dumpupc)) {
$upcinfo['description'] = str_replace("\"", "\\\"", $upcinfo['description']);
$upcinfo['sizeweight'] = str_replace("\"", "\\\"", $upcinfo['sizeweight']);
if($add_quantity_row===true) {
$upcinfo['quantity'] = str_replace("\"", "\\\"", $upcinfo['quantity']); }
?>
<item>
<upc><?php echo $upcinfo['upc']; ?></upc>
<description><?php echo htmlspecialchars($upcinfo['description'], ENT_XML1, "UTF-8"); ?></description>
<sizeweight><?php echo htmlspecialchars($upcinfo['sizeweight'], ENT_XML1, "UTF-8"); ?></sizeweight>
<?php if($add_quantity_row===true) { ?><sizeweight><?php echo htmlspecialchars($upcinfo['quantity'], ENT_XML1, "UTF-8"); ?></sizeweight><?php } ?>
</item>

<?php } } ?>
</<?php echo $sqlitedatabase; ?>>
<?php } if($_GET['act']=="yaml"||$_GET['act']=="dumpyaml"||
		   $_GET['act']=="yml"||$_GET['act']=="dumpyml") { 
$deep_sub_act = null;
if(isset($_GET['deepsubact'])) { $deep_sub_act = $_GET['deepsubact']; }
if(isset($_GET['subact'])&&preg_match("/([a-z]+),([a-z]+)/", $_GET['subact'], $subact_part)) {
	$_GET['subact'] = $subact_part[1]; $deep_sub_act = $subact_part[2]; }
if($_GET['subact']=="random"||$_GET['subact']=="rand") {
$findupc = sqlite3_query($slite3, "SELECT * FROM \"".$table_prefix."items\" ORDER BY RANDOM() LIMIT 1;"); 
$upcinfo = sql_fetch_assoc($findupc); $_GET['upc'] = $upcinfo['upc']; $_GET['subact'] = "lookup"; }
@header("Content-Type: text/x-yaml; charset=UTF-8"); 
@header("Content-Disposition: attachment; filename=\"".$sqlitedatabase.".yaml\"");
?>
item: 
<?php
if($_GET['subact']=="neighbor"||$_GET['subact']=="neighbors") {
if(!isset($_GET['upc'])||!is_numeric($_GET['upc'])) { 
	$_GET['upc'] = null; $_GET['subact'] = NULL; }
preg_match("/^(\d{7})/", $_GET['upc'], $fix_matches); 
$findprefix = $fix_matches[1];
if($deep_sub_act===null||$deep_sub_act=="upc") {
$findupc = sqlite3_query($slite3, "SELECT COUNT(*) AS COUNT FROM \"".$table_prefix."items\" WHERE \"upc\" LIKE '".$findprefix."%' ORDER BY \"upc\" ASC;"); }
if($deep_sub_act=="id") {
$findupc = sqlite3_query($slite3, "SELECT COUNT(*) AS COUNT FROM \"".$table_prefix."items\" WHERE \"upc\" LIKE '".$findprefix."%' ORDER BY \"id\" ASC;"); }
if($deep_sub_act=="latest") {
$findupc = sqlite3_query($slite3, "SELECT COUNT(*) AS COUNT FROM \"".$table_prefix."items\" WHERE \"upc\" LIKE '".$findprefix."%' ORDER BY \"lastupdate\" DESC;"); }
$numupc = sql_fetch_assoc($findupc);
$numrows = $numupc['COUNT'];
if($numrows>0) {
if($deep_sub_act===null||$deep_sub_act=="upc") {
$dumpupc = sqlite3_query($slite3, "SELECT * FROM \"".$table_prefix."items\" WHERE \"upc\" LIKE '".$findprefix."%' ORDER BY \"upc\" ASC;"); }
if($deep_sub_act=="id") {
$dumpupc = sqlite3_query($slite3, "SELECT * FROM \"".$table_prefix."items\" WHERE \"upc\" LIKE '".$findprefix."%' ORDER BY \"id\" ASC;"); }
if($deep_sub_act=="latest") {
$dumpupc = sqlite3_query($slite3, "SELECT * FROM \"".$table_prefix."items\" WHERE \"upc\" LIKE '".$findprefix."%' ORDER BY \"lastupdate\" DESC;"); } } }
if($_GET['subact']=="search"&&!isset($_GET['searchterms'])) {
	$_GET['upc'] = null; $_GET['subact'] = NULL; }
if($_GET['subact']=="search"&&isset($_GET['searchterms'])) {
$_GET['searchterms'] = trim($_GET['searchterms']);
$_GET['searchterms'] = remove_spaces($_GET['searchterms']); }
if((strlen($_GET['searchterms'])>100||strlen($_GET['searchterms'])<=3)&&
	$_GET['subact']=="search") {
	$_GET['upc'] = null; $_GET['subact'] = NULL; }
if($_GET['subact']=="search"&&isset($_GET['searchterms'])) {
if($deep_sub_act===null||$deep_sub_act=="upc") {
$findupc = sqlite3_query($slite3, "SELECT COUNT(*) AS COUNT FROM \"".$table_prefix."items\" WHERE \"description\" LIKE '%".sqlite3_escape_string($slite3, $_GET['searchterms'])."%' ORDER BY \"upc\" ASC;"); }
if($deep_sub_act=="id") {
$findupc = sqlite3_query($slite3, "SELECT COUNT(*) AS COUNT FROM \"".$table_prefix."items\" WHERE \"description\" LIKE '%".sqlite3_escape_string($slite3, $_GET['searchterms'])."%' ORDER BY \"id\" ASC;"); }
if($deep_sub_act=="latest") {
$findupc = sqlite3_query($slite3, "SELECT COUNT(*) AS COUNT FROM \"".$table_prefix."items\" WHERE \"description\" LIKE '%".sqlite3_escape_string($slite3, $_GET['searchterms'])."%' ORDER BY \"lastupdate\" DESC;"); }
$numupc = sql_fetch_assoc($findupc);
$numrows = $numupc['COUNT'];
if($numrows>0) {
if($deep_sub_act===null||$deep_sub_act=="upc") {
$dumpupc = sqlite3_query($slite3, "SELECT * FROM \"".$table_prefix."items\" WHERE \"description\" LIKE '%".sqlite3_escape_string($slite3, $_GET['searchterms'])."%' ORDER BY \"upc\" ASC;"); }
if($deep_sub_act=="id") {
$dumpupc = sqlite3_query($slite3, "SELECT * FROM \"".$table_prefix."items\" WHERE \"description\" LIKE '%".sqlite3_escape_string($slite3, $_GET['searchterms'])."%' ORDER BY \"id\" ASC;"); } 
if($deep_sub_act=="latest") {
$dumpupc = sqlite3_query($slite3, "SELECT * FROM \"".$table_prefix."items\" WHERE \"description\" LIKE '%".sqlite3_escape_string($slite3, $_GET['searchterms'])."%' ORDER BY \"lastupdate\" DESC;"); } } }
if($_GET['subact']=="lookup") {
if(!isset($_GET['upc'])||!is_numeric($_GET['upc'])) { 
	$_GET['upc'] = null; $_GET['subact'] = NULL; }
$findupc = sqlite3_query($slite3, "SELECT COUNT(*) AS COUNT FROM \"".$table_prefix."items\" WHERE \"upc\"='".$_GET['upc']."';"); 
$numupc = sql_fetch_assoc($findupc);
$numrows = $numupc['COUNT'];
if($numrows>0) {
$dumpupc = sqlite3_query($slite3, "SELECT * FROM \"".$table_prefix."items\" WHERE \"upc\"='".$_GET['upc']."' ORDER BY \"upc\" ASC;"); } }
if($_GET['subact']==NULL||$_GET['subact']=="upc") {
$findupc = sqlite3_query($slite3, "SELECT COUNT(*) AS COUNT FROM \"".$table_prefix."items\" ORDER BY \"upc\" ASC;"); 
$numupc = sql_fetch_assoc($findupc);
$numrows = $numupc['COUNT'];
$dumpupc = sqlite3_query($slite3, "SELECT * FROM \"".$table_prefix."items\" ORDER BY \"upc\" ASC;"); } 
if($_GET['subact']=="id") {
$findupc = sqlite3_query($slite3, "SELECT COUNT(*) AS COUNT FROM \"".$table_prefix."items\" ORDER BY \"id\" ASC;"); 
$numupc = sql_fetch_assoc($findupc);
$numrows = $numupc['COUNT'];
$dumpupc = sqlite3_query($slite3, "SELECT * FROM \"".$table_prefix."items\" ORDER BY \"id\" ASC;"); } 
if($_GET['subact']=="latest") {
$findupc = sqlite3_query($slite3, "SELECT COUNT(*) AS COUNT FROM \"".$table_prefix."items\" ORDER BY \"lastupdate\" DESC;"); 
$numupc = sql_fetch_assoc($findupc);
$numrows = $numupc['COUNT'];
$dumpupc = sqlite3_query($slite3, "SELECT * FROM \"".$table_prefix."items\" ORDER BY \"lastupdate\" DESC;"); } 
if($dumpupc!=NULL) {
while ($upcinfo = sql_fetch_assoc($dumpupc)) {
/*$upcinfo['description'] = str_replace("\"", "\"\"", $upcinfo['description']);
$upcinfo['sizeweight'] = str_replace("\"", "\"\"", $upcinfo['sizeweight']);
if($add_quantity_row===true) {
$upcinfo['quantity'] = str_replace("\"", "\"\"", $upcinfo['quantity']); } */
?>
   - upc:           <?php echo $upcinfo['upc']."\n"; ?>
     description:   <?php echo $upcinfo['description']."\n"; ?>
     sizeweight:    <?php echo $upcinfo['sizeweight']."\n"; ?>
<?php if($add_quantity_row===true) { ?>     quantity:      <?php echo $upcinfo['quantity']."\n"; } ?>

<?php } } } if($_GET['act']=="json"||$_GET['act']=="dumpjson") { 
$deep_sub_act = null;
if(isset($_GET['deepsubact'])) { $deep_sub_act = $_GET['deepsubact']; }
if(isset($_GET['subact'])&&preg_match("/([a-z]+),([a-z]+)/", $_GET['subact'], $subact_part)) {
	$_GET['subact'] = $subact_part[1]; $deep_sub_act = $subact_part[2]; }
if($_GET['subact']=="random"||$_GET['subact']=="rand") {
$findupc = sqlite3_query($slite3, "SELECT * FROM \"".$table_prefix."items\" ORDER BY RANDOM() LIMIT 1;"); 
$upcinfo = sql_fetch_assoc($findupc); $_GET['upc'] = $upcinfo['upc']; $_GET['subact'] = "lookup"; }
@header("Content-Type: application/json; charset=UTF-8"); 
?>
{
  "item": [
<?php
if($_GET['subact']=="neighbor"||$_GET['subact']=="neighbors") {
if(!isset($_GET['upc'])||!is_numeric($_GET['upc'])) { 
	$_GET['upc'] = null; $_GET['subact'] = NULL; }
preg_match("/^(\d{7})/", $_GET['upc'], $fix_matches); 
$findprefix = $fix_matches[1];
if($deep_sub_act===null||$deep_sub_act=="upc") {
$findupc = sqlite3_query($slite3, "SELECT COUNT(*) AS COUNT FROM \"".$table_prefix."items\" WHERE \"upc\" LIKE '".$findprefix."%' ORDER BY \"upc\" ASC;"); }
if($deep_sub_act=="id") {
$findupc = sqlite3_query($slite3, "SELECT COUNT(*) AS COUNT FROM \"".$table_prefix."items\" WHERE \"upc\" LIKE '".$findprefix."%' ORDER BY \"id\" ASC;"); }
if($deep_sub_act=="latest") {
$findupc = sqlite3_query($slite3, "SELECT COUNT(*) AS COUNT FROM \"".$table_prefix."items\" WHERE \"upc\" LIKE '".$findprefix."%' ORDER BY \"lastupdate\" DESC;"); }
$numupc = sql_fetch_assoc($findupc);
$numrows = $numupc['COUNT'];
if($numrows>0) {
if($deep_sub_act===null||$deep_sub_act=="upc") {
$dumpupc = sqlite3_query($slite3, "SELECT * FROM \"".$table_prefix."items\" WHERE \"upc\" LIKE '".$findprefix."%' ORDER BY \"upc\" ASC;"); }
if($deep_sub_act=="id") {
$dumpupc = sqlite3_query($slite3, "SELECT * FROM \"".$table_prefix."items\" WHERE \"upc\" LIKE '".$findprefix."%' ORDER BY \"id\" ASC;"); } 
if($deep_sub_act=="latest") {
$dumpupc = sqlite3_query($slite3, "SELECT * FROM \"".$table_prefix."items\" WHERE \"upc\" LIKE '".$findprefix."%' ORDER BY \"lastupdate\" DESC;"); } } }
if($_GET['subact']=="search"&&!isset($_GET['searchterms'])) {
	$_GET['upc'] = null; $_GET['subact'] = NULL; }
if($_GET['subact']=="search"&&isset($_GET['searchterms'])) {
$_GET['searchterms'] = trim($_GET['searchterms']);
$_GET['searchterms'] = remove_spaces($_GET['searchterms']); }
if((strlen($_GET['searchterms'])>100||strlen($_GET['searchterms'])<=3)&&
	$_GET['subact']=="search") {
	$_GET['upc'] = null; $_GET['subact'] = NULL; }
if($_GET['subact']=="search"&&isset($_GET['searchterms'])) {
if($deep_sub_act===null||$deep_sub_act=="upc") {
$findupc = sqlite3_query($slite3, "SELECT COUNT(*) AS COUNT FROM \"".$table_prefix."items\" WHERE \"description\" LIKE '%".sqlite3_escape_string($slite3, $_GET['searchterms'])."%' ORDER BY \"upc\" ASC;"); } 
if($deep_sub_act=="id") {
$findupc = sqlite3_query($slite3, "SELECT COUNT(*) AS COUNT FROM \"".$table_prefix."items\" WHERE \"description\" LIKE '%".sqlite3_escape_string($slite3, $_GET['searchterms'])."%' ORDER BY \"id\" ASC;"); }
if($deep_sub_act=="latest") {
$findupc = sqlite3_query($slite3, "SELECT COUNT(*) AS COUNT FROM \"".$table_prefix."items\" WHERE \"description\" LIKE '%".sqlite3_escape_string($slite3, $_GET['searchterms'])."%' ORDER BY \"lastupdate\" DESC;"); }
$numupc = sql_fetch_assoc($findupc);
$numrows = $numupc['COUNT'];
if($numrows>0) {
if($deep_sub_act===null||$deep_sub_act=="upc") {
$dumpupc = sqlite3_query($slite3, "SELECT * FROM \"".$table_prefix."items\" WHERE \"description\" LIKE '%".sqlite3_escape_string($slite3, $_GET['searchterms'])."%' ORDER BY \"upc\" ASC;"); }
if($deep_sub_act=="id") {
$dumpupc = sqlite3_query($slite3, "SELECT * FROM \"".$table_prefix."items\" WHERE \"description\" LIKE '%".sqlite3_escape_string($slite3, $_GET['searchterms'])."%' ORDER BY \"id\" ASC;"); } 
if($deep_sub_act=="latest") {
$dumpupc = sqlite3_query($slite3, "SELECT * FROM \"".$table_prefix."items\" WHERE \"description\" LIKE '%".sqlite3_escape_string($slite3, $_GET['searchterms'])."%' ORDER BY \"lastupdate\" DESC;"); } } }
if($_GET['subact']=="lookup") {
if(!isset($_GET['upc'])||!is_numeric($_GET['upc'])) { 
	$_GET['upc'] = null; $_GET['subact'] = NULL; }
$findupc = sqlite3_query($slite3, "SELECT COUNT(*) AS COUNT FROM \"".$table_prefix."items\" WHERE \"upc\"='".$_GET['upc']."';"); 
$numupc = sql_fetch_assoc($findupc);
$numrows = $numupc['COUNT'];
if($numrows>0) {
$dumpupc = sqlite3_query($slite3, "SELECT * FROM \"".$table_prefix."items\" WHERE \"upc\"='".$_GET['upc']."' ORDER BY \"upc\" ASC;"); } }
if($_GET['subact']==NULL||$_GET['subact']=="upc") {
$findupc = sqlite3_query($slite3, "SELECT COUNT(*) AS COUNT FROM \"".$table_prefix."items\" ORDER BY \"upc\" ASC;"); 
$numupc = sql_fetch_assoc($findupc);
$numrows = $numupc['COUNT'];
$dumpupc = sqlite3_query($slite3, "SELECT * FROM \"".$table_prefix."items\" ORDER BY \"upc\" ASC;"); } 
if($_GET['subact']=="id") {
$findupc = sqlite3_query($slite3, "SELECT COUNT(*) AS COUNT FROM \"".$table_prefix."items\" ORDER BY \"id\" ASC;"); 
$numupc = sql_fetch_assoc($findupc);
$numrows = $numupc['COUNT'];
$dumpupc = sqlite3_query($slite3, "SELECT * FROM \"".$table_prefix."items\" ORDER BY \"id\" ASC;"); } 
if($_GET['subact']=="latest") {
$findupc = sqlite3_query($slite3, "SELECT COUNT(*) AS COUNT FROM \"".$table_prefix."items\" ORDER BY \"lastupdate\" DESC;"); 
$numupc = sql_fetch_assoc($findupc);
$numrows = $numupc['COUNT'];
$dumpupc = sqlite3_query($slite3, "SELECT * FROM \"".$table_prefix."items\" ORDER BY \"lastupdate\" DESC;"); } 
if($dumpupc!=NULL) { $numcount = 1;
while ($upcinfo = sql_fetch_assoc($dumpupc)) {
$upcinfo['description'] = str_replace("\"", "\\\"", $upcinfo['description']);
$upcinfo['sizeweight'] = str_replace("\"", "\\\"", $upcinfo['sizeweight']);
if($add_quantity_row===true) {
$upcinfo['quantity'] = str_replace("\"", "\\\"", $upcinfo['quantity']); }
echo "    {\n";
echo "      \"upc\": \"".$upcinfo['upc']."\",\n";
echo "      \"description\": \"".$upcinfo['description']."\",\n";
echo "      \"sizeweight\": \"".$upcinfo['sizeweight']."\"\n";
if($add_quantity_row===true) { echo "      \"quantity\": \"".$upcinfo['quantity']."\"\n"; }
if($numcount<$numrows) { echo "    },\n"; }
if($numcount==$numrows) { echo "    }\n"; }
++$numcount; } ?>
  ]
}
<?php } } if($_GET['act']=="serialize"||$_GET['act']=="dumpserialize") { 
$deep_sub_act = null;
if(isset($_GET['deepsubact'])) { $deep_sub_act = $_GET['deepsubact']; }
if(isset($_GET['subact'])&&preg_match("/([a-z]+),([a-z]+)/", $_GET['subact'], $subact_part)) {
	$_GET['subact'] = $subact_part[1]; $deep_sub_act = $subact_part[2]; }
if($_GET['subact']=="random"||$_GET['subact']=="rand") {
$findupc = sqlite3_query($slite3, "SELECT * FROM \"".$table_prefix."items\" ORDER BY RANDOM() LIMIT 1;"); 
$upcinfo = sql_fetch_assoc($findupc); $_GET['upc'] = $upcinfo['upc']; $_GET['subact'] = "lookup"; }
@header("Content-Type: text/plain; charset=UTF-8"); 
if($_GET['subact']=="neighbor"||$_GET['subact']=="neighbors") {
if(!isset($_GET['upc'])||!is_numeric($_GET['upc'])) { 
	$_GET['upc'] = null; $_GET['subact'] = NULL; }
preg_match("/^(\d{7})/", $_GET['upc'], $fix_matches); 
$findprefix = $fix_matches[1];
if($deep_sub_act===null||$deep_sub_act=="upc") {
$findupc = sqlite3_query($slite3, "SELECT COUNT(*) AS COUNT FROM \"".$table_prefix."items\" WHERE \"upc\" LIKE '".$findprefix."%' ORDER BY \"upc\" ASC;"); }
if($deep_sub_act=="id") {
$findupc = sqlite3_query($slite3, "SELECT COUNT(*) AS COUNT FROM \"".$table_prefix."items\" WHERE \"upc\" LIKE '".$findprefix."%' ORDER BY \"id\" ASC;"); }
if($deep_sub_act=="latest") {
$findupc = sqlite3_query($slite3, "SELECT COUNT(*) AS COUNT FROM \"".$table_prefix."items\" WHERE \"upc\" LIKE '".$findprefix."%' ORDER BY \"lastupdate\" DESC;"); }
$numupc = sql_fetch_assoc($findupc);
$numrows = $numupc['COUNT'];
if($numrows>0) {
if($deep_sub_act===null||$deep_sub_act=="upc") {
$dumpupc = sqlite3_query($slite3, "SELECT * FROM \"".$table_prefix."items\" WHERE \"upc\" LIKE '".$findprefix."%' ORDER BY \"upc\" ASC;"); }
if($deep_sub_act=="id") {
$dumpupc = sqlite3_query($slite3, "SELECT * FROM \"".$table_prefix."items\" WHERE \"upc\" LIKE '".$findprefix."%' ORDER BY \"id\" ASC;"); } 
if($deep_sub_act=="latest") {
$dumpupc = sqlite3_query($slite3, "SELECT * FROM \"".$table_prefix."items\" WHERE \"upc\" LIKE '".$findprefix."%' ORDER BY \"lastupdate\" DESC;"); } } }
if($_GET['subact']=="search"&&!isset($_GET['searchterms'])) {
	$_GET['upc'] = null; $_GET['subact'] = NULL; }
if($_GET['subact']=="search"&&isset($_GET['searchterms'])) {
$_GET['searchterms'] = trim($_GET['searchterms']);
$_GET['searchterms'] = remove_spaces($_GET['searchterms']); }
if((strlen($_GET['searchterms'])>100||strlen($_GET['searchterms'])<=3)&&
	$_GET['subact']=="search") {
	$_GET['upc'] = null; $_GET['subact'] = NULL; }
if($_GET['subact']=="search"&&isset($_GET['searchterms'])) {
if($deep_sub_act===null||$deep_sub_act=="upc") {
$findupc = sqlite3_query($slite3, "SELECT COUNT(*) AS COUNT FROM \"".$table_prefix."items\" WHERE \"description\" LIKE '%".sqlite3_escape_string($slite3, $_GET['searchterms'])."%' ORDER BY \"upc\" ASC;"); }
if($deep_sub_act=="id") {
$findupc = sqlite3_query($slite3, "SELECT COUNT(*) AS COUNT FROM \"".$table_prefix."items\" WHERE \"description\" LIKE '%".sqlite3_escape_string($slite3, $_GET['searchterms'])."%' ORDER BY \"id\" ASC;"); }
if($deep_sub_act=="latest") {
$findupc = sqlite3_query($slite3, "SELECT COUNT(*) AS COUNT FROM \"".$table_prefix."items\" WHERE \"description\" LIKE '%".sqlite3_escape_string($slite3, $_GET['searchterms'])."%' ORDER BY \"lastupdate\" DESC;"); }
$numupc = sql_fetch_assoc($findupc);
$numrows = $numupc['COUNT'];
if($numrows>0) {
if($deep_sub_act===null||$deep_sub_act=="upc") {
$dumpupc = sqlite3_query($slite3, "SELECT * FROM \"".$table_prefix."items\" WHERE \"description\" LIKE '%".sqlite3_escape_string($slite3, $_GET['searchterms'])."%' ORDER BY \"upc\" ASC;"); }
if($deep_sub_act=="id") {
$dumpupc = sqlite3_query($slite3, "SELECT * FROM \"".$table_prefix."items\" WHERE \"description\" LIKE '%".sqlite3_escape_string($slite3, $_GET['searchterms'])."%' ORDER BY \"id\" ASC;"); } 
if($deep_sub_act=="latest") {
$dumpupc = sqlite3_query($slite3, "SELECT * FROM \"".$table_prefix."items\" WHERE \"description\" LIKE '%".sqlite3_escape_string($slite3, $_GET['searchterms'])."%' ORDER BY \"lastupdate\" DESC;"); } } }
if($_GET['subact']=="lookup") {
if(!isset($_GET['upc'])||!is_numeric($_GET['upc'])) { 
	$_GET['upc'] = null; $_GET['subact'] = NULL; }
$findupc = sqlite3_query($slite3, "SELECT COUNT(*) AS COUNT FROM \"".$table_prefix."items\" WHERE \"upc\"='".$_GET['upc']."';"); 
$numupc = sql_fetch_assoc($findupc);
$numrows = $numupc['COUNT'];
if($numrows>0) {
$dumpupc = sqlite3_query($slite3, "SELECT * FROM \"".$table_prefix."items\" WHERE \"upc\"='".$_GET['upc']."' ORDER BY \"upc\" ASC;"); } }
if($_GET['subact']==NULL||$_GET['subact']=="upc") {
$findupc = sqlite3_query($slite3, "SELECT COUNT(*) AS COUNT FROM \"".$table_prefix."items\" ORDER BY \"upc\" ASC;"); 
$numupc = sql_fetch_assoc($findupc);
$numrows = $numupc['COUNT'];
$dumpupc = sqlite3_query($slite3, "SELECT * FROM \"".$table_prefix."items\" ORDER BY \"upc\" ASC;"); } 
if($_GET['subact']=="id") {
$findupc = sqlite3_query($slite3, "SELECT COUNT(*) AS COUNT FROM \"".$table_prefix."items\" ORDER BY \"id\" ASC;"); 
$numupc = sql_fetch_assoc($findupc);
$numrows = $numupc['COUNT'];
$dumpupc = sqlite3_query($slite3, "SELECT * FROM \"".$table_prefix."items\" ORDER BY \"id\" ASC;"); }
if($_GET['subact']=="latest") {
$findupc = sqlite3_query($slite3, "SELECT COUNT(*) AS COUNT FROM \"".$table_prefix."items\" ORDER BY \"lastupdate\" DESC;"); 
$numupc = sql_fetch_assoc($findupc);
$numrows = $numupc['COUNT'];
$dumpupc = sqlite3_query($slite3, "SELECT * FROM \"".$table_prefix."items\" ORDER BY \"lastupdate\" DESC;"); } 
if($dumpupc!=NULL) { 
$items = array();
$ari = 0;
while ($upcinfo = sql_fetch_assoc($dumpupc)) {
/*$upcinfo['description'] = str_replace("\"", "\\\"", $upcinfo['description']);
$upcinfo['sizeweight'] = str_replace("\"", "\\\"", $upcinfo['sizeweight']);
if($add_quantity_row===true) {
$upcinfo['quantity'] = str_replace("\"", "\\\"", $upcinfo['quantity']); }*/
$arkeys[$ari] = $upcinfo['upc'];
if($add_quantity_row===false) {
$arvalues[$ari] = array("upc" => $upcinfo['upc'], "description" => $upcinfo['description'], "sizeweight" => $upcinfo['sizeweight']); }
if($add_quantity_row===true) {
$arvalues[$ari] = array("upc" => $upcinfo['upc'], "description" => $upcinfo['description'], "sizeweight" => $upcinfo['sizeweight'], "quantity" => $upcinfo['quantity']); }
++$ari; }
$items = array_combine($arkeys, $arvalues);
$items = array_merge($items, $arvalues);
echo serialize($items); } } if($_GET['act']=="xslt") { 
@header("Content-Type: text/xml; charset=UTF-8"); 
echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:template match="/">
 <html xsl:version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns="http://www.w3.org/1999/xhtml">
  <body style="background-color:#FFFFFF;">
   <xsl:for-each select="<?php echo $sqlitedatabase; ?>/item">
    <xsl:element name="table">
     <xsl:element name="tr"><xsl:element name="td">EAN/UCC-13</xsl:element><xsl:element name="td"><xsl:element name="img"><xsl:attribute name="src"><?php echo $website_url.$barcode_file; ?>?act=ean13&amp;upc=<xsl:value-of select="upc"/></xsl:attribute><xsl:attribute name="title"><xsl:value-of select="upc"/></xsl:attribute><xsl:attribute name="alt"><xsl:value-of select="upc"/></xsl:attribute></xsl:element></xsl:element></xsl:element>
     <xsl:element name="tr"><xsl:element name="td">Description</xsl:element><xsl:element name="td"><xsl:value-of select="description"/></xsl:element></xsl:element>
     <xsl:element name="tr"><xsl:element name="td">Size/Weight</xsl:element><xsl:element name="td"><xsl:value-of select="sizeweight"/></xsl:element></xsl:element>
     <?php if($add_quantity_row===true) { ?><xsl:element name="tr"><xsl:element name="td">Quantity</xsl:element><xsl:element name="td"><xsl:value-of select="quantity"/></xsl:element></xsl:element><?php } ?>
    </xsl:element>
    <xsl:element name="div"><br /></xsl:element>
   </xsl:for-each>
  </body>
 </html>
</xsl:template>
</xsl:stylesheet>
<?php } ?>