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
                        'path'  => '/users',
                        'roles' => ['superadmin'],
                    ],
                    [
                        'name'  => 'Gudang',
                        'icon'  => 'warehouse',
                        'roles' => ['superadmin', 'admin'],
                        'subItems' => [
                            [
                                'name'  => 'Barang',
                                'path'  => '/gudang/barang',
                                'roles' => ['superadmin', 'admin'],
                            ],
                            [
                                'name'  => 'Kategori',
                                'path'  => '/gudang/kategori',
                                'roles' => ['superadmin'],
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
                        'new'   => true,
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
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        d="M3 12l2-2 7-7 7 7 2 2v8a1 1 0 01-1 1h-6v-6h-4v6H4a1 1 0 01-1-1v-8z"/>
                </svg>
            ',

            'users' => '
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        d="M17 20h5v-2a4 4 0 00-4-4M9 20H4v-2a4 4 0 014-4m6-4a4 4 0 100-8 4 4 0 000 8zm6 4a4 4 0 100-8 4 4 0 000 8z"/>
                </svg>
            ',

            'warehouse' => '
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        d="M3 9l9-6 9 6v11a1 1 0 01-1 1h-5v-6H9v6H4a1 1 0 01-1-1V9z"/>
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
