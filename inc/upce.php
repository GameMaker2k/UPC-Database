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

    $FileInfo: upce.php - Last Update: 02/13/2012 Ver. 2.2.5 RC 1 - Author: cooldude2k $
*/
$File3Name = basename($_SERVER['SCRIPT_NAME']);
if ($File3Name=="upce.php"||$File3Name=="/upce.php") {
	chdir("../");
	require("./upc.php");
	exit(); }

if(!isset($upcfunctions)) { $upcfunctions = array(); }
if(!is_array($upcfunctions)) { $upcfunctions = array(); }
array_push($upcfunctions, "create_upce");
function create_upce($upc,$imgtype="png",$outputimage=true,$resize=1,$resizetype="resize",$outfile=NULL,$hidecd=false) {
	if(!isset($upc)) { return false; }
	$upc_pieces = null; $supplement = null;
	if(preg_match("/([0-9]+)([ |\|]{1})([0-9]{2})$/", $upc, $upc_pieces)) {
	$upc = $upc_pieces[1]; $supplement = $upc_pieces[3]; }
	if(preg_match("/([0-9]+)([ |\|]){1}([0-9]{5})$/", $upc, $upc_pieces)) {
	$upc = $upc_pieces[1]; $supplement = $upc_pieces[3]; }
	if(!isset($upc)||!is_numeric($upc)) { return false; }
	if(strlen($upc)==12) { $upc = convert_upca_to_upce($upc); }
	if(strlen($upc)==13) { $upc = convert_ean13_to_upce($upc); }
	if(strlen($upc)==7) { $upc = $upc.validate_upce($upc,true); }
	if(strlen($upc)>8||strlen($upc)<8) { return false; }
	if(!isset($resize)||!preg_match("/^([0-9]*[\.]?[0-9])/", $resize)||$resize<1) { $resize = 1; }
	if($resizetype!="resample"&&$resizetype!="resize") { $resizetype = "resize"; }
	if(!preg_match("/^0/", $upc)) { return false; }
	if(validate_upce($upc)===false) { preg_match("/^(\d{7})/", $upc, $pre_matches); 
	$upc = $pre_matches[1].validate_upce($pre_matches[1],true); }
	if($imgtype!="png"&&$imgtype!="gif"&&$imgtype!="xbm"&&$imgtype!="wbmp") { $imgtype = "png"; }
	preg_match("/(\d{1})(\d{6})(\d{1})/", $upc, $upc_matches);
	if(count($upc_matches)<=0) { return false; }
	if($upc_matches[1]>1) { return false; }
	$PrefixDigit = $upc_matches[1];
	$LeftDigit = str_split($upc_matches[2]);
	$CheckDigit = $upc_matches[3];
	if($imgtype=="png") {
	if($outputimage==true) {
	header("Content-Type: image/png"); } }
	if($imgtype=="gif") {
	if($outputimage==true) {
	header("Content-Type: image/gif"); } }
	if($imgtype=="xbm") {
	if($outputimage==true) {
	header("Content-Type: image/x-xbitmap"); } }
	if($imgtype=="wbmp") {
	if($outputimage==true) {
	header("Content-Type: image/vnd.wap.wbmp"); } }
	$addonsize = 0;
	if(strlen($supplement)==2) { $addonsize = 29; }
	if(strlen($supplement)==5) { $addonsize = 56; }
	$upc_img = imagecreatetruecolor(69 + $addonsize, 62);
	imagefilledrectangle($upc_img, 0, 0, 69 + $addonsize, 62, 0xFFFFFF);
	imageinterlace($upc_img, true);
	$background_color = imagecolorallocate($upc_img, 255, 255, 255);
	$text_color = imagecolorallocate($upc_img, 0, 0, 0);
	$alt_text_color = imagecolorallocate($upc_img, 255, 255, 255);
	imagestring($upc_img, 2, 2, 47, $upc_matches[1], $text_color);
	imagestring($upc_img, 2, 16, 47, $upc_matches[2], $text_color);
	if($hidecd!==true) {
	imagestring($upc_img, 2, 62, 47, $upc_matches[3], $text_color); }
	imageline($upc_img, 0, 10, 0, 47, $alt_text_color);
	imageline($upc_img, 1, 10, 1, 47, $alt_text_color);
	imageline($upc_img, 2, 10, 2, 47, $alt_text_color);
	imageline($upc_img, 3, 10, 3, 47, $alt_text_color);
	imageline($upc_img, 4, 10, 4, 47, $alt_text_color);
	imageline($upc_img, 5, 10, 5, 47, $alt_text_color);
	imageline($upc_img, 6, 10, 6, 47, $alt_text_color);
	imageline($upc_img, 7, 10, 7, 47, $alt_text_color);
	imageline($upc_img, 8, 10, 8, 47, $alt_text_color);
	imageline($upc_img, 9, 10, 9, 53, $text_color);
	imageline($upc_img, 10, 10, 10, 53, $alt_text_color);
	imageline($upc_img, 11, 10, 11, 53, $text_color);
	$NumZero = 0; $LineStart = 12;
	while ($NumZero < count($LeftDigit)) {
		$LineSize = 47;
		$left_text_color = array(0, 0, 0, 0, 0, 0, 0);
		$left_text_color_odd = array(0, 0, 0, 0, 0, 0, 0);
		$left_text_color_even = array(0, 0, 0, 0, 0, 0, 0);
		if($LeftDigit[$NumZero]==0) { 
		$left_text_color_odd = array(0, 0, 0, 1, 1, 0, 1); 
		$left_text_color_even = array(0, 1, 0, 0, 1, 1, 1); }
		if($LeftDigit[$NumZero]==1) { 
		$left_text_color_odd = array(0, 0, 1, 1, 0, 0, 1); 
		$left_text_color_even = array(0, 1, 1, 0, 0, 1, 1); }
		if($LeftDigit[$NumZero]==2) { 
		$left_text_color_odd = array(0, 0, 1, 0, 0, 1, 1); 
		$left_text_color_even = array(0, 0, 1, 1, 0, 1, 1); }
		if($LeftDigit[$NumZero]==3) { 
		$left_text_color_odd = array(0, 1, 1, 1, 1, 0, 1); 
		$left_text_color_even = array(0, 1, 0, 0, 0, 0, 1); }
		if($LeftDigit[$NumZero]==4) { 
		$left_text_color_odd = array(0, 1, 0, 0, 0, 1, 1); 
		$left_text_color_even = array(0, 0, 1, 1, 1, 0, 1); }
		if($LeftDigit[$NumZero]==5) { 
		$left_text_color_odd = array(0, 1, 1, 0, 0, 0, 1); 
		$left_text_color_even = array(0, 1, 1, 1, 0, 0, 1); }
		if($LeftDigit[$NumZero]==6) { 
		$left_text_color_odd = array(0, 1, 0, 1, 1, 1, 1); 
		$left_text_color_even = array(0, 0, 0, 0, 1, 0, 1); }
		if($LeftDigit[$NumZero]==7) { 
		$left_text_color_odd = array(0, 1, 1, 1, 0, 1, 1); 
		$left_text_color_even = array(0, 0, 1, 0, 0, 0, 1); }
		if($LeftDigit[$NumZero]==8) { 
		$left_text_color_odd = array(0, 1, 1, 0, 1, 1, 1); 
		$left_text_color_even = array(0, 0, 0, 1, 0, 0, 1); }
		if($LeftDigit[$NumZero]==9) {
		$left_text_color_odd = array(0, 0, 0, 1, 0, 1, 1);
		$left_text_color_even = array(0, 0, 1, 0, 1, 1, 1); }
		$left_text_color = $left_text_color_odd;
		if($upc_matches[3]==0&&$upc_matches[1]==0) {
		if($NumZero==0) { $left_text_color = $left_text_color_even; }
		if($NumZero==1) { $left_text_color = $left_text_color_even; }
		if($NumZero==2) { $left_text_color = $left_text_color_even; } }
		if($upc_matches[3]==1&&$upc_matches[1]==0) {
		if($NumZero==0) { $left_text_color = $left_text_color_even; }
		if($NumZero==1) { $left_text_color = $left_text_color_even; }
		if($NumZero==3) { $left_text_color = $left_text_color_even; } }
		if($upc_matches[3]==2&&$upc_matches[1]==0) {
		if($NumZero==0) { $left_text_color = $left_text_color_even; }
		if($NumZero==1) { $left_text_color = $left_text_color_even; }
		if($NumZero==4) { $left_text_color = $left_text_color_even; } }
		if($upc_matches[3]==3&&$upc_matches[1]==0) {
		if($NumZero==0) { $left_text_color = $left_text_color_even; }
		if($NumZero==1) { $left_text_color = $left_text_color_even; }
		if($NumZero==5) { $left_text_color = $left_text_color_even; } }
		if($upc_matches[3]==4&&$upc_matches[1]==0) {
		if($NumZero==0) { $left_text_color = $left_text_color_even; }
		if($NumZero==2) { $left_text_color = $left_text_color_even; }
		if($NumZero==3) { $left_text_color = $left_text_color_even; } }
		if($upc_matches[3]==5&&$upc_matches[1]==0) {
		if($NumZero==0) { $left_text_color = $left_text_color_even; }
		if($NumZero==3) { $left_text_color = $left_text_color_even; }
		if($NumZero==4) { $left_text_color = $left_text_color_even; } }
		if($upc_matches[3]==6&&$upc_matches[1]==0) {
		if($NumZero==0) { $left_text_color = $left_text_color_even; }
		if($NumZero==4) { $left_text_color = $left_text_color_even; }
		if($NumZero==5) { $left_text_color = $left_text_color_even; } }
		if($upc_matches[3]==7&&$upc_matches[1]==0) {
		if($NumZero==0) { $left_text_color = $left_text_color_even; }
		if($NumZero==2) { $left_text_color = $left_text_color_even; }
		if($NumZero==4) { $left_text_color = $left_text_color_even; } }
		if($upc_matches[3]==8&&$upc_matches[1]==0) {
		if($NumZero==0) { $left_text_color = $left_text_color_even; }
		if($NumZero==2) { $left_text_color = $left_text_color_even; }
		if($NumZero==5) { $left_text_color = $left_text_color_even; } }
		if($upc_matches[3]==9&&$upc_matches[1]==0) {
		if($NumZero==0) { $left_text_color = $left_text_color_even; }
		if($NumZero==3) { $left_text_color = $left_text_color_even; }
		if($NumZero==5) { $left_text_color = $left_text_color_even; } }
		if($upc_matches[3]==0&&$upc_matches[1]==1) {
		if($NumZero==3) { $left_text_color = $left_text_color_even; }
		if($NumZero==4) { $left_text_color = $left_text_color_even; }
		if($NumZero==5) { $left_text_color = $left_text_color_even; } }
		if($upc_matches[3]==1&&$upc_matches[1]==1) {
		if($NumZero==2) { $left_text_color = $left_text_color_even; }
		if($NumZero==4) { $left_text_color = $left_text_color_even; }
		if($NumZero==5) { $left_text_color = $left_text_color_even; } }
		if($upc_matches[3]==2&&$upc_matches[1]==1) {
		if($NumZero==2) { $left_text_color = $left_text_color_even; }
		if($NumZero==3) { $left_text_color = $left_text_color_even; }
		if($NumZero==5) { $left_text_color = $left_text_color_even; } }
		if($upc_matches[3]==3&&$upc_matches[1]==1) {
		if($NumZero==2) { $left_text_color = $left_text_color_even; }
		if($NumZero==3) { $left_text_color = $left_text_color_even; }
		if($NumZero==4) { $left_text_color = $left_text_color_even; } }
		if($upc_matches[3]==4&&$upc_matches[1]==1) {
		if($NumZero==1) { $left_text_color = $left_text_color_even; }
		if($NumZero==4) { $left_text_color = $left_text_color_even; }
		if($NumZero==5) { $left_text_color = $left_text_color_even; } }
		if($upc_matches[3]==5&&$upc_matches[1]==1) {
		if($NumZero==1) { $left_text_color = $left_text_color_even; }
		if($NumZero==2) { $left_text_color = $left_text_color_even; }
		if($NumZero==5) { $left_text_color = $left_text_color_even; } }
		if($upc_matches[3]==6&&$upc_matches[1]==1) {
		if($NumZero==1) { $left_text_color = $left_text_color_even; }
		if($NumZero==2) { $left_text_color = $left_text_color_even; }
		if($NumZero==3) { $left_text_color = $left_text_color_even; } }
		if($upc_matches[3]==7&&$upc_matches[1]==1) {
		if($NumZero==1) { $left_text_color = $left_text_color_even; }
		if($NumZero==3) { $left_text_color = $left_text_color_even; }
		if($NumZero==5) { $left_text_color = $left_text_color_even; } }
		if($upc_matches[3]==8&&$upc_matches[1]==1) {
		if($NumZero==1) { $left_text_color = $left_text_color_even; }
		if($NumZero==3) { $left_text_color = $left_text_color_even; }
		if($NumZero==4) { $left_text_color = $left_text_color_even; } }
		if($upc_matches[3]==9&&$upc_matches[1]==1) {
		if($NumZero==1) { $left_text_color = $left_text_color_even; }
		if($NumZero==2) { $left_text_color = $left_text_color_even; }
		if($NumZero==4) { $left_text_color = $left_text_color_even; } }
		$InnerUPCNum = 0;
		while ($InnerUPCNum < count($left_text_color)) {
		if($left_text_color[$InnerUPCNum]==1) {
		imageline($upc_img, $LineStart, 10, $LineStart, $LineSize, $text_color); }
		if($left_text_color[$InnerUPCNum]==0) {
		imageline($upc_img, $LineStart, 10, $LineStart, $LineSize, $alt_text_color); }
		$LineStart += 1;
		++$InnerUPCNum; }
		++$NumZero; }
	imageline($upc_img, 54, 10, 54, 53, $alt_text_color);
	imageline($upc_img, 55, 10, 55, 53, $text_color);
	imageline($upc_img, 56, 10, 56, 53, $alt_text_color);
	imageline($upc_img, 57, 10, 57, 53, $text_color);
	imageline($upc_img, 58, 10, 58, 53, $alt_text_color);
	imageline($upc_img, 59, 10, 59, 53, $text_color);
	imageline($upc_img, 60, 10, 60, 47, $alt_text_color);
	imageline($upc_img, 61, 10, 61, 47, $alt_text_color);
	imageline($upc_img, 62, 10, 62, 47, $alt_text_color);
	imageline($upc_img, 63, 10, 63, 47, $alt_text_color);
	imageline($upc_img, 64, 10, 64, 47, $alt_text_color);
	imageline($upc_img, 65, 10, 65, 47, $alt_text_color);
	imageline($upc_img, 66, 10, 66, 47, $alt_text_color);
	imageline($upc_img, 67, 10, 67, 47, $alt_text_color);
	imageline($upc_img, 68, 10, 68, 47, $alt_text_color);
	if(strlen($supplement)==2) { create_ean2($supplement,69,$upc_img); }
	if(strlen($supplement)==5) { create_ean5($supplement,69,$upc_img); }
	if($resize>1) {
	$new_upc_img = imagecreatetruecolor((69 + $addonsize) * $resize, 62 * $resize);
	imagefilledrectangle($new_upc_img, 0, 0, (69 + $addonsize) * $resize, 62 * $resize, 0xFFFFFF);
	imageinterlace($new_upc_img, true);
	if($resizetype=="resize") {
	imagecopyresized($new_upc_img, $upc_img, 0, 0, 0, 0, (69 + $addonsize) * $resize, 62 * $resize, 69 + $addonsize, 62); }
	if($resizetype=="resample") {
	imagecopyresampled($new_upc_img, $upc_img, 0, 0, 0, 0, (69 + $addonsize) * $resize, 62 * $resize, 69 + $addonsize, 62); }
	imagedestroy($upc_img); 
	$upc_img = $new_upc_img; }
	if($imgtype=="png") {
	if($outputimage==true) {
	imagepng($upc_img); }
	if($outfile!=null) {
	imagepng($upc_img,$outfile); } }
	if($imgtype=="gif") {
	if($outputimage==true) {
	imagegif($upc_img); }
	if($outfile!=null) {
	imagegif($upc_img,$outfile); } }
	if($imgtype=="xbm") {
	if($outputimage==true) {
	imagexbm($upc_img,NULL); }
	if($outfile!=null) {
	imagexbm($upc_img,$outfile); } }
	if($imgtype=="wbmp") {
	if($outputimage==true) {
	imagewbmp($upc_img); }
	if($outfile!=null) {
	imagewbmp($upc_img,$outfile); } }
	imagedestroy($upc_img); 
	return true; }
?>