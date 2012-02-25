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

    $FileInfo: functions.php - Last Update: 02/13/2012 Ver. 2.2.5 RC 1 - Author: cooldude2k $
*/
$File3Name = basename($_SERVER['SCRIPT_NAME']);
if ($File3Name=="functions.php"||$File3Name=="/functions.php") {
	chdir("../");
	require("./upc.php");
	exit(); }

/*
UPC Resources and Info
http://en.wikipedia.org/wiki/Universal_Product_Code
http://en.wikipedia.org/wiki/Global_Trade_Item_Number
http://en.wikipedia.org/wiki/Barcode
http://www.ucancode.net/CPP_Library_Control_Tool/Draw-Print-encode-UPCA-barcode-UPCE-barcode-EAN13-barcode-VC-Code.htm
http://en.wikipedia.org/wiki/International_Article_Number
http://www.upcdatabase.com/docs/
http://www.accipiter.org/projects/cat.php
http://www.accipiter.org/download/kittycode.js
http://uscan.sourceforge.net/upc.txt
http://www.adams1.com/upccode.html
http://www.documentmedia.com/Media/PublicationsArticles/QuietZone.pdf
http://zxing.org/w/decode.jspx
http://code.google.com/p/zxing/
http://www.terryburton.co.uk/barcodewriter/generator/
http://en.wikipedia.org/wiki/Interleaved_2_of_5
http://www.gs1au.org/assets/documents/info/user_manuals/barcode_technical_details/ITF_14_Barcode_Structure.pdf
*/

// str_split for php 4 by rlpvandenberg at hotmail dot com
// http://us2.php.net/manual/en/function.str-split.php#79921
if(!function_exists('str_split')) {
function str_split($text, $split = 1){
    //place each character of the string into and array
    $array = array();
    for ($i=0; $i < strlen($text); $i++){
        $key = "";
        for ($j = 0; $j < $split; $j++){
            $key .= $text[$i+$j]; 
        }
        $i = $i + $j - 1;
        array_push($array, $key);
    }
    return $array;
} }

$upcfunctions = array();
// Code for validating UPC/EAN by Kazuki Przyborowski
require("./inc/validate.php");
// Code for converting UPC/EAN by Kazuki Przyborowski
require("./inc/convert.php");
// Code for getting GS1 Prefix EAN-8/EAN-13/ITF-14 by Kazuki Przyborowski
require("./inc/getprefix.php");
// Code for making EAN-2 supplement by Kazuki Przyborowski
require("./inc/ean2.php");
// Code for making EAN-5 supplement by Kazuki Przyborowski
require("./inc/ean5.php");
// Code for making UPC-A by Kazuki Przyborowski
require("./inc/upca.php");
// Code for making UPC-E by Kazuki Przyborowski
require("./inc/upce.php");
// Code for making EAN-13 by Kazuki Przyborowski
require("./inc/ean13.php");
// Code for making EAN-8 by Kazuki Przyborowski
require("./inc/ean8.php");
// Code for making Interleaved 2 of 5 by Kazuki Przyborowski
require("./inc/itf.php");
// Code for making ITF-14 by Kazuki Przyborowski
require("./inc/itf14.php");
// Code for making Code 39 by Kazuki Przyborowski
require("./inc/code39.php");
// Code for making Code 93 by Kazuki Przyborowski
require("./inc/code93.php");
// Code for decoding CueCat codes by Neil McNab
require("./inc/cuecat.php");
// Functions for passwords by Kazuki Przyborowski
require("./inc/password.php");
if(!isset($upcfunctions)) { $upcfunctions = array(); }
if(!is_array($upcfunctions)) { $upcfunctions = array(); }
array_push($upcfunctions, "validate_barcode", "fix_barcode_checksum", "create_barcode");
// Shortcut Codes by Kazuki Przyborowski
function validate_barcode($upc,$return_check=false) {
	if(!isset($upc)||!is_numeric($upc)) { return false; }
	if(strlen($upc)==8) { return validate_upce($upc,$return_check); }
	if(strlen($upc)==12) { return validate_upca($upc,$return_check); }
	if(strlen($upc)==13) { return validate_ean13($upc,$return_check); } 
	if(strlen($upc)==14) { return validate_itf14($upc,$return_check); } 
	return false; }
function fix_barcode_checksum($upc) {
	if(!isset($upc)||!is_numeric($upc)) { return false; }
	if(strlen($upc)==7) { return $upc.validate_upce($upc,true); }
	if(strlen($upc)==11) { return $upc.validate_upca($upc,true); }
	if(strlen($upc)==12) { return $upc.validate_ean13($upc,true); } 
	if(strlen($upc)==13) { return $upc.validate_itf14($upc,true); } 
	return false; }
function create_barcode($upc,$imgtype="png",$outputimage=true,$resize=1,$resizetype="resize",$outfile=NULL,$hidecd=false) {
	if(!isset($upc)||!is_numeric($upc)) { return false; }
	if(!isset($resize)||!preg_match("/^([0-9]*[\.]?[0-9])/", $resize)||$resize<1) { $resize = 1; }
	if($resizetype!="resample"&&$resizetype!="resize") { $resizetype = "resize"; }
	if(strlen($upc)==7||strlen($upc)==8) { 
		return create_upce($upc,$imgtype,$outputimage,$resize,$resizetype,$outfile,$hidecd); }
	if(strlen($upc)==11||strlen($upc)==12) { 
		return create_upca($upc,$imgtype,$outputimage,$resize,$resizetype,$outfile,$hidecd); }
	if(strlen($upc)==13) { return create_ean13($upc,$imgtype,$outputimage,$resize,$resizetype,$outfile,$hidecd); } 
	if(strlen($upc)==14) { return create_itf14($upc,$imgtype,$outputimage,$resize,$resizetype,$outfile,$hidecd); } 
	return false; }
?>