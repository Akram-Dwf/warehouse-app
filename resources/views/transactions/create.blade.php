<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Buat Transaksi Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <form action="{{ route('transactions.store') }}" method="POST" id="transactionForm">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Tanggal Transaksi</label>
                                    <input type="date" name="date" value="{{ date('Y-m-d') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Tipe Transaksi</label>
                                    <select name="type" id="type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required onchange="toggleType()">
                                        <option value="incoming">Barang Masuk (Incoming)</option>
                                        <option value="outgoing">Barang Keluar (Outgoing)</option>
                                    </select>
                                </div>

                                <div id="supplier_field">
                                    <label class="block text-sm font-medium text-gray-700">Supplier</label>
                                    <select name="supplier_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        <option value="">-- Pilih Supplier --</option>
                                        @foreach($suppliers as $supplier)
                                            <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div id="customer_field" style="display: none;">
                                    <label class="block text-sm font-medium text-gray-700">Nama Customer</label>
                                    <input type="text" name="customer_name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Contoh: Toko Maju Jaya">
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Catatan (Opsional)</label>
                                <textarea name="notes" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Tambahkan catatan jika perlu..."></textarea>
                            </div>
                        </div>

                        <hr class="my-6">

                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Daftar Barang</h3>
                        
                        <div class="overflow-x-auto mb-4">
                            <table class="min-w-full border border-gray-200" id="products_table">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700 w-1/2">Produk</th>
                                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700 w-1/4">Jumlah</th>
                                        <th class="px-4 py-2 text-center text-sm font-medium text-gray-700 w-1/4">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="product_list">
                                    <tr class="border-t product-row">
                                        <td class="px-4 py-2">
                                            <select name="products[0][id]" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 product-select" required>
                                                <option value="">-- Pilih Produk --</option>
                                                @foreach($products as $product)
                                                    <option value="{{ $product->id }}">
                                                        {{ $product->name }} (Stok: {{ $product->stock }})
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td class="px-4 py-2">
                                            <input type="number" name="products[0][quantity]" min="1" value="1" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 quantity-input" required>
                                        </td>
                                        <td class="px-4 py-2 text-center">
                                            <button type="button" class="text-red-500 hover:text-red-700 remove-row" disabled>
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <button type="button" id="add_row" class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none">
                            + Tambah Baris Produk
                        </button>

                        <div class="flex justify-end mt-6 pt-4 border-t border-gray-200 gap-4">
                            <a href="{{ route('transactions.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                Batal
                            </a>
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow-lg">
                                Simpan Transaksi
                            </button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>

    <script>
        // 1. LOGIKA GANTI TIPE (INCOMING/OUTGOING)
        function toggleType() {
            const type = document.getElementById('type').value;
            const supplierField = document.getElementById('supplier_field');
            const customerField = document.getElementById('customer_field');

            if (type === 'incoming') {
                supplierField.style.display = 'block';
                customerField.style.display = 'none';
            } else {
                supplierField.style.display = 'none';
                customerField.style.display = 'block';
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            let rowCount = 1;

            // 2. LOGIKA TAMBAH BARIS
            document.getElementById('add_row').addEventListener('click', function() {
                const tableBody = document.getElementById('product_list');
                const firstRow = tableBody.querySelector('tr');
                const newRow = firstRow.cloneNode(true);

                // Reset nilai input di baris baru
                const inputs = newRow.querySelectorAll('input, select');
                inputs.forEach(input => {
                    input.value = '';
                    if (input.name.includes('[id]')) {
                        input.name = `products[${rowCount}][id]`;
                    } else if (input.name.includes('[quantity]')) {
                        input.name = `products[${rowCount}][quantity]`;
                        input.value = 1;
                    }
                });

                // Aktifkan tombol hapus di baris baru
                const removeBtn = newRow.querySelector('.remove-row');
                removeBtn.disabled = false;
                removeBtn.onclick = function() {
                    newRow.remove();
                };

                tableBody.appendChild(newRow);
                rowCount++;
            });
        });
    </script>
</x-app-layout>