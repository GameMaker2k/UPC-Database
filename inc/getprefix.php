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

    $FileInfo: getprefix.php - Last Update: 02/13/2012 Ver. 2.2.5 RC 1 - Author: cooldude2k $
*/
$File3Name = basename($_SERVER['SCRIPT_NAME']);
if ($File3Name=="getprefix.php"||$File3Name=="/getprefix.php") {
	chdir("../");
	require("./upc.php");
	exit(); }

if(!isset($upcfunctions)) { $upcfunctions = array(); }
if(!is_array($upcfunctions)) { $upcfunctions = array(); }
array_push($upcfunctions, "get_gs1_prefix", "get_upca_ns", "get_itf14_type", "get_upca_vw_info", "get_upca_vw_code", "get_upca_vw_price", "get_upca_vw_pricecs", "get_upca_coupon_info", "get_upca_coupon_manufacturer", "get_upca_coupon_family", "get_upca_coupon_value");
// Get GS1 Prefix for EAN-13 EAN-9 barcodes
// Source: http://en.wikipedia.org/wiki/List_of_GS1_country_codes
function get_gs1_prefix($upc) {
	if(preg_match("/^(\d{12})$/", $upc, $fix_ean)) { $upc = "0".$upc; }
	if(preg_match("/^0(\d{3}\d{10})$/", $upc, $fix_ean)) { $upc = $fix_ean[1]; }
	if(!preg_match("/^(\d{3}\d{5}|\d{3}\d{10})$/", $upc)) { return false; }
	if(preg_match("/^(\d{3}\d{10})$/", $upc)&&validate_ean13($upc)===false) { return false; }
	if(preg_match("/^(\d{3}\d{5})$/", $upc)&&validate_ean8($upc)===false) { return false; }
	if(preg_match("/^(0[0-1][0-9])/", $upc)) { return "United States and Canada"; }
	if(preg_match("/^(02[0-9])/", $upc)) { return "Restricted distribution"; }
	if(preg_match("/^(03[0-9])/", $upc)) { return "United States drugs"; }
	if(preg_match("/^(04[0-9])/", $upc)) { return "Restricted distribution"; }
	if(preg_match("/^(05[0-9])/", $upc)) { return "Coupons"; }
	if(preg_match("/^(0[6-9][0-9])/", $upc)) { return "United States and Canada"; }
	if(preg_match("/^(1[0-3][0-9])/", $upc)) { return "United States"; }
	if(preg_match("/^(2[0-9][0-9])/", $upc)) { return "Restricted distribution"; }
	if(preg_match("/^(3[0-7][0-9])/", $upc)) { return "France and Monaco"; }
	if(preg_match("/^(380)/", $upc)) { return "Bulgaria"; }
	if(preg_match("/^(383)/", $upc)) { return "Slovenia"; }
	if(preg_match("/^(385)/", $upc)) { return "Croatia"; }
	if(preg_match("/^(387)/", $upc)) { return "Bosnia and Herzegovina"; }
	if(preg_match("/^(389)/", $upc)) { return "Montenegro"; }
	if(preg_match("/^(4[0-3][0-9]|440)/", $upc)) { return "Germany"; }
	if(preg_match("/^(4[0-5][0-9])/", $upc)) { return "Japan"; }
	if(preg_match("/^(46[0-9])/", $upc)) { return "Russia"; }
	if(preg_match("/^(470)/", $upc)) { return "Kyrgyzstan"; }
	if(preg_match("/^(471)/", $upc)) { return "Taiwan"; }
	if(preg_match("/^(474)/", $upc)) { return "Estonia"; }
	if(preg_match("/^(475)/", $upc)) { return "Latvia"; }
	if(preg_match("/^(476)/", $upc)) { return "Azerbaijan"; }
	if(preg_match("/^(477)/", $upc)) { return "Lithuania"; }
	if(preg_match("/^(478)/", $upc)) { return "Uzbekistan"; }
	if(preg_match("/^(479)/", $upc)) { return "Sri Lanka"; }
	if(preg_match("/^(480)/", $upc)) { return "Philippines"; }
	if(preg_match("/^(481)/", $upc)) { return "Belarus"; }
	if(preg_match("/^(482)/", $upc)) { return "Ukraine"; }
	if(preg_match("/^(484)/", $upc)) { return "Moldova"; }
	if(preg_match("/^(485)/", $upc)) { return "Armenia"; }
	if(preg_match("/^(486)/", $upc)) { return "Georgia"; }
	if(preg_match("/^(487)/", $upc)) { return "Kazakhstan"; }
	if(preg_match("/^(488)/", $upc)) { return "Tajikistan"; }
	if(preg_match("/^(489)/", $upc)) { return "Hong Kong SAR"; }
	if(preg_match("/^(49[0-9])/", $upc)) { return "Japan"; }
	if(preg_match("/^(50[0-9])/", $upc)) { return "United Kingdom"; }
	if(preg_match("/^(52[0-1])/", $upc)) { return "Greece"; }
	if(preg_match("/^(528)/", $upc)) { return "Lebanon"; }
	if(preg_match("/^(529)/", $upc)) { return "Cyprus"; }
	if(preg_match("/^(530)/", $upc)) { return "Albania"; }
	if(preg_match("/^(531)/", $upc)) { return "F.Y.R.O. Macedonia"; }
	if(preg_match("/^(535)/", $upc)) { return "Malta"; }
	if(preg_match("/^(539)/", $upc)) { return "Ireland"; }
	if(preg_match("/^(54[0-9])/", $upc)) { return "Belgium and Luxembourg"; }
	if(preg_match("/^(560)/", $upc)) { return "Portugal"; }
	if(preg_match("/^(569)/", $upc)) { return "Iceland"; }
	if(preg_match("/^(57[0-9])/", $upc)) { return "Denmark, Faroe Islands and Greenland"; }
	if(preg_match("/^(590)/", $upc)) { return "Poland"; }
	if(preg_match("/^(594)/", $upc)) { return "Romania"; }
	if(preg_match("/^(599)/", $upc)) { return "Hungary"; }
	if(preg_match("/^(60[0-1])/", $upc)) { return "South Africa"; }
	if(preg_match("/^(603)/", $upc)) { return "Ghana"; }
	if(preg_match("/^(604)/", $upc)) { return "Senegal"; }
	if(preg_match("/^(608)/", $upc)) { return "Bahrain"; }
	if(preg_match("/^(609)/", $upc)) { return "Mauritius"; }
	if(preg_match("/^(611)/", $upc)) { return "Morocco"; }
	if(preg_match("/^(613)/", $upc)) { return "Algeria"; }
	if(preg_match("/^(615)/", $upc)) { return "Nigeria"; }
	if(preg_match("/^(616)/", $upc)) { return "Kenya"; }
	if(preg_match("/^(618)/", $upc)) { return "Côte d'Ivoire"; }
	if(preg_match("/^(619)/", $upc)) { return "Tunisia"; }
	if(preg_match("/^(621)/", $upc)) { return "Syria"; }
	if(preg_match("/^(622)/", $upc)) { return "Egypt"; }
	if(preg_match("/^(624)/", $upc)) { return "Libya"; }
	if(preg_match("/^(625)/", $upc)) { return "Jordan"; }
	if(preg_match("/^(626)/", $upc)) { return "Iran"; }
	if(preg_match("/^(627)/", $upc)) { return "Kuwait"; }
	if(preg_match("/^(628)/", $upc)) { return "Saudi Arabia"; }
	if(preg_match("/^(629)/", $upc)) { return "United Arab Emirates"; }
	if(preg_match("/^(64[0-9])/", $upc)) { return "Finland"; }
	if(preg_match("/^(69[0-5])/", $upc)) { return "China"; }
	if(preg_match("/^(70[0-9])/", $upc)) { return "Norway"; }
	if(preg_match("/^(729)/", $upc)) { return "Israel"; }
	if(preg_match("/^(73[0-9])/", $upc)) { return "Sweden"; }
	if(preg_match("/^(740)/", $upc)) { return "Guatemala"; }
	if(preg_match("/^(741)/", $upc)) { return "El Salvador"; }
	if(preg_match("/^(742)/", $upc)) { return "Honduras"; }
	if(preg_match("/^(743)/", $upc)) { return "Nicaragua"; }
	if(preg_match("/^(744)/", $upc)) { return "Costa Rica"; }
	if(preg_match("/^(745)/", $upc)) { return "Panama"; }
	if(preg_match("/^(746)/", $upc)) { return "Dominican Republic"; }
	if(preg_match("/^(750)/", $upc)) { return "Mexico"; }
	if(preg_match("/^(75[4-5])/", $upc)) { return "Canada"; }
	if(preg_match("/^(759)/", $upc)) { return "Venezuela"; }
	if(preg_match("/^(76[0-9])/", $upc)) { return "Switzerland and Liechtenstein"; }
	if(preg_match("/^(77[0-1])/", $upc)) { return "Colombia"; }
	if(preg_match("/^(773)/", $upc)) { return "Uruguay"; }
	if(preg_match("/^(775)/", $upc)) { return "Peru"; }
	if(preg_match("/^(777)/", $upc)) { return "Bolivia"; }
	if(preg_match("/^(77[8-9])/", $upc)) { return "Argentina"; }
	if(preg_match("/^(780)/", $upc)) { return "Chile"; }
	if(preg_match("/^(784)/", $upc)) { return "Paraguay"; }
	if(preg_match("/^(786)/", $upc)) { return "Ecuador"; }
	if(preg_match("/^(789|790)/", $upc)) { return "Brazil"; }
	if(preg_match("/^(8[0-3][0-9])/", $upc)) { return "Italy, San Marino and Vatican City"; }
	if(preg_match("/^(84[0-9])/", $upc)) { return "Spain and Andorra"; }
	if(preg_match("/^(850)/", $upc)) { return "Cuba"; }
	if(preg_match("/^(858)/", $upc)) { return "Slovakia"; }
	if(preg_match("/^(859)/", $upc)) { return "Czech Republic"; }
	if(preg_match("/^(860)/", $upc)) { return "Serbia"; }
	if(preg_match("/^(865)/", $upc)) { return "Mongolia"; }
	if(preg_match("/^(867)/", $upc)) { return "North Korea"; }
	if(preg_match("/^(86[8-9])/", $upc)) { return "Turkey"; }
	if(preg_match("/^(87[0-9])/", $upc)) { return "Netherlands"; }
	if(preg_match("/^(880)/", $upc)) { return "South Korea"; }
	if(preg_match("/^(884)/", $upc)) { return "Cambodia"; }
	if(preg_match("/^(885)/", $upc)) { return "Thailand"; }
	if(preg_match("/^(888)/", $upc)) { return "Singapore"; }
	if(preg_match("/^(890)/", $upc)) { return "India"; }
	if(preg_match("/^(893)/", $upc)) { return "Vietnam"; }
	if(preg_match("/^(894)/", $upc)) { return "Bangladesh"; }
	if(preg_match("/^(896)/", $upc)) { return "Pakistan"; }
	if(preg_match("/^(899)/", $upc)) { return "Indonesia"; }
	if(preg_match("/^(9[0-1][0-9])/", $upc)) { return "Austria"; }
	if(preg_match("/^(93[0-9])/", $upc)) { return "Australia"; }
	if(preg_match("/^(94[0-9])/", $upc)) { return "New Zealand"; }
	if(preg_match("/^(950)/", $upc)) { return "GS1 Global Office: Special applications"; }
	if(preg_match("/^(951)/", $upc)) { return "EPCglobal: Special applications"; }
	if(preg_match("/^(955)/", $upc)) { return "Malaysia"; }
	if(preg_match("/^(958)/", $upc)) { return "Macau"; }
	if(preg_match("/^(96[0-9])/", $upc)) { return "GS1 Global Office: GTIN-8 allocations"; }
	if(preg_match("/^(977)/", $upc)) { return "Serial publications (ISSN)"; }
	if(preg_match("/^(97[8-9])/", $upc)) { return "Bookland (ISBN)"; }
	if(preg_match("/^(980)/", $upc)) { return "Refund receipts"; }
	if(preg_match("/^(98[1-3])/", $upc)) { return "Common Currency Coupons"; }
	if(preg_match("/^(99[0-9])/", $upc)) { return "Coupons"; }
	// Reserved for future use
	if(preg_match("/^(1[4-9][0-9])/", $upc)) { return "Reserved for future use"; }
	if(preg_match("/^(381|382|384|386|388)/", $upc)) { return "Reserved for future use"; }
	if(preg_match("/^(39[0-9])/", $upc)) { return "Reserved for future use"; }
	if(preg_match("/^(44[1-9])/", $upc)) { return "Reserved for future use"; }
	if(preg_match("/^(472|473|483)/", $upc)) { return "Reserved for future use"; }
	if(preg_match("/^(51[0-9])/", $upc)) { return "Reserved for future use"; }
	if(preg_match("/^(52[1-7])/", $upc)) { return "Reserved for future use"; }
	if(preg_match("/^(53[2-4])/", $upc)) { return "Reserved for future use"; }
	if(preg_match("/^(53[6-8])/", $upc)) { return "Reserved for future use"; }
	if(preg_match("/^(55[0-9])/", $upc)) { return "Reserved for future use"; }
	if(preg_match("/^(56[1-8])/", $upc)) { return "Reserved for future use"; }
	if(preg_match("/^(58[0-9])/", $upc)) { return "Reserved for future use"; }
	if(preg_match("/^(59[1-3])/", $upc)) { return "Reserved for future use"; }
	if(preg_match("/^(59[5-8])/", $upc)) { return "Reserved for future use"; }
	if(preg_match("/^(602)/", $upc)) { return "Reserved for future use"; }
	if(preg_match("/^(60[5-7])/", $upc)) { return "Reserved for future use"; }
	if(preg_match("/^(610|612|614|617|620|623)/", $upc)) { return "Reserved for future use"; }
	if(preg_match("/^(63[0-9])/", $upc)) { return "Reserved for future use"; }
	if(preg_match("/^(6[5-8][0-9])/", $upc)) { return "Reserved for future use"; }
	if(preg_match("/^(69[6-9])/", $upc)) { return "Reserved for future use"; }
	if(preg_match("/^(71[0-9]|72[0-8])/", $upc)) { return "Reserved for future use"; }
	if(preg_match("/^(74[7-9])/", $upc)) { return "Reserved for future use"; }
	if(preg_match("/^(75[1-3])/", $upc)) { return "Reserved for future use"; }
	if(preg_match("/^(75[6-8])/", $upc)) { return "Reserved for future use"; }
	if(preg_match("/^(772|774|776|778)/", $upc)) { return "Reserved for future use"; }
	if(preg_match("/^(78[1-3])/", $upc)) { return "Reserved for future use"; }
	if(preg_match("/^(785|787|788)/", $upc)) { return "Reserved for future use"; }
	if(preg_match("/^(79[1-9])/", $upc)) { return "Reserved for future use"; }
	if(preg_match("/^(85[1-7])/", $upc)) { return "Reserved for future use"; }
	if(preg_match("/^(86[1-4])/", $upc)) { return "Reserved for future use"; }
	if(preg_match("/^(866)/", $upc)) { return "Reserved for future use"; }
	if(preg_match("/^(88[1-3])/", $upc)) { return "Reserved for future use"; }
	if(preg_match("/^(886|887|889|891|892|895|897|898)/", $upc)) { return "Reserved for future use"; }
	if(preg_match("/^(92[0-9])/", $upc)) { return "Reserved for future use"; }
	if(preg_match("/^(95[2-4])/", $upc)) { return "Reserved for future use"; }
	if(preg_match("/^(956|957|959)/", $upc)) { return "Reserved for future use"; }
	if(preg_match("/^(96[0-9]|97[0-6])/", $upc)) { return "Reserved for future use"; }
	if(preg_match("/^(98[4-9])/", $upc)) { return "Reserved for future use"; }
	return false; }
