<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use App\Http\Requests\ProductFormRequest;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;


class ProductController extends Controller
{
     public function index(){
        $products = Product::all();
        return view('admin.products.index', compact('products'));
     }



     public function create(){

        $categories= Category::all();
        return view('admin.products.create', compact('categories'));
     }

     public function store(ProductFormRequest $request){
        $validateData=$request->validated();
// Find the category based on the provided 'category_id' from validated data
         $category =Category::findOrFail( $validateData['category_id']);

         // Create a new product associated "مرتبطة" with the found category
       $product= $category->products()->create([
            'category_id'=>$validateData['category_id'],
            'name'=>$validateData['name'],
            'small_description'=>$validateData['small_description'],
            'description'=>$validateData['description'],
            'original_price'=>$validateData['original_price'],
            'selling_price'=>$validateData['selling_price'],
            'status'=>$request->status==true ? '1':'0',


        ]);

        //This condition checks if there are uploaded image files in the request.
        if ($request->hasFile('image')) {
            $uploadPath = 'uploads/products/';
            $i=1;
            // Loop through each uploaded image file
            foreach ($request->file('image') as $imageFile) {

               // Get the extension of the image file
                // getClientOriginalExtension->This method is typically used when working with uploaded files, such as images or documents, to get information about the file's extension.
                $extension = $imageFile->getClientOriginalExtension();

                // Generate a unique filename using the current timestamp and counter
                $filename = time().$i++.'.'.$extension;

                // Move the uploaded image file to the designated directory

                $imageFile->move($uploadPath, $filename);
                //the final image path and name:
               $finalImagePathName= $uploadPath.$filename;


        // Create a new ProductImage associated with the current product

           $product->productImages()->create([
            'product_id'=>$product->id,
            'image'=>$finalImagePathName,
         ]);


        }
    }

      return redirect('/admin/products')->with('message','product Added Successfully');
   }

    public function edit(int $product_id){
            // Get all categories for populating a dropdown in the form
        $categories= Category::all();
        //Get the specified product by its ID from db
        $product =Product::findOrFail($product_id);
        return view('admin.products.edit',compact('categories','product'));
    }

    public function update( ProductFormRequest $request, int $product_id )
    {
        $validateData=$request->validated();
        $product = Category::findOrFail($validateData['category_id'])
        ->products()->where('id', $product_id)->first();
        if($product)
        {
            $product->update([
                'category_id'=>$validateData['category_id'],
                'name'=>$validateData['name'],
                'small_description'=>$validateData['small_description'],
                'description'=>$validateData['description'],
                'original_price'=>$validateData['original_price'],
                'selling_price'=>$validateData['selling_price'],
                'status'=>$request->status==true ? '1':'0',


            ]);
            if ($request->hasFile('image')) {
                $uploadPath = 'uploads/products/';
                $i=1;
                foreach ($request->file('image') as $imageFile) {
                    $extension = $imageFile->getClientOriginalExtension();
                    $filename = time().$i++.'.'.$extension;
                    $imageFile->move($uploadPath, $filename);
                   $finalImagePathName= $uploadPath.$filename;



               $product->productImages()->create([
                'product_id'=>$product->id,
                'image'=>$finalImagePathName,
            ]);


        }
    }

      return redirect('/admin/products')->with('message','product updated Successfully');
   }



        else
        {
            return redirect('admin/products')->with('message', 'No such product ID found');
        }


     }

     public function destroyImage($product_image_id)
     {
         $productImage = ProductImage::findOrFail($product_image_id);

         // Delete the record from the product_images table
         // Delete the record from the 'product_images' table corresponding to the given product image ID
         DB::table('product_images')->where('id', $productImage->id)->delete();

         // Delete the physical image file if needed
         // ...

         return redirect()->back()->with('message', 'product Image Deleted ');
     }

     public function delete($product)
{
    // Find the product by ID and delete it
    $product = Product::findOrFail($product);
    $product->delete();

    // Redirect back or to a specific route
    return redirect()->back()->with('message', 'Product deleted successfully');
}


}
