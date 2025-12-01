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

                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-medium text-gray-900">Daftar Inventori Produk</h3>
                        <a href="{{ route('products.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            + Tambah Produk
                        </a>
                    </div>

                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 mb-6">
                        <form method="GET" action="{{ route('products.index') }}">
                            <div class="grid grid-cols-1 md:grid-cols-6 gap-4">
                                
                                <div class="md:col-span-2">
                                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Pencarian</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fas fa-search text-gray-400"></i>
                                        </div>
                                        <input type="text" name="search" value="{{ request('search') }}" 
                                               class="pl-10 w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm" 
                                               placeholder="Cari Nama Produk atau SKU...">
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Kategori</label>
                                    <select name="category_id" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                                        <option value="">-- Semua --</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Status Stok</label>
                                    <select name="stock_status" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                                        <option value="">-- Semua --</option>
                                        <option value="available" {{ request('stock_status') == 'available' ? 'selected' : '' }}>Tersedia (Aman)</option>
                                        <option value="low_stock" {{ request('stock_status') == 'low_stock' ? 'selected' : '' }}>Low Stock (Menipis)</option>
                                        <option value="out_of_stock" {{ request('stock_status') == 'out_of_stock' ? 'selected' : '' }}>Habis (0)</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Urutkan</label>
                                    <div class="flex">
                                        <select name="sort" class="w-full rounded-l-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm border-r-0">
                                            <option value="created_at" {{ request('sort') == 'created_at' ? 'selected' : '' }}>Tanggal</option>
                                            <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Nama</option>
                                            <option value="stock" {{ request('sort') == 'stock' ? 'selected' : '' }}>Stok</option>
                                            <option value="selling_price" {{ request('sort') == 'selling_price' ? 'selected' : '' }}>Harga</option>
                                        </select>
                                        
                                        <select name="direction" class="w-20 rounded-r-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm bg-gray-100 cursor-pointer text-center font-bold">
                                            <option value="asc" {{ request('direction') == 'asc' ? 'selected' : '' }}>⬆️ A-Z</option>
                                            <option value="desc" {{ request('direction') == 'desc' ? 'selected' : '' }}>⬇️ Z-A</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="flex items-end gap-2">
                                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-bold shadow w-full transition">
                                        Filter
                                    </button>
                                    @if(request()->anyFilled(['search', 'category_id', 'stock_status', 'sort']))
                                        <a href="{{ route('products.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-3 py-2 rounded-md text-sm font-bold shadow text-center transition" title="Reset Filter">
                                            <i class="fas fa-undo"></i>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </form>
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
                                                <span style="background-color: #fee2e2; color: #991b1b; padding: 4px 8px; border-radius: 4px; font-size: 11px; font-weight: bold; display: inline-block;">
                                                    {{ $product->stock }} {{ $product->unit }}
                                                </span>
                                            @else
                                                <span style="background-color: #dcfce7; color: #166534; padding: 4px 8px; border-radius: 4px; font-size: 11px; font-weight: bold; display: inline-block;">
                                                    {{ $product->stock }} {{ $product->unit }}
                                                </span>
                                            @endif
                                        </td>

                                        <td class="py-3 px-6 text-center">
                                            <div class="flex item-center justify-center gap-3">
                                                <a href="{{ route('products.show', $product) }}" class="text-blue-500 hover:text-blue-700 transform hover:scale-110 transition" title="Lihat Detail">
                                                    <i class="fas fa-eye"></i>
                                                </a>

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
                                        <td colspan="7" class="py-8 text-center text-gray-500 bg-gray-50">
                                            <div class="flex flex-col items-center justify-center">
                                                <i class="fas fa-box-open fa-3x mb-3 text-gray-300"></i>
                                                <p>Tidak ada produk yang ditemukan.</p>
                                                @if(request()->anyFilled(['search', 'category_id', 'stock_status', 'sort']))
                                                    <a href="{{ route('products.index') }}" class="text-blue-600 hover:underline text-sm mt-1">Reset Filter</a>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $products->appends(request()->all())->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>