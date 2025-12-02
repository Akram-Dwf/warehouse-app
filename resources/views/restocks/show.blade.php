<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
            <i class="fas fa-file-invoice-dollar text-blue-600"></i>
            {{ __('Detail Restock Order') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            <div class="mb-6">
                <a href="{{ route('restocks.index') }}" class="text-gray-500 hover:text-blue-600 font-bold flex items-center gap-2 transition">
                    <i class="fas fa-arrow-left"></i> Kembali ke Daftar
                </a>
            </div>

            <div class="bg-white shadow-lg rounded-xl overflow-hidden border-t-4 border-purple-600">
                
                <div class="p-8 border-b border-gray-100 flex justify-between items-start bg-gray-50">
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">No. Purchase Order</p>
                        <h1 class="text-3xl font-mono font-bold text-gray-800 tracking-tight">{{ $restock->po_number }}</h1>
                        <div class="flex items-center gap-4 mt-4 text-sm text-gray-600">
                            <div class="flex items-center gap-1">
                                <i class="far fa-calendar-alt"></i>
                                {{ \Carbon\Carbon::parse($restock->date)->format('d F Y') }}
                            </div>
                            <div class="flex items-center gap-1">
                                <i class="fas fa-shipping-fast"></i>
                                Est: {{ $restock->expected_delivery_date ? \Carbon\Carbon::parse($restock->expected_delivery_date)->format('d M Y') : '-' }}
                            </div>
                        </div>
                    </div>
                    
                    <div class="text-right">
                        @if($restock->status == 'pending')
                            <div class="inline-flex flex-col items-end">
                                <span class="bg-yellow-100 text-yellow-800 text-xs font-bold px-3 py-1 rounded-full uppercase mb-1">Status</span>
                                <span class="text-xl font-bold text-yellow-600">PENDING</span>
                            </div>
                        @elseif($restock->status == 'confirmed')
                            <div class="inline-flex flex-col items-end">
                                <span class="bg-blue-100 text-blue-800 text-xs font-bold px-3 py-1 rounded-full uppercase mb-1">Status</span>
                                <span class="text-xl font-bold text-blue-600">CONFIRMED</span>
                            </div>
                        @elseif($restock->status == 'in_transit')
                            <div class="inline-flex flex-col items-end">
                                <span class="bg-purple-100 text-purple-800 text-xs font-bold px-3 py-1 rounded-full uppercase mb-1">Status</span>
                                <span class="text-xl font-bold text-purple-600">IN TRANSIT</span>
                            </div>
                        @elseif($restock->status == 'received')
                            <div class="inline-flex flex-col items-end">
                                <span class="bg-green-100 text-green-800 text-xs font-bold px-3 py-1 rounded-full uppercase mb-1">Status</span>
                                <span class="text-xl font-bold text-green-600">RECEIVED</span>
                            </div>
                        @elseif($restock->status == 'rejected')
                            <div class="inline-flex flex-col items-end">
                                <span class="bg-red-100 text-red-800 text-xs font-bold px-3 py-1 rounded-full uppercase mb-1">Status</span>
                                <span class="text-xl font-bold text-red-600">REJECTED</span>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="p-4 rounded-lg bg-purple-50 border border-purple-100">
                        <h3 class="text-xs font-bold text-purple-400 uppercase tracking-wider mb-2">Supplier Tujuan</h3>
                        <p class="text-lg font-bold text-gray-900">{{ $restock->supplier->name }}</p>
                        <p class="text-sm text-gray-600 flex items-center gap-2 mt-1">
                            <i class="far fa-envelope"></i> {{ $restock->supplier->email }}
                        </p>
                    </div>
                    
                    <div class="p-4 rounded-lg bg-gray-50 border border-gray-100">
                        <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Catatan</h3>
                        <p class="text-gray-600 italic leading-relaxed">
                            "{{ $restock->notes ?? 'Tidak ada catatan.' }}"
                        </p>
                    </div>
                </div>

                <div class="px-8 pb-8">
                    <h3 class="text-sm font-bold text-gray-800 uppercase tracking-wider mb-4 border-b border-gray-100 pb-2">Item yang Dipesan</h3>
                    <div class="overflow-hidden rounded-lg border border-gray-200">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Produk</th>
                                    <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase">Jumlah Order</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($restock->products as $product)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 font-bold text-gray-800 text-sm">{{ $product->name }}</td>
                                        <td class="px-6 py-4 text-right font-mono font-bold text-lg text-gray-900">{{ $product->pivot->quantity }} {{ $product->unit }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="bg-gray-50 p-6 border-t border-gray-200">
                    <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                        <div>
                            <h3 class="font-bold text-gray-800">Tindakan Lanjutan</h3>
                            <p class="text-sm text-gray-500">Kelola status pesanan ini sesuai peran Anda.</p>
                        </div>

                        <div class="flex gap-3">
                            
                            @if(Auth::user()->role == 'supplier' && $restock->status == 'pending')
                                <form action="{{ route('restocks.update', $restock) }}" method="POST" 
                                      class="confirm-form" 
                                      data-title="Konfirmasi Pesanan?" 
                                      data-text="Pesanan akan ditandai sebagai Disetujui." 
                                      data-color="#16a34a">
                                    @csrf @method('PUT')
                                    <input type="hidden" name="status" value="confirmed">
                                    <button type="submit" class="px-5 py-2 bg-green-600 text-white rounded-lg font-bold hover:bg-green-700 shadow transition transform hover:scale-105">
                                        ✔ Konfirmasi
                                    </button>
                                </form>
                                
                                <form action="{{ route('restocks.update', $restock) }}" method="POST" 
                                      class="confirm-form"
                                      data-title="Tolak Pesanan?" 
                                      data-text="Pesanan akan ditandai sebagai Ditolak." 
                                      data-color="#dc2626">
                                    @csrf @method('PUT')
                                    <input type="hidden" name="status" value="rejected">
                                    <button type="submit" class="px-5 py-2 bg-white border border-red-300 text-red-600 rounded-lg font-bold hover:bg-red-50 shadow-sm transition">
                                        ✖ Tolak
                                    </button>
                                </form>
                            
                            @elseif((Auth::user()->role == 'manager' || Auth::user()->role == 'admin') && in_array($restock->status, ['confirmed', 'in_transit', 'received']))
                                
                                @if($restock->status == 'confirmed')
                                    <form action="{{ route('restocks.update', $restock) }}" method="POST" 
                                          class="confirm-form"
                                          data-title="Kirim Barang?" 
                                          data-text="Status akan diubah menjadi SEDANG DIKIRIM." 
                                          data-color="#9333ea">
                                        @csrf @method('PUT')
                                        <input type="hidden" name="status" value="in_transit">
                                        <button type="submit" class="px-5 py-2 bg-purple-600 text-white rounded-lg font-bold hover:bg-purple-700 shadow transition transform hover:scale-105">
                                            🚚 Update: Sedang Dikirim
                                        </button>
                                    </form>
                                @elseif(in_array($restock->status, ['in_transit', 'received']))
                                    <button type="button" class="px-5 py-2 bg-gray-200 text-gray-400 rounded-lg font-bold cursor-not-allowed shadow-inner" disabled>
                                        🚚 Sudah Dikirim
                                    </button>
                                @endif

                                @if($restock->status == 'in_transit')
                                    <form action="{{ route('restocks.update', $restock) }}" method="POST" 
                                          class="confirm-form"
                                          data-title="Terima Barang?" 
                                          data-text="Pastikan barang fisik sudah sampai. Status akan menjadi DITERIMA." 
                                          data-color="#16a34a">
                                        @csrf @method('PUT')
                                        <input type="hidden" name="status" value="received">
                                        <button type="submit" class="px-5 py-2 bg-green-600 text-white rounded-lg font-bold hover:bg-green-700 shadow transition transform hover:scale-105">
                                            📦 Barang Diterima (Selesai)
                                        </button>
                                    </form>
                                @elseif($restock->status == 'received')
                                    <button type="button" class="px-5 py-2 bg-green-800 text-white rounded-lg font-bold cursor-default shadow-md" disabled>
                                        ✔ Selesai (Diterima)
                                    </button>
                                @else
                                    <button type="button" class="px-5 py-2 bg-gray-200 text-gray-400 rounded-lg font-bold cursor-not-allowed shadow-inner" disabled>
                                        📦 Barang Diterima
                                    </button>
                                @endif

                            @else
                                <span class="text-gray-400 italic text-sm">Menunggu tindakan pihak lain...</span>
                            @endif
                        </div>
                    </div>
                    
                    @if($restock->status == 'received')
                        <div class="mt-4 bg-green-50 text-green-700 p-3 rounded border border-green-200 text-sm text-center">
                            <strong>Info:</strong> Proses administrasi Restock selesai. Silakan buat Transaksi Masuk untuk menambah stok fisik.
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>
    
    </x-app-layout>