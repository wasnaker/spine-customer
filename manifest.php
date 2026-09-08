<?php

declare(strict_types=1);

/**
 * MANIFEST modul Customer.
 *
 * 2 entity lokal: Customer, Branch. NPWP (Vat) dipakai via module
 * spine-vat — dependensi via composer require wasnaker/spine-vat.
 *
 * @return array{menu: list<array{slug: string, label: string, icon: string, href: string, position: int, permission?: string}>, widgets: list<array{id: string, area: string, title: string, api: string}>, detail_tabs: list<array{slug: string, label: string, icon: string, api: string, position: int, permission?: string}>, rbac: array{permissions: list<string>, roles: list<array{name: string, label?: string, permissions: list<string>}>, grants: array<string, list<string>>}}
 */
return [
    'menu' => [
        [
            'slug'       => 'customers',
            'label'      => 'Customers',
            'icon'       => '👥',
            'href'       => '/customers',
            'position'   => 30,
            // Platform (customer:view) ATAU surveyor dgn koneksi (view-connected).
            'permission' => 'customer:view|customer:view-connected',
        ],
    ],

    'widgets' => [
        [
            'id'    => 'customers-items',
            'area'  => 'right-4',
            'title' => 'Customers',
            'api'   => '/api/v1/customers',
        ],
    ],

    'detail_tabs' => [
        [
            'slug'       => 'overview',
            'label'      => 'Overview',
            'icon'       => '👁️',
            'api'        => '/api/v1/customers/{id}',
            'position'   => 10,
            'permission' => 'customer:view|customer:view-connected',
        ],
        [
            'slug'       => 'branches',
            'label'      => 'Branches',
            'icon'       => '🏢',
            'api'        => '/api/v1/customers/{id}/branches',
            'position'   => 20,
            'permission' => 'branch:view|customer:view-connected',
        ],
        [
            'slug'       => 'pengawas',
            'label'      => 'Pengawas',
            'icon'       => '🛡️',
            'api'        => '/api/v1/customers/{id}/pengawas',
            'position'   => 25,
            'permission' => 'pengawas:view|customer:view|customer:view-connected',
        ],
        [
            'slug'       => 'staffs',
            'label'      => 'Staff',
            'icon'       => '👥',
            'api'        => '/api/v1/customers/{id}/staffs',
            'position'   => 26,
            'permission' => 'customer:view|customer:view-connected',
        ],
        [
            'slug'       => 'activity',
            'label'      => 'Activity',
            'icon'       => '🕐',
            'api'        => '/api/v1/customers/{id}/activity-logs',
            'position'   => 30,
            'permission' => 'customer:view|customer:view-connected',
        ],
    ],

    'settings' => [
        [
            'slug'     => 'customer',
            'label'    => 'Customer',
            'icon'     => '👥',
            'position' => 50,
            'fields'   => [
                [
                    'key'     => 'customer_start_number',
                    'label'   => 'Start Number',
                    'type'    => 'number',
                    'default' => '20721',
                ],
                [
                    'key'     => 'customer_code_length',
                    'label'   => 'Code Length',
                    'type'    => 'number',
                    'default' => '4',
                ],
                [
                    'key'     => 'customer_user_start_number',
                    'label'   => 'User Start Number',
                    'type'    => 'number',
                    'default' => '10249',
                ],
            ],
        ],
    ],

    'rbac' => [
        'permissions' => [
            'customer:view', 'customer:create', 'customer:edit', 'customer:delete',
            'customer:view-connected',
            'branch:view',   'branch:create',   'branch:edit',   'branch:delete',
        ],
        'roles' => [
            // Role BASE semua user entity customer: TANPA customer:view (menu
            // Customers di-block; data company via Profile /user/company).
            // surveyor:view-connected = menu Surveyors utk rekan terhubung.
            ['name' => 'customer',              'label' => 'Customer',
             'permissions' => ['connection:view', 'connection:create', 'surveyor:view-connected', 'pengawas:view']],
            ['name' => 'customer-branch-admin', 'label' => 'Customer Branch Admin',
             'permissions' => ['connection:view', 'connection:create', 'connection:approve', 'connection:cancel',
                'surveyor:view-connected', 'pengawas:view']],
            ['name' => 'customer-admin',        'label' => 'Customer Admin',
             'permissions' => ['connection:view', 'connection:create', 'connection:approve', 'connection:cancel',
                'surveyor:view-connected', 'pengawas:view']],
        ],
        'grants' => [
            'staff' => ['customer:view', 'branch:view'],
        ],
    ],
];
