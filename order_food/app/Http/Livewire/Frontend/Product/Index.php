<?php

namespace App\Http\Livewire\Frontend\Product;

use Livewire\Component;
use App\Models\Product;

class Index extends Component
{
    public $products;
    public $category;
    public $priceInput;
    protected $queryString = [
        'priceInput' => ['except' => '', 'as' => 'price']
    ];

    public function mount($category)
    {
        $this->category = $category;
    }

    public function render()
    {
            // Query products based on the selected category and optional price filter
        $this->products = Product::where('category_id', $this->category->id)
            ->when($this->priceInput, function ($query) {
             // Apply sorting based on the price filter
               return $query->orderBy('selling_price', $this->priceInput === 'low-to-high' ? 'ASC' : 'DESC');
            })
            ->where('status', '0')
            ->get();

        return view('livewire.frontend.product.index', [
            'products' => $this->products,
            'category' => $this->category,
        ]);
    }
}
