<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Transaksi') }} : {{ $transaction->reference_number }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            <div class="mb-6">
                <a href="{{ route('transactions.index') }}" class="text-gray-600 hover:text-gray-900 flex items-center">
                    &laquo; Kembali ke Daftar
                </a>
            </div>

            <div class="bg-white shadow-md rounded-lg overflow-hidden mb-6">
                <div class="p-6 border-b border-gray-200 bg-gray-50 flex justify-between items-start">
                    <div>
                        <h2 class="text-xl font-bold text-gray-800">{{ $transaction->reference_number }}</h2>
                        <p class="text-sm text-gray-500">
                            Dibuat oleh: <span class="font-semibold">{{ $transaction->user->name }}</span> | 
                            Tanggal: {{ $transaction->date }}
                        </p>
                    </div>
                    
                    <div>
                        @if($transaction->status == 'pending')
                            <span class="bg-yellow-100 text-yellow-800 text-sm font-bold px-3 py-1 rounded-full uppercase">Pending</span>
                        @elseif($transaction->status == 'approved')
                            <span class="bg-green-100 text-green-800 text-sm font-bold px-3 py-1 rounded-full uppercase">Selesai</span>
                        @else
                            <span class="bg-red-100 text-red-800 text-sm font-bold px-3 py-1 rounded-full uppercase">Ditolak</span>
                        @endif
                    </div>
                </div>

                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h3 class="text-gray-500 text-xs uppercase font-bold mb-1">Tipe Transaksi</h3>
                        @if($transaction->type == 'incoming')
                            <p class="text-blue-600 font-bold text-lg">⬇️ Barang Masuk (Incoming)</p>
                            <p class="text-sm text-gray-600 mt-2">Supplier:</p>
                            <p class="font-medium">{{ $transaction->supplier->name ?? '-' }}</p>
                        @else
                            <p class="text-orange-600 font-bold text-lg">⬆️ Barang Keluar (Outgoing)</p>
                            <p class="text-sm text-gray-600 mt-2">Customer:</p>
                            <p class="font-medium">{{ $transaction->customer_name ?? '-' }}</p>
                        @endif
                    </div>
                    <div>
                        <h3 class="text-gray-500 text-xs uppercase font-bold mb-1">Catatan</h3>
                        <p class="text-gray-700 italic bg-gray-50 p-3 rounded border">
                            "{{ $transaction->notes ?? 'Tidak ada catatan' }}"
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-white shadow-md rounded-lg overflow-hidden mb-6">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <h3 class="font-bold text-gray-800">Rincian Barang</h3>
                </div>
                <table class="min-w-full text-left text-sm">
                    <thead class="bg-gray-100 text-gray-600 uppercase font-medium">
                        <tr>
                            <th class="px-6 py-3">Nama Produk</th>
                            <th class="px-6 py-3 text-center">Kategori</th>
                            <th class="px-6 py-3 text-right">Jumlah (Qty)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($transaction->products as $product)
                            <tr>
                                <td class="px-6 py-4 font-medium text-gray-900">{{ $product->name }}</td>
                                <td class="px-6 py-4 text-center text-gray-500">{{ $product->category->name ?? '-' }}</td>
                                <td class="px-6 py-4 text-right font-bold text-lg">{{ $product->pivot->quantity }} {{ $product->unit }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($transaction->status == 'pending' && (Auth::user()->role == 'admin' || Auth::user()->role == 'manager'))
                <div class="bg-white shadow-md rounded-lg p-6 flex justify-between items-center border-l-4 border-yellow-400">
                    <div>
                        <h3 class="font-bold text-lg text-gray-800">Verifikasi Transaksi</h3>
                        <p class="text-sm text-gray-600">Tindakan ini akan memperbarui stok barang secara otomatis.</p>
                    </div>
                    <div class="flex gap-3">
                        <form action="{{ route('transactions.update', $transaction) }}" method="POST" class="reject-form">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="rejected">
                            <button type="submit" class="px-4 py-2 bg-red-100 text-red-700 font-bold rounded hover:bg-red-200 transition">
                                ✖ Tolak
                            </button>
                        </form>

                        <form action="{{ route('transactions.update', $transaction) }}" method="POST" class="approve-form">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="approved">
                            <button type="submit" class="px-4 py-2 bg-green-600 text-white font-bold rounded hover:bg-green-700 shadow-lg transition">
                                ✔ Setujui & Update Stok
                            </button>
                        </form>
                    </div>
                </div>
            @endif

        </div>
    </div>

</x-app-layout>