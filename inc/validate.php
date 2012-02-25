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

    $FileInfo: validate.php - Last Update: 02/13/2012 Ver. 2.2.5 RC 1 - Author: cooldude2k $
*/
$File3Name = basename($_SERVER['SCRIPT_NAME']);
if ($File3Name=="validate.php"||$File3Name=="/validate.php") {
	chdir("../");
	require("./upc.php");
	exit(); }

if(!isset($upcfunctions)) { $upcfunctions = array(); }
if(!is_array($upcfunctions)) { $upcfunctions = array(); }
array_push($upcfunctions, "validate_upca", "fix_upca_checksum", "validate_ean13", "fix_ean13_checksum", "validate_itf14", "fix_itf14_checksum", "validate_ean8", "validate_ean8", "validate_upce", "fix_upce_checksum", "validate_issn8", "fix_issn8_checksum", "validate_issn13", "fix_issn13_checksum", "validate_isbn10", "fix_isbn10_checksum", "validate_isbn13", "fix_isbn13_checksum", "validate_ismn10", "fix_ismn10_checksum", "validate_ismn13", "fix_ismn13_checksum", "get_vw_price_checksum", "fix_vw_price_checksum");
function validate_upca($upc,$return_check=false) {
	if(!isset($upc)||!is_numeric($upc)) { return false; }
	if(strlen($upc)>12) { preg_match("/^(\d{12})/", $upc, $fix_matches); $upc = $fix_matches[1]; }
	if(strlen($upc)>12||strlen($upc)<11) { return false; }
	if(strlen($upc)==11) {
	preg_match("/^(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})/", $upc, $upc_matches); }
	if(strlen($upc)==12) {
	preg_match("/^(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})/", $upc, $upc_matches); }
	$OddSum = ($upc_matches[1] + $upc_matches[3] + $upc_matches[5] + $upc_matches[7] + $upc_matches[9] + $upc_matches[11]) * 3;
	$EvenSum = $upc_matches[2] + $upc_matches[4] + $upc_matches[6] + $upc_matches[8] + $upc_matches[10];
	$AllSum = $OddSum + $EvenSum;
	$CheckSum = $AllSum % 10;
	if($CheckSum>0) {
	$CheckSum = 10 - $CheckSum; }
	if($return_check==false&&strlen($upc)==12) {
	if($CheckSum!=$upc_matches[12]) { return false; }
	if($CheckSum==$upc_matches[12]) { return true; } }
	if($return_check==true) { return $CheckSum; } 
	if(strlen($upc)==11) { return $CheckSum; } }
function fix_upca_checksum($upc) {
	if(strlen($upc)>11) { preg_match("/^(\d{11})/", $upc, $fix_matches); $upc = $fix_matches[1]; }
	return $upc.validate_upca($upc,true); }
function validate_ean13($upc,$return_check=false) {
	if(!isset($upc)||!is_numeric($upc)) { return false; }
	if(strlen($upc)>13) { preg_match("/^(\d{13})/", $upc, $fix_matches); $upc = $fix_matches[1]; }
	if(strlen($upc)>13||strlen($upc)<12) { return false; }
	if(strlen($upc)==12) {
	preg_match("/^(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})/", $upc, $upc_matches); }
	if(strlen($upc)==13) {
	preg_match("/^(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})/", $upc, $upc_matches); }
	$EvenSum = ($upc_matches[2] + $upc_matches[4] + $upc_matches[6] + $upc_matches[8] + $upc_matches[10] + $upc_matches[12]) * 3;
	$OddSum = $upc_matches[1] + $upc_matches[3] + $upc_matches[5] + $upc_matches[7] + $upc_matches[9] + $upc_matches[11];
	$AllSum = $OddSum + $EvenSum;
	$CheckSum = $AllSum % 10;
	if($CheckSum>0) {
	$CheckSum = 10 - $CheckSum; }
	if($return_check==false&&strlen($upc)==13) {
	if($CheckSum!=$upc_matches[13]) { return false; }
	if($CheckSum==$upc_matches[13]) { return true; } }
	if($return_check==true) { return $CheckSum; }
	if(strlen($upc)==12) { return $CheckSum; } }
function fix_ean13_checksum($upc) {
	if(strlen($upc)>12) { preg_match("/^(\d{12})/", $upc, $fix_matches); $upc = $fix_matches[1]; }
	return $upc.validate_ean13($upc,true); }
