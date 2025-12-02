<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
            <i class="fas fa-info-circle text-blue-600"></i>
            {{ __('Detail Produk') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg border-t-4 border-blue-600">
                <div class="p-8 text-gray-900">
                    
                    <div class="flex justify-between items-start mb-8 border-b border-gray-100 pb-6">
                        <div>
                            <h1 class="text-3xl font-extrabold text-gray-900 flex items-center gap-3">
                                {{ $product->name }}
                                @if($product->stock <= $product->min_stock)
                                    <span class="bg-red-100 text-red-600 text-xs font-bold px-2 py-1 rounded uppercase tracking-wider">Low Stock</span>
                                @endif
                            </h1>
                            <p class="text-sm text-gray-500 mt-1 flex items-center gap-2">
                                <i class="fas fa-barcode"></i> SKU: 
                                <span class="font-mono bg-gray-100 px-2 py-0.5 rounded border border-gray-200 text-gray-700 font-bold">{{ $product->sku }}</span>
                            </p>
                        </div>
                        <a href="{{ route('products.index') }}" class="text-gray-500 hover:text-blue-600 font-bold flex items-center gap-1 transition">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                        <div class="md:col-span-1 space-y-6">
                            <div class="border-2 border-gray-100 rounded-xl p-2 bg-gray-50 shadow-inner">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-auto rounded-lg object-cover shadow-sm">
                                @else
                                    <div class="w-full h-64 bg-gray-200 rounded-lg flex flex-col items-center justify-center text-gray-400 border-2 border-dashed border-gray-300">
                                        <i class="fas fa-image fa-4x mb-2 opacity-50"></i>
                                        <span class="text-sm font-semibold">Tidak ada gambar</span>
                                    </div>
                                @endif
                            </div>
                            
                            <div class="p-5 rounded-xl border {{ $product->stock <= $product->min_stock ? 'bg-red-50 border-red-100' : 'bg-green-50 border-green-100' }}">
                                <h4 class="text-sm font-bold uppercase tracking-wider {{ $product->stock <= $product->min_stock ? 'text-red-800' : 'text-green-800' }} mb-2">
                                    Status Inventori
                                </h4>
                                <div class="flex items-center justify-between">
                                    <span class="text-2xl font-extrabold {{ $product->stock <= $product->min_stock ? 'text-red-600' : 'text-green-600' }}">
                                        {{ $product->stock }} <span class="text-sm font-medium text-gray-600">{{ $product->unit }}</span>
                                    </span>
                                    <i class="fas {{ $product->stock <= $product->min_stock ? 'fa-exclamation-circle text-red-400' : 'fa-check-circle text-green-400' }} fa-2x"></i>
                                </div>
                                <p class="text-xs mt-2 {{ $product->stock <= $product->min_stock ? 'text-red-600' : 'text-green-600' }}">
                                    Min. Stok: {{ $product->min_stock }} {{ $product->unit }}
                                </p>
                                
                                @if($product->stock <= $product->min_stock)
                                    @if(Auth::user()->role == 'manager')
                                        <a href="{{ route('restocks.create') }}" class="mt-4 block w-full text-center bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-lg shadow transition transform hover:scale-105">
                                            <i class="fas fa-truck-loading mr-1"></i> Buat Restock Order
                                        </a>
                                    @elseif(Auth::user()->role == 'admin')
                                        <div class="mt-4 text-center text-xs text-red-500 italic border-t border-red-200 pt-2">
                                            *Menunggu Manager melakukan restock
                                        </div>
                                    @endif
                                @endif
                            </div>
                        </div>

                        <div class="md:col-span-2">
                            <div class="bg-gray-50 rounded-xl p-6 border border-gray-100 mb-8">
                                <h3 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-4 border-b border-gray-200 pb-2">Spesifikasi Produk</h3>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-6 gap-x-4">
                                    <div>
                                        <label class="block text-xs text-gray-400 uppercase">Kategori</label>
                                        <p class="text-base font-bold text-gray-800 flex items-center gap-2">
                                            <i class="fas fa-tag text-blue-400 text-xs"></i> 
                                            {{ $product->category->name ?? 'Tidak ada Kategori' }}
                                        </p>
                                    </div>
                                    <div>
                                        <label class="block text-xs text-gray-400 uppercase">Lokasi Rak</label>
                                        <p class="text-base font-bold text-gray-800 flex items-center gap-2">
                                            <i class="fas fa-map-marker-alt text-red-400 text-xs"></i> 
                                            {{ $product->location ?? '-' }}
                                        </p>
                                    </div>
                                    <div>
                                        <label class="block text-xs text-gray-400 uppercase">Harga Beli</label>
                                        <p class="text-base font-medium text-gray-600">Rp {{ number_format($product->purchase_price, 0, ',', '.') }}</p>
                                    </div>
                                    <div>
                                        <label class="block text-xs text-gray-400 uppercase">Harga Jual</label>
                                        <p class="text-xl font-bold text-blue-600">Rp {{ number_format($product->selling_price, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                                <div class="mt-6 pt-4 border-t border-gray-200">
                                    <label class="block text-xs text-gray-400 uppercase mb-1">Deskripsi</label>
                                    <p class="text-gray-700 leading-relaxed text-sm">{{ $product->description ?? 'Tidak ada deskripsi.' }}</p>
                                </div>
                            </div>

                            <div>
                                <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                                    <i class="fas fa-history text-gray-400"></i> Riwayat Transaksi (5 Terakhir)
                                </h3>
                                
                                <div class="bg-white border border-gray-200 rounded-lg overflow-hidden shadow-sm">
                                    @if(isset($lastTransactions) && $lastTransactions->count() > 0)
                                        <table class="min-w-full divide-y divide-gray-200">
                                            <thead class="bg-gray-50">
                                                <tr>
                                                    <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">Tanggal</th>
                                                    <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">Tipe</th>
                                                    <th class="px-4 py-3 text-center text-xs font-bold text-gray-500 uppercase">Jumlah</th>
                                                    <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">Oleh</th>
                                                </tr>
                                            </thead>
                                            <tbody class="divide-y divide-gray-200">
                                                @foreach($lastTransactions as $trx)
                                                    <tr class="hover:bg-gray-50 transition">
                                                        <td class="px-4 py-3 text-sm text-gray-600">
                                                            {{ \Carbon\Carbon::parse($trx->date)->format('d M Y') }}
                                                        </td>
                                                        <td class="px-4 py-3 text-sm">
                                                            @if($trx->type == 'incoming')
                                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">
                                                                    ⬇️ MASUK
                                                                </span>
                                                            @else
                                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-orange-100 text-orange-800">
                                                                    ⬆️ KELUAR
                                                                </span>
                                                            @endif
                                                        </td>
                                                        <td class="px-4 py-3 text-sm text-center font-bold text-gray-800">
                                                            {{ $trx->pivot->quantity }} {{ $product->unit }}
                                                        </td>
                                                        <td class="px-4 py-3 text-sm text-gray-500">
                                                            {{ $trx->user->name ?? 'Sistem' }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    @else
                                        <div class="p-8 text-center">
                                            <p class="text-gray-400 italic text-sm">Belum ada riwayat transaksi untuk produk ini.</p>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="mt-8 flex items-center gap-4 pt-6 border-t border-gray-100">
                                <a href="{{ route('products.edit', $product) }}" class="flex items-center gap-2 bg-yellow-100 text-yellow-700 hover:bg-yellow-200 font-bold py-2 px-6 rounded-lg transition">
                                    <i class="fas fa-pencil-alt"></i> Edit Produk
                                </a>
                                
                                <form action="{{ route('products.destroy', $product) }}" method="POST" class="delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="flex items-center gap-2 bg-red-100 text-red-700 hover:bg-red-200 font-bold py-2 px-6 rounded-lg transition">
                                        <i class="fas fa-trash-alt"></i> Hapus Produk
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>