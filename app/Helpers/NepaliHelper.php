<?php

namespace App\Helpers;

class NepaliHelper
{
    /**
     * Map of English to Devanagari digits.
     *
     * @var array
     */
    protected static $nepaliDigits = [
        '0' => '०',
        '1' => '१',
        '2' => '२',
        '3' => '३',
        '4' => '४',
        '5' => '५',
        '6' => '६',
        '7' => '७',
        '8' => '८',
        '9' => '९',
    ];

    /**
     * Convert English digits to Devanagari digits.
     *
     * @param string|int|float|null $input
     * @return string
     */
    public static function toDevanagari($input)
    {
        if ($input === null || $input === '') {
            return '';
        }
        return strtr((string) $input, self::$nepaliDigits);
    }

    /**
     * Convert Devanagari digits to English digits.
     *
     * @param string|null $input
     * @return string
     */
    public static function toEnglish($input)
    {
        if ($input === null || $input === '') {
            return '';
        }
        $flipped = array_flip(self::$nepaliDigits);
        return strtr((string) $input, $flipped);
    }

    /**
     * Format a number according to the active locale or explicit override.
     *
     * @param string|int|float $number
     * @param bool|null $useDevanagari
     * @return string
     */
    public static function formatNumber($number, $useDevanagari = null)
    {
        if ($useDevanagari === null) {
            $useDevanagari = (app()->getLocale() === 'ne');
        }

        $formatted = (string) $number;
        return $useDevanagari ? self::toDevanagari($formatted) : $formatted;
    }

    /**
     * Format currency in NPR / रु.
     *
     * @param float|int $amount
     * @param int $decimals
     * @param bool|null $useDevanagari
     * @return string
     */
    public static function formatNpr($amount, $decimals = 2, $useDevanagari = null)
    {
        if ($useDevanagari === null) {
            $useDevanagari = (app()->getLocale() === 'ne');
        }

        $formattedAmount = number_format((float) $amount, $decimals, '.', ',');

        if ($useDevanagari) {
            return 'रु ' . self::toDevanagari($formattedAmount);
        }

        return 'NPR ' . $formattedAmount;
    }
}
