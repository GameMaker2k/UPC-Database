#!/usr/bin/python

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

    $FileInfo: validate.py - Last Update: 02/28/2012 Ver. 2.2.5 RC 1 - Author: cooldude2k $
*/

import re;
def validate_upca(upc,return_check): 
	if(len(upc)>12):
		fix_matches = re.findall("/^(\d{12})/", upc);
		upc = fix_matches[1];
	if(len(upc)>12 or len(upc)<11):
		return False;
	if(len(upc)==11):
		upc_matches = re.findall("^(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})", upc);
	if(len(upc)==12):
		upc_matches = re.findall("^(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})", upc);
	upc_matches=upc_matches[0];
	OddSum = eval(upc_matches[0]+"+"+upc_matches[2]+"+"+upc_matches[4]+"+"+upc_matches[6]+"+"+upc_matches[8]+"+"+upc_matches[10]) * 3;
	EvenSum = eval(upc_matches[1]+"+"+upc_matches[3]+"+"+upc_matches[5]+"+"+upc_matches[7]+"+"+upc_matches[9]);
	AllSum = OddSum + EvenSum;
	CheckSum = AllSum % 10;
	if(CheckSum>0):
		CheckSum = 10 - CheckSum;
	if(return_check==False and len(upc)==12):
		if(CheckSum!=int(upc_matches[11])):
			return False;
		if(CheckSum==int(upc_matches[11])):
			return True;
	if(return_check==True):
		return CheckSum;
	if(len(upc)==11):
		return CheckSum;
def fix_upca_checksum(upc):
	if(len(upc)>11):
		fix_matches = re.findall("^(\d{11})", upc); 
		fix_matches = fix_matches[0];
		upc = fix_matches;
	return upc+str(validate_upca(upc,True));
