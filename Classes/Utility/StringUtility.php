<?php

namespace Sethorax\Fluidloader\Utility;

/**
 * Class StringUtility.
 */
class StringUtility
{
    /**
     * Returns string between $needleStart and $needleEnd.
     *
     * @param string $haystack
     * @param string $needleStart
     * @param string $needleEnd
     *
     * @return mixed
     */
    public static function getContentsBetweenStrings($haystack, $needleStart, $needleEnd)
    {
        $stringFromStart = substr($haystack, strpos($haystack, $needleStart) + strlen($needleStart));
        $excessString = substr($haystack, strpos($haystack, $needleEnd));

        return str_replace($excessString, '', $stringFromStart);
    }
}
