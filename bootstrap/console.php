<?php

use App\Jobs\ProductParser;

return [
    'console' => [
        'commands' => [
            'Product parser' => ProductParser::class
        ]
    ]
];