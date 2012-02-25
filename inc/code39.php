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

    $FileInfo: code39.php - Last Update: 02/13/2012 Ver. 2.2.5 RC 1 - Author: cooldude2k $
*/
$File3Name = basename($_SERVER['SCRIPT_NAME']);
if ($File3Name=="code39.php"||$File3Name=="/code39.php") {
	chdir("../");
	require("./upc.php");
	exit(); }

if(!isset($upcfunctions)) { $upcfunctions = array(); }
if(!is_array($upcfunctions)) { $upcfunctions = array(); }
array_push($upcfunctions, "create_code39");
function create_code39($upc,$imgtype="png",$outputimage=true,$resize=1,$resizetype="resize",$outfile=NULL,$hidecd=false) {
	if(!isset($upc)) { return false; }
	if(strlen($upc) < 1) { return false; }
	if(!preg_match("/([0-9a-zA-Z\-\.\$\/\+% ]+)/", $upc)) { return false; }
	if(!isset($resize)||!preg_match("/^([0-9]*[\.]?[0-9])/", $resize)||$resize<1) { $resize = 1; }
	if($resizetype!="resample"&&$resizetype!="resize") { $resizetype = "resize"; }
	if($imgtype!="png"&&$imgtype!="gif"&&$imgtype!="xbm"&&$imgtype!="wbmp") { $imgtype = "png"; }
	$upc = strtoupper($upc);
	$upc_matches = str_split($upc);
	$upc_size_add = (count($upc_matches) * 15) + (count($upc_matches) + 1);
	if(count($upc_matches)<=0) { return false; }
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
	$upc_img = imagecreatetruecolor(48 + $upc_size_add, 62);
	imagefilledrectangle($upc_img, 0, 0, 48 + $upc_size_add, 62, 0xFFFFFF);
	imageinterlace($upc_img, true);
	$background_color = imagecolorallocate($upc_img, 255, 255, 255);
	$text_color = imagecolorallocate($upc_img, 0, 0, 0);
	$alt_text_color = imagecolorallocate($upc_img, 255, 255, 255);
	$NumTxtZero = 0; $LineTxtStart = 30;
	imagestring($upc_img, 2, 14, 48, "*", $text_color);
	while ($NumTxtZero < count($upc_matches)) {
	imagestring($upc_img, 2, $LineTxtStart, 48, $upc_matches[$NumTxtZero], $text_color);
	$LineTxtStart += 16;
	++$NumTxtZero; }
	imagestring($upc_img, 2, $LineTxtStart, 48, "*", $text_color);
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
	imageline($upc_img, 11, 4, 11, 47, $alt_text_color);
	imageline($upc_img, 12, 4, 12, 47, $alt_text_color);
	imageline($upc_img, 13, 4, 13, 47, $text_color);
	imageline($upc_img, 14, 4, 14, 47, $alt_text_color);
	imageline($upc_img, 15, 4, 15, 47, $text_color);
	imageline($upc_img, 16, 4, 16, 47, $text_color);
	imageline($upc_img, 17, 4, 17, 47, $text_color);
	imageline($upc_img, 18, 4, 18, 47, $alt_text_color);
	imageline($upc_img, 19, 4, 19, 47, $text_color);
	imageline($upc_img, 20, 4, 20, 47, $text_color);
	imageline($upc_img, 21, 4, 21, 47, $text_color);
	imageline($upc_img, 22, 4, 22, 47, $alt_text_color);
	imageline($upc_img, 23, 4, 23, 47, $text_color);
	imageline($upc_img, 24, 4, 24, 47, $alt_text_color); 
	$NumZero = 0; $LineStart = 25; $LineSize = 47;
	while ($NumZero < count($upc_matches)) {
		$left_text_color = array(0, 2, 0, 3, 1, 2, 1, 2, 0);
		if($upc_matches[$NumZero]==0) {
		$left_text_color = array(0, 2, 0, 3, 1, 2, 1, 2, 0); }
		if($upc_matches[$NumZero]==1) {
		$left_text_color = array(1, 2, 0, 3, 0, 2, 0, 2, 1); }
		if($upc_matches[$NumZero]==2) {
		$left_text_color = array(0, 2, 1, 3, 0, 2, 0, 2, 1); }
		if($upc_matches[$NumZero]==3) {
		$left_text_color = array(1, 2, 1, 3, 0, 2, 0, 2, 0); }
		if($upc_matches[$NumZero]==4) {
		$left_text_color = array(0, 2, 0, 3, 1, 2, 0, 2, 1); }
		if($upc_matches[$NumZero]==5) {
		$left_text_color = array(1, 2, 0, 3, 1, 2, 0, 2, 0); }
		if($upc_matches[$NumZero]==6) {
		$left_text_color = array(0, 2, 1, 3, 1, 2, 0, 2, 0); }
		if($upc_matches[$NumZero]==7) {
		$left_text_color = array(0, 2, 0, 3, 0, 2, 1, 2, 1); }
		if($upc_matches[$NumZero]==8) {
		$left_text_color = array(1, 2, 0, 3, 0, 2, 1, 2, 0); }
		if($upc_matches[$NumZero]==9) {
		$left_text_color = array(0, 2, 1, 3, 0, 2, 1, 2, 0); }
		if($upc_matches[$NumZero]=="A") {
		$left_text_color = array(1, 2, 0, 2, 0, 3, 0, 2, 1); }
		if($upc_matches[$NumZero]=="B") {
		$left_text_color = array(0, 2, 1, 2, 0, 3, 0, 2, 1); }
		if($upc_matches[$NumZero]=="C") {
		$left_text_color = array(1, 2, 1, 2, 0, 3, 0, 2, 0); }
		if($upc_matches[$NumZero]=="D") {
		$left_text_color = array(0, 2, 0, 2, 1, 3, 0, 2, 1); }
		if($upc_matches[$NumZero]=="E") {
		$left_text_color = array(1, 2, 0, 2, 1, 3, 0, 2, 0); }
		if($upc_matches[$NumZero]=="F") {
		$left_text_color = array(0, 2, 1, 2, 1, 3, 0, 2, 0); }
		if($upc_matches[$NumZero]=="G") {
		$left_text_color = array(0, 2, 0, 2, 0, 3, 1, 2, 1); }
		if($upc_matches[$NumZero]=="H") {
		$left_text_color = array(1, 2, 0, 2, 0, 3, 1, 2, 0); }
		if($upc_matches[$NumZero]=="I") {
		$left_text_color = array(0, 2, 1, 2, 0, 3, 1, 2, 0); }
		if($upc_matches[$NumZero]=="J") {
		$left_text_color = array(0, 2, 0, 2, 1, 3, 1, 2, 0); }
		if($upc_matches[$NumZero]=="K") {
		$left_text_color = array(1, 2, 0, 2, 0, 2, 0, 3, 1); }
		if($upc_matches[$NumZero]=="L") {
		$left_text_color = array(0, 2, 1, 2, 0, 2, 0, 3, 1); }
		if($upc_matches[$NumZero]=="M") {
		$left_text_color = array(1, 2, 1, 2, 0, 2, 0, 3, 0); }
		if($upc_matches[$NumZero]=="N") {
		$left_text_color = array(0, 2, 0, 2, 1, 2, 0, 3, 1); }
		if($upc_matches[$NumZero]=="O") {
		$left_text_color = array(1, 2, 0, 2, 1, 2, 0, 3, 0); }
		if($upc_matches[$NumZero]=="P") {
		$left_text_color = array(0, 2, 1, 2, 1, 2, 0, 3, 0); }
		if($upc_matches[$NumZero]=="Q") {
		$left_text_color = array(0, 2, 0, 2, 0, 2, 1, 3, 1); }
		if($upc_matches[$NumZero]=="R") {
		$left_text_color = array(1, 2, 0, 2, 0, 2, 1, 3, 0); }
		if($upc_matches[$NumZero]=="S") {
		$left_text_color = array(0, 2, 1, 2, 0, 2, 1, 3, 0); }
		if($upc_matches[$NumZero]=="T") {
		$left_text_color = array(0, 2, 0, 2, 1, 2, 1, 3, 0); }
		if($upc_matches[$NumZero]=="U") {
		$left_text_color = array(1, 3, 0, 2, 0, 2, 0, 2, 1); }
		if($upc_matches[$NumZero]=="V") {
		$left_text_color = array(0, 3, 1, 2, 0, 2, 0, 2, 1); }
		if($upc_matches[$NumZero]=="W") {
		$left_text_color = array(1, 3, 1, 2, 0, 2, 0, 2, 0); }
		if($upc_matches[$NumZero]=="X") {
		$left_text_color = array(0, 3, 0, 2, 1, 2, 0, 2, 1); }
		if($upc_matches[$NumZero]=="Y") {
		$left_text_color = array(1, 3, 0, 2, 1, 2, 0, 2, 0); }
		if($upc_matches[$NumZero]=="Z") {
		$left_text_color = array(0, 3, 1, 2, 1, 2, 0, 2, 0); }
		if($upc_matches[$NumZero]=="-") {
		$left_text_color = array(0, 3, 0, 2, 0, 2, 1, 2, 1); }
		if($upc_matches[$NumZero]==".") {
		$left_text_color = array(1, 3, 0, 2, 0, 2, 1, 2, 0); }
		if($upc_matches[$NumZero]==" ") {
		$left_text_color = array(0, 3, 1, 2, 0, 2, 1, 2, 0); }
		if($upc_matches[$NumZero]=="$") {
		$left_text_color = array(0, 3, 0, 3, 0, 3, 0, 2, 0); }
		if($upc_matches[$NumZero]=="/") {
		$left_text_color = array(0, 3, 0, 3, 0, 2, 0, 3, 0); }
		if($upc_matches[$NumZero]=="+") {
		$left_text_color = array(0, 3, 0, 2, 0, 3, 0, 3, 0); }
		if($upc_matches[$NumZero]=="%") {
		$left_text_color = array(0, 2, 0, 3, 0, 3, 0, 3, 0); }
		$InnerUPCNum = 0;
		while ($InnerUPCNum < count($left_text_color)) {
		if($left_text_color[$InnerUPCNum]==1) {
		imageline($upc_img, $LineStart, 4, $LineStart, $LineSize, $text_color); 
		$LineStart += 1; 
		imageline($upc_img, $LineStart, 4, $LineStart, $LineSize, $text_color); 
		$LineStart += 1; 
		imageline($upc_img, $LineStart, 4, $LineStart, $LineSize, $text_color); 
		$LineStart += 1; }
		if($left_text_color[$InnerUPCNum]==0) {
		imageline($upc_img, $LineStart, 4, $LineStart, $LineSize, $text_color); 
		$LineStart += 1; }
		if($left_text_color[$InnerUPCNum]==3) {
		imageline($upc_img, $LineStart, 4, $LineStart, $LineSize, $alt_text_color); 
		$LineStart += 1; 
		imageline($upc_img, $LineStart, 4, $LineStart, $LineSize, $alt_text_color); 
		$LineStart += 1; 
		imageline($upc_img, $LineStart, 4, $LineStart, $LineSize, $alt_text_color); 
		$LineStart += 1; }
		if($left_text_color[$InnerUPCNum]==2) {
		imageline($upc_img, $LineStart, 4, $LineStart, $LineSize, $alt_text_color); 
		$LineStart += 1; }
		++$InnerUPCNum; }
		imageline($upc_img, $LineStart, 4, $LineStart, $LineSize, $alt_text_color); 
		$LineStart += 1; 
		++$NumZero; }
	imageline($upc_img, 23 + $upc_size_add, 4, 23 + $upc_size_add, 47, $alt_text_color); 
	imageline($upc_img, 24 + $upc_size_add, 4, 24 + $upc_size_add, 47, $text_color);
	imageline($upc_img, 25 + $upc_size_add, 4, 25 + $upc_size_add, 47, $alt_text_color);
	imageline($upc_img, 26 + $upc_size_add, 4, 26 + $upc_size_add, 47, $alt_text_color);
	imageline($upc_img, 27 + $upc_size_add, 4, 27 + $upc_size_add, 47, $alt_text_color);
	imageline($upc_img, 28 + $upc_size_add, 4, 28 + $upc_size_add, 47, $text_color);
	imageline($upc_img, 29 + $upc_size_add, 4, 29 + $upc_size_add, 47, $alt_text_color);
	imageline($upc_img, 30 + $upc_size_add, 4, 30 + $upc_size_add, 47, $text_color);
	imageline($upc_img, 31 + $upc_size_add, 4, 31 + $upc_size_add, 47, $text_color);
	imageline($upc_img, 32 + $upc_size_add, 4, 32 + $upc_size_add, 47, $text_color);
	imageline($upc_img, 33 + $upc_size_add, 4, 33 + $upc_size_add, 47, $alt_text_color);
	imageline($upc_img, 34 + $upc_size_add, 4, 34 + $upc_size_add, 47, $text_color);
	imageline($upc_img, 35 + $upc_size_add, 4, 35 + $upc_size_add, 47, $text_color);
	imageline($upc_img, 36 + $upc_size_add, 4, 36 + $upc_size_add, 47, $text_color);
	imageline($upc_img, 37 + $upc_size_add, 4, 37 + $upc_size_add, 47, $alt_text_color);
	imageline($upc_img, 38 + $upc_size_add, 4, 38 + $upc_size_add, 47, $text_color);
	imageline($upc_img, 39 + $upc_size_add, 4, 39 + $upc_size_add, 47, $alt_text_color);
	imageline($upc_img, 40 + $upc_size_add, 4, 40 + $upc_size_add, 47, $alt_text_color);
	imageline($upc_img, 41 + $upc_size_add, 4, 41 + $upc_size_add, 47, $alt_text_color);
	imageline($upc_img, 42 + $upc_size_add, 4, 42 + $upc_size_add, 47, $alt_text_color);
	imageline($upc_img, 43 + $upc_size_add, 4, 43 + $upc_size_add, 47, $alt_text_color);
	imageline($upc_img, 44 + $upc_size_add, 4, 44 + $upc_size_add, 47, $alt_text_color);
	imageline($upc_img, 45 + $upc_size_add, 4, 45 + $upc_size_add, 47, $alt_text_color);
	imageline($upc_img, 46 + $upc_size_add, 4, 46 + $upc_size_add, 47, $alt_text_color);
	imageline($upc_img, 47 + $upc_size_add, 4, 47 + $upc_size_add, 47, $alt_text_color);
	if($resize>1) {
	$new_upc_img = imagecreatetruecolor((48 + $upc_size_add) * $resize, 62 * $resize);
	imagefilledrectangle($new_upc_img, 0, 0, (48 + $upc_size_add) * $resize, 62 * $resize, 0xFFFFFF);
	imageinterlace($new_upc_img, true);
	if($resizetype=="resize") {
	imagecopyresized($new_upc_img, $upc_img, 0, 0, 0, 0, (48 + $upc_size_add) * $resize, 62 * $resize, (48 + $upc_size_add), 62); }
	if($resizetype=="resample") {
	imagecopyresampled($new_upc_img, $upc_img, 0, 0, 0, 0, (48 + $upc_size_add) * $resize, 62 * $resize, (48 + $upc_size_add), 62); }
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