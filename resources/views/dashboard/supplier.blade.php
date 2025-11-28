<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Supplier') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6 border-l-4 border-purple-500">
                <h3 class="text-lg font-bold text-gray-800">Selamat Datang, Mitra Supplier!</h3>
                <p class="text-gray-600">Silakan cek pesanan masuk yang perlu dikonfirmasi di bawah ini.</p>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 border-b border-gray-200 flex justify-between items-center bg-gray-50">
                    <h3 class="text-lg font-bold text-gray-800">Pesanan Perlu Konfirmasi (Pending)</h3>
                    @if(count($data['pending_restocks']) > 0)
                        <span class="bg-red-100 text-red-800 text-xs font-bold px-3 py-1 rounded-full animate-pulse">{{ count($data['pending_restocks']) }} Pesanan Baru</span>
                    @endif
                </div>
                <div class="p-6">
                    @if(count($data['pending_restocks']) > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead>
                                    <tr>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">No. PO</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Estimasi Sampai</th>
                                        <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @foreach($data['pending_restocks'] as $restock)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-4 py-2 text-sm text-gray-900">{{ \Carbon\Carbon::parse($restock->date)->format('d M Y') }}</td>
                                            <td class="px-4 py-2 text-sm font-mono font-bold text-blue-600">{{ $restock->po_number }}</td>
                                            <td class="px-4 py-2 text-sm text-gray-500">{{ $restock->expected_delivery_date ? \Carbon\Carbon::parse($restock->expected_delivery_date)->format('d M Y') : '-' }}</td>
                                            <td class="px-4 py-2 text-center">
                                                <a href="{{ route('restocks.show', $restock) }}" class="inline-block px-4 py-1 bg-green-600 text-white text-xs font-bold rounded hover:bg-green-700 shadow transition">
                                                    Proses Pesanan
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-8">
                            <p class="text-green-600 font-medium">Tidak ada pesanan baru saat ini.</p>
                            <p class="text-gray-400 text-sm">Terima kasih telah memproses semua pesanan.</p>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>