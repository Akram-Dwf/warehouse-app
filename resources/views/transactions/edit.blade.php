<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Transaksi') }} : <span class="text-blue-600">{{ $transaction->reference_number }}</span>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <form action="{{ route('transactions.update', $transaction) }}" method="POST" id="transactionForm"
                          data-row-count="{{ $transaction->products->count() }}">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            
                            <div class="space-y-4 bg-gray-50 p-4 rounded-lg border border-gray-200">
                                <h3 class="text-sm font-bold text-gray-500 uppercase mb-2">Informasi Tetap</h3>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Tanggal Transaksi</label>
                                    <input type="text" value="{{ $transaction->date }}" class="mt-1 block w-full rounded-md border-gray-200 bg-gray-100 text-gray-500 shadow-sm cursor-not-allowed" readonly>
                                </div>

                                @if($transaction->type == 'incoming')
                                    <div>
                                        <label class="block text-sm font-medium text-gray-500">Tipe</label>
                                        <input type="text" value="Barang Masuk (Incoming)" class="mt-1 block w-full rounded-md border-gray-200 bg-gray-100 text-blue-600 font-bold shadow-sm cursor-not-allowed" readonly>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-500">Supplier</label>
                                        <input type="text" value="{{ $transaction->supplier->name ?? '-' }}" class="mt-1 block w-full rounded-md border-gray-200 bg-gray-100 text-gray-500 shadow-sm cursor-not-allowed" readonly>
                                    </div>
                                @else
                                    <div>
                                        <label class="block text-sm font-medium text-gray-500">Tipe</label>
                                        <input type="text" value="Barang Keluar (Outgoing)" class="mt-1 block w-full rounded-md border-gray-200 bg-gray-100 text-orange-600 font-bold shadow-sm cursor-not-allowed" readonly>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-500">Customer</label>
                                        <input type="text" value="{{ $transaction->customer_name }}" class="mt-1 block w-full rounded-md border-gray-200 bg-gray-100 text-gray-500 shadow-sm cursor-not-allowed" readonly>
                                    </div>
                                @endif
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Catatan (Bisa diedit)</label>
                                <textarea name="notes" rows="6" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('notes', $transaction->notes) }}</textarea>
                            </div>
                        </div>

                        <hr class="my-6">

                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold text-gray-800">Edit Daftar Barang</h3>
                            <button type="button" id="add_row" class="inline-flex items-center px-3 py-1 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none">
                                + Tambah Baris
                            </button>
                        </div>
                        
                        <div class="overflow-x-auto mb-6">
                            <table class="min-w-full border border-gray-200" id="products_table">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700 w-1/2">Produk</th>
                                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700 w-1/4">Jumlah</th>
                                        <th class="px-4 py-2 text-center text-sm font-medium text-gray-700 w-1/4">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="product_list">
                                    
                                    @foreach($transaction->products as $index => $item)
                                        <tr class="border-t product-row">
                                            <td class="px-4 py-2">
                                                <select name="products[{{ $index }}][id]" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 product-select" required>
                                                    <option value="">-- Pilih Produk --</option>
                                                    @foreach($products as $product)
                                                        <option value="{{ $product->id }}" {{ $item->id == $product->id ? 'selected' : '' }}>
                                                            {{ $product->name }} (Stok: {{ $product->stock }})
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td class="px-4 py-2">
                                                <input type="number" name="products[{{ $index }}][quantity]" min="1" value="{{ $item->pivot->quantity }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 quantity-input" required>
                                            </td>
                                            <td class="px-4 py-2 text-center">
                                                <button type="button" class="text-red-500 hover:text-red-700 remove-row">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>

                        <div class="flex justify-end mt-6 pt-4 border-t border-gray-200 gap-4">
                            <a href="{{ route('transactions.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                Batal
                            </a>
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow-lg">
                                Simpan Perubahan
                            </button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('transactionForm');
            let rowCount = parseInt(form.getAttribute('data-row-count')) || 0;

            document.getElementById('add_row').addEventListener('click', function() {
                const tableBody = document.getElementById('product_list');
                
                const newRowHtml = `
                    <tr class="border-t product-row">
                        <td class="px-4 py-2">
                            <select name="products[${rowCount}][id]" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 product-select" required>
                                <option value="">-- Pilih Produk --</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}">
                                        {{ $product->name }} (Stok: {{ $product->stock }})
                                    </option>
                                @endforeach
                            </select>
                        </td>
                        <td class="px-4 py-2">
                            <input type="number" name="products[${rowCount}][quantity]" min="1" value="1" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 quantity-input" required>
                        </td>
                        <td class="px-4 py-2 text-center">
                            <button type="button" class="text-red-500 hover:text-red-700 remove-row" onclick="this.closest('tr').remove()">
                                <i class="fas fa-trash"></i>
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
                    } else {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Tidak Bisa Dihapus',
                            text: 'Transaksi harus memiliki minimal satu produk.',
                            confirmButtonColor: '#f59e0b'
                        });
                    }
                });
            });
        });
    </script>
</x-app-layout>