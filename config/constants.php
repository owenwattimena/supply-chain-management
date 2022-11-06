<?php

return [
    'order' => [
        'status' => ['draft', 'pending', 'proses', 'final', 'batal'],
    ],
    'access' => [
        'menu' => [
            'master_user' => ['developer', 'superadmin', 'admin'],
            'persediaan' => ['developer', 'superadmin', 'admin'],
            'laporan' => ['developer', 'superadmin', 'admin'],
        ]
    ]
];