function validate_itf14($upc,$return_check=false) {
	if(!isset($upc)||!is_numeric($upc)) { return false; }
	if(strlen($upc)>14) { preg_match("/^(\d{14})/", $upc, $fix_matches); $upc = $fix_matches[1]; }
	if(strlen($upc)>14||strlen($upc)<13) { return false; }
	if(strlen($upc)==13) {
	preg_match("/^(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})/", $upc, $upc_matches); }
	if(strlen($upc)==14) {
	preg_match("/^(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})/", $upc, $upc_matches); }
	$EvenSum = $upc_matches[2] + $upc_matches[4] + $upc_matches[6] + $upc_matches[8] + $upc_matches[10] + $upc_matches[12];
	$OddSum = ($upc_matches[1] + $upc_matches[3] + $upc_matches[5] + $upc_matches[7] + $upc_matches[9] + $upc_matches[11] + $upc_matches[13]) * 3;
	$AllSum = $OddSum + $EvenSum;
	$CheckSum = $AllSum % 10;
	if($CheckSum>0) {
	$CheckSum = 10 - $CheckSum; }
	if($return_check==false&&strlen($upc)==14) {
	if($CheckSum!=$upc_matches[14]) { return false; }
	if($CheckSum==$upc_matches[14]) { return true; } }
	if($return_check==true) { return $CheckSum; }
	if(strlen($upc)==13) { return $CheckSum; } }
function fix_itf14_checksum($upc) {
	if(strlen($upc)>13) { preg_match("/^(\d{13})/", $upc, $fix_matches); $upc = $fix_matches[1]; }
	return $upc.validate_itf14($upc,true); }
function validate_ean8($upc,$return_check=false) {
	if(!isset($upc)||!is_numeric($upc)) { return false; }
	if(strlen($upc)>8) { preg_match("/^(\d{8})/", $upc, $fix_matches); $upc = $fix_matches[1]; }
	if(strlen($upc)>8||strlen($upc)<7) { return false; }
	if(strlen($upc)==7) {
	preg_match("/^(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})/", $upc, $upc_matches); }
	if(strlen($upc)==8) {
	preg_match("/^(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})/", $upc, $upc_matches); }
	$EvenSum = ($upc_matches[1] + $upc_matches[3] + $upc_matches[5] + $upc_matches[7]) * 3;
	$OddSum = $upc_matches[2] + $upc_matches[4] + $upc_matches[6];
	$AllSum = $OddSum + $EvenSum;
	$CheckSum = $AllSum % 10;
	if($CheckSum>0) {
	$CheckSum = 10 - $CheckSum; }
	if($return_check==false&&strlen($upc)==8) {
	if($CheckSum!=$upc_matches[8]) { return false; }
	if($CheckSum==$upc_matches[8]) { return true; } }
	if($return_check==true) { return $CheckSum; }
	if(strlen($upc)==7) { return $CheckSum; } }
function fix_ean8_checksum($upc) {
	if(strlen($upc)>7) { preg_match("/^(\d{7})/", $upc, $fix_matches); $upc = $fix_matches[1]; }
	return $upc.validate_ean8($upc,true); }
