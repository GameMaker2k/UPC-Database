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

    $FileInfo: settings.php - Last Update: 10/24/2024 Ver. 2.2.5 RC 1 - Author: cooldude2k $
*/

$website_url = "http://localhost/upcdatabase/";
$url_file = "upc.php";
$barcode_file = "ucc.php";
$url_admin_file = "admin.php";
$sqlitedatabase = "upcdatabase";
$usehashtype = "sha256";
$appname = htmlspecialchars("Open UPC Database");
$appmakerurl = "https://github.com/GameMaker2k/UPC-Database";
$appmaker = htmlspecialchars("Game Maker 2k");
$validate_items = true;
$validate_members = true;
$disable_dumps = false;
$sitekeywords = "";
$sitedescription = "";
$site_encryption_key = "";
$sqlite_version = 3;
$display_per_page = 25;
$add_quantity_row = false;

$appver = array(2,2,5,"RC 1");
$upcdatabase = "http://www.upcdatabase.com/item/%s";
$sitename = $appname;
$siteauthor = $appmaker;
$table_prefix = $sqlitedatabase."_";
$sdb_file = $sqlitedatabase.".sdb";

@ob_start("ob_gzhandler");

$File3Name = basename($_SERVER['SCRIPT_NAME']);
if ($File3Name == "settings.php" || $File3Name == "/settings.php") {
    header("Location: ".$website_url.$url_file."?act=lookup");
    exit();
}

$usersip = $_SERVER['REMOTE_ADDR'];
$basecheck = parse_url($website_url);
$basedir = $basecheck['path'];
$cbasedir = $basedir;
$cookieDomain = $basecheck['host'];

if (!is_numeric($sqlite_version)) {
    $sqlite_version = 3;
}
if ($sqlite_version > 3 || $sqlite_version < 2) {
    $sqlite_version = 3;
}
if ($sqlite_version == 3 && !extension_loaded("sqlite3")) {
    $sqlite_version = 2;
}
if ($sqlite_version == 2 && !extension_loaded("sqlite")) {
    $sqlite_version = 3;
}
if (!is_bool($add_quantity_row)) {
    $add_quantity_row = false;
}

$disfunc = @ini_get("disable_functions");
$disfunc = @trim($disfunc);
$disfunc = @preg_replace("/([\\s+|\\t+|\\n+|\\r+|\\0+|\\x0B+])/i", "", $disfunc);
if ($disfunc != "ini_set") {
    $disfunc = explode(",", $disfunc);
}
if ($disfunc == "ini_set") {
    $disfunc = array("ini_set");
}

if (!in_array("ini_set", $disfunc)) {
    @ini_set("html_errors", false);
    @ini_set("track_errors", false);
    @ini_set("display_errors", false);
    @ini_set("report_memleaks", false);
    @ini_set("display_startup_errors", false);
    //@ini_set("error_log","logs/error.log");
    //@ini_set("log_errors","On");
    @ini_set("docref_ext", "");
    @ini_set("docref_root", "http://php.net/");
    @ini_set("date.timezone", "UTC");
    @ini_set("default_mimetype", "text/html");
    @ini_set("zlib.output_compression", false);
    @ini_set("zlib.output_compression_level", -1);
    //@ini_set("session.use_trans_sid", false);
    //@ini_set("session.use_cookies", true);
    //@ini_set("session.use_only_cookies", true);
    @ini_set("url_rewriter.tags", "");
    @ini_set('zend.ze1_compatibility_mode', 0);
    @ini_set("ignore_user_abort", 1);
}
if (!defined("E_DEPRECATED")) {
    define("E_DEPRECATED", 0);
}
@error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
if (function_exists("date_default_timezone_set")) {
    @date_default_timezone_set("UTC");
}

@header("Content-Type: text/html; charset=UTF-8");
@header("Content-Language: en");
@header("content-Style-Type: text/css");
@header("Content-Script-Type: text/javascript");
if (!isset($_SERVER['HTTP_USER_AGENT'])) {
    $_SERVER['HTTP_USER_AGENT'] = "";
}
if (strpos($_SERVER['HTTP_USER_AGENT'], "msie") &&
    !strpos($_SERVER['HTTP_USER_AGENT'], "opera")) {
    @header("X-UA-Compatible: IE=Edge");
}
if (strpos($_SERVER['HTTP_USER_AGENT'], "chromeframe")) {
    @header("X-UA-Compatible: IE=Edge,chrome=1");
}
@header("Date: ".gmdate("D, d M Y H:i:s")." GMT");
@header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
@header("Expires: ".gmdate("D, d M Y H:i:s")." GMT");

