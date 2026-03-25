<?php

namespace App\Support;

class PageContentFormatter
{
    public static function format(?string $content): string
    {
        $content = trim((string) $content);

        if ($content === '') {
            return '';
        }

        if (self::containsBlockHtml($content)) {
            return $content;
        }

        return self::formatPlainText($content);
    }

    private static function containsBlockHtml(string $content): bool
    {
        return preg_match('/<\s*(article|aside|blockquote|div|dl|figure|figcaption|h[1-6]|hr|iframe|img|li|ol|p|pre|section|table|tbody|td|th|thead|tr|ul)\b/i', $content) === 1;
    }

    private static function formatPlainText(string $content): string
    {
        $lines = preg_split('/\R/u', str_replace("\r", '', $content)) ?: [];
        $html = [];
        $listType = null;
        $listItems = [];
        $implicitList = false;

        $flushList = static function () use (&$html, &$listType, &$listItems): void {
            if ($listType === null || $listItems === []) {
                $listType = null;
                $listItems = [];

                return;
            }

            $items = implode('', array_map(static fn (string $item): string => '<li>'.$item.'</li>', $listItems));
            $html[] = '<'.$listType.'>'.$items.'</'.$listType.'>';
            $listType = null;
            $listItems = [];
        };

        foreach ($lines as $index => $rawLine) {
            $line = trim($rawLine);

            if ($line === '') {
                $flushList();
                $implicitList = false;
                continue;
            }

            if (preg_match('/^(?:[-*\\x{2022}]\s+)(.+)$/u', $line, $matches)) {
                if ($listType !== 'ul') {
                    $flushList();
                    $listType = 'ul';
                }

                $listItems[] = e($matches[1]);
                $implicitList = false;
                continue;
            }

            if (preg_match('/^\d+[\.\)]\s+(.+)$/u', $line, $matches)) {
                if ($listType !== 'ol') {
                    $flushList();
                    $listType = 'ol';
                }

                $listItems[] = e($matches[1]);
                $implicitList = false;
                continue;
            }

            if ($implicitList && self::looksLikeListItem($line)) {
                if ($listType !== 'ul') {
                    $flushList();
                    $listType = 'ul';
                }

                $listItems[] = e($line);
                continue;
            }

            $flushList();

            $previous = $index > 0 ? $lines[$index - 1] : null;
            $next = self::nextNonEmptyLine($lines, $index);

            if (self::shouldBeHeading($line, $previous, $next)) {
                $html[] = '<h2>'.e($line).'</h2>';
                $implicitList = false;
                continue;
            }

            $html[] = '<p>'.e($line).'</p>';
            $implicitList = str_ends_with($line, ':');
        }

        $flushList();

        return implode("\n", $html);
    }

    private static function nextNonEmptyLine(array $lines, int $index): ?string
    {
        for ($i = $index + 1, $count = count($lines); $i < $count; $i++) {
            $line = trim($lines[$i]);

            if ($line !== '') {
                return $line;
            }
        }

        return null;
    }

    private static function shouldBeHeading(string $line, ?string $previous, ?string $next): bool
    {
        if ($next === null) {
            return false;
        }

        if (mb_strlen($line) > 90) {
            return false;
        }

        if ($previous !== null && trim($previous) !== '') {
            return false;
        }

        return preg_match('/[.!?]$/u', $line) !== 1;
    }

    private static function looksLikeListItem(string $line): bool
    {
        if (mb_strlen($line) > 80) {
            return false;
        }

        return preg_match('/[.!?]$/u', $line) !== 1;
    }
}
