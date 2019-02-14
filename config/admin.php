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
        ['name' => 'admin.subscription management', 'route' => 'subscriptions.index']
    ]
];