if (extension_loaded("sqlite3") && $sqlite_version == 3) {
    function sqlite3_open($filename, $mode = 0666)
    {
        global $site_encryption_key;
        if ($site_encryption_key === null) {
            $handle = new SQLite3($filename, SQLITE3_OPEN_READWRITE | SQLITE3_OPEN_CREATE);
        }
        if ($site_encryption_key !== null) {
            $handle = new SQLite3($filename, SQLITE3_OPEN_READWRITE | SQLITE3_OPEN_CREATE, $site_encryption_key);
        }
        return $handle;
    }
    function sqlite3_close($dbhandle)
    {
        $dbhandle->close();
        return true;
    }
    function sqlite3_escape_string($dbhandle, $string)
    {
        $string = $dbhandle->escapeString($string);
        return $string;
    }
    function sqlite3_query($dbhandle, $query)
    {
        $results = $dbhandle->query($query);
        return $results;
    }
    function sqlite3_fetch_array($result, $result_type = SQLITE3_BOTH)
    {
        $row = $result->fetchArray($result_type);
        return $row;
    }
    function sql_fetch_assoc($result)
    {
        $row = $result->fetchArray(SQLITE3_ASSOC);
        return $row;
    }
    function sqlite3_last_insert_rowid($dbhandle)
    {
        $rowid = $dbhandle->lastInsertRowID();
        return $rowid;
    }
    function sqlite3_libversion($dbhandle)
    {
        $dbversion = $dbhandle->version();
        return $dbversion['versionString'];
    }
}

if (extension_loaded("sqlite") && $sqlite_version == 2) {
    function sqlite3_open($filename, $mode = 0666)
    {
        $handle = sqlite_open($filename, $mode);
        return $handle;
    }
    function sqlite3_close($dbhandle)
    {
        $dbhandle = sqlite_close($dbhandle);
        return true;
    }
    function sqlite3_escape_string($dbhandle, $string)
    {
        $string = sqlite_escape_string($string);
        return $string;
    }
    function sqlite3_query($dbhandle, $query)
    {
        $results = sqlite_query($dbhandle, $query);
        return $results;
    }
    function sqlite3_fetch_array($result, $result_type = SQLITE_BOTH)
    {
        $row = sqlite_fetch_array($result, $result_type = SQLITE_BOTH);
        return $row;
    }
    function sql_fetch_assoc($result)
    {
        $row = sqlite_fetch_array($result, SQLITE_ASSOC);
        return $row;
    }
    function sqlite3_last_insert_rowid($dbhandle)
    {
        $rowid = sqlite_last_insert_rowid($dbhandle);
        return $rowid;
    }
    function sqlite3_libversion($dbhandle)
    {
        $dbversion = sqlite_libversion();
        return $dbversion;
    }
}

function version_info($proname, $subver, $ver, $supver, $reltype, $svnver, $showsvn)
{
    $return_var = $proname." ".$reltype." ".$subver.".".$ver.".".$supver;
    if ($showsvn == false) {
        $showsvn = null;
    }
    if ($showsvn == true) {
        $return_var .= " SVN ".$svnver;
    }
    if ($showsvn != true && $showsvn != null) {
        $return_var .= " ".$showsvn." ".$svnver;
    }
    return $return_var;
}
$appversion = version_info($appname, $appver[0], $appver[1], $appver[2], $appver[3]." Ver.", null, false);
require("./functions.php");

