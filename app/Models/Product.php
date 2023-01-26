<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    public static $rules = [
        'name' => 'required',
        'size_id' => 'required',
        'color_id' => 'required',
        'category_id' => 'required'
    ];
    protected $guarded = ['rating', 'rating_count'];
    public function getPrice()
    {
        return $this->price - $this->price * $this->discount;
    }
    public static function getCart()
    {
        $products = [];
        $ids = session()->get('ids', []);
        $ids = array_count_values($ids);
        foreach($ids as $id=>$quantity){
            $product= Product::findOrFail($id);
            $product['quantity'] = $quantity;
            array_push($products, $product);
        }
        return $products;
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
