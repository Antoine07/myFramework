<?php

return [
    'tables' => [
        'users'         => __DIR__ . '/table/users.sql',
        'taxonomies'    => __DIR__ . '/table/taxonomies.sql',
        'posts'         => __DIR__ . '/table/posts.sql',
        'comments'      => __DIR__ . '/table/comments.sql',
        'taxonomy_post' => __DIR__ . '/table/taxonomy_post.sql',
    ],
    'seeds'  => [
        //'posts' => __DIR__.'/seeds/posts.sql',
    ],
    'tests'  => [
        'tables' => [
            'students' => __DIR__ . '/sql/students.sql',
        ],
        'seeds'  => [
            'students' => __DIR__ . '/seeds/students.sql',
        ]
    ]
];