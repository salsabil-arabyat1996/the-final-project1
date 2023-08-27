<?php

namespace App\Models;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

// conniton with table categories in db
    protected $table='categories';

    // Specifying the columns that can be mass assigned
    protected $fillable=[
        'name',
        'description',
        'image',




    ];
  // Defining a one-to-many relationship with the Product model
    public function products(){
        return $this->hasMany(Product::class,'category_id','id');
    }

}
