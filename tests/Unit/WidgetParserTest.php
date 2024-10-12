<?php

declare(strict_types=1);

use Mvenghaus\Magento2WidgetDirective\Data\WidgetData;
use Mvenghaus\Magento2WidgetDirective\WidgetParser;

test('can parse widgets', function () {

    $widgetParser = new WidgetParser();

    $widgets = $widgetParser->parse(<<<EOF
Lorem ipsum dolor sit amet, consetetur sadipscing elitr.
{{widget type="TestWidget\Widget" param1="foo" param2="bar"}}
Lorem ipsum dolor sit amet, consetetur sadipscing elitr.
{{widget type="TestWidget\Widget2" param1="foo2" param2="bar2"}}
Lorem ipsum dolor sit amet, consetetur sadipscing elitr.
{{widget type="TestWidget\Widget3" param1="" param2="bar3"}}
EOF
    );

    expect()
        ->and(count($widgets))->toBe(3)
        ->and($widgets[0])->toBeObject(WidgetData::class)
        ->and($widgets[0]->type)->toBe('TestWidget\\Widget')
        ->and($widgets[0]->properties)->toMatchArray([
            'param1' => 'foo',
            'param2' => 'bar'
        ])
        ->and($widgets[1])->toBeObject(WidgetData::class)
        ->and($widgets[1]->type)->toBe('TestWidget\\Widget2')
        ->and($widgets[1]->properties)->toMatchArray([
            'param1' => 'foo2',
            'param2' => 'bar2'
        ])
        ->and($widgets[2])->toBeObject(WidgetData::class)
        ->and($widgets[2]->type)->toBe('TestWidget\\Widget3')
        ->and($widgets[2]->properties)->toMatchArray([
            'param1' => '',
            'param2' => 'bar3'
        ]);


});
