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

    $FileInfo: code93.php - Last Update: 10/24/2024 Ver. 2.2.5 RC 1 - Author: cooldude2k $
*/
$File3Name = basename($_SERVER['SCRIPT_NAME']);
if ($File3Name == "code93.php" || $File3Name == "/code93.php") {
    chdir("../");
    require("./upc.php");
    exit();
}

if (!isset($upcfunctions)) {
    $upcfunctions = array();
}
if (!is_array($upcfunctions)) {
    $upcfunctions = array();
}
array_push($upcfunctions, "create_code93");
function create_code93($upc, $imgtype = "png", $outputimage = true, $resize = 1, $resizetype = "resize", $outfile = null, $hidecd = false)
{
    if (!isset($upc)) {
        return false;
    }
    if (strlen($upc) < 1) {
        return false;
    }
    if (!preg_match("/([0-9a-zA-Z\-\.\$\/\+% ]+)/", $upc)) {
        return false;
    }
    if (!isset($resize) || !preg_match("/^([0-9]*[\.]?[0-9])/", $resize) || $resize < 1) {
        $resize = 1;
    }
    if ($resizetype != "resample" && $resizetype != "resize") {
        $resizetype = "resize";
    }
    if ($imgtype != "png" && $imgtype != "gif" && $imgtype != "xbm" && $imgtype != "wbmp") {
        $imgtype = "png";
    }
    $upc = strtoupper($upc);
    $upc_matches = str_split($upc);
    if (count($upc_matches) <= 0) {
        return false;
    }
    $Code93Array = array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z", "-", ".", " ", "$", "/", "+", "%", "($)", "(%)", "(/)", "(+)");
    $Code93Values = array_flip($Code93Array);
    $upc_reverse = array_reverse($upc_matches);
    $upc_print = $upc_matches;
    $UPC_Count = 0;
    $UPC_Weight = 1;
    $UPC_Sum = 0;
    while ($UPC_Count < count($upc_reverse)) {
        if ($UPC_Weight > 20) {
            $UPC_Weight = 1;
        }
        $UPC_Sum = $UPC_Sum + ($UPC_Weight * $Code93Values[$upc_reverse[$UPC_Count]]);
        ++$UPC_Count;
        ++$UPC_Weight;
    }
    array_push($upc_matches, $Code93Array[$UPC_Sum % 47]);
    $upc_reverse = array_reverse($upc_matches);
    $UPC_Count = 0;
    $UPC_Weight = 1;
    $UPC_Sum = 0;
    while ($UPC_Count < count($upc_reverse)) {
        if ($UPC_Weight > 20) {
            $UPC_Weight = 1;
        }
        $UPC_Sum = $UPC_Sum + ($UPC_Weight * $Code93Values[$upc_reverse[$UPC_Count]]);
        ++$UPC_Count;
        ++$UPC_Weight;
    }
    array_push($upc_matches, $Code93Array[$UPC_Sum % 47]);
    $upc_size_add = (count($upc_matches) * 9);
    if ($imgtype == "png") {
        if ($outputimage == true) {
            header("Content-Type: image/png");
        }
    }
    if ($imgtype == "gif") {
        if ($outputimage == true) {
            header("Content-Type: image/gif");
        }
    }
    if ($imgtype == "xbm") {
        if ($outputimage == true) {
            header("Content-Type: image/x-xbitmap");
        }
    }
    if ($imgtype == "wbmp") {
        if ($outputimage == true) {
            header("Content-Type: image/vnd.wap.wbmp");
        }
    }
    $upc_img = imagecreatetruecolor(37 + $upc_size_add, 62);
    imagefilledrectangle($upc_img, 0, 0, 37 + $upc_size_add, 62, 0xFFFFFF);
    imageinterlace($upc_img, true);
    $background_color = imagecolorallocate($upc_img, 255, 255, 255);
    $text_color = imagecolorallocate($upc_img, 0, 0, 0);
    $alt_text_color = imagecolorallocate($upc_img, 255, 255, 255);
    $NumTxtZero = 0;
    $LineTxtStart = 18;
    while ($NumTxtZero < count($upc_print)) {
        imagestring($upc_img, 2, $LineTxtStart, 48, $upc_print[$NumTxtZero], $text_color);
        $LineTxtStart += 9;
        ++$NumTxtZero;
    }
    imageline($upc_img, 0, 4, 0, 47, $alt_text_color);
    imageline($upc_img, 1, 4, 1, 47, $alt_text_color);
    imageline($upc_img, 2, 4, 2, 47, $alt_text_color);
    imageline($upc_img, 3, 4, 3, 47, $alt_text_color);
    imageline($upc_img, 4, 4, 4, 47, $alt_text_color);
    imageline($upc_img, 5, 4, 5, 47, $alt_text_color);
    imageline($upc_img, 6, 4, 6, 47, $alt_text_color);
    imageline($upc_img, 7, 4, 7, 47, $alt_text_color);
    imageline($upc_img, 8, 4, 8, 47, $alt_text_color);
    imageline($upc_img, 9, 4, 9, 47, $text_color);
    imageline($upc_img, 10, 4, 10, 47, $alt_text_color);
    imageline($upc_img, 11, 4, 11, 47, $text_color);
    imageline($upc_img, 12, 4, 12, 47, $alt_text_color);
    imageline($upc_img, 13, 4, 13, 47, $text_color);
    imageline($upc_img, 14, 4, 14, 47, $text_color);
    imageline($upc_img, 15, 4, 15, 47, $text_color);
    imageline($upc_img, 16, 4, 16, 47, $text_color);
    imageline($upc_img, 17, 4, 17, 47, $alt_text_color);
    $NumZero = 0;
    $LineStart = 18;
    $LineSize = 47;
    while ($NumZero < count($upc_matches)) {
        $left_text_color = array(1, 0, 0, 0, 1, 0, 1, 0, 0);
        if ($upc_matches[$NumZero] == 0) {
            $left_text_color = array(1, 0, 0, 0, 1, 0, 1, 0, 0);
        }
        if ($upc_matches[$NumZero] == 1) {
            $left_text_color = array(1, 0, 1, 0, 0, 1, 0, 0, 0);
        }
        if ($upc_matches[$NumZero] == 2) {
            $left_text_color = array(1, 0, 1, 0, 0, 0, 1, 0, 0);
        }
        if ($upc_matches[$NumZero] == 3) {
            $left_text_color = array(1, 0, 1, 0, 0, 0, 0, 1, 0);
        }
        if ($upc_matches[$NumZero] == 4) {
            $left_text_color = array(1, 0, 0, 1, 0, 1, 0, 0, 0);
        }
        if ($upc_matches[$NumZero] == 5) {
            $left_text_color = array(1, 0, 0, 1, 0, 0, 1, 0, 0);
        }
        if ($upc_matches[$NumZero] == 6) {
            $left_text_color = array(1, 0, 0, 1, 0, 0, 0, 1, 0);
        }
        if ($upc_matches[$NumZero] == 7) {
            $left_text_color = array(1, 0, 1, 0, 1, 0, 0, 0, 0);
        }
        if ($upc_matches[$NumZero] == 8) {
            $left_text_color = array(1, 0, 0, 0, 1, 0, 0, 1, 0);
        }
        if ($upc_matches[$NumZero] == 9) {
            $left_text_color = array(1, 0, 0, 0, 0, 1, 0, 1, 0);
        }
        if ($upc_matches[$NumZero] == "A") {
            $left_text_color = array(1, 1, 0, 1, 0, 1, 0, 0, 0);
        }
        if ($upc_matches[$NumZero] == "B") {
            $left_text_color = array(1, 1, 0, 1, 0, 0, 1, 0, 0);
        }
        if ($upc_matches[$NumZero] == "C") {
            $left_text_color = array(1, 1, 0, 1, 0, 0, 0, 1, 0);
        }
        if ($upc_matches[$NumZero] == "D") {
            $left_text_color = array(1, 1, 0, 0, 1, 0, 1, 0, 0);
        }
        if ($upc_matches[$NumZero] == "E") {
            $left_text_color = array(1, 1, 0, 0, 1, 0, 0, 1, 0);
        }
        if ($upc_matches[$NumZero] == "F") {
            $left_text_color = array(1, 1, 0, 0, 0, 1, 0, 1, 0);
        }
        if ($upc_matches[$NumZero] == "G") {
            $left_text_color = array(1, 0, 1, 1, 0, 1, 0, 0, 0);
        }
        if ($upc_matches[$NumZero] == "H") {
            $left_text_color = array(1, 0, 1, 1, 0, 0, 1, 0, 0);
        }
        if ($upc_matches[$NumZero] == "I") {
            $left_text_color = array(1, 0, 1, 1, 0, 0, 0, 1, 0);
        }
        if ($upc_matches[$NumZero] == "J") {
            $left_text_color = array(1, 0, 0, 1, 1, 0, 1, 0, 0);
        }
        if ($upc_matches[$NumZero] == "K") {
            $left_text_color = array(1, 0, 0, 0, 1, 1, 0, 1, 0);
        }
        if ($upc_matches[$NumZero] == "L") {
            $left_text_color = array(1, 0, 1, 0, 1, 1, 0, 0, 0);
        }
        if ($upc_matches[$NumZero] == "M") {
            $left_text_color = array(1, 0, 1, 0, 0, 1, 1, 0, 0);
        }
        if ($upc_matches[$NumZero] == "N") {
            $left_text_color = array(1, 0, 1, 0, 0, 0, 1, 1, 0);
        }
        if ($upc_matches[$NumZero] == "O") {
            $left_text_color = array(1, 0, 0, 1, 0, 1, 1, 0, 0);
        }
        if ($upc_matches[$NumZero] == "P") {
            $left_text_color = array(1, 0, 0, 0, 1, 0, 1, 1, 0);
        }
        if ($upc_matches[$NumZero] == "Q") {
            $left_text_color = array(1, 1, 0, 1, 1, 0, 1, 0, 0);
        }
        if ($upc_matches[$NumZero] == "R") {
            $left_text_color = array(1, 1, 0, 1, 1, 0, 0, 1, 0);
        }
        if ($upc_matches[$NumZero] == "S") {
            $left_text_color = array(1, 1, 0, 1, 0, 1, 1, 0, 0);
        }
        if ($upc_matches[$NumZero] == "T") {
            $left_text_color = array(1, 1, 0, 1, 0, 0, 1, 1, 0);
        }
        if ($upc_matches[$NumZero] == "U") {
            $left_text_color = array(1, 1, 0, 0, 1, 0, 1, 1, 0);
        }
        if ($upc_matches[$NumZero] == "V") {
            $left_text_color = array(1, 1, 0, 0, 1, 1, 0, 1, 0);
        }
        if ($upc_matches[$NumZero] == "W") {
            $left_text_color = array(1, 0, 1, 1, 0, 1, 1, 0, 0);
        }
        if ($upc_matches[$NumZero] == "X") {
            $left_text_color = array(1, 0, 1, 1, 0, 0, 1, 1, 0);
        }
        if ($upc_matches[$NumZero] == "Y") {
            $left_text_color = array(1, 0, 0, 1, 1, 0, 1, 1, 0);
        }
        if ($upc_matches[$NumZero] == "Z") {
            $left_text_color = array(1, 0, 0, 1, 1, 1, 0, 1, 0);
        }
        if ($upc_matches[$NumZero] == "-") {
            $left_text_color = array(1, 0, 0, 1, 0, 1, 1, 1, 0);
        }
        if ($upc_matches[$NumZero] == ".") {
            $left_text_color = array(1, 1, 1, 0, 1, 0, 1, 0, 0);
        }
        if ($upc_matches[$NumZero] == " ") {
            $left_text_color = array(1, 1, 1, 0, 1, 0, 0, 1, 0);
        }
        if ($upc_matches[$NumZero] == "$") {
            $left_text_color = array(1, 1, 1, 0, 0, 1, 0, 1, 0);
        }
        if ($upc_matches[$NumZero] == "/") {
            $left_text_color = array(1, 0, 1, 1, 0, 1, 1, 1, 0);
        }
        if ($upc_matches[$NumZero] == "+") {
            $left_text_color = array(1, 0, 1, 1, 1, 0, 1, 1, 0);
        }
        if ($upc_matches[$NumZero] == "%") {
            $left_text_color = array(1, 1, 0, 1, 0, 1, 1, 1, 0);
        }
        if ($upc_matches[$NumZero] == "($)") {
            $left_text_color = array(1, 0, 0, 1, 0, 0, 1, 1, 0);
        }
        if ($upc_matches[$NumZero] == "(%)") {
            $left_text_color = array(1, 1, 1, 0, 1, 1, 0, 1, 0);
        }
        if ($upc_matches[$NumZero] == "(/)") {
            $left_text_color = array(1, 1, 1, 0, 1, 0, 1, 1, 0);
        }
        if ($upc_matches[$NumZero] == "(+)") {
            $left_text_color = array(1, 0, 0, 1, 1, 0, 0, 1, 0);
        }
        $InnerUPCNum = 0;
        while ($InnerUPCNum < count($left_text_color)) {
            if ($left_text_color[$InnerUPCNum] == 1) {
                imageline($upc_img, $LineStart, 4, $LineStart, $LineSize, $text_color);
            }
            if ($left_text_color[$InnerUPCNum] == 0) {
                imageline($upc_img, $LineStart, 4, $LineStart, $LineSize, $alt_text_color);
            }
            $LineStart += 1;
            ++$InnerUPCNum;
        }
        ++$NumZero;
    }
    imageline($upc_img, 18 + $upc_size_add, 4, 18 + $upc_size_add, 47, $text_color);
    imageline($upc_img, 19 + $upc_size_add, 4, 19 + $upc_size_add, 47, $alt_text_color);
    imageline($upc_img, 20 + $upc_size_add, 4, 20 + $upc_size_add, 47, $text_color);
    imageline($upc_img, 21 + $upc_size_add, 4, 21 + $upc_size_add, 47, $alt_text_color);
    imageline($upc_img, 22 + $upc_size_add, 4, 22 + $upc_size_add, 47, $text_color);
    imageline($upc_img, 23 + $upc_size_add, 4, 23 + $upc_size_add, 47, $text_color);
    imageline($upc_img, 24 + $upc_size_add, 4, 24 + $upc_size_add, 47, $text_color);
    imageline($upc_img, 25 + $upc_size_add, 4, 25 + $upc_size_add, 47, $text_color);
    imageline($upc_img, 26 + $upc_size_add, 4, 26 + $upc_size_add, 47, $alt_text_color);
    imageline($upc_img, 27 + $upc_size_add, 4, 27 + $upc_size_add, 47, $text_color);
    imageline($upc_img, 28 + $upc_size_add, 4, 28 + $upc_size_add, 47, $alt_text_color);
    imageline($upc_img, 29 + $upc_size_add, 4, 29 + $upc_size_add, 47, $alt_text_color);
    imageline($upc_img, 30 + $upc_size_add, 4, 30 + $upc_size_add, 47, $alt_text_color);
    imageline($upc_img, 31 + $upc_size_add, 4, 31 + $upc_size_add, 47, $alt_text_color);
    imageline($upc_img, 32 + $upc_size_add, 4, 32 + $upc_size_add, 47, $alt_text_color);
    imageline($upc_img, 33 + $upc_size_add, 4, 33 + $upc_size_add, 47, $alt_text_color);
    imageline($upc_img, 34 + $upc_size_add, 4, 34 + $upc_size_add, 47, $alt_text_color);
    imageline($upc_img, 35 + $upc_size_add, 4, 35 + $upc_size_add, 47, $alt_text_color);
    imageline($upc_img, 36 + $upc_size_add, 4, 36 + $upc_size_add, 47, $alt_text_color);
    if ($resize > 1) {
        $new_upc_img = imagecreatetruecolor((37 + $upc_size_add) * $resize, 62 * $resize);
        imagefilledrectangle($new_upc_img, 0, 0, (37 + $upc_size_add) * $resize, 62 * $resize, 0xFFFFFF);
        imageinterlace($new_upc_img, true);
        if ($resizetype == "resize") {
            imagecopyresized($new_upc_img, $upc_img, 0, 0, 0, 0, (37 + $upc_size_add) * $resize, 62 * $resize, (37 + $upc_size_add), 62);
        }
        if ($resizetype == "resample") {
            imagecopyresampled($new_upc_img, $upc_img, 0, 0, 0, 0, (37 + $upc_size_add) * $resize, 62 * $resize, (37 + $upc_size_add), 62);
        }
        imagedestroy($upc_img);
        $upc_img = $new_upc_img;
    }
    if ($imgtype == "png") {
        if ($outputimage == true) {
            imagepng($upc_img);
        }
        if ($outfile != null) {
            imagepng($upc_img, $outfile);
        }
    }
    if ($imgtype == "gif") {
        if ($outputimage == true) {
            imagegif($upc_img);
        }
        if ($outfile != null) {
            imagegif($upc_img, $outfile);
        }
    }
    if ($imgtype == "xbm") {
        if ($outputimage == true) {
            imagexbm($upc_img, null);
        }
        if ($outfile != null) {
            imagexbm($upc_img, $outfile);
        }
    }
    if ($imgtype == "wbmp") {
        if ($outputimage == true) {
            imagewbmp($upc_img);
        }
        if ($outfile != null) {
            imagewbmp($upc_img, $outfile);
        }
    }
    imagedestroy($upc_img);
    return true;
}
