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

    $FileInfo: ean2.php - Last Update: 10/24/2024 Ver. 2.2.5 RC 1 - Author: cooldude2k $
*/
$File3Name = basename($_SERVER['SCRIPT_NAME']);
if ($File3Name == "ean2.php" || $File3Name == "/ean2.php") {
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
array_push($upcfunctions, "create_ean2");
function create_ean2($upc, $offsetadd, $imgres)
{
    if (!isset($upc) || !is_numeric($upc)) {
        return false;
    }
    if (strlen($upc) > 2 || strlen($upc) < 2) {
        return false;
    }
    preg_match("/(\d{2})/", $upc, $upc_matches);
    if (count($upc_matches) <= 0) {
        return false;
    }
    $CheckSum = $upc_matches[1] % 4;
    $LeftDigit = str_split($upc_matches[1]);
    $text_color = imagecolorallocate($imgres, 0, 0, 0);
    $alt_text_color = imagecolorallocate($imgres, 255, 255, 255);
    imagestring($imgres, 2, 5 + $offsetadd, 47, $LeftDigit[0], $text_color);
    imagestring($imgres, 2, 13 + $offsetadd, 47, $LeftDigit[1], $text_color);
    imageline($imgres, 0 + $offsetadd, 10, 0 + $offsetadd, 47, $alt_text_color);
    imageline($imgres, 1 + $offsetadd, 10, 1 + $offsetadd, 47, $text_color);
    imageline($imgres, 2 + $offsetadd, 10, 2 + $offsetadd, 47, $alt_text_color);
    imageline($imgres, 3 + $offsetadd, 10, 3 + $offsetadd, 47, $text_color);
    imageline($imgres, 4 + $offsetadd, 10, 4 + $offsetadd, 47, $text_color);
    $NumZero = 0;
    $LineStart = 5 + $offsetadd;
    while ($NumZero < count($LeftDigit)) {
        $LineSize = 47;
        $left_text_color_l = array(0, 0, 0, 0, 0, 0, 0);
        $left_text_color_g = array(1, 1, 1, 1, 1, 1, 1);
        if ($LeftDigit[$NumZero] == 0) {
            $left_text_color_l = array(0, 0, 0, 1, 1, 0, 1);
            $left_text_color_g = array(0, 1, 0, 0, 1, 1, 1);
        }
        if ($LeftDigit[$NumZero] == 1) {
            $left_text_color_l = array(0, 0, 1, 1, 0, 0, 1);
            $left_text_color_g = array(0, 1, 1, 0, 0, 1, 1);
        }
        if ($LeftDigit[$NumZero] == 2) {
            $left_text_color_l = array(0, 0, 1, 0, 0, 1, 1);
            $left_text_color_g = array(0, 0, 1, 1, 0, 1, 1);
        }
        if ($LeftDigit[$NumZero] == 3) {
            $left_text_color_l = array(0, 1, 1, 1, 1, 0, 1);
            $left_text_color_g = array(0, 1, 0, 0, 0, 0, 1);
        }
        if ($LeftDigit[$NumZero] == 4) {
            $left_text_color_l = array(0, 1, 0, 0, 0, 1, 1);
            $left_text_color_g = array(0, 0, 1, 1, 1, 0, 1);
        }
        if ($LeftDigit[$NumZero] == 5) {
            $left_text_color_l = array(0, 1, 1, 0, 0, 0, 1);
            $left_text_color_g = array(0, 1, 1, 1, 0, 0, 1);
        }
        if ($LeftDigit[$NumZero] == 6) {
            $left_text_color_l = array(0, 1, 0, 1, 1, 1, 1);
            $left_text_color_g = array(0, 0, 0, 0, 1, 0, 1);
        }
        if ($LeftDigit[$NumZero] == 7) {
            $left_text_color_l = array(0, 1, 1, 1, 0, 1, 1);
            $left_text_color_g = array(0, 0, 1, 0, 0, 0, 1);
        }
        if ($LeftDigit[$NumZero] == 8) {
            $left_text_color_l = array(0, 1, 1, 0, 1, 1, 1);
            $left_text_color_g = array(0, 0, 0, 1, 0, 0, 1);
        }
        if ($LeftDigit[$NumZero] == 9) {
            $left_text_color_l = array(0, 0, 0, 1, 0, 1, 1);
            $left_text_color_g = array(0, 0, 1, 0, 1, 1, 1);
        }
        $left_text_color = $left_text_color_l;
        if ($CheckSum == 0 && $NumZero == 0) {
            $left_text_color = $left_text_color_l;
        }
        if ($CheckSum == 0 && $NumZero == 1) {
            $left_text_color = $left_text_color_l;
        }
        if ($CheckSum == 1 && $NumZero == 0) {
            $left_text_color = $left_text_color_l;
        }
        if ($CheckSum == 1 && $NumZero == 1) {
            $left_text_color = $left_text_color_g;
        }
        if ($CheckSum == 2 && $NumZero == 0) {
            $left_text_color = $left_text_color_g;
        }
        if ($CheckSum == 2 && $NumZero == 1) {
            $left_text_color = $left_text_color_l;
        }
        if ($CheckSum == 3 && $NumZero == 0) {
            $left_text_color = $left_text_color_g;
        }
        if ($CheckSum == 3 && $NumZero == 1) {
            $left_text_color = $left_text_color_g;
        }
        $InnerUPCNum = 0;
        while ($InnerUPCNum < count($left_text_color)) {
            if ($left_text_color[$InnerUPCNum] == 1) {
                imageline($imgres, $LineStart, 10, $LineStart, $LineSize, $text_color);
            }
            if ($left_text_color[$InnerUPCNum] == 0) {
                imageline($imgres, $LineStart, 10, $LineStart, $LineSize, $alt_text_color);
            }
            $LineStart += 1;
            ++$InnerUPCNum;
        }
        if ($NumZero == 0) {
            imageline($imgres, $LineStart, 10, $LineStart, $LineSize, $alt_text_color);
            $LineStart += 1;
            imageline($imgres, $LineStart, 10, $LineStart, $LineSize, $text_color);
            $LineStart += 1;
        }
        ++$NumZero;
    }
    return true;
}
