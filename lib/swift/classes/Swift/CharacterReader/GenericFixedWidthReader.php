<?php

/*
 * This file is part of SwiftMailer.
 * (c) 2004-2009 Chris Corbyn
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Provides fixed-width byte sizes for reading fixed-width character sets.
 *
 * @yazilim    Swift
 * @subpackage Encoder
 * @web adresi
@web adresi
@web adresi     Chris Corbyn
 * @web adresi
@web adresi
@web adresi     Xavier De Cock <xdecock@gmail.com>
 */
class Swift_CharacterReader_GenericFixedWidthReader implements Swift_CharacterReader
{
    /**
     * The number of bytes in a single character.
     *
     * @var integer
     */
    private $_width;

    /**
     * Creates a new GenericFixedWidthReader using $width bytes per character.
     *
     * @param integer $width
     */
    public function __construct($width)
    {
        $this->_width = $width;
    }

    /**
     * Returns the complete character map.
     *
     * @param string  $string
     * @param integer $startOffset
     * @param array   $currentMap
     * @param mixed   $ignoredChars
     *
     * @return integer
     */
    public function getCharPositions($string, $startOffset, &$currentMap, &$ignoredChars)
    {
        $strlen = strlen($string);
        // % and / are CPU intensive, so, maybe find a better way
        $ignored = $strlen % $this->_width;
        $ignoredChars = substr($string, - $ignored);
        $currentMap = $this->_width;

        return ($strlen - $ignored) / $this->_width;
    }

    /**
     * Returns the mapType.
     *
     * @return integer
     */
    public function getMapType()
    {
        return self::MAP_TYPE_FIXED_LEN;
    }

    /**
     * Returns an integer which specifies how many more bytes to read.
     *
     * A positive integer indicates the number of more bytes to fetch before invoking
     * this method again.
     *
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
        $needed = $this->_width - $size;

        return ($needed > -1) ? $needed : -1;
    }

    /**
     * Returns the number of bytes which should be read to start each character.
     *
     * @return integer
     */
    public function getInitialByteSize()
    {
        return $this->_width;
    }
}
