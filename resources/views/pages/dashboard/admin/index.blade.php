@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-gray-800 dark:text-white">
            Dashboard
        </h1>
        <p class="text-sm text-gray-500 dark:text-gray-400">
            Selamat datang di Admin Panel
        </p>
    </div>

    {{-- Card Kosong --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">
        <div class="rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-6">
            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">
                ADMIN DASHBOARD
            </h3>
            <p class="mt-2 text-xl font-bold text-gray-800 dark:text-white">
                —
            </p>
        </div>
    </div>
@endsection
