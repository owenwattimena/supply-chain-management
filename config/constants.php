<?php

return [
    'order' => [
        'status' => ['draft', 'menunggu', 'pending', 'proses', 'final', 'batal'],
    ],
    'access' => [
        'menu' => [
            'master' => ['developer', 'superadmin', 'admin', 'supplier', 'supplier_pasir'],
            'master_user' => ['developer', 'superadmin', 'admin'],
            'master_satuan' => ['developer', 'superadmin', 'admin'],
            'master_bahan_baku' => ['developer', 'superadmin', 'admin', 'supplier', 'supplier_pasir'],
            'persediaan' => ['developer', 'superadmin', 'admin', 'supplier', 'supplier_pasir'],
            'persediaan_pasir' => ['developer', 'superadmin', 'admin'],
            'bahan_baku_masuk' => ['supplier', 'supplier_pasir'],
            'pengiriman_pasir' => ['supplier_pasir', 'stockpile_pasir', 'admin'],
            // 'penerimaan_pasir' => ['stockpile'],
            'produksi' => ['produksi'],
            'pemesanan_bahan_baku' => [
                'access' => ['admin', 'superadmin', 'developer', 'supplier', 'stockpile', 'manager'],
                'draft' => [
                    'tab' => ['admin', 'superadmin', 'developer', 'manager'],
                    'tombol_tambah' => ['admin', 'superadmin', 'developer'],
                ],
                'menunggu' => [
                    'tab' => ['admin', 'superadmin', 'developer', 'manager'],
                ],
                'pending' => [
                    'tab' => ['admin', 'superadmin', 'developer', 'supplier', 'stockpile', 'manager'],
                ],
                'proses' => [
                    'tab' => ['admin', 'superadmin', 'developer', 'supplier', 'stockpile', 'manager'],
                ],
                'diterima' => [
                    'tab' => ['admin', 'superadmin', 'developer', 'supplier', 'stockpile', 'manager'],
                ],
                'dibatalkan' => [
                    'tab' => ['admin', 'superadmin', 'developer', 'supplier', 'stockpile', 'manager'],
                ],
            ],
            'laporan' => [
                'produksi' => ['developer', 'superadmin', 'admin', 'manager', 'pt_lamco'],
                'penerimaan_pasir' => ['developer', 'superadmin', 'admin', 'manager', ]
            ],
        ]
    ],
    'jenis_kelamin' => [
        'laki-laki' => 'Laki-laki',
        'perempuan' => 'Perempuan'
    ],
    'agama' => [
        'islam' => 'Islam',
        'kristen' => 'Kristen',
        'katolik' => 'Katolik',
        'hindu' => 'Hindu',
        'budah' => 'Budah',
        'konghucu' => 'Konghucu',
    ],
];
