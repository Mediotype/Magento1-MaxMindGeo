<?php
class Mediotype_MaxMindGeo_Model_Reader_Util
{

    public static function read($stream, $offset, $numberOfBytes)
    {
        if ($numberOfBytes == 0) {
            return '';
        }
        if (fseek($stream, $offset) == 0) {
            $value = fread($stream, $numberOfBytes);
            if (static::stringLength($value) === $numberOfBytes) {
                return $value;
            }
        }
        throw new Mediotype_MaxMindGeo_Model_Reader_InvalidDatabaseException(
            "The MaxMind DB file contains bad data"
        );
    }

    public static function stringLength($string)
    {
        if (function_exists('mb_strlen')) {
            return mb_strlen($string, '8bit');
        }

        return strlen($string);
    }
}
