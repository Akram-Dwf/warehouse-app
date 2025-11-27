<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Restock Order') }} : <span class="text-blue-600">{{ $restock->po_number }}</span>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            <div class="mb-6">
                <a href="{{ route('restocks.index') }}" class="text-gray-600 hover:text-gray-900 flex items-center">
                    &laquo; Kembali ke Daftar
                </a>
            </div>

            <div class="bg-white shadow-md rounded-lg overflow-hidden mb-6">
                <div class="p-6 border-b border-gray-200 bg-gray-50 flex justify-between items-start">
                    <div>
                        <h2 class="text-xl font-bold text-gray-800">Purchase Order (PO)</h2>
                        <p class="text-sm text-gray-500 mt-1">
                            Tanggal Order: {{ \Carbon\Carbon::parse($restock->date)->format('d M Y') }} <br>
                            Estimasi Sampai: {{ $restock->expected_delivery_date ? \Carbon\Carbon::parse($restock->expected_delivery_date)->format('d M Y') : '-' }}
                        </p>
                    </div>
                    
                    <div class="text-right">
                        <span class="block text-xs text-gray-500 mb-1">Status Saat Ini</span>
                        @if($restock->status == 'pending')
                            <span style="background-color: #fef9c3; color: #854d0e; padding: 4px 12px; border-radius: 9999px; font-weight: bold; font-size: 0.875rem; text-transform: uppercase;">Pending</span>
                        @elseif($restock->status == 'confirmed')
                            <span style="background-color: #dbeafe; color: #1e40af; padding: 4px 12px; border-radius: 9999px; font-weight: bold; font-size: 0.875rem; text-transform: uppercase;">Confirmed</span>
                        @elseif($restock->status == 'in_transit')
                            <span style="background-color: #f3e8ff; color: #6b21a8; padding: 4px 12px; border-radius: 9999px; font-weight: bold; font-size: 0.875rem; text-transform: uppercase;">In Transit</span>
                        @elseif($restock->status == 'received')
                            <span style="background-color: #dcfce7; color: #166534; padding: 4px 12px; border-radius: 9999px; font-weight: bold; font-size: 0.875rem; text-transform: uppercase;">Received</span>
                        @elseif($restock->status == 'rejected')
                            <span style="background-color: #fee2e2; color: #991b1b; padding: 4px 12px; border-radius: 9999px; font-weight: bold; font-size: 0.875rem; text-transform: uppercase;">Ditolak</span>
                        @endif
                    </div>
                </div>

                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h3 class="text-xs font-bold text-gray-500 uppercase mb-1">Supplier Tujuan</h3>
                        <p class="text-lg font-medium text-gray-900">{{ $restock->supplier->name }}</p>
                        <p class="text-sm text-gray-600">{{ $restock->supplier->email }}</p>
                    </div>
                    <div>
                        <h3 class="text-xs font-bold text-gray-500 uppercase mb-1">Catatan</h3>
                        <p class="text-gray-700 italic bg-gray-50 p-3 rounded border">
                            "{{ $restock->notes ?? 'Tidak ada catatan' }}"
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-white shadow-md rounded-lg overflow-hidden mb-6">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <h3 class="font-bold text-gray-800">Item yang Dipesan</h3>
                </div>
                <table class="min-w-full text-left text-sm">
                    <thead class="bg-gray-100 text-gray-600 uppercase font-medium">
                        <tr>
                            <th class="px-6 py-3">Produk</th>
                            <th class="px-6 py-3 text-right">Jumlah Order</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($restock->products as $product)
                            <tr>
                                <td class="px-6 py-4 font-medium text-gray-900">{{ $product->name }}</td>
                                <td class="px-6 py-4 text-right font-bold text-lg">{{ $product->pivot->quantity }} {{ $product->unit }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="bg-white shadow-md rounded-lg p-6 mb-10 border-l-4 border-blue-500">
                <h3 class="font-bold text-lg text-gray-800 mb-4">Tindakan Lanjutan</h3>

                @if(Auth::user()->role == 'supplier' && $restock->status == 'pending')
                    <p class="text-gray-600 mb-4">Pesanan ini menunggu konfirmasi Anda.</p>
                    <div class="flex gap-3">
                        <form action="{{ route('restocks.update', $restock) }}" method="POST" class="action-form">
                            @csrf @method('PUT')
                            <input type="hidden" name="status" value="confirmed">
                            <button type="submit" style="background-color: #16a34a; color: white; padding: 8px 16px; border-radius: 6px; font-weight: bold;">
                                ✔ Konfirmasi Pesanan
                            </button>
                        </form>
                        <form action="{{ route('restocks.update', $restock) }}" method="POST" class="action-form">
                            @csrf @method('PUT')
                            <input type="hidden" name="status" value="rejected">
                            <button type="submit" style="background-color: #dc2626; color: white; padding: 8px 16px; border-radius: 6px; font-weight: bold;">
                                ✖ Tolak Pesanan
                            </button>
                        </form>
                    </div>

                @elseif(Auth::user()->role == 'manager' && $restock->status == 'confirmed')
                    <p class="text-gray-600 mb-4">Supplier telah mengonfirmasi. Klik tombol di bawah jika barang sudah dikirim.</p>
                    <form action="{{ route('restocks.update', $restock) }}" method="POST" class="action-form">
                        @csrf @method('PUT')
                        <input type="hidden" name="status" value="in_transit">
                        <button type="submit" style="background-color: #9333ea; color: white; padding: 8px 16px; border-radius: 6px; font-weight: bold;">
                            🚚 Barang Dikirim (In Transit)
                        </button>
                    </form>

                @elseif(Auth::user()->role == 'manager' && $restock->status == 'in_transit')
                    <p class="text-gray-600 mb-4">Barang sedang dikirim. Klik tombol di bawah jika barang sudah sampai di gudang.</p>
                    <form action="{{ route('restocks.update', $restock) }}" method="POST" class="action-form">
                        @csrf @method('PUT')
                        <input type="hidden" name="status" value="received">
                        <button type="submit" style="background-color: #16a34a; color: white; padding: 8px 16px; border-radius: 6px; font-weight: bold;">
                            📦 Barang Diterima (Received)
                        </button>
                    </form>
                    <p class="text-xs text-red-500 mt-2">*Stok fisik tidak bertambah otomatis. Harap buat Transaksi Masuk setelah ini.</p>

                @else
                    <p class="text-gray-500 italic">Tidak ada tindakan yang diperlukan saat ini.</p>
                @endif
            </div>

        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.action-form').forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Proses Status?',
                        text: "Status pesanan akan diperbarui.",
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, Lanjutkan!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) form.submit();
                    });
                });
            });
        });
    </script>
    @endpush
</x-app-layout>