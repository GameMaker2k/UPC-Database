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
if ($File3Name == "password.php" || $File3Name == "/password.php") {
    chdir("../");
    require("./upc.php");
    exit();
}

// Fallback hash function for environments without the hash extension
// Drop-in replacement for the hash() function if it does not exist
if (!function_exists('hash')) {
    function hash($algo, $data, $raw_output = false)
    {
        // Supported algorithms for the fallback implementation
        $supported_algos = array('md5', 'sha1');

        // Check if the algorithm is supported
        if (!in_array($algo, $supported_algos)) {
            trigger_error("Unsupported hashing algorithm. Defaulting to 'md5'.", E_USER_WARNING);
            $algo = 'md5';  // Default to 'md5' if unsupported
        }

        // Hash the data using the specified algorithm
        $hash = ($algo == 'md5') ? md5($data) : sha1($data);

        // Handle raw output (binary) if requested
        return $raw_output ? hex2bin($hash) : $hash;
    }
}

// Define hmac() function as a custom implementation
function hmac($data, $key, $hash = 'sha1', $blocksize = 64)
{
    // If hash_hmac() is available, use it directly
    if (function_exists('hash_hmac')) {
        return hash_hmac($hash, $data, $key);
    }

    // Otherwise, use the custom implementation for HMAC
    // Normalize SHA-3 algorithm names for compatibility with hash()
    $hash = str_replace(['sha3-224', 'sha3-256', 'sha3-384', 'sha3-512'], ['sha3224', 'sha3256', 'sha3384', 'sha3512'], $hash);

    // Check if hash() function is available
    if (!function_exists('hash')) {
        trigger_error("hash() function not available. Cannot perform HMAC.", E_USER_WARNING);
        return false;
    }

    // Determine the block size for the hash function
    if (in_array($hash, ['sha384', 'sha512', 'sha3384', 'sha3512'])) {
        $blocksize = 128; // For SHA-512 and similar algorithms
    }

    // Hash the key if it is longer than the block size
    if (strlen($key) > $blocksize) {
        $key = pack('H*', hash($hash, $key));
    }

    // Pad the key to the block size
    $key = str_pad($key, $blocksize, chr(0x00));
    $ipad = str_repeat(chr(0x36), $blocksize);
    $opad = str_repeat(chr(0x5c), $blocksize);

    // Perform inner and outer hash calculations manually
    $inner = hash($hash, ($key ^ $ipad) . $data);
    $hmac = hash($hash, ($key ^ $opad) . pack('H*', $inner));

    // Restore original SHA-3 names for consistency
    $hash = str_replace(['sha3224', 'sha3256', 'sha3384', 'sha3512'], ['sha3-224', 'sha3-256', 'sha3-384', 'sha3-512'], $hash);

    return $hmac;
}
// b64hmac hash function
function b64e_hmac($data, $key, $extdata, $hash = 'sha1', $blocksize = 64)
{
    $extdata2 = hexdec($extdata);
    $key = $key.$extdata2;
    return base64_encode(hmac($data, $key, $hash, $blocksize).$extdata);
}
// b64hmac rot13 hash function
function b64e_rot13_hmac($data, $key, $extdata, $hash = 'sha1', $blocksize = 64)
{
    $data = str_rot13($data);
    $extdata2 = hexdec($extdata);
    $key = $key.$extdata2;
    return base64_encode(hmac($data, $key, $hash, $blocksize).$extdata);
}
// salt hmac hash function
function salt_hmac($size1 = 6, $size2 = 12)
{
    $hprand = rand($size1, $size2);
    $i = 0;
    $hpass = "";
    while ($i < $hprand) {
        $hspsrand = rand(1, 2);
        if ($hspsrand != 1 && $hspsrand != 2) {
            $hspsrand = 1;
        }
        if ($hspsrand == 1) {
            $hpass .= chr(rand(48, 57));
        }
        /* if($hspsrand==2) { $hpass .= chr(rand(65,70)); } */
        if ($hspsrand == 2) {
            $hpass .= chr(rand(97, 102));
        }
        ++$i;
    } return $hpass;
}
// PHP 5 hash algorithms to functions :o
// Automatically define hash functions for all supported algorithms
if (function_exists('hash') && function_exists('hash_algos')) {
    $algos = hash_algos();  // Get the list of available hash algorithms

    foreach ($algos as $algo) {
        // Format function names: Remove non-alphanumeric characters for function names
        $function_name = preg_replace('/[^a-zA-Z0-9]/', '', $algo);

        // Check if the function already exists to avoid redeclaration
        if (!function_exists($function_name)) {
            eval("
                function $function_name(\$data, \$raw_output = false) {
                    return hash('$algo', \$data, \$raw_output);
                }
            ");
        }
    }
}
// Try and convert IPB 2.0.0 style passwords to iDB style passwords
function hash2xkey($data, $key, $hash1 = 'md5', $hash2 = 'md5')
{
    return $hash1($hash2($key).$hash2($data));
}
// Hash two times with md5 and sha1 for DF2k
function PassHash2x($Text)
{
    $Text = md5($Text);
    $Text = sha1($Text);
    return $Text;
}
// Hash two times with hmac-md5 and hmac-sha1
function PassHash2x2($data, $key, $extdata, $blocksize = 64)
{
    $extdata2 = hexdec($extdata);
    $key = $key.$extdata2;
    $Text = hmac($data, $key, "md5").$extdata;
    $Text = hmac($Text, $key, "sha1").$extdata;
    return base64_encode($Text);
}
function cp($infile, $outfile, $mode = "w")
{
    $contents = file_get_contents($infile);
    $cpfp = fopen($outfile, $mode);
    fwrite($cpfp, $contents);
    fclose($cpfp);
    return true;
}
