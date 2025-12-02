<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
            <i class="fas fa-file-invoice text-blue-600"></i>
            {{ __('Detail Transaksi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            <div class="mb-6">
                <a href="{{ route('transactions.index') }}" class="text-gray-500 hover:text-blue-600 font-bold flex items-center gap-2 transition">
                    <i class="fas fa-arrow-left"></i> Kembali ke Daftar
                </a>
            </div>

            <div class="bg-white shadow-lg rounded-xl overflow-hidden border-t-4 {{ $transaction->type == 'incoming' ? 'border-blue-500' : 'border-orange-500' }}">
                
                <div class="p-8 border-b border-gray-100 flex justify-between items-start bg-gray-50">
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">No. Referensi</p>
                        <h1 class="text-3xl font-mono font-bold text-gray-800 tracking-tight">{{ $transaction->reference_number }}</h1>
                        <div class="flex items-center gap-4 mt-4 text-sm text-gray-600">
                            <div class="flex items-center gap-1">
                                <i class="far fa-calendar-alt"></i>
                                {{ \Carbon\Carbon::parse($transaction->date)->format('d F Y') }}
                            </div>
                            <div class="flex items-center gap-1">
                                <i class="far fa-user"></i>
                                {{ $transaction->user->name }}
                            </div>
                        </div>
                    </div>
                    
                    <div class="text-right">
                        @if($transaction->status == 'pending')
                            <div class="inline-flex flex-col items-end">
                                <span class="bg-yellow-100 text-yellow-800 text-xs font-bold px-3 py-1 rounded-full uppercase mb-1">Status</span>
                                <span class="text-xl font-bold text-yellow-600">PENDING</span>
                            </div>
                        @elseif($transaction->status == 'approved')
                            <div class="inline-flex flex-col items-end">
                                <span class="bg-green-100 text-green-800 text-xs font-bold px-3 py-1 rounded-full uppercase mb-1">Status</span>
                                <span class="text-xl font-bold text-green-600">SELESAI</span>
                            </div>
                        @else
                            <div class="inline-flex flex-col items-end">
                                <span class="bg-red-100 text-red-800 text-xs font-bold px-3 py-1 rounded-full uppercase mb-1">Status</span>
                                <span class="text-xl font-bold text-red-600">DITOLAK</span>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="p-4 rounded-lg bg-gray-50 border border-gray-100">
                        <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Jenis Transaksi</h3>
                        @if($transaction->type == 'incoming')
                            <div class="flex items-center gap-2 text-blue-700 mb-3">
                                <div class="p-2 bg-blue-100 rounded-lg"><i class="fas fa-arrow-down"></i></div>
                                <span class="text-lg font-bold">Barang Masuk</span>
                            </div>
                            <p class="text-xs text-gray-500 uppercase font-bold">Supplier:</p>
                            <p class="font-medium text-gray-800 text-lg">{{ $transaction->supplier->name ?? '-' }}</p>
                        @else
                            <div class="flex items-center gap-2 text-orange-700 mb-3">
                                <div class="p-2 bg-orange-100 rounded-lg"><i class="fas fa-arrow-up"></i></div>
                                <span class="text-lg font-bold">Barang Keluar</span>
                            </div>
                            <p class="text-xs text-gray-500 uppercase font-bold">Customer:</p>
                            <p class="font-medium text-gray-800 text-lg">{{ $transaction->customer_name ?? '-' }}</p>
                        @endif
                    </div>
                    
                    <div class="p-4 rounded-lg bg-gray-50 border border-gray-100">
                        <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Catatan</h3>
                        <p class="text-gray-600 italic leading-relaxed">
                            "{{ $transaction->notes ?? 'Tidak ada catatan tambahan.' }}"
                        </p>
                    </div>
                </div>

                <div class="px-8 pb-8">
                    <h3 class="text-sm font-bold text-gray-800 uppercase tracking-wider mb-4 border-b border-gray-100 pb-2">Rincian Barang</h3>
                    <div class="overflow-hidden rounded-lg border border-gray-200">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Produk</th>
                                    <th class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase">Kategori</th>
                                    <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase">Jumlah</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($transaction->products as $product)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 text-sm font-bold text-gray-800">{{ $product->name }}</td>
                                        <td class="px-6 py-4 text-sm text-center text-gray-500">
                                            <span class="px-2 py-1 bg-gray-100 rounded text-xs">{{ $product->category->name ?? '-' }}</span>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-right font-mono font-bold text-gray-900">{{ $product->pivot->quantity }} {{ $product->unit }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                @if($transaction->status == 'pending' && (Auth::user()->role == 'admin' || Auth::user()->role == 'manager'))
                    <div class="bg-yellow-50 p-6 border-t border-yellow-200 flex flex-col md:flex-row justify-between items-center gap-4">
                        <div class="flex items-center gap-3">
                            <div class="bg-yellow-200 p-2 rounded-full text-yellow-700">
                                <i class="fas fa-user-check fa-lg"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-yellow-900">Menunggu Persetujuan</h4>
                                <p class="text-sm text-yellow-700">Verifikasi transaksi ini untuk memperbarui stok fisik.</p>
                            </div>
                        </div>
                        <div class="flex gap-3">
                            <form action="{{ route('transactions.update', $transaction) }}" method="POST" 
                                  class="confirm-form"
                                  data-title="Tolak Transaksi?" 
                                  data-text="Transaksi akan ditandai sebagai Ditolak." 
                                  data-color="#ef4444">
                                @csrf @method('PUT')
                                <input type="hidden" name="status" value="rejected">
                                <button type="submit" class="px-5 py-2 bg-white border border-red-300 text-red-600 font-bold rounded-lg hover:bg-red-50 transition shadow-sm">
                                    ✖ Tolak
                                </button>
                            </form>

                            <form action="{{ route('transactions.update', $transaction) }}" method="POST" 
                                  class="confirm-form"
                                  data-title="Setujui Transaksi?" 
                                  data-text="Stok barang akan otomatis diperbarui!" 
                                  data-color="#16a34a">
                                @csrf @method('PUT')
                                <input type="hidden" name="status" value="approved">
                                <button type="submit" class="px-5 py-2 bg-green-600 text-white font-bold rounded-lg hover:bg-green-700 shadow-md transition transform hover:scale-105">
                                    ✔ Setujui & Update Stok
                                </button>
                            </form>
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>