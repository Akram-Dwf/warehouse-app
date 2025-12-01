<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
            <i class="fas fa-tags text-blue-600"></i>
            {{ __('Manajemen Kategori') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg border-t-4 border-blue-600">
                <div class="p-6 text-gray-900">
                    
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h3 class="text-lg font-bold text-gray-800">Daftar Kategori</h3>
                            <p class="text-sm text-gray-500">Kelola kategori produk gudang Anda.</p>
                        </div>
                        <a href="{{ route('categories.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-700 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-800 focus:bg-blue-800 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-md">
                            <i class="fas fa-plus mr-2"></i> Tambah Kategori
                        </a>
                    </div>

                    <div class="overflow-x-auto rounded-lg border border-gray-200">
                        <table class="min-w-full bg-white">
                            <thead>
                                <tr class="bg-blue-600 text-white uppercase text-sm leading-normal">
                                    <th class="py-3 px-6 text-left font-bold border-r border-blue-500">ID</th>
                                    <th class="py-3 px-6 text-left font-bold border-r border-blue-500">Gambar</th>
                                    <th class="py-3 px-6 text-left font-bold border-r border-blue-500">Nama Kategori</th>
                                    <th class="py-3 px-6 text-left font-bold border-r border-blue-500">Deskripsi</th>
                                    <th class="py-3 px-6 text-center font-bold">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-700 text-sm font-light">
                                @forelse ($categories as $category)
                                    <tr class="border-b border-gray-200 hover:bg-blue-50 transition duration-150">
                                        <td class="py-3 px-6 text-left whitespace-nowrap font-bold text-blue-600">
                                            #{{ $category->id }}
                                        </td>
                                        <td class="py-3 px-6 text-left">
                                            @if($category->image)
                                                <div class="p-1 bg-white border rounded-full inline-block shadow-sm">
                                                    <img src="{{ asset('storage/' . $category->image) }}" alt="Img" 
                                                         style="width: 40px; height: 40px; object-fit: cover; border-radius: 50%;">
                                                </div>
                                            @else
                                                <div class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center text-gray-400 shadow-inner">
                                                    <i class="fas fa-image"></i>
                                                </div>
                                            @endif
                                        </td>
                                        <td class="py-3 px-6 text-left">
                                            <span class="font-bold text-gray-800 text-base">{{ $category->name }}</span>
                                        </td>
                                        <td class="py-3 px-6 text-left">
                                            <span class="text-gray-500 italic">{{ \Illuminate\Support\Str::limit($category->description ?? 'Tidak ada deskripsi', 50) }}</span>
                                        </td>
                                        <td class="py-3 px-6 text-center">
                                            <div class="flex item-center justify-center gap-3">
                                                <a href="{{ route('categories.edit', $category) }}" class="w-8 h-8 rounded flex items-center justify-center bg-yellow-100 text-yellow-600 hover:bg-yellow-200 hover:text-yellow-800 transition shadow-sm" title="Edit">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </a>
                                                
                                                <form action="{{ route('categories.destroy', $category) }}" method="POST" class="delete-form inline-block">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="w-8 h-8 rounded flex items-center justify-center bg-red-100 text-red-600 hover:bg-red-200 hover:text-red-800 transition shadow-sm" title="Hapus">
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
                                                <i class="fas fa-inbox fa-3x mb-3 text-gray-300"></i>
                                                <p>Belum ada data kategori yang tersedia.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6">
                        {{ $categories->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>