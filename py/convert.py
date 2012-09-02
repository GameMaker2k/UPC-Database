#!/usr/bin/python

'''
    This program is free software; you can redistribute it and/or modify
    it under the terms of the Revised BSD License.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    Revised BSD License for more details.

    Copyright 2011-2012 Cool Dude 2k - http://idb.berlios.de/
    Copyright 2011-2012 Game Maker 2k - http://intdb.sourceforge.net/
    Copyright 2011-2012 Kazuki Przyborowski - https://github.com/KazukiPrzyborowski

    $FileInfo: convert.py - Last Update: 02/28/2012 Ver. 2.2.5 RC 1 - Author: cooldude2k $
'''

import sys,re;

def convert_upce_to_upca(upc):
	if(len(upc)==7):
		upc = upc+str(validate_upce(upc,True));
	if(len(upc)>8 or len(upc)<8):
		return False;
	if(not re.findall("^0", upc)):
		return False;
	if(validate_upce(upc)==False):
		return False;
	if(re.findall("0(\d{5})([0-3])(\d{1})", upc)):
		upc_matches = re.findall("0(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})", upc);
		upc_matches = upc_matches[0];
		if(int(upc_matches[5])==0):
			upce = "0"+upc_matches[0]+upc_matches[1]+upc_matches[5]+"0000"+upc_matches[2]+upc_matches[3]+upc_matches[4]+upc_matches[6];
		if(int(upc_matches[5])==1):
			upce = "0"+upc_matches[0]+upc_matches[1]+upc_matches[5]+"0000"+upc_matches[2]+upc_matches[3]+upc_matches[4]+upc_matches[6];
		if(int(upc_matches[5])==2):
			upce = "0"+upc_matches[0]+upc_matches[1]+upc_matches[5]+"0000"+upc_matches[2]+upc_matches[3]+upc_matches[4]+upc_matches[6];
		if(int(upc_matches[5])==3):
			upce = "0"+upc_matches[0]+upc_matches[1]+upc_matches[2]+"00000"+upc_matches[3]+upc_matches[4]+upc_matches[6]; 
	if(re.findall("0(\d{5})([4-9])(\d{1})", upc)):
		upc_matches = re.findall("0(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})", upc);
		upc_matches = upc_matches[0];
		if(int(upc_matches[5])==4):
			upce = "0"+upc_matches[0]+upc_matches[1]+upc_matches[2]+upc_matches[3]+"00000"+upc_matches[4]+upc_matches[6];
		if(int(upc_matches[5])==5):
			upce = "0"+upc_matches[0]+upc_matches[1]+upc_matches[2]+upc_matches[3]+upc_matches[4]+"0000"+upc_matches[5]+upc_matches[6];
		if(int(upc_matches[5])==6):
			upce = "0"+upc_matches[0]+upc_matches[1]+upc_matches[2]+upc_matches[3]+upc_matches[4]+"0000"+upc_matches[5]+upc_matches[6];
		if(int(upc_matches[5])==7):
			upce = "0"+upc_matches[0]+upc_matches[1]+upc_matches[2]+upc_matches[3]+upc_matches[4]+"0000"+upc_matches[5]+upc_matches[6];
		if(int(upc_matches[5])==8):
			upce = "0"+upc_matches[0]+upc_matches[1]+upc_matches[2]+upc_matches[3]+upc_matches[4]+"0000"+upc_matches[5]+upc_matches[6];
		if(int(upc_matches[5])==9):
			upce = "0"+upc_matches[0]+upc_matches[1]+upc_matches[2]+upc_matches[3]+upc_matches[4]+"0000"+upc_matches[5]+upc_matches[6];
	return upce;
def convert_upca_to_ean13(upc):
	if(len(upc)==11):
		upc = upc+str(validate_upca(upc,True));
	if(len(upc)>13 or len(upc)<12):
		return False;
	if(validate_upca(upc)==False):
		return False;
	if(len(upc)==12):
		ean13 = "0"+upc;
	if(len(upc)==13):
		ean13 = upc;
	return ean13;
def convert_ean13_to_itf14(upc):
	if(len(upc)==11):
		upc = upc+str(validate_upca(upc,True));
	if(len(upc)==12):
		upc = "0"+upc;
	if(len(upc)>14 or len(upc)<13):
		return False;
	if(validate_ean13(upc)==False):
		return False;
	if(len(upc)==13):
		itf14 = "0"+upc;
	if(len(upc)==14):
		itf14 = upc;
	return itf14;
