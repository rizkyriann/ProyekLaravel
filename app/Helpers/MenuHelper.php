<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Auth;

class MenuHelper
{
    /**
     * ENTRY POINT
     */
    public static function getMenuGroups(): array
    {
        $role = Auth::user()?->role;

        return self::filterByRole(self::menuDefinition(), $role);
    }

    /**
     * =========================
     * Daftar menu dan submenu beserta akses role
     * =========================
     */
    private static function menuDefinition(): array
    {
        return [

            [
                'title' => 'MAIN',
                'items' => [
                    [
                        'name'  => 'Dashboard',
                        'icon'  => 'dashboard',
                        'path'  => '/dashboard',
                        'roles' => ['superadmin', 'admin', 'karyawan'],
                    ],
                ],
            ],

            [
                'title' => 'WAREHOUSE',
                'items' => [
                    [
                        'name' => 'Handover',
                        'icon' => 'handover',
                        'path' => '/warehouse/handovers',
                        'roles' => ['superadmin', 'admin']
                    ],
                    [
                        'name' => 'Stok Gudang',
                        'icon' => 'warehouse',
                        'path' => '/warehouse/items',
                        'roles' => ['superadmin', 'admin']
                    ],
                    [
                        'name' => 'Invoice',
                        'icon' => 'invoice',
                        'path' => '/warehouse/invoices',
                        'roles' => ['superadmin', 'admin']
                    ]
                ]
            ],

            [
                'title' => 'ADMIN',
                'items' => [
                    [
                        'name'  => 'Manajemen User',
                        'icon'  => 'users',
                        'path'  => '/admin/employees',
                        'roles' => ['superadmin', 'admin'],
                    ],
                ],
            ],

            [
                'title' => 'PROYEK',
                'items' => [
                    [
                        'name'  => 'Proyek',
                        'icon'  => 'project',
                        'path'  => '/proyek',
                        'roles' => ['superadmin', 'admin'],
                    ],
                    [
                        'name'  => 'Laporan',
                        'icon'  => 'report',
                        'path'  => '/laporan',
                        'roles' => ['superadmin'],
                    ],
                ],
            ],
        ];
    }

    //FUNGSI FILTER MENU BERDASARKAN ROLE
    private static function filterByRole(array $groups, ?string $role): array
    {
        return array_values(array_filter(array_map(function ($group) use ($role) {

            $group['items'] = array_values(array_filter(array_map(function ($item) use ($role) {

                // Filter submenu
                if (isset($item['subItems'])) {
                    $item['subItems'] = array_values(array_filter(
                        $item['subItems'],
                        fn ($sub) => self::hasAccess($sub, $role)
                    ));

                    if (empty($item['subItems'])) {
                        return null;
                    }
                }

                return self::hasAccess($item, $role) ? $item : null;

            }, $group['items'])));

            return empty($group['items']) ? null : $group;

        }, $groups)));
    }

    private static function hasAccess(array $item, ?string $role): bool
    {
        if (!isset($item['roles'])) {
            return true;
        }

        return $role && in_array($role, $item['roles']);
    }

    //svg library

