<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
            <i class="fas fa-truck-loading text-blue-600"></i>
            {{ __('Dashboard Supplier') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white border-l-4 border-purple-600 rounded-lg shadow-sm p-6 mb-8 flex items-start gap-4">
                <div class="p-3 bg-purple-100 rounded-full text-purple-600 shrink-0">
                    <i class="fas fa-handshake fa-2x"></i>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-gray-800">Selamat Datang, Mitra Supplier!</h3>
                    <p class="text-gray-600 mt-1">Silakan cek tabel di bawah untuk pesanan masuk yang perlu dikonfirmasi.</p>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-purple-200 overflow-hidden mb-8">
                <div class="px-6 py-4 border-b border-purple-100 bg-purple-50 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-purple-900 flex items-center gap-2">
                        <i class="fas fa-bell"></i> Pesanan Perlu Konfirmasi (Pending)
                    </h3>
                    @if(count($data['pending_restocks']) > 0)
                        <span class="bg-red-500 text-white text-xs font-bold px-3 py-1 rounded-full animate-pulse shadow-sm">
                            {{ count($data['pending_restocks']) }} Pesanan Baru
                        </span>
                    @endif
                </div>
                
                <div class="p-0">
                    @if(count($data['pending_restocks']) > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Tanggal Order</th>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">No. PO</th>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Estimasi Sampai</th>
                                        <th class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($data['pending_restocks'] as $restock)
                                        <tr class="hover:bg-purple-50 transition">
                                            <td class="px-6 py-4 text-sm text-gray-900">{{ \Carbon\Carbon::parse($restock->date)->format('d M Y') }}</td>
                                            <td class="px-6 py-4 text-sm font-mono font-bold text-purple-700">{{ $restock->po_number }}</td>
                                            <td class="px-6 py-4 text-sm text-gray-500">{{ $restock->expected_delivery_date ? \Carbon\Carbon::parse($restock->expected_delivery_date)->format('d M Y') : '-' }}</td>
                                            <td class="px-6 py-4 text-center">
                                                <a href="{{ route('restocks.show', $restock) }}" class="inline-flex items-center gap-1 px-4 py-1 bg-purple-600 text-white text-xs font-bold rounded hover:bg-purple-700 shadow transition">
                                                    <i class="fas fa-edit"></i> Proses
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-8 bg-gray-50">
                            <div class="inline-block p-3 rounded-full bg-green-100 text-green-500 mb-2">
                                <i class="fas fa-check fa-lg"></i>
                            </div>
                            <p class="text-gray-500 font-medium">Semua pesanan sudah diproses.</p>
                        </div>
                    @endif
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 flex items-center gap-2">
                    <i class="fas fa-history text-gray-400"></i>
                    <h3 class="text-lg font-bold text-gray-800">Riwayat Pesanan & Pengiriman Terakhir</h3>
                </div>
                
                <div class="p-0">
                    @if(count($data['completed_restocks']) > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Tanggal</th>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">No. PO</th>
                                        <th class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($data['completed_restocks'] as $restock)
                                        <tr class="hover:bg-gray-50 transition">
                                            <td class="px-6 py-4 text-sm text-gray-600">{{ \Carbon\Carbon::parse($restock->date)->format('d M Y') }}</td>
                                            <td class="px-6 py-4 text-sm font-mono font-medium text-gray-800">{{ $restock->po_number }}</td>
                                            <td class="px-6 py-4 text-center">
                                                @if($restock->status == 'confirmed')
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-blue-100 text-blue-800 border border-blue-200">CONFIRMED</span>
                                                @elseif($restock->status == 'in_transit')
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-purple-100 text-purple-800 border border-purple-200">IN TRANSIT</span>
                                                @elseif($restock->status == 'received')
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-green-100 text-green-800 border border-green-200">RECEIVED</span>
                                                @elseif($restock->status == 'rejected')
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-red-100 text-red-800 border border-red-200">REJECTED</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 text-center">
                                                <a href="{{ route('restocks.show', $restock) }}" class="text-gray-400 hover:text-blue-600 transition" title="Detail">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-gray-500 text-center py-8 italic">Belum ada riwayat pengiriman.</p>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>