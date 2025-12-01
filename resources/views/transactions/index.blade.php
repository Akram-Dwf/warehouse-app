<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Transaksi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-medium text-gray-900">Riwayat Barang Masuk & Keluar</h3>
                        <a href="{{ route('transactions.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            + Buat Transaksi Baru
                        </a>
                    </div>

                    <div class="border-b border-gray-200 mb-6">
                        <nav class="-mb-px flex space-x-8">
                            <a href="{{ route('transactions.index') }}" 
                               class="{{ !request('type') ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} 
                                      whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition">
                                Semua Transaksi
                            </a>
                            <a href="{{ route('transactions.index', ['type' => 'incoming']) }}" 
                               class="{{ request('type') == 'incoming' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} 
                                      whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition">
                                ⬇️ Barang Masuk
                            </a>
                            <a href="{{ route('transactions.index', ['type' => 'outgoing']) }}" 
                               class="{{ request('type') == 'outgoing' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} 
                                      whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition">
                                ⬆️ Barang Keluar
                            </a>
                        </nav>
                    </div>

                    <div class="bg-gray-50 p-5 rounded-lg border border-gray-200 mb-6">
                        <form method="GET" action="{{ route('transactions.index') }}">
                            @if(request('type'))
                                <input type="hidden" name="type" value="{{ request('type') }}">
                            @endif

                            <div class="grid grid-cols-1 md:grid-cols-12 gap-4 mb-4">
                                <div class="md:col-span-5">
                                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Pencarian</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fas fa-search text-gray-400"></i>
                                        </div>
                                        <input type="text" name="search" value="{{ request('search') }}" 
                                               class="pl-10 w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm" 
                                               placeholder="No. Ref / Supplier / Customer...">
                                    </div>
                                </div>

                                <div class="md:col-span-3">
                                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Status</label>
                                    <select name="status" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                                        <option value="">-- Semua --</option>
                                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Selesai (Approved)</option>
                                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                                    </select>
                                </div>

                                <div class="md:col-span-4">
                                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Rentang Tanggal</label>
                                    <div class="flex gap-2">
                                        <input type="date" name="start_date" value="{{ request('start_date') }}" 
                                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                                        <span class="text-gray-500 self-center">-</span>
                                        <input type="date" name="end_date" value="{{ request('end_date') }}" 
                                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                                    </div>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-12 gap-4 border-t border-gray-200 pt-4">
                                <div class="md:col-span-4">
                                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Urutkan</label>
                                    <div class="flex">
                                        <select name="sort" class="w-full rounded-l-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm border-r-0">
                                            <option value="created_at" {{ request('sort') == 'created_at' ? 'selected' : '' }}>Waktu Input</option>
                                            <option value="date" {{ request('sort') == 'date' ? 'selected' : '' }}>Tanggal Transaksi</option>
                                            <option value="reference_number" {{ request('sort') == 'reference_number' ? 'selected' : '' }}>No. Referensi</option>
                                        </select>
                                        <select name="direction" class="w-24 rounded-r-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm bg-gray-100 text-center font-bold cursor-pointer">
                                            <option value="desc" {{ request('direction') == 'desc' ? 'selected' : '' }}>⬇️ Baru</option>
                                            <option value="asc" {{ request('direction') == 'asc' ? 'selected' : '' }}>⬆️ Lama</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="md:col-span-4"></div>

                                <div class="md:col-span-4 flex justify-end items-end gap-2">
                                    @if(request()->anyFilled(['search', 'status', 'start_date', 'end_date', 'sort', 'type']))
                                        <a href="{{ route('transactions.index', ['type' => request('type')]) }}" class="bg-white border border-gray-300 text-gray-700 px-4 py-2 rounded-md text-sm font-bold shadow-sm hover:bg-gray-50 transition">
                                            Reset Filter
                                        </a>
                                    @endif
                                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-md text-sm font-bold shadow transition">
                                        Terapkan Filter
                                    </button>
                                </div>
                            </div>

                        </form>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white border border-gray-200 rounded-lg">
                            <thead>
                                <tr class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
                                    <th class="py-3 px-6 text-left">Tanggal</th>
                                    <th class="py-3 px-6 text-left">No. Referensi</th>
                                    <th class="py-3 px-6 text-left">Tipe</th>
                                    <th class="py-3 px-6 text-left">Supplier / Customer</th>
                                    <th class="py-3 px-6 text-center">Status</th>
                                    <th class="py-3 px-6 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600 text-sm font-light">
                                @forelse ($transactions as $trx)
                                    <tr class="border-b border-gray-200 hover:bg-gray-50">
                                        <td class="py-3 px-6 text-left whitespace-nowrap">
                                            {{ \Carbon\Carbon::parse($trx->date)->format('d M Y') }}
                                        </td>
                                        <td class="py-3 px-6 text-left font-mono font-bold text-gray-700">
                                            {{ $trx->reference_number }}
                                        </td>
                                        <td class="py-3 px-6 text-left">
                                            @if($trx->type == 'incoming')
                                                <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded border border-blue-400">Masuk (In)</span>
                                            @else
                                                <span class="bg-orange-100 text-orange-800 text-xs font-medium px-2.5 py-0.5 rounded border border-orange-400">Keluar (Out)</span>
                                            @endif
                                        </td>
                                        <td class="py-3 px-6 text-left">
                                            @if($trx->type == 'incoming')
                                                <span class="font-semibold text-gray-700">{{ $trx->supplier->name ?? '-' }}</span>
                                            @else
                                                <span class="font-semibold text-gray-700">{{ $trx->customer_name ?? 'Umum' }}</span>
                                            @endif
                                        </td>
                                        <td class="py-3 px-6 text-center">
                                            @if($trx->status == 'approved')
                                                <span style="background-color: #dcfce7; color: #166534; padding: 4px 8px; border-radius: 4px; font-size: 11px; font-weight: bold; text-transform: uppercase;">Selesai</span>
                                            @elseif($trx->status == 'rejected')
                                                <span style="background-color: #fee2e2; color: #991b1b; padding: 4px 8px; border-radius: 4px; font-size: 11px; font-weight: bold; text-transform: uppercase;">Ditolak</span>
                                            @else
                                                <span style="background-color: #fef9c3; color: #854d0e; padding: 4px 8px; border-radius: 4px; font-size: 11px; font-weight: bold; text-transform: uppercase;">Pending</span>
                                            @endif
                                        </td>
                                        <td class="py-3 px-6 text-center">
                                            <div class="flex item-center justify-center gap-3">
                                                <a href="{{ route('transactions.show', $trx) }}" class="text-blue-500 hover:text-blue-700 transform hover:scale-110 transition" title="Lihat Detail">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                @if($trx->status == 'pending')
                                                    <a href="{{ route('transactions.edit', $trx) }}" class="text-yellow-500 hover:text-yellow-700 transform hover:scale-110 transition" title="Edit">
                                                        <i class="fas fa-pencil-alt"></i>
                                                    </a>
                                                    <form action="{{ route('transactions.destroy', $trx) }}" method="POST" class="delete-form inline-block">
                                                        @csrf @method('DELETE')
                                                        <button type="submit" class="text-red-500 hover:text-red-700 transform hover:scale-110 transition" title="Hapus">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="py-8 text-center text-gray-500 bg-gray-50">
                                            <div class="flex flex-col items-center justify-center">
                                                <i class="fas fa-clipboard-list fa-3x mb-3 text-gray-300"></i>
                                                <p>Tidak ada transaksi yang ditemukan.</p>
                                                @if(request()->anyFilled(['search', 'status', 'start_date', 'end_date']))
                                                    <a href="{{ route('transactions.index', ['type' => request('type')]) }}" class="text-blue-600 hover:underline text-sm mt-1">Reset Filter</a>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $transactions->appends(request()->all())->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>