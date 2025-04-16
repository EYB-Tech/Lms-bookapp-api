<?php
$modules = [
    'uploads' => 'r,c,u,d',
    'courses' => 'r,c,u,d',
    'lessons' => 'r,c,u,d',
    'subscriptions' => 'r,c,u,d',
    'tags' => 'r,c,u,d',
    'staffs' => 'r,c,u,d',
    'students' => 'r,c,u,d',
    'settings' => 'u',
];
$staffModules = [
    'uploads' => 'r,c,u,d',
    'lessons' => 'r,c,u,d',
    'courses' => 'r,c,u,d',
    'students' => 'r,c,u,d',
    'subscriptions' => 'r,c,u,d',
    'tags' => 'r,c,u,d',
    'settings' => 'c',
];
return [
    /**
     * Control if the seeder should create a user per role while seeding the data.
     */
    'create_users' => false,

    /**
     * Control if all the laratrust tables should be truncated before running the seeder.
     */
    'truncate_tables' => true,
    'modules' => $modules,
    'staff_modules' => $staffModules,
    'roles_structure' => [
        'super_admin' => $modules,
        'staff' => [],
    ],
    'permissions_map' => [
        'c' => 'create',
        'r' => 'read',
        'u' => 'update',
        'd' => 'delete',
    ]
];
