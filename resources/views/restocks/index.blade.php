<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Restock Management') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-medium text-gray-900">Daftar Permintaan Restock</h3>

                        @if(Auth::user()->role == 'admin' || Auth::user()->role == 'manager') <a href="{{ route('restocks.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            + Buat Restock Order
                        </a>
                        @endif
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white border border-gray-200 rounded-lg">
                            <thead>
                                <tr class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
                                    <th class="py-3 px-6 text-left">Tanggal</th>
                                    <th class="py-3 px-6 text-left">No. PO</th>
                                    <th class="py-3 px-6 text-left">Supplier</th>
                                    <th class="py-3 px-6 text-center">Status</th>
                                    <th class="py-3 px-6 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600 text-sm font-light">
                                @forelse ($restocks as $restock)
                                <tr class="border-b border-gray-200 hover:bg-gray-50">
                                    <td class="py-3 px-6 text-left whitespace-nowrap">
                                        {{ \Carbon\Carbon::parse($restock->date)->format('d M Y') }}
                                    </td>

                                    <td class="py-3 px-6 text-left font-mono font-bold text-blue-600">
                                        {{ $restock->po_number }}
                                    </td>

                                    <td class="py-3 px-6 text-left">
                                        <span class="font-semibold">{{ $restock->supplier->name ?? '-' }}</span>
                                    </td>

                                    <td class="py-3 px-6 text-center">
                                        @if($restock->status == 'pending')
                                        <span class="bg-yellow-100 text-yellow-800 text-xs font-bold px-2 py-1 rounded uppercase">Pending</span>
                                        @elseif($restock->status == 'confirmed')
                                        <span class="bg-blue-100 text-blue-800 text-xs font-bold px-2 py-1 rounded uppercase">Confirmed</span>
                                        @elseif($restock->status == 'in_transit')
                                        <span class="bg-purple-100 text-purple-800 text-xs font-bold px-2 py-1 rounded uppercase">In Transit</span>
                                        @elseif($restock->status == 'received')
                                        <span class="bg-green-100 text-green-800 text-xs font-bold px-2 py-1 rounded uppercase">Received</span>
                                        @endif
                                    </td>

                                    <td class="py-3 px-6 text-center">
                                        <div class="flex item-center justify-center gap-3">
                                            <a href="{{ route('restocks.show', $restock) }}" class="text-blue-500 hover:text-blue-700 transform hover:scale-110 transition" title="Lihat Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="py-6 text-center text-gray-500 bg-gray-50">
                                        Belum ada data restock.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $restocks->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>