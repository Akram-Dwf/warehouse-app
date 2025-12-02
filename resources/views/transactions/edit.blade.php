<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
            <i class="fas fa-edit text-blue-600"></i>
            {{ __('Edit Transaksi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg border-t-4 border-yellow-500">
                <div class="p-8 text-gray-900">

                    <div class="mb-8 border-b border-gray-100 pb-4 flex justify-between items-center">
                        <div>
                            <h3 class="text-lg font-bold text-gray-800">Perbarui Data Transaksi</h3>
                            <p class="text-sm text-gray-500">Perbaiki kesalahan input produk atau catatan.</p>
                        </div>
                        <span class="bg-gray-100 text-gray-600 font-mono font-bold px-3 py-1 rounded border text-sm">
                            {{ $transaction->reference_number }}
                        </span>
                    </div>

                    <form action="{{ route('transactions.update', $transaction) }}" method="POST" id="transactionForm"
                          data-row-count="{{ $transaction->products->count() }}">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
                            
                            <div class="md:col-span-2 bg-gray-50 p-6 rounded-xl border border-gray-200">
                                <div class="flex items-center gap-2 text-gray-500 border-b border-gray-200 pb-2 mb-4">
                                    <i class="fas fa-lock"></i>
                                    <h4 class="font-bold uppercase text-xs tracking-wider">Informasi Tetap (Terkunci)</h4>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label class="block text-xs font-bold text-gray-400 uppercase mb-1">Tanggal</label>
                                        <input type="text" value="{{ $transaction->date }}" class="block w-full rounded-md border-gray-200 bg-gray-100 text-gray-500 shadow-sm cursor-not-allowed sm:text-sm font-medium" readonly>
                                    </div>

                                    @if($transaction->type == 'incoming')
                                        <div>
                                            <label class="block text-xs font-bold text-gray-400 uppercase mb-1">Tipe</label>
                                            <div class="flex items-center gap-2 mt-1">
                                                <span class="text-blue-700 bg-blue-100 px-2 py-1 rounded text-xs font-bold border border-blue-200">INCOMING</span>
                                            </div>
                                        </div>
                                        <div class="md:col-span-2">
                                            <label class="block text-xs font-bold text-gray-400 uppercase mb-1">Supplier</label>
                                            <p class="font-bold text-gray-800 text-lg">{{ $transaction->supplier->name ?? '-' }}</p>
                                        </div>
                                    @else
                                        <div>
                                            <label class="block text-xs font-bold text-gray-400 uppercase mb-1">Tipe</label>
                                            <div class="flex items-center gap-2 mt-1">
                                                <span class="text-orange-700 bg-orange-100 px-2 py-1 rounded text-xs font-bold border border-orange-200">OUTGOING</span>
                                            </div>
                                        </div>
                                        <div class="md:col-span-2">
                                            <label class="block text-xs font-bold text-gray-400 uppercase mb-1">Customer</label>
                                            <p class="font-bold text-gray-800 text-lg">{{ $transaction->customer_name }}</p>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div>
                                <div class="flex items-center gap-2 text-blue-600 border-b border-blue-100 pb-2 mb-4">
                                    <i class="fas fa-pen"></i>
                                    <h4 class="font-bold uppercase text-xs tracking-wider">Edit Catatan</h4>
                                </div>
                                <textarea name="notes" rows="6" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm bg-white">{{ old('notes', $transaction->notes) }}</textarea>
                            </div>
                        </div>

                        <div class="mb-8">
                            <div class="flex justify-between items-end mb-2 border-b border-gray-200 pb-2">
                                <h3 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                                    <i class="fas fa-boxes text-blue-600"></i> Edit Daftar Barang
                                </h3>
                                <button type="button" id="add_row" class="inline-flex items-center px-3 py-1.5 bg-green-50 text-green-700 text-xs font-bold rounded border border-green-200 hover:bg-green-100 transition shadow-sm">
                                    <i class="fas fa-plus mr-1"></i> Tambah Baris
                                </button>
                            </div>
                            
                            <div class="bg-gray-50 rounded-lg border border-gray-200 overflow-hidden shadow-inner">
                                <table class="min-w-full" id="products_table">
                                    <thead class="bg-gray-100 text-gray-600 text-xs uppercase font-bold">
                                        <tr>
                                            <th class="px-4 py-3 text-left w-1/2">Produk</th>
                                            <th class="px-4 py-3 text-left w-1/4">Jumlah</th>
                                            <th class="px-4 py-3 text-center w-1/4">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody id="product_list" class="bg-white divide-y divide-gray-100">
                                        
                                        @foreach($transaction->products as $index => $item)
                                            <tr class="product-row group hover:bg-yellow-50 transition">
                                                <td class="px-4 py-2">
                                                    <select name="products[{{ $index }}][id]" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm product-select" required>
                                                        <option value="">-- Pilih Produk --</option>
                                                        @foreach($products as $product)
                                                            <option value="{{ $product->id }}" {{ $item->id == $product->id ? 'selected' : '' }}>
                                                                {{ $product->name }} (Stok: {{ $product->stock }})
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td class="px-4 py-2">
                                                    <input type="number" name="products[{{ $index }}][quantity]" min="1" value="{{ $item->pivot->quantity }}" 
                                                           class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm font-bold text-center" required>
                                                </td>
                                                <td class="px-4 py-2 text-center">
                                                    <button type="button" class="text-red-400 hover:text-red-600 p-2 rounded-full hover:bg-red-50 transition remove-row">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="flex justify-end gap-4 pt-6 border-t border-gray-100">
                            <a href="{{ route('transactions.index') }}" class="px-6 py-2 bg-gray-200 text-gray-700 font-bold rounded shadow-sm hover:bg-gray-300 transition">
                                Batal
                            </a>
                            <button type="submit" class="px-6 py-2 bg-blue-600 text-white font-bold rounded shadow-md hover:bg-blue-700 transition transform hover:scale-105">
                                <i class="fas fa-save mr-2"></i> Simpan Perubahan
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
                    <tr class="product-row group hover:bg-yellow-50 transition border-t border-gray-100">
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
                            <input type="number" name="products[${rowCount}][quantity]" min="1" value="1" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm font-bold text-center" required>
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