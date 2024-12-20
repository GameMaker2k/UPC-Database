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

    $FileInfo: upc.php - Last Update: 10/24/2024 Ver. 2.2.5 RC 1 - Author: cooldude2k $
*/

require("./settings.php");

$upce = null;
$upca = null;
$ean13 = null;
if (!isset($_GET['act']) && isset($_POST['act'])) {
    $_GET['act'] = $_POST['act'];
}
if (!isset($_GET['act'])) {
    $_GET['act'] = "lookup";
    /*header("Location: ".$website_url.$url_file."?act=lookup"); exit();*/
}
if (isset($_GET['act']) && $_GET['act'] == "view") {
    $_GET['act'] = "lookup";
}
if (!isset($_GET['subact']) && isset($_POST['subact'])) {
    $_GET['subact'] = $_POST['subact'];
}
if (!isset($_POST['subact']) && isset($_GET['subact'])) {
    $_POST['subact'] = $_GET['subact'];
}
if (!isset($_GET['subact'])) {
    $_GET['subact'] = null;
}
if (!isset($_POST['upc']) && isset($_GET['upc'])) {
    $_POST['upc'] = $_GET['upc'];
}
if (!isset($_GET['upc']) && isset($_POST['upc'])) {
    $_GET['upc'] = $_POST['upc'];
}
if (isset($_GET['upc'])) {
    $_GET['upc'] = trim($_GET['upc']);
    $_GET['upc'] = remove_spaces($_GET['upc']);
}
if (isset($_POST['upc'])) {
    $_POST['upc'] = trim($_POST['upc']);
    $_POST['upc'] = remove_spaces($_POST['upc']);
}
if (($_GET['act'] == "upca" || $_GET['act'] == "upce" || $_GET['act'] == "ean8" ||
    $_GET['act'] == "ean13" || $_GET['act'] == "itf14") && isset($_GET['upc'])) {
    header("Location: ".$website_url.$barcode_file."?act=".$_GET['act']."&upc=".$_GET['upc']);
    exit();
}
if (isset($_GET['upc']) && !is_numeric($_GET['upc'])) {
    $_GET['upc'] = trim($_GET['upc']);
    $_GET['upc'] = remove_spaces($_GET['upc']);
    $_GET['upc'] = cuecat_decode($_GET['upc']);
}
if (isset($_POST['upc']) && !is_numeric($_POST['upc'])) {
    $_POST['upc'] = cuecat_decode($_POST['upc']);
}
if (isset($_POST['upc'])) {
    if (strlen($_POST['upc']) == 13 && validate_ean13($_POST['upc']) === false) {
        $_POST['upc'] = fix_ean13_checksum($_POST['upc']);
    }
    if (strlen($_POST['upc']) == 12 && validate_upca($_POST['upc']) === false) {
        $_POST['upc'] = fix_upca_checksum($_POST['upc']);
    }
    if (strlen($_POST['upc']) == 8 && validate_upce($_POST['upc']) === false && validate_ean8($_POST['upc']) === false) {
        $_POST['upc'] = fix_upce_checksum($_POST['upc']);
    }
    if (strlen($_POST['upc']) == 13 && validate_ean13($_POST['upc']) === true &&
        validate_upca(convert_ean13_to_upca($_POST['upc'])) === true) {
        $_POST['upc'] = convert_ean13_to_upca($_POST['upc']);
    }
    if (strlen($_POST['upc']) == 12 && validate_upca($_POST['upc']) === true &&
        validate_upce(convert_upca_to_upce($_POST['upc'])) === true) {
        $_POST['upc'] = convert_upca_to_upce($_POST['upc']);
    }
    if (strlen($_POST['upc']) == 8 && validate_upce($_POST['upc']) === true) {
        $upce = $_POST['upc'];
        $_POST['upc'] = convert_upce_to_upca($_POST['upc']);
    }
    if (strlen($_POST['upc']) == 8 && validate_upce($_POST['upc']) === false && validate_ean8($_POST['upc']) === true) {
        $_POST['upc'] = convert_ean8_to_upca($_POST['upc']);
    }
    if (strlen($_POST['upc']) == 12 && validate_upca($_POST['upc']) === true) {
        $upca = $_POST['upc'];
        $_POST['upc'] = convert_upca_to_ean13($_POST['upc']);
    }
    if (strlen($_POST['upc']) == 13 && validate_ean13($_POST['upc']) === true) {
        $ean13 = $_POST['upc'];
    }
    if (strlen($_POST['upc']) == 13 && validate_ean13($_POST['upc']) === false) {
        unset($_POST['upc']);
    }
}
if (isset($_POST['upc']) && !is_numeric($_POST['upc'])) {
    unset($_POST['upc']);
}
if (isset($_POST['upc']) && strlen($_POST['upc']) > 13) {
    unset($_POST['upc']);
}
if (isset($_GET['upc'])) {
    if (strlen($_GET['upc']) == 8 && validate_upce($_GET['upc']) === true) {
        $upce = $_GET['upc'];
        $_GET['upc'] = convert_upce_to_upca($_GET['upc']);
    }
    if (strlen($_GET['upc']) == 8 && validate_upce($_GET['upc']) === false && validate_ean8($_GET['upc']) === true) {
        $_GET['upc'] = convert_ean8_to_upca($_GET['upc']);
    }
    if (strlen($_GET['upc']) == 12 && validate_upca($_GET['upc']) === true) {
        $upca = $_GET['upc'];
        $_GET['upc'] = convert_upca_to_ean13($_GET['upc']);
    }
    if (strlen($_GET['upc']) == 13 && validate_ean13($_GET['upc']) === true) {
        $ean13 = $_GET['upc'];
    }
    if (strlen($_GET['upc']) == 13 && validate_ean13($_GET['upc']) === false) {
        unset($_GET['upc']);
    }
}
if (isset($_GET['upc']) && !is_numeric($_GET['upc'])) {
    unset($_GET['upc']);
}
if (isset($_GET['upc']) && strlen($_GET['upc']) > 13) {
    unset($_GET['upc']);
}
if (($_GET['act'] == "upca" || $_GET['act'] == "upce" || $_GET['act'] == "ean8" ||
    $_GET['act'] == "ean13" || $_GET['act'] == "itf14") && !isset($_GET['upc'])) {
    $_GET['act'] = "lookup";
    header("Location: ".$website_url.$url_file."?act=lookup");
    exit();
}
if (isset($_COOKIE['MemberName']) && isset($_COOKIE['MemberID']) && isset($_COOKIE['SessPass'])) {
    if ($_GET['act'] == "login" || $_GET['act'] == "signin" || $_GET['act'] == "join" || $_GET['act'] == "signup") {
        $_GET['act'] = "lookup";
        header("Location: ".$website_url.$url_file."?act=lookup");
        exit();
    }
}
if ($_GET['act'] == "logout" || $_GET['act'] == "signout") {
    unset($_COOKIE['MemberName']);
    setcookie("MemberName", null, -1, $cbasedir, $cookieDomain);
    unset($_COOKIE['MemberID']);
    setcookie("MemberID", null, -1, $cbasedir, $cookieDomain);
    unset($_COOKIE['SessPass']);
    setcookie("SessPass", null, -1, $cbasedir, $cookieDomain);
    $_GET['act'] = "login";
    header("Location: ".$website_url.$url_file."?act=login");
    exit();
}
if (strlen($_POST['upc']) > 0 && strlen($_POST['upc']) != 8 && strlen($_POST['upc']) != 12 && strlen($_POST['upc']) != 13) {
    $_GET['act'] = "lookup";
    header("Location: ".$website_url.$url_file."?act=lookup");
    exit();
}
if ($_GET['act'] == "random" || $_GET['act'] == "rand") {
    $findupc = sqlite3_query($slite3, "SELECT * FROM \"".$table_prefix."items\" ORDER BY RANDOM() LIMIT 1;");
    $upcinfo = sql_fetch_assoc($findupc);
    $_GET['act'] = "lookup";
    header("Location: ".$website_url.$url_file."?act=lookup&upc=".$upcinfo['upc']);
    exit();
}
if (($_GET['act'] == "terms" || $_GET['act'] == "termsofuse") &&
    !file_exists("./terms.txt") && !file_exists("./terms.html") &&
    !file_exists("./termsofuse.txt") && !file_exists("./termsofuse.html")) {
    $_GET['act'] = "lookup";
    header("Location: ".$website_url.$url_file."?act=lookup");
    exit();
}
if ($_GET['act'] == "login" || $_GET['act'] == "signin" ||
    $_GET['act'] == "join" || $_GET['act'] == "signup" ||
    $_GET['act'] == "usr" || $_GET['act'] == "user" ||
    $_GET['act'] == "usrs" || $_GET['act'] == "users") {
    require("./misc/members.php");
}
if ($_GET['act'] == "lookup" || $_GET['act'] == "check" ||
    $_GET['act'] == "terms" || $_GET['act'] == "termsofuse" ||
    $_GET['act'] == "stats" || $_GET['act'] == "statistics" ||
    $_GET['act'] == "checkdigit") {
    require("./misc/lookup.php");
}
if ($_GET['act'] == "add") {
    require("./misc/additem.php");
}
if ($_GET['act'] == "latest" || $_GET['act'] == "neighbor" ||
    $_GET['act'] == "neighbors" || $_GET['act'] == "search") {
    require("./misc/listitem.php");
}
if ($_GET['act'] == "csv" || $_GET['act'] == "dumpcsv" ||
   $_GET['act'] == "xml" || $_GET['act'] == "dumpxml" ||
   $_GET['act'] == "sgml" || $_GET['act'] == "dumpsgml" ||
   $_GET['act'] == "yml" || $_GET['act'] == "dumpyml" ||
   $_GET['act'] == "json" || $_GET['act'] == "dumpjson" ||
   $_GET['act'] == "yaml" || $_GET['act'] == "dumpyaml" ||
   $_GET['act'] == "serialize" || $_GET['act'] == "dumpserialize" ||
   $_GET['act'] == "xslt") {
    if ($disable_dumps === true) {
        $_GET['act'] = "lookup";
        header("Location: ".$website_url.$url_file."?act=lookup");
        exit();
    }
    require("./misc/dumpfile.php");
}
sqlite3_close($slite3);
