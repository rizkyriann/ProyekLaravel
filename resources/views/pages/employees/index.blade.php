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
                        <th class="px-5 py-3 text-center sm:px-6">
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
                                <span
                                    @click="openConfirm({{ $employee->user->id }}, false)"
                                    class="cursor-pointer inline-flex rounded-full bg-green-50 px-2 py-0.5 text-theme-xs font-medium text-green-700
                                           dark:bg-green-500/15 dark:text-green-500"
                                >
                                    Aktif
                                </span>
                            @else
                                <span
                                    @click="openConfirm({{ $employee->user->id }}, true)"
                                    class="cursor-pointer inline-flex rounded-full bg-red-50 px-2 py-0.5 text-theme-xs font-medium text-red-700
                                           dark:bg-red-500/15 dark:text-red-500"
                                >
                                    Nonaktif
                                </span>
                            @endif
                        </td>

                        <td class="px-5 py-4 sm:px-6">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('admin.employees.show', $employee) }}"
                                class="inline-flex rounded-md bg-primary px-3 py-1.5 text-xs font-medium text-gray-800 text-theme-sm dark:text-white/90">
                                    Detail
                                </a>

                                <a href="{{ route('admin.employees.edit', $employee) }}"
                                class="inline-flex rounded-md bg-primary px-3 py-1.5 text-xs font-medium text-gray-800 text-theme-sm dark:text-white/90">
                                    Edit
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
