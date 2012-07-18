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

    $FileInfo: validate.js - Last Update: 02/28/2012 Ver. 2.2.5 RC 1 - Author: cooldude2k $
*/

function validate_upca(upc,return_check) {
	if(upc.length>12||upc.length<11) { return false; }
	if(upc.length==11) { upc_matches = upc.match(/^(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})/); }
	if(upc.length==12) {
	upc_matches = upc.match(/^(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})/); }
	OddSum = eval(upc_matches[1]+'+'+upc_matches[3]+'+'+upc_matches[5]+'+'+upc_matches[7]+'+'+upc_matches[9]+'+'+upc_matches[11]) * 3;
	EvenSum = eval(upc_matches[2]+'+'+upc_matches[4]+'+'+upc_matches[6]+'+'+upc_matches[8]+'+'+upc_matches[10]);
	AllSum = OddSum + EvenSum;
	CheckSum = AllSum % 10;
	if(CheckSum>0) {
	CheckSum = 10 - CheckSum; }
	if(return_check==false&&upc.length==12) {
	if(CheckSum!=upc_matches[12]) { return false; }
	if(CheckSum==upc_matches[12]) { return true; } }
	if(return_check==true) { return CheckSum; } 
	if(upc.length==11) { return CheckSum; } }
function fix_upca_checksum(upc) {
	if(upc.length>11) { fix_matches = upc.match(/^(\d{11})/); upc = fix_matches[1]; }
	return upc+validate_upca(upc,true); }

function validate_ean13(upc,return_check) {
	if(upc.length>13||upc.length<12) { return false; }
	if(upc.length==12) { upc_matches = upc.match(/^(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})/); }
	if(upc.length==13) {
	upc_matches = upc.match(/^(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})/); }
	EvenSum = eval(upc_matches[2]+'+'+upc_matches[4]+'+'+upc_matches[6]+'+'+upc_matches[8]+'+'+upc_matches[10]+'+'+upc_matches[12]) * 3;
	OddSum = eval(upc_matches[1]+'+'+upc_matches[3]+'+'+upc_matches[5]+'+'+upc_matches[7]+'+'+upc_matches[9]+'+'+upc_matches[11]);
	AllSum = OddSum + EvenSum;
	CheckSum = AllSum % 10;
	if(CheckSum>0) {
	CheckSum = 10 - CheckSum; }
	if(return_check==false&&upc.length==13) {
	if(CheckSum!=upc_matches[13]) { return false; }
	if(CheckSum==upc_matches[13]) { return true; } }
	if(return_check==true) { return CheckSum; } 
	if(upc.length==12) { return CheckSum; } }
function fix_ean13_checksum(upc) {
	if(upc.length>12) { fix_matches = upc.match(/^(\d{12})/); upc = fix_matches[1]; }
	return upc+validate_ean13(upc,true); }

function validate_itf14(upc,return_check) {
	if(upc.length>14||upc.length<13) { return false; }
	if(upc.length==13) { upc_matches = upc.match(/^(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})/); }
	if(upc.length==14) {
	upc_matches = upc.match(/^(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})/); }
	EvenSum = eval(upc_matches[2]+'+'+upc_matches[4]+'+'+upc_matches[6]+'+'+upc_matches[8]+'+'+upc_matches[10]+'+'+upc_matches[12]);
	OddSum = eval(upc_matches[1]+'+'+upc_matches[3]+'+'+upc_matches[5]+'+'+upc_matches[7]+'+'+upc_matches[9]+'+'+upc_matches[11]+'+'+upc_matches[13]) * 3;
	AllSum = OddSum + EvenSum;
	CheckSum = AllSum % 10;
	if(CheckSum>0) {
	CheckSum = 10 - CheckSum; }
	if(return_check==false&&upc.length==14) {
	if(CheckSum!=upc_matches[14]) { return false; }
	if(CheckSum==upc_matches[14]) { return true; } }
	if(return_check==true) { return CheckSum; } 
	if(upc.length==13) { return CheckSum; } }
function fix_itf14_checksum(upc) {
	if(upc.length>13) { fix_matches = upc.match(/^(\d{13})/); upc = fix_matches[1]; }
	return upc+validate_upca(upc,true); }

