<?php

use Morilog\Jalali\Jalalian;

if (! function_exists('toman')) {
    function toman(int $amount): string
    {
        return number_format($amount);
    }
}

if (! function_exists('toJalali')) {
    function toJalali(mixed $timestamp, string $format = 'Y/m/d'): string
    {
        if (! $timestamp) {
            return '';
        }

        return Jalalian::fromCarbon(
            \Illuminate\Support\Carbon::parse($timestamp)
        )->format($format);
    }
}

if (! function_exists('toGregorian')) {
    function toGregorian(string $jalaliDate, string $format = 'Y-m-d'): string
    {
        return Jalalian::fromFormat('Y/m/d', $jalaliDate)->toCarbon()->format($format);
    }
}

if (! function_exists('getRealIp')) {
    function getRealIp(): string
    {
        $request = request();

        return $request->header('X-Forwarded-For')
            ?? $request->header('X-Real-IP')
            ?? $request->ip()
            ?? '0.0.0.0';
    }
}

if (! function_exists('persianDigits')) {
    function persianDigits(int|string $number): string
    {
        $persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
        $english = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];

        return str_replace($english, $persian, (string) $number);
    }
}
