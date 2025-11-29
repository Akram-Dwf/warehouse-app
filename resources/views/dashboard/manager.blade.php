<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Manager') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-blue-500">
                    <div class="text-gray-500 text-sm font-medium uppercase">Total Produk</div>
                    <div class="text-3xl font-bold text-gray-800 mt-2">{{ $data['total_products'] }}</div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-yellow-500">
                    <div class="text-gray-500 text-sm font-medium uppercase">Perlu Approval</div>
                    <div class="text-3xl font-bold text-gray-800 mt-2">{{ $data['pending_transactions'] }}</div>
                    @if($data['pending_transactions'] > 0)
                        <a href="{{ route('transactions.index') }}" class="text-xs text-blue-600 hover:underline mt-1 block">Lihat Transaksi &rarr;</a>
                    @endif
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-indigo-500">
                    <div class="text-gray-500 text-sm font-medium uppercase">Restock Berjalan</div>
                    <div class="text-3xl font-bold text-gray-800 mt-2">{{ $data['ongoing_restocks'] }}</div>
                    @if($data['ongoing_restocks'] > 0)
                        <a href="{{ route('restocks.index') }}" class="text-xs text-indigo-600 hover:underline mt-1 block">Cek Status &rarr;</a>
                    @endif
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-bold text-red-600 flex items-center">
                        <i class="fas fa-exclamation-triangle mr-2"></i> Perhatian: Stok Menipis
                    </h3>
                </div>
                <div class="p-6">
                    @if(count($data['low_stock_products']) > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead>
                                    <tr>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">Produk</th>
                                        <th class="px-4 py-2 text-center text-xs font-medium text-gray-500">Stok</th>
                                        <th class="px-4 py-2 text-center text-xs font-medium text-gray-500">Min. Stok</th>
                                        <th class="px-4 py-2 text-center text-xs font-medium text-gray-500">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @foreach($data['low_stock_products'] as $product)
                                        <tr>
                                            <td class="px-4 py-2 text-sm font-medium text-gray-900">{{ $product->name }}</td>
                                            <td class="px-4 py-2 text-center text-red-600 font-bold">{{ $product->stock }}</td>
                                            <td class="px-4 py-2 text-center text-sm text-gray-500">{{ $product->min_stock }}</td>
                                            <td class="px-4 py-2 text-center">
                                                <a href="{{ route('restocks.create') }}" class="inline-block px-3 py-1 bg-blue-600 text-white text-xs rounded hover:bg-blue-700">Buat PO Restock</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-green-600 text-sm">Semua stok aman.</p>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>