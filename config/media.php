<?php
return [
    'product_file' => 'product_files/',
    'slider_image_path' => 'sliders/',
    'settings_path' => 'settings/',
    'image' => [
        'path' => 'media/',
        'dimensions' => [
            'l' => ['w'=>0, 'h'=> 700, 'resize' => ''],
            'm' => ['w'=>400, 'h'=> 300, 'resize' => 'fit'],
            'product_image' => ['w'=>175, 'h'=> 172, 'resize' => ''],
            'product_main_image' => ['w'=>473, 'h'=> '', 'resize' => 'aspect_ratio'],
            'category_preview' => ['w'=>271, 'h'=> 235, 'resize' => ''],
            'cart_item_image' => ['w'=>127, 'h'=> 127, 'resize' => ''],
            'category_icon_image' => ['w'=>46, 'h'=> 46, 'resize' => ''],
            'related_product_image' => ['w'=>173, 'h'=> 207, 'resize' => ''],
            'product_slider_image' => ['w'=>135, 'h'=> 135, 'resize' => 'fit'],
            'preview' => ['w'=>150, 'h'=> 150, 'resize' => 'fit'],
        ]
    ],
];
