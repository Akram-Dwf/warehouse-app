<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
            <i class="fas fa-plus-circle text-blue-600"></i>
            {{ __('Tambah Produk Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg border-t-4 border-blue-600">
                <div class="p-8 text-gray-900">

                    <div class="mb-8 border-b border-gray-100 pb-4">
                        <h3 class="text-lg font-bold text-gray-800">Detail Produk</h3>
                        <p class="text-sm text-gray-500">Masukkan informasi lengkap produk baru ke dalam inventori.</p>
                    </div>

                    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            
                            <div class="space-y-6">
                                <div class="flex items-center gap-2 text-blue-600 border-b border-blue-100 pb-2 mb-4">
                                    <i class="fas fa-info-circle"></i>
                                    <h4 class="font-bold uppercase text-xs tracking-wider">Identitas & Lokasi</h4>
                                </div>

                                <div>
                                    <label class="block text-sm font-bold text-gray-700 uppercase tracking-wider mb-1">SKU (Kode Unik) <span class="text-red-500">*</span></label>
                                    <div class="relative rounded-md shadow-sm">
                                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                            <i class="fas fa-barcode text-gray-400"></i>
                                        </div>
                                        <input type="text" name="sku" value="{{ old('sku') }}" 
                                               class="block w-full rounded-md border-gray-300 pl-10 focus:border-blue-500 focus:ring-blue-500 sm:text-sm" 
                                               placeholder="Contoh: PROD-001" required>
                                    </div>
                                    @error('sku') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-bold text-gray-700 uppercase tracking-wider mb-1">Nama Produk <span class="text-red-500">*</span></label>
                                    <input type="text" name="name" value="{{ old('name') }}" 
                                           class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" required>
                                    @error('name') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-bold text-gray-700 uppercase tracking-wider mb-1">Kategori <span class="text-red-500">*</span></label>
                                    <select name="category_id" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" required>
                                        <option value="">-- Pilih Kategori --</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category_id') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-bold text-gray-700 uppercase tracking-wider mb-1">Satuan <span class="text-red-500">*</span></label>
                                        <input type="text" name="unit" value="{{ old('unit', 'pcs') }}" 
                                               class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" required>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-bold text-gray-700 uppercase tracking-wider mb-1">Lokasi Rak <span class="text-red-500">*</span></label>
                                        <input type="text" name="location" value="{{ old('location') }}" 
                                               class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" 
                                               placeholder="Contoh: A-01" required>
                                    </div>
                                </div>
                            </div>

                            <div class="space-y-6">
                                <div class="flex items-center gap-2 text-green-600 border-b border-green-100 pb-2 mb-4">
                                    <i class="fas fa-coins"></i>
                                    <h4 class="font-bold uppercase text-xs tracking-wider">Harga & Stok</h4>
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-bold text-gray-700 uppercase tracking-wider mb-1">Harga Beli (Rp) <span class="text-red-500">*</span></label>
                                        <input type="number" name="purchase_price" value="{{ old('purchase_price') }}" 
                                               class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" required>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-bold text-gray-700 uppercase tracking-wider mb-1">Harga Jual (Rp) <span class="text-red-500">*</span></label>
                                        <input type="number" name="selling_price" value="{{ old('selling_price') }}" 
                                               class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" required>
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-bold text-gray-700 uppercase tracking-wider mb-1">Stok Awal <span class="text-red-500">*</span></label>
                                        <input type="number" name="stock" value="{{ old('stock', 0) }}" 
                                               class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" required>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-bold text-gray-700 uppercase tracking-wider mb-1">Min. Stok (Alert) <span class="text-red-500">*</span></label>
                                        <input type="number" name="min_stock" value="{{ old('min_stock', 10) }}" 
                                               class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" required>
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-bold text-gray-700 uppercase tracking-wider mb-1">Gambar Produk <span class="text-red-500">*</span></label>
                                    <label class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 hover:border-blue-400 transition">
                                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                            <i class="fas fa-cloud-upload-alt text-gray-400 text-2xl mb-2"></i>
                                            <p class="mb-1 text-xs text-gray-500 font-semibold">Klik untuk upload gambar</p>
                                        </div>
                                        <input type="file" name="image" class="hidden" />
                                    </label>
                                    @error('image') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mt-8">
                            <label class="block text-sm font-bold text-gray-700 uppercase tracking-wider mb-1">Deskripsi Lengkap <span class="text-red-500">*</span></label>
                            <textarea name="description" rows="4" 
                                      class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" 
                                      placeholder="Jelaskan spesifikasi produk..." required>{{ old('description') }}</textarea>
                            @error('description') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="flex items-center justify-end gap-4 pt-6 border-t border-gray-100 mt-6">
                            <a href="{{ route('products.index') }}" class="px-6 py-2 bg-gray-200 text-gray-700 font-bold rounded shadow-sm hover:bg-gray-300 transition">
                                Batal
                            </a>
                            <button type="submit" class="px-6 py-2 bg-blue-600 text-white font-bold rounded shadow-md hover:bg-blue-700 transition transform hover:scale-105">
                                <i class="fas fa-save mr-2"></i> Simpan Produk
                            </button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>