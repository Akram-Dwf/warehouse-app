<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Pengguna') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <h3 class="text-lg font-medium text-gray-900 mb-4">Daftar Pengguna Sistem</h3>

                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white border border-gray-200 rounded-lg">
                            <thead>
                                <tr class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
                                    <th class="py-3 px-6 text-left">Nama</th>
                                    <th class="py-3 px-6 text-left">Email</th>
                                    <th class="py-3 px-6 text-left">Role</th>
                                    <th class="py-3 px-6 text-center">Status</th>
                                    <th class="py-3 px-6 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600 text-sm font-light">
                                @forelse ($users as $user)
                                    <tr class="border-b border-gray-200 hover:bg-gray-50 {{ !$user->is_approved ? 'bg-red-50' : '' }}">
                                        <td class="py-3 px-6 text-left whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="mr-2">
                                                    <div class="h-8 w-8 rounded-full bg-gray-200 flex items-center justify-center text-gray-600 font-bold">
                                                        {{ substr($user->name, 0, 1) }}
                                                    </div>
                                                </div>
                                                <span class="font-medium">{{ $user->name }}</span>
                                            </div>
                                        </td>
                                        
                                        <td class="py-3 px-6 text-left">
                                            {{ $user->email }}
                                        </td>

                                        <td class="py-3 px-6 text-left">
                                            <span class="bg-gray-200 text-gray-600 py-1 px-3 rounded-full text-xs uppercase font-bold">
                                                {{ $user->role }}
                                            </span>
                                        </td>

                                        <td class="py-3 px-6 text-center">
                                            @if($user->is_approved)
                                                <span class="bg-green-200 text-green-600 py-1 px-3 rounded-full text-xs font-bold">Aktif</span>
                                            @else
                                                <span class="bg-red-200 text-red-600 py-1 px-3 rounded-full text-xs font-bold animate-pulse">Menunggu Approval</span>
                                            @endif
                                        </td>

                                        <td class="py-3 px-6 text-center">
                                            <div class="flex item-center justify-center gap-2">
                                                
                                                @if(!$user->is_approved)
                                                    <form action="{{ route('users.update', $user) }}" method="POST" class="approve-user-form">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit" class="w-6 h-6 text-green-500 hover:text-green-700 transform hover:scale-110" title="Setujui User Ini">
                                                            <i class="fas fa-check-circle fa-lg"></i>
                                                        </button>
                                                    </form>
                                                @endif

                                                @if(Auth::id() !== $user->id)
                                                    <form action="{{ route('users.destroy', $user) }}" method="POST" class="delete-form">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="w-6 h-6 text-red-500 hover:text-red-700 transform hover:scale-110" title="Hapus User">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                    </form>
                                                @endif

                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="py-6 text-center text-gray-500 bg-gray-50">
                                            Tidak ada data pengguna.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $users->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Handle Approval Confirmation
            document.querySelectorAll('.approve-user-form').forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Setujui Pengguna Ini?',
                        text: "Pengguna akan dapat login ke sistem.",
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#16a34a',
                        cancelButtonColor: '#6b7280',
                        confirmButtonText: 'Ya, Setujui!',
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