// _format_bytes by yatsynych at gmail dot com
// URL: http://php.net/manual/en/function.filesize.php#106935
function _format_bytes($a_bytes)
{
    if ($a_bytes < 1024) {
        return $a_bytes .' B';
    } elseif ($a_bytes < 1048576) {
        return round($a_bytes / 1024, 2) .' KiB';
    } elseif ($a_bytes < 1073741824) {
        return round($a_bytes / 1048576, 2) . ' MiB';
    } elseif ($a_bytes < 1099511627776) {
        return round($a_bytes / 1073741824, 2) . ' GiB';
    } elseif ($a_bytes < 1125899906842624) {
        return round($a_bytes / 1099511627776, 2) .' TiB';
    } elseif ($a_bytes < 1152921504606846976) {
        return round($a_bytes / 1125899906842624, 2) .' PiB';
    } elseif ($a_bytes < 1180591620717411303424) {
        return round($a_bytes / 1152921504606846976, 2) .' EiB';
    } elseif ($a_bytes < 1208925819614629174706176) {
        return round($a_bytes / 1180591620717411303424, 2) .' ZiB';
    } else {
        return round($a_bytes / 1208925819614629174706176, 2) .' YiB';
    }
}

$slite3 = sqlite3_open($sdb_file);
$tablecheck1 = @sqlite3_query($slite3, "SELECT * FROM \"".$table_prefix."members\"");
if ($tablecheck1 === false) {
    sqlite3_query($slite3, "PRAGMA auto_vacuum = 1;");
    sqlite3_query($slite3, "PRAGMA encoding = \"UTF-8\";");
    $query = "CREATE TABLE \"".$table_prefix."members\" (\n".
    "  \"id\" INTEGER PRIMARY KEY NOT NULL,\n".
    "  \"name\" VARCHAR(150) UNIQUE NOT NULL default '',\n".
    "  \"password\" VARCHAR(250) NOT NULL default '',\n".
    "  \"hashtype\" VARCHAR(50) NOT NULL default '',\n".
    "  \"email\" VARCHAR(256) UNIQUE NOT NULL default '',\n".
    "  \"timestamp\" INTEGER NOT NULL default '0',\n".
    "  \"lastactive\" INTEGER NOT NULL default '0',\n".
    "  \"canviewsite\" VARCHAR(20) NOT NULL default '',\n".
    "  \"validateitems\" VARCHAR(20) NOT NULL default '',\n".
    "  \"canaddupc\" VARCHAR(20) NOT NULL default '',\n".
    "  \"canmakeeditreq\" VARCHAR(20) NOT NULL default '',\n".
    "  \"canmakedelreq\" VARCHAR(20) NOT NULL default '',\n".
    "  \"canuseupcapi\" VARCHAR(20) NOT NULL default '',\n".
    "  \"validated\" VARCHAR(20) NOT NULL default '',\n".
    "  \"bantime\" INTEGER NOT NULL default '0',\n".
    "  \"numitems\" INTEGER NOT NULL default '0',\n".
    "  \"numpending\" INTEGER NOT NULL default '0',\n".
    "  \"numdelreq\" INTEGER NOT NULL default '0',\n".
    "  \"admin\" VARCHAR(20) NOT NULL default '',\n".
    "  \"ip\" VARCHAR(50) NOT NULL default '',\n".
    "  \"salt\" VARCHAR(50) NOT NULL default ''\n".
    ");";
    sqlite3_query($slite3, $query);
}
$tablecheck2 = @sqlite3_query($slite3, "SELECT * FROM \"".$table_prefix."items\"");
if ($tablecheck2 === false) {
    sqlite3_query($slite3, "PRAGMA auto_vacuum = 1;");
    sqlite3_query($slite3, "PRAGMA encoding = \"UTF-8\";");
    $query = "CREATE TABLE \"".$table_prefix."items\" (\n".
    "  \"id\" INTEGER PRIMARY KEY NOT NULL,\n".
    "  \"upc\" TEXT UNIQUE NOT NULL,\n".
    "  \"description\" TEXT NOT NULL,\n".
    "  \"sizeweight\" TEXT NOT NULL,\n".
    "  \"quantity\" TEXT NOT NULL,\n".
    "  \"validated\" VARCHAR(20) NOT NULL default '',\n".
    "  \"delrequest\" VARCHAR(20) NOT NULL default '',\n".
    "  \"delreqreason\" TEXT NOT NULL,\n".
    "  \"userid\" INTEGER NOT NULL default '0',\n".
    "  \"username\" VARCHAR(150) NOT NULL default '',\n".
    "  \"timestamp\" INTEGER NOT NULL default '0',\n".
    "  \"lastupdate\" INTEGER NOT NULL default '0',\n".
    "  \"edituserid\" INTEGER NOT NULL default '0',\n".
    "  \"editname\" VARCHAR(150) NOT NULL default '',\n".
    "  \"ip\" VARCHAR(50) NOT NULL default '',\n".
    "  \"editip\" VARCHAR(50) NOT NULL default ''\n".
    ");";
    sqlite3_query($slite3, $query);
}
$tablecheck3 = @sqlite3_query($slite3, "SELECT * FROM \"".$table_prefix."pending\"");
if ($tablecheck3 === false) {
    sqlite3_query($slite3, "PRAGMA auto_vacuum = 1;");
    sqlite3_query($slite3, "PRAGMA encoding = \"UTF-8\";");
    $query = "CREATE TABLE \"".$table_prefix."pending\" (\n".
    "  \"id\" INTEGER PRIMARY KEY NOT NULL,\n".
    "  \"upc\" TEXT UNIQUE NOT NULL,\n".
    "  \"description\" TEXT NOT NULL,\n".
    "  \"sizeweight\" TEXT NOT NULL,\n".
    "  \"quantity\" TEXT NOT NULL,\n".
    "  \"validated\" VARCHAR(20) NOT NULL default '',\n".
    "  \"delrequest\" VARCHAR(20) NOT NULL default '',\n".
    "  \"delreqreason\" TEXT NOT NULL,\n".
    "  \"userid\" INTEGER NOT NULL default '0',\n".
    "  \"username\" VARCHAR(150) NOT NULL default '',\n".
    "  \"timestamp\" INTEGER NOT NULL default '0',\n".
    "  \"lastupdate\" INTEGER NOT NULL default '0',\n".
    "  \"ip\" VARCHAR(50) NOT NULL default ''\n".
    ");";
    sqlite3_query($slite3, $query);
}
$tablecheck3 = @sqlite3_query($slite3, "SELECT * FROM \"".$table_prefix."modupc\"");
if ($tablecheck3 === false) {
    sqlite3_query($slite3, "PRAGMA auto_vacuum = 1;");
    sqlite3_query($slite3, "PRAGMA encoding = \"UTF-8\";");
    $query = "CREATE TABLE \"".$table_prefix."modupc\" (\n".
    "  \"id\" INTEGER PRIMARY KEY NOT NULL,\n".
    "  \"upc\" TEXT UNIQUE NOT NULL,\n".
    "  \"description\" TEXT NOT NULL,\n".
    "  \"sizeweight\" TEXT NOT NULL,\n".
    "  \"quantity\" TEXT NOT NULL,\n".
    "  \"validated\" VARCHAR(20) NOT NULL default '',\n".
    "  \"delrequest\" VARCHAR(20) NOT NULL default '',\n".
    "  \"delreqreason\" TEXT NOT NULL,\n".
    "  \"userid\" INTEGER NOT NULL default '0',\n".
    "  \"username\" VARCHAR(150) NOT NULL default '',\n".
    "  \"timestamp\" INTEGER NOT NULL default '0',\n".
    "  \"lastupdate\" INTEGER NOT NULL default '0',\n".
    "  \"ip\" VARCHAR(50) NOT NULL default ''\n".
    ");";
    sqlite3_query($slite3, $query);
}