    public static function getIconSvg(string $iconName): string
    {
        $icons = [

            'dashboard' => '
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                    <path d="M11.47 3.841a.75.75 0 0 1 1.06 0l8.69 8.69a.75.75 0 1 0 1.06-1.061l-8.689-8.69a2.25 2.25 0 0 0-3.182 0l-8.69 8.69a.75.75 0 1 0 1.061 1.06l8.69-8.689Z" />
                    <path d="m12 5.432 8.159 8.159c.03.03.06.058.091.086v6.198c0 1.035-.84 1.875-1.875 1.875H15a.75.75 0 0 1-.75-.75v-4.5a.75.75 0 0 0-.75-.75h-3a.75.75 0 0 0-.75.75V21a.75.75 0 0 1-.75.75H5.625a1.875 1.875 0 0 1-1.875-1.875v-6.198a2.29 2.29 0 0 0 .091-.086L12 5.432Z" />
                </svg>

            ',

            'users' => '
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                    <path fill-rule="evenodd" d="M18.685 19.097A9.723 9.723 0 0 0 21.75 12c0-5.385-4.365-9.75-9.75-9.75S2.25 6.615 2.25 12a9.723 9.723 0 0 0 3.065 7.097A9.716 9.716 0 0 0 12 21.75a9.716 9.716 0 0 0 6.685-2.653Zm-12.54-1.285A7.486 7.486 0 0 1 12 15a7.486 7.486 0 0 1 5.855 2.812A8.224 8.224 0 0 1 12 20.25a8.224 8.224 0 0 1-5.855-2.438ZM15.75 9a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z" clip-rule="evenodd" />
                </svg>
            ',

            'warehouse' => '
                <svg  xmlns="http://www.w3.org/2000/svg" width="24" height="24"  
                    fill="currentColor" viewBox="0 0 24 24" >
                    <path d="m21.55,8.17L12.55,2.17c-.34-.22-.77-.22-1.11,0L2.45,8.17c-.28.19-.45.5-.45.83v11c0,1.1.9,2,2,2h16c1.1,0,2-.9,2-2v-11c0-.33-.17-.65-.45-.83Zm-5.55,7.83h-8v-2h8v2Zm-8,4v-2h8v2h-8Zm10,0v-6c0-1.1-.9-2-2-2h-8c-1.1,0-2,.9-2,2v6h-2v-10.46l8-5.33,8,5.33v10.46s-2,0-2,0Z"></path>
                </svg>
            ',

            'project' => '
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        d="M9 12h6m-6 4h6M5 20h14a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v14a1 1 0 001 1z"/>
                </svg>
            ',

            'report' => '
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        d="M9 17v-2a4 4 0 014-4h4M7 7h10M7 11h10"/>
                </svg>
            ',

            'handover' => '
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                    <path fill-rule="evenodd" d="M7.502 6h7.128A3.375 3.375 0 0 1 18 9.375v9.375a3 3 0 0 0 3-3V6.108c0-1.505-1.125-2.811-2.664-2.94a48.972 48.972 0 0 0-.673-.05A3 3 0 0 0 15 1.5h-1.5a3 3 0 0 0-2.663 1.618c-.225.015-.45.032-.673.05C8.662 3.295 7.554 4.542 7.502 6ZM13.5 3A1.5 1.5 0 0 0 12 4.5h4.5A1.5 1.5 0 0 0 15 3h-1.5Z" clip-rule="evenodd" />
                    <path fill-rule="evenodd" d="M3 9.375C3 8.339 3.84 7.5 4.875 7.5h9.75c1.036 0 1.875.84 1.875 1.875v11.25c0 1.035-.84 1.875-1.875 1.875h-9.75A1.875 1.875 0 0 1 3 20.625V9.375ZM6 12a.75.75 0 0 1 .75-.75h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75H6.75a.75.75 0 0 1-.75-.75V12Zm2.25 0a.75.75 0 0 1 .75-.75h3.75a.75.75 0 0 1 0 1.5H9a.75.75 0 0 1-.75-.75ZM6 15a.75.75 0 0 1 .75-.75h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75H6.75a.75.75 0 0 1-.75-.75V15Zm2.25 0a.75.75 0 0 1 .75-.75h3.75a.75.75 0 0 1 0 1.5H9a.75.75 0 0 1-.75-.75ZM6 18a.75.75 0 0 1 .75-.75h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75H6.75a.75.75 0 0 1-.75-.75V18Zm2.25 0a.75.75 0 0 1 .75-.75h3.75a.75.75 0 0 1 0 1.5H9a.75.75 0 0 1-.75-.75Z" clip-rule="evenodd" />
                </svg>
            ',

            'invoice' => '
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                    <path fill-rule="evenodd" d="M3.75 3.375c0-1.036.84-1.875 1.875-1.875H9a3.75 3.75 0 0 1 3.75 3.75v1.875c0 1.036.84 1.875 1.875 1.875H16.5a3.75 3.75 0 0 1 3.75 3.75v7.875c0 1.035-.84 1.875-1.875 1.875H5.625a1.875 1.875 0 0 1-1.875-1.875V3.375Zm10.5 1.875a5.23 5.23 0 0 0-1.279-3.434 9.768 9.768 0 0 1 6.963 6.963A5.23 5.23 0 0 0 16.5 7.5h-1.875a.375.375 0 0 1-.375-.375V5.25ZM12 10.5a.75.75 0 0 1 .75.75v.028a9.727 9.727 0 0 1 1.687.28.75.75 0 1 1-.374 1.452 8.207 8.207 0 0 0-1.313-.226v1.68l.969.332c.67.23 1.281.85 1.281 1.704 0 .158-.007.314-.02.468-.083.931-.83 1.582-1.669 1.695a9.776 9.776 0 0 1-.561.059v.028a.75.75 0 0 1-1.5 0v-.029a9.724 9.724 0 0 1-1.687-.278.75.75 0 0 1 .374-1.453c.425.11.864.186 1.313.226v-1.68l-.968-.332C9.612 14.974 9 14.354 9 13.5c0-.158.007-.314.02-.468.083-.931.831-1.582 1.67-1.694.185-.025.372-.045.56-.06v-.028a.75.75 0 0 1 .75-.75Zm-1.11 2.324c.119-.016.239-.03.36-.04v1.166l-.482-.165c-.208-.072-.268-.211-.268-.285 0-.113.005-.225.015-.336.013-.146.14-.309.374-.34Zm1.86 4.392V16.05l.482.165c.208.072.268.211.268.285 0 .113-.005.225-.015.336-.012.146-.14.309-.374.34-.12.016-.24.03-.361.04Z" clip-rule="evenodd" />
                </svg>
            ',

        ];

        return $icons[$iconName] ?? self::defaultIcon();
    }

    private static function defaultIcon(): string
    {
        return '
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="10" stroke-width="2"/>
            </svg>
        ';
    }
}
