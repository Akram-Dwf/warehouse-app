<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
            <i class="fas fa-user-edit text-blue-600"></i>
            {{ __('Edit Pengguna') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg border-t-4 border-yellow-500">
                <div class="p-8 text-gray-900">

                    <div class="mb-8 border-b border-gray-100 pb-4 flex justify-between items-center">
                        <div>
                            <h3 class="text-lg font-bold text-gray-800">Perbarui Profil</h3>
                            <p class="text-sm text-gray-500">Edit informasi pengguna sistem.</p>
                        </div>
                        <span class="bg-gray-100 text-gray-600 font-mono font-bold px-3 py-1 rounded border text-sm">
                            ID: {{ $user->id }}
                        </span>
                    </div>

                    <form action="{{ route('users.update', $user) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            
                            <div class="space-y-6">
                                <div class="flex items-center gap-2 text-blue-600 border-b border-blue-100 pb-2 mb-4">
                                    <i class="fas fa-id-card"></i>
                                    <h4 class="font-bold uppercase text-xs tracking-wider">Informasi Dasar</h4>
                                </div>

                                <div>
                                    <label class="block text-sm font-bold text-gray-700 uppercase tracking-wider mb-1">Nama Lengkap</label>
                                    <input type="text" name="name" value="{{ old('name', $user->name) }}" 
                                           class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" required>
                                    @error('name') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-bold text-gray-700 uppercase tracking-wider mb-1">Email</label>
                                    <input type="email" name="email" value="{{ old('email', $user->email) }}" 
                                           class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" required>
                                    @error('email') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-bold text-gray-500 uppercase tracking-wider mb-1">
                                        Peran (Role) <span class="text-xs text-red-500 normal-case ml-1"><i class="fas fa-lock"></i> Terkunci</span>
                                    </label>
                                    <div class="relative">
                                        <select name="role" class="block w-full rounded-md border-gray-200 bg-gray-100 text-gray-500 shadow-sm cursor-not-allowed sm:text-sm" disabled>
                                            <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                            <option value="manager" {{ $user->role == 'manager' ? 'selected' : '' }}>Warehouse Manager</option>
                                            <option value="staff" {{ $user->role == 'staff' ? 'selected' : '' }}>Staff Gudang</option>
                                            <option value="supplier" {{ $user->role == 'supplier' ? 'selected' : '' }}>Supplier</option>
                                        </select>
                                        </div>
                                    <p class="text-xs text-gray-400 mt-1">Role tidak dapat diubah untuk menjaga hierarki.</p>
                                </div>
                            </div>

                            <div class="space-y-6">
                                <div class="flex items-center gap-2 text-green-600 border-b border-green-100 pb-2 mb-4">
                                    <i class="fas fa-key"></i>
                                    <h4 class="font-bold uppercase text-xs tracking-wider">Ubah Password</h4>
                                </div>

                                <div class="bg-yellow-50 p-4 rounded border border-yellow-100 mb-4">
                                    <p class="text-xs text-yellow-800">
                                        <strong>Catatan:</strong> Kosongkan kolom di bawah ini jika tidak ingin mengubah password pengguna.
                                    </p>
                                </div>

                                <div>
                                    <label class="block text-sm font-bold text-gray-700 uppercase tracking-wider mb-1">Password Baru</label>
                                    <input type="password" name="password" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                    @error('password') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-bold text-gray-700 uppercase tracking-wider mb-1">Konfirmasi Password</label>
                                    <input type="password" name="password_confirmation" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-end gap-4 pt-6 border-t border-gray-100 mt-8">
                            <a href="{{ route('users.index') }}" class="px-6 py-2 bg-gray-200 text-gray-700 font-bold rounded shadow-sm hover:bg-gray-300 transition">
                                Batal
                            </a>
                            <button type="submit" class="px-6 py-2 bg-blue-600 text-white font-bold rounded shadow-md hover:bg-blue-700 transition transform hover:scale-105">
                                <i class="fas fa-check-circle mr-2"></i> Simpan Perubahan
                            </button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>