@extends('layouts.app')

@section('content')
<div 
    x-data="{
        confirmOpen: false,
        targetId: null,
        targetStatus: false,
        openConfirm(id, status) {
            this.targetId = id
            this.targetStatus = status
            this.confirmOpen = true
        }
    }"
    class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10"
>

    <!-- Header -->
    <div class="mb-6 flex justify-between items-center">
        <h2 class="text-title-md2 font-semibold text-gray-800 dark:text-white/90">
            Data Karyawan
        </h2>

        <a href="{{ route('admin.employees.create') }}"
           class="inline-flex items-center justify-center rounded-md bg-primary px-6 py-2.5 text-sm font-medium text-white hover:bg-primary/90">
            Tambah Karyawan
        </a>
    </div>

    <!-- Table Wrapper (SAMA PERSIS TailAdmin) -->
    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="max-w-full overflow-x-auto custom-scrollbar">
            <table class="w-full min-w-[1100px]">
                <thead>
                    <tr class="border-b border-gray-100 dark:border-gray-800">
                        <th class="px-5 py-3 text-left sm:px-6">
                            <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Nama</p>
                        </th>
                        <th class="px-5 py-3 text-left sm:px-6">
                            <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Email</p>
                        </th>
                        <th class="px-5 py-3 text-left sm:px-6">
                            <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Jabatan</p>
                        </th>
                        <th class="px-5 py-3 text-left sm:px-6">
                            <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Role</p>
                        </th>
                        <th class="px-5 py-3 text-left sm:px-6">
                            <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Status</p>
                        </th>
                        <th class="px-5 py-3 text-center sm:px-6 w-[140px]">
                            <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Aksi</p>
                        </th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($employees as $employee)
                    <tr class="border-b border-gray-100 dark:border-gray-800">
                        <td class="px-5 py-4 sm:px-6">
                            <p class="font-medium text-gray-800 text-theme-sm dark:text-white/90">
                                {{ $employee->nama_lengkap }}
                            </p>
                        </td>

                        <td class="px-5 py-4 sm:px-6">
                            <p class="text-gray-500 text-theme-sm dark:text-gray-400">
                                {{ $employee->user->email }}
                            </p>
                        </td>

                        <td class="px-5 py-4 sm:px-6">
                            <p class="text-gray-500 text-theme-sm dark:text-gray-400">
                                {{ $employee->jabatan }}
                            </p>
                        </td>

                        <td class="px-5 py-4 sm:px-6 capitalize">
                            <p class="text-gray-500 text-theme-sm dark:text-gray-400">
                                {{ $employee->user->role }}
                            </p>
                        </td>

                        <!-- Status Badge -->
                        <td class="px-5 py-4 sm:px-6">
                            @if($employee->user->status)
                                <span class="inline-flex rounded-full bg-green-50 px-2 py-0.5 text-theme-xs font-medium text-green-700
                                           dark:bg-green-500/15 dark:text-green-500">
                                    Aktif
                                </span>
                            @else
                                <span class="inline-flex rounded-full bg-red-50 px-2 py-0.5 text-theme-xs font-medium text-red-700
                                           dark:bg-red-500/15 dark:text-red-500">
                                    Nonaktif
                                </span>
                            @endif
                        </td>

                        <td class="px-5 py-4 sm:px-6">
                            <div class="flex items-center gap-3 justify-center">
                                <a href="{{ route('admin.employees.show', $employee) }}"
                                class="inline-flex items-center justify-center rounded-md bg-primary p-2
                                        text-gray-800 hover:bg-primary/90 dark:text-white/90">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                        <path fill-rule="evenodd" d="M4.5 3.75a3 3 0 0 0-3 3v10.5a3 3 0 0 0 3 3h15a3 3 0 0 0 3-3V6.75a3 3 0 0 0-3-3h-15Zm4.125 3a2.25 2.25 0 1 0 0 4.5 2.25 2.25 0 0 0 0-4.5Zm-3.873 8.703a4.126 4.126 0 0 1 7.746 0 .75.75 0 0 1-.351.92 7.47 7.47 0 0 1-3.522.877 7.47 7.47 0 0 1-3.522-.877.75.75 0 0 1-.351-.92ZM15 8.25a.75.75 0 0 0 0 1.5h3.75a.75.75 0 0 0 0-1.5H15ZM14.25 12a.75.75 0 0 1 .75-.75h3.75a.75.75 0 0 1 0 1.5H15a.75.75 0 0 1-.75-.75Zm.75 2.25a.75.75 0 0 0 0 1.5h3.75a.75.75 0 0 0 0-1.5H15Z" clip-rule="evenodd" />
                                    </svg>
                                </a>

                                <a href="{{ route('admin.employees.edit', $employee) }}"
                                class="inline-flex items-center justify-center rounded-md bg-primary p-2
                                        text-gray-800 hover:bg-primary/90 dark:text-white/90">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                         <path d="M21.731 2.269a2.625 2.625 0 0 0-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 0 0 0-3.712ZM19.513 8.199l-3.712-3.712-8.4 8.4a5.25 5.25 0 0 0-1.32 2.214l-.8 2.685a.75.75 0 0 0 .933.933l2.685-.8a5.25 5.25 0 0 0 2.214-1.32l8.4-8.4Z" />
                                         <path d="M5.25 5.25a3 3 0 0 0-3 3v10.5a3 3 0 0 0 3 3h10.5a3 3 0 0 0 3-3V13.5a.75.75 0 0 0-1.5 0v5.25a1.5 1.5 0 0 1-1.5 1.5H5.25a1.5 1.5 0 0 1-1.5-1.5V8.25a1.5 1.5 0 0 1 1.5-1.5h5.25a.75.75 0 0 0 0-1.5H5.25Z" />
                                    </svg>
                                </a>
                            
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
    </div>

    <!-- Modal Konfirmasi -->
    <div
        x-show="confirmOpen"
        x-transition
        class="fixed inset-0 z-999 flex items-center justify-center bg-black/40"
    >
        <div class="w-full max-w-md rounded-xl bg-white p-6 dark:bg-boxdark">
            <h3 class="mb-3 text-lg font-semibold text-gray-800 dark:text-white/90">
                Konfirmasi
            </h3>

            <p class="mb-6 text-gray-500 dark:text-gray-400">
                Apakah kamu yakin ingin mengubah status karyawan ini?
            </p>

            <div class="flex justify-end space-x-3">
                <button
                    @click="confirmOpen = false"
                    class="rounded-md border border-gray-300 px-4 py-2 text-sm dark:border-gray-700"
                >
                    Batal
                </button>

                <form method="POST" :action="`/admin/users/${targetId}/toggle-status`">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="status" :value="targetStatus ? 1 : 0">

                    <button
                        type="submit"
                        class="rounded-md bg-primary px-4 py-2 text-sm font-medium text-white hover:bg-primary/90"
                    >
                        Ya, Lanjutkan
                    </button>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection
