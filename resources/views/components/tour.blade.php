@props(['element', 'steps'])

@php
$options = json_encode([
    'nextText' => __('Next'),
    'backText' => __('Back'),
    'closeText' => __('Close'),
    'steps' => $steps,
    'opts' => [
        'useModalOverlay' => true,
        'defaultStepOptions' => [
            'arrow' => true,
            'cancelIcon' => [
                'enabled' => true,
            ],
            'popperOptions' => [
                'modifiers' => [
                    [
                        'name' => 'offset',
                        'options' => ['offset' => [0, 16]],
                    ],
                    [
                        'name' => 'preventOverflow',
                        'options' => [
                            'altAxis' => true,
                            'padding' => 8,
                        ],
                    ],
                ],
            ],
        ],
    ],
]);
@endphp

<{{ $element }} {{ $attributes->merge([
     'x-data' => "tour($options)",
 ]) }}>
    {{ $slot }}
    </{{ $element }}>
