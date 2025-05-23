<?php

/*
 * This file is part of SwiftMailer.
 * (c) 2004-2009 Chris Corbyn
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * An abstract means of reading data.
 *
 * Classes implementing this interface may use a subsystem which requires less
 * memory than working with large strings of data.
 *
 * @yazilim    Swift
 * @subpackage ByteStream
 * @web adresi
@web adresi
@web adresi     Chris Corbyn
 */
interface Swift_OutputByteStream
{
    /**
     * Reads $length bytes from the stream into a string and moves the pointer
     * through the stream by $length.
     *
     * If less bytes exist than are requested the remaining bytes are given instead.
     * If no bytes are remaining at all, boolean false is returned.
     *
     * @param integer $length
     *
     * @return string|boolean
     *
     * @throws Swift_IoException
     */
    public function read($length);

    /**
     * Move the internal read pointer to $byteOffset in the stream.
     *
     * @param integer $byteOffset
     *
     * @return boolean
     *
     * @throws Swift_IoException
     */
    public function setReadPointer($byteOffset);
}
