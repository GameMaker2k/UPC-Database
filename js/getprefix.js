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

    $FileInfo: getprefix.js - Last Update: 02/13/2012 Ver. 2.2.5 RC 1 - Author: cooldude2k $
*/

// Get GS1 Prefix for EAN-13 EAN-9 barcodes
// Source: http://en.wikipedia.org/wiki/List_of_GS1_country_codes
function get_gs1_prefix(upc) {
	if(upc.match(/^(\d{12})/)) { upc = "0"+upc; }
	if(upc.match(/^0(\d{3}\d{10})/)) { 
	fix_ean = upc.match(/^0(\d{3}\d{10})/); upc = fix_ean[1]; }
	if(!upc.match(/^(\d{3}\d{5}|\d{3}\d{10})/)) { return false; }
	if(upc.match(/^(\d{3}\d{10})/)&&validate_ean13(upc)==false) { return false; }
	if(upc.match(/^(\d{3}\d{5})/)&&validate_ean8(upc)==false) { return false; }
	if(upc.match(/^(0[0-1][0-9])/)) { return "United States and Canada"; }
	if(upc.match(/^(02[0-9])/)) { return "Restricted distribution"; }
	if(upc.match(/^(03[0-9])/)) { return "United States drugs"; }
	if(upc.match(/^(04[0-9])/)) { return "Restricted distribution"; }
	if(upc.match(/^(05[0-9])/)) { return "Coupons"; }
	if(upc.match(/^(0[6-9][0-9])/)) { return "United States and Canada"; }
	if(upc.match(/^(1[0-3][0-9])/)) { return "United States"; }
	if(upc.match(/^(2[0-9][0-9])/)) { return "Restricted distribution"; }
	if(upc.match(/^(3[0-7][0-9])/)) { return "France and Monaco"; }
	if(upc.match(/^(380)/)) { return "Bulgaria"; }
	if(upc.match(/^(383)/)) { return "Slovenia"; }
	if(upc.match(/^(385)/)) { return "Croatia"; }
	if(upc.match(/^(387)/)) { return "Bosnia and Herzegovina"; }
	if(upc.match(/^(389)/)) { return "Montenegro"; }
	if(upc.match(/^(4[0-3][0-9]|440)/)) { return "Germany"; }
	if(upc.match(/^(4[0-5][0-9])/)) { return "Japan"; }
	if(upc.match(/^(46[0-9])/)) { return "Russia"; }
	if(upc.match(/^(470)/)) { return "Kyrgyzstan"; }
	if(upc.match(/^(471)/)) { return "Taiwan"; }
	if(upc.match(/^(474)/)) { return "Estonia"; }
	if(upc.match(/^(475)/)) { return "Latvia"; }
	if(upc.match(/^(476)/)) { return "Azerbaijan"; }
	if(upc.match(/^(477)/)) { return "Lithuania"; }
	if(upc.match(/^(478)/)) { return "Uzbekistan"; }
	if(upc.match(/^(479)/)) { return "Sri Lanka"; }
	if(upc.match(/^(480)/)) { return "Philippines"; }
	if(upc.match(/^(481)/)) { return "Belarus"; }
	if(upc.match(/^(482)/)) { return "Ukraine"; }
	if(upc.match(/^(484)/)) { return "Moldova"; }
	if(upc.match(/^(485)/)) { return "Armenia"; }
	if(upc.match(/^(486)/)) { return "Georgia"; }
	if(upc.match(/^(487)/)) { return "Kazakhstan"; }
	if(upc.match(/^(488)/)) { return "Tajikistan"; }
	if(upc.match(/^(489)/)) { return "Hong Kong SAR"; }
	if(upc.match(/^(49[0-9])/)) { return "Japan"; }
	if(upc.match(/^(50[0-9])/)) { return "United Kingdom"; }
	if(upc.match(/^(52[0-1])/)) { return "Greece"; }
	if(upc.match(/^(528)/)) { return "Lebanon"; }
	if(upc.match(/^(529)/)) { return "Cyprus"; }
	if(upc.match(/^(530)/)) { return "Albania"; }
	if(upc.match(/^(531)/)) { return "F.Y.R.O. Macedonia"; }
	if(upc.match(/^(535)/)) { return "Malta"; }
	if(upc.match(/^(539)/)) { return "Ireland"; }
	if(upc.match(/^(54[0-9])/)) { return "Belgium and Luxembourg"; }
	if(upc.match(/^(560)/)) { return "Portugal"; }
	if(upc.match(/^(569)/)) { return "Iceland"; }
	if(upc.match(/^(57[0-9])/)) { return "Denmark, Faroe Islands and Greenland"; }
	if(upc.match(/^(590)/)) { return "Poland"; }
	if(upc.match(/^(594)/)) { return "Romania"; }
	if(upc.match(/^(599)/)) { return "Hungary"; }
	if(upc.match(/^(60[0-1])/)) { return "South Africa"; }
	if(upc.match(/^(603)/)) { return "Ghana"; }
	if(upc.match(/^(604)/)) { return "Senegal"; }
	if(upc.match(/^(608)/)) { return "Bahrain"; }
	if(upc.match(/^(609)/)) { return "Mauritius"; }
	if(upc.match(/^(611)/)) { return "Morocco"; }
	if(upc.match(/^(613)/)) { return "Algeria"; }
	if(upc.match(/^(615)/)) { return "Nigeria"; }
	if(upc.match(/^(616)/)) { return "Kenya"; }
	if(upc.match(/^(618)/)) { return "Côte d'Ivoire"; }
	if(upc.match(/^(619)/)) { return "Tunisia"; }
	if(upc.match(/^(621)/)) { return "Syria"; }
	if(upc.match(/^(622)/)) { return "Egypt"; }
	if(upc.match(/^(624)/)) { return "Libya"; }
	if(upc.match(/^(625)/)) { return "Jordan"; }
	if(upc.match(/^(626)/)) { return "Iran"; }
	if(upc.match(/^(627)/)) { return "Kuwait"; }
	if(upc.match(/^(628)/)) { return "Saudi Arabia"; }
	if(upc.match(/^(629)/)) { return "United Arab Emirates"; }
	if(upc.match(/^(64[0-9])/)) { return "Finland"; }
	if(upc.match(/^(69[0-5])/)) { return "China"; }
	if(upc.match(/^(70[0-9])/)) { return "Norway"; }
	if(upc.match(/^(729)/)) { return "Israel"; }
	if(upc.match(/^(73[0-9])/)) { return "Sweden"; }
	if(upc.match(/^(740)/)) { return "Guatemala"; }
	if(upc.match(/^(741)/)) { return "El Salvador"; }
	if(upc.match(/^(742)/)) { return "Honduras"; }
	if(upc.match(/^(743)/)) { return "Nicaragua"; }
	if(upc.match(/^(744)/)) { return "Costa Rica"; }
	if(upc.match(/^(745)/)) { return "Panama"; }
	if(upc.match(/^(746)/)) { return "Dominican Republic"; }
	if(upc.match(/^(750)/)) { return "Mexico"; }
	if(upc.match(/^(75[4-5])/)) { return "Canada"; }
	if(upc.match(/^(759)/)) { return "Venezuela"; }
	if(upc.match(/^(76[0-9])/)) { return "Switzerland and Liechtenstein"; }
	if(upc.match(/^(77[0-1])/)) { return "Colombia"; }
	if(upc.match(/^(773)/)) { return "Uruguay"; }
	if(upc.match(/^(775)/)) { return "Peru"; }
	if(upc.match(/^(777)/)) { return "Bolivia"; }
	if(upc.match(/^(77[8-9])/)) { return "Argentina"; }
	if(upc.match(/^(780)/)) { return "Chile"; }
	if(upc.match(/^(784)/)) { return "Paraguay"; }
	if(upc.match(/^(786)/)) { return "Ecuador"; }
	if(upc.match(/^(789|790)/)) { return "Brazil"; }
	if(upc.match(/^(8[0-3][0-9])/)) { return "Italy, San Marino and Vatican City"; }
	if(upc.match(/^(84[0-9])/)) { return "Spain and Andorra"; }
	if(upc.match(/^(850)/)) { return "Cuba"; }
	if(upc.match(/^(858)/)) { return "Slovakia"; }
	if(upc.match(/^(859)/)) { return "Czech Republic"; }
	if(upc.match(/^(860)/)) { return "Serbia"; }
	if(upc.match(/^(865)/)) { return "Mongolia"; }
	if(upc.match(/^(867)/)) { return "North Korea"; }
	if(upc.match(/^(86[8-9])/)) { return "Turkey"; }
	if(upc.match(/^(87[0-9])/)) { return "Netherlands"; }
	if(upc.match(/^(880)/)) { return "South Korea"; }
	if(upc.match(/^(884)/)) { return "Cambodia"; }
	if(upc.match(/^(885)/)) { return "Thailand"; }
	if(upc.match(/^(888)/)) { return "Singapore"; }
	if(upc.match(/^(890)/)) { return "India"; }
	if(upc.match(/^(893)/)) { return "Vietnam"; }
	if(upc.match(/^(894)/)) { return "Bangladesh"; }
	if(upc.match(/^(896)/)) { return "Pakistan"; }
	if(upc.match(/^(899)/)) { return "Indonesia"; }
	if(upc.match(/^(9[0-1][0-9])/)) { return "Austria"; }
	if(upc.match(/^(93[0-9])/)) { return "Australia"; }
	if(upc.match(/^(94[0-9])/)) { return "New Zealand"; }
	if(upc.match(/^(950)/)) { return "GS1 Global Office: Special applications"; }
	if(upc.match(/^(951)/)) { return "EPCglobal: Special applications"; }
	if(upc.match(/^(955)/)) { return "Malaysia"; }
	if(upc.match(/^(958)/)) { return "Macau"; }
	if(upc.match(/^(96[0-9])/)) { return "GS1 Global Office: GTIN-8 allocations"; }
	if(upc.match(/^(977)/)) { return "Serial publications (ISSN)"; }
	if(upc.match(/^(97[8-9])/)) { return "Bookland (ISBN)"; }
	if(upc.match(/^(980)/)) { return "Refund receipts"; }
	if(upc.match(/^(98[1-3])/)) { return "Common Currency Coupons"; }
	if(upc.match(/^(99[0-9])/)) { return "Coupons"; }
	// Reserved for future use
	if(upc.match(/^(1[4-9][0-9])/)) { return "Reserved for future use"; }
	if(upc.match(/^(381|382|384|386|388)/)) { return "Reserved for future use"; }
	if(upc.match(/^(39[0-9])/)) { return "Reserved for future use"; }
	if(upc.match(/^(44[1-9])/)) { return "Reserved for future use"; }
	if(upc.match(/^(472|473|483)/)) { return "Reserved for future use"; }
	if(upc.match(/^(51[0-9])/)) { return "Reserved for future use"; }
	if(upc.match(/^(52[1-7])/)) { return "Reserved for future use"; }
	if(upc.match(/^(53[2-4])/)) { return "Reserved for future use"; }
	if(upc.match(/^(53[6-8])/)) { return "Reserved for future use"; }
	if(upc.match(/^(55[0-9])/)) { return "Reserved for future use"; }
	if(upc.match(/^(56[1-8])/)) { return "Reserved for future use"; }
	if(upc.match(/^(58[0-9])/)) { return "Reserved for future use"; }
	if(upc.match(/^(59[1-3])/)) { return "Reserved for future use"; }
	if(upc.match(/^(59[5-8])/)) { return "Reserved for future use"; }
	if(upc.match(/^(602)/)) { return "Reserved for future use"; }
	if(upc.match(/^(60[5-7])/)) { return "Reserved for future use"; }
	if(upc.match(/^(610|612|614|617|620|623)/)) { return "Reserved for future use"; }
	if(upc.match(/^(63[0-9])/)) { return "Reserved for future use"; }
	if(upc.match(/^(6[5-8][0-9])/)) { return "Reserved for future use"; }
	if(upc.match(/^(69[6-9])/)) { return "Reserved for future use"; }
	if(upc.match(/^(71[0-9]|72[0-8])/)) { return "Reserved for future use"; }
	if(upc.match(/^(74[7-9])/)) { return "Reserved for future use"; }
	if(upc.match(/^(75[1-3])/)) { return "Reserved for future use"; }
	if(upc.match(/^(75[6-8])/)) { return "Reserved for future use"; }
	if(upc.match(/^(772|774|776|778)/)) { return "Reserved for future use"; }
	if(upc.match(/^(78[1-3])/)) { return "Reserved for future use"; }
	if(upc.match(/^(785|787|788)/)) { return "Reserved for future use"; }
	if(upc.match(/^(79[1-9])/)) { return "Reserved for future use"; }
	if(upc.match(/^(85[1-7])/)) { return "Reserved for future use"; }
	if(upc.match(/^(86[1-4])/)) { return "Reserved for future use"; }
	if(upc.match(/^(866)/)) { return "Reserved for future use"; }
	if(upc.match(/^(88[1-3])/)) { return "Reserved for future use"; }
	if(upc.match(/^(886|887|889|891|892|895|897|898)/)) { return "Reserved for future use"; }
	if(upc.match(/^(92[0-9])/)) { return "Reserved for future use"; }
	if(upc.match(/^(95[2-4])/)) { return "Reserved for future use"; }
	if(upc.match(/^(956|957|959)/)) { return "Reserved for future use"; }
	if(upc.match(/^(96[0-9]|97[0-6])/)) { return "Reserved for future use"; }
	if(upc.match(/^(98[4-9])/)) { return "Reserved for future use"; }
	return false; }
