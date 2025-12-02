<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
            <i class="fas fa-user-circle text-blue-600"></i>
            {{ __('Profil Saya') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <div class="p-8 bg-white shadow-lg sm:rounded-lg border-t-4 border-blue-600">
                <div class="max-w-xl">
                    <div class="flex items-center gap-2 text-blue-700 mb-4 border-b border-gray-100 pb-2">
                        <i class="fas fa-id-card"></i>
                        <h3 class="font-bold uppercase text-sm tracking-wider">Informasi Pribadi</h3>
                    </div>
                    
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-8 bg-white shadow-lg sm:rounded-lg border-t-4 border-green-500">
                <div class="max-w-xl">
                    <div class="flex items-center gap-2 text-green-700 mb-4 border-b border-gray-100 pb-2">
                        <i class="fas fa-shield-alt"></i>
                        <h3 class="font-bold uppercase text-sm tracking-wider">Keamanan Akun</h3>
                    </div>

                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-8 bg-white shadow-lg sm:rounded-lg border-t-4 border-red-600">
                <div class="max-w-xl">
                    <div class="flex items-center gap-2 text-red-700 mb-4 border-b border-gray-100 pb-2">
                        <i class="fas fa-exclamation-triangle"></i>
                        <h3 class="font-bold uppercase text-sm tracking-wider">Zona Berbahaya</h3>
                    </div>

                    @include('profile.partials.delete-user-form')
                </div>
            </div>

        </div>
    </div>
</x-app-layout>