if (!is_numeric($_COOKIE['MemberID'])) {
    unset($_COOKIE['MemberID']);
    setcookie("MemberID", null, -1, $cbasedir, $cookieDomain);
}
if (isset($_COOKIE['MemberName']) && !isset($_COOKIE['MemberID']) && !isset($_COOKIE['SessPass'])) {
    unset($_COOKIE['MemberName']);
    setcookie("MemberName", null, -1, $cbasedir, $cookieDomain);
}
if (!isset($_COOKIE['MemberName']) && isset($_COOKIE['MemberID']) && !isset($_COOKIE['SessPass'])) {
    unset($_COOKIE['MemberID']);
    setcookie("MemberID", null, -1, $cbasedir, $cookieDomain);
}
if (!isset($_COOKIE['MemberName']) && !isset($_COOKIE['MemberID']) && isset($_COOKIE['SessPass'])) {
    unset($_COOKIE['SessPass']);
    setcookie("SessPass", null, -1, $cbasedir, $cookieDomain);
}
if (isset($_COOKIE['MemberName']) && isset($_COOKIE['MemberID']) && isset($_COOKIE['SessPass'])) {
    $findme = sqlite3_query($slite3, "SELECT COUNT(*) AS COUNT FROM \"".$table_prefix."members\" WHERE name='".sqlite3_escape_string($slite3, $_COOKIE['MemberName'])."';");
    $numfindme = sql_fetch_assoc($findme);
    $numfmrows = $numfindme['COUNT'];
    if ($numfmrows < 1) {
        unset($_COOKIE['MemberName']);
        setcookie("MemberName", null, -1, $cbasedir, $cookieDomain);
        unset($_COOKIE['MemberID']);
        setcookie("MemberID", null, -1, $cbasedir, $cookieDomain);
        unset($_COOKIE['SessPass']);
        setcookie("SessPass", null, -1, $cbasedir, $cookieDomain);
    }
    if ($numfmrows > 0) {
        $findme = sqlite3_query($slite3, "SELECT * FROM \"".$table_prefix."members\" WHERE name='".sqlite3_escape_string($slite3, $_COOKIE['MemberName'])."';");
        $userinfo = sql_fetch_assoc($findme);
        $usersiteinfo = $userinfo;
        $ChkUsrGMTime = time();
        if ($userinfo['bantime'] != 0 && $userinfo['bantime'] != null) {
            if ($userinfo['bantime'] >= $ChkUsrGMTime) {
                $userinfo['canviewsite'] = "yes";
            }
            if ($userinfo['bantime'] < 0) {
                $userinfo['canviewsite'] = "yes";
            }
        }
        if ($userinfo['password'] != $_COOKIE['SessPass']) {
            unset($_COOKIE['MemberName']);
            setcookie("MemberName", null, -1, $cbasedir, $cookieDomain);
            unset($_COOKIE['MemberID']);
            setcookie("MemberID", null, -1, $cbasedir, $cookieDomain);
            unset($_COOKIE['SessPass']);
            setcookie("SessPass", null, -1, $cbasedir, $cookieDomain);
        }
    }
}
if (!isset($usersiteinfo['admin'])) {
    $usersiteinfo['admin'] = "no";
}
if ($usersiteinfo['admin'] != "yes" && $usersiteinfo['admin'] != "no") {
    $usersiteinfo['admin'] = "no";
}
if (!isset($usersiteinfo['validated'])) {
    $usersiteinfo['validated'] = "no";
}
if ($usersiteinfo['validated'] != "yes" && $usersiteinfo['validated'] != "no") {
    $usersiteinfo['validated'] = "no";
}
if (!isset($usersiteinfo['validateitems'])) {
    $usersiteinfo['validateitems'] = "no";
}
if ($usersiteinfo['validateitems'] != "yes" && $usersiteinfo['validateitems'] != "no") {
    $usersiteinfo['validateitems'] = "no";
}
if (!isset($_COOKIE['LastVisit'])) {
    setcookie("LastVisit", time(), time() + (7 * 86400), $cbasedir, $cookieDomain);
}
if (date("Ymd", time()) > date("Ymd", $_COOKIE['LastVisit'])) {
    setcookie("LastVisit", time(), time() + (7 * 86400), $cbasedir, $cookieDomain);
    setcookie("MemberName", $_COOKIE['MemberName'], time() + (7 * 86400), $cbasedir, $cookieDomain);
    setcookie("MemberID", $_COOKIE['MemberID'], time() + (7 * 86400), $cbasedir, $cookieDomain);
    setcookie("SessPass", $_COOKIE['SessPass'], time() + (7 * 86400), $cbasedir, $cookieDomain);
}

