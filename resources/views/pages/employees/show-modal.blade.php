<div
    x-show="openEmployeeModal"
    x-transition
    class="fixed inset-0 z-50 flex items-center justify-center"
>
    <!-- Overlay -->
    <div
        class="absolute inset-0 bg-black/50"
        @click="openEmployeeModal = false"
    ></div>

    <!-- Modal Box -->
    <div class="relative w-full max-w-screen-md max-h-[90vh] overflow-y-auto
                rounded-xl bg-white shadow-default
                dark:bg-gray-900">

        {{-- HEADER --}}
        <div class="flex items-center justify-between border-b
                    border-gray-200 p-6 dark:border-gray-800">
            <h2 class="text-title-md2 font-semibold text-gray-800 dark:text-white/90">
                Detail Karyawan
            </h2>

            <button
                @click="openEmployeeModal = false"
                class="text-gray-500 hover:text-red-500 text-xl"
            >
                ✕
            </button>
        </div>

        {{-- CONTENT --}}
        <div class="p-6 space-y-6">

            {{-- PROFILE --}}
            <div class="flex items-center gap-6">
                @if($employee->photo)
                    <img src="{{ asset('storage/'.$employee->photo) }}"
                         class="h-24 w-24 rounded-full object-cover ring-1 ring-gray-200 dark:ring-gray-700">
                @endif

                <div>
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white dark:text-white/90">
                        {{ $employee->nama_lengkap }}
                    </h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 dark:text-white/90">
                        {{ $employee->jabatan }}
                    </p>
                </div>
            </div>

            {{-- INFO GRID --}}
            <div class="grid grid-cols-1 gap-4 text-sm md:grid-cols-2 text-title-md2 font-semibold text-gray-800 dark:text-white/90">
                <p><strong>Email:</strong> {{ $employee->user->email }}</p>
                <p><strong>Role:</strong> {{ $employee->user->role }}</p>
                <p><strong>No Telp:</strong> {{ $employee->no_telp }}</p>
                <p><strong>Pendidikan:</strong> {{ $employee->pendidikan_terakhir }}</p>
                <p><strong>Jenis Kelamin:</strong> {{ $employee->jenis_kelamin }}</p>
            </div>

            {{-- ALAMAT --}}
            <div>
                <p class="mb-1 text-sm font-medium text-gray-600 dark:text-gray-400 dark:text-white/90">Alamat</p>
                <p class="text-sm text-gray-600 dark:text-gray-400 dark:text-white/90">
                    {{ $employee->alamat }}
                </p>
            </div>

            {{-- DOKUMEN --}}
            <div>
                <p class="mb-1 text-sm font-medium text-gray-600 dark:text-gray-400 dark:text-white/90">Dokumen</p>
                @if($employee->ktp_document)
                    <a href="{{ asset('storage/'.$employee->ktp_document) }}"
                       target="_blank"
                       class="font-semibold underline text-gray-600 dark:text-gray-400 dark:text-white/90">
                        Lihat Dokumen KTP
                    </a>
                @else
                    <p class="text-sm text-gray-500 text-gray-600 dark:text-gray-400 dark:text-white/90">Tidak ada dokumen</p>
                @endif
            </div>

        </div>

        {{-- FOOTER --}}
        <div class="flex justify-between border-t
                    border-gray-200 p-6 dark:border-gray-800">

            <a href="{{ route('admin.employees.edit', $employee) }}"
               class="inline-flex h-10 items-center rounded-md
                      bg-primary px-6 text-sm font-medium text-gray-600 dark:text-gray-400 dark:text-white/90">
                Edit
            </a>

            @if($employee->user->status)
                <form action="{{ route('admin.employees.deactivate', $employee) }}" method="POST">
                    @csrf
                    <button class="h-10 rounded-md bg-red-600 px-6 text-sm text-white">
                        Nonaktifkan
                    </button>
                </form>
            @else
                <form action="{{ route('admin.employees.activate', $employee) }}" method="POST">
                    @csrf
                    <button class="h-10 rounded-md bg-green-600 px-6 text-sm text-white">
                        Aktifkan
                    </button>
                </form>
            @endif

        </div>
    </div>
</div>
