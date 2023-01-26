<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Category extends Model
{
    use HasFactory;
    protected $guarded = [];
    public $timestamps = false;
    public static $rules = [
        'name' => 'required',
        'image' => 'required'
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
    public static function getProductsCount($id){
        $db=DB::table('products')->where('category_id', '=', $id)->get();
        return count($db);
     /*DB::table('categories')->leftJoin(,'categories.category_id','=','products.category_id')
    ("SELECT c.*,IFNULL(p.product_count,0) product_count FROM categories c 
    LEFT JOIN (SELECT COUNT(0) product_count,category_id FROM products) p ON c.id=p.category_id");*/
}
}
