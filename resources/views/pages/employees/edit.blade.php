@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-screen-md p-4 md:p-6 2xl:p-10">

    {{-- HEADER --}}
    <h2 class="mb-6 text-title-md2 font-semibold text-gray-800 dark:text-white/90">
        Edit Karyawan
    </h2>

    <form action="{{ route('admin.employees.update', $employee) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="overflow-hidden rounded-xl border border-gray-200 bg-white
                    shadow-default dark:border-gray-800 dark:bg-white/[0.03]">

            <div class="space-y-6 p-6">

                {{-- USER --}}
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <div>
                        <label class="mb-1 block text-theme-xs font-medium text-gray-500 dark:text-gray-400">
                            Nama User
                        </label>
                        <input type="text" name="name" value="{{ $employee->user->name }}"
                            class="w-full rounded-md border
                                   border-gray-300 dark:border-gray-700
                                   bg-transparent dark:bg-gray-900
                                   px-4 py-2 text-sm
                                   text-gray-800 dark:text-white
                                   focus:border-primary focus:outline-none
                                   dark:focus:border-primary">
                    </div>

                    <div>
                        <label class="mb-1 block text-theme-xs font-medium text-gray-500 dark:text-gray-400">
                            Email
                        </label>
                        <input type="email" name="email" value="{{ $employee->user->email }}"
                            class="w-full rounded-md border
                                   border-gray-300 dark:border-gray-700
                                   bg-transparent dark:bg-gray-900
                                   px-4 py-2 text-sm
                                   text-gray-800 dark:text-white
                                   focus:border-primary focus:outline-none
                                   dark:focus:border-primary">
                    </div>

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
                            <option value="superadmin" @selected($employee->user->role=='superadmin')>Superadmin</option>
                            <option value="admin" @selected($employee->user->role=='admin')>Admin</option>
                            <option value="karyawan" @selected($employee->user->role=='karyawan')>Karyawan</option>
                        </select>
                    </div>

                    <div>
                        <label class="mb-1 block text-theme-xs font-medium text-gray-500 dark:text-gray-400">
                            Status Akun
                        </label>
                        <select name="status"
                            class="w-full rounded-md border
                                   border-gray-300 dark:border-gray-700
                                   bg-transparent dark:bg-gray-900
                                   px-4 py-2 text-sm
                                   text-gray-800 dark:text-white
                                   focus:border-primary focus:outline-none
                                   dark:focus:border-primary">
                            <option value="1" @selected($employee->user->status)>Aktif</option>
                            <option value="0" @selected(!$employee->user->status)>Nonaktif</option>
                        </select>
                    </div>
                </div>

                <hr class="border-gray-200 dark:border-gray-800">

                {{-- EMPLOYEE --}}
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <div>
                        <label class="mb-1 block text-theme-xs font-medium text-gray-500 dark:text-gray-400">
                            Nama Lengkap
                        </label>
                        <input type="text" name="nama_lengkap" value="{{ $employee->nama_lengkap }}"
                            class="w-full rounded-md border
                                   border-gray-300 dark:border-gray-700
                                   bg-transparent dark:bg-gray-900
                                   px-4 py-2 text-sm
                                   text-gray-800 dark:text-white
                                   focus:border-primary focus:outline-none
                                   dark:focus:border-primary">
                    </div>

                    <div>
                        <label class="mb-1 block text-theme-xs font-medium text-gray-500 dark:text-gray-400">
                            Jabatan
                        </label>
                        <input type="text" name="jabatan" value="{{ $employee->jabatan }}"
                            class="w-full rounded-md border
                                   border-gray-300 dark:border-gray-700
                                   bg-transparent dark:bg-gray-900
                                   px-4 py-2 text-sm
                                   text-gray-800 dark:text-white
                                   focus:border-primary focus:outline-none
                                   dark:focus:border-primary">
                    </div>

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
                            <option value="Laki-Laki" @selected($employee->jenis_kelamin=='Laki-Laki')>Laki-Laki</option>
                            <option value="Perempuan" @selected($employee->jenis_kelamin=='Perempuan')>Perempuan</option>
                        </select>
                    </div>

                    <div>
                        <label class="mb-1 block text-theme-xs font-medium text-gray-500 dark:text-gray-400">
                            No Telp
                        </label>
                        <input type="text" name="no_telp" value="{{ $employee->no_telp }}"
                            class="w-full rounded-md border
                                   border-gray-300 dark:border-gray-700
                                   bg-transparent dark:bg-gray-900
                                   px-4 py-2 text-sm
                                   text-gray-800 dark:text-white
                                   focus:border-primary focus:outline-none
                                   dark:focus:border-primary">
                    </div>

                    <div>
                        <label class="mb-1 block text-theme-xs font-medium text-gray-500 dark:text-gray-400">
                            Pendidikan Terakhir
                        </label>
                        <input type="text" name="pendidikan_terakhir" value="{{ $employee->pendidikan_terakhir }}"
                            class="w-full rounded-md border
                                   border-gray-300 dark:border-gray-700
                                   bg-transparent dark:bg-gray-900
                                   px-4 py-2 text-sm
                                   text-gray-800 dark:text-white
                                   focus:border-primary focus:outline-none
                                   dark:focus:border-primary">
                    </div>
                </div>

                {{-- ALAMAT --}}
                <div>
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
                               dark:focus:border-primary">{{ $employee->alamat }}</textarea>
                </div>

                {{-- FILE --}}
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <div>
                        <label class="mb-1 block text-theme-xs font-medium text-gray-500 dark:text-gray-400">
                            Foto
                        </label>
                        @if($employee->photo)
                            <img src="{{ asset('storage/'.$employee->photo) }}"
                                 class="mb-2 h-24 rounded-md object-cover ring-1 ring-gray-200 dark:ring-gray-700">
                        @endif
                        <input type="file" name="photo"
                               class="w-full text-sm text-gray-700 dark:text-gray-300">
                    </div>

                    <div>
                        <label class="mb-1 block text-theme-xs font-medium text-gray-500 dark:text-gray-400">
                            Dokumen KTP
                        </label>
                        @if($employee->ktp_document)
                            <a href="{{ asset('storage/'.$employee->ktp_document) }}"
                               target="_blank"
                               class="mb-2 inline-block text-sm font-medium text-primary underline dark:text-white">
                                Lihat Dokumen
                            </a>
                        @endif
                        <input type="file" name="ktp_document"
                               class="w-full text-sm text-gray-700 dark:text-gray-300">
                    </div>
                </div>

            </div>

            {{-- ACTION --}}
            <div class="flex justify-end gap-3 border-t border-gray-200 p-6 dark:border-gray-800">
                <a href="{{ route('admin.employees.index') }}"
                   class="inline-flex h-10 items-center justify-center
                          rounded-md border border-gray-300 dark:border-gray-700
                          px-6 text-sm font-medium
                          text-gray-700 dark:text-white
                          hover:bg-gray-100 dark:hover:bg-gray-800">
                    Kembali
                </a>

                <x-ui.button
                    class="h-10 px-6 text-sm font-medium"
                    variant="primary"
                    type="submit">
                    Simpan
                </x-ui.button>
            </div>

        </div>
    </form>
</div>
@endsection
