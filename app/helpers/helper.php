<?php

if (!function_exists('formatKg')) {
    function formatKg($value) {
        $num = floatval($value);

        if (floor($num) == $num) {
            return intval($num) . " kg";
        }

        $formatted = rtrim(rtrim(number_format($num, 1, '.', ''), '0'), '.');
        return $formatted . " kg";
    }
}

if (!function_exists('format')) {
    function format($value) {
        $num = floatval($value);

        if (floor($num) == $num) {
            return intval($num);
        }

        $formatted = rtrim(rtrim(number_format($num, 1, '.', ''), '0'), '.');
        return $formatted;
    }
}



if (!function_exists('formatRupiah')) {
    function formatRupiah($angka, $prefix = 'Rp ') {
        return $prefix . number_format($angka, 0, ',', '.');
    }
}


if (! function_exists('firstCharUpper')) {
    function firstCharUpper(string $text): string
    {
        if (trim($text) === '') {
            return '';
        }

        return mb_strtoupper(mb_substr($text, 0, 1));
    }
}