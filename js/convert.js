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

    $FileInfo: convert.js - Last Update: 02/13/2012 Ver. 2.2.5 RC 1 - Author: cooldude2k $
*/

function convert_upce_to_upca(upc) {
	if(upc.length==7) { upc = upc+validate_upce(upc,true); }
	if(upc.length>8||upc.length<8) { return false; }
	if(!upc.match(/^0/)) { return false; }
	if(validate_upce(upc)===false) { return false; }
	if(upc.match(/0(\d{5})([0-3])(\d{1})/)) {
	upc_matches = upc.match(/0(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})/);
	if(upc_matches[6]==0) {
	upce = "0"+upc_matches[1]+upc_matches[2]+upc_matches[6]+"0000"+upc_matches[3]+upc_matches[4]+upc_matches[5]+upc_matches[7]; }
	if(upc_matches[6]==1) {
	upce = "0"+upc_matches[1]+upc_matches[2]+upc_matches[6]+"0000"+upc_matches[3]+upc_matches[4]+upc_matches[5]+upc_matches[7]; }
	if(upc_matches[6]==2) {
	upce = "0"+upc_matches[1]+upc_matches[2]+upc_matches[6]+"0000"+upc_matches[3]+upc_matches[4]+upc_matches[5]+upc_matches[7]; }
	if(upc_matches[6]==3) {
	upce = "0"+upc_matches[1]+upc_matches[2]+upc_matches[3]+"00000"+upc_matches[4]+upc_matches[5]+upc_matches[7]; } }
	if(upc.match(/0(\d{5})([4-9])(\d{1})/)) {
	upc_matches = upc.match(/0(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})/);
	if(upc_matches[6]==4) {
	upce = "0"+upc_matches[1]+upc_matches[2]+upc_matches[3]+upc_matches[4]+"00000"+upc_matches[5]+upc_matches[7]; }
	if(upc_matches[6]==5) {
	upce = "0"+upc_matches[1]+upc_matches[2]+upc_matches[3]+upc_matches[4]+upc_matches[5]+"0000"+upc_matches[6]+upc_matches[7]; }
	if(upc_matches[6]==6) {
	upce = "0"+upc_matches[1]+upc_matches[2]+upc_matches[3]+upc_matches[4]+upc_matches[5]+"0000"+upc_matches[6]+upc_matches[7]; }
	if(upc_matches[6]==7) {
	upce = "0"+upc_matches[1]+upc_matches[2]+upc_matches[3]+upc_matches[4]+upc_matches[5]+"0000"+upc_matches[6]+upc_matches[7]; }
	if(upc_matches[6]==8) {
	upce = "0"+upc_matches[1]+upc_matches[2]+upc_matches[3]+upc_matches[4]+upc_matches[5]+"0000"+upc_matches[6]+upc_matches[7]; }
	if(upc_matches[6]==9) {
	upce = "0"+upc_matches[1]+upc_matches[2]+upc_matches[3]+upc_matches[4]+upc_matches[5]+"0000"+upc_matches[6]+upc_matches[7]; } }
	return upce; }

function convert_upca_to_ean13(upc) {
	if(upc.length==11) { upc = upc+validate_upca(upc,true); }
	if(upc.length>13||upc.length<12) { return false; }
	if(validate_upca(upc)) { return false; }
	if(upc.length==12) { ean13 = "0"+upc; }
	if(upc.length==13) { ean13 = upc; }
	return ean13; }

function convert_ean13_to_itf14(upc) {
	if(upc.length==11) { upc = upc+validate_upca(upc,true); }
	if(upc.length==12) { upc = "0"+upc; }
	if(upc.length>14||upc.length<13) { return false; }
	if(validate_ean13(upc)===false) { return false; }
	if(upc.length==13) { itf14 = "0"+upc; }
	if(upc.length==14) { itf14 = upc; }
	return itf14; }

function convert_upce_to_ean13(upc) {
	return convert_upca_to_ean13(convert_upce_to_upca(upc)); }
function convert_upce_to_itf14(upc) {
	return convert_ean13_to_itf14(convert_upce_to_ean13(upc)); }
function convert_upca_to_itf14(upc) {
	return convert_ean13_to_itf14(convert_upca_to_ean13(upc)); }

function convert_ean13_to_upca(upc) {
	if(upc.length==12) { upc = "0".upc; }
	if(upc.length>13||upc.length<13) { return false; }
	if(validate_ean13(upc)===false) { return false; }
	if(!upc.match(/^0(\d{12})/)) {
	return false; }
	if(upc.match(/^0(\d{12})/)) {
	upc_matches = upc.match(/^0(\d{12})/);
	upca = upc_matches[1]; }
	return upca; }

function convert_itf14_to_ean13(upc) {
	if(upc.length==13) { upc = "0".upc; }
	if(upc.length>14||upc.length<14) { return false; }
	if(validate_itf14(upc)===false) { return false; }
	if(!upc.match(/^(\d{1})(\d{12})(\d{1})/)) {
	return false; }
	if(upc.match(/^(\d{1})(\d{12})(\d{1})/)) {
	upc_matches = upc.match(/^(\d{1})(\d{12})(\d{1})/);
	ean13 = upc_matches[2]+validate_ean13(upc_matches[2], true); }
	return ean13; }