// Get Number System Prefix for UPC-A barcodes
// Source: http://www.morovia.com/education/symbology/upc-a.asp
// Source: http://www.computalabel.com/aboutupc.htm
function get_upca_ns($upc) {
	if(preg_match("/^0(\d{12})/", $upc, $upc_matches)) { $upc = $upc_matches[1]; }
	if(!preg_match("/^(\d{12})$/", $upc)) { return false; }
	if(preg_match("/^(0)/", $upc)) { return "Regular UPC"; }
	if(preg_match("/^(1)/", $upc)) { return "Regular UPC"; }
	if(preg_match("/^(2)/", $upc)) { return "Variable Weight Items"; }
	if(preg_match("/^(3)/", $upc)) { return "Drug/Health Items"; }
	if(preg_match("/^(4)/", $upc)) { return "In-store use"; }
	if(preg_match("/^(5)/", $upc)) { return "Coupons"; }
	if(preg_match("/^(6)/", $upc)) { return "Regular UPC"; }
	if(preg_match("/^(7)/", $upc)) { return "Regular UPC"; }
	if(preg_match("/^(8)/", $upc)) { return "Regular UPC"; }
	if(preg_match("/^(9)/", $upc)) { return "Coupons"; }
	return false; }
// Get ITF-14 Packaging Indicator
// Source: http://www.mecsw.com/specs/itf_14.html
// Source: http://www.qed.org/RBTL/chapters/ch3.3.htm
function get_itf14_type($upc) {
	if(!preg_match("/^(\d{14})$/", $upc)) { return false; }
	if(preg_match("/^(0)/", $upc)) { return "UPC code of contents differs from case code"; }
	if(preg_match("/^(1)/", $upc)) { return "More than each and below inner packs"; }
	if(preg_match("/^(2)/", $upc)) { return "More than each and below inner packs"; }
	if(preg_match("/^(3)/", $upc)) { return "Inner packs"; }
	if(preg_match("/^(4)/", $upc)) { return "Inner packs"; }
	if(preg_match("/^(5)/", $upc)) { return "Shipping containers (cartons)"; }
	if(preg_match("/^(6)/", $upc)) { return "Shipping containers (cartons)"; }
	if(preg_match("/^(7)/", $upc)) { return "Pallet"; }
	if(preg_match("/^(8)/", $upc)) { return "Reserved"; }
	if(preg_match("/^(9)/", $upc)) { return "Variable quantity content"; }
	return false; }
