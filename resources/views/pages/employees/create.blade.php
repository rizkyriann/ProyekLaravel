@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-screen-lg p-4 md:p-6 2xl:p-10">

    {{-- HEADER --}}
    <div class="mb-6 flex items-center justify-between">
        <h2 class="text-title-md2 font-semibold text-gray-800 dark:text-white/90">
            Tambah Karyawan
        </h2>
    </div>

    <form action="{{ route('admin.employees.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="overflow-hidden rounded-xl border border-gray-200 bg-white
                    dark:border-gray-800 dark:bg-white/[0.03]">

            {{-- BODY --}}
            <div class="p-6">
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

                    {{-- Nama User --}}
                    <div>
                        <label class="mb-1 block text-theme-xs font-medium text-gray-500 dark:text-gray-400">
                            Nama User
                        </label>
                        <input type="text" name="name"
                            class="w-full rounded-md border
                                   border-gray-300 dark:border-gray-700
                                   bg-transparent dark:bg-gray-900
                                   px-4 py-2 text-sm
                                   text-gray-800 dark:text-white
                                   focus:border-primary focus:outline-none
                                   dark:focus:border-primary">
                    </div>

                    {{-- Email --}}
                    <div>
                        <label class="mb-1 block text-theme-xs font-medium text-gray-500 dark:text-gray-400">
                            Email
                        </label>
                        <input type="email" name="email"
                            class="w-full rounded-md border
                                   border-gray-300 dark:border-gray-700
                                   bg-transparent dark:bg-gray-900
                                   px-4 py-2 text-sm
                                   text-gray-800 dark:text-white
                                   focus:border-primary focus:outline-none
                                   dark:focus:border-primary">
                    </div>

                    {{-- Password --}}
                    <div>
                        <label class="mb-1 block text-theme-xs font-medium text-gray-500 dark:text-gray-400">
                            Password
                        </label>
                        <input type="password" name="password"
                            class="w-full rounded-md border
                                   border-gray-300 dark:border-gray-700
                                   bg-transparent dark:bg-gray-900
                                   px-4 py-2 text-sm
                                   text-gray-800 dark:text-white
                                   focus:border-primary focus:outline-none
                                   dark:focus:border-primary">
                    </div>

                    {{-- Role --}}
                    <div>
                        <label class="mb-1 block text-theme-xs font-medium text-gray-500 dark:text-gray-400">
                            Role
                        </label>
                        <select name="role"
                            class="w-full rounded-md border
                                   border-gray-300 dark:border-gray-700
                                   bg-transparent dark:bg-gray-900
                                   px-4 py-2 text-sm
                                   text-gray-800 dark:text-white
                                   focus:border-primary focus:outline-none
                                   dark:focus:border-primary">
                            <option value="">Pilih Role</option>
                            <option value="superadmin">Superadmin</option>
                            <option value="admin">Admin</option>
                            <option value="karyawan">Karyawan</option>
                        </select>
                    </div>

                    {{-- Nama Lengkap --}}
                    <div>
                        <label class="mb-1 block text-theme-xs font-medium text-gray-500 dark:text-gray-400">
                            Nama Lengkap
                        </label>
                        <input type="text" name="nama_lengkap"
                            class="w-full rounded-md border
                                   border-gray-300 dark:border-gray-700
                                   bg-transparent dark:bg-gray-900
                                   px-4 py-2 text-sm
                                   text-gray-800 dark:text-white
                                   focus:border-primary focus:outline-none
                                   dark:focus:border-primary">
                    </div>

                    {{-- Jabatan --}}
                    <div>
                        <label class="mb-1 block text-theme-xs font-medium text-gray-500 dark:text-gray-400">
                            Jabatan
                        </label>
                        <input type="text" name="jabatan"
                            class="w-full rounded-md border
                                   border-gray-300 dark:border-gray-700
                                   bg-transparent dark:bg-gray-900
                                   px-4 py-2 text-sm
                                   text-gray-800 dark:text-white
                                   focus:border-primary focus:outline-none
                                   dark:focus:border-primary">
                    </div>

                    {{-- Jenis Kelamin --}}
                    <div>
                        <label class="mb-1 block text-theme-xs font-medium text-gray-500 dark:text-gray-400">
                            Jenis Kelamin
                        </label>
                        <select name="jenis_kelamin"
                            class="w-full rounded-md border
                                   border-gray-300 dark:border-gray-700
                                   bg-transparent dark:bg-gray-900
                                   px-4 py-2 text-sm
                                   text-gray-800 dark:text-white
                                   focus:border-primary focus:outline-none
                                   dark:focus:border-primary">
                            <option value="">Pilih</option>
                            <option value="Laki-Laki">Laki-Laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                    </div>

                    {{-- Alamat --}}
                    <div class="md:col-span-2">
                        <label class="mb-1 block text-theme-xs font-medium text-gray-500 dark:text-gray-400">
                            Alamat
                        </label>
                        <textarea name="alamat" rows="3"
                            class="w-full rounded-md border
                                   border-gray-300 dark:border-gray-700
                                   bg-transparent dark:bg-gray-900
                                   px-4 py-2 text-sm
                                   text-gray-800 dark:text-white
                                   focus:border-primary focus:outline-none
                                   dark:focus:border-primary"></textarea>
                    </div>

                    {{-- Upload Foto --}}
                    <x-file-input
                        label="Upload Foto"
                        name="photo"
                        accept="image/*"
                    />

                    {{-- Upload KTP --}}
                    <x-file-input
                        label="Upload KTP"
                        name="ktp_document"
                        accept="image/*"
                    />

                </div>
            </div>

            {{-- FOOTER ACTION --}}
            <div class="flex justify-end gap-3 border-t border-gray-200 p-6 dark:border-gray-800">
                 <x-ui.button
                    size="h-10 w-40 px-6 text-sm"
                    variant="primary"
                    type="submit">
                     Tambah Karyawan
                 </x-ui.button>
            </div>
        </div>
    </form>
</div>
@endsection
