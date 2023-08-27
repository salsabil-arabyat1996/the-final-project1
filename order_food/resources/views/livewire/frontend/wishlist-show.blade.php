
    <div class="py-3 py-md-5 bg-light">
        <div class="container">
<h3> My Wishlist</h3>
<hr>
            <div class="row ">
                <div class="col-md-12">
                    <div class="shopping-cart">

                        <div class="cart-header d-none d-sm-none d-mb-block d-lg-block">
                            <div class="row">
                                <div class="col-md-6">
                                    <h4>Products</h4>
                                </div>
                                <div class="col-md-2">
                                    <h4>Price</h4>
                                </div>

                                <div class="col-md-4">
                                    <h4>Remove</h4>
                                </div>
                            </div>
                        </div>

                        @forelse ($wishlist as $wishlistItem)
                            @if ($wishlistItem->product)
                                <div class="cart-item">
                                    <div class="row ">
                                        <div class="col-md-6 my-auto">
                                            <a href="{{ url('collections/' . $wishlistItem->product->category->name . '/' . $wishlistItem->product->name) }}">
                                                <label class="product-name">
                                                    <div class="">
                                                        <img src="{{ $wishlistItem->product->productImages[0]->image }}"
                                                        style="width: 80px; height: 80px;"
                                                        alt="{{ $wishlistItem->product->name }}"/>


                                                            {{ $wishlistItem->product->name }}
                                                 </label>
                                            </a>
                                        </div>

                                    </div>
                                    <div class="col-md-2 my-auto">
                                        <label class="price">{{ $wishlistItem->product->selling_price }} Jd </label>
                                    </div>

                                    {{-- <div class="col-md-2 col-7 my-auto">
                                        <div class="quantity">
                                            <div class="input-group">
                                                <span class="btn btn1"><i class="fa fa-minus"></i></span>
                                                <input type="text" value="1" class="input-quantity"/>
                                                <span class="btn btn1"><i class="fa fa-plus"></i></span>

                                            </div>
                                        </div>
                                    </div> --}}


                                    <div class="col-md-4 col-12 my-auto">
                                        <div class="remove">
                                            <button type="button" wire:click="removeWishlistItem({{ $wishlistItem->id }})" class="btn btn-danger btn-sm">
                                                <span wire:loading.remove wire:target="removeWishlistItem({{ $wishlistItem->id }})">
                                                    <i class="fa fa-trash"></i> Remove
                                                </span>
                                                <span wire:loading wire:target="removeWishlistItem({{ $wishlistItem->id }})">
                                                    <i class="fa fa-trash"></i> Removeing...
                                                </span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                    </div>
                    @endif
                @empty
                <h4> No Whislist Added</h4>
                    @endforelse

                </div>
            </div>
        </div>

    </div>
</div>

