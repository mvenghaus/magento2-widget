<?php

declare(strict_types=1);

namespace Mvenghaus\Magento2WidgetDirective;

use Mvenghaus\Magento2WidgetDirective\Data\WidgetData;
use Mvenghaus\Magento2WidgetDirective\Exceptions\WidgetParseException;

class WidgetParser
{
    /**
     * @param  string  $content
     * @return array<WidgetData>
     * @throws WidgetParseException
     */
    public function parse(string $content): array
    {
        preg_match_all('/{{widget([^}]+)}}/i', $content, $results);

        $directives = $results[1] ?? [];
        if (count($directives) === 0) {
            return $directives;
        }

        $widgets = [];
        foreach ($directives as $directive) {
            preg_match_all('/ (.*?)="([^"]+)/', $directive, $results);

            $paramKeys = $results[1] ?? [];
            $paramValues = $results[2] ?? [];

            $type = null;
            $properties = [];
            foreach ($paramKeys as $index => $paramKey) {
                $paramValue = $paramValues[$index] ?? null;
                if ($paramValue === null) {
                    throw new WidgetParseException($directive);
                }

                if ($paramKey === 'type') {
                    $type = $paramValue;
                    continue;
                }

                $properties[$paramKey] = $paramValue;
            }

            if ($type === null) {
                throw new WidgetParseException($directive);
            }

            $widgets[] = new WidgetData(
                type: $type,
                properties: $properties
            );
        }

        return $widgets;
    }
}