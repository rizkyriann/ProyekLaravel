@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-screen-lg p-4 md:p-6 2xl:p-10">

    <div class="mb-6 flex justify-between items-center">
        <h2 class="text-title-md2 font-semibold text-gray-800 dark:text-white/90">
            Tambah Karyawan
        </h2>
    </div>
    
    <form action="{{ route('admin.employees.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="overflow-hidden rounded-xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">

            <div class="p-6">
                <!-- GRID 2 KOLOM -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    {{-- Nama User --}}
                    <div>
                        <label class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Nama User</label>
                        <input type="text" name="name"
                               class="w-full rounded border border-stroke bg-transparent px-4 py-2 focus:border-primary focus:outline-none dark:border-strokedark">
                    </div>

                    {{-- Email --}}
                    <div>
                        <label class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Email</label>
                        <input type="email" name="email"
                               class="w-full rounded border border-stroke px-4 py-2 dark:border-strokedark">
                    </div>

                    {{-- Password --}}
                    <div>
                        <label class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Password</label>
                        <input type="password" name="password"
                               class="w-full rounded border border-stroke px-4 py-2 dark:border-strokedark">
                    </div>

                    {{-- Role --}}
                    <div>
                        <label class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Role</label>
                        <select name="role"
                                class="w-full rounded border border-stroke px-4 py-2 dark:border-strokedark">
                            <option value="">Pilih Role</option>
                            <option value="superadmin">Superadmin</option>
                            <option value="admin">Admin</option>
                            <option value="karyawan">Karyawan</option>
                        </select>
                    </div>

                    {{-- Nama Lengkap --}}
                    <div>
                        <label class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Nama Lengkap</label>
                        <input type="text" name="nama_lengkap"
                               class="w-full rounded border border-stroke px-4 py-2 dark:border-strokedark">
                    </div>

                    {{-- Jabatan --}}
                    <div>
                        <label class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Jabatan</label>
                        <input type="text" name="jabatan"
                               class="w-full rounded border border-stroke px-4 py-2 dark:border-strokedark">
                    </div>

                    {{-- Jenis Kelamin --}}
                    <div>
                        <label class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Jenis Kelamin</label>
                        <select name="jenis_kelamin"
                                class="w-full rounded border border-stroke px-4 py-2 dark:border-strokedark">
                            <option value="">Pilih</option>
                            <option value="Laki-Laki">Laki-Laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                    </div>

                    {{-- Alamat (FULL WIDTH) --}}
                    <div class="md:col-span-2">
                        <label class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Alamat</label>
                        <textarea name="alamat" rows="3"
                                  class="w-full rounded border border-stroke px-4 py-2 dark:border-strokedark"></textarea>
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

                     <script>
                        function handleFileChange(event) {
                        console.log(event.target.files[0]);
                        }
                    </script>

                </div>
            </div>

            {{-- ACTION --}}
            <div class="flex justify-end gap-3 border-t border-stroke p-6 dark:border-strokedark">
                <a href="{{ url()->previous() }}"
                   class="rounded-md border border-stroke px-6 py-2 text-sm font-medium hover:bg-gray-100 dark:hover:bg-boxdark-2">
                    Batal
                </a>

                <button type="submit"
                        class="rounded-md bg-primary px-6 py-2 text-sm font-medium text-white hover:bg-opacity-90">
                    Simpan
                </button>
            </div>

        </div>
    </form>
</div>
@endsection
