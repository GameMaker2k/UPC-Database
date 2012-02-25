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

    $FileInfo: itf14.php - Last Update: 02/13/2012 Ver. 2.2.5 RC 1 - Author: cooldude2k $
*/
$File3Name = basename($_SERVER['SCRIPT_NAME']);
if ($File3Name=="itf14.php"||$File3Name=="/itf14.php") {
	chdir("../");
	require("./upc.php");
	exit(); }

if(!isset($upcfunctions)) { $upcfunctions = array(); }
if(!is_array($upcfunctions)) { $upcfunctions = array(); }
array_push($upcfunctions, "create_itf14");
function create_itf14($upc,$imgtype="png",$outputimage=true,$resize=1,$resizetype="resize",$outfile=NULL,$hidecd=false) {
	if(!isset($upc)||!is_numeric($upc)) { return false; }
	if(strlen($upc) % 2) { return false; }
	if(strlen($upc) < 6) { return false; }
	if(!isset($resize)||!preg_match("/^([0-9]*[\.]?[0-9])/", $resize)||$resize<1) { $resize = 1; }
	if($resizetype!="resample"&&$resizetype!="resize") { $resizetype = "resize"; }
	if($imgtype!="png"&&$imgtype!="gif"&&$imgtype!="xbm"&&$imgtype!="wbmp") { $imgtype = "png"; }
	$upc_matches = str_split($upc, 2);
	$upc_size_add = count($upc_matches) * 18;
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
	$upc_img = imagecreatetruecolor(44 + $upc_size_add, 62);
	imagefilledrectangle($upc_img, 0, 0, 44 + $upc_size_add, 62, 0xFFFFFF);
	imageinterlace($upc_img, true);
	$background_color = imagecolorallocate($upc_img, 255, 255, 255);
	$text_color = imagecolorallocate($upc_img, 0, 0, 0);
	$alt_text_color = imagecolorallocate($upc_img, 255, 255, 255);
	$NumTxtZero = 0; $LineTxtStart = 23;
	while ($NumTxtZero < count($upc_matches)) {
	$ArrayDigit = str_split($upc_matches[$NumTxtZero]);
	imagestring($upc_img, 2, $LineTxtStart, 50, $ArrayDigit[0], $text_color);
	$LineTxtStart += 9;
	imagestring($upc_img, 2, $LineTxtStart, 50, $ArrayDigit[1], $text_color);
	$LineTxtStart += 9;
	++$NumTxtZero; }
	imagerectangle($upc_img, 0, 0, 43 + $upc_size_add, 51, $text_color);
	imagerectangle($upc_img, 1, 1, 42 + $upc_size_add, 50, $text_color);
	imagerectangle($upc_img, 2, 2, 41 + $upc_size_add, 49, $text_color);
	imagerectangle($upc_img, 3, 3, 40 + $upc_size_add, 48, $text_color);
	imageline($upc_img, 4, 4, 4, 47, $alt_text_color);
	imageline($upc_img, 5, 4, 5, 47, $alt_text_color);
	imageline($upc_img, 6, 4, 6, 47, $alt_text_color);
	imageline($upc_img, 7, 4, 7, 47, $alt_text_color);
	imageline($upc_img, 8, 4, 8, 47, $alt_text_color);
	imageline($upc_img, 9, 4, 9, 47, $alt_text_color);
	imageline($upc_img, 10, 4, 10, 47, $alt_text_color);
	imageline($upc_img, 11, 4, 11, 47, $alt_text_color);
	imageline($upc_img, 12, 4, 12, 47, $alt_text_color);
	imageline($upc_img, 13, 4, 13, 47, $alt_text_color);
	imageline($upc_img, 14, 4, 14, 47, $alt_text_color);
	imageline($upc_img, 15, 4, 15, 47, $alt_text_color);
	imageline($upc_img, 16, 4, 16, 47, $alt_text_color);
	imageline($upc_img, 17, 4, 17, 47, $text_color);
	imageline($upc_img, 18, 4, 18, 47, $alt_text_color);
	imageline($upc_img, 19, 4, 19, 47, $text_color);
	imageline($upc_img, 20, 4, 20, 47, $alt_text_color);
	$NumZero = 0; $LineStart = 21; $LineSize = 47;
	while ($NumZero < count($upc_matches)) {
		$ArrayDigit = str_split($upc_matches[$NumZero]);
		$left_text_color = array(0, 0, 1, 1, 0);
		if($ArrayDigit[0]==0) {
		$left_text_color = array(0, 0, 1, 1, 0); }
		if($ArrayDigit[0]==1) {
		$left_text_color = array(1, 0, 0, 0, 1); }
		if($ArrayDigit[0]==2) {
		$left_text_color = array(0, 1, 0, 0, 1); }
		if($ArrayDigit[0]==3) {
		$left_text_color = array(1, 1, 0, 0, 0); }
		if($ArrayDigit[0]==4) {
		$left_text_color = array(0, 0, 1, 0, 1); }
		if($ArrayDigit[0]==5) {
		$left_text_color = array(1, 0, 1, 0, 0); }
		if($ArrayDigit[0]==6) {
		$left_text_color = array(0, 1, 1, 0, 0); }
		if($ArrayDigit[0]==7) {
		$left_text_color = array(0, 0, 0, 1, 1); }
		if($ArrayDigit[0]==8) {
		$left_text_color = array(1, 0, 0, 1, 0); }
		if($ArrayDigit[0]==9) {
		$left_text_color = array(0, 1, 0, 1, 0); }
		$right_text_color = array(0, 0, 1, 1, 0);
		if($ArrayDigit[1]==0) {
		$right_text_color = array(0, 0, 1, 1, 0); }
		if($ArrayDigit[1]==1) {
		$right_text_color = array(1, 0, 0, 0, 1); }
		if($ArrayDigit[1]==2) {
		$right_text_color = array(0, 1, 0, 0, 1); }
		if($ArrayDigit[1]==3) {
		$right_text_color = array(1, 1, 0, 0, 0); }
		if($ArrayDigit[1]==4) {
		$right_text_color = array(0, 0, 1, 0, 1); }
		if($ArrayDigit[1]==5) {
		$right_text_color = array(1, 0, 1, 0, 0); }
		if($ArrayDigit[1]==6) {
		$right_text_color = array(0, 1, 1, 0, 0); }
		if($ArrayDigit[1]==7) {
		$right_text_color = array(0, 0, 0, 1, 1); }
		if($ArrayDigit[1]==8) {
		$right_text_color = array(1, 0, 0, 1, 0); }
		if($ArrayDigit[1]==9) {
		$right_text_color = array(0, 1, 0, 1, 0); }
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
		if($right_text_color[$InnerUPCNum]==1) {
		imageline($upc_img, $LineStart, 4, $LineStart, $LineSize, $alt_text_color); 
		$LineStart += 1; 
		imageline($upc_img, $LineStart, 4, $LineStart, $LineSize, $alt_text_color); 
		$LineStart += 1; 
		imageline($upc_img, $LineStart, 4, $LineStart, $LineSize, $alt_text_color); 
		$LineStart += 1; }
		if($right_text_color[$InnerUPCNum]==0) {
		imageline($upc_img, $LineStart, 4, $LineStart, $LineSize, $alt_text_color);
		$LineStart += 1; }
		++$InnerUPCNum; }
		++$NumZero; }
	imageline($upc_img, 21 + $upc_size_add, 4, 21 + $upc_size_add, 47, $text_color);
	imageline($upc_img, 22 + $upc_size_add, 4, 22 + $upc_size_add, 47, $text_color);
	imageline($upc_img, 23 + $upc_size_add, 4, 23 + $upc_size_add, 47, $text_color);
	imageline($upc_img, 24 + $upc_size_add, 4, 24 + $upc_size_add, 47, $alt_text_color);
	imageline($upc_img, 25 + $upc_size_add, 4, 25 + $upc_size_add, 47, $text_color);
	imageline($upc_img, 26 + $upc_size_add, 4, 26 + $upc_size_add, 47, $alt_text_color);
	imageline($upc_img, 27 + $upc_size_add, 4, 27 + $upc_size_add, 47, $alt_text_color);
	imageline($upc_img, 28 + $upc_size_add, 4, 28 + $upc_size_add, 47, $alt_text_color);
	imageline($upc_img, 29 + $upc_size_add, 4, 29 + $upc_size_add, 47, $alt_text_color);
	imageline($upc_img, 30 + $upc_size_add, 4, 30 + $upc_size_add, 47, $alt_text_color);
	imageline($upc_img, 31 + $upc_size_add, 4, 31 + $upc_size_add, 47, $alt_text_color);
	imageline($upc_img, 32 + $upc_size_add, 4, 32 + $upc_size_add, 47, $alt_text_color);
	imageline($upc_img, 33 + $upc_size_add, 4, 33 + $upc_size_add, 47, $alt_text_color);
	imageline($upc_img, 34 + $upc_size_add, 4, 34 + $upc_size_add, 47, $alt_text_color);
	imageline($upc_img, 35 + $upc_size_add, 4, 35 + $upc_size_add, 47, $alt_text_color);
	imageline($upc_img, 36 + $upc_size_add, 4, 36 + $upc_size_add, 47, $alt_text_color);
	imageline($upc_img, 37 + $upc_size_add, 4, 37 + $upc_size_add, 47, $alt_text_color);
	imageline($upc_img, 38 + $upc_size_add, 4, 38 + $upc_size_add, 47, $alt_text_color);
	imageline($upc_img, 39 + $upc_size_add, 4, 39 + $upc_size_add, 47, $alt_text_color);
	if($resize>1) {
	$new_upc_img = imagecreatetruecolor((44 + $upc_size_add) * $resize, 62 * $resize);
	imagefilledrectangle($new_upc_img, 0, 0, (44 + $upc_size_add) * $resize, 62 * $resize, 0xFFFFFF);
	imageinterlace($new_upc_img, true);
	if($resizetype=="resize") {
	imagecopyresized($new_upc_img, $upc_img, 0, 0, 0, 0, (44 + $upc_size_add) * $resize, 62 * $resize, (44 + $upc_size_add), 62); }
	if($resizetype=="resample") {
	imagecopyresampled($new_upc_img, $upc_img, 0, 0, 0, 0, (44 + $upc_size_add) * $resize, 62 * $resize, (44 + $upc_size_add), 62); }
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