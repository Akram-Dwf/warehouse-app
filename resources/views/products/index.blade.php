<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
            <i class="fas fa-box-open text-blue-600"></i>
            {{ __('Manajemen Produk') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg border-t-4 border-blue-600">
                <div class="p-6 text-gray-900">

                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h3 class="text-lg font-bold text-gray-800">Daftar Inventori</h3>
                            <p class="text-sm text-gray-500">Kelola data, stok, dan harga produk.</p>
                        </div>
                        <a href="{{ route('products.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-700 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-800 focus:bg-blue-800 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-md">
                            <i class="fas fa-plus mr-2"></i> Tambah Produk
                        </a>
                    </div>

                    <div class="bg-gray-50 p-5 rounded-xl border border-gray-200 mb-8 shadow-inner">
                        <form method="GET" action="{{ route('products.index') }}">
                            <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
                                
                                <div class="md:col-span-4">
                                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Pencarian</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fas fa-search text-gray-400"></i>
                                        </div>
                                        <input type="text" name="search" value="{{ request('search') }}" 
                                               class="pl-10 w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm" 
                                               placeholder="Nama Produk / SKU...">
                                    </div>
                                </div>

                                <div class="md:col-span-2">
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

                                <div class="md:col-span-2">
                                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Status Stok</label>
                                    <select name="stock_status" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                                        <option value="">-- Semua --</option>
                                        <option value="available" {{ request('stock_status') == 'available' ? 'selected' : '' }}>Aman</option>
                                        <option value="low_stock" {{ request('stock_status') == 'low_stock' ? 'selected' : '' }}>Menipis</option>
                                        <option value="out_of_stock" {{ request('stock_status') == 'out_of_stock' ? 'selected' : '' }}>Habis</option>
                                    </select>
                                </div>

                                <div class="md:col-span-2">
                                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Urutkan</label>
                                    <div class="flex rounded-md shadow-sm">
                                        <select name="sort" class="block w-full rounded-l-md border-gray-300 focus:border-blue-500 focus:ring-blue-500 text-sm border-r-0">
                                            <option value="created_at" {{ request('sort') == 'created_at' ? 'selected' : '' }}>Tanggal</option>
                                            <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Nama</option>
                                            <option value="stock" {{ request('sort') == 'stock' ? 'selected' : '' }}>Stok</option>
                                            <option value="selling_price" {{ request('sort') == 'selling_price' ? 'selected' : '' }}>Harga</option>
                                        </select>
                                        
                                        <select name="direction" class="inline-flex items-center px-2 rounded-r-md border border-l-0 border-gray-300 bg-gray-50 text-gray-700 sm:text-sm focus:ring-blue-500 focus:border-blue-500 w-24 cursor-pointer font-semibold text-center">
                                            <option value="asc" {{ request('direction') == 'asc' ? 'selected' : '' }}>A-Z ⬆</option>
                                            <option value="desc" {{ request('direction') == 'desc' ? 'selected' : '' }}>Z-A ⬇</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="md:col-span-2 flex items-end gap-2">
                                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-bold shadow w-full transition h-[38px]">
                                        Filter
                                    </button>
                                    @if(request()->anyFilled(['search', 'category_id', 'stock_status', 'sort']))
                                        <a href="{{ route('products.index') }}" class="bg-white border border-gray-300 text-gray-700 px-3 py-2 rounded-md text-sm font-bold shadow-sm hover:bg-gray-50 transition h-[38px] flex items-center justify-center" title="Reset">
                                            <i class="fas fa-undo"></i>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="overflow-x-auto rounded-lg border border-gray-200 shadow-sm">
                        <table class="min-w-full bg-white">
                            <thead>
                                <tr class="bg-blue-600 text-white uppercase text-sm leading-normal">
                                    <th class="py-3 px-6 text-left font-bold border-r border-blue-500">Info Produk</th>
                                    <th class="py-3 px-6 text-left font-bold border-r border-blue-500">Kategori</th>
                                    <th class="py-3 px-6 text-right font-bold border-r border-blue-500">Harga Jual</th>
                                    <th class="py-3 px-6 text-center font-bold border-r border-blue-500">Stok</th>
                                    <th class="py-3 px-6 text-center font-bold">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-700 text-sm font-light">
                                @forelse ($products as $product)
                                    <tr class="border-b border-gray-200 hover:bg-blue-50 transition duration-150">
                                        <td class="py-3 px-6 text-left">
                                            <div class="flex items-center">
                                                <div class="mr-3 shrink-0">
                                                    @if($product->image)
                                                        <img src="{{ asset('storage/' . $product->image) }}" alt="Img" 
                                                             style="width: 40px; height: 40px; object-fit: cover; border-radius: 6px;" 
                                                             class="border border-gray-300 shadow-sm">
                                                    @else
                                                        <div class="w-10 h-10 bg-gray-100 rounded-md flex items-center justify-center text-gray-400 border">
                                                            <i class="fas fa-box"></i>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div>
                                                    <span class="font-bold text-gray-800 block">{{ $product->name }}</span>
                                                    <span class="text-xs font-mono text-gray-500 bg-gray-100 px-1 rounded">{{ $product->sku }}</span>
                                                </div>
                                            </div>
                                        </td>

                                        <td class="py-3 px-6 text-left">
                                            <span class="bg-blue-50 text-blue-700 py-1 px-3 rounded-full text-xs font-bold border border-blue-100">
                                                {{ $product->category->name ?? 'Tanpa Kategori' }}
                                            </span>
                                        </td>

                                        <td class="py-3 px-6 text-right font-bold text-gray-700">
                                            Rp {{ number_format($product->selling_price, 0, ',', '.') }}
                                        </td>

                                        <td class="py-3 px-6 text-center">
                                            @if($product->stock == 0)
                                                <span style="background-color: #fee2e2; color: #991b1b; padding: 4px 10px; border-radius: 9999px; font-size: 11px; font-weight: bold; display: inline-block; border: 1px solid #fecaca;">
                                                    Habis (0)
                                                </span>
                                            @elseif($product->stock <= $product->min_stock)
                                                <span style="background-color: #fef3c7; color: #92400e; padding: 4px 10px; border-radius: 9999px; font-size: 11px; font-weight: bold; display: inline-block; border: 1px solid #fde68a;">
                                                    Low: {{ $product->stock }}
                                                </span>
                                            @else
                                                <span style="background-color: #dcfce7; color: #166534; padding: 4px 10px; border-radius: 9999px; font-size: 11px; font-weight: bold; display: inline-block; border: 1px solid #bbf7d0;">
                                                    {{ $product->stock }} {{ $product->unit }}
                                                </span>
                                            @endif
                                        </td>

                                        <td class="py-3 px-6 text-center">
                                            <div class="flex item-center justify-center gap-2">
                                                <a href="{{ route('products.show', $product) }}" class="w-8 h-8 rounded flex items-center justify-center bg-blue-100 text-blue-600 hover:bg-blue-200 hover:text-blue-800 transition" title="Lihat">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('products.edit', $product) }}" class="w-8 h-8 rounded flex items-center justify-center bg-yellow-100 text-yellow-600 hover:bg-yellow-200 hover:text-yellow-800 transition" title="Edit">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </a>
                                                <form action="{{ route('products.destroy', $product) }}" method="POST" class="delete-form inline-block">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="w-8 h-8 rounded flex items-center justify-center bg-red-100 text-red-600 hover:bg-red-200 hover:text-red-800 transition" title="Hapus">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="py-8 text-center text-gray-500 bg-gray-50">
                                            <div class="flex flex-col items-center justify-center">
                                                <i class="fas fa-box-open fa-3x mb-3 text-gray-300"></i>
                                                <p class="font-medium">Tidak ada data produk.</p>
                                                @if(request()->anyFilled(['search', 'category_id', 'stock_status']))
                                                    <a href="{{ route('products.index') }}" class="text-blue-600 hover:underline text-sm mt-2">Bersihkan Filter</a>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6">
                        {{ $products->appends(request()->all())->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>