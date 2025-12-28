@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-screen-md p-4 md:p-6 2xl:p-10">

    <div class="mb-6 flex justify-between items-center">
        <h2 class="text-title-md2 font-semibold text-black dark:text-white">
            Detail Karyawan
        </h2>

        <a href="{{ route('admin.employees.edit', $employee) }}"
           class="rounded-md bg-primary px-6 py-2 text-sm font-medium text-white hover:bg-opacity-90">
            Edit
        </a>
    </div>

    <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
        <div class="p-6 space-y-6">

            <div class="flex items-center gap-6">
                @if($employee->photo)
                    <img src="{{ asset('storage/'.$employee->photo) }}"
                         class="h-24 w-24 rounded-full object-cover">
                @endif

                <div>
                    <h3 class="text-lg font-semibold text-black dark:text-white">
                        {{ $employee->nama_lengkap }}
                    </h3>
                    <p class="text-sm text-gray-500">
                        {{ $employee->jabatan }}
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-4 md:grid-cols-2 text-sm">
                <p><strong>Email:</strong> {{ $employee->user->email }}</p>
                <p><strong>Role:</strong> {{ $employee->user->role }}</p>
                <p><strong>No Telp:</strong> {{ $employee->no_telp }}</p>
                <p><strong>Pendidikan:</strong> {{ $employee->pendidikan_terakhir }}</p>
                <p><strong>Jenis Kelamin:</strong> {{ $employee->jenis_kelamin }}</p>
            </div>

            <div>
                <p class="text-sm"><strong>Alamat:</strong></p>
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    {{ $employee->alamat }}
                </p>
            </div>

            <div>
                <strong class="text-sm">Dokumen:</strong><br>
                @if($employee->ktp_document)
                    <a href="{{ asset('storage/'.$employee->ktp_document) }}"
                       target="_blank"
                       class="text-primary underline text-sm">
                        Lihat Dokumen KTP
                    </a>
                @endif
            </div>

        </div>

        <!-- ACTIVATE / DEACTIVATE -->
        <div class="flex justify-end gap-3 border-t border-stroke p-6 dark:border-strokedark">
            @if($employee->user->status)
                <form action="{{ route('admin.employees.deactivate', $employee) }}" method="POST">
                    @csrf
                    <button class="rounded-md bg-danger px-6 py-2 text-sm font-medium text-white">
                        Nonaktifkan
                    </button>
                </form>
            @else
                <form action="{{ route('admin.employees.activate', $employee) }}" method="POST">
                    @csrf
                    <button class="rounded-md bg-success px-6 py-2 text-sm font-medium text-white">
                        Aktifkan
                    </button>
                </form>
            @endif
        </div>
    </div>
</div>
@endsection
