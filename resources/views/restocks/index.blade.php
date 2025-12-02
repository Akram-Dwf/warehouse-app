<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
            <i class="fas fa-truck-loading text-blue-600"></i>
            {{ __('Restock Management') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg border-t-4 border-blue-600">
                <div class="p-6 text-gray-900">

                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h3 class="text-lg font-bold text-gray-800">Daftar Permintaan Restock (PO)</h3>
                            <p class="text-sm text-gray-500">Kelola pesanan barang ke Supplier.</p>
                        </div>
                        
                        @if(Auth::user()->role == 'admin' || Auth::user()->role == 'manager')
                            <a href="{{ route('restocks.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-700 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-800 focus:bg-blue-800 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-md">
                                <i class="fas fa-plus mr-2"></i> Buat Restock Order
                            </a>
                        @endif
                    </div>

                    <div class="overflow-x-auto rounded-lg border border-gray-200 shadow-sm">
                        <table class="min-w-full bg-white">
                            <thead>
                                <tr class="bg-blue-600 text-white uppercase text-sm leading-normal">
                                    <th class="py-3 px-6 text-left font-bold border-r border-blue-500">Tanggal</th>
                                    <th class="py-3 px-6 text-left font-bold border-r border-blue-500">No. PO</th>
                                    <th class="py-3 px-6 text-left font-bold border-r border-blue-500">Supplier</th>
                                    <th class="py-3 px-6 text-center font-bold border-r border-blue-500">Status</th>
                                    <th class="py-3 px-6 text-center font-bold">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-700 text-sm font-light">
                                @forelse ($restocks as $restock)
                                    <tr class="border-b border-gray-200 hover:bg-blue-50 transition duration-150">
                                        <td class="py-3 px-6 text-left whitespace-nowrap">
                                            {{ \Carbon\Carbon::parse($restock->date)->format('d M Y') }}
                                            <div class="text-xs text-gray-400 mt-1">{{ $restock->created_at->diffForHumans() }}</div>
                                        </td>
                                        
                                        <td class="py-3 px-6 text-left">
                                            <span class="font-mono font-bold text-blue-600 bg-blue-50 px-2 py-1 rounded border border-blue-100">
                                                {{ $restock->po_number }}
                                            </span>
                                        </td>

                                        <td class="py-3 px-6 text-left">
                                            <span class="font-bold text-gray-700">{{ $restock->supplier->name ?? '-' }}</span>
                                            <div class="text-xs text-gray-400">Email: {{ $restock->supplier->email ?? '-' }}</div>
                                        </td>

                                        <td class="py-3 px-6 text-center">
                                            @if($restock->status == 'pending')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-yellow-100 text-yellow-800 border border-yellow-200">
                                                    <i class="fas fa-clock mr-1"></i> Pending
                                                </span>
                                            @elseif($restock->status == 'confirmed')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-blue-100 text-blue-800 border border-blue-200">
                                                    <i class="fas fa-check-circle mr-1"></i> Confirmed
                                                </span>
                                            @elseif($restock->status == 'in_transit')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-purple-100 text-purple-800 border border-purple-200">
                                                    <i class="fas fa-shipping-fast mr-1"></i> In Transit
                                                </span>
                                            @elseif($restock->status == 'received')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-green-100 text-green-800 border border-green-200">
                                                    <i class="fas fa-box-open mr-1"></i> Received
                                                </span>
                                            @elseif($restock->status == 'rejected')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-red-100 text-red-800 border border-red-200">
                                                    <i class="fas fa-times-circle mr-1"></i> Ditolak
                                                </span>
                                            @endif
                                        </td>

                                        <td class="py-3 px-6 text-center">
                                            <div class="flex item-center justify-center gap-3">
                                                <a href="{{ route('restocks.show', $restock) }}" class="w-8 h-8 rounded flex items-center justify-center bg-blue-100 text-blue-600 hover:bg-blue-200 hover:text-blue-800 transition shadow-sm" title="Lihat Detail">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="py-8 text-center text-gray-500 bg-gray-50">
                                            <div class="flex flex-col items-center justify-center">
                                                <i class="fas fa-clipboard-list fa-3x mb-3 text-gray-300"></i>
                                                <p class="font-medium">Belum ada data restock.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6">
                        {{ $restocks->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>