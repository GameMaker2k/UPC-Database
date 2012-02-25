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

    $FileInfo: convert.php - Last Update: 02/13/2012 Ver. 2.2.5 RC 1 - Author: cooldude2k $
*/
$File3Name = basename($_SERVER['SCRIPT_NAME']);
if ($File3Name=="convert.php"||$File3Name=="/convert.php") {
	chdir("../");
	require("./upc.php");
	exit(); }

if(!isset($upcfunctions)) { $upcfunctions = array(); }
if(!is_array($upcfunctions)) { $upcfunctions = array(); }
array_push($upcfunctions, "convert_upce_to_upca", "convert_upca_to_ean13", "convert_ean13_to_itf14", "convert_upce_to_ean13", "convert_upce_to_itf14", "convert_upca_to_itf14", "convert_ean13_to_upca", "convert_itf14_to_ean13", "convert_upca_to_upce", "convert_ean13_to_upce", "convert_itf14_to_upca", "convert_itf14_to_upce", "convert_any_to_upca", "convert_any_to_upce", "convert_any_to_ean13", "convert_any_to_itf14", "convert_any_to_ean8", "convert_ean8_to_upca", "convert_ean8_to_ean13", "convert_ean8_to_itf14", "convert_upca_to_ean8", "convert_ean13_to_ean8", "convert_itf14_to_ean8", "convert_issn8_to_issn13", "convert_issn13_to_issn8", "print_issn8", "print_issn13", "print_convert_issn8_to_issn13", "print_convert_issn13_to_issn8", "convert_isbn10_to_isbn13", "convert_isbn13_to_isbn10", "convert_isbn10_to_ean13", "convert_ean13_to_isbn10", "convert_isbn10_to_itf14", "convert_itf14_to_isbn10", "print_isbn10", "print_isbn13", "print_convert_isbn10_to_isbn13", "print_convert_isbn13_to_isbn10", "convert_ismn10_to_ismn13", "convert_ismn13_to_ismn10", "convert_ismn10_to_ean13", "convert_ean13_to_ismn10", "convert_ismn10_to_itf14", "convert_itf14_to_ismn10", "print_ismn10", "print_ismn13", "print_convert_ismn10_to_ismn13", "print_convert_ismn13_to_ismn10", "make_vw_upca", "make_vw_to_ean13", "make_vw_to_itf14", "make_coupon_upca", "make_coupon_to_ean13", "make_coupon_to_itf14");
function convert_upce_to_upca($upc) {
	if(!isset($upc)||!is_numeric($upc)) { return false; }
	if(strlen($upc)==7) { $upc = $upc.validate_upce($upc,true); }
	if(strlen($upc)>8||strlen($upc)<8) { return false; }
	if(!preg_match("/^0/", $upc)) { return false; }
	if(validate_upce($upc)===false) { return false; }
	if(preg_match("/0(\d{5})([0-3])(\d{1})/", $upc, $upc_matches)) {
	$upce_test = preg_match("/0(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})/", $upc, $upc_matches);
	if($upce_test==false) { return false; }
	if($upc_matches[6]==0) {
	$upce = "0".$upc_matches[1].$upc_matches[2].$upc_matches[6]."0000".$upc_matches[3].$upc_matches[4].$upc_matches[5].$upc_matches[7]; }
	if($upc_matches[6]==1) {
	$upce = "0".$upc_matches[1].$upc_matches[2].$upc_matches[6]."0000".$upc_matches[3].$upc_matches[4].$upc_matches[5].$upc_matches[7]; }
	if($upc_matches[6]==2) {
	$upce = "0".$upc_matches[1].$upc_matches[2].$upc_matches[6]."0000".$upc_matches[3].$upc_matches[4].$upc_matches[5].$upc_matches[7]; }
	if($upc_matches[6]==3) {
	$upce = "0".$upc_matches[1].$upc_matches[2].$upc_matches[3]."00000".$upc_matches[4].$upc_matches[5].$upc_matches[7]; } }
	if(preg_match("/0(\d{5})([4-9])(\d{1})/", $upc, $upc_matches)) {
	preg_match("/0(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})/", $upc, $upc_matches);
	if($upc_matches[6]==4) {
	$upce = "0".$upc_matches[1].$upc_matches[2].$upc_matches[3].$upc_matches[4]."00000".$upc_matches[5].$upc_matches[7]; }
	if($upc_matches[6]==5) {
	$upce = "0".$upc_matches[1].$upc_matches[2].$upc_matches[3].$upc_matches[4].$upc_matches[5]."0000".$upc_matches[6].$upc_matches[7]; }
	if($upc_matches[6]==6) {
	$upce = "0".$upc_matches[1].$upc_matches[2].$upc_matches[3].$upc_matches[4].$upc_matches[5]."0000".$upc_matches[6].$upc_matches[7]; }
	if($upc_matches[6]==7) {
	$upce = "0".$upc_matches[1].$upc_matches[2].$upc_matches[3].$upc_matches[4].$upc_matches[5]."0000".$upc_matches[6].$upc_matches[7]; }
	if($upc_matches[6]==8) {
	$upce = "0".$upc_matches[1].$upc_matches[2].$upc_matches[3].$upc_matches[4].$upc_matches[5]."0000".$upc_matches[6].$upc_matches[7]; }
	if($upc_matches[6]==9) {
	$upce = "0".$upc_matches[1].$upc_matches[2].$upc_matches[3].$upc_matches[4].$upc_matches[5]."0000".$upc_matches[6].$upc_matches[7]; } }
	return $upce; }
