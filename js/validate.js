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
	return validate_upca(upc,true); }

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
	if(upc.length>13) { fix_matches = upc.match(/^(\d{12})/); upc = fix_matches[1]; }
	return validate_upca(upc,true); }

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
	if(upc.length>14) { fix_matches = upc.match(/^(\d{13})/); upc = fix_matches[1]; }
	return validate_upca(upc,true); }

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
	if(upc.length>8) { fix_matches = upc.match(/^(\d{7})/); upc = fix_matches[1]; }
	return validate_upca(upc,true); }

function validate_upce(upc,return_check) {
	if(upc.length>8||upc.length<7) { return false; }
	if(upc.length>8) { upc.match(/^(\d{8})/, upc, fix_matches); upc = fix_matches[1]; }
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
	if(upc.length>7) { upc.match(/^(\d{7})/, upc, fix_matches); upc = fix_matches[1]; }
	return upc+validate_upce(upc,true); }