// Get variable weight info
// Source: http://wiki.answers.com/Q/How_does_a_price_embedded_bar_code_work
// Source: http://en.wikipedia.org/wiki/Universal_Product_Code#Prefixes
function get_upca_vw_info($upc) {
	if(preg_match("/^0(\d{12})/", $upc, $upc_matches)) { $upc = $upc_matches[1]; }
	if(!preg_match("/^(\d{12})$/", $upc)) { return false; }
	if(!preg_match("/^2(\d{11})/", $upc)) { return false; }
	preg_match("/^2(\d{5})(\d{1})(\d{4})(\d{1})/", $upc, $upc_matches);
	$product['code'] = $upc_matches[1];
	$product['pricecs'] = $upc_matches[2];
	$product['price'] = $upc_matches[3];
	return $product; }
function get_upca_vw_code($upc) {
	$product = get_upca_vw_info($upc);
	if($product===false) { return false; }
	return $product['code']; }
function get_upca_vw_price($upc) {
	$product = get_upca_vw_info($upc);
	if($product===false) { return false; }
	return $product['price']; }
function get_upca_vw_pricecs($upc) {
	$product = get_upca_vw_info($upc);
	if($product===false) { return false; }
	return $product['pricecs']; }
// Get coupon info
// Source: http://divagirlusa-ivil.tripod.com/austinitecouponers/id29.html
function get_upca_coupon_info($upc) {
	if(preg_match("/^0(\d{12})/", $upc, $upc_matches)) { $upc = $upc_matches[1]; }
	if(!preg_match("/^(\d{12})$/", $upc)) { return false; }
	if(!preg_match("/^(5|9)(\d{11})/", $upc)) { return false; }
	preg_match("/^(5|9)(\d{5})(\d{3})(\d{2})(\d{1})/", $upc, $upc_matches);
	$product['manufacturer'] = $upc_matches[2];
	$product['family'] = $upc_matches[3];
	$product['value'] = $upc_matches[4];
	return $product; }
function get_upca_coupon_manufacturer($upc) {
	$product = get_upca_coupon_info($upc);
	if($product===false) { return false; }
	return $product['manufacturer']; }
function get_upca_coupon_family($upc) {
	$product = get_upca_coupon_info($upc);
	if($product===false) { return false; }
	return $product['family']; }
function get_upca_coupon_value($upc) {
	$product = get_upca_coupon_info($upc);
	if($product===false) { return false; }
	return $product['value']; }
?>