function validate_upce($upc,$return_check=false) {
	if(!isset($upc)||!is_numeric($upc)) { return false; }
	if(strlen($upc)>8) { preg_match("/^(\d{8})/", $upc, $fix_matches); $upc = $fix_matches[1]; }
	if(strlen($upc)>8||strlen($upc)<7) { return false; }
	if(!preg_match("/^0/", $upc)) { return false; }
	$CheckDigit = null;
	if(strlen($upc)==8&&preg_match("/^(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})/", $upc, $upc_matches)) {
	preg_match("/^(\d{7})(\d{1})/", $upc, $upc_matches);
	$CheckDigit = $upc_matches[2]; }
	if(preg_match("/^(\d{1})(\d{5})([0-3])/", $upc, $upc_matches)) {
	preg_match("/^(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})/", $upc, $upc_matches);
	if($upc_matches[7]==0) {
	$OddSum = (0 + $upc_matches[3] + 0 + 0 + $upc_matches[4] + $upc_matches[6]) * 3;
	$EvenSum = $upc_matches[2] + 0 + 0 + 0 + $upc_matches[5]; }
	if($upc_matches[7]==1) {
	$OddSum = (0 + $upc_matches[3] + 0 + 0 + $upc_matches[4] + $upc_matches[6]) * 3;
	$EvenSum = $upc_matches[2] + 1 + 0 + 0 + $upc_matches[5]; }
	if($upc_matches[7]==2) {
	$OddSum = (0 + $upc_matches[3] + 0 + 0 + $upc_matches[4] + $upc_matches[6]) * 3;
	$EvenSum = $upc_matches[2] + 2 + 0 + 0 + $upc_matches[5]; }
	if($upc_matches[7]==3) {
	$OddSum = (0 + $upc_matches[3] + 0 + 0 + 0 + $upc_matches[6]) * 3;
	$EvenSum = $upc_matches[2] + $upc_matches[4] + 0 + 0 + $upc_matches[5]; } }
	if(preg_match("/^(\d{1})(\d{5})([4-9])/", $upc, $upc_matches)) {
	preg_match("/^(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})/", $upc, $upc_matches);
	if($upc_matches[7]==4) {
	$OddSum = (0 + $upc_matches[3] + $upc_matches[5] + 0 + 0 + $upc_matches[6]) * 3;
	$EvenSum = $upc_matches[2] + $upc_matches[4] + 0 + 0 + 0; }
	if($upc_matches[7]==5) {
	$OddSum = (0 + $upc_matches[3] + $upc_matches[5] + 0 + 0 + $upc_matches[7]) * 3;
	$EvenSum = $upc_matches[2] + $upc_matches[4] + $upc_matches[6] + 0 + 0; }
	if($upc_matches[7]==6) {
	$OddSum = (0 + $upc_matches[3] + $upc_matches[5] + 0 + 0 + $upc_matches[7]) * 3;
	$EvenSum = $upc_matches[2] + $upc_matches[4] + $upc_matches[6] + 0 + 0; }
	if($upc_matches[7]==7) {
	$OddSum = (0 + $upc_matches[3] + $upc_matches[5] + 0 + 0 + $upc_matches[7]) * 3;
	$EvenSum = $upc_matches[2] + $upc_matches[4] + $upc_matches[6] + 0 + 0; }
	if($upc_matches[7]==8) {
	$OddSum = (0 + $upc_matches[3] + $upc_matches[5] + 0 + 0 + $upc_matches[7]) * 3;
	$EvenSum = $upc_matches[2] + $upc_matches[4] + $upc_matches[6] + 0 + 0; }
	if($upc_matches[7]==9) {
	$OddSum = (0 + $upc_matches[3] + $upc_matches[5] + 0 + 0 + $upc_matches[7]) * 3;
	$EvenSum = $upc_matches[2] + $upc_matches[4] + $upc_matches[6] + 0 + 0; } }
	$AllSum = $OddSum + $EvenSum;
	$CheckSum = $AllSum % 10;
	if($CheckSum>0) {
	$CheckSum = 10 - $CheckSum; }
	if($return_check==false&&strlen($upc)==8) {
	if($CheckSum!=$CheckDigit) { return false; }
	if($CheckSum==$CheckDigit) { return true; } }
	if($return_check==true) { return $CheckSum; } 
	if(strlen($upc)==7) { return $CheckSum; } }
function fix_upce_checksum($upc) {
	if(strlen($upc)>7) { preg_match("/^(\d{7})/", $upc, $fix_matches); $upc = $fix_matches[1]; }
	return $upc.validate_upce($upc,true); }
/*
ISSN (International Standard Serial Number)
http://en.wikipedia.org/wiki/International_Standard_Serial_Number
*/
function validate_issn8($upc,$return_check=false) {
	$upc = str_replace("-", "", $upc);
	$upc = str_replace(" ", "", $upc);
	if(!isset($upc)||!is_numeric($upc)) { return false; }
	if(strlen($upc)>8) { preg_match("/^(\d{8})/", $upc, $fix_matches); $upc = $fix_matches[1].$fix_matches[2]; }
	if(strlen($upc)>8||strlen($upc)<7) { return false; }
	if(strlen($upc)==7) {
	preg_match("/^(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})/", $upc, $upc_matches); }
	if(strlen($upc)==8) {
	preg_match("/^(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})/", $upc, $upc_matches); }
	$AllSum = ($upc_matches[1] * 8) + ($upc_matches[2] * 7) + ($upc_matches[3] * 6) + ($upc_matches[4] * 5) + ($upc_matches[5] * 4) + ($upc_matches[6] * 3) + ($upc_matches[7] * 2);
	$CheckSum = $AllSum % 11;
	if($CheckSum>0) {
	$CheckSum = 11 - $CheckSum; }
	if($return_check==false&&strlen($upc)==8) {
	if($CheckSum!=$upc_matches[8]) { return false; }
	if($CheckSum==$upc_matches[8]) { return true; } }
	if($return_check==true) { return $CheckSum; } 
	if(strlen($upc)==7) { return $CheckSum; } }
