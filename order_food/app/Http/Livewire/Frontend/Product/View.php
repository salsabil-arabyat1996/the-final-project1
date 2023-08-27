<?php

namespace App\Http\Livewire\Frontend\Product;

use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\Product;
use App\Models\Wishlist;

class View extends Component
{
    public $category;
    public $product;
    public $quantityCount;



    public function addToWishList($productId)
    {
        if (Auth::check()) {

            if (Wishlist::where('user_id', auth::user()->id)->where('product_id', $productId)->exists()) {
                session()->flash('message', 'Already added to Wishlist');
                return false;
            } else {
                Wishlist::create([
                    "user_id" => auth::user()->id,
                    "product_id" => $productId
                ]);
                session()->flash('message', 'Wishlist  added successfully');
            }
        } else {
            session()->flash('alert', 'please loging to continue');
            return false;
        }
    }

    public function mount($category, $product)
    {
        $this->category = $category;
        $this->product = $product;
          // Set the initial quantity count to 1.
        $this->quantityCount = 1;
    }

    public function incrementQuantity()
    {
    // Check if the product's available quantity is greater than 0
        if($this->product->quantity > 0){
            $this->quantityCount++;
        }

    }

    public function decrementQuantity()
    {
        $this->quantityCount = max(1, $this->quantityCount - 1);
    }




    public function addToCart(int $productId)
    {
        if (Auth::check()) {
             // Check if the product exists and is active
            if ($this->product->where('id', $productId)->where('status', '0')->exists()) {

                // Check if the product is already in the user's cart
                if (Cart::where('user_id', auth()->user()->id)->where('product_id', $productId)->exists()) {
                    session()->flash('message', 'Product Already Added');
                    return false;

                } else {
                 // Check if the product quantity is greater than 0
                    if ($this->product->quantity > 0) {
                     // Check if the desired quantity is available
                      if ($this->product->quantity > $this->quantityCount) {
                          // Create a new cart entry for the user

                            Cart::create([
                                'user_id' => auth()->user()->id,
                                'product_id' => $productId,
                                'quantity' => $this->quantityCount
                            ]);
                                // Emit "تحديث السلة" an event to update the cart
                            $this->emit('CartAddedUpdated');
                            session()->flash('message', '
                            Product Added to Cart');
                            return false;
                            ;
                        } else {
                             // Show a warning message if the desired quantity is not available

                            $this->dispatchBrowserEvent('message', [
                                'text' => 'Only ' . $this->product->quantity . ' Quantity Available',
                                'type' => 'warning',
                                'status' => 404
                            ]);
                        }
                    }
                }
            } else {
                $this->dispatchBrowserEvent('message', [
                    'text' => 'Product does not exist.',
                    'type' => 'warning',
                    'status' => 404
                ]);
            }
        } else {
            $this->dispatchBrowserEvent('alert', [
                session()->flash('alert', 'please loging to continue'),
                'type' => 'info',
                'status' => 401
            ]);
        }
    }

    public function render()
    {
        return view('livewire.frontend.product.view', [
            'category' => $this->category,
            'product' => $this->product,
        ]);
    }
}