$metatags = "<meta http-equiv=\"Content-Language\" content=\"en\" />\n  <meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />\n  <meta http-equiv=\"Content-Style-Type\" content=\"text/css\" />\n  <meta http-equiv=\"Content-Script-Type\" content=\"text/javascript\" />\n  <meta name=\"generator\" content=\"".$sitename."\" />\n  <meta name=\"author\" content=\"".$siteauthor."\" />\n  <meta name=\"keywords\" content=\"".$sitekeywords."\" />\n  <meta name=\"description\" content=\"".$sitedescription."\" />\n  <base href=\"".$website_url."\" />\n  <link rel=\"icon\" href=\"favicon.ico\" />\n  <link rel=\"shortcut icon\" href=\"favicon.ico\" />\n  <script type=\"text/javascript\" src=\"js/validate.js\"></script>\n  <script type=\"text/javascript\" src=\"js/convert.js\"></script>\n  <script type=\"text/javascript\" src=\"js/kittycode.js\"></script>\n  <script type=\"text/javascript\" src=\"js/misc.js\"></script>\n  <style type=\"text/css\">\n  body {\n	  min-width: 750px;\n	  margin: 0;\n	  padding: 0;\n  }\n  img {\n	  border: 0;\n	  margin: 0;\n  }\n  table {\n	  margin-left: auto;\n	  margin-right: auto;\n	  text-align: left;\n  }\n  </style>\n";

