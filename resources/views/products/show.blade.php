<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Produk') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <div class="flex justify-between items-start mb-6 border-b pb-4">
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900">{{ $product->name }}</h1>
                            <p class="text-sm text-gray-500">SKU: <span class="font-mono bg-gray-100 px-2 py-0.5 rounded">{{ $product->sku }}</span></p>
                        </div>
                        <a href="{{ route('products.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded text-sm">
                            &laquo; Kembali
                        </a>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <div class="md:col-span-1">
                            <div class="border rounded-lg p-2 bg-gray-50">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-auto rounded object-cover">
                                @else
                                    <div class="w-full h-64 bg-gray-200 flex items-center justify-center rounded text-gray-400 flex-col">
                                        <i class="fas fa-image fa-3x mb-2"></i>
                                        <span>Tidak ada gambar</span>
                                    </div>
                                @endif
                            </div>
                            
                            <div class="mt-4 p-4 rounded-lg {{ $product->stock <= $product->min_stock ? 'bg-red-100 border border-red-200' : 'bg-green-100 border border-green-200' }}">
                                <p class="text-sm font-bold {{ $product->stock <= $product->min_stock ? 'text-red-700' : 'text-green-700' }}">
                                    Status Stok: 
                                    {{ $product->stock <= $product->min_stock ? 'Menipis (Low Stock)' : 'Aman (In Stock)' }}
                                </p>
                                
                                @if($product->stock <= $product->min_stock)
                                    
                                    @if(Auth::user()->role == 'manager')
                                        <a href="{{ route('restocks.create') }}" class="mt-2 block w-full text-center bg-red-600 hover:bg-red-700 text-white font-bold py-1 px-3 rounded text-sm shadow transition transform hover:scale-105">
                                            Buat Restock Order
                                        </a>
                                    @elseif(Auth::user()->role == 'admin')
                                        <p class="mt-2 text-xs text-red-600 italic text-center border border-red-200 bg-red-50 p-1 rounded">
                                            Info: Stok kritis. Menunggu Manager restock.
                                        </p>
                                    @endif

                                @endif
                            </div>
                        </div>

                        <div class="md:col-span-2">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-6">
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase">Kategori</label>
                                    <p class="text-lg text-gray-900">{{ $product->category->name ?? 'Tidak ada Kategori' }}</p>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase">Lokasi Rak</label>
                                    <p class="text-lg text-gray-900">{{ $product->location ?? '-' }}</p>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase">Stok Saat Ini</label>
                                    <p class="text-2xl font-bold text-gray-900">{{ $product->stock }} <span class="text-sm font-normal text-gray-600">{{ $product->unit }}</span></p>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase">Stok Minimum</label>
                                    <p class="text-lg text-gray-900">{{ $product->min_stock }} {{ $product->unit }}</p>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase">Harga Beli</label>
                                    <p class="text-lg text-gray-900">Rp {{ number_format($product->purchase_price, 0, ',', '.') }}</p>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase">Harga Jual</label>
                                    <p class="text-2xl font-bold text-blue-600">Rp {{ number_format($product->selling_price, 0, ',', '.') }}</p>
                                </div>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Deskripsi</label>
                                <div class="bg-gray-50 p-4 rounded border border-gray-200 text-gray-700 whitespace-pre-line">
                                    {{ $product->description ?? 'Tidak ada deskripsi.' }}
                                </div>
                            </div>

                            <div class="mt-8">
                                <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Riwayat Transaksi (5 Terakhir)</h3>
                                
                                @if(isset($lastTransactions) && $lastTransactions->count() > 0)
                                    <div class="overflow-x-auto border rounded-lg">
                                        <table class="min-w-full divide-y divide-gray-200">
                                            <thead class="bg-gray-50">
                                                <tr>
                                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Tipe</th>
                                                    <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase">Jumlah</th>
                                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Oleh</th>
                                                </tr>
                                            </thead>
                                            <tbody class="bg-white divide-y divide-gray-200">
                                                @foreach($lastTransactions as $trx)
                                                    <tr class="hover:bg-gray-50">
                                                        <td class="px-4 py-2 text-sm text-gray-600">
                                                            {{ \Carbon\Carbon::parse($trx->date)->format('d M Y') }}
                                                        </td>
                                                        <td class="px-4 py-2 text-sm">
                                                            @if($trx->type == 'incoming')
                                                                <span class="text-green-600 font-bold text-xs uppercase">Masuk</span>
                                                            @else
                                                                <span class="text-orange-600 font-bold text-xs uppercase">Keluar</span>
                                                            @endif
                                                        </td>
                                                        <td class="px-4 py-2 text-sm text-center font-bold text-gray-800">
                                                            {{ $trx->pivot->quantity }} {{ $product->unit }}
                                                        </td>
                                                        <td class="px-4 py-2 text-sm text-gray-500">
                                                            {{ $trx->user->name ?? 'Sistem' }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <div class="text-gray-500 italic text-sm p-4 bg-gray-50 text-center border rounded">
                                        Belum ada riwayat transaksi untuk produk ini.
                                    </div>
                                @endif
                            </div>

                            <div class="mt-8 flex gap-3">
                                <a href="{{ route('products.edit', $product) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-6 rounded">
                                    Edit Produk
                                </a>
                                
                                <form action="{{ route('products.destroy', $product) }}" method="POST" class="delete-form inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-6 rounded">
                                        Hapus Produk
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