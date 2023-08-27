<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\CategoryFormRequest;
 use Illuminate\Support\Facades\File;


class CategoryController extends Controller
{
    public function index()
    {
        return view('admin.category.index');
    }

    public function create()
    {
        return view('admin.category.create');
    }

    public function store(CategoryFormRequest $request)
    {
        // Validate the data based on the rules defined in CategoryFormRequest
        $validatedData = $request->validated();

        // Create a new Category instance
        $category = new Category;

        // Assign values from validated data to Category model attributes
        $category->name = $validatedData['name'];
        $category->description = $validatedData['description'];

        // Define the upload path for category images
        $uploadPath = 'uploads/category/';

        // Check if an image was uploaded
        if ($request->hasFile('image')) {
            $file = $request->file('image');

            // Get the file extension
            $ext = $file->getClientOriginalExtension();

            // Generate a unique filename using the current timestamp
            $filename = time() . '.' . $ext;

            // Move the uploaded file to the designated directory
            $file->move('uploads/category/', $filename);

            // Save the image path to the category model
            $category->image = $uploadPath . $filename;
        }

        // Save the category model to the database
        $category->save();

        // Redirect to a specific route with a success message
        return redirect('admin/category')->with('message', 'Category added successfully');
    }

    public function edit(Category $category)
    {
        return view('admin.category.edit', compact('category'));
    }

    public function update(CategoryFormRequest $request, $category)
    {
        // Validate the data based on the rules defined in CategoryFormRequest
        $validatedData = $request->validated();

        // Find the category by its ID, using the "findOrFail" method
        $category = Category::findOrFail($category);

        // Assign values from validated data to Category model attributes
        $category->name = $validatedData['name'];
        $category->description = $validatedData['description'];

        // Check if an image was uploaded
        if ($request->hasFile('image')) {
            // Define the upload path for category images
            $uploadPath = 'uploads/category/';

            // Get the current image path
            $path = 'uploads/category/' . $category->image;

            // Check if the current image exists and delete it
            if (File::exists($path)) {
                File::delete($path);
            }

            // Upload the new image
            $file = $request->file('image');
            $ext = $file->getClientOriginalExtension();
            $filename = time() . '.' . $ext;
            $file->move('uploads/category/', $filename);
            $category->image = $uploadPath . $filename;
        }

        // Update the category model in the database
        $category->update();

        // Redirect to a specific route with a success message
        return redirect('admin/category')->with('message', 'Category updated successfully');
    }


}