$adminlink = null;
if ($usersiteinfo['admin'] == "yes") {
    $adminlink = " | <a href=\"".$website_url.$url_admin_file."\">AdminCP</a>";
}
if ($usersiteinfo['admin'] == "yes") {
    $usersiteinfo['validated'] = "yes";
}
$navbar = "<h1><big><a style=\"text-decoration: none;\" href=\"".$website_url.$url_file."?act=lookup\">".$sitename."</a></big></h1>\n   <div>";
if (isset($_COOKIE['MemberName'])) {
    $navbar = $navbar."Welcome: <a href=\"".$website_url.$url_file."?act=user\">".$_COOKIE['MemberName']."</a>".$adminlink." | <a href=\"".$website_url.$url_file."?act=logout\">Logout</a> | <a href=\"".$website_url.$url_file."?act=lookup\">Index Page</a>";
}
if (!isset($_COOKIE['MemberName'])) {
    $navbar = $navbar."Welcome: Guest | <a href=\"".$website_url.$url_file."?act=lookup\">Index Page</a> | <a href=\"".$website_url.$url_file."?act=join\">Join</a> | <a href=\"".$website_url.$url_file."?act=login\">Login</a>";
}
$navbar = $navbar." | <a href=\"".$website_url.$url_file."?act=latest&amp;page=1\">Latest</a> | <a href=\"".$website_url.$url_file."?act=random\">Random</a> | <a href=\"".$website_url.$url_file."?act=stats\">Stats</a> | <a href=\"".$website_url.$url_file."?act=checkdigit\">Checkdigit</a><br /></div>";

$navbarxslt = "<xsl:element name=\"h1\"><xsl:element name=\"big\"><xsl:element name=\"a\"><xsl:attribute name=\"style\">text-decoration: none;</xsl:attribute><xsl:attribute name=\"href\">".$website_url.$url_file."?act=lookup</xsl:attribute>".$sitename."</xsl:element></xsl:element></xsl:element>\n   <xsl:element name=\"div1\">";
if (isset($_COOKIE['MemberName'])) {
    $navbarxslt = $navbarxslt."Welcome: <xsl:element name=\"a\"><xsl:attribute name=\"href\">".$website_url.$url_file."?act=user</xsl:attribute>".$_COOKIE['MemberName']."</xsl:element>".$adminlink." | <xsl:element name=\"a\"><xsl:attribute name=\"href\">".$website_url.$url_file."?act=logout</xsl:attribute>Logout</xsl:element> | <xsl:element name=\"a\"><xsl:attribute name=\"href\">".$website_url.$url_file."?act=lookup</xsl:attribute>Index Page</xsl:element>";
}
if (!isset($_COOKIE['MemberName'])) {
    $navbarxslt = $navbarxslt."Welcome: Guest | <xsl:element name=\"a\"><xsl:attribute name=\"href\">".$website_url.$url_file."?act=lookup</xsl:attribute>Index Page</xsl:element> | <xsl:element name=\"a\"><xsl:attribute name=\"href\">".$website_url.$url_file."?act=join</xsl:attribute>Join</xsl:element> | <xsl:element name=\"a\"><xsl:attribute name=\"href\">".$website_url.$url_file."?act=login</xsl:attribute>Login</xsl:element>";
}
$navbarxslt = $navbarxslt." | <xsl:element name=\"a\"><xsl:attribute name=\"href\">".$website_url.$url_file."?act=latest&amp;page=1</xsl:attribute>Latest</xsl:element> | <xsl:element name=\"a\"><xsl:attribute name=\"href\">".$website_url.$url_file."?act=random</xsl:attribute>Random</xsl:element> | <xsl:element name=\"a\"><xsl:attribute name=\"href\">".$website_url.$url_file."?act=stats</xsl:attribute>Stats</xsl:element> | <xsl:element name=\"a\"><xsl:attribute name=\"href\">".$website_url.$url_file."?act=checkdigit</xsl:attribute>Checkdigit</xsl:element><xsl:element name=\"br\"></xsl:element></xsl:element>";

