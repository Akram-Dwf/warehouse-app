<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
            <i class="fas fa-edit text-blue-600"></i>
            {{ __('Edit Produk') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg border-t-4 border-blue-600">
                <div class="p-8 text-gray-900">

                    <div class="mb-8 border-b border-gray-100 pb-4 flex justify-between items-center">
                        <div>
                            <h3 class="text-lg font-bold text-gray-800">Edit: {{ $product->name }}</h3>
                            <p class="text-sm text-gray-500">Perbarui informasi produk.</p>
                        </div>
                        <span class="bg-gray-100 text-gray-600 text-xs font-mono px-3 py-1 rounded border">SKU: {{ $product->sku }}</span>
                    </div>

                    <form action="{{ route('products.update', $product) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            
                            <div class="space-y-6">
                                <div class="flex items-center gap-2 text-blue-600 border-b border-blue-100 pb-2 mb-4">
                                    <i class="fas fa-info-circle"></i>
                                    <h4 class="font-bold uppercase text-xs tracking-wider">Identitas & Lokasi</h4>
                                </div>

                                <div>
                                    <label class="block text-sm font-bold text-gray-500 uppercase tracking-wider mb-1">SKU (Tidak dapat diubah)</label>
                                    <div class="relative rounded-md shadow-sm">
                                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                            <i class="fas fa-lock text-gray-400"></i>
                                        </div>
                                        <input type="text" value="{{ $product->sku }}" 
                                               class="block w-full rounded-md border-gray-200 bg-gray-100 pl-10 text-gray-500 cursor-not-allowed sm:text-sm" readonly>
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-bold text-gray-700 uppercase tracking-wider mb-1">Nama Produk <span class="text-red-500">*</span></label>
                                    <input type="text" name="name" value="{{ old('name', $product->name) }}" 
                                           class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" required>
                                </div>

                                <div>
                                    <label class="block text-sm font-bold text-gray-700 uppercase tracking-wider mb-1">Kategori <span class="text-red-500">*</span></label>
                                    <select name="category_id" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" required>
                                        <option value="">-- Pilih Kategori --</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-bold text-gray-700 uppercase tracking-wider mb-1">Satuan <span class="text-red-500">*</span></label>
                                        <input type="text" name="unit" value="{{ old('unit', $product->unit) }}" 
                                               class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" required>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-bold text-gray-700 uppercase tracking-wider mb-1">Lokasi Rak <span class="text-red-500">*</span></label>
                                        <input type="text" name="location" value="{{ old('location', $product->location) }}" 
                                               class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" required>
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
                                        <label class="block text-sm font-bold text-gray-700 uppercase tracking-wider mb-1">Harga Beli <span class="text-red-500">*</span></label>
                                        <input type="number" name="purchase_price" value="{{ old('purchase_price', $product->purchase_price) }}" 
                                               class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" required>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-bold text-gray-700 uppercase tracking-wider mb-1">Harga Jual <span class="text-red-500">*</span></label>
                                        <input type="number" name="selling_price" value="{{ old('selling_price', $product->selling_price) }}" 
                                               class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" required>
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-bold text-gray-700 uppercase tracking-wider mb-1">Stok Saat Ini <span class="text-red-500">*</span></label>
                                        <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" 
                                               class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" required>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-bold text-gray-700 uppercase tracking-wider mb-1">Min. Stok <span class="text-red-500">*</span></label>
                                        <input type="number" name="min_stock" value="{{ old('min_stock', $product->min_stock) }}" 
                                               class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" required>
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-bold text-gray-700 uppercase tracking-wider mb-3">Ganti Gambar</label>
                                    <div class="flex items-start gap-4">
                                        @if($product->image)
                                            <img src="{{ asset('storage/' . $product->image) }}" class="w-24 h-24 object-cover rounded-lg border shadow-sm bg-gray-50 shrink-0">
                                        @endif
                                        <label class="flex-grow flex flex-col items-center justify-center h-24 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 hover:border-blue-400 transition">
                                            <div class="flex flex-col items-center justify-center pt-2 pb-3">
                                                <i class="fas fa-cloud-upload-alt text-gray-400 text-xl mb-1"></i>
                                                <p class="text-xs text-gray-500 font-semibold">Ganti file gambar</p>
                                            </div>
                                            <input type="file" name="image" class="hidden" />
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-8">
                            <label class="block text-sm font-bold text-gray-700 uppercase tracking-wider mb-1">Deskripsi Lengkap <span class="text-red-500">*</span></label>
                            <textarea name="description" rows="4" 
                                      class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" required>{{ old('description', $product->description) }}</textarea>
                        </div>

                        <div class="flex items-center justify-end gap-4 pt-6 border-t border-gray-100 mt-6">
                            <a href="{{ route('products.index') }}" class="px-6 py-2 bg-gray-200 text-gray-700 font-bold rounded shadow-sm hover:bg-gray-300 transition">
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