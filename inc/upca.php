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

    $FileInfo: upca.php - Last Update: 02/13/2012 Ver. 2.2.5 RC 1 - Author: cooldude2k $
*/
$File3Name = basename($_SERVER['SCRIPT_NAME']);
if ($File3Name=="upca.php"||$File3Name=="/upca.php") {
	chdir("../");
	require("./upc.php");
	exit(); }

if(!isset($upcfunctions)) { $upcfunctions = array(); }
if(!is_array($upcfunctions)) { $upcfunctions = array(); }
array_push($upcfunctions, "create_upca");
function create_upca($upc,$imgtype="png",$outputimage=true,$resize=1,$resizetype="resize",$outfile=NULL,$hidecd=false) {
	if(!isset($upc)) { return false; }
	$upc_pieces = null; $supplement = null;
	if(preg_match("/([0-9]+)([ |\|]{1})([0-9]{2})$/", $upc, $upc_pieces)) {
	$upc = $upc_pieces[1]; $supplement = $upc_pieces[3]; }
	if(preg_match("/([0-9]+)([ |\|]){1}([0-9]{5})$/", $upc, $upc_pieces)) {
	$upc = $upc_pieces[1]; $supplement = $upc_pieces[3]; }
	if(!isset($upc)||!is_numeric($upc)) { return false; }
	if(isset($supplement)&&!is_numeric($supplement)) { return false; }
	if(strlen($upc)==8) { $upc = convert_upce_to_upca($upc); }
	if(strlen($upc)==13) { $upc = convert_ean13_to_upca($upc); }
	if(strlen($upc)==11) { $upc = $upc.validate_upca($upc,true); }
	if(strlen($upc)>12||strlen($upc)<12) { return false; }
	if(!isset($resize)||!preg_match("/^([0-9]*[\.]?[0-9])/", $resize)||$resize<1) { $resize = 1; }
	if($resizetype!="resample"&&$resizetype!="resize") { $resizetype = "resize"; }
	if(validate_upca($upc)===false) { preg_match("/^(\d{11})/", $upc, $pre_matches); 
	$upc = $pre_matches[1].validate_upca($pre_matches[1],true); }
	if($imgtype!="png"&&$imgtype!="gif"&&$imgtype!="xbm"&&$imgtype!="wbmp") { $imgtype = "png"; }
	preg_match("/(\d{1})(\d{5})(\d{5})(\d{1})/", $upc, $upc_matches);
	if(count($upc_matches)<=0) { return false; }
	$PrefixDigit = $upc_matches[1];
	$LeftDigit = str_split($upc_matches[2]);
	array_unshift($LeftDigit, $upc_matches[1]);
	$RightDigit = str_split($upc_matches[3]);
	array_push($RightDigit, $upc_matches[4]);
	$CheckDigit = $upc_matches[4];
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
	$upc_img = imagecreatetruecolor(113 + $addonsize, 62);
	imagefilledrectangle($upc_img, 0, 0, 113 + $addonsize, 62, 0xFFFFFF);
	imageinterlace($upc_img, true);
	$background_color = imagecolorallocate($upc_img, 255, 255, 255);
	$text_color = imagecolorallocate($upc_img, 0, 0, 0);
	$alt_text_color = imagecolorallocate($upc_img, 255, 255, 255);
	imagestring($upc_img, 2, 2, 47, $upc_matches[1], $text_color);
	imagestring($upc_img, 2, 22, 47, $upc_matches[2], $text_color);
	imagestring($upc_img, 2, 61, 47, $upc_matches[3], $text_color);
	if($hidecd!==true) {
	imagestring($upc_img, 2, 106, 47, $upc_matches[4], $text_color); }
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
		if($NumZero!=0) { $LineSize = 47; }
		if($NumZero==0) { $LineSize = 53; }
		$left_text_color = array(0, 0, 0, 0, 0, 0, 0);
		if($LeftDigit[$NumZero]==0) { 
		$left_text_color = array(0, 0, 0, 1, 1, 0, 1); }
		if($LeftDigit[$NumZero]==1) { 
		$left_text_color = array(0, 0, 1, 1, 0, 0, 1); }
		if($LeftDigit[$NumZero]==2) { 
		$left_text_color = array(0, 0, 1, 0, 0, 1, 1); }
		if($LeftDigit[$NumZero]==3) { 
		$left_text_color = array(0, 1, 1, 1, 1, 0, 1); }
		if($LeftDigit[$NumZero]==4) { 
		$left_text_color = array(0, 1, 0, 0, 0, 1, 1); }
		if($LeftDigit[$NumZero]==5) { 
		$left_text_color = array(0, 1, 1, 0, 0, 0, 1); }
		if($LeftDigit[$NumZero]==6) { 
		$left_text_color = array(0, 1, 0, 1, 1, 1, 1); }
		if($LeftDigit[$NumZero]==7) { 
		$left_text_color = array(0, 1, 1, 1, 0, 1, 1); }
		if($LeftDigit[$NumZero]==8) { 
		$left_text_color = array(0, 1, 1, 0, 1, 1, 1); }
		if($LeftDigit[$NumZero]==9) {
		$left_text_color = array(0, 0, 0, 1, 0, 1, 1); }
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
	$NumZero = 0; $LineStart = 59;
	while ($NumZero < count($RightDigit)) {
		if($NumZero!=5) { $LineSize = 47; }
		if($NumZero==5) { $LineSize = 53; }
		$right_text_color = array(0, 0, 0, 0, 0, 0, 0);
		if($RightDigit[$NumZero]==0) { 
		$right_text_color = array(1, 1, 1, 0, 0, 1, 0); }
		if($RightDigit[$NumZero]==1) { 
		$right_text_color = array(1, 1, 0, 0, 1, 1, 0); }
		if($RightDigit[$NumZero]==2) { 
		$right_text_color = array(1, 1, 0, 1, 1, 0, 0); }
		if($RightDigit[$NumZero]==3) { 
		$right_text_color = array(1, 0, 0, 0, 0, 1, 0); }
		if($RightDigit[$NumZero]==4) { 
		$right_text_color = array(1, 0, 1, 1, 1, 0, 0); }
		if($RightDigit[$NumZero]==5) { 
		$right_text_color = array(1, 0, 0, 1, 1, 1, 0); }
		if($RightDigit[$NumZero]==6) { 
		$right_text_color = array(1, 0, 1, 0, 0, 0, 0); }
		if($RightDigit[$NumZero]==7) { 
		$right_text_color = array(1, 0, 0, 0, 1, 0, 0); }
		if($RightDigit[$NumZero]==8) { 
		$right_text_color = array(1, 0, 0, 1, 0, 0, 0); }
		if($RightDigit[$NumZero]==9) { 
		$right_text_color = array(1, 1, 1, 0, 1, 0, 0); }
		$InnerUPCNum = 0;
		while ($InnerUPCNum < count($right_text_color)) {
		if($right_text_color[$InnerUPCNum]==1) {
		imageline($upc_img, $LineStart, 10, $LineStart, $LineSize, $text_color); }
		if($right_text_color[$InnerUPCNum]==0) {
		imageline($upc_img, $LineStart, 10, $LineStart, $LineSize, $alt_text_color); }
		$LineStart += 1;
		++$InnerUPCNum; }
		++$NumZero; }
	imageline($upc_img, 101, 10, 101, 53, $text_color);
	imageline($upc_img, 102, 10, 102, 53, $alt_text_color);
	imageline($upc_img, 103, 10, 103, 53, $text_color);
	imageline($upc_img, 104, 10, 104, 47, $alt_text_color);
	imageline($upc_img, 105, 10, 105, 47, $alt_text_color);
	imageline($upc_img, 106, 10, 106, 47, $alt_text_color);
	imageline($upc_img, 107, 10, 107, 47, $alt_text_color);
	imageline($upc_img, 108, 10, 108, 47, $alt_text_color);
	imageline($upc_img, 109, 10, 109, 47, $alt_text_color);
	imageline($upc_img, 110, 10, 110, 47, $alt_text_color);
	imageline($upc_img, 111, 10, 111, 47, $alt_text_color);
	imageline($upc_img, 112, 10, 112, 47, $alt_text_color);
	if(strlen($supplement)==2) { create_ean2($supplement,113,$upc_img); }
	if(strlen($supplement)==5) { create_ean5($supplement,113,$upc_img); }
	if($resize>1) {
	$new_upc_img = imagecreatetruecolor((113 + $addonsize) * $resize, 62 * $resize);
	imagefilledrectangle($new_upc_img, 0, 0, (113 + $addonsize) * $resize, 62 * $resize, 0xFFFFFF);
	imageinterlace($new_upc_img, true);
	if($resizetype=="resize") {
	imagecopyresized($new_upc_img, $upc_img, 0, 0, 0, 0, (113 + $addonsize) * $resize, 62 * $resize, 113 + $addonsize, 62); }
	if($resizetype=="resample") {
	imagecopyresampled($new_upc_img, $upc_img, 0, 0, 0, 0, (113 + $addonsize) * $resize, 62 * $resize, 113 + $addonsize, 62); }
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