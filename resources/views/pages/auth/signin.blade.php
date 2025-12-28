@extends('layouts.fullscreen-layout')

@section('content')
<div class="relative z-1 bg-white p-6 sm:p-0 dark:bg-gray-900">
    <div class="relative flex h-screen w-full flex-col justify-center lg:flex-row dark:bg-gray-900">

        <!-- Form -->
        <div class="flex w-full flex-1 flex-col lg:w-1/2">
            <div class="mx-auto flex w-full max-w-md flex-1 flex-col justify-center">

                <div class="mb-6">
                    <h1 class="text-title-sm sm:text-title-md mb-2 font-semibold text-gray-800 dark:text-white/90">
                        Sign In
                    </h1>
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        Masukkan email dan password untuk login
                    </p>
                </div>

                {{-- ERROR MESSAGE --}}
                @if ($errors->any())
                    <div class="mb-4 rounded-lg bg-red-50 p-3 text-sm text-red-600">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="space-y-5">
                        <!-- Email -->
                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                Email
                            </label>
                            <input
                                type="email"
                                name="email"
                                value="{{ old('email') }}"
                                required
                                autofocus
                                placeholder="email@example.com"
                                class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm
                                text-gray-800 placeholder:text-gray-400 focus:border-brand-500 focus:ring-3
                                focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900
                                dark:text-white/90"
                            />
                        </div>

                        <!-- Password -->
                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                Password
                            </label>
                            <input
                                type="password"
                                name="password"
                                required
                                placeholder="••••••••"
                                class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm
                                text-gray-800 placeholder:text-gray-400 focus:border-brand-500 focus:ring-3
                                focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900
                                dark:text-white/90"
                            />
                        </div>

                        <!-- Remember -->
                        <div class="flex items-center">
                            <input
                                type="checkbox"
                                name="remember"
                                class="mr-2 rounded border-gray-300 text-brand-500 focus:ring-brand-500"
                            >
                            <span class="text-sm text-gray-700 dark:text-gray-400">
                                Keep me logged in
                            </span>
                        </div>

                        <!-- Button -->
                        <button
                            type="submit"
                            class="bg-brand-500 hover:bg-brand-600 flex w-full items-center justify-center
                            rounded-lg px-4 py-3 text-sm font-medium text-white transition"
                        >
                            Sign In
                        </button>
                    </div>
                </form>

                <div class="mt-6 text-center">
                    <p class="text-sm text-gray-700 dark:text-gray-400">
                        Hubungi admin atau superadmin jika belum memiliki akun.
                        </a>
                    </p>
                </div>

            </div>
        </div>

        <!-- Right Side -->
        <div class="bg-brand-950 relative hidden h-full w-full items-center lg:grid lg:w-1/2 dark:bg-white/5">
            <div class="flex items-center justify-center">
                <div class="max-w-xs text-center">
                    <img src="/images/logo/auth-logo.svg" class="mx-auto mb-4" alt="Logo">
                    <p class="text-gray-400 dark:text-white/60">
                        Sistem Admin Proyek Laravel
                    </p>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
