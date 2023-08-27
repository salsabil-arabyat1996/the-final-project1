

<div class="row">
    <div class="col-md-3">
        <div class="card">
            <div class="card-header">
                <h4>Price</h4>
            </div>
            <div class="card-body">

                <label class="d-block">
                    <input type="radio" name="priceSort" wire:model="priceInput" value="high-to-low"/> High to low
                </label>

                <label class="d-block">
                    <input type="radio" name="priceSort" wire:model="priceInput" value="low-to-high"/> Low to High
                </label>

            </div>
        </div>
    </div>

    <div class="col-md-9">
        <div class="row">
            @forelse ($products as $productItem)
                <div class="col-md-4">
                    <div class="product-card">
                        <div class="product-card-img">
                              <!-- Check if the product has images -->
                            @if ($productItem->productImages->count() > 0)
                                <a href="{{ url('/collections/'. $productItem->category->name.'/'. $productItem->name) }}">
                                    <img src="{{ asset($productItem->productImages[0]->image) }}" alt="{{ $productItem->name }}" style="height: 200px";>
                                </a>
                            @endif
                        </div>
                        <div class="product-card-body">
                            <h5 class="product-name">
                                <a href="{{ url('/collections/'. $productItem->category->name.'/'. $productItem->name) }}">
                                    {{ $productItem->name }}
                                </a>
                            </h5>
                            <div>
                                <span class="selling-price">{{ $productItem->selling_price }} JOD</span>
                                {{-- <span class="original-price">JOD{{ $productItem->original_price }}</span> --}}
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-md-12">
                    <div class="p-2">
                        <h4>No products available in {{ $category->name }}</h4>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</div>
{{-- @endsection --}}