function convert_upca_to_ean13($upc) {
	if(!isset($upc)||!is_numeric($upc)) { return false; }
	if(strlen($upc)==11) { $upc = $upc.validate_upca($upc,true); }
	if(strlen($upc)>13||strlen($upc)<12) { return false; }
	if(validate_upca($upc)===false) { return false; }
	if(strlen($upc)==12) { $ean13 = "0".$upc; }
	if(strlen($upc)==13) { $ean13 = $upc; }
	return $ean13; }
function convert_ean13_to_itf14($upc) {
	if(!isset($upc)||!is_numeric($upc)) { return false; }
	if(strlen($upc)==11) { $upc = $upc.validate_upca($upc,true); }
	if(strlen($upc)==12) { $upc = "0".$upc; }
	if(strlen($upc)>14||strlen($upc)<13) { return false; }
	if(validate_ean13($upc)===false) { return false; }
	if(strlen($upc)==13) { $itf14 = "0".$upc; }
	if(strlen($upc)==14) { $itf14 = $upc; }
	return $itf14; }
function convert_upce_to_ean13($upc) {
	return convert_upca_to_ean13(convert_upce_to_upca($upc)); }
function convert_upce_to_itf14($upc) {
	return convert_ean13_to_itf14(convert_upce_to_ean13($upc)); }
function convert_upca_to_itf14($upc) {
	return convert_ean13_to_itf14(convert_upca_to_ean13($upc)); }
function convert_ean13_to_upca($upc) {
	if(!isset($upc)||!is_numeric($upc)) { return false; }
	if(strlen($upc)==12) { $upc = "0".$upc; }
	if(strlen($upc)>13||strlen($upc)<13) { return false; }
	if(validate_ean13($upc)===false) { return false; }
	if(!preg_match("/^0(\d{12})/", $upc, $upc_matches)) {
	return false; }
	if(preg_match("/^0(\d{12})/", $upc, $upc_matches)) {
	$upca = $upc_matches[1]; }
	return $upca; }
function convert_itf14_to_ean13($upc) {
	if(!isset($upc)||!is_numeric($upc)) { return false; }
	if(strlen($upc)==13) { $upc = "0".$upc; }
	if(strlen($upc)>14||strlen($upc)<14) { return false; }
	if(validate_itf14($upc)===false) { return false; }
	if(!preg_match("/^(\d{1})(\d{12})(\d{1})/", $upc, $upc_matches)) {
	return false; }
	if(preg_match("/^(\d{1})(\d{12})(\d{1})/", $upc, $upc_matches)) {
	$ean13 = $upc_matches[2].validate_ean13($upc_matches[2], true); }
	return $ean13; }
