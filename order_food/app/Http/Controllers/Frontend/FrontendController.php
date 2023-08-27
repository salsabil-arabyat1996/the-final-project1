<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\About; // Import the About model or your relevant model


use function PHPUnit\Framework\returnSelf;

class FrontendController extends Controller
{
    public function index()
    {
        return view('frontend.index');
    }


//     public function  searchProducts(Request $request)
//     {
//        if($request->serarch){

//         $searchProducts =Product::where('name','LIKE','%'.$request->search.'%')->latest()->paginates(15);
//         return view('frontend.page.search', compact('searchProducts'));
//     }else{

// return redirect()->back()->with('message','Empty search');
//        }
//     }

public function about()
{


    return view('frontend.about');
}

public function gallery()
{


    return view('frontend.Gallery');
}


public function note(){
    return view('frontend.blog');
}



    public function categories()
    {
    // Retrieve categories from the database
        $categories =Category::all();

        return view('frontend.collections.category.index', compact('categories'));
    }


    public function products($category_name)
    {
          // Find the category by its name
        $category = Category::where('name', $category_name)->first();
   // Check if the category exists
        if ($category) {

            // Retrieve the products associated with the category
            $products = $category->products()->get();
            return view('frontend.collections.products.index', compact('products', 'category'));
        } else {
            return redirect()->back();
        }
    }

    public function productsview(string $category_name, string $product_name)
    {
          // Find the category based on the given category name
        $category = Category::where('name', $category_name)->first();

        if ($category) {

            // Find the product within the specified category by name and where status is '0'

            $product = $category->products()->where('name',$product_name)->where('status','0')->first();
            if($product)
            {
// If the product is found, pass it to the view along with the category
    return view('frontend.collections.products.view', compact('product', 'category'));

      } else {
    // If the product is not found, redirect back
    return redirect()->back();
       }
       } else {
        // If the category is not found, redirect back
            return redirect()->back();
        }
    }
    public function thankyou()
    {
        return view ('frontend.thank-you');
    }


}
