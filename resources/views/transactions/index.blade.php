<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
            <i class="fas fa-exchange-alt text-blue-600"></i>
            {{ __('Manajemen Transaksi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg border-t-4 border-blue-600">
                <div class="p-6 text-gray-900">

                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h3 class="text-lg font-bold text-gray-800">Riwayat Logistik</h3>
                            <p class="text-sm text-gray-500">Pantau arus barang masuk dan keluar.</p>
                        </div>
                        <a href="{{ route('transactions.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-700 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-800 focus:bg-blue-800 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-md">
                            <i class="fas fa-plus mr-2"></i> Buat Transaksi Baru
                        </a>
                    </div>

                    <div class="border-b border-gray-200 mb-6">
                        <nav class="-mb-px flex space-x-8">
                            <a href="{{ route('transactions.index') }}" 
                               class="{{ !request('type') ? 'border-blue-600 text-blue-700 bg-blue-50' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} 
                                      whitespace-nowrap py-3 px-4 border-b-2 font-bold text-sm transition rounded-t-lg flex items-center gap-2">
                                <i class="fas fa-list"></i> Semua
                            </a>
                            <a href="{{ route('transactions.index', ['type' => 'incoming']) }}" 
                               class="{{ request('type') == 'incoming' ? 'border-blue-600 text-blue-700 bg-blue-50' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} 
                                      whitespace-nowrap py-3 px-4 border-b-2 font-bold text-sm transition rounded-t-lg flex items-center gap-2">
                                <i class="fas fa-arrow-down text-green-500"></i> Barang Masuk
                            </a>
                            <a href="{{ route('transactions.index', ['type' => 'outgoing']) }}" 
                               class="{{ request('type') == 'outgoing' ? 'border-blue-600 text-blue-700 bg-blue-50' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} 
                                      whitespace-nowrap py-3 px-4 border-b-2 font-bold text-sm transition rounded-t-lg flex items-center gap-2">
                                <i class="fas fa-arrow-up text-orange-500"></i> Barang Keluar
                            </a>
                        </nav>
                    </div>

                    <div class="bg-gray-50 p-5 rounded-xl border border-gray-200 mb-8 shadow-inner">
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
                                        <span class="text-gray-500 self-center font-bold">-</span>
                                        <input type="date" name="end_date" value="{{ request('end_date') }}" 
                                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                                    </div>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-12 gap-4 border-t border-gray-200 pt-4">
                                <div class="md:col-span-4">
                                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Urutkan</label>
                                    <div class="flex rounded-md shadow-sm">
                                        <select name="sort" class="block w-full rounded-l-md border-gray-300 focus:border-blue-500 focus:ring-blue-500 text-sm border-r-0">
                                            <option value="created_at" {{ request('sort') == 'created_at' ? 'selected' : '' }}>Waktu Input</option>
                                            <option value="date" {{ request('sort') == 'date' ? 'selected' : '' }}>Tanggal Transaksi</option>
                                            <option value="reference_number" {{ request('sort') == 'reference_number' ? 'selected' : '' }}>No. Referensi</option>
                                        </select>
                                        <select name="direction" class="w-40 rounded-r-md border-l-0 border-gray-300 bg-gray-100 text-gray-700 text-sm focus:ring-blue-500 focus:border-blue-500 cursor-pointer font-bold text-center px-2">
                                            <option value="desc" {{ request('direction') == 'desc' ? 'selected' : '' }}>⬇ Baru</option>
                                            <option value="asc" {{ request('direction') == 'asc' ? 'selected' : '' }}>⬆ Lama</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="md:col-span-4 hidden md:block"></div>

                                <div class="md:col-span-4 flex justify-end items-end gap-2">
                                    @if(request()->anyFilled(['search', 'status', 'start_date', 'end_date', 'sort', 'type']))
                                        <a href="{{ route('transactions.index', ['type' => request('type')]) }}" class="bg-white border border-gray-300 text-gray-700 px-4 py-2 rounded-md text-sm font-bold shadow-sm hover:bg-gray-50 transition h-[38px] flex items-center justify-center" title="Reset Filter">
                                            <i class="fas fa-undo mr-1"></i> Reset
                                        </a>
                                    @endif
                                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-md text-sm font-bold shadow transition h-[38px]">
                                        <i class="fas fa-filter mr-1"></i> Terapkan
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="overflow-x-auto rounded-lg border border-gray-200 shadow-sm">
                        <table class="min-w-full bg-white">
                            <thead>
                                <tr class="bg-blue-600 text-white uppercase text-sm leading-normal">
                                    <th class="py-3 px-6 text-left font-bold border-r border-blue-500">Tanggal</th>
                                    <th class="py-3 px-6 text-left font-bold border-r border-blue-500">No. Ref</th>
                                    <th class="py-3 px-6 text-left font-bold border-r border-blue-500">Tipe</th>
                                    <th class="py-3 px-6 text-left font-bold border-r border-blue-500">Pihak Terkait</th>
                                    <th class="py-3 px-6 text-center font-bold border-r border-blue-500">Status</th>
                                    <th class="py-3 px-6 text-center font-bold">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-700 text-sm font-light">
                                @forelse ($transactions as $trx)
                                    <tr class="border-b border-gray-200 hover:bg-blue-50 transition duration-150">
                                        <td class="py-3 px-6 text-left whitespace-nowrap">
                                            {{ \Carbon\Carbon::parse($trx->date)->format('d M Y') }}
                                            <div class="text-xs text-gray-400 mt-1">{{ $trx->created_at->diffForHumans() }}</div>
                                        </td>
                                        
                                        <td class="py-3 px-6 text-left font-mono font-bold text-gray-700">
                                            {{ $trx->reference_number }}
                                        </td>

                                        <td class="py-3 px-6 text-left">
                                            @if($trx->type == 'incoming')
                                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-bold bg-blue-100 text-blue-800 border border-blue-200">
                                                    <i class="fas fa-arrow-down"></i> Masuk
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-bold bg-orange-100 text-orange-800 border border-orange-200">
                                                    <i class="fas fa-arrow-up"></i> Keluar
                                                </span>
                                            @endif
                                        </td>

                                        <td class="py-3 px-6 text-left">
                                            @if($trx->type == 'incoming')
                                                <span class="font-bold text-gray-700">{{ $trx->supplier->name ?? '-' }}</span>
                                                <div class="text-xs text-gray-400">Supplier</div>
                                            @else
                                                <span class="font-bold text-gray-700">{{ $trx->customer_name ?? 'Umum' }}</span>
                                                <div class="text-xs text-gray-400">Customer</div>
                                            @endif
                                        </td>

                                        <td class="py-3 px-6 text-center">
                                            @if($trx->status == 'approved')
                                                <span style="background-color: #dcfce7; color: #166534; padding: 4px 10px; border-radius: 9999px; font-size: 11px; font-weight: bold; display: inline-block; border: 1px solid #bbf7d0;">
                                                    SELESAI
                                                </span>
                                            @elseif($trx->status == 'rejected')
                                                <span style="background-color: #fee2e2; color: #991b1b; padding: 4px 10px; border-radius: 9999px; font-size: 11px; font-weight: bold; display: inline-block; border: 1px solid #fecaca;">
                                                    DITOLAK
                                                </span>
                                            @else
                                                <span style="background-color: #fef9c3; color: #854d0e; padding: 4px 10px; border-radius: 9999px; font-size: 11px; font-weight: bold; display: inline-block; border: 1px solid #fde68a;">
                                                    PENDING
                                                </span>
                                            @endif
                                        </td>

                                        <td class="py-3 px-6 text-center">
                                            <div class="flex item-center justify-center gap-2">
                                                <a href="{{ route('transactions.show', $trx) }}" class="w-8 h-8 rounded flex items-center justify-center bg-blue-100 text-blue-600 hover:bg-blue-200 hover:text-blue-800 transition" title="Lihat Detail">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                
                                                @if($trx->status == 'pending')
                                                    <a href="{{ route('transactions.edit', $trx) }}" class="w-8 h-8 rounded flex items-center justify-center bg-yellow-100 text-yellow-600 hover:bg-yellow-200 hover:text-yellow-800 transition" title="Edit">
                                                        <i class="fas fa-pencil-alt"></i>
                                                    </a>
                                                    <form action="{{ route('transactions.destroy', $trx) }}" method="POST" class="delete-form inline-block">
                                                        @csrf @method('DELETE')
                                                        <button type="submit" class="w-8 h-8 rounded flex items-center justify-center bg-red-100 text-red-600 hover:bg-red-200 hover:text-red-800 transition" title="Hapus">
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
                                                <p class="font-medium">Tidak ada transaksi yang ditemukan.</p>
                                                @if(request()->anyFilled(['search', 'status', 'start_date', 'end_date']))
                                                    <a href="{{ route('transactions.index', ['type' => request('type')]) }}" class="text-blue-600 hover:underline text-sm mt-2">Bersihkan Filter</a>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6">
                        {{ $transactions->appends(request()->all())->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>