function convert_upca_to_upce(upc) {
	if(upc.length==11) { upc = upc+validate_upca(upc,true); }
	if(upc.length>12||upc.length<12) { return false; }
	if(validate_upca(upc)===false) { return false; }
	if(!upc.match(/0(\d{11})/, upc)) { return false; }
	upce = null;
	if(upc.match(/0(\d{2})00000(\d{3})(\d{1})/)) {
	upc_matches = upc.match(/0(\d{2})00000(\d{3})(\d{1})/);
	upce = "0"+upc_matches[1]+upc_matches[2]+"0";
	upce = upce+upc_matches[3]; return upce; }
	if(upc.match(/0(\d{2})10000(\d{3})(\d{1})/)) {
	upc_matches = upc.match(/0(\d{2})10000(\d{3})(\d{1})/);
	upce = "0"+upc_matches[1]+upc_matches[2]+"1";
	upce = upce+upc_matches[3]; return upce; }
	if(upc.match(/0(\d{2})20000(\d{3})(\d{1})/)) {
	upc_matches = upc.match(/0(\d{2})20000(\d{3})(\d{1})/);
	upce = "0"+upc_matches[1]+upc_matches[2]+"2";
	upce = upce+upc_matches[3]; return upce; }
	if(upc.match(/0(\d{3})00000(\d{2})(\d{1})/)) {
	upc_matches = upc.match(/0(\d{3})00000(\d{2})(\d{1})/);
	upce = "0"+upc_matches[1]+upc_matches[2]+"3";
	upce = upce+upc_matches[3]; return upce; }
	if(upc.match(/0(\d{4})00000(\d{1})(\d{1})/)) {
	upc_matches = upc.match(/0(\d{4})00000(\d{1})(\d{1})/);
	upce = "0"+upc_matches[1]+upc_matches[2]+"4";
	upce = upce+upc_matches[3]; return upce; }
	if(upc.match(/0(\d{5})00005(\d{1})/)) {
	upc_matches = upc.match(/0(\d{5})00005(\d{1})/);
	upce = "0"+upc_matches[1]+"5";
	upce = upce+upc_matches[2]; return upce; }
	if(upc.match(/0(\d{5})00006(\d{1})/)) {
	upc_matches = upc.match(/0(\d{5})00006(\d{1})/);
	upce = "0"+upc_matches[1]+"6";
	upce = upce+upc_matches[2]; return upce; }
	if(upc.match(/0(\d{5})00007(\d{1})/)) {
	upc_matches = upc.match(/0(\d{5})00007(\d{1})/);
	upce = "0"+upc_matches[1]+"7";
	upce = upce+upc_matches[2]; return upce; }
	if(upc.match(/0(\d{5})00008(\d{1})/)) {
	upc_matches = upc.match(/0(\d{5})00008(\d{1})/);
	upce = "0"+upc_matches[1]+"8";
	upce = upce+upc_matches[2]; return upce; }
	if(upc.match(/0(\d{5})00009(\d{1})/)) {
	upc_matches = upc.match(/0(\d{5})00009(\d{1})/);
	upce = "0"+upc_matches[1]+"9";
	upce = upce+upc_matches[2]; return upce; }
	if(upce==null) { return false; }
	return upce; }

function convert_ean13_to_upce(upc) {
	return convert_upca_to_upce(convert_ean13_to_upca(upc)); }
function convert_itf14_to_upca(upc) {
	return convert_ean13_to_upca(convert_itf14_to_ean13(upc)); }
function convert_itf14_to_upce(upc) {
	return convert_upca_to_upce(convert_itf14_to_upca(upc)); }

function convert_any_to_upca(upc) {
	if(upc.length==8) { 
	return convert_upce_to_upca(upc); }
	if(upc.length==13) { 
	return convert_ean13_to_upce(upc); }
	if(upc.length==14) { 
	return convert_itf14_to_upce(upc); }
	return false; }

function convert_any_to_upce(upc) {
	if(upc.length==12) { 
	return convert_upca_to_upce(upc); }
	if(upc.length==13) { 
	return convert_ean13_to_upca(upc); }
	if(upc.length==14) { 
	return convert_itf14_to_upca(upc); }
	return false; }

function convert_any_to_ean13(upc) {
	if(upc.length==8) { 
	return convert_upce_to_ean13(upc); }
	if(upc.length==12) { 
	return convert_upca_to_ean13(upc); }
	if(upc.length==14) { 
	return convert_itf14_to_ean13(upc); }
	return false; }

function convert_any_to_itf14(upc) {
	if(upc.length==8) { 
	return convert_upce_to_itf14(upc); }
	if(upc.length==12) { 
	return convert_upca_to_itf14(upc); }
	if(upc.length==13) { 
	return convert_ean13_to_itf14(upc); }
	return false; }

function convert_any_to_ean8(upc) {
	if(upc.length==12) { 
	return convert_upca_to_ean8(upc); }
	if(upc.length==13) { 
	return convert_ean13_to_ean8(upc); }
	if(upc.length==14) { 
	return convert_itf14_to_ean8(upc); }
	return false; }
