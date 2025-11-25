<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Produk') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <div class="flex justify-end mb-6">
                        <a href="{{ route('products.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            + Tambah Produk
                        </a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white border border-gray-200 rounded-lg">
                            <thead>
                                <tr class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
                                    <th class="py-3 px-6 text-left">Gambar</th>
                                    <th class="py-3 px-6 text-left">SKU</th>
                                    <th class="py-3 px-6 text-left">Nama Produk</th>
                                    <th class="py-3 px-6 text-left">Kategori</th>
                                    <th class="py-3 px-6 text-right">Harga</th>
                                    <th class="py-3 px-6 text-center">Stok</th>
                                    <th class="py-3 px-6 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600 text-sm font-light">
                                @forelse ($products as $product)
                                <tr class="border-b border-gray-200 hover:bg-gray-50">
                                    <td class="py-3 px-6 text-left">
                                        @if($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" alt="Img"
                                            style="width: 40px; height: 40px; object-fit: cover; border-radius: 4px;"
                                            class="border border-gray-300">
                                        @else
                                        <span class="text-gray-400 text-xs italic">No Img</span>
                                        @endif
                                    </td>

                                    <td class="py-3 px-6 text-left whitespace-nowrap">
                                        <span class="font-mono text-xs bg-gray-100 px-2 py-1 rounded">{{ $product->sku }}</span>
                                    </td>

                                    <td class="py-3 px-6 text-left font-medium text-gray-800">
                                        {{ $product->name }}
                                    </td>

                                    <td class="py-3 px-6 text-left">
                                        <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded">
                                            {{ $product->category->name ?? 'Tanpa Kategori' }}
                                        </span>
                                    </td>

                                    <td class="py-3 px-6 text-right font-medium">
                                        Rp {{ number_format($product->selling_price, 0, ',', '.') }}
                                    </td>

                                    <td class="py-3 px-6 text-center">
                                        @if($product->stock <= $product->min_stock)
                                            <span style="background-color: #fee2e2; color: #991b1b; padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: bold; display: inline-block;">
                                                {{ $product->stock }} {{ $product->unit }}
                                            </span>
                                            @else
                                            <span style="background-color: #dcfce7; color: #166534; padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: bold; display: inline-block;">
                                                {{ $product->stock }} {{ $product->unit }}
                                            </span>
                                            @endif
                                    </td>

                                    <td class="py-3 px-6 text-center">
                                        <div class="flex item-center justify-center gap-3">
                                            <a href="{{ route('products.edit', $product) }}" class="text-yellow-500 hover:text-yellow-700 transform hover:scale-110 transition" title="Edit">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>

                                            <form action="{{ route('products.destroy', $product) }}" method="POST" class="delete-form inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:text-red-700 transform hover:scale-110 transition" title="Hapus">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="py-6 text-center text-gray-500 bg-gray-50">
                                        Belum ada data produk. Silakan tambah produk baru.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $products->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>