function fix_issn8_checksum($upc) {
	$upc = str_replace("-", "", $upc);
	$upc = str_replace(" ", "", $upc);
	if(strlen($upc)>7) { preg_match("/^(\d{7})/", $upc, $fix_matches); $upc = $fix_matches[1]; }
	return $upc.validate_issn8($upc,true); }
function validate_issn13($upc,$return_check=false) {
	if(!preg_match("/^977(\d{9})/", $upc, $upc_matches)) {
	return false; }
	if(preg_match("/^977(\d{9})/", $upc, $upc_matches)) {
	return validate_ean13($upc,$return_check); } }
function fix_issn13_checksum($upc) {
	if(!preg_match("/^977(\d{9})/", $upc, $upc_matches)) {
	return false; }
	if(preg_match("/^977(\d{9})/", $upc, $upc_matches)) {
	return fix_ean13_checksum($upc); } }
/*
ISBN (International Standard Book Number)
http://en.wikipedia.org/wiki/ISBN
*/
function validate_isbn10($upc,$return_check=false) {
	$upc = str_replace("-", "", $upc);
	$upc = str_replace(" ", "", $upc);
	if(!isset($upc)) { return false; }
	if(strlen($upc)>10) { preg_match("/^(\d{9})(\d{1}|X{1})/", $upc, $fix_matches); $upc = $fix_matches[1].$fix_matches[2]; }
	if(strlen($upc)>10||strlen($upc)<9) { return false; }
	if(strlen($upc)==9) {
	preg_match("/^(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})/", $upc, $upc_matches); }
	if(strlen($upc)==10) {
	preg_match("/^(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1}|X{1})/", $upc, $upc_matches); }
	$AllSum = ($upc_matches[1] * 10) + ($upc_matches[2] * 9) + ($upc_matches[3] * 8) + ($upc_matches[4] * 7) + ($upc_matches[5] * 6) + ($upc_matches[6] * 5) + ($upc_matches[7] * 4) + ($upc_matches[8] * 3) + ($upc_matches[9] * 2);
	$CheckSum = 1;
	while(($AllSum + ($CheckSum * 1)) % 11) {
	++$CheckSum; }
	if($CheckSum==10) { $CheckSum = "X"; }
	if($return_check==false&&strlen($upc)==10) {
	if($CheckSum!=$upc_matches[10]) { return false; }
	if($CheckSum==$upc_matches[10]) { return true; } }
	if($return_check==true) { return $CheckSum; } 
	if(strlen($upc)==9) { return $CheckSum; } }
function fix_isbn10_checksum($upc) {
	$upc = str_replace("-", "", $upc);
	$upc = str_replace(" ", "", $upc);
	if(strlen($upc)>9) { preg_match("/^(\d{9})/", $upc, $fix_matches); $upc = $fix_matches[1]; }
	return $upc.validate_isbn10($upc,true); }
function validate_isbn13($upc,$return_check=false) {
	if(!preg_match("/^978(\d{9})/", $upc, $upc_matches)) {
	return false; }
	if(preg_match("/^978(\d{9})/", $upc, $upc_matches)) {
	return validate_ean13($upc,$return_check); } }
function fix_isbn13_checksum($upc) {
	if(!preg_match("/^978(\d{9})/", $upc, $upc_matches)) {
	return false; }
	if(preg_match("/^978(\d{9})/", $upc, $upc_matches)) {
	return fix_ean13_checksum($upc); } }
/*
ISMN (International Standard Music Number)
http://en.wikipedia.org/wiki/International_Standard_Music_Number
http://www.ismn-international.org/whatis.html
http://www.ismn-international.org/manual_1998/chapter2.html
*/
function validate_ismn10($upc,$return_check=false) {
	$upc = str_replace("M", "", $upc);
	$upc = str_replace("-", "", $upc);
	$upc = str_replace(" ", "", $upc);
	if(!isset($upc)) { return false; }
	if(strlen($upc)>9) { preg_match("/^(\d{8})(\d{1})/", $upc, $fix_matches); $upc = $fix_matches[1].$fix_matches[2]; }
	if(strlen($upc)>9||strlen($upc)<8) { return false; }
	if(strlen($upc)==8) {
	preg_match("/^(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})/", $upc, $upc_matches); }
	if(strlen($upc)==9) {
	preg_match("/^(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})/", $upc, $upc_matches); }
	$AllSum = (3 * 3) + ($upc_matches[1] * 1) + ($upc_matches[2] * 3) + ($upc_matches[3] * 1) + ($upc_matches[4] * 3) + ($upc_matches[5] * 1) + ($upc_matches[6] * 3) + ($upc_matches[7] * 1) + ($upc_matches[8] * 3);
	$CheckSum = 1;
	while(($AllSum + ($CheckSum * 1)) % 10) {
	++$CheckSum; }
	if($return_check==false&&strlen($upc)==9) {
	if($CheckSum!=$upc_matches[9]) { return false; }
	if($CheckSum==$upc_matches[9]) { return true; } }
	if($return_check==true) { return $CheckSum; } 
	if(strlen($upc)==8) { return $CheckSum; } }
