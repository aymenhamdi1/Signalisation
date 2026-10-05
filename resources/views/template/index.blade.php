@extends('Template.admin_master')

@section('content')
<div class="min-h-screen bg-gray-100 flex flex-col items-center justify-center p-6">
    <div class="bg-white shadow-lg rounded-lg p-8 max-w-3xl w-full">
        <h1 class="text-2xl font-bold text-gray-800 mb-6 text-center">Bienvenue sur votre tableau de bord</h1>

        <div class="grid grid-cols-2 gap-6">
            <a href="{{ route('dashboard') }}" class="flex flex-col items-center justify-center bg-blue-500 hover:bg-blue-600 text-white py-6 px-4 rounded-lg shadow-lg transition">
                <i class="ri-dashboard-line text-4xl"></i>
                <span class="mt-2 text-lg">Dashboard</span>
            </a>

            <a href="#" class="flex flex-col items-center justify-center bg-green-500 hover:bg-green-600 text-white py-6 px-4 rounded-lg shadow-lg transition">
                <i class="ri-map-pin-line text-4xl"></i>
                <span class="mt-2 text-lg">Gestion des Cartes</span>
            </a>

            <a href="#" class="flex flex-col items-center justify-center bg-purple-500 hover:bg-purple-600 text-white py-6 px-4 rounded-lg shadow-lg transition">
                <i class="ri-user-line text-4xl"></i>
                <span class="mt-2 text-lg">Utilisateurs</span>
            </a>

            <a href="#" class="flex flex-col items-center justify-center bg-red-500 hover:bg-red-600 text-white py-6 px-4 rounded-lg shadow-lg transition">
                <i class="ri-lock-line text-4xl"></i>
                <span class="mt-2 text-lg">Permissions & Rôles</span>
            </a>
        </div>
    </div>
</div>
@endsection
