<?php

declare(strict_types=1);

namespace Mvenghaus\Magento2WidgetDirective\Data;

class WidgetData
{
    public function __construct(
        public string $type,
        public array $properties
    ) {
    }
}