function fix_ismn10_checksum($upc) {
	$upc = str_replace("M", "", $upc);
	$upc = str_replace("-", "", $upc);
	$upc = str_replace(" ", "", $upc);
	if(strlen($upc)>9) { preg_match("/^(\d{9})/", $upc, $fix_matches); $upc = $fix_matches[1]; }
	return $upc.validate_ismn10($upc,true); }
function validate_ismn13($upc,$return_check=false) {
	if(!preg_match("/^9790(\d{8})/", $upc, $upc_matches)) {
	return false; }
	if(preg_match("/^9790(\d{8})/", $upc, $upc_matches)) {
	return validate_ean13($upc,$return_check); } }
function fix_ismn13_checksum($upc) {
	if(!preg_match("/^9790(\d{8})/", $upc, $upc_matches)) {
	return false; }
	if(preg_match("/^9790(\d{8})/", $upc, $upc_matches)) {
	return fix_ean13_checksum($upc); } }
// Get variable weight price checksum
// Source: http://wiki.answers.com/Q/How_does_a_price_embedded_bar_code_work
// Source: http://en.wikipedia.org/wiki/Universal_Product_Code#Prefixes
// Source: http://barcodes.gs1us.org/GS1%20US%20BarCodes%20and%20eCom%20-%20The%20Global%20Language%20of%20Business.htm
function get_vw_price_checksum($price,$return_check=false) {
	if(strlen($price)==1) { $price = "000".$price; }
	if(strlen($price)==2) { $price = "00".$price; }
	if(strlen($price)==3) { $price = "0".$price; }
	if(strlen($price)>5) {
	if(preg_match("/^(\d{5})/", $price, $price_matches)) { $price = $price_matches[1]; } }
	$price_split = str_split($price);
	$numrep1 = array(0 => 0, 1 => 2, 2 => 4, 3 => 6, 4 => 8, 5 => 9, 6 => 1, 7 => 3, 8 => 5, 9 => 7);
	$numrep2 = array(0 => 0, 1 => 3, 2 => 6, 3 => 9, 4 => 2, 5 => 5, 6 => 8, 7 => 1, 8 => 4, 9 => 7);
	$numrep3 = array(0 => 0, 1 => 5, 2 => 9, 3 => 4, 4 => 8, 5 => 3, 6 => 7, 7 => 2, 8 => 6, 9 => 1);
	if(strlen($price)==4) {
	$price_split[0] = $numrep1[$price_split[0]];
	$price_split[1] = $numrep1[$price_split[1]];
	$price_split[2] = $numrep2[$price_split[2]];
	$price_split[3] = $numrep3[$price_split[3]]; }
	if(strlen($price)==5) {
	$price_split[1] = $numrep1[$price_split[1]];
	$price_split[2] = $numrep1[$price_split[2]];
	$price_split[3] = $numrep2[$price_split[3]];
	$price_split[4] = $numrep3[$price_split[4]]; }
	$price_add = ($price_split[0] + $price_split[1] + $price_split[2] + $price_split[3]) * 3;
	$CheckSum = $price_add % 10;
	if($return_check==false&&strlen($price)==5) {
	if($CheckSum!=$price_split[0]) { return false; }
	if($CheckSum==$price_split[0]) { return true; } }
	if($return_check==true) { return $CheckSum; } 
	if(strlen($price)==4) { return $CheckSum; }
	return $CheckSum; }
function fix_vw_price_checksum($price) {
	if(strlen($price)==5) { preg_match("/^(\d{1})(\d{4})/", $price, $fix_matches); $price = $fix_matches[2]; }
	if(strlen($price)>4) { preg_match("/^(\d{4})/", $price, $fix_matches); $price = $fix_matches[1]; }
	return get_vw_price_checksum($price,true).$price; }
?>