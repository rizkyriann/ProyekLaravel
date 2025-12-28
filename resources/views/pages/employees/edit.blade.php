@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-screen-md p-4 md:p-6 2xl:p-10">

    <h2 class="mb-6 text-title-md2 font-semibold text-black dark:text-white">
        Edit Karyawan
    </h2>

    <form action="{{ route('admin.employees.update', $employee) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
            <div class="p-6 space-y-6">

                <!-- USER -->
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <div>
                        <label class="mb-2 block text-sm font-medium text-black dark:text-white">
                            Nama User
                        </label>
                        <input type="text" name="name" value="{{ $employee->user->name }}"
                               class="w-full rounded border border-stroke px-4 py-2 focus:border-primary focus:outline-none dark:border-strokedark">
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium">Email</label>
                        <input type="email" name="email" value="{{ $employee->user->email }}"
                               class="w-full rounded border border-stroke px-4 py-2">
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium">Role</label>
                        <select name="role" class="w-full rounded border border-stroke px-4 py-2">
                            <option value="superadmin" @selected($employee->user->role=='superadmin')>Superadmin</option>
                            <option value="admin" @selected($employee->user->role=='admin')>Admin</option>
                            <option value="karyawan" @selected($employee->user->role=='karyawan')>Karyawan</option>
                        </select>
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium">Status Akun</label>
                        <select name="status" class="w-full rounded border border-stroke px-4 py-2">
                            <option value="1" @selected($employee->user->status)>Aktif</option>
                            <option value="0" @selected(!$employee->user->status)>Nonaktif</option>
                        </select>
                    </div>
                </div>

                <hr class="border-stroke dark:border-strokedark">

                <!-- EMPLOYEE -->
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <div>
                        <label class="mb-2 block text-sm font-medium">Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" value="{{ $employee->nama_lengkap }}"
                               class="w-full rounded border border-stroke px-4 py-2">
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium">Jabatan</label>
                        <input type="text" name="jabatan" value="{{ $employee->jabatan }}"
                               class="w-full rounded border border-stroke px-4 py-2">
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium">Jenis Kelamin</label>
                        <select name="jenis_kelamin" class="w-full rounded border border-stroke px-4 py-2">
                            <option value="Laki-Laki" @selected($employee->jenis_kelamin=='Laki-Laki')>Laki-Laki</option>
                            <option value="Perempuan" @selected($employee->jenis_kelamin=='Perempuan')>Perempuan</option>
                        </select>
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium">No Telp</label>
                        <input type="text" name="no_telp" value="{{ $employee->no_telp }}"
                               class="w-full rounded border border-stroke px-4 py-2">
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium">Pendidikan Terakhir</label>
                        <input type="text" name="pendidikan_terakhir"
                               value="{{ $employee->pendidikan_terakhir }}"
                               class="w-full rounded border border-stroke px-4 py-2">
                    </div>
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium">Alamat</label>
                    <textarea name="alamat" rows="3"
                              class="w-full rounded border border-stroke px-4 py-2">{{ $employee->alamat }}</textarea>
                </div>

                <!-- FILE -->
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <div>
                        <label class="mb-2 block text-sm font-medium">Foto</label>
                        @if($employee->photo)
                            <img src="{{ asset('storage/'.$employee->photo) }}"
                                 class="mb-2 h-24 rounded">
                        @endif
                        <input type="file" name="photo" class="w-full">
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium">Dokumen KTP</label>
                        @if($employee->ktp_document)
                            <a href="{{ asset('storage/'.$employee->ktp_document) }}"
                               class="mb-2 inline-block text-primary underline" target="_blank">
                                Lihat Dokumen
                            </a>
                        @endif
                        <input type="file" name="ktp_document" class="w-full">
                    </div>
                </div>

            </div>

            <div class="flex justify-end gap-3 border-t border-stroke p-6 dark:border-strokedark">
                <a href="{{ route('admin.employees.index') }}"
                   class="rounded-md border border-stroke px-6 py-2 text-sm font-medium">
                    Kembali
                </a>
                <button type="submit"
                        class="rounded-md bg-primary px-6 py-2 text-sm font-medium text-white hover:bg-opacity-90">
                    Update
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
