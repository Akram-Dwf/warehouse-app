<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Supplier') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-8 border-l-4 border-purple-500">
                <div class="p-6 border-b border-gray-200 flex justify-between items-center bg-gray-50">
                    <h3 class="text-lg font-bold text-gray-800">Pesanan Perlu Konfirmasi (Pending)</h3>
                    @if(count($data['pending_restocks']) > 0)
                        <span class="bg-red-100 text-red-800 text-xs font-bold px-3 py-1 rounded-full animate-pulse">
                            {{ count($data['pending_restocks']) }} Pesanan Baru
                        </span>
                    @endif
                </div>
                <div class="p-6">
                    @if(count($data['pending_restocks']) > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Tanggal Order</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">No. PO</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Estimasi Sampai</th>
                                        <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @foreach($data['pending_restocks'] as $restock)
                                        <tr class="hover:bg-purple-50 transition">
                                            <td class="px-4 py-2 text-sm text-gray-900">{{ \Carbon\Carbon::parse($restock->date)->format('d M Y') }}</td>
                                            <td class="px-4 py-2 text-sm font-mono font-bold text-purple-700">{{ $restock->po_number }}</td>
                                            <td class="px-4 py-2 text-sm text-gray-500">{{ $restock->expected_delivery_date ? \Carbon\Carbon::parse($restock->expected_delivery_date)->format('d M Y') : '-' }}</td>
                                            <td class="px-4 py-2 text-center">
                                                <a href="{{ route('restocks.show', $restock) }}" class="inline-block px-4 py-1 bg-purple-600 text-white text-xs font-bold rounded hover:bg-purple-700 shadow transition">
                                                    Proses Pesanan
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-6 bg-gray-50 rounded-lg border border-dashed border-gray-300">
                            <p class="text-gray-500 text-sm">Tidak ada pesanan baru yang perlu dikonfirmasi saat ini.</p>
                        </div>
                    @endif
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 border-b border-gray-200 bg-gray-50">
                    <h3 class="text-lg font-bold text-gray-800">Riwayat Pesanan & Pengiriman Terakhir</h3>
                </div>
                <div class="p-6">
                    @if(count($data['completed_restocks']) > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">No. PO</th>
                                        <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase">Status</th>
                                        <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @foreach($data['completed_restocks'] as $restock)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-4 py-2 text-sm text-gray-600">{{ \Carbon\Carbon::parse($restock->date)->format('d M Y') }}</td>
                                            <td class="px-4 py-2 text-sm font-mono font-medium text-gray-800">{{ $restock->po_number }}</td>
                                            <td class="px-4 py-2 text-center">
                                                @if($restock->status == 'confirmed')
                                                    <span style="background-color: #dbeafe; color: #1e40af; padding: 2px 8px; border-radius: 4px; font-size: 10px; font-weight: bold; text-transform: uppercase;">Confirmed</span>
                                                @elseif($restock->status == 'in_transit')
                                                    <span style="background-color: #f3e8ff; color: #6b21a8; padding: 2px 8px; border-radius: 4px; font-size: 10px; font-weight: bold; text-transform: uppercase;">In Transit</span>
                                                @elseif($restock->status == 'received')
                                                    <span style="background-color: #dcfce7; color: #166534; padding: 2px 8px; border-radius: 4px; font-size: 10px; font-weight: bold; text-transform: uppercase;">Received</span>
                                                @elseif($restock->status == 'rejected')
                                                    <span style="background-color: #fee2e2; color: #991b1b; padding: 2px 8px; border-radius: 4px; font-size: 10px; font-weight: bold; text-transform: uppercase;">Ditolak</span>
                                                @endif
                                            </td>
                                            <td class="px-4 py-2 text-center">
                                                <a href="{{ route('restocks.show', $restock) }}" class="text-blue-600 hover:text-blue-800 text-xs font-bold hover:underline">Detail</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-gray-500 text-center py-4 italic">Belum ada riwayat pengiriman.</p>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>