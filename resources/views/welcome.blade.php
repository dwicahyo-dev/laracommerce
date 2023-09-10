<x-guest-layout>
    <x-slot name="title">Products</x-slot>

    <div class="row">
        @forelse ($products as $product)
        <div class="col-12 col-md-4 col-lg-4">
            <article class="article article-style-c">
                <div class="article-header">
                    <div class="article-image" data-background="{{ $product->imageUrl }}"
                        style="background-image: url('{{ $product->imageUrl }}');">
                    </div>
                </div>
                <div class="article-details">
                    <div class="article-category">
                        <span>{{ $product->category->name }}</span>
                        <div class="bullet"></div>
                        <span>{{ $product->created_at->diffForHumans() }}</span>
                    </div>
                    <div class="article-title">
                        <h2>
                            <a href="#">{{ $product->name }}</a>
                        </h2>
                    </div>
                    <p>
                        {!! $product->description !!}
                    </p>
                    <div class="article-user">
                        <div class="article-user-details">
                            <div class="text-job">{{ $product->price }}</div>
                        </div>
                    </div>
                </div>
            </article>
        </div>
        @empty

        @endforelse
    </div>

    {{ $products->links() }}

</x-guest-layout>