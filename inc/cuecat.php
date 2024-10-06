<?php

########################################################################
#
# Project: Grocery List
# URL: http://sourceforge.net/projects/grocery-list/
# E-mail: hide@address.com
#
# Copyright: (C) 2010, Neil McNab
# License: GNU General Public License Version 3
#
# This program is free software: you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation, version 3 of the License.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
# GNU General Public License for more details.
#
# You should have received a copy of the GNU General Public License
# along with this program.  If not, see <http://www.gnu.org/licenses/>.
#
# Filename: $URL: https://grocery-list.svn.sourceforge.net/svnroot/grocery-list/releases/1.0/include/cuecat.php $
# Last Updated: $Date: 2010-03-07 21:53:54 -0800 (Sun, 07 Mar 2010) $
# Author(s): Neil McNab
#
# Description:
#   Cuecat decode to normal UPC functions.
#
########################################################################

/*
http://osiris.978.org/~brianr/cuecat/files/cuecat-0.0.8/SUPPORTED_BARCODES

http://www.accipiter.org/projects/cat.php

http://uscan.sourceforge.net/upc.txt

divide the UPC into 4 groups of three digits
use the scheme below to translate each digit into its output



    1  2  3

0   C3 n  Z
1   CN j  Y
2   Cx f  X
3   Ch b  W
4   D3 D  3
5   DN z  2
6   Dx v  1
7   Dh r  0
8   E3 T  7
9   EN P  6

*/

$File3Name = basename($_SERVER['SCRIPT_NAME']);
if ($File3Name == "cuecat.php" || $File3Name == "/cuecat.php") {
    chdir("../");
    require("./upc.php");
    exit();
}

if (!isset($upcfunctions)) {
    $upcfunctions = array();
}
if (!is_array($upcfunctions)) {
    $upcfunctions = array();
}
array_push($upcfunctions, "cuecat_decode", "cuecat_decode_block");
function cuecat_decode($ccstr)
{
    $ccparts = explode(".", $ccstr);
    $upcstr = "";
    if ('fHmc' == $ccparts[2]) {
        // decode UPC-A
        $upcstr .= cuecat_decode_block(substr($ccparts[3], 0, 4));
        $upcstr .= cuecat_decode_block(substr($ccparts[3], 4, 4));
        $upcstr .= cuecat_decode_block(substr($ccparts[3], 8, 4));
        $upcstr .= cuecat_decode_block(substr($ccparts[3], 12, 4));
    } elseif ('fHmg' == $ccparts[2]) {
        // decode UPC-E
        $upcstr .= cuecat_decode_block(substr($ccparts[3], 0, 4));
        $upcstr .= cuecat_decode_block(substr($ccparts[3], 4, 4));
        $upcstr .= cuecat_decode_block(substr($ccparts[3], 8, 2));
        $upcstr = compute_check_digit($upcstr . 'X');
    }

    return $upcstr;
}

function cuecat_decode_block($ccblock)
{
    $lookup1 = array(
        '' => '',
        'C3' => '0', 'CW' => '0',
        'CN' => '1',
        'Cx' => '2',
        'Ch' => '3',
        'D3' => '4',
        'DN' => '5',
        'Dx' => '6',
        'Dh' => '7',
        'E3' => '8',
        'EN' => '9',
    );
    $lookup2 = array(
        '' => '',
        'n' => '0',
        'j' => '1',
        'f' => '2',
        'b' => '3',
        'D' => '4',
        'z' => '5',
        'v' => '6',
        'r' => '7',
        'T' => '8',
        'P' => '9',
    );
    $lookup3 = array(
        '' => '',
        'Z' => '0',
        'Y' => '1',
        'X' => '2',
        'W' => '3',
        '3' => '4',
        '2' => '5',
        '1' => '6',
        '0' => '7',
        '7' => '8',
        '6' => '9',
    );

    $result = "";
    $result .= $lookup1[strval(substr($ccblock, 0, 2))];
    $result .= $lookup2[strval(substr($ccblock, 2, 1))];
    $result .= $lookup3[strval(substr($ccblock, 3, 1))];

    return $result;
}

//print cuecat_decode(".C3nZC3nZC3nYD3b6ENnZCNnY.fHmc.C3D1Dxr2C3nZE3n7.");
//print cuecat_decode(".C3nZC3nZC3nXC3v2Dhz6C3nX.fHmg.C3T0CxrYCW.");
//print cuecat_decode(".C3nZC3nZC3nXC3v2Dhz6C3nX.fHmg.C3bZDhr2CW.");
