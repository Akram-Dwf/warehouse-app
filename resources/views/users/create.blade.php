<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
            <i class="fas fa-user-plus text-blue-600"></i>
            {{ __('Tambah Pengguna Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg border-t-4 border-blue-600">
                <div class="p-8 text-gray-900">

                    <div class="mb-8 border-b border-gray-100 pb-4">
                        <h3 class="text-lg font-bold text-gray-800">Detail Akun</h3>
                        <p class="text-sm text-gray-500">Buat akun baru untuk akses sistem internal.</p>
                    </div>

                    <form action="{{ route('users.store') }}" method="POST">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            
                            <div class="space-y-6">
                                <div class="flex items-center gap-2 text-blue-600 border-b border-blue-100 pb-2 mb-4">
                                    <i class="fas fa-id-card"></i>
                                    <h4 class="font-bold uppercase text-xs tracking-wider">Informasi Profil</h4>
                                </div>

                                <div>
                                    <label class="block text-sm font-bold text-gray-700 uppercase tracking-wider mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fas fa-user text-gray-400"></i>
                                        </div>
                                        <input type="text" name="name" value="{{ old('name') }}" 
                                               class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" required>
                                    </div>
                                    @error('name') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-bold text-gray-700 uppercase tracking-wider mb-1">Alamat Email <span class="text-red-500">*</span></label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fas fa-envelope text-gray-400"></i>
                                        </div>
                                        <input type="email" name="email" value="{{ old('email') }}" 
                                               class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" required>
                                    </div>
                                    @error('email') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-bold text-gray-700 uppercase tracking-wider mb-1">Peran (Role) <span class="text-red-500">*</span></label>
                                    <select name="role" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" required>
                                        <option value="">-- Pilih Akses --</option>
                                        <option value="admin">Admin (Full Access)</option>
                                        <option value="manager">Warehouse Manager</option>
                                        <option value="staff">Staff Gudang</option>
                                        <option value="supplier">Supplier</option>
                                    </select>
                                    @error('role') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            <div class="space-y-6">
                                <div class="flex items-center gap-2 text-green-600 border-b border-green-100 pb-2 mb-4">
                                    <i class="fas fa-lock"></i>
                                    <h4 class="font-bold uppercase text-xs tracking-wider">Keamanan Akun</h4>
                                </div>

                                <div>
                                    <label class="block text-sm font-bold text-gray-700 uppercase tracking-wider mb-1">Password <span class="text-red-500">*</span></label>
                                    <input type="password" name="password" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" required>
                                    @error('password') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-bold text-gray-700 uppercase tracking-wider mb-1">Konfirmasi Password <span class="text-red-500">*</span></label>
                                    <input type="password" name="password_confirmation" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" required>
                                </div>

                                <div class="bg-blue-50 p-4 rounded-lg border border-blue-100 mt-4">
                                    <p class="text-xs text-blue-800">
                                        <i class="fas fa-info-circle mr-1"></i> 
                                        User baru akan langsung berstatus <strong>Aktif</strong> dan dapat segera login.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-end gap-4 pt-6 border-t border-gray-100 mt-8">
                            <a href="{{ route('users.index') }}" class="px-6 py-2 bg-gray-200 text-gray-700 font-bold rounded shadow-sm hover:bg-gray-300 transition">
                                Batal
                            </a>
                            <button type="submit" class="px-6 py-2 bg-blue-600 text-white font-bold rounded shadow-md hover:bg-blue-700 transition transform hover:scale-105">
                                <i class="fas fa-save mr-2"></i> Simpan Pengguna
                            </button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>