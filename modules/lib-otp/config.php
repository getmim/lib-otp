<?php

return [
    '__name' => 'lib-otp',
    '__version' => '0.0.2',
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
                'lib-model' => NULL
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
    ]
];
