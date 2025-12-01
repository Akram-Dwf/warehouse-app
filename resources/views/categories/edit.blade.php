<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
            <i class="fas fa-edit text-blue-600"></i>
            {{ __('Edit Kategori') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg border-t-4 border-blue-600">
                <div class="p-8 text-gray-900">

                    <div class="mb-6 border-b border-gray-100 pb-4 flex justify-between items-center">
                        <div>
                            <h3 class="text-lg font-bold text-gray-800">Edit: {{ $category->name }}</h3>
                            <p class="text-sm text-gray-500">Perbarui informasi kategori produk.</p>
                        </div>
                        <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded border border-blue-200">ID: {{ $category->id }}</span>
                    </div>

                    <form action="{{ route('categories.update', $category) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-6">
                            <label for="name" class="block text-sm font-bold text-gray-700 uppercase tracking-wider mb-1">
                                Nama Kategori <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="name" id="name" value="{{ old('name', $category->name) }}" 
                                   class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition duration-150 ease-in-out py-2 px-3" required>
                            @error('name') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="mb-6">
                            <label for="description" class="block text-sm font-bold text-gray-700 uppercase tracking-wider mb-1">
                                Deskripsi (Opsional)
                            </label>
                            <textarea name="description" id="description" rows="4" 
                                      class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition duration-150 ease-in-out py-2 px-3">{{ old('description', $category->description) }}</textarea>
                            @error('description') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="mb-8">
                            <label class="block text-sm font-bold text-gray-700 uppercase tracking-wider mb-3">
                                Gambar Kategori
                            </label>
                            
                            <div class="flex items-start gap-6">
                                <div class="shrink-0">
                                    <p class="text-xs text-gray-500 mb-2 text-center">Saat Ini</p>
                                    @if($category->image)
                                        <img src="{{ asset('storage/' . $category->image) }}" class="w-32 h-32 object-cover rounded-lg border shadow-sm bg-gray-50">
                                    @else
                                        <div class="w-32 h-32 bg-gray-200 rounded-lg flex items-center justify-center text-gray-400 border shadow-inner">
                                            <i class="fas fa-image fa-2x"></i>
                                        </div>
                                    @endif
                                </div>

                                <div class="flex-grow">
                                    <p class="text-xs text-gray-500 mb-2">Ganti Gambar (Opsional)</p>
                                    <label for="image" class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 hover:border-blue-400 transition">
                                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                            <i class="fas fa-cloud-upload-alt text-gray-400 text-2xl mb-2"></i>
                                            <p class="mb-1 text-sm text-gray-500">Klik untuk ganti</p>
                                        </div>
                                        <input id="image" name="image" type="file" class="hidden" />
                                    </label>
                                </div>
                            </div>
                            @error('image') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="flex items-center justify-end gap-4 pt-4 border-t border-gray-100">
                            <a href="{{ route('categories.index') }}" class="px-6 py-2 bg-gray-200 text-gray-700 font-bold rounded shadow-sm hover:bg-gray-300 transition">
                                Batal
                            </a>
                            <button type="submit" class="px-6 py-2 bg-blue-600 text-white font-bold rounded shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition transform hover:scale-105">
                                <i class="fas fa-check-circle mr-2"></i> Simpan Perubahan
                            </button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>