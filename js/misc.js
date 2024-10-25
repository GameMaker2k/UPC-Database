/*
    This program is free software; you can redistribute it and/or modify
    it under the terms of the Revised BSD License.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    Revised BSD License for more details.

    Copyright 2011-2024 Cool Dude 2k - http://idb.berlios.de/
    Copyright 2011-2024 Game Maker 2k - http://intdb.sourceforge.net/
    Copyright 2011-2024 Kazuki Przyborowski - https://github.com/KazukiPrzyborowski

    $FileInfo: misc.js - Last Update: 02/28/2012 Ver. 2.2.5 RC 1 - Author: cooldude2k $
*/

// validate upc/ean input
  function validate_str_size(str) {
  if(str==null||str=='') {
    alert("You need to enter a UPC/EAN!");
    return false; }
  if(str.length==0) {
    alert("You need to enter a UPC/EAN!");
    return false; }
  kittyCode();
  if(str.length!=7&&str.length!=8&&str.length!=11&&
	  str.length!=12&&str.length!=13) {
    alert("Invalid UPC/EAN!");
    return false; }
  if(str.length==7) {
    document.upcform.upc.value = fix_upce_checksum(str); }
  if(str.length==8&&!validate_upce(str,false)&&!validate_ean8(str,false)) {
    document.upcform.upc.value = fix_upce_checksum(str); }
  if(str.length==8&&validate_upce(str,false)) {
    document.upcform.upc.value = convert_upce_to_ean13(str); 
	str = document.upcform.upc.value; }
  if(str.length==8&&validate_ean8(str,false)) {
    document.upcform.upc.value = convert_ean8_to_ean13(str); 
	str = document.upcform.upc.value; }
  if(str.length==11) {
    document.upcform.upc.value = fix_upca_checksum(str); }
  if(str.length==12&&!validate_upca(str,false)) {
    document.upcform.upc.value = fix_upca_checksum(str); }
  if(str.length==12&&validate_upca(str,false)) {
    document.upcform.upc.value = convert_upca_to_ean13(str); 
	str = document.upcform.upc.value; }
  if(str.length==13&&!validate_ean13(str,false)) {
    document.upcform.upc.value = fix_ean13_checksum(str); }
  return true; }
