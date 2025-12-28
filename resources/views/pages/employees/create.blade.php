@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-screen-md p-4 md:p-6 2xl:p-10">

    <h2 class="mb-6 text-title-md2 font-semibold text-black dark:text-white">
        Tambah Karyawan
    </h2>

    <form action="{{ route('admin.employees.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
            <div class="p-6 space-y-6">

                <div>
                    <label class="mb-2 block text-sm font-medium text-black dark:text-white">
                        Nama User
                    </label>
                    <input type="text" name="name" class="w-full rounded border border-stroke bg-transparent px-4 py-2 focus:border-primary focus:outline-none dark:border-strokedark">
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium">Email</label>
                    <input type="email" name="email" class="w-full rounded border border-stroke px-4 py-2">
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium">Password</label>
                    <input type="password" name="password" class="w-full rounded border border-stroke px-4 py-2">
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium">Role</label>
                    <select name="role" class="w-full rounded border border-stroke px-4 py-2">
                        <option value="">Pilih Role</option>
                        <option value="superadmin">Superadmin</option>
                        <option value="admin">Admin</option>
                        <option value="karyawan">Karyawan</option>
                    </select>
                </div>

                <hr class="border-stroke dark:border-strokedark">

                <div>
                    <label class="mb-2 block text-sm font-medium">Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" class="w-full rounded border border-stroke px-4 py-2">
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium">Jabatan</label>
                    <input type="text" name="jabatan" class="w-full rounded border border-stroke px-4 py-2">
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium">Jenis Kelamin</label>
                    <select name="jenis_kelamin" class="w-full rounded border border-stroke px-4 py-2">
                        <option value="">Pilih</option>
                        <option value="Laki-Laki">Laki-Laki</option>
                        <option value="Perempuan">Perempuan</option>
                    </select>
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium">Alamat</label>
                    <textarea name="alamat" rows="3" class="w-full rounded border border-stroke px-4 py-2"></textarea>
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium">Foto</label>
                    <input type="file" name="photo" class="w-full">
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium">Dokumen KTP</label>
                    <input type="file" name="ktp_document" class="w-full">
                </div>

            </div>

            <div class="flex justify-end gap-3 border-t border-stroke p-6 dark:border-strokedark">
                <button class="rounded-md border border-stroke px-6 py-2 text-sm font-medium">
                    Batal
                </button>
                <button type="submit"
                        class="rounded-md bg-primary px-6 py-2 text-sm font-medium text-white hover:bg-opacity-90">
                    Simpan
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
