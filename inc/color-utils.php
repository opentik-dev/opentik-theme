<?php
/**
 * Shared color utilities.
 * Converts hex colors to RGB/RGBA and picks a readable text color.
 */

if (!function_exists('opentik_hex_to_rgb')) {
    function opentik_hex_to_rgb(string $hex): array
    {
        $hex = ltrim(trim($hex), '#');
        if (strlen($hex) === 3) {
            $hex = $hex[0] . $hex[0] . $hex[1] . $hex[1] . $hex[2] . $hex[2];
        }
        return [
            hexdec(substr($hex, 0, 2)),
            hexdec(substr($hex, 2, 2)),
            hexdec(substr($hex, 4, 2)),
        ];
    }
}

if (!function_exists('opentik_hex_to_rgba')) {
    function opentik_hex_to_rgba(string $hex, float $alpha = 1.0): string
    {
        [$r, $g, $b] = opentik_hex_to_rgb($hex);
        return "rgba($r, $g, $b, $alpha)";
    }
}

if (!function_exists('opentik_contrast_text')) {
    function opentik_contrast_text(string $hex): string
    {
        [$r, $g, $b] = opentik_hex_to_rgb($hex);
        $brightness = (($r * 299) + ($g * 587) + ($b * 114)) / 1000;
        return $brightness > 125 ? '#0f172a' : '#ffffff';
    }
}