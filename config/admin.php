<?php

return [
    'menu' => [
        ['name' => 'admin.dashboard', 'route' => 'admin.dashboard'],
        [
            'name' => 'admin.content management',
            'sub' => [
                ['name' => 'admin.categories', 'route' => 'categories.index'],
                ['name' => 'admin.publishing houses', 'route' => 'publishings.index'],
                ['name' => 'admin.authors', 'route' => 'authors.index'],
                ['name' => 'admin.journals', 'route' => 'journals.index'],
                ['name' => 'admin.releases', 'route' => 'releases.index'],
                ['name' => 'admin.articles', 'route' => 'articles.index'],
                ['name' => 'admin.news', 'route' => 'news.index']
            ]
        ],
        ['name' => 'admin.subscription management', 'route' => 'subscriptions.index'],
        [
            'name' => 'admin.orders management',
            'sub' => [
                ['name' => 'admin.paysystems', 'route' => 'paysystems.index'],
                ['name' => 'admin.physical users', 'route' => 'order_phys_users.index'],
                ['name' => 'admin.legal users', 'route' => 'order_legal_users.index'],
                ['name' => 'admin.orders', 'route' => 'orders.index']
            ]
        ],
        [
            'name' => 'admin.promocodes',
            'sub' => [
                ['name' => 'admin.promocodes management', 'route' => 'promocodes.index'],
                ['name' => 'admin.promousers management', 'route' => 'promo_userz.index'],
                ['name' => 'admin.journals by promocodes', 'route' => 'jby_promo.index']
            ]
        ],
        [
            'name' => 'admin.partnership',
            'sub' => [
                ['name' => 'admin.partners', 'route' => 'partners.index'],
                ['name' => 'admin.quotas', 'route' => 'quotas.index'],
                ['name' => 'admin.partner users', 'route' => 'partner_users.index']
            ]
        ],
        [
            'name' => 'admin.users and roles',
            'sub' => [
                ['name' => 'admin.users', 'route' => 'users.index'],
//                ['name' => 'admin.roles', 'route' => 'roles.index']
            ]
        ]
    ]
];