// Get Number System Prefix for UPC-A barcodes
// Source: http://www.morovia.com/education/symbology/upc-a.asp
// Source: http://www.computalabel.com/aboutupc.htm
function get_upca_ns(upc) {
	if(upc.match(/^0(\d{12})/)) { 
	upc_matches = upc.match(/^0(\d{12})/); upc = upc_matches[1]; }
	if(!upc.match(/^(\d{12})/)) { return false; }
	if(upc.match(/^(0)/)) { return "Regular UPC"; }
	if(upc.match(/^(1)/)) { return "Regular UPC"; }
	if(upc.match(/^(2)/)) { return "Variable Weight Items"; }
	if(upc.match(/^(3)/)) { return "Drug/Health Items"; }
	if(upc.match(/^(4)/)) { return "In-store use"; }
	if(upc.match(/^(5)/)) { return "Coupons"; }
	if(upc.match(/^(6)/)) { return "Regular UPC"; }
	if(upc.match(/^(7)/)) { return "Regular UPC"; }
	if(upc.match(/^(8)/)) { return "Regular UPC"; }
	if(upc.match(/^(9)/)) { return "Coupons"; }
	return false; }
// Get ITF-14 Packaging Indicator
// Source: http://www.mecsw.com/specs/itf_14.html
// Source: http://www.qed.org/RBTL/chapters/ch3.3.htm
function get_itf14_type(upc) {
	if(!upc.match(/^(\d{14})/)) { return false; }
	if(upc.match(/^(0)/)) { return "UPC code of contents differs from case code"; }
	if(upc.match(/^(1)/)) { return "More than each and below inner packs"; }
	if(upc.match(/^(2)/)) { return "More than each and below inner packs"; }
	if(upc.match(/^(3)/)) { return "Inner packs"; }
	if(upc.match(/^(4)/)) { return "Inner packs"; }
	if(upc.match(/^(5)/)) { return "Shipping containers (cartons)"; }
	if(upc.match(/^(6)/)) { return "Shipping containers (cartons)"; }
	if(upc.match(/^(7)/)) { return "Pallet"; }
	if(upc.match(/^(8)/)) { return "Reserved"; }
	if(upc.match(/^(9)/)) { return "Variable quantity content"; }
	return false; }
