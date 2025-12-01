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

                                    <td class="py-3 px-6 text-left font-mono font-bold">
                                        {{ $trx->reference_number }}
                                    </td>

                                    <td class="py-3 px-6 text-left">
                                        @if($trx->type == 'incoming')
                                        <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded border border-blue-400">
                                            Masuk (In)
                                        </span>
                                        @else
                                        <span class="bg-orange-100 text-orange-800 text-xs font-medium px-2.5 py-0.5 rounded border border-orange-400">
                                            Keluar (Out)
                                        </span>
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
                                        <span class="bg-green-100 text-green-800 text-xs font-bold px-2 py-1 rounded">Selesai</span>
                                        @elseif($trx->status == 'rejected')
                                        <span class="bg-red-100 text-red-800 text-xs font-bold px-2 py-1 rounded">Ditolak</span>
                                        @else
                                        <span class="bg-yellow-100 text-yellow-800 text-xs font-bold px-2 py-1 rounded">Pending</span>
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
                                            @endif

                                            @if($trx->status == 'pending')
                                            <form action="{{ route('transactions.destroy', $trx) }}" method="POST" class="delete-form inline-block">
                                                @csrf
                                                @method('DELETE')
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
                                    <td colspan="6" class="py-6 text-center text-gray-500 bg-gray-50">
                                        Belum ada transaksi.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $transactions->appends(request()->query())->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>