def convert_upce_to_ean13(upc):
	return convert_upca_to_ean13(convert_upce_to_upca(upc));
def convert_upce_to_itf14(upc):
	return convert_ean13_to_itf14(convert_upce_to_ean13(upc));
def convert_upca_to_itf14(upc):
	return convert_ean13_to_itf14(convert_upca_to_ean13(upc));
def convert_ean13_to_upca(upc):
	if(len(upc)==12):
		upc = "0"+upc;
	if(len(upc)>13 or len(upc)<13):
		return False;
	if(validate_ean13(upc)==False):
		return False;
	if(not re.findall("^0(\d{12})", upc)):
		return False;
	if(re.findall("^0(\d{12})", upc)):
		upc_matches = re.findall("^0(\d{12})", upc);
		upca = upc_matches[0];
	return upca;
def convert_itf14_to_ean13(upc):
	if(len(upc)==13):
		upc = "0"+upc;
	if(len(upc)>14 or len(upc)<14): 
		return False;
	if(validate_itf14(upc)==False):
		return False;
	if(not re.findall("^(\d{1})(\d{12})(\d{1})", upc)):
		return False;
	if(re.findall("^(\d{1})(\d{12})(\d{1})", upc)):
		upc_matches = re.findall("^(\d{1})(\d{12})(\d{1})", upc);
		upc_matches = upc_matches[0];
		ean13 = upc_matches[1]+str(validate_ean13(upc_matches[1], True));
	return ean13;
def convert_upca_to_upce(upc):
	if(len(upc)==11):
		upc = upc+str(validate_upca(upc,True));
	if(len(upc)>12 or len(upc)<12):
		return False;
	if(validate_upca(upc)==False):
		return False;
	if(not re.findall("0(\d{11})", upc)):
		return False;
	upce = None;
	if(re.findall("0(\d{2})00000(\d{3})(\d{1})", upc)):
		upc_matches = re.findall("0(\d{2})00000(\d{3})(\d{1})", upc);
		upc_matches = upc_matches[0];
		upce = "0"+upc_matches[0]+upc_matches[1]+"0";
		upce = upce+upc_matches[2]; 
		return upce;
	if(re.findall("0(\d{2})10000(\d{3})(\d{1})", upc)):
		upc_matches = re.findall("0(\d{2})10000(\d{3})(\d{1})", upc);
		upc_matches = upc_matches[0];
		upce = "0"+upc_matches[0]+upc_matches[1]+"1";
		upce = upce+upc_matches[2]; 
		return upce;
	if(re.findall("0(\d{2})20000(\d{3})(\d{1})", upc)):
		upc_matches = re.findall("0(\d{2})20000(\d{3})(\d{1})", upc);
		upc_matches = upc_matches[0];
		upce = "0"+upc_matches[0]+upc_matches[1]+"2";
		upce = upce+upc_matches[2]; 
		return upce;
	if(re.findall("0(\d{3})00000(\d{2})(\d{1})", upc)):
		upc_matches = re.findall("0(\d{3})00000(\d{2})(\d{1})", upc);
		upc_matches = upc_matches[0];
		upce = "0"+upc_matches[0]+upc_matches[1]+"3";
		upce = upce+upc_matches[2]; 
		return upce;
	if(re.findall("0(\d{4})00000(\d{1})(\d{1})", upc)):
		upc_matches = re.findall("0(\d{4})00000(\d{1})(\d{1})", upc);
		upc_matches = upc_matches[0];
		upce = "0"+upc_matches[0]+upc_matches[1]+"4";
		upce = upce+upc_matches[2]; 
		return upce;
	if(re.findall("0(\d{5})00005(\d{1})", upc)):
		upc_matches = re.findall("0(\d{5})00005(\d{1})", upc);
		upc_matches = upc_matches[0];
		upce = "0"+upc_matches[0]+"5";
		upce = upce+upc_matches[1]; 
		return upce;
	if(re.findall("0(\d{5})00006(\d{1})", upc)):
		upc_matches = re.findall("0(\d{5})00006(\d{1})", upc);
		upc_matches = upc_matches[0];
		upce = "0"+upc_matches[0]+"6";
		upce = upce+upc_matches[1]; 
		return upce;
	if(re.findall("0(\d{5})00007(\d{1})", upc)):
		upc_matches = re.findall("0(\d{5})00007(\d{1})", upc);
		upc_matches = upc_matches[0];
		upce = "0"+upc_matches[0]+"7";
		upce = upce+upc_matches[1]; 
		return upce;
	if(re.findall("0(\d{5})00008(\d{1})", upc)):
		upc_matches = re.findall("0(\d{5})00008(\d{1})", upc);
		upc_matches = upc_matches[0];
		upce = "0"+upc_matches[0]+"8";
		upce = upce+upc_matches[1]; 
		return upce;
	if(re.findall("0(\d{5})00009(\d{1})", upc)):
		upc_matches = re.findall("0(\d{5})00009(\d{1})", upc);
		upc_matches = upc_matches[0];
		upce = "0"+upc_matches[0]+"9";
		upce = upce+upc_matches[1]; 
		return upce;
	if(upce==None):
		return False;
	return upce;