function validate_ean8(upc,return_check) {
	if(upc.length>8||upc.length<7) { return false; }
	if(upc.length==7) { upc_matches = upc.match(/^(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})/); }
	if(upc.length==8) {
	upc_matches = upc.match(/^(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})/); }
	EvenSum = eval(upc_matches[1]+'+'+upc_matches[3]+'+'+upc_matches[5]+'+'+upc_matches[7]) * 3;
	OddSum = eval(upc_matches[2]+'+'+upc_matches[4]+'+'+upc_matches[6]);
	AllSum = OddSum + EvenSum;
	CheckSum = AllSum % 10;
	if(CheckSum>0) {
	CheckSum = 10 - CheckSum; }
	if(return_check==false&&upc.length==8) {
	if(CheckSum!=upc_matches[8]) { return false; }
	if(CheckSum==upc_matches[8]) { return true; } }
	if(return_check==true) { return CheckSum; } 
	if(upc.length==7) { return CheckSum; } }
function fix_ean8_checksum(upc) {
	if(upc.length>7) { fix_matches = upc.match(/^(\d{7})/); upc = fix_matches[1]; }
	return upc+validate_ean8(upc,true); }

function validate_upce(upc,return_check) {
	if(upc.length>8||upc.length<7) { return false; }
	if(upc.length>8) { upc.match(/^(\d{8})/); upc = fix_matches[1]; }
	if(upc.length>8||upc.length<7) { return false; }
	if(!upc.match(/^0/)) { return false; }
	CheckDigit = null;
	if(upc.length==8) {
	upc_matches = upc.match(/^(\d{7})(\d{1})/);
	CheckDigit = upc_matches[2]; }
	if(upc.match(/^(\d{1})(\d{5})([0-3])/)) {
	upc_matches = upc.match(/^(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})/);
	if(upc_matches[7]==0) {
	OddSum = eval('0'+'+'+upc_matches[3]+'+'+'0'+'+'+'0'+'+'+upc_matches[4]+'+'+upc_matches[6]) * 3;
	EvenSum = eval(upc_matches[2]+'+'+'0'+'+'+'0'+'+'+'0'+'+'+upc_matches[5]); }
	if(upc_matches[7]==1) {
	OddSum = eval('0'+'+'+upc_matches[3]+'+'+'0'+'+'+'0'+'+'+upc_matches[4]+'+'+upc_matches[6]) * 3;
	EvenSum = eval(upc_matches[2]+'+'+1+'+'+'0'+'+'+'0'+'+'+upc_matches[5]); }
	if(upc_matches[7]==2) {
	OddSum = eval('0'+'+'+upc_matches[3]+'+'+'0'+'+'+'0'+'+'+upc_matches[4]+'+'+upc_matches[6]) * 3;
	EvenSum = eval(upc_matches[2]+'+'+2+'+'+'0'+'+'+'0'+'+'+upc_matches[5]); }
	if(upc_matches[7]==3) {
	OddSum = eval('0'+'+'+upc_matches[3]+'+'+'0'+'+'+'0'+'+'+'0'+'+'+upc_matches[6]) * 3;
	EvenSum = eval(upc_matches[2]+'+'+upc_matches[4]+'+'+'0'+'+'+'0'+'+'+upc_matches[5]); } }
	if(upc.match(/^(\d{1})(\d{5})([4-9])/)) {
	upc_matches = upc.match(/^(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})/);
	if(upc_matches[7]==4) {
	OddSum = eval('0'+'+'+upc_matches[3]+'+'+upc_matches[5]+'+'+'0'+'+'+'0'+'+'+upc_matches[6]) * 3;
	EvenSum = eval(upc_matches[2]+'+'+upc_matches[4]+'+'+'0'+'+'+'0'+'+'+'0'); }
	if(upc_matches[7]==5) {
	OddSum = eval('0'+'+'+upc_matches[3]+'+'+upc_matches[5]+'+'+'0'+'+'+'0'+'+'+upc_matches[7]) * 3;
	EvenSum = eval(upc_matches[2]+'+'+upc_matches[4]+'+'+upc_matches[6]+'+'+'0'+'+'+'0'); }
	if(upc_matches[7]==6) {
	OddSum = eval('0'+'+'+upc_matches[3]+'+'+upc_matches[5]+'+'+'0'+'+'+'0'+'+'+upc_matches[7]) * 3;
	EvenSum = eval(upc_matches[2]+'+'+upc_matches[4]+'+'+upc_matches[6]+'+'+'0'+'+'+'0'); }
	if(upc_matches[7]==7) {
	OddSum = eval('0'+'+'+upc_matches[3]+'+'+upc_matches[5]+'+'+'0'+'+'+'0'+'+'+upc_matches[7]) * 3;
	EvenSum = eval(upc_matches[2]+'+'+upc_matches[4]+'+'+upc_matches[6]+'+'+'0'+'+'+'0'); }
	if(upc_matches[7]==8) {
	OddSum = eval('0'+'+'+upc_matches[3]+'+'+upc_matches[5]+'+'+'0'+'+'+'0'+'+'+upc_matches[7]) * 3;
	EvenSum = eval(upc_matches[2]+'+'+upc_matches[4]+'+'+upc_matches[6]+'+'+'0'+'+'+'0'); }
	if(upc_matches[7]==9) {
	OddSum = eval('0'+'+'+upc_matches[3]+'+'+upc_matches[5]+'+'+'0'+'+'+'0'+'+'+upc_matches[7]) * 3;
	EvenSum = eval(upc_matches[2]+'+'+upc_matches[4]+'+'+upc_matches[6]+'+'+'0'+'+'+'0'); } }
	AllSum = OddSum + EvenSum;
	CheckSum = AllSum % 10;
	if(CheckSum>0) {
	CheckSum = 10 - CheckSum; }
	if(return_check==false&&upc.length==8) {
	if(CheckSum!=CheckDigit) { return false; }
	if(CheckSum==CheckDigit) { return true; } }
	if(return_check==true) { return CheckSum; } 
	if(upc.length==7) { return CheckSum; } }