function convert_upca_to_upce($upc) {
	if(!isset($upc)||!is_numeric($upc)) { return false; }
	if(strlen($upc)==11) { $upc = $upc.validate_upca($upc,true); }
	if(strlen($upc)>12||strlen($upc)<12) { return false; }
	if(validate_upca($upc)===false) { return false; }
	if(!preg_match("/0(\d{11})/", $upc)) { return false; }
	$upce = null;
	if(preg_match("/0(\d{2})00000(\d{3})(\d{1})/", $upc, $upc_matches)) {
	$upce = "0".$upc_matches[1].$upc_matches[2]."0";
	$upce = $upce.$upc_matches[3]; return $upce; }
	if(preg_match("/0(\d{2})10000(\d{3})(\d{1})/", $upc, $upc_matches)) {
	$upce = "0".$upc_matches[1].$upc_matches[2]."1";
	$upce = $upce.$upc_matches[3]; return $upce; }
	if(preg_match("/0(\d{2})20000(\d{3})(\d{1})/", $upc, $upc_matches)) {
	$upce = "0".$upc_matches[1].$upc_matches[2]."2";
	$upce = $upce.$upc_matches[3]; return $upce; }
	if(preg_match("/0(\d{3})00000(\d{2})(\d{1})/", $upc, $upc_matches)) {
	$upce = "0".$upc_matches[1].$upc_matches[2]."3";
	$upce = $upce.$upc_matches[3]; return $upce; }
	if(preg_match("/0(\d{4})00000(\d{1})(\d{1})/", $upc, $upc_matches)) {
	$upce = "0".$upc_matches[1].$upc_matches[2]."4";
	$upce = $upce.$upc_matches[3]; return $upce; }
	if(preg_match("/0(\d{5})00005(\d{1})/", $upc, $upc_matches)) {
	$upce = "0".$upc_matches[1]."5";
	$upce = $upce.$upc_matches[2]; return $upce; }
	if(preg_match("/0(\d{5})00006(\d{1})/", $upc, $upc_matches)) {
	$upce = "0".$upc_matches[1]."6";
	$upce = $upce.$upc_matches[2]; return $upce; }
	if(preg_match("/0(\d{5})00007(\d{1})/", $upc, $upc_matches)) {
	$upce = "0".$upc_matches[1]."7";
	$upce = $upce.$upc_matches[2]; return $upce; }
	if(preg_match("/0(\d{5})00008(\d{1})/", $upc, $upc_matches)) {
	$upce = "0".$upc_matches[1]."8";
	$upce = $upce.$upc_matches[2]; return $upce; }
	if(preg_match("/0(\d{5})00009(\d{1})/", $upc, $upc_matches)) {
	$upce = "0".$upc_matches[1]."9";
	$upce = $upce.$upc_matches[2]; return $upce; }
	if($upce==null) { return false; }
	return $upce; }
function convert_ean13_to_upce($upc) {
	return convert_upca_to_upce(convert_ean13_to_upca($upc)); }
function convert_itf14_to_upca($upc) {
	return convert_ean13_to_upca(convert_itf14_to_ean13($upc)); }
function convert_itf14_to_upce($upc) {
	return convert_upca_to_upce(convert_itf14_to_upca($upc)); }
function convert_any_to_upca($upc) {
	if(strlen($upc)==8) { 
	return convert_upce_to_upca($upc)."\n"; }
	if(strlen($upc)==13) { 
	return convert_ean13_to_upce($upc)."\n"; }
	if(strlen($upc)==14) { 
	return convert_itf14_to_upce($upc)."\n"; }
	return false; }
function convert_any_to_upce($upc) {
	if(strlen($upc)==12) { 
	return convert_upca_to_upce($upc)."\n"; }
	if(strlen($upc)==13) { 
	return convert_ean13_to_upca($upc)."\n"; }
	if(strlen($upc)==14) { 
	return convert_itf14_to_upca($upc)."\n"; }
	return false; }
function convert_any_to_ean13($upc) {
	if(strlen($upc)==8) { 
	return convert_upce_to_ean13($upc)."\n"; }
	if(strlen($upc)==12) { 
	return convert_upca_to_ean13($upc)."\n"; }
	if(strlen($upc)==14) { 
	return convert_itf14_to_ean13($upc)."\n"; }
	return false; }
function convert_any_to_itf14($upc) {
	if(strlen($upc)==8) { 
	return convert_upce_to_itf14($upc)."\n"; }
	if(strlen($upc)==12) { 
	return convert_upca_to_itf14($upc)."\n"; }
	if(strlen($upc)==13) { 
	return convert_ean13_to_itf14($upc)."\n"; }
	return false; }
