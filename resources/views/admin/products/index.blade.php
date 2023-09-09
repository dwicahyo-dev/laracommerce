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
            <div class="float-right">
                <a href="{{ route('admin.products.create') }}" role="button"
                    class="btn btn-icon icon-left btn-primary ">
                    <i class="fas fa-plus"></i> Create Product
                </a>
            </div>

        </div>
        <div class="card-body">
            <div class="table table-responsive table-hover table-striped ">
                {!! $dataTable->table(['style' => 'width:100%', 'cellspacing' => '0']) !!}
            </div>
        </div>
    </div>


    @push('scripts')
    {!! $dataTable->scripts() !!}

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.store('products', {
                tableName: 'products',
                moduleName: 'Products',
                _method: 'POST',
                delete(product){
                    const url = route('admin.products.destroy', { product: product });
                    
                    axiosDelete(url, this.tableName, this.moduleName, { loading: true });
                },
            })
        })
    </script>

    @endpush
</x-app-layout>