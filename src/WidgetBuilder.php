<?php

declare(strict_types=1);

namespace Mvenghaus\Magento2WidgetDirective;

use Mvenghaus\Magento2WidgetDirective\Data\WidgetData;

class WidgetBuilder
{
    public function build(WidgetData $widget): string
    {
        $params = [];
        foreach ($widget->properties as $key => $value)
        {
            $params[] = sprintf('%s="%s"', $key, $value);
        }

        return sprintf(
            '{{widget type="%s" %s}}',
            $widget->type,
            implode(' ', $params)
        );
    }
}