function convert_any_to_ean8($upc) {
	if(strlen($upc)==12) { 
	return convert_upca_to_ean8($upc)."\n"; }
	if(strlen($upc)==13) { 
	return convert_ean13_to_ean8($upc)."\n"; }
	if(strlen($upc)==14) { 
	return convert_itf14_to_ean8($upc)."\n"; }
	return false; }
/*
Changing a EAN-8 code to UPC-A and EAN-13 based on whats used at: 
http://www.upcdatabase.com/
*/
function convert_ean8_to_upca($upc) {
	if(!isset($upc)||!is_numeric($upc)) { return false; }
	if(strlen($upc)==7) { $upc = $upc.validate_ean8($upc,true); }
	if(strlen($upc)>8||strlen($upc)<8) { return false; }
	if(validate_ean8($upc)===false) { return false; }
	$upca = "0000".$upc; 
	return $upca; }
function convert_ean8_to_ean13($upc) {
	return convert_upca_to_ean13(convert_ean8_to_upca($upc)); }
function convert_ean8_to_itf14($upc) {
	return convert_ean13_to_itf14(convert_ean8_to_ean13($upc)); }
function convert_upca_to_ean8($upc) {
	if(!isset($upc)||!is_numeric($upc)) { return false; }
	if(strlen($upc)==11) { $upc = $upc.validate_upca($upc,true); }
	if(strlen($upc)>12||strlen($upc)<12) { return false; }
	if(validate_upca($upc)===false) { return false; }
	if(!preg_match("/^0000(\d{8})/", $upc, $upc_matches)) {
	return false; }
	if(preg_match("/^0000(\d{8})/", $upc, $upc_matches)) {
	$ean8 = $upc_matches[1]; }
	return $ean8; }
function convert_ean13_to_ean8($upc) {
	return convert_upca_to_ean8(convert_ean13_to_upca($upc)); }
function convert_itf14_to_ean8($upc) {
	return convert_ean13_to_ean8(convert_itf14_to_ean13($upc)); }
/*
ISSN (International Standard Serial Number)
http://en.wikipedia.org/wiki/International_Standard_Serial_Number
*/
function convert_issn8_to_issn13($upc) {
	$upc = str_replace("-", "", $upc);
	$upc = str_replace(" ", "", $upc);
	$upc = str_replace("X", "", $upc);
	if(validate_issn8($upc)===false) { return false; }
	if(strlen($upc)>7) { preg_match("/^(\d{7})/", $upc, $fix_matches); $upc = $fix_matches[1]; }
	$issn13 = "977".$upc."00".validate_ean13("977".$upc."00",true); 
	return $issn13; }
function convert_issn13_to_issn8($upc) {
	$upc = str_replace("-", "", $upc);
	$upc = str_replace(" ", "", $upc);
	$upc = str_replace("X", "", $upc);
	if(validate_ean13($upc)===false) { return false; }
	if(!preg_match("/^977(\d{7})/", $upc, $upc_matches)) {
	return false; }
	if(preg_match("/^977(\d{7})/", $upc, $upc_matches)) {
	$issn8 = $upc_matches[1].validate_issn8($upc_matches[1],true); }
	return $issn8; }
function print_issn8($upc) {
	if(strlen($upc)>8) { preg_match("/^(\d{8})/", $upc, $fix_matches); $upc = $fix_matches[1]; }
	if(strlen($upc)>8||strlen($upc)<8) { return false; }
	if(!preg_match("/^(\d{4})(\d{4})/", $upc, $issn_matches)) {
	return false; }
	$issn8 = $issn_matches[1]."-".$issn_matches[2];
	return $issn8; }
function print_issn13($upc) {
	if(strlen($upc)>13) { preg_match("/^(\d{13})/", $upc, $fix_matches); $upc = $fix_matches[1]; }
	if(strlen($upc)>13||strlen($upc)<13) { return false; }
	if(!preg_match("/^(\d{3})(\d{4})(\d{4})(\d{2})/", $upc, $issn_matches)) {
	return false; }
	$issn13 = $issn_matches[1]."-".$issn_matches[2]."-".$issn_matches[3]."-".$issn_matches[4];
	return $issn13; }
function print_convert_issn8_to_issn13($upc) {
	$issn13 = print_issn13(convert_issn8_to_issn13($upc));
	return $issn13; }
function print_convert_issn13_to_issn8($upc) {
	$issn8 = print_issn8(convert_issn13_to_issn8($upc));
	return $issn8; }
