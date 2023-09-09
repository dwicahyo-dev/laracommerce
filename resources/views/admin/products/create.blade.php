<x-app-layout>
    <x-slot name="title">Products</x-slot>
    <x-slot name="breadcrumb">
        <div class="section-header">
            <h1>Products</h1>

            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active">
                    <a href="{{ route('dashboard') }}">Dashboard</a>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="card">
        <div class="card-header">
            Create Product
        </div>

        <form id="form-products" @submit.prevent="$store.products.store()">
            @csrf

            <div class="card-body">
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" class="form-control" name="name" id="name" x-model="$store.products.product.name"
                        placeholder="Name">
                </div>

                <div class="form-group">
                    <label>Category</label>
                    <select class="form-control" name="category_id" id="category_id"
                        x-model="$store.products.product.category_id">
                        <option value="">-- Select</option>

                        @forelse ($categories as $key => $category)
                        <option value="{{ $key }}">{{ $category }}</option>
                        @empty

                        @endforelse
                    </select>
                </div>

                <div class="form-group">
                    <label>Description</label>
                    <textarea class="form-control" name="description" id="description"
                        x-model="$store.products.product.description" placeholder="Description"></textarea>
                </div>

                <div class="form-group">
                    <label>Price</label>
                    <input type="number" class="form-control" name="price" id="price"
                        x-model="$store.products.product.price" placeholder="Price">
                </div>

                <div class="form-group">
                    <label>Image</label>
                    <input type="file" class="form-control" name="image" id="image"
                        accept="image/png, image/jpeg, image/jpg" x-on:change="$store.products.imageOnChanged($event)">
                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">
                    Submit
                </button>
            </div>
        </form>
    </div>

    @push('scripts')
    <script src=" {{ asset('js/products/create.js') }}"></script>
    <script src="{{ asset('js/products/store.js') }}"></script>

    @endpush
</x-app-layout>