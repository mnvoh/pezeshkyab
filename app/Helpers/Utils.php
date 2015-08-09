<?php
require_once(dirname(__FILE__) . '/jdf.php');

class Utils {
    /**
     * Applies substr to $str without cutting any words.
     * @param $str          The string
     * @param $min_length   The minimum length of the product string.
     * @return string       The substring of $str cut right after the first word found at $min_length
     *                      with three dots (...) added to the end if $min_length is not greater
     *                      or equal to the string length.
     */
    public static function word_safe_substr($str, $min_length) {
        $word_terminators = [' ', '.', ',', "\n", "\r"];
        for(;;$min_length++) {
            if(in_array(substr($str, $min_length, 1), $word_terminators)) {
                break;
            }
        }
        if($min_length >= strlen($str))
            return $str;
        else
            return substr($str, 0, $min_length) . " ...";
    }

	public static function prefDate($timestamp, $lang) {
		if($lang == "fa")
			return jdate('Y/m/d H:i:s', $timestamp);
		else
			return date('Y-m-d H:i:s', $timestamp);
	}
}