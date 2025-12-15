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



if (!function_exists('formatRupiah')) {
    function formatRupiah($angka, $prefix = 'Rp ') {
        return $prefix . number_format($angka, 0, ',', '.');
    }
}