/*
ISBN (International Standard Book Number)
http://en.wikipedia.org/wiki/ISBN
*/
function convert_isbn10_to_isbn13($upc) {
	$upc = str_replace("-", "", $upc);
	$upc = str_replace(" ", "", $upc);
	if(validate_isbn10($upc)===false) { return false; }
	if(strlen($upc)>9) { preg_match("/^(\d{9})/", $upc, $fix_matches); $upc = $fix_matches[1]; }
	$isbn13 = "978".$upc.validate_ean13("978".$upc,true); 
	return $isbn13; }
function convert_isbn13_to_isbn10($upc) {
	$upc = str_replace("-", "", $upc);
	$upc = str_replace(" ", "", $upc);
	if(validate_ean13($upc)===false) { return false; }
	if(!preg_match("/^978(\d{9})/", $upc, $upc_matches)) {
	return false; }
	if(preg_match("/^978(\d{9})/", $upc, $upc_matches)) {
	$isbn10 = $upc_matches[1].validate_isbn10($upc_matches[1],true); }
	return $isbn10; }
function convert_isbn10_to_ean13($upc) {
	return convert_isbn10_to_isbn13($upc); }
function convert_ean13_to_isbn10($upc) {
	return convert_isbn13_to_isbn10($upc); }
function convert_isbn10_to_itf14($upc) {
	return convert_ean13_to_itf14(convert_isbn10_to_isbn13($upc)); }
function convert_itf14_to_isbn10($upc) {
	return convert_itf14_to_ean13(convert_isbn13_to_isbn10($upc)); }
function print_isbn10($upc) {
	if(strlen($upc)>10) { preg_match("/^(\d{9})(\d{1}|X{1})/", $upc, $fix_matches); $upc = $fix_matches[1].$fix_matches[2]; }
	if(strlen($upc)>10||strlen($upc)<10) { return false; }
	if(!preg_match("/^(\d{1})(\d{3})(\d{5})(\d{1}|X{1})/", $upc, $isbn_matches)) {
	return false; }
	$isbn10 = $isbn_matches[1]."-".$isbn_matches[2]."-".$isbn_matches[3]."-".$isbn_matches[4];
	return $isbn10; }
function print_isbn13($upc) {
	if(strlen($upc)>13) { preg_match("/^(\d{13})/", $upc, $fix_matches); $upc = $fix_matches[1]; }
	if(strlen($upc)>13||strlen($upc)<13) { return false; }
	if(!preg_match("/^(\d{3})(\d{1})(\d{3})(\d{5})(\d{1})/", $upc, $isbn_matches)) {
	return false; }
	$isbn13 = $isbn_matches[1]."-".$isbn_matches[2]."-".$isbn_matches[3]."-".$isbn_matches[4]."-".$isbn_matches[5];
	return $isbn13; }
function print_convert_isbn10_to_isbn13($upc) {
	$isbn13 = print_isbn13(convert_isbn10_to_isbn13($upc));
	return $isbn13; }
function print_convert_isbn13_to_isbn10($upc) {
	$isbn10 = print_isbn10(convert_isbn13_to_isbn10($upc));
	return $isbn10; }
/*
ISMN (International Standard Music Number)
http://en.wikipedia.org/wiki/International_Standard_Music_Number
http://www.ismn-international.org/whatis.html
http://www.ismn-international.org/manual_1998/chapter2.html
*/
function convert_ismn10_to_ismn13($upc) {
	$upc = str_replace("M", "", $upc);
	$upc = str_replace("-", "", $upc);
	$upc = str_replace(" ", "", $upc);
	if(validate_ismn10($upc)===false) { return false; }
	if(strlen($upc)>8) { preg_match("/^(\d{8})/", $upc, $fix_matches); $upc = $fix_matches[1]; }
	$ismn13 = "9790".$upc.validate_ean13("9790".$upc,true); 
	return $ismn13; }
function convert_ismn13_to_ismn10($upc) {
	$upc = str_replace("M", "", $upc);
	$upc = str_replace("-", "", $upc);
	$upc = str_replace(" ", "", $upc);
	if(validate_ean13($upc)===false) { return false; }
	if(!preg_match("/^9790(\d{8})/", $upc, $upc_matches)) {
	return false; }
	if(preg_match("/^9790(\d{8})/", $upc, $upc_matches)) {
	$ismn10 = $upc_matches[1].validate_ismn10($upc_matches[1],true); }
	return $ismn10; }
