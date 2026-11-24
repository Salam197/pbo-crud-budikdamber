<?php

class Helper
{
    public static function clean(string $input): string
    {
        return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
    }

    public static function statusAirColor(string $kondisi): string
    {
        return match ($kondisi) {
            'Jernih' => 'success',
            'Keruh Ringan' => 'warning',
            default => 'danger',
        };
    }
}