$endhtmltag = "\n  <center>\n   <br /><address><a href=\"".$appmakerurl."\" title=\"".$appname." by ".$appmaker."\">".$appname."</a> ver. ".$appver[0].".".$appver[1].".".$appver[2]." ".$appver[3]."</address>\n  </center>\n </body>\n</html>\n";

$endhtmlxslt = "   <xsl:element name=\"center\">\n    <xsl:element name=\"br\"></xsl:element>\n    <xsl:element name=\"address\">\n     <xsl:element name=\"a\">\n      <xsl:attribute name=\"href\">".$appmakerurl."</xsl:attribute>\n      <xsl:attribute name=\"title\">".$appname." by ".$appmaker."</xsl:attribute>".$appname."</xsl:element>\n	 ver. ".$appver[0].".".$appver[1].".".$appver[2]." ".$appver[3]."\n    </xsl:element>\n   </xsl:element>\n";

// Removes the bad stuff
function remove_bad_entities($Text)
{
    //HTML Entities Dec Version
    $Text = preg_replace("/&#8238;/isU", "", $Text);
    $Text = preg_replace("/&#8194;/isU", "", $Text);
    $Text = preg_replace("/&#8195;/isU", "", $Text);
    $Text = preg_replace("/&#8201;/isU", "", $Text);
    $Text = preg_replace("/&#8204;/isU", "", $Text);
    $Text = preg_replace("/&#8205;/isU", "", $Text);
    $Text = preg_replace("/&#8206;/isU", "", $Text);
    $Text = preg_replace("/&#8207;/isU", "", $Text);
    //HTML Entities Hex Version
    $Text = preg_replace("/&#x202e;/isU", "", $Text);
    $Text = preg_replace("/&#x2002;/isU", "", $Text);
    $Text = preg_replace("/&#x2003;/isU", "", $Text);
    $Text = preg_replace("/&#x2009;/isU", "", $Text);
    $Text = preg_replace("/&#x200c;/isU", "", $Text);
    $Text = preg_replace("/&#x200d;/isU", "", $Text);
    $Text = preg_replace("/&#x200e;/isU", "", $Text);
    $Text = preg_replace("/&#x200f;/isU", "", $Text);
    //HTML Entities Name Version
    $Text = preg_replace("/&ensp;/isU", "", $Text);
    $Text = preg_replace("/&emsp;/isU", "", $Text);
    $Text = preg_replace("/&thinsp;/isU", "", $Text);
    $Text = preg_replace("/&zwnj;/isU", "", $Text);
    $Text = preg_replace("/&zwj;/isU", "", $Text);
    $Text = preg_replace("/&lrm;/isU", "", $Text);
    $Text = preg_replace("/&rlm;/isU", "", $Text);
    return $Text;
}
// Remove the bad stuff
function remove_spaces($Text)
{
    $Text = preg_replace("/(^\t+|\t+$)/", "", $Text);
    $Text = preg_replace("/(^\n+|\n+$)/", "", $Text);
    $Text = preg_replace("/(^\r+|\r+$)/", "", $Text);
    $Text = preg_replace("/(\r|\n|\t)+/", " ", $Text);
    $Text = preg_replace("/\s\s+/", " ", $Text);
    $Text = preg_replace("/(^\s+|\s+$)/", "", $Text);
    $Text = trim($Text, "\x00..\x1F");
    $Text = remove_bad_entities($Text);
    return $Text;
}
