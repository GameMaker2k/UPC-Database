#!/usr/bin/python

import re;

def validate_upca(upc,return_check=False): 
	if(len(upc)>12):
		fix_matches = re.findall("^(\d{12})", upc);
		upc = fix_matches[0];
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
		upc = fix_matches[0];
	return upc+str(validate_upca(upc,True));

def validate_ean13(upc,return_check=False):
	if(len(upc)>13):
		fix_matches = re.findall("^(\d{13})", upc);
		upc = fix_matches[0];
	if(len(upc)>13 or len(upc)<12):
		return False;
	if(len(upc)==12):
		upc_matches = re.findall("^(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})", upc);
	if(len(upc)==13):
		upc_matches = re.findall("^(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})", upc);
	upc_matches=upc_matches[0];
	EvenSum = eval(upc_matches[1]+"+"+upc_matches[3]+"+"+upc_matches[5]+"+"+upc_matches[7]+"+"+upc_matches[9]+"+"+upc_matches[11]) * 3;
	OddSum = eval(upc_matches[0]+"+"+upc_matches[2]+"+"+upc_matches[4]+"+"+upc_matches[6]+"+"+upc_matches[8]+"+"+upc_matches[10]);
	AllSum = OddSum + EvenSum;
	CheckSum = AllSum % 10;
	if(CheckSum>0):
		CheckSum = 10 - CheckSum;
	if(return_check==False and len(upc)==13):
		if(CheckSum!=int(upc_matches[12])):
			return False;
		if(CheckSum==int(upc_matches[12])):
			return True;
	if(return_check==True):
		return CheckSum;
	if(len(upc)==12):
		return CheckSum;
def fix_ean13_checksum(upc):
	if(len(upc)>12):
		fix_matches = re.findall("^(\d{12})", upc); 
		upc = fix_matches[0];
	return upc+str(validate_ean13(upc,True));

def validate_itf14(upc,return_check=False):
	if(len(upc)>14):
		fix_matches = re.findall("^(\d{14})", upc); 
		upc = fix_matches[0];
	if(len(upc)>14 or len(upc)<13):
		return False;
	if(len(upc)==13):
		upc_matches = re.findall("^(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})", upc);
	if(len(upc)==14):
		upc_matches = re.findall("^(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})", upc);
	upc_matches=upc_matches[0];
	EvenSum = eval(upc_matches[1]+"+"+upc_matches[3]+"+"+upc_matches[5]+"+"+upc_matches[7]+"+"+upc_matches[9]+"+"+upc_matches[11]);
	OddSum = eval(upc_matches[0]+"+"+upc_matches[2]+"+"+upc_matches[4]+"+"+upc_matches[6]+"+"+upc_matches[8]+"+"+upc_matches[10]+"+"+upc_matches[12]) * 3;
	AllSum = OddSum + EvenSum;
	CheckSum = AllSum % 10;
	if(CheckSum>0):
		CheckSum = 10 - CheckSum;
	if(return_check==False and len(upc)==14):
		if(CheckSum!=int(upc_matches[13])):
			return False;
		if(CheckSum==int(upc_matches[13])):
			return True;
	if(return_check==True):
		return CheckSum;
	if(len(upc)==13):
		return CheckSum;
def fix_itf14_checksum(upc):
	if(len(upc)>13):
		fix_matches = re.findall("^(\d{13})", upc); 
		upc = fix_matches[0];
	return upc+str(validate_itf14(upc,True));

def validate_ean8(upc,return_check=False):
	if(len(upc)>8):
		fix_matches = re.findall("^(\d{8})", upc); 
		upc = fix_matches[0];
	if(len(upc)>8 or len(upc)<7):
		return False;
	if(len(upc)==7):
		upc_matches = re.findall("^(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})", upc);
	if(len(upc)==8):
		upc_matches = re.findall("^(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})", upc);
	upc_matches=upc_matches[0];
	EvenSum = eval(upc_matches[0]+"+"+upc_matches[2]+"+"+upc_matches[4]+"+"+upc_matches[6]) * 3;
	OddSum = eval(upc_matches[1]+"+"+upc_matches[3]+"+"+upc_matches[5]);
	AllSum = OddSum + EvenSum;
	CheckSum = AllSum % 10;
	if(CheckSum>0):
		CheckSum = 10 - CheckSum;
	if(return_check==False and len(upc)==8):
		if(CheckSum!=int(upc_matches[7])):
			return False;
		if(CheckSum==int(upc_matches[7])): 
			return True;
	if(return_check==True):
		return CheckSum;
	if(len(upc)==7):
		return CheckSum;
