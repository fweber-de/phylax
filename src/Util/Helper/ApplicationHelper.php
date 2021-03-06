<?php

namespace Util\Helper;

/**
 * @author Florian Weber <florian.weber@fweber.info>
 */
class ApplicationHelper
{
    /**
     * @param string $name
     *
     * @return string
     */
    public static function generateAppKey($name)
    {
        return sha1($name);
    }

    /**
     * @param string $name
     *
     * @return string
     */
    public static function generateSlug($text)
    {
        // replace non letter or digits by -
        $text = preg_replace('~[^\\pL\d]+~u', '-', $text);

        // trim
        $text = trim($text, '-');

        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // lowercase
        $text = strtolower($text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }
}
