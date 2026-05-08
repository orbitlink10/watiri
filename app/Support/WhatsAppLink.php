<?php

namespace App\Support;

use Illuminate\Support\Str;

class WhatsAppLink
{
    public static function fromPhone(?string $value, string $countryCode = '254'): ?string
    {
        $phone = static::normalizePhone($value, $countryCode);

        return $phone ? 'https://wa.me/'.$phone : null;
    }

    public static function maybeNormalize(?string $value, string $countryCode = '254'): ?string
    {
        if (blank($value)) {
            return null;
        }

        $value = trim($value);

        if (static::looksLikeWhatsAppUrl($value)) {
            return static::normalizeWhatsAppUrl($value, $countryCode) ?? $value;
        }

        if (static::looksLikePhoneNumber($value)) {
            return static::fromPhone($value, $countryCode) ?? $value;
        }

        return $value;
    }

    public static function normalizePhone(?string $value, string $countryCode = '254'): ?string
    {
        if (blank($value)) {
            return null;
        }

        $countryCode = static::digits($countryCode) ?: '254';
        $digits = static::digits(urldecode(trim($value)));

        if ($digits === '') {
            return null;
        }

        if (Str::startsWith($digits, '00')) {
            $digits = substr($digits, 2);
        }

        if (Str::startsWith($digits, $countryCode)) {
            return $digits;
        }

        if (strlen($digits) === 10 && Str::startsWith($digits, '0')) {
            return $countryCode.substr($digits, 1);
        }

        if (strlen($digits) === 9) {
            return $countryCode.$digits;
        }

        return $digits;
    }

    protected static function normalizeWhatsAppUrl(string $value, string $countryCode): ?string
    {
        $normalizedValue = preg_match('#^https?://#i', $value) ? $value : 'https://'.ltrim($value, '/');
        $parts = parse_url($normalizedValue);

        if (! is_array($parts)) {
            return null;
        }

        $host = strtolower($parts['host'] ?? '');
        $host = preg_replace('/^www\./', '', $host);

        if (! in_array($host, ['wa.me', 'api.whatsapp.com', 'whatsapp.com'], true)) {
            return null;
        }

        parse_str($parts['query'] ?? '', $query);

        $phone = static::extractPhoneFromPath($parts['path'] ?? '');

        if (blank($phone) && is_string($query['phone'] ?? null)) {
            $phone = $query['phone'];
        }

        if (blank($phone) && is_string($query['deeplink'] ?? null)) {
            $phone = $query['deeplink'];
        }

        $phone = static::normalizePhone($phone, $countryCode);

        if (! $phone) {
            return null;
        }

        $normalized = 'https://wa.me/'.$phone;

        if (is_string($query['text'] ?? null) && $query['text'] !== '') {
            $normalized .= '?text='.rawurlencode($query['text']);
        }

        return $normalized;
    }

    protected static function extractPhoneFromPath(string $path): ?string
    {
        $path = trim(urldecode($path), '/');

        if ($path === '' || in_array($path, ['send', 'message', 'resolve'], true)) {
            return null;
        }

        return $path;
    }

    protected static function looksLikePhoneNumber(string $value): bool
    {
        return preg_match('/^\/?[+\d][\d\s().-]{6,}$/', $value) === 1;
    }

    protected static function looksLikeWhatsAppUrl(string $value): bool
    {
        return Str::contains(strtolower($value), ['wa.me', 'whatsapp.com']);
    }

    protected static function digits(string $value): string
    {
        return preg_replace('/\D+/', '', $value) ?? '';
    }
}
