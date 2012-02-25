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

    $FileInfo: password.php - Last Update: 02/13/2012 Ver. 2.2.5 RC 1 - Author: cooldude2k $
*/
$File3Name = basename($_SERVER['SCRIPT_NAME']);
if ($File3Name=="password.php"||$File3Name=="/password.php") {
	chdir("../");
	require("./upc.php");
	exit(); }

// hmac hash function
function hmac($data,$key,$hash='sha1',$blocksize=64) {
  if (!function_exists('hash_hmac')) {
  if (strlen($key)>$blocksize) {
  if (function_exists('hash')) {
  $key=pack('H*',hash($hash, $key)); }
  if (!function_exists('hash')) {
  $key=pack('H*',$hash($key)); } }
  $key=str_pad($key, $blocksize, chr(0x00));
  $ipad=str_repeat(chr(0x36),$blocksize);
  $opad=str_repeat(chr(0x5c),$blocksize);
  if (function_exists('hash')) {
  return hash($hash, ($key^$opad).pack('H*',hash($hash, ($key^$ipad).$data))); }
  if (!function_exists('hash')) {
  return $hash(($key^$opad).pack('H*',$hash(($key^$ipad).$data))); } }
  if (function_exists('hash_hmac')) { 
  return hash_hmac($hash,$data,$key); } }
// b64hmac hash function
function b64e_hmac($data,$key,$extdata,$hash='sha1',$blocksize=64) {
	$extdata2 = hexdec($extdata); $key = $key.$extdata2;
  return base64_encode(hmac($data,$key,$hash,$blocksize).$extdata); }
// b64hmac rot13 hash function
function b64e_rot13_hmac($data,$key,$extdata,$hash='sha1',$blocksize=64) {
	$data = str_rot13($data);
	$extdata2 = hexdec($extdata); $key = $key.$extdata2;
  return base64_encode(hmac($data,$key,$hash,$blocksize).$extdata); }
// salt hmac hash function
function salt_hmac($size1=6,$size2=12) {
$hprand = rand($size1,$size2); $i = 0; $hpass = "";
while ($i < $hprand) {
$hspsrand = rand(1,2);
if($hspsrand!=1&&$hspsrand!=2) { $hspsrand=1; }
if($hspsrand==1) { $hpass .= chr(rand(48,57)); }
/* if($hspsrand==2) { $hpass .= chr(rand(65,70)); } */
if($hspsrand==2) { $hpass .= chr(rand(97,102)); }
++$i; } return $hpass; }
// PHP 5 hash algorithms to functions :o 
if(function_exists('hash')&&function_exists('hash_algos')) {
if(in_array("md2",hash_algos())&&!function_exists("md2")) { 
function md2($data) { return hash("md2",$data); } } 
if(in_array("md4",hash_algos())&&!function_exists("md4")) { 
function md4($data) { return hash("md4",$data); } }
if(in_array("md5",hash_algos())&&!function_exists("md5")) { 
function md5($data) { return hash("md5",$data); } }
if(in_array("sha1",hash_algos())&&!function_exists("sha1")) { 
function sha1($data) { return hash("sha1",$data); } }
if(in_array("sha224",hash_algos())&&!function_exists("sha224")) { 
function sha224($data) { return hash("sha224",$data); } }
if(in_array("sha256",hash_algos())&&!function_exists("sha256")) { 
function sha256($data) { return hash("sha256",$data); } }
if(in_array("sha384",hash_algos())&&!function_exists("sha384")) { 
function sha384($data) { return hash("sha384",$data); } }
if(in_array("sha512",hash_algos())&&!function_exists("sha512")) { 
function sha512($data) { return hash("sha512",$data); } }
if(in_array("ripemd128",hash_algos())&&!function_exists("ripemd128")) { 
function ripemd128($data) { return hash("ripemd128",$data); } }
if(in_array("ripemd160",hash_algos())&&!function_exists("ripemd160")) { 
function ripemd160($data) { return hash("ripemd160",$data); } }
if(in_array("ripemd256",hash_algos())&&!function_exists("ripemd256")) { 
function ripemd256($data) { return hash("ripemd256",$data); } }
if(in_array("ripemd512",hash_algos())&&!function_exists("ripemd512")) { 
function ripemd320($data) { return hash("ripemd320",$data); } } 
if(in_array("salsa10",hash_algos())&&!function_exists("salsa10")) { 
function salsa10($data) { return hash("salsa10",$data); } }
if(in_array("salsa20",hash_algos())&&!function_exists("salsa20")) { 
function salsa20($data) { return hash("salsa20",$data); } } 
if(in_array("snefru",hash_algos())&&!function_exists("snefru")) { 
function snefru($data) { return hash("snefru",$data); } }
if(in_array("snefru256",hash_algos())&&!function_exists("snefru256")) { 
function snefru256($data) { return hash("snefru256",$data); } }
if(in_array("gost",hash_algos())&&!function_exists("gost")) { 
function gost($data) { return hash("gost",$data); } } 
if(in_array("joaat",hash_algos())&&!function_exists("joaat")) { 
function joaat($data) { return hash("joaat",$data); } } }
// Try and convert IPB 2.0.0 style passwords to iDB style passwords
function hash2xkey($data,$key,$hash1='md5',$hash2='md5') {
  return $hash1($hash2($key).$hash2($data)); }
// Hash two times with md5 and sha1 for DF2k
function PassHash2x($Text) {
$Text = md5($Text);
$Text = sha1($Text);
return $Text; }
// Hash two times with hmac-md5 and hmac-sha1
function PassHash2x2($data,$key,$extdata,$blocksize=64) {
$extdata2 = hexdec($extdata); $key = $key.$extdata2;
$Text = hmac($data,$key,"md5").$extdata; 
$Text = hmac($Text,$key,"sha1").$extdata;
return base64_encode($Text); }
function cp($infile,$outfile,$mode="w") { 
   $contents = file_get_contents($infile);
   $cpfp = fopen($outfile,$mode);
   fwrite($cpfp, $contents);
   fclose($cpfp);
   return true; }
?>