def fix_ean8_checksum(upc):
	if(len(upc)>7):
		fix_matches = re.findall("^(\d{7})", upc); 
		upc = fix_matches[0];
	return upc+str(validate_ean8(upc,True));

def validate_upce(upc,return_check=False):
	if(len(upc)>8):
		fix_matches = re.findall("/^(\d{8})/", upc); 
		upc = fix_matches[0];
	if(len(upc)>8 or len(upc)<7):
		return False;
	if(not re.findall("^0", upc)):
		return False;
	CheckDigit = None;
	if(len(upc)==8 and re.findall("^(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})", upc)):
		upc_matches = re.findall("^(\d{7})(\d{1})", upc);
		upc_matches=upc_matches[0];
		CheckDigit = upc_matches[1];
	if(re.findall("^(\d{1})(\d{5})([0-3])", upc)):
		upc_matches = re.findall("^(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})", upc);
		upc_matches=upc_matches[0];
		if(int(upc_matches[6])==0):
			OddSum = eval(upc_matches[2]+"+"+upc_matches[3]+"+"+upc_matches[5]) * 3;
			EvenSum = eval(upc_matches[1]+"+"+upc_matches[4]);
		if(int(upc_matches[6])==1):
			OddSum = eval(upc_matches[2]+"+"+upc_matches[3]+"+"+upc_matches[5]) * 3;
			EvenSum = eval(upc_matches[1]+"+1+"+upc_matches[4]);
		if(int(upc_matches[6])==2):
			OddSum = eval(upc_matches[2]+"+"+upc_matches[3]+"+"+upc_matches[5]) * 3;
			EvenSum = eval(upc_matches[1]+"+2+"+upc_matches[4]);
		if(int(upc_matches[6])==3):
			OddSum = eval(upc_matches[2]+"+"+upc_matches[4]) * 3;
			EvenSum = eval(upc_matches[1]+"+"+upc_matches[3]+"+"+upc_matches[5]);
	if(re.findall("^(\d{1})(\d{5})([4-9])", upc)):
		upc_matches = re.findall("^(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})(\d{1})", upc);
		upc_matches=upc_matches[0];
		if(int(upc_matches[6])==4):
			OddSum = eval(upc_matches[2]+"+"+upc_matches[4]+"+"+upc_matches[5]) * 3;
			EvenSum = eval(upc_matches[1]+"+"+upc_matches[3]);
		if(int(upc_matches[6])==5):
			OddSum = eval(upc_matches[2]+"+"+upc_matches[4]+"+"+upc_matches[6]) * 3;
			EvenSum = eval(upc_matches[1]+"+"+upc_matches[3]+"+"+upc_matches[5]);
		if(int(upc_matches[6])==6):
			OddSum = eval(upc_matches[2]+"+"+upc_matches[4]+"+"+upc_matches[6]) * 3;
			EvenSum = eval(upc_matches[1]+"+"+upc_matches[3]+"+"+upc_matches[5]);
		if(int(upc_matches[6])==7):
			OddSum = eval(upc_matches[2]+"+"+upc_matches[4]+"+"+upc_matches[6]) * 3;
			EvenSum = eval(upc_matches[1]+"+"+upc_matches[3]+"+"+upc_matches[5]);
		if(int(upc_matches[6])==8):
			OddSum = eval(upc_matches[2]+"+"+upc_matches[4]+"+"+upc_matches[6]) * 3;
			EvenSum = eval(upc_matches[1]+"+"+upc_matches[3]+"+"+upc_matches[5]);
		if(int(upc_matches[6])==9):
			OddSum = eval(upc_matches[2]+"+"+upc_matches[4]+"+"+upc_matches[6]) * 3;
			EvenSum = eval(upc_matches[1]+"+"+upc_matches[3]+"+"+upc_matches[5]);
	AllSum = OddSum + EvenSum;
	CheckSum = AllSum % 10;
	if(CheckSum>0):
		CheckSum = 10 - CheckSum;
	if(return_check==False and len(upc)==8):
		if(CheckSum!=int(CheckDigit)):
			return False;
		if(CheckSum==int(CheckDigit)):
			return True;
	if(return_check==True):
		return CheckSum;
	if(len(upc)==7):
		return CheckSum;
def fix_upce_checksum(upc):
	if(len(upc)>7):
		fix_matches = re.findall("^(\d{7})", upc); 
		upc = fix_matches[0];
	return upc+str(validate_upce(upc,True));
