<?php

declare(strict_types=1);

namespace Mvenghaus\Magento2WidgetDirective;

use Mvenghaus\Magento2WidgetDirective\Data\WidgetData;
use Mvenghaus\Magento2WidgetDirective\Exceptions\WidgetParseException;
use Mvenghaus\Magento2WidgetDirective\Tokenizer\ParameterTokenizer;

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
            $tokenizer = new ParameterTokenizer();
            $tokenizer->setString(html_entity_decode($directive));
            $properties = $tokenizer->tokenize();

            $type = $properties['type'] ?? null;
            if ($type === null) {
                throw new WidgetParseException($directive);
            }

            unset($properties['type']);

            $widgets[] = new WidgetData(
                type: $type,
                properties: $properties
            );
        }

        return $widgets;
    }
}