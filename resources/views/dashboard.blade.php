<x-app-layout>
    <x-slot name="title">Dashboard</x-slot>
    <x-slot name="breadcrumb">
        <div class="section-header">
            <h1>Dashboard</h1>

            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active">
                    <a href="{{ route('dashboard') }}">Dashboard</a>
                </div>
            </div>
        </div>
    </x-slot>
</x-app-layout>