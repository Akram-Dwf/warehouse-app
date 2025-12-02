<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
            <i class="fas fa-users-cog text-blue-600"></i>
            {{ __('Manajemen Pengguna') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg border-t-4 border-blue-600">
                <div class="p-6 text-gray-900">

                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h3 class="text-lg font-bold text-gray-800">Daftar Pengguna Sistem</h3>
                            <p class="text-sm text-gray-500">Kelola akses dan peran pengguna aplikasi.</p>
                        </div>
                        <a href="{{ route('users.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-700 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-800 focus:bg-blue-800 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-md">
                            <i class="fas fa-user-plus mr-2"></i> Tambah User
                        </a>
                    </div>

                    <div class="overflow-x-auto rounded-lg border border-gray-200 shadow-sm">
                        <table class="min-w-full bg-white">
                            <thead>
                                <tr class="bg-blue-600 text-white uppercase text-sm leading-normal">
                                    <th class="py-3 px-6 text-left font-bold border-r border-blue-500">Pengguna</th>
                                    <th class="py-3 px-6 text-left font-bold border-r border-blue-500">Email</th>
                                    <th class="py-3 px-6 text-center font-bold border-r border-blue-500">Role</th>
                                    <th class="py-3 px-6 text-center font-bold border-r border-blue-500">Status</th>
                                    <th class="py-3 px-6 text-center font-bold">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-700 text-sm font-light">
                                @forelse ($users as $user)
                                    <tr class="border-b border-gray-200 hover:bg-blue-50 transition duration-150 {{ !$user->is_approved ? 'bg-red-50' : '' }}">
                                        
                                        <td class="py-3 px-6 text-left whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="mr-3">
                                                    <div class="h-9 w-9 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold border border-blue-200 shadow-sm">
                                                        {{ substr($user->name, 0, 1) }}
                                                    </div>
                                                </div>
                                                <span class="font-bold text-gray-800">{{ $user->name }}</span>
                                            </div>
                                        </td>
                                        
                                        <td class="py-3 px-6 text-left">
                                            <span class="text-gray-600 font-mono text-xs">{{ $user->email }}</span>
                                        </td>

                                        <td class="py-3 px-6 text-center">
                                            @if($user->role == 'admin')
                                                <span class="bg-blue-100 text-blue-800 py-1 px-3 rounded-full text-xs font-bold border border-blue-200">ADMIN</span>
                                            @elseif($user->role == 'manager')
                                                <span class="bg-purple-100 text-purple-800 py-1 px-3 rounded-full text-xs font-bold border border-purple-200">MANAGER</span>
                                            @elseif($user->role == 'staff')
                                                <span class="bg-gray-100 text-gray-800 py-1 px-3 rounded-full text-xs font-bold border border-gray-300">STAFF</span>
                                            @else
                                                <span class="bg-yellow-100 text-yellow-800 py-1 px-3 rounded-full text-xs font-bold border border-yellow-200">SUPPLIER</span>
                                            @endif
                                        </td>

                                        <td class="py-3 px-6 text-center">
                                            @if($user->is_approved)
                                                <span class="inline-flex items-center gap-1 text-green-600 font-bold text-xs">
                                                    <i class="fas fa-check-circle"></i> Aktif
                                                </span>
                                            @else
                                                <span class="bg-red-100 text-red-600 py-1 px-3 rounded-full text-xs font-bold animate-pulse border border-red-200">
                                                    <i class="fas fa-clock mr-1"></i> Menunggu
                                                </span>
                                            @endif
                                        </td>

                                        <td class="py-3 px-6 text-center">
                                            <div class="flex item-center justify-center gap-2">
                                                
                                                @if(!$user->is_approved)
                                                    <form action="{{ route('users.update', $user) }}" method="POST" 
                                                          class="confirm-form"
                                                          data-title="Setujui Pengguna?" 
                                                          data-text="Pengguna akan dapat login ke sistem." 
                                                          data-color="#16a34a">
                                                        @csrf @method('PUT')
                                                        <input type="hidden" name="approve_action" value="1">
                                                        <button type="submit" class="w-8 h-8 rounded flex items-center justify-center bg-green-100 text-green-600 hover:bg-green-200 hover:text-green-800 transition shadow-sm" title="Approve">
                                                            <i class="fas fa-check"></i>
                                                        </button>
                                                    </form>
                                                @else
                                                    <a href="{{ route('users.edit', $user) }}" class="w-8 h-8 rounded flex items-center justify-center bg-yellow-100 text-yellow-600 hover:bg-yellow-200 hover:text-yellow-800 transition shadow-sm" title="Edit">
                                                        <i class="fas fa-pencil-alt"></i>
                                                    </a>
                                                @endif

                                                @if(Auth::id() !== $user->id)
                                                    <form action="{{ route('users.destroy', $user) }}" method="POST" class="delete-form inline-block">
                                                        @csrf @method('DELETE')
                                                        <button type="submit" class="w-8 h-8 rounded flex items-center justify-center bg-red-100 text-red-600 hover:bg-red-200 hover:text-red-800 transition shadow-sm" title="Hapus">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                    </form>
                                                @endif

                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="py-8 text-center text-gray-500 bg-gray-50">
                                            <div class="flex flex-col items-center justify-center">
                                                <i class="fas fa-user-slash fa-3x mb-3 text-gray-300"></i>
                                                <p>Tidak ada data pengguna.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6">
                        {{ $users->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>