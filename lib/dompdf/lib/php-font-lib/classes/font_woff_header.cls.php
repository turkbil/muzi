<?php
/**
 * @yazilim php-font-lib
 * @link    http://php-font-lib.googlecode.com/
 * @web adresi
@web adresi
@web adresi  Fabien M�nager <fabien.menager@gmail.com>
 * @license http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License
 * @version $Id: font_woff_header.cls.php 34 2011-10-23 13:53:25Z fabien.menager $
 */

require_once dirname(__FILE__)."/font_truetype_header.cls.php";

/**
 * WOFF font file header.
 * 
 * @yazilim php-font-lib
 */
class Font_WOFF_Header extends Font_TrueType_Header {
  protected $def = array(
    "format"         => self::uint32,
    "flavor"         => self::uint32,
    "length"         => self::uint32,
    "numTables"      => self::uint16,
                        self::uint16,
    "totalSfntSize"  => self::uint32,
    "majorVersion"   => self::uint16,
    "minorVersion"   => self::uint16,
    "metaOffset"     => self::uint32,
    "metaLength"     => self::uint32,
    "metaOrigLength" => self::uint32,
    "privOffset"     => self::uint32,
    "privLength"     => self::uint32,
  );
}