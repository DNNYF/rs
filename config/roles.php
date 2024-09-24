<?php

return [
    'admin' => [
        'sidebar' => 'layouts.navbars.admin.sidebar',
        'nav' => 'layouts.navbars.admin.nav',
        'footer' => '',
        'special_routes' => ['dashboard', 'settings'], 
        'extra_components' => [
            
        ],
    ],
    'operator' => [
        'sidebar' => 'operator.sidebar',
        'nav' => 'operator.nav',
        'footer' => 'operator.footer',
        'special_routes' => ['operator-dashboard'],
        'extra_components' => [
           
        ],
    ],
    'default' => [
        'sidebar' => 'guest.sidebar',
        'nav' => 'guest.nav',
        'footer' => 'guest.footer',
        'special_routes' => [],
        'extra_components' => [],
    ],
];