// Get variable weight info
// Source: http://wiki.answers.com/Q/How_does_a_price_embedded_bar_code_work
// Source: http://en.wikipedia.org/wiki/Universal_Product_Code#Prefixes
function get_upca_vw_info(upc) {
	if(upc.match(/^0(\d{12})/)) { 
	upc_matches = upc.match(/^0(\d{12})/); upc = upc_matches[1]; }
	if(!upc.match(/^(\d{12})/)) { return false; }
	if(!upc.match(/^2(\d{11})/)) { return false; }
	upc_matches = upc.match(/^2(\d{5})(\d{1})(\d{4})(\d{1})/);
	product['code'] = upc_matches[1];
	product['pricecs'] = upc_matches[2];
	product['price'] = upc_matches[3];
	return product; }
function get_upca_vw_code(upc) {
	product = get_upca_vw_info(upc);
	if(product==false) { return false; }
	return product['code']; }
function get_upca_vw_price(upc) {
	product = get_upca_vw_info(upc);
	if(product==false) { return false; }
	return product['price']; }
function get_upca_vw_pricecs(upc) {
	product = get_upca_vw_info(upc);
	if(product==false) { return false; }
	return product['pricecs']; }
// Get coupon info
// Source: http://divagirlusa-ivil.tripod.com/austinitecouponers/id29.html
function get_upca_coupon_info(upc) {
	if(upc.match(/^0(\d{12})/)) { 
	upc_matches = upc.match(/^0(\d{12})/); upc = upc_matches[1]; }
	if(!upc.match(/^(\d{12})/)) { return false; }
	if(!upc.match(/^(5|9)(\d{11})/)) { return false; }
	upc_matches = upc.match(/^(5|9)(\d{5})(\d{3})(\d{2})(\d{1})/);
	product['manufacturer'] = upc_matches[2];
	product['family'] = upc_matches[3];
	product['value'] = upc_matches[4];
	return product; }
