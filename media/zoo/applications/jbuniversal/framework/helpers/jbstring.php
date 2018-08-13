<?php
/**
 * JBZoo App is universal Joomla CCK, application for YooTheme Zoo component
 *
 * @package     jbzoo
 * @version     2.x Pro
 * @author      JBZoo App http://jbzoo.com
 * @copyright   Copyright (C) JBZoo.com,  All rights reserved.
 * @license     http://jbzoo.com/license-pro.php JBZoo Licence
 * @coder       Denis Smetannikov <denis@jbzoo.com>
 */

// no direct access
defined('_JEXEC') or die('Restricted access');


/**
 * Class JBStringHelper
 */
class JBStringHelper extends AppHelper
{

    const MAX_LENGTH = 30;

    /**
     * Get sub string (by words)
     * @param $text
     * @param $searchword
     * @return mixed|string
     */
    public function smartSubstr($text, $searchword)
    {
        $length      = self::MAX_LENGTH;
        $textlen     = JString::strlen($text);
        $lsearchword = JString::strtolower($searchword);
        $wordfound   = false;
        $pos         = 0;
        $chunk       = '';

        while ($wordfound === false && $pos < $textlen) {

            if (($wordpos = @JString::strpos($text, ' ', $pos + $length)) !== false) {
                $chunk_size = $wordpos - $pos;
            } else {
                $chunk_size = $length;
            }

            $chunk     = JString::substr($text, $pos, $chunk_size);
            $wordfound = JString::strpos(JString::strtolower($chunk), $lsearchword);

            if ($wordfound === false) {
                $pos += $chunk_size + 1;
            }
        }

        if ($wordfound !== false) {
            return (($pos > 0) ? '...' : '') . $chunk;

        } elseif (($wordpos = @JString::strpos($text, ' ', $length)) !== false) {
            return JString::substr($text, 0, $wordpos) . '...';

        } else {
            return JString::substr($text, 0, $length);
        }
    }


    /**
     * Get truncated string (by words)
     * @param $string
     * @param $maxlen
     * @return string
     */
    public function cutByWords($string, $maxlen = 255)
    {

        $len    = (JString::strlen($string) > $maxlen) ? JString::strrpos(JString::substr($string, 0, $maxlen), ' ') : $maxlen;
        $cutStr = JString::substr($string, 0, $len);

        return (JString::strlen($string) > $maxlen) ? $cutStr . '...' : $cutStr;
    }

    /**
     * Parse text by lines
     * @param string $text
     * @return array
     */
    public function parseLines($text)
    {
        $text  = JString::trim($text);
        $lines = explode("\n", $text);

        $result = array();
        if (!empty($lines)) {

            foreach ($lines as $line) {

                $line = JString::trim($line);
                if (!empty($line)) {
                    $result[] = $line;
                }

            }
        }

        return $result;
    }
}