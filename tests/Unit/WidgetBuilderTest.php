<?php

declare(strict_types=1);

use Mvenghaus\Magento2WidgetDirective\Data\WidgetData;
use Mvenghaus\Magento2WidgetDirective\WidgetBuilder;

test('can build widgets', function () {
    $widgetBuilder = new WidgetBuilder();

    $result = $widgetBuilder->build(
        new WidgetData(
            type: '\\TestWidget\\Widget',
            properties: [
                'param1' => 'foo',
                'param2' => 'bar'
            ]
        )
    );

    expect($result)
        ->toBe('{{widget type="\\TestWidget\\Widget" param1="foo" param2="bar"}}');
});