function fix_upce_checksum(upc) {
	if(upc.length>7) { fix_matches = upc.match(/^(\d{7})/); upc = fix_matches[1]; }
	return upc+validate_upce(upc,true); }

function validate_barcode(upc,return_check) {
	if(upc.length==8) { return validate_upce(upc,return_check); }
	if(upc.length==12) { return validate_upca(upc,return_check); }
	if(upc.length==13) { return validate_ean13(upc,return_check); } 
	if(upc.length==14) { return validate_itf14(upc,return_check); } 
	return false; }
function fix_barcode_checksum(upc) {
	if(upc.length==7) { return upc+validate_upce(upc,true); }
	if(upc.length==11) { return upc+validate_upca(upc,true); }
	if(upc.length==12) { return upc+validate_ean13(upc,true); } 
	if(upc.length==13) { return upc+validate_itf14(upc,true); } 
	return false; }

// Get variable weight price checksum
// Source: http://wiki.answers.com/Q/How_does_a_price_embedded_bar_code_work
// Source: http://en.wikipedia.org/wiki/Universal_Product_Code#Prefixes
// Source: http://barcodes.gs1us.org/GS1%20US%20BarCodes%20and%20eCom%20-%20The%20Global%20Language%20of%20Business.htm
function get_vw_price_checksum(price,return_check) {
	if(price.length==1) { price = "000"+price; }
	if(price.length==2) { price = "00"+price; }
	if(price.length==3) { price = "0"+price; }
	if(price.length>5) {
	if(price.match(/^(\d{5})/)) { 
	price_matches = price.match(/^(\d{5})/); price = price_matches[1]; } }
	price_split = price.split("");
	numrep1 = [0, 2, 4, 6, 8, 9, 1, 3, 5, 7];
	numrep2 = [0, 3, 6, 9, 2, 5, 8, 1, 4, 7];
	numrep3 = [0, 5, 9, 4, 8, 3, 7, 2, 6, 1];
	if(price.length==4) {
	price_split[0] = numrep1[price_split[0]];
	price_split[1] = numrep1[price_split[1]];
	price_split[2] = numrep2[price_split[2]];
	price_split[3] = numrep3[price_split[3]];
	price_add = eval(price_split[0] + price_split[1] + price_split[2] + price_split[3]) * 3; }
	if(price.length==5) {
	price_split[1] = numrep1[price_split[1]];
	price_split[2] = numrep1[price_split[2]];
	price_split[3] = numrep2[price_split[3]];
	price_split[4] = numrep3[price_split[4]];
	price_add = eval(price_split[1] + price_split[2] + price_split[3] + price_split[4]) * 3; }
	CheckSum = price_add % 10;
	if(return_check==false&&price.length==5) {
	if(CheckSum!=price_split[0]) { return false; }
	if(CheckSum==price_split[0]) { return true; } }
	if(return_check==true) { return CheckSum; } 
	if(price.length==4) { return CheckSum; }
	return CheckSum; }
function fix_vw_price_checksum(price) {
	if(price.length==5) { fix_matches = price.match(/^(\d{1})(\d{4})/); price = fix_matches[2]; }
	if(price.length>4) { fix_matches = price.match(/^(\d{4})/); price = fix_matches[1]; }
	return get_vw_price_checksum(price,true)+price; }
