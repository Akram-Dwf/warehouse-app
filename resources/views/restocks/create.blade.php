<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
            <i class="fas fa-cart-plus text-blue-600"></i>
            {{ __('Buat Restock Order (PO)') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg border-t-4 border-blue-600">
                <div class="p-8 text-gray-900">

                    <form action="{{ route('restocks.store') }}" method="POST" id="restockForm">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
                            
                            <div class="md:col-span-2 space-y-6">
                                <div class="flex items-center gap-2 text-blue-600 border-b border-blue-100 pb-2 mb-4">
                                    <i class="fas fa-file-contract"></i>
                                    <h4 class="font-bold uppercase text-xs tracking-wider">Detail Pemesanan</h4>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-bold text-gray-700 uppercase tracking-wider mb-1">Pilih Supplier <span class="text-red-500">*</span></label>
                                        <select name="supplier_id" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" required>
                                            <option value="">-- Pilih Supplier --</option>
                                            @foreach($suppliers as $supplier)
                                                <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-bold text-gray-700 uppercase tracking-wider mb-1">Tanggal Order <span class="text-red-500">*</span></label>
                                        <input type="date" name="date" value="{{ date('Y-m-d') }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" required>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-bold text-gray-700 uppercase tracking-wider mb-1">Estimasi Sampai</label>
                                        <input type="date" name="expected_delivery_date" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                    </div>
                                </div>
                            </div>

                            <div>
                                <div class="flex items-center gap-2 text-gray-500 border-b border-gray-100 pb-2 mb-4">
                                    <i class="fas fa-sticky-note"></i>
                                    <h4 class="font-bold uppercase text-xs tracking-wider">Catatan Tambahan</h4>
                                </div>
                                <textarea name="notes" rows="5" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm bg-gray-50" placeholder="Tambahkan catatan untuk supplier..."></textarea>
                            </div>
                        </div>

                        <hr class="my-6 border-gray-200">

                        <div class="mb-8">
                            <div class="flex justify-between items-end mb-2 border-b border-gray-200 pb-2">
                                <h3 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                                    <i class="fas fa-boxes text-blue-600"></i> Daftar Barang Pesanan
                                </h3>
                                <button type="button" id="add_row" class="inline-flex items-center px-3 py-1.5 bg-green-50 text-green-700 text-xs font-bold rounded border border-green-200 hover:bg-green-100 transition">
                                    <i class="fas fa-plus mr-1"></i> Tambah Baris
                                </button>
                            </div>
                            
                            <div class="bg-gray-50 rounded-lg border border-gray-200 overflow-hidden shadow-inner">
                                <table class="min-w-full" id="products_table">
                                    <thead class="bg-gray-100 text-gray-600 text-xs uppercase font-bold">
                                        <tr>
                                            <th class="px-4 py-3 text-left w-1/2">Produk</th>
                                            <th class="px-4 py-3 text-left w-1/4">Jumlah Order</th>
                                            <th class="px-4 py-3 text-center w-1/4">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody id="product_list" class="bg-white divide-y divide-gray-100">
                                        <tr class="product-row group hover:bg-blue-50 transition">
                                            <td class="px-4 py-2">
                                                <select name="products[0][id]" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm product-select" required>
                                                    <option value="">-- Pilih Produk --</option>
                                                    @foreach($products as $product)
                                                        <option value="{{ $product->id }}">
                                                            {{ $product->name }} (Stok: {{ $product->stock }})
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td class="px-4 py-2">
                                                <input type="number" name="products[0][quantity]" min="1" value="10" 
                                                       class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm font-bold text-center" required>
                                            </td>
                                            <td class="px-4 py-2 text-center">
                                                <button type="button" class="text-red-400 hover:text-red-600 p-2 rounded-full hover:bg-red-50 transition remove-row" disabled>
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="flex justify-end gap-4 pt-6 border-t border-gray-100">
                            <a href="{{ route('restocks.index') }}" class="px-6 py-2 bg-gray-200 text-gray-700 font-bold rounded shadow-sm hover:bg-gray-300 transition">
                                Batal
                            </a>
                            <button type="submit" class="px-6 py-2 bg-blue-600 text-white font-bold rounded shadow-md hover:bg-blue-700 transition transform hover:scale-105">
                                <i class="fas fa-paper-plane mr-2"></i> Buat Pesanan (PO)
                            </button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let rowCount = 1;

            document.getElementById('add_row').addEventListener('click', function() {
                const tableBody = document.getElementById('product_list');
                
                const newRowHtml = `
                    <tr class="product-row group hover:bg-blue-50 transition border-t border-gray-100">
                        <td class="px-4 py-2">
                            <select name="products[${rowCount}][id]" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm product-select" required>
                                <option value="">-- Pilih Produk --</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}">
                                        {{ $product->name }} (Stok: {{ $product->stock }})
                                    </option>
                                @endforeach
                            </select>
                        </td>
                        <td class="px-4 py-2">
                            <input type="number" name="products[${rowCount}][quantity]" min="1" value="10" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm font-bold text-center" required>
                        </td>
                        <td class="px-4 py-2 text-center">
                            <button type="button" class="text-red-400 hover:text-red-600 p-2 rounded-full hover:bg-red-50 transition remove-row" onclick="this.closest('tr').remove()">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </td>
                    </tr>
                `;

                tableBody.insertAdjacentHTML('beforeend', newRowHtml);
                rowCount++;
            });

            document.querySelectorAll('.remove-row').forEach(btn => {
                btn.addEventListener('click', function() {
                    if (document.querySelectorAll('.product-row').length > 1) {
                        this.closest('tr').remove();
                    }
                });
            });
        });
    </script>
</x-app-layout>