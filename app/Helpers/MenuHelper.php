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
                'title' => 'ADMIN',
                'items' => [
                    [
                        'name'  => 'Manajemen User',
                        'icon'  => 'users',
                        'path'  => '/admin/employees',
                        'roles' => ['superadmin', 'admin'],
                    ],
                    [
                        'name'  => 'Manajemen Gudang',
                        'icon'  => 'warehouse',
                        'roles' => ['superadmin', 'admin'],
                        'subItems' => [
                            [
                                'name'  => 'Daftar Handover',
                                'path'  => '/warehouse/handover',
                                'roles' => ['superadmin', 'admin'],
                            ],
                            [
                                'name'  => 'Daftar Barang',
                                'path'  => '/warehouse/items',
                                'roles' => ['superadmin'],
                            ],
                            [
                                'name'  => 'Daftar Invoice',
                                'path'  => '/warehouse/invoices',
                                'roles' => ['superadmin', 'admin'],
                            ],
                        ],
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