function get_upca_coupon_manufacturer(upc) {
	product = get_upca_coupon_info(upc);
	if(product==false) { return false; }
	return product['manufacturer']; }
function get_upca_coupon_family(upc) {
	product = get_upca_coupon_info(upc);
	if(product==false) { return false; }
	return product['family']; }
function get_upca_coupon_value(upc) {
	product = get_upca_coupon_info(upc);
	if(product==false) { return false; }
	return product['value']; }
function get_upca_coupon_value_code(vcode) {
	if(vcode.match(/^(00)/)) { return "Manual Input Required"; }
	if(vcode.match(/^(01)/)) { return "Free Item"; }
	if(vcode.match(/^(02)/)) { return "Buy 4 Get 1 Free"; }
	if(vcode.match(/^(03)/)) { return "\1.10"; }
	if(vcode.match(/^(04)/)) { return "\1.35"; }
	if(vcode.match(/^(05)/)) { return "\1.40"; }
	if(vcode.match(/^(06)/)) { return "\1.60"; }
	if(vcode.match(/^(07)/)) { return "Buy 3 For 1.50"; }
	if(vcode.match(/^(08)/)) { return "Buy 2 For 3.00"; }
	if(vcode.match(/^(09)/)) { return "Buy 3 For 2.00"; }
	if(vcode.match(/^(10)/)) { return "\0.10"; }
	if(vcode.match(/^(11)/)) { return "\1.85"; }
	if(vcode.match(/^(12)/)) { return "\0.12"; }
	if(vcode.match(/^(13)/)) { return "Buy 4 For 1.00"; }
	if(vcode.match(/^(14)/)) { return "Buy 1 Get 1 Free"; }
	if(vcode.match(/^(15)/)) { return "\0.15"; }
	if(vcode.match(/^(16)/)) { return "Buy 2 Get 1 Free"; }
	if(vcode.match(/^(17)/)) { return "Reserved for future use"; }
	if(vcode.match(/^(18)/)) { return "\2.60"; }
	if(vcode.match(/^(19)/)) { return "Buy 3 Get 1 Free"; }
	if(vcode.match(/^(20)/)) { return "\0.20"; }
	if(vcode.match(/^(21)/)) { return "Buy 2 For 0.35"; }
	if(vcode.match(/^(22)/)) { return "Buy 2 For 0.40"; }
	if(vcode.match(/^(23)/)) { return "Buy 2 For 0.45"; }
	if(vcode.match(/^(24)/)) { return "Buy 2 For 0.50"; }
	if(vcode.match(/^(25)/)) { return "\0.25"; }
	if(vcode.match(/^(26)/)) { return "\2.85"; }
	if(vcode.match(/^(27)/)) { return "Reserved for future use"; }
	if(vcode.match(/^(28)/)) { return "Buy 2 For 0.55"; }
	if(vcode.match(/^(29)/)) { return "\0.29"; }
	if(vcode.match(/^(30)/)) { return "\0.30"; }
	if(vcode.match(/^(31)/)) { return "Buy 2 For 0.60"; }
	if(vcode.match(/^(32)/)) { return "Buy 2 For 0.75"; }
	if(vcode.match(/^(33)/)) { return "Buy 2 For 1.00"; }
	if(vcode.match(/^(34)/)) { return "Buy 2 For 1.25"; }
	if(vcode.match(/^(35)/)) { return "\0.35"; }
	if(vcode.match(/^(36)/)) { return "Buy 2 For 1.50"; }
	if(vcode.match(/^(37)/)) { return "Buy 3 For 0.25"; }
	if(vcode.match(/^(38)/)) { return "Buy 3 For 0.30"; }
	if(vcode.match(/^(39)/)) { return "\0.39"; }
	if(vcode.match(/^(40)/)) { return "\0.40"; }
	if(vcode.match(/^(41)/)) { return "Buy 3 For 0.50"; }
	if(vcode.match(/^(42)/)) { return "Buy 3 For 1.00"; }
	if(vcode.match(/^(43)/)) { return "Buy 2 For 1.10"; }
	if(vcode.match(/^(44)/)) { return "Buy 2 For 1.35"; }
	if(vcode.match(/^(45)/)) { return "\0.45"; }
	if(vcode.match(/^(46)/)) { return "Buy 2 For 1.60"; }
	if(vcode.match(/^(47)/)) { return "Buy 2 For 1.75"; }
	if(vcode.match(/^(48)/)) { return "Buy 2 For 1.85"; }
	if(vcode.match(/^(49)/)) { return "\0.49"; }
	if(vcode.match(/^(50)/)) { return "\0.50"; }
	if(vcode.match(/^(51)/)) { return "Buy 2 For 2.00"; }
	if(vcode.match(/^(52)/)) { return "Buy 3 For 0.55"; }
	if(vcode.match(/^(53)/)) { return "Buy 2 For 0.10"; }
	if(vcode.match(/^(54)/)) { return "Buy 2 For 0.15"; }
	if(vcode.match(/^(55)/)) { return "\0.55"; }
	if(vcode.match(/^(56)/)) { return "Buy 2 For 0.20"; }
	if(vcode.match(/^(57)/)) { return "Buy 2 For 0.25"; }
	if(vcode.match(/^(58)/)) { return "Buy 2 For 0.30"; }
	if(vcode.match(/^(59)/)) { return "\0.59"; }
	if(vcode.match(/^(60)/)) { return "\0.60"; }
	if(vcode.match(/^(61)/)) { return "\10.00"; }
	if(vcode.match(/^(62)/)) { return "\9.50"; }
	if(vcode.match(/^(63)/)) { return "\9.00"; }
	if(vcode.match(/^(64)/)) { return "\8.50"; }
	if(vcode.match(/^(65)/)) { return "\0.65"; }
	if(vcode.match(/^(66)/)) { return "\8.00"; }
	if(vcode.match(/^(67)/)) { return "\7.50"; }
	if(vcode.match(/^(68)/)) { return "\7.00"; }
	if(vcode.match(/^(69)/)) { return "\0.69"; }
	if(vcode.match(/^(70)/)) { return "\0.70"; }
	if(vcode.match(/^(71)/)) { return "\6.50"; }
	if(vcode.match(/^(72)/)) { return "\6.00"; }
	if(vcode.match(/^(73)/)) { return "\5.50"; }
	if(vcode.match(/^(74)/)) { return "\5.00"; }
	if(vcode.match(/^(75)/)) { return "\0.75"; }
	if(vcode.match(/^(76)/)) { return "\1.00"; }
	if(vcode.match(/^(77)/)) { return "\1.25"; }
	if(vcode.match(/^(78)/)) { return "\1.50"; }
	if(vcode.match(/^(79)/)) { return "\0.79"; }
	if(vcode.match(/^(80)/)) { return "\0.80"; }
	if(vcode.match(/^(81)/)) { return "\1.75"; }
	if(vcode.match(/^(82)/)) { return "\2.00"; }
	if(vcode.match(/^(83)/)) { return "\2.25"; }
	if(vcode.match(/^(84)/)) { return "\2.50"; }
	if(vcode.match(/^(85)/)) { return "\0.85"; }
	if(vcode.match(/^(86)/)) { return "\2.75"; }
	if(vcode.match(/^(87)/)) { return "\3.00"; }
	if(vcode.match(/^(88)/)) { return "\3.25"; }
	if(vcode.match(/^(89)/)) { return "\0.89"; }
	if(vcode.match(/^(90)/)) { return "\0.90"; }
	if(vcode.match(/^(91)/)) { return "\3.50"; }
	if(vcode.match(/^(92)/)) { return "\3.75"; }
	if(vcode.match(/^(93)/)) { return "\4.00"; }
	if(vcode.match(/^(94)/)) { return "Reserved for future use"; }
	if(vcode.match(/^(95)/)) { return "\0.95"; }
	if(vcode.match(/^(96)/)) { return "\4.50"; }
	if(vcode.match(/^(97)/)) { return "Reserved for future use"; }
	if(vcode.match(/^(98)/)) { return "Buy 2 For 0.65"; }
	if(vcode.match(/^(99)/)) { return "\0.99"; }
	return false; }