<?php

return [
    'LibOtp\\Model\\Otp' => [
        'fields' => [
            'id' => [
                'type' => 'INT',
                'attrs' => [
                    'unsigned' => TRUE,
                    'primary_key' => TRUE,
                    'auto_increment' => TRUE
                ],
                'index' => 1000
            ],
            'identity' => [
                'type' => 'VARCHAR',
                'length' => 50,
                'attrs' => [
                    'null' => FALSE
                ],
                'index' => 2000
            ],
            'otp' => [
                'type' => 'VARCHAR',
                'length' => 50,
                'attrs' => [
                    'null' => false,
                    'unique' => true 
                ],
                'index' => 3000
            ],
            'status' => [
                'comment' => '0 Expired, 1 Active, 2 Verified',
                'type' => 'TINYINT',
                'attrs' => [
                    'null' => false,
                    'unsigned' => true,
                    'default' => 1
                ],
                'index' => 4000
            ],
            'validated' => [
                'type' => 'DATETIME',
                'attrs' => [
                    'null' => true 
                ],
                'index' => 5000
            ],
            'expires' => [
                'type' => 'DATETIME',
                'attrs' => [
                    'null' => false 
                ],
                'index' => 6000
            ],
            'updated' => [
                'type' => 'TIMESTAMP',
                'attrs' => [
                    'default' => 'CURRENT_TIMESTAMP',
                    'update' => 'CURRENT_TIMESTAMP'
                ],
                'index' => 10000
            ],
            'created' => [
                'type' => 'TIMESTAMP',
                'attrs' => [
                    'default' => 'CURRENT_TIMESTAMP'
                ],
                'index' => 11000
            ]
        ]
    ]
];
