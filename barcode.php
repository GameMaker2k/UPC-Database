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

    $FileInfo: barcode.php - Last Update: 02/13/2012 Ver. 2.2.5 RC 1 - Author: cooldude2k $
*/

require("./settings.php");

if(($_GET['act']=="upca"||$_GET['act']=="upce"||$_GET['act']=="ean8"||
	$_GET['act']=="ean13"||$_GET['act']=="itf14")&&isset($_GET['upc'])) {
	if(!isset($_GET['resize'])||!is_numeric($_GET['resize'])||$_GET['resize']<1) { $_GET['resize'] = 1; }
	if(!isset($_GET['imgtype'])) { $_GET['imgtype'] = "png"; }
	if(strlen($_GET['upc'])==8&&validate_upce($_GET['upc'])===true&&$_GET['act']=="upce") {
	create_barcode($_GET['upc'],$_GET['imgtype'],true,$_GET['resize']); }
	if(strlen($_GET['upc'])==12&&validate_upca($_GET['upc'])===true&&$_GET['act']=="upca") {
	create_barcode($_GET['upc'],$_GET['imgtype'],true,$_GET['resize']); }
	if(strlen($_GET['upc'])==8&&validate_ean8($_GET['upc'])===true&&$_GET['act']=="ean8") {
	create_ean8($_GET['upc'],$_GET['imgtype'],true,$_GET['resize']); }
	if(strlen($_GET['upc'])==13&&validate_ean13($_GET['upc'])===true&&$_GET['act']=="ean13") {
	create_barcode($_GET['upc'],$_GET['imgtype'],true,$_GET['resize']); }
	if(strlen($_GET['upc'])==14&&validate_itf14($_GET['upc'])===true&&$_GET['act']=="itf14") {
	create_barcode($_GET['upc'],$_GET['imgtype'],true,$_GET['resize']); } }
?>