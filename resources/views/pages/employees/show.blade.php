@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-screen-md p-4 md:p-6 2xl:p-10">

    {{-- HEADER --}}
    <div class="mb-6 flex items-center justify-between">
        <h2 class="text-title-md2 font-semibold text-gray-800 dark:text-white/90">
            Detail Karyawan
        </h2>

        <a href="{{ route('admin.employees.edit', $employee) }}"
           class="inline-flex h-10 items-center justify-center
                  rounded-md bg-primary px-6 text-sm font-medium
                  hover:bg-opacity-90 text-gray-800 dark:text-white/90">
            Edit
        </a>
    </div>

    {{-- CARD --}}
    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white
                shadow-default dark:border-gray-800 dark:bg-white/[0.03]">

        <div class="space-y-6 p-6">

            {{-- PROFILE --}}
            <div class="flex items-center gap-6">
                @if($employee->photo)
                    <img src="{{ asset('storage/'.$employee->photo) }}"
                         class="h-24 w-24 rounded-full object-cover ring-1 ring-gray-200 dark:ring-gray-700">
                @endif

                <div>
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white">
                        {{ $employee->nama_lengkap }}
                    </h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        {{ $employee->jabatan }}
                    </p>
                </div>
            </div>

            {{-- INFO GRID --}}
            <div class="grid grid-cols-1 gap-4 text-sm md:grid-cols-2">
                <p class="text-gray-700 dark:text-gray-300">
                    <strong>Email:</strong> {{ $employee->user->email }}
                </p>
                <p class="text-gray-700 dark:text-gray-300">
                    <strong>Role:</strong> {{ $employee->user->role }}
                </p>
                <p class="text-gray-700 dark:text-gray-300">
                    <strong>No Telp:</strong> {{ $employee->no_telp }}
                </p>
                <p class="text-gray-700 dark:text-gray-300">
                    <strong>Pendidikan:</strong> {{ $employee->pendidikan_terakhir }}
                </p>
                <p class="text-gray-700 dark:text-gray-300">
                    <strong>Jenis Kelamin:</strong> {{ $employee->jenis_kelamin }}
                </p>
            </div>

            {{-- ALAMAT --}}
            <div>
                <p class="mb-1 text-sm font-medium text-gray-700 dark:text-gray-300">
                    Alamat
                </p>
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    {{ $employee->alamat }}
                </p>
            </div>

            {{-- DOKUMEN --}}
            <div>
                <p class="mb-1 text-sm font-medium text-gray-700 dark:text-gray-300">
                    Dokumen
                </p>
                @if($employee->ktp_document)
                    <a href="{{ asset('storage/'.$employee->ktp_document) }}"
                       target="_blank"
                       class="text-title-md2 font-semibold text-gray-800 dark:text-white/90 underline">
                        Lihat Dokumen KTP
                    </a>
                @else
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        Tidak ada dokumen
                    </p>
                @endif
            </div>

        </div>

        {{-- ACTION FOOTER --}}
        <div class="flex justify-end gap-3 border-t border-gray-200 p-6 dark:border-gray-800">
            @if($employee->user->status)
                <form action="{{ route('admin.employees.deactivate', $employee) }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="inline-flex h-10 items-center justify-center
                               rounded-md bg-red-600 px-6 text-sm font-medium text-white
                               hover:bg-red-700">
                        Nonaktifkan
                    </button>
                </form>
            @else
                <form action="{{ route('admin.employees.activate', $employee) }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="inline-flex h-10 items-center justify-center
                               rounded-md bg-green-600 px-6 text-sm font-medium text-white
                               hover:bg-green-700">
                        Aktifkan
                    </button>
                </form>
            @endif
        </div>

    </div>
</div>
@endsection
