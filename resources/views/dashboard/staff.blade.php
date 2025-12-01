<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
            <i class="fas fa-dolly text-blue-600"></i>
            {{ __('Dashboard Staff') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-gradient-to-r from-blue-600 to-blue-800 rounded-xl shadow-lg p-6 mb-8 text-white flex justify-between items-center">
                <div>
                    <h3 class="text-2xl font-bold mb-1">Halo, {{ Auth::user()->name }}! 👋</h3>
                    <p class="text-blue-100">Siap mencatat barang masuk atau keluar hari ini?</p>
                </div>
                <a href="{{ route('transactions.create') }}" class="bg-white text-blue-700 font-bold py-3 px-6 rounded-lg shadow-md hover:bg-gray-50 transition transform hover:scale-105 flex items-center gap-2">
                    <i class="fas fa-plus-circle"></i> Buat Transaksi Baru
                </a>
            </div>

            @if(isset($data['restocks_to_process']) && count($data['restocks_to_process']) > 0)
                <div class="bg-white rounded-xl shadow-sm border border-green-200 overflow-hidden mb-8">
                    <div class="px-6 py-4 border-b border-green-100 bg-green-50 flex justify-between items-center">
                        <div class="flex items-center gap-2 text-green-800">
                            <i class="fas fa-shipping-fast fa-lg"></i>
                            <h3 class="text-lg font-bold">Barang Datang (Wajib Diproses)</h3>
                        </div>
                        <span class="bg-green-600 text-white text-xs font-bold px-3 py-1 rounded-full animate-pulse">
                            {{ count($data['restocks_to_process']) }} Menunggu
                        </span>
                    </div>
                    <div class="p-0">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">No. PO</th>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Supplier</th>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Tanggal Terima</th>
                                        <th class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($data['restocks_to_process'] as $restock)
                                        <tr class="hover:bg-green-50 transition">
                                            <td class="px-6 py-4 text-sm font-mono font-bold text-blue-600">{{ $restock->po_number }}</td>
                                            <td class="px-6 py-4 text-sm text-gray-700 font-medium">{{ $restock->supplier->name }}</td>
                                            <td class="px-6 py-4 text-sm text-gray-500">{{ $restock->updated_at->format('d M Y') }}</td>
                                            <td class="px-6 py-4 text-center">
                                                <a href="{{ route('transactions.create', ['restock_id' => $restock->id]) }}" 
                                                   class="inline-flex items-center px-4 py-2 bg-green-600 text-white text-xs font-bold rounded hover:bg-green-700 shadow transition">
                                                    <i class="fas fa-check mr-1"></i> Proses Masuk
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 flex items-center gap-2">
                    <i class="fas fa-history text-gray-400"></i>
                    <h3 class="text-lg font-bold text-gray-800">Transaksi Saya Hari Ini</h3>
                </div>
                
                <div class="p-0">
                    @if(isset($data['my_transactions_today']) && count($data['my_transactions_today']) > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">No. Ref</th>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Tipe</th>
                                        <th class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @foreach($data['my_transactions_today'] as $trx)
                                        <tr class="hover:bg-gray-50 transition">
                                            <td class="px-6 py-4 text-sm font-mono font-medium text-gray-900">{{ $trx->reference_number }}</td>
                                            <td class="px-6 py-4 text-sm">
                                                @if($trx->type == 'incoming')
                                                    <span class="text-blue-600 font-bold flex items-center gap-1"><i class="fas fa-arrow-down"></i> Masuk</span>
                                                @else
                                                    <span class="text-orange-600 font-bold flex items-center gap-1"><i class="fas fa-arrow-up"></i> Keluar</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 text-center">
                                                @if($trx->status == 'pending')
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 border border-yellow-200">Pending</span>
                                                @elseif($trx->status == 'approved')
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 border border-green-200">Selesai</span>
                                                @else
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 border border-red-200">Ditolak</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 text-center">
                                                <a href="{{ route('transactions.show', $trx) }}" class="text-gray-400 hover:text-blue-600 transition" title="Detail">
                                                    <i class="fas fa-eye fa-lg"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="p-8 text-center">
                            <div class="inline-block p-3 rounded-full bg-gray-100 text-gray-400 mb-2">
                                <i class="fas fa-clipboard-list fa-2x"></i>
                            </div>
                            <p class="text-gray-500 italic">Belum ada transaksi yang Anda buat hari ini.</p>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>