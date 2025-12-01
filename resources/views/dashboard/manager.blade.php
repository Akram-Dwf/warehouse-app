<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
            <i class="fas fa-user-tie text-blue-600"></i>
            {{ __('Dashboard Manager') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white rounded-lg shadow-sm p-6 border-l-4 border-blue-600 flex items-center justify-between hover:shadow-md transition">
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total Produk</p>
                        <p class="text-3xl font-bold text-gray-800 mt-1">{{ $data['total_products'] }}</p>
                    </div>
                    <div class="p-3 bg-blue-50 rounded-full text-blue-600">
                        <i class="fas fa-cubes fa-lg"></i>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm p-6 border-l-4 border-yellow-500 flex items-center justify-between hover:shadow-md transition">
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Perlu Approval</p>
                        <p class="text-3xl font-bold text-gray-800 mt-1">{{ $data['pending_transactions'] }}</p>
                        @if($data['pending_transactions'] > 0)
                            <a href="{{ route('transactions.index') }}" class="text-xs font-bold text-blue-600 hover:underline mt-1 inline-block">
                                Proses Sekarang <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        @endif
                    </div>
                    <div class="p-3 bg-yellow-50 rounded-full text-yellow-600">
                        <i class="fas fa-clipboard-check fa-lg"></i>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm p-6 border-l-4 border-indigo-500 flex items-center justify-between hover:shadow-md transition">
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Restock Berjalan</p>
                        <p class="text-3xl font-bold text-gray-800 mt-1">{{ $data['ongoing_restocks'] }}</p>
                        @if($data['ongoing_restocks'] > 0)
                            <a href="{{ route('restocks.index') }}" class="text-xs font-bold text-indigo-600 hover:underline mt-1 inline-block">
                                Cek Status <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        @endif
                    </div>
                    <div class="p-3 bg-indigo-50 rounded-full text-indigo-600">
                        <i class="fas fa-shipping-fast fa-lg"></i>
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
                                        <th class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Status Stok</th>
                                        <th class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($data['low_stock_products'] as $product)
                                        <tr class="hover:bg-red-50 transition duration-150">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="text-sm font-bold text-gray-900">{{ $product->name }}</span>
                                                <br>
                                                <span class="text-xs text-gray-500 font-mono">{{ $product->sku }}</span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold {{ $product->stock == 0 ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800' }}">
                                                    {{ $product->stock }} / {{ $product->min_stock }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                                <a href="{{ route('restocks.create') }}" class="text-blue-600 hover:text-blue-800 text-xs font-bold border border-blue-200 bg-blue-50 px-3 py-1 rounded hover:bg-blue-100 transition">
                                                    <i class="fas fa-plus-circle mr-1"></i> Restock
                                                </a>
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
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>