<?php
return
    [
        'mode'                  => 'utf-8',
        'format'                => 'A4',
        'author'                => '',
        'subject'               => '',
        'keywords'              => '',
        'creator'               => 'Laravel Pdf',
        'display_mode'          => 'fullpage',
        'isRemoteEnabled' => true,
        'tempDir'               => base_path('temp/'),
        'font_path' => base_path('public/assets/pdf/fonts/'),
        'font_data' => [
            'xbriyaz' => [
                'R'  => 'XB Riyaz.ttf',  // Regular
                'useOTL' => 0xFF,
                'useKashida' => 75,
            ],
            'roboto' => [
                'R'  => 'NotoNaskhArabic.ttf',    // regular font
                'useOTL' => 0xFF,    // required for complicated langs like Persian, Arabic and Chinese
                'useKashida' => 75,  // required for complicated langs like Persian, Arabic and Chinese
            ],
            'roboto' => [
                'R'  => 'Roboto-Regular.ttf',    // regular font
                'useOTL' => 0xFF,    // required for complicated langs like Persian, Arabic and Chinese
                'useKashida' => 75,  // required for complicated langs like Persian, Arabic and Chinese
            ],
            'hindsiliguri' => [
                'R'  => 'HindSiliguri-Regular.ttf',    // regular font
                'useOTL' => 0xFF,    // required for complicated langs like Persian, Arabic and Chinese
                'useKashida' => 75,  // required for complicated langs like Persian, Arabic and Chinese
            ],
            'arnamu' => [
                'R'  => 'arnamu.ttf',    // regular font
                'useOTL' => 0xFF,    // required for complicated langs like Persian, Arabic and Chinese
                'useKashida' => 75,  // required for complicated langs like Persian, Arabic and Chinese
            ],
            'varelaround' => [
                'R'  => 'VarelaRound-Regular.ttf',    // regular font
                'useOTL' => 0xFF,    // required for complicated langs like Persian, Arabic and Chinese
                'useKashida' => 75,  // required for complicated langs like Persian, Arabic and Chinese
            ],
            'hanuman' => [
                'R'  => 'Hanuman-Regular.ttf',    // regular font
                'useOTL' => 0xFF,    // required for complicated langs like Persian, Arabic and Chinese
                'useKashida' => 75,  // required for complicated langs like Persian, Arabic and Chinese
            ],
            'kanit' => [
                'R'  => 'Kanit-Regular.ttf',    // regular font
            ],
            'yahei' => [
                'R'  => 'chinese-msyh.ttf',    // regular font
            ],
            'pyidaungsu' => [
                'R'  => 'Pyidaungsu.ttf',    // regular font
            ],
            'zawgyi-one' => [
                'R'  => 'Zawgyi-One.ttf',    // regular font
            ]
        ]
    ];
