<?php

if (!function_exists('convertPrice')) {
    function convertPrice($amount, $currency = 'đ')
    {
        return number_format($amount) . $currency;
    }
}
