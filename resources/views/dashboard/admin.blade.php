<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
            <i class="fas fa-tachometer-alt text-blue-600"></i>
            {{ __('Dashboard Admin') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                
                <div class="bg-white rounded-lg shadow-sm p-6 border-l-4 border-blue-600 flex items-center justify-between hover:shadow-md transition">
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total Produk</p>
                        <p class="text-2xl font-bold text-gray-800 mt-1">{{ $data['total_products'] }}</p>
                    </div>
                    <div class="p-3 bg-blue-50 rounded-full text-blue-600">
                        <i class="fas fa-box fa-lg"></i>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm p-6 border-l-4 border-green-500 flex items-center justify-between hover:shadow-md transition">
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Transaksi (Bulan Ini)</p>
                        <p class="text-2xl font-bold text-gray-800 mt-1">{{ $data['transactions_this_month'] }}</p>
                    </div>
                    <div class="p-3 bg-green-50 rounded-full text-green-600">
                        <i class="fas fa-chart-line fa-lg"></i>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm p-6 border-l-4 border-indigo-500 flex items-center justify-between hover:shadow-md transition">
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Nilai Aset</p>
                        <p class="text-lg font-bold text-gray-800 mt-1 truncate" title="Rp {{ number_format($data['inventory_value'], 0, ',', '.') }}">
                            Rp {{ number_format($data['inventory_value'], 0, ',', '.') }}
                        </p>
                    </div>
                    <div class="p-3 bg-indigo-50 rounded-full text-indigo-600">
                        <i class="fas fa-wallet fa-lg"></i>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm p-6 border-l-4 border-gray-500 flex items-center justify-between hover:shadow-md transition">
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total Pengguna</p>
                        <p class="text-2xl font-bold text-gray-800 mt-1">{{ $data['total_users'] }}</p>
                    </div>
                    <div class="p-3 bg-gray-100 rounded-full text-gray-600">
                        <i class="fas fa-users fa-lg"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 bg-red-50 flex items-center gap-3">
                    <div class="bg-red-100 text-red-600 p-2 rounded-full">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Peringatan Stok Menipis</h3>
                        <p class="text-xs text-red-600">Segera lakukan restock untuk produk di bawah ini.</p>
                    </div>
                </div>
                
                <div class="p-0">
                    @if(count($data['low_stock_products']) > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Produk</th>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Kategori</th>
                                        <th class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Status Stok</th>
                                        <th class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($data['low_stock_products'] as $product)
                                        <tr class="hover:bg-red-50 transition duration-150">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-bold text-gray-900">{{ $product->name }}</div>
                                                <div class="text-xs text-gray-500 font-mono">{{ $product->sku }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                                <span class="px-2 py-1 bg-gray-100 rounded text-xs font-semibold">{{ $product->category->name ?? '-' }}</span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                                @if($product->stock == 0)
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-red-100 text-red-800 border border-red-200">
                                                        Habis (0)
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-yellow-100 text-yellow-800 border border-yellow-200">
                                                        Rendah ({{ $product->stock }} / {{ $product->min_stock }})
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                                @if(Auth::user()->role == 'manager')
                                                    <a href="{{ route('restocks.create') }}" class="text-blue-600 hover:text-blue-800 text-xs font-bold border border-blue-200 bg-blue-50 px-3 py-1 rounded hover:bg-blue-100 transition">
                                                        <i class="fas fa-plus-circle mr-1"></i> Restock
                                                    </a>
                                                @else
                                                    <span class="text-xs text-gray-400 italic">Hubungi Manager</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="p-8 text-center">
                            <div class="inline-block p-4 rounded-full bg-green-100 text-green-500 mb-3">
                                <i class="fas fa-check-circle fa-3x"></i>
                            </div>
                            <p class="text-gray-800 font-bold">Stok Aman!</p>
                            <p class="text-gray-500 text-sm">Tidak ada produk yang berada di bawah batas minimum.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>