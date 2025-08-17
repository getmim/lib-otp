<?php

return [
    '__name' => 'lib-otp',
    '__version' => '1.0.0',
    '__git' => 'git@github.com:getmim/lib-otp.git',
    '__license' => 'MIT',
    '__author' => [
        'name' => 'Iqbal Fauzi',
        'email' => 'iqbalfawz@gmail.com',
        'website' => 'https://iqbalfn.com/'
    ],
    '__files' => [
        'modules/lib-otp' => ['install','update','remove']
    ],
    '__dependencies' => [
        'required' => [
            [
                'lib-model' => null
            ],
            [
                'lib-formatter' => null
            ],
            [
                'lib-enum' => null
            ]
        ],
        'optional' => []
    ],
    'autoload' => [
        'classes' => [
            'LibOtp\\Model' => [
                'type' => 'file',
                'base' => 'modules/lib-otp/model'
            ],
            'LibOtp\\Library' => [
                'type' => 'file',
                'base' => 'modules/lib-otp/library'
            ]
        ],
        'files' => []
    ],
    'libEnun' => [
        'enums' => [
            'otp.status' => ['Expired', 'Active', 'Verified']
        ]
    ],
    'libFormatter' => [
        'formats' => [
            'otp' => [
                'id' => [
                    'type' => 'number'
                ],
                'identity' => [
                    'type' => 'text'
                ],
                'otp' => [
                    'type' => 'text'
                ],
                'status' => [
                    'type' => 'enum',
                    'enum' => 'otp.status',
                    'vtype' => 'int'
                ],
                'validated' => [
                    'type' => 'date'
                ],
                'expires' => [
                    'type' => 'date'
                ],
                'updated' => [
                    'type' => 'date'
                ],
                'created' => [
                    'type' => 'date'
                ]
            ]
        ]
    ]
];
