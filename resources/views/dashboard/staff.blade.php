<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Staff') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6 flex justify-between items-center border-l-4 border-blue-500">
                <div>
                    <h3 class="text-lg font-bold text-gray-800">Halo, {{ Auth::user()->name }}!</h3>
                    <p class="text-gray-600">Siap mencatat barang masuk atau keluar hari ini?</p>
                </div>
                <a href="{{ route('transactions.create') }}" class="inline-block px-6 py-3 bg-blue-600 text-white rounded-lg font-bold hover:bg-blue-700 shadow-md transition">
                    + Buat Transaksi Baru
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-bold text-gray-800">Transaksi Saya Hari Ini</h3>
                </div>
                <div class="p-6">
                    @if(count($data['my_transactions_today']) > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">No. Ref</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Tipe</th>
                                        <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase">Status</th>
                                        <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @foreach($data['my_transactions_today'] as $trx)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-4 py-2 text-sm font-medium text-gray-900">{{ $trx->reference_number }}</td>
                                            <td class="px-4 py-2 text-sm">
                                                @if($trx->type == 'incoming')
                                                    <span class="text-blue-600 font-bold">⬇️ Masuk</span>
                                                @else
                                                    <span class="text-orange-600 font-bold">⬆️ Keluar</span>
                                                @endif
                                            </td>
                                            <td class="px-4 py-2 text-center">
                                                @if($trx->status == 'pending')
                                                    <span class="bg-yellow-100 text-yellow-800 text-xs font-bold px-2 py-1 rounded">Pending</span>
                                                @elseif($trx->status == 'approved')
                                                    <span class="bg-green-100 text-green-800 text-xs font-bold px-2 py-1 rounded">Selesai</span>
                                                @else
                                                    <span class="bg-red-100 text-red-800 text-xs font-bold px-2 py-1 rounded">Ditolak</span>
                                                @endif
                                            </td>
                                            <td class="px-4 py-2 text-center">
                                                <a href="{{ route('transactions.show', $trx) }}" class="text-blue-600 hover:text-blue-900 text-xs font-bold hover:underline">Detail</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-gray-500 text-center py-4 italic">Belum ada transaksi yang Anda buat hari ini.</p>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>