def convert_ean13_to_upce(upc):
	return convert_upca_to_upce(convert_ean13_to_upca(upc));
def convert_itf14_to_upca(upc):
	return convert_ean13_to_upca(convert_itf14_to_ean13(upc));
def convert_itf14_to_upce(upc):
	return convert_upca_to_upce(convert_itf14_to_upca(upc));
def convert_any_to_upca(upc):
	if(len(upc)==8):
		return convert_upce_to_upca(upc);
	if(len(upc)==13):
		return convert_ean13_to_upce(upc);
	if(len(upc)==14):
		return convert_itf14_to_upce(upc);
	return False;
def convert_any_to_upce(upc):
	if(len(upc)==12):
		return convert_upca_to_upce(upc);
	if(len(upc)==13):
		return convert_ean13_to_upca(upc);
	if(len(upc)==14):
		return convert_itf14_to_upca(upc);
	return False;
def convert_any_to_ean13(upc):
	if(len(upc)==8):
		return convert_upce_to_ean13(upc);
	if(len(upc)==12):
		return convert_upca_to_ean13(upc);
	if(len(upc)==14):
		return convert_itf14_to_ean13(upc);
	return False;
def convert_any_to_itf14(upc):
	if(len(upc)==8):
		return convert_upce_to_itf14(upc);
	if(len(upc)==12):
		return convert_upca_to_itf14(upc);
	if(len(upc)==13):
		return convert_ean13_to_itf14(upc);
	return False;
def convert_any_to_ean8(upc):
	if(len(upc)==12):
		return convert_upca_to_ean8(upc);
	if(len(upc)==13):
		return convert_ean13_to_ean8(upc);
	if(len(upc)==14):
		return convert_itf14_to_ean8(upc);
	return False;
'''
Changing a EAN-8 code to UPC-A and EAN-13 based on whats used at: 
http://www.upcdatabase.com/
'''
def convert_ean8_to_upca(upc):
	if(len(upc)==7):
		upc = upc+str(validate_ean8(upc,True));
	if(len(upc)>8 or len(upc)<8):
		return False;
	if(validate_ean8(upc)==False):
		return False;
	upca = "0000"+upc; 
	return upca;
def convert_ean8_to_ean13(upc):
	return convert_upca_to_ean13(convert_ean8_to_upca(upc));
def convert_ean8_to_itf14(upc):
	return convert_ean13_to_itf14(convert_ean8_to_ean13(upc));
def convert_upca_to_ean8(upc):
	if(len(upc)==11):
		upc = upc+str(validate_upca(upc,True));
	if(len(upc)>12 or len(upc)<12):
		return False;
	if(validate_upca(upc)==False):
		return False;
	if(not re.findall("^0000(\d{8})", upc)):
		return False;
	if(re.findall("^0000(\d{8})", upc)):
		upc_matches = re.findall("^0000(\d{8})", upc);
		ean8 = upc_matches[0];
	return ean8;
def convert_ean13_to_ean8(upc):
	return convert_upca_to_ean8(convert_ean13_to_upca(upc));
def convert_itf14_to_ean8(upc):
	return convert_ean13_to_ean8(convert_itf14_to_ean13(upc));
