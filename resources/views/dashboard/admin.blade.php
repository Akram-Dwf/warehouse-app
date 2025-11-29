<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Admin') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-blue-500">
                    <div class="text-gray-500 text-sm font-medium uppercase">Total Produk</div>
                    <div class="text-2xl font-bold text-gray-800 mt-2">{{ $data['total_products'] }}</div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-green-500">
                    <div class="text-gray-500 text-sm font-medium uppercase">Transaksi Bulan Ini</div>
                    <div class="text-2xl font-bold text-gray-800 mt-2">{{ $data['transactions_this_month'] }}</div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-purple-500">
                    <div class="text-gray-500 text-sm font-medium uppercase">Nilai Inventori</div>
                    <div class="text-xl font-bold text-gray-800 mt-2">
                        Rp {{ number_format($data['inventory_value'], 0, ',', '.') }}
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-gray-500">
                    <div class="text-gray-500 text-sm font-medium uppercase">Total Pengguna</div>
                    <div class="text-2xl font-bold text-gray-800 mt-2">{{ $data['total_users'] }}</div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-bold text-red-600 flex items-center">
                        <i class="fas fa-exclamation-triangle mr-2"></i> Peringatan Stok Menipis
                    </h3>
                </div>
                <div class="p-6">
                    @if(count($data['low_stock_products']) > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead>
                                    <tr>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Produk</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Kategori</th>
                                        <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase">Stok Saat Ini</th>
                                        <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase">Min. Stok</th>
                                        <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @foreach($data['low_stock_products'] as $product)
                                        <tr>
                                            <td class="px-4 py-2 text-sm font-medium text-gray-900">{{ $product->name }}</td>
                                            <td class="px-4 py-2 text-sm text-gray-500">{{ $product->category->name ?? '-' }}</td>
                                            <td class="px-4 py-2 text-center">
                                                <span class="bg-red-100 text-red-800 text-xs font-bold px-2 py-1 rounded">
                                                    {{ $product->stock }} {{ $product->unit }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-2 text-center text-sm text-gray-500">{{ $product->min_stock }}</td>
                                            <td class="px-4 py-2 text-center">
                                                <a href="{{ route('restocks.create') }}" class="text-blue-600 hover:text-blue-900 text-xs font-bold">Buat PO Restock</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-green-600 text-sm">Aman! Tidak ada produk yang stoknya di bawah batas minimum.</p>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>