function convert_ismn10_to_ean13($upc) {
	return convert_ismn10_to_ismn13($upc); }
function convert_ean13_to_ismn10($upc) {
	return convert_ismn13_to_ismn10($upc); }
function convert_ismn10_to_itf14($upc) {
	return convert_ean13_to_itf14(convert_ismn10_to_ismn13($upc)); }
function convert_itf14_to_ismn10($upc) {
	return convert_itf14_to_ean13(convert_ismn13_to_ismn10($upc)); }
function print_ismn10($upc) {
	$upc = str_replace("M", "", $upc);
	if(strlen($upc)>9) { preg_match("/^(\d{9})/", $upc, $fix_matches); $upc = $fix_matches[1]; }
	if(strlen($upc)>9||strlen($upc)<9) { return false; }
	if(!preg_match("/^(\d{4})(\d{4})(\d{1})/", $upc, $ismn_matches)) {
	return false; }
	$ismn10 = "M-".$ismn_matches[1]."-".$ismn_matches[2]."-".$ismn_matches[3];
	return $ismn10; }
function print_ismn13($upc) {
	if(strlen($upc)>13) { preg_match("/^(\d{13})/", $upc, $fix_matches); $upc = $fix_matches[1]; }
	if(strlen($upc)>13||strlen($upc)<13) { return false; }
	if(!preg_match("/^(\d{3})(\d{1})(\d{4})(\d{4})(\d{1})/", $upc, $ismn_matches)) {
	return false; }
	$ismn13 = $ismn_matches[1]."-".$ismn_matches[2]."-".$ismn_matches[3]."-".$ismn_matches[4]."-".$ismn_matches[5];
	return $ismn13; }
function print_convert_ismn10_to_ismn13($upc) {
	$ismn13 = print_ismn13(convert_ismn10_to_ismn13($upc));
	return $ismn13; }
function print_convert_ismn13_to_ismn10($upc) {
	$ismn10 = print_ismn10(convert_ismn13_to_ismn10($upc));
	return $ismn10; }
// Get variable weight price checksum
// Source: http://wiki.answers.com/Q/How_does_a_price_embedded_bar_code_work
// Source: http://en.wikipedia.org/wiki/Universal_Product_Code#Prefixes
// Source: http://barcodes.gs1us.org/GS1%20US%20BarCodes%20and%20eCom%20-%20The%20Global%20Language%20of%20Business.htm
function make_vw_upca($code, $price) {
	if(strlen($price)>5) {
	if(preg_match("/^(\d{5})/", $code, $code_matches)) { $code = $code_matches[1]; } }
	$pricecs = get_vw_price_checksum($price);
	$vwupc = "207362".$pricecs.$price;
	$vwupc = $vwupc.validate_upca($vwupc, true);
	return $vwupc; }
function make_vw_to_ean13($code, $price) {
	$vwean13 = convert_upca_to_ean13(make_vw_upca($code, $price));
	return $vwean13; }
function make_vw_to_itf14($code, $price) {
	$vwitf14 = convert_upca_to_itf14(make_vw_upca($code, $price));
	return $vwitf14; }
function make_coupon_upca($numbersystem, $manufacturer, $family, $value) {
	if($numbersystem!=5&&$numbersystem!=9) { $numbersystem = 5; }
	if(strlen($upc)>5) { preg_match("/^(\d{5})/", $upc, $fix_matches); $upc = $fix_matches[1]; }
	if(strlen($upc)>3) { preg_match("/^(\d{3})/", $upc, $fix_matches); $upc = $fix_matches[1]; }
	if(strlen($upc)>2) { preg_match("/^(\d{2})/", $upc, $fix_matches); $upc = $fix_matches[1]; }
	$couponupca = $numbersystem.$manufacturer.$family.$value;
	$couponupca = $couponupca.validate_upca($couponupca, true);
	return $couponupca; }
function make_coupon_to_ean13($numbersystem, $manufacturer, $family, $value) {
	$couponean13 = convert_upca_to_ean13(make_coupon_upca($numbersystem, $manufacturer, $family, $value));
	return $couponean13; }
function make_coupon_to_itf14($numbersystem, $manufacturer, $family, $value) {
	$couponitf14 = convert_upca_to_itf14(make_coupon_upca($numbersystem, $manufacturer, $family, $value));
	return $couponitf14; }
?>