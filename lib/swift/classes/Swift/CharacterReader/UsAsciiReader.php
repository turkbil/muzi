<?php

/*
 * This file is part of SwiftMailer.
 * (c) 2004-2009 Chris Corbyn
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Analyzes US-ASCII characters.
 *
 * @yazilim    Swift
 * @subpackage Encoder
 * @web adresi
@web adresi
@web adresi     Chris Corbyn
 */
class Swift_CharacterReader_UsAsciiReader implements Swift_CharacterReader
{
    /**
     * Returns the complete character map.
     *
     * @param string  $string
     * @param integer $startOffset
     * @param array   $currentMap
     * @param string  $ignoredChars
     *
     * @return integer
     */
    public function getCharPositions($string, $startOffset, &$currentMap, &$ignoredChars)
    {
        $strlen=strlen($string);
        $ignoredChars='';
        for ($i = 0; $i < $strlen; ++$i) {
            if ($string[$i]>"\x07F") { // Invalid char
                $currentMap[$i+$startOffset]=$string[$i];
            }
        }

        return $strlen;
    }

    /**
     * Returns mapType
     *
     * @return integer mapType
     */
    public function getMapType()
    {
        return self::MAP_TYPE_INVALID;
    }

    /**
     * Returns an integer which specifies how many more bytes to read.
     *
     * A positive integer indicates the number of more bytes to fetch before invoking
     * this method again.
     * A value of zero means this is already a valid character.
     * A value of -1 means this cannot possibly be a valid character.
     *
     * @param string  $bytes
     * @param integer $size
     *
     * @return integer
     */
    public function validateByteSequence($bytes, $size)
    {
        $byte = reset($bytes);
        if (1 == count($bytes) && $byte >= 0x00 && $byte <= 0x7F) {
            return 0;
        } else {
            return -1;
        }
    }

    /**
     * Returns the number of bytes which should be read to start each character.
     *
     * @return integer
     */
    public function getInitialByteSize()
    